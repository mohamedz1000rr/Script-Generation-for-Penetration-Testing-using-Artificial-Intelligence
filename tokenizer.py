from tokenizers import ByteLevelBPETokenizer
import os

def tokenizer_main() -> tuple:

    # Set CUDA device order and visible devices
    os.environ["CUDA_DEVICE_ORDER"] = "PCI_BUS_ID"
    os.environ["CUDA_VISIBLE_DEVICES"] = "0, 1, 3, 4, 5"
  
    # Create a directory for tokenizer files if it doesn't exist
    if not os.path.exists("tokenizer"):
        os.mkdir("tokenizer")
  
    TRAINABLE = True
  
    # Path to the file/files
    paths = "E:\\Grad\\payloads_code_text_data.txt"  # Corrected paths assignment
  
    # Tokenizer
    if TRAINABLE:
        tokenizer = ByteLevelBPETokenizer()
    
        tokenizer.train(files=paths, vocab_size=52_000, min_frequency=2, special_tokens=[
            "<s>",
            "<pad>", 
            "</s>",
            "<unk>", 
            "<mask>",
        ])

        # Save files to disk
        tokenizer.save_model("tokenizerr")
        return tokenizer, paths
