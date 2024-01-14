import gpt_2_simple as gpt2

# Download GPT-2 model
model_name = "124M"
gpt2.download_gpt2(model_name=model_name)

# Set file paths
text_file_path = "E:/code-gen-main/python_code_text_data.txt"
checkpoint_dir = "checkpoint"
model_save_path = "fine_tuned_model/model"

# Tokenize and encode the data
sess = gpt2.start_tf_sess()
gpt2.encode_dataset(
    sess,
    text_file_path,
    model_name=model_name,
    out_path="encoded.npz"
)

# Finetune the GPT-2 model
gpt2.finetune(
    sess,
    dataset="encoded.npz",
    model_name=model_name,
    steps=1000,
    restore_from='fresh',
    run_name='run1',
    checkpoint_dir=checkpoint_dir
)

# Save the fine-tuned model
gpt2.save_gpt2(sess, model_save_path)

# Generate text using the fine-tuned model
generated_text = gpt2.generate(sess, run_name='run1', return_as_list=True)[0]

# Print or save the generated text as needed
print(generated_text)

# Close the TensorFlow session
gpt2.reset_session(sess)
