import pandas as pd

# Load both datasets
sql_data_path = '/mnt/data/Modified_SQL_Dataset.csv'
xss_data_path = '/mnt/data/XSS_dataset.csv'
sql_data = pd.read_csv(sql_data_path)
xss_data = pd.read_csv(xss_data_path)

# Transform labels in SQL dataset
sql_data['Label'] = sql_data['Label'].map({0: 'Invalid Script', 1: 'SQL Injection'})
xss_data.drop(columns=['Unnamed: 0'], inplace=True)

# Transform labels in XSS dataset
xss_data['Label'] = xss_data['Label'].map({0: 'Invalid Script', 1: 'XSS'})

# Rename the script columns to 'Script'
sql_data.rename(columns={'Query': 'Script'}, inplace=True)
xss_data.rename(columns={'Sentence': 'Script'}, inplace=True)

# Merge the datasets
merged_data = pd.concat([sql_data, xss_data], ignore_index=True)

# Save the merged dataset to a new CSV file
merged_data.to_csv('Merged_Dataset.csv', index=False)
