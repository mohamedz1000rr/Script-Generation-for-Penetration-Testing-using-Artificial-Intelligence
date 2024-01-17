from transformers import GPT2LMHeadModel, GPT2Tokenizer, GPT2Config
from transformers import TextDataset, DataCollatorForLanguageModeling
from transformers import Trainer, TrainingArguments

# Load pre-trained GPT-2 model and tokenizer
model_name = "gpt2-medium"  # or "gpt2-medium", "gpt2-large", "gpt2-xl" for larger models
tokenizer = GPT2Tokenizer.from_pretrained(model_name)
model = GPT2LMHeadModel.from_pretrained(model_name)

# Load your dataset
dataset = TextDataset(
    tokenizer=tokenizer,
    file_path="E:/Grad/python_code_text_data.txt",
    block_size=128  # Adjust according to your dataset and resources
)

# Prepare data collator
data_collator = DataCollatorForLanguageModeling(
    tokenizer=tokenizer,
    mlm=False  # For language modeling tasks, set mlm to True
)

# Configure training arguments
training_args = TrainingArguments(
    output_dir="E:/Grad/gpt2-finetuned",
    overwrite_output_dir=True,
    num_train_epochs=1,  # Adjust as needed
    per_device_train_batch_size=4,
    save_steps=10_000,  # Save model every specified number of steps
    save_total_limit=2,
)

# Create Trainer and fine-tune the model
trainer = Trainer(
    model=model,
    args=training_args,
    data_collator=data_collator,
    train_dataset=dataset,
)

trainer.train()
model.save_pretrained("E:/Grad/gpt2-finetuned-final")
tokenizer.save_pretrained("E:/Grad/gpt2-finetuned-final")