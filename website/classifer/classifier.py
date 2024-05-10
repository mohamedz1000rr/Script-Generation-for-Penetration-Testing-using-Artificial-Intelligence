import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.linear_model import LogisticRegression
from sklearn.pipeline import Pipeline
from sklearn.metrics import classification_report

# Load the dataset to view its columns
file_path = 'Merged_SQL_XSS_Dataset.csv'
merged_data= pd.read_csv(file_path)


# Splitting the data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(
    merged_data['Script'], merged_data['Label'], test_size=0.2, random_state=42)

# Creating a pipeline with TF-IDF Vectorizer and Logistic Regression
pipeline = Pipeline([
    ('tfidf', TfidfVectorizer()),
    ('classifier', LogisticRegression(random_state=42,max_iter=500))
])

# Training the model
pipeline.fit(X_train, y_train)

# Evaluating the model
predictions = pipeline.predict(X_test)
report = classification_report(y_test, predictions)
# Retraining the model with the updated pipeline

# Save the trained model
import joblib
model_file_path = 'Trained_Text_Classification_Model.pkl'
joblib.dump(pipeline, model_file_path)

model_file_path
