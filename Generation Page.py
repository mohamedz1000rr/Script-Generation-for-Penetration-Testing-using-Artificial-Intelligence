import tkinter as tk
from tkinter import messagebox
from transformers import GPT2LMHeadModel, GPT2Tokenizer

# Initialize GPT-2 model and tokenizer
model = GPT2LMHeadModel.from_pretrained("E:/Grad/gpt2-finetuned-final")
tokenizer = GPT2Tokenizer.from_pretrained("E:/Grad/gpt2-finetuned-final")
model.eval()

def generate_text():
    prompt = prompt_entry.get()
    if not prompt:
        messagebox.showwarning("Warning", "Please enter a prompt.")
        return

    # Show loading message
    result_text.delete(1.0, tk.END)
    result_text.insert(tk.END, "Generating... Please wait.")

    try:
        input_ids = tokenizer.encode(prompt, return_tensors="pt")

        # Generate text
        output = model.generate(input_ids, max_length=1000, num_beams=5, no_repeat_ngram_size=2, top_k=50, top_p=0.95, temperature=0.7)

        # Decode and display the generated text
        generated_text = tokenizer.decode(output[0], skip_special_tokens=True)
        result_text.delete(1.0, tk.END)
        result_text.insert(tk.END, generated_text)
    except Exception as e:
        messagebox.showerror("Error", f"An error occurred: {str(e)}")

# Create main window
root = tk.Tk()
root.title("GPT-2 Text Generation")
root.geometry("600x400")

# Create top bar
top_bar = tk.Frame(root, bg="light blue", height=50)
top_bar.pack(fill=tk.X)

# Create prompt label and entry
prompt_label = tk.Label(root, text="Prompt:")
prompt_label.pack(pady=(20, 5))
prompt_entry = tk.Entry(root, width=50)
prompt_entry.pack(pady=5)

# Create generate button
generate_button = tk.Button(root, text="Generate", command=generate_text)
generate_button.pack(pady=10)

# Create text area
result_text = tk.Text(root, height=15, width=70)
result_text.pack(expand=True, fill=tk.BOTH, padx=10, pady=10)

root.mainloop()
