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





