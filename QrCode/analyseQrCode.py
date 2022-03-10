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
import cv2

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
            print("qrcode du bureau detecté: ", data)
    if(cv2.waitKey(1) == ord("q")):
        break
    # pseudo-code timestart = time.start() 
    # pseudo-code if(bouton appuyé || timestart != XX minutes):
    # pseudo-code   break
# free camera object and exit
cap.release()

"""