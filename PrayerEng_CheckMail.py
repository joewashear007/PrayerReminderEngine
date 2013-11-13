#!/usr/bin/python
import imaplib
import getpass
import datetime
import email
import email.header
import pprint
import quopri
import re
import HTMLParser

#user name and password for the prayer email
username="prayer+joesboxoftricks.com"
password="prayer4ME"
out_file = open("/home2/jjprogra/public_html/pray/test.txt", "w")

#function to parse out the email body
def GetEmailBody(email_message_instance):
    maintype = email_message_instance.get_content_maintype()
    if maintype == 'multipart':
        for part in email_message_instance.get_payload():
            if part.get_content_maintype() == 'text':
                return part.get_payload()
    elif maintype == 'text':
        return email_message_instance.get_payload()
        
def handel_email(num, msg):
    print("Some code here to get the user id")
    
    
    
def read_email():
    #list of commands to run when finished
    commands = []
    #connect
    print "Starting COnnection"
    mail = imaplib.IMAP4_SSL("host155.hostmonster.com", 993)  
    mail.login(username, password)
    mail.select("inbox") 
    print "Starting Fetch"
    #return "OK" and list of emails id
    status, data = mail.uid('search', None, "UNSEEN")
    if status == "OK":
        results = data[0].split()
        if len(results) > 0:
            print "IMAP Server returned " + str(len(results)) + " results"
            out_file.write(" - IMAP Server returned " + str(len(results)) + " results")
            #Loop through each id and get the email
            for uid in data[0].split():
                status, data = mail.uid('fetch', uid, '(RFC822)')
                if status == "OK":
                    #process the email 
                    raw_email = data[0][1]
                    email_message = email.message_from_string(raw_email)
                    addr = email.utils.parseaddr(email_message['From'])[1]
                    msg = GetEmailBody(email_message)
                    #get the number and msg to make command 
                    number = addr[0:addr.find("@")]
                    commands.append( number + "|" + msg.strip() )
                    out_file.write( number + "|" + msg.strip() )
            return commands
        else:
            out_file.write(" - Nothing fetched")
            print "Nothing to fetch!"
            return -1

if __name__ == "__main__":
    print "Stating Program"

    out_file.write(" - Starting Email Read")

    commands = read_email()
    if commands != -1:
        print "do stuff"
        print commands
    out_file.close()
