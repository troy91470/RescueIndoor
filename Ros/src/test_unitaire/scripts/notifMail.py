# Marwane Bahraoui & Thomas Roy

import smtplib
from email.message import EmailMessage
from email.headerregistry import Address
from email.utils import make_msgid

'''
subject : objet du mail
receiver : adresse de destination du mail
plain_text : message sans formatage html
html_text : message avec formatage html
'''
def send_email(subject, receiver, plain_text, html_text):
    msg = EmailMessage() % subject
    msg['Message-ID'] = make_msgid()
    msg['Subject'] = subject
    msg['From'] = Address("delivery robot", "robot", 'gmail.com')
    msg['To'] = Address("", receiver.split('@')[0], receiver.split('@')[1])
    msg.set_content(plain_text)
    msg.add_alternative(html_text, subtype='html')
    server = smtplib.SMTP_SSL('smtp.gmail.com', 465)
    server.ehlo()
    server.login("rescue.indoor.noreply@gmail.com", "cwlsvvcgxsalrvik")
    server.send_message(msg)
    server.quit()

# mail de destination
mailDestinataire="thomas.roy91470@gmail.com"
# bureau de la personne destinataire
bureau="415"
# message avec un formatage html
msgHtml="Vous venez de recevoir une nouvelle livraison devant votre bureau : "+bureau+".<br/>Veuillez venir le chercher dans moins de 5 minutes si vous le pouvez.\
    <br/>Dans le cas contraire, vous pouvez venir le chercher plus tard au bureau de l'administrateur selon ses horaires.\
    <br/><br/>--<br/>Cordialement,<br/>l'administration"
# message sans format html
msgTxt="Vous venez de recevoir une nouvelle livraison devant votre bureau : "+bureau+".<br/>Veuillez venir le chercher dans moins de 5 minutes si vous le pouvez.\
    \nDans le cas contraire, vous pouvez venir le chercher plus tard au bureau de l'administrateur selon ses horaires.\
    \n\n--\nCordialement,\nl'administration"

send_email("[DELIVERY] Livraison au bureau "+bureau,mailDestinataire, msgTxt, msgHtml)