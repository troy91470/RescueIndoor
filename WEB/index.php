<!-- 

1) PAGE DE CONNEXION A RECUPERER (juste admin)

2) SITE PROPOSANT:
=> VOIR LA LISTE DES EMPLOYES AVEC LEUR PRENOM, NOM, SALLE, ET N° QRCODE
=> LANCER UN TRAJET:
	- DEFINIR QUI SERA LIVRE EN COCHANT
	- OUVRIR REMORQUE
	- ATTENTE DE FERMETURE DE REMORQUE
	- FERMER REMORQUE
	- MSG DE REFUS DE DEPART SI LE ROBOT N'EST PAS SUR LA LIGNE DE DEPART
	- BOUTON POUR LANCER LE ROBOT	

=> SUIVRE LE TRAJET EN COURS:
	- VOIR QUI EST LIVRE
	- VOIR QUI DOIT ETRE LIVRE
	- VOIR OU ON EN EST

-->

<?php
	//Les informations de la BDD
	session_start();
	if (isset($_SESSION) ) {
		header('Location: connexion.php');
	}
?>
