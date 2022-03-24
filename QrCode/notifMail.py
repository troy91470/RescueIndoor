import smtplib
from email.message import EmailMessage
from email.headerregistry import Address
from email.utils import make_msgid

def send_email(subject, receiver, plain_text, html_text):
    msg = EmailMessage()
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

mailDestinataire="thomas.roy91470@gmail.com"
bureau="415"
msgHtml="Vous venez de recevoir une nouvelle livraison devant votre bureau : "+bureau+".<br/>Veuillez venir le chercher dans moins de 5 minutes si vous le pouvez.\
    <br/>Vous pouvez venir le chercher plus tard au bureau de l'administrateur selon ses horaires.\
    <br/><br/>--<br/>Cordialement,<br/>entreprise XXX"

send_email("[DELIVERY] Livraison au bureau "+bureau,mailDestinataire,"livraison effectuee",msgHtml)
'''
server=smtplib.SMTP('smtp.gmail.com',587)
server.starttls()
addresseMail2="wawane951@gmail.com"
addresseMail="rescue.indoor.noreply@gmail.com"
msg="ca va ou quoi chakal ?"
msg['Message-ID'] = make_msgid()
#addresseMail2=addresseMail
mdp="cwlsvvcgxsalrvik"

server.login(addresseMail,mdp)
server.sendmail(addresseMail,addresseMail2,msg)
server.quit()
'''