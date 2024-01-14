import torch
from transformers import GPT2Tokenizer, GPT2LMHeadModel, GPT2Config
from transformers import TextDataset, DataCollatorForLanguageModeling
from transformers import Trainer, TrainingArguments

# Path to your text file
data_file_path = "E:/code-gen-main/python_code_text_data.txt"

# Load the GPT-2 tokenizer
tokenizer = GPT2Tokenizer.from_pretrained("gpt2")

# Tokenize and encode the data
with open(data_file_path, "r", encoding="utf-8") as file:
    data = file.read()

# Tokenize the data
tokenized_data = tokenizer.encode(data, return_tensors="pt")

# Save the tokenized data
torch.save(tokenized_data, "tokenized_data.pt")

# Load GPT-2 model and configuration
model_config = GPT2Config.from_pretrained("gpt2")
model = GPT2LMHeadModel(config=model_config)

# Create a dataset and data collator
dataset = TextDataset(tokenized_data, tokenizer=tokenizer)
data_collator = DataCollatorForLanguageModeling(tokenizer=tokenizer, mlm=False)

# Training arguments
training_args = TrainingArguments(
    output_dir="./gpt2-finetuned",
    overwrite_output_dir=True,
    num_train_epochs=1,
    per_device_train_batch_size=1,
    save_steps=10_000,
    save_total_limit=2,
)

# Create Trainer
trainer = Trainer(
    model=model,
    args=training_args,
    data_collator=data_collator,
    train_dataset=dataset,
)

# Train the model
trainer.train()

# Save the trained model
model.save_pretrained("./gpt2-finetuned")
tokenizer.save_pretrained("./gpt2-finetuned")
