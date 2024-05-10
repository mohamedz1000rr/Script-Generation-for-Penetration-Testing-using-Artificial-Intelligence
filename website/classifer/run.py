import joblib

# Load the model
model = joblib.load('Trained_Text_Classification_Model.pkl')

# Function to classify a script
def classify_script(script):
    prediction = model.predict([script])
    return prediction[0]

# Example usage
script_input = input("Enter a script to classify: ")
output = classify_script(script_input)
print(f"The script is classified as: {output}")
