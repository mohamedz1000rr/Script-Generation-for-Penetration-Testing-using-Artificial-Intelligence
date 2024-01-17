from transformers import GPT2LMHeadModel, GPT2Tokenizer

# GPT-2 model and tokenizer
model = GPT2LMHeadModel.from_pretrained("E:/Grad/gpt2-finetuned-final")
tokenizer = GPT2Tokenizer.from_pretrained("E:/Grad/gpt2-finetuned-final")

model.eval()

# generate text using prompt
def generate_text(prompt, max_length=1000):
    input_ids = tokenizer.encode(prompt, return_tensors="pt")

    # Generate text
    output = model.generate(input_ids, max_length=max_length, num_beams=5, no_repeat_ngram_size=2, top_k=50, top_p=0.95, temperature=0.7)

    # Decode and print the generated text
    generated_text = tokenizer.decode(output[0], skip_special_tokens=True)
    print("Generated Text:", generated_text)

generate_text("python payload")
