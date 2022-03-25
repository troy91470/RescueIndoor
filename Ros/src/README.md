
# Ros

Ce dossier est composé de deux sous dossiers /carteIno qui contient les deux fichiers principaux de notre robot.

codeRos.ino est téléversé dans une carte arduino mega

analyseQrCode.py est le module d'analyse de Qr code qui est lancer sur la raspberry

Commandes a executer sur la raspberry

```
roscore

rosrun rosserial_python serial_node.py _port:=/dev/ttyACM0 _baud:=57600

roslaunch rosbridge_server rosbridge_websocket.launch

```
