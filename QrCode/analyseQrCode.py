"""
 # attention a ne pas renommer ce fichier "qrcode.py"

import qrcode
import cv2

# QR code detection object
detector = cv2.QRCodeDetector()

img = cv2.imread("png_random2.jpg")

# get bounding box coords and data
data, bbox, _ = detector.detectAndDecode(img) # data = numero  bu

# if there is a bounding box, draw one, along with the data
if(bbox is not None):
    if data:
        print("qrcode du bureau detecté: ", data)
else:
    print("aucun qrcode detecte")
# pseudo-code timestart = time.start() 
# pseudo-code if(bouton appuyé || timestart != XX minutes):
# pseudo-code   break

"""
from time import sleep
import cv2
import rospy
from std_msgs.msg import String

memo = ""

# set up camera object
cap = cv2.VideoCapture(0)

# QR code detection object
detector = cv2.QRCodeDetector()

while True:
    # get the image
    _, img = cap.read()
    # get bounding box coords and data
    data, bbox, _ = detector.detectAndDecode(img) # data = numero  bu
    # if there is a bounding box, draw one, along with the data
    if(bbox is not None):
        if data:
            if memo != data :
                memo = data
                pub = rospy.Publisher('', String, 1)
                rospy.init_node('', anonymous=True)
                while not rospy.is_shutdown():
                     e
    if(cv2.waitKey(1) == ord("q")):
        break
    sleep(1)
    # pseudo-code timestart = time.start()
    # pseudo-code if(bouton appuyé || timestart != XX minutes):
    # pseudo-code   break
# free camera object and exit
cap.release()
