#!/usr/bin/python

# Import smtplib for the actual sending function
import smtplib
import email
# Import the email modules we'll need
from email.mime.text import MIMEText


class EmailEng:

	def __init__(self):
		user = ""
		pw = ""
		
	def sendTextMsg(self, msg):
		# Create a text/plain message
		msg = email.mime.text.MIMEText(msg)
		msg['Subject'] = "The test email"
		msg['From'] = "joesboxoftricks.com"
		msg['To'] = "5672772237@vtext.com"

		# Send the message via our own SMTP server.
		s = smtplib.SMTP('localhost')
		s.send_message(msg)
		s.quit()
		
def main():
	e = EmailEng()
	e.sendTextMsg("Hello World")
	
if __name__ == '__main__':
    main()
