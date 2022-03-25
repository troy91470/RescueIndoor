# Lucas Deshayes & Reda Guendouz

import cv2
import rospy
from std_msgs.msg import String

def listeBureauxPublisher():
    memo = ""
    # set up camera object
    cap = cv2.VideoCapture(0)
    # QR code detection object
    detector = cv2.QRCodeDetector()
    pub = rospy.Publisher('qrCodeData', String, queue_size=10)
    rospy.init_node('talker', anonymous=True)
    rate = rospy.Rate(1) # 1hz
    while not rospy.is_shutdown():
        _, img = cap.read()
        data, bbox, _ = detector.detectAndDecode(img) # data = numero  bu
        if(bbox is not None):
            if data:
                if memo != data :
                    memo = data
                    bureau = data.split()
                    rospy.loginfo(bureau[0])
                    pub.publish(bureau[0])
                    rate.sleep()

if __name__ == '__main__':
    try:
        listeBureauxPublisher()
    except rospy.ROSInterruptException:
        pass