# ROS CODE ROBOT INDOOR #


## Presentation ##

Programme ROS pour le Robot Indoor : Groupe X (XXXXXXXXXXXXXXXXX)


## Pseudo-code ##

### Enregistrer le courrier pour chaque bureau ###

#### Pré-requis : ####
	Connexion au mode admin
	Ouvrir le coffre

#### Code : ####
	Enregistrer le numero du bureau
		Ouvrir l'interface d'ajout de courrier
			Ajouter l'id du courrier
			# Mettre le courrier dans le coffre
		Fermer l'interface d'ajout du courrier
	Fermer le numero du bureau

### Lancement du robot ###

#### Pré-requis ####
	Ligne noir placé sur le parcours
	Aucun obstacle ne doit être présent sur le parcours
	QR CODE placé devant chaque bureau
	Bande de sckotch rouge présente devant chaque bureau

#### Code : ####
	Tant que le robot est sur la ligne
		avancer
		analyse de la ligne
		SI une bande de sckotch rouge est detecté
			analyser le QR CODE
			Trouver le numero de bureau correspondant au QR CODE analyse
			Envoyer une notification au bureau associe
			Lancer chrono de 5 minutes
				Tant que message non accepte
					attendre
				Fin tant que
			FIN chrono
			Si message accepte
				Ouvrir le coffre
				Attendre 2 minutes
				Fermer le coffre
				Memoriser le bureau accepteur
			Fin si
			SINON 
				Memoriser le bureau refuseur
			FIN SINON
		FIN si


### Commande Ros a faire ###

roscore

rosrun rosserial_python serial_node.py _port:=/dev/ttyACM0 _baud:=57600

rostopic echo state

rostopic pub "topic" std_msgs/Empty --once 


####################################

# Package Information for pkg-config

prefix=/usr/local
exec_prefix=${prefix}
libdir=${exec_prefix}/lib
includedir=${prefix}/include/opencv4

Name: OpenCV
Description: Open Source Computer Vision Library
Version: 4.5.5
Libs: -L${exec_prefix}/lib -lopencv_gapi -lopencv_stitching -lopencv_aruco -lopencv_barcode -lopencv_bgsegm -lopencv_bioinspired -lopencv_ccalib -lopencv_dnn_objdetect -lopencv_dnn_superres -lopencv_dpm -lopencv_face -lopencv_freetype -lopencv_fuzzy -lopencv_hfs -lopencv_img_hash -lopencv_intensity_transform -lopencv_line_descriptor -lopencv_mcc -lopencv_quality -lopencv_rapid -lopencv_reg -lopencv_rgbd -lopencv_saliency -lopencv_stereo -lopencv_structured_light -lopencv_phase_unwrapping -lopencv_superres -lopencv_optflow -lopencv_surface_matching -lopencv_tracking -lopencv_highgui -lopencv_datasets -lopencv_text -lopencv_plot -lopencv_videostab -lopencv_videoio -lopencv_wechat_qrcode -lopencv_xfeatures2d -lopencv_shape -lopencv_ml -lopencv_ximgproc -lopencv_video -lopencv_xobjdetect -lopencv_objdetect -lopencv_calib3d -lopencv_imgcodecs -lopencv_features2d -lopencv_dnn -lopencv_flann -lopencv_xphoto -lopencv_photo -lopencv_imgproc -lopencv_core
Libs.private: -ldl -lm -lpthread -lrt
Cflags: -I${includedir}

###############################


g++ analyseQrCode.cpp -o testoutput -std=c++11 `pkg-config --cflags --libs opencv`

pkg-config opencv --cflags


sudo apt-get install libopencv-dev

sudo mkdir /usr/local/lib/pkgconfig && sudo nano /usr/local/lib/pkgconfig/opencv.pc
