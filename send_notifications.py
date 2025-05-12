import sys
import json
from twilio.rest import Client
import smtplib
from email.mime.text import MIMEText

# Twilio Credentials
TWILIO_SID = "your_twilio_sid"
TWILIO_AUTH_TOKEN = "your_twilio_auth_token"
TWILIO_PHONE = "+your_twilio_number"

# Email SMTP Setup
SMTP_SERVER = "smtp.yourmail.com"
SMTP_PORT = 587
SMTP_USER = "your_email@example.com"
SMTP_PASS = "your_email_password"

def send_sms(phone, message):
    client = Client(TWILIO_SID, TWILIO_AUTH_TOKEN)
    client.messages.create(to=phone, from_=TWILIO_PHONE, body=message)

def send_email(email, subject, message):
    msg = MIMEText(message)
    msg["Subject"] = subject
    msg["From"] = SMTP_USER
    msg["To"] = email

    with smtplib.SMTP(SMTP_SERVER, SMTP_PORT) as server:
        server.starttls()
        server.login(SMTP_USER, SMTP_PASS)
        server.sendmail(SMTP_USER, email, msg.as_string())

if __name__ == "__main__":
    title = sys.argv[1]
    message = sys.argv[2]
    tenants = json.loads(sys.argv[3])

    for tenant in tenants:
        send_sms(tenant["phone"], f"{title}: {message}")
        send_email(tenant["email"], title, message)

    print("Notifications Sent Successfully")
