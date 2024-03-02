import tkinter as tk
from tkinter import messagebox
import psycopg2
import subprocess

def authenticate_user():
    email = email_entry.get()
    password = password_entry.get()

    # Database connection and authentication
    try:
        connection = psycopg2.connect(
            user="postgres",
            password="sys",
            host="localhost",
            port="8080",
            database="grad"
        )
        cursor = connection.cursor()
        query = f"SELECT * FROM public.users WHERE email = '{email}' AND password = '{password}';"
        cursor.execute(query)
        user = cursor.fetchone()
        if user:
            messagebox.showinfo("Login Successful", "Welcome!")
            # Run the generate script
            subprocess.Popen(["python", "E:/Grad/final.py"])
            root.destroy()  # Close the login window after successful login
        else:
            messagebox.showerror("Login Failed", "Invalid email or password.")
    except (Exception, psycopg2.Error) as error:
        messagebox.showerror("Error", f"Database error: {error}")
    finally:
        if connection:
            cursor.close()
            connection.close()

# Create main window
root = tk.Tk()
root.title("Login Page")
root.attributes("-fullscreen", True)  # Run in full screen mode

# Create top bar
top_bar = tk.Frame(root, bg="light blue", height=50)
top_bar.pack(fill=tk.X)

# Create email label and entry
email_label = tk.Label(root, text="Email:")
email_label.pack(pady=(20, 5))
email_entry = tk.Entry(root, width=30)
email_entry.pack(pady=5)

# Create password label and entry
password_label = tk.Label(root, text="Password:")
password_label.pack()
password_entry = tk.Entry(root, width=30, show="*")
password_entry.pack(pady=5)

# Create login button
login_button = tk.Button(root, text="Login", command=authenticate_user)
login_button.pack(pady=10)

root.mainloop()
