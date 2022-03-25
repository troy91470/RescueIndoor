# Lucas Deshayes & Reda Guendouz

import cv2
import rospy
from std_msgs.msg import String

'''
noeud ros abonné au topic listeTopic.

la variable memo permet de faire en sorte que la camera s'arrete une fois le qr code lu
et ne doit pas tout le temps publier sur le topic
'''
def listeBureauxPublisher():
    memo = ""
    # 0 => camera par defaut (dans notre cas, nous avons une seule camera, ainsi la valeur par défaut fonctionne bien)
    cap = cv2.VideoCapture(0)
    # QR code detection objet
    detector = cv2.QRCodeDetector()
    # abonnement au topic listeTopic
    pub = rospy.Publisher('listeTopic', String, queue_size=10)
    # creation du noeud listeBureauxReader
    rospy.init_node('listeBureauxReader', anonymous=True)
    # initialisation de l'attente entre chaque iteration de 1seconde
    rate = rospy.Rate(1) # 1hz
    while not rospy.is_shutdown():
        _, img = cap.read()
        data, bbox, _ = detector.detectAndDecode(img) # data = numero  bu
        if(bbox is not None):
            if data:
                if memo != data :
                    memo = data
                    rospy.loginfo(data)
                    # publication du bureau
                    pub.publish(data)
        # attente de 1 seconde
        rate.sleep()


if __name__ == '__main__':
    try:
        listeBureauxPublisher()
    except rospy.ROSInterruptException:
        pass
