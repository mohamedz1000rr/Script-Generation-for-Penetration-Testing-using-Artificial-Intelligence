import pandas as pd
from transformers import GPT2LMHeadModel, GPT2Tokenizer
from transformers import TrainingArguments, Trainer
from datasets import Dataset

def prepare_data(filepath):
    data = pd.read_csv(filepath)
    def label_to_prompt(label):
        if label == 'SQL Injection':
            return 'Generate an SQL injection script.'
        elif label == 'XSS':
            return 'Generate an XSS script.'
        elif label == 'Invalid Script':
            return 'Generate a non-executable script.'
    data['prompt'] = data['Label'].apply(label_to_prompt)
    data['input'] = data['prompt'] + " <|endoftext|> " + data['Script']
    return data[['input', 'Script']]

def tokenize_function(examples, tokenizer):
    # Set padding token if not already defined
    if tokenizer.pad_token is None:
        tokenizer.pad_token = tokenizer.eos_token
    return tokenizer(examples['input'], padding="max_length", truncation=True)

def main():
    # Load and prepare data
    data_path = 'E:/Grad/data/Merged_SQL_XSS_Dataset.csv'
    data = prepare_data(data_path)
    dataset = Dataset.from_pandas(data)
    dataset = dataset.train_test_split(test_size=0.1)  # Splitting the data

    # Load tokenizer and model
    tokenizer = GPT2Tokenizer.from_pretrained('gpt2-medium')
    model = GPT2LMHeadModel.from_pretrained('gpt2-medium')

    # Tokenization
    tokenized_datasets = dataset.map(lambda examples: tokenize_function(examples, tokenizer), batched=True)

    # Training arguments
    training_args = TrainingArguments(
        output_dir='E:/Grad/data/results',          # output directory
        num_train_epochs=3,              # number of training epochs
        per_device_train_batch_size=4,   # batch size for training
        per_device_eval_batch_size=8,    # batch size for evaluation
        warmup_steps=500,                # number of warmup steps for learning rate scheduler
        weight_decay=0.01,               # strength of weight decay
        logging_dir='E:/Grad/data/logs',            # directory for storing logs
        logging_steps=10,
        do_train=True,
        do_eval=True,
        evaluation_strategy="epoch",
        save_strategy="epoch"
    )

    # Initialize Trainer
    trainer = Trainer(
        model=model,
        args=training_args,
        train_dataset=tokenized_datasets['train'],
        eval_dataset=tokenized_datasets['test'],
        tokenizer=tokenizer
    )

    # Train the model
    trainer.train()

    # Save the model
    model.save_pretrained('E:/Grad/data')

if __name__ == '__main__':
    main()

        