<!-- 

1) PAGE DE CONNEXION A RECUPERER (juste admin)

2) SITE PROPOSANT:
 => RAJOUTER PERSONNE / BUREAU 	...........
 => MODIFIER PERSONNE / BUREAU 	...........
 => SUPPRIMER PERSONNE / BUREAU 	...........

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

	require("functions.php");
	$afficher_erreurs = TRUE;

	if ($afficher_erreurs) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

	if (!is_session_active()) {
		header('Location: connexion.php');
	} else {
		header('Location: listeEmployes.php');
	}
?>

