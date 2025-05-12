import smtplib
from email.message import EmailMessage

def email_alert(subject, body, to):
    msg = EmailMessage()
    msg.set_content(body)
    msg['Subject'] = subject
    msg['To'] = to

    user = "nathaniellasquety2024@gmail.com"
    msg['From'] = user
    password = "burjtnjsdarrwsdh"  # Store securely in an environment variable instead

    server = smtplib.SMTP("smtp.gmail.com", 587)
    server.starttls()
    server.login(user, password)
    server.send_message(msg)  # Corrected indentation
    server.quit()  # Corrected indentation

if __name__ == "__main__":  
    email_alert("Hello", "How are you?", "raikouhattori@gmail.com")  # Fixed indentation
