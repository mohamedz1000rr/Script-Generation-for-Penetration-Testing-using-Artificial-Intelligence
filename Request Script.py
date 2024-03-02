import tkinter as tk
from tkinter import ttk
import psycopg2
from PIL import Image, ImageTk

def execute_query():
    selected_option = select_var.get()
    query = f"SELECT script FROM public.scripts WHERE name = '{selected_option}';"
    try:
        connection = psycopg2.connect(
            user="postgres",
            password="sys",
            host="localhost",
            port="8080",
            database="grad"
        )
        cursor = connection.cursor()
        cursor.execute(query)
        rows = cursor.fetchall()
        result_text.delete(1.0, tk.END)  # Clear previous text
        for row in rows:
            result_text.insert(tk.END, f"{row}\n")
    except (Exception, psycopg2.Error) as error:
        result_text.delete(1.0, tk.END)  # Clear previous text
        result_text.insert(tk.END, f"Error: {error}")
    finally:
        if connection:
            cursor.close()
            connection.close()

# Create main window
root = tk.Tk()
root.title("SQL Query Executor")
root.attributes("-fullscreen", True)  # Run in full screen mode

# Create top bar
top_bar = tk.Frame(root, bg="light blue", height=50)
top_bar.pack(fill=tk.X)

# User icon
user_icon_img = Image.open(r"E:\Grad\user.png")  # Replace with your user icon path
user_icon_img = user_icon_img.resize((30, 30), Image.BILINEAR)  # Use BILINEAR resampling
user_icon_photo = ImageTk.PhotoImage(user_icon_img)
user_icon_label = tk.Label(top_bar, image=user_icon_photo, bg="light blue")
user_icon_label.image = user_icon_photo
user_icon_label.pack(side=tk.RIGHT, padx=(0, 10))

# Menu icon
menu_icon_img = Image.open(r"E:\Grad\menu.png")  # Replace with your menu icon path
menu_icon_img = menu_icon_img.resize((30, 30), Image.BILINEAR)  # Use BILINEAR resampling
menu_icon_photo = ImageTk.PhotoImage(menu_icon_img)
menu_icon_label = tk.Label(top_bar, image=menu_icon_photo, bg="light blue")
menu_icon_label.image = menu_icon_photo
menu_icon_label.pack(side=tk.RIGHT, padx=(0, 10))

# Create text area
result_text = tk.Text(root, height=10, width=50)
result_text.pack(expand=True, fill=tk.BOTH, padx=10, pady=(0, 10))  # Make text area resizable

# Create select list
options = ["SQL Injection"]
select_var = tk.StringVar(value=options[0])
select_list = ttk.Combobox(root, textvariable=select_var, values=options)
select_list.pack()

# Create button
generate_button = tk.Button(root, text="Generate", command=execute_query)
generate_button.pack(pady=10)

root.mainloop()
