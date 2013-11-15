#!/usr/bin/python

# Import smtplib for the actual sending function
import smtplib
import imaplib
import email
import platform
# Import the email modules we'll need
from email.mime.text import MIMEText


class EmailEng:

	def __init__(self):
		self.username=""
		self.password=""
		self.host = "host155.hostmonster.com"
		self.host_port = 993
		self.main = None
	
	def _Connect_To_Inbox(self):
		#returns creates self.mail object
		self.mail = imaplib.IMAP4_SSL(self.host, self.host_port)  
		self.mail.login(self.username, self.password)
		self.mail.select("INBOX")
		
	def _Get_Email_Body(self, email_msg):
		maintype = email_msg.get_content_maintype()
		if maintype == 'multipart':
			for part in email_msg.get_payload():
				if part.get_content_maintype() == 'text':
					return part.get_payload()
		elif maintype == 'text':
			return email_msg.get_payload()
		
	def _Get_Email_From_UID(self, uid):
		#return email instance object
		status, data = self.mail.uid("FETCH", uid, "(RFC822)")
		if status == "OK":
			raw_email = data[0][1]
			message = email.message_from_bytes(raw_email)
			return message
			
	def Get_Unread_Emails(self):
		self._Connect_To_Inbox()
		status, uids = self.mail.uid("SEARCH", None, "UNSEEN")
		if status == "OK":
			number_emails = len(uids[0].split())
			if number_emails > 0:
				for uid in uids[0].split():
					email_msg = self._Get_Email_From_UID(uid)
					body = self._Get_Email_Body(email_msg)
					sender = email.utils.parseaddr(email_msg['From'])[1]
					print ("Email from ", sender, ":", body)
			else:
				print ("No Emails to Fetch")
		else:
			print("Email Search Failed")
			
	def SendEmail(self, to, subject, msg):
		# smtplib module send mail
		server = smtplib.SMTP(self.host, 587)
		server.ehlo()
		server.starttls()
		server.login(self.username, self.password)
		BODY = '\r\n'.join(['To: %s' % to,
							'From: %s' % self.username,
							'Subject: %s' % subject,'', msg])
		try:
			server.sendmail(gmail_sender, [TO], BODY)
			print ('email sent')
		except:
			print ('error sending mail')

		server.quit()


		
def main():
	print("Platform: " , platform.python_version())
	e = EmailEng()
	e.Get_Unread_Emails()
	
	to = '5672772237@vtext.com'
	subject = 'TEST MAIL'
	text = 'Here is a message from python.'
#e.SendEmail(to, subject, text)
	
if __name__ == '__main__':
    main()
