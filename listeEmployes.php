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
    include("logs.php");
	
	// Connexion à la BDDs 
	$connexionBDD = new mysqli($servername,$username,$password);
	mysqli_select_db($connexionBDD, $gw_databaseName);


	// Vérifier la connexion
	if($connexionBDD->connect_error) {
		die("Connection failed: " . $connexionBDD->connect_error);
	}
	
	$requeteUtilisateurs = "SELECT * FROM utilisateurs";
	$resultatUtilisateurs = $connexionBDD -> query($requeteUtilisateurs);
	while ($ligneUtilisateurs = $resultatUtilisateurs -> fetch_assoc()) {
		$bureau = NULL;
		$qrCode = NULL;

		$requeteBureau = "SELECT * FROM bureau";
		$resultatBureau = $connexionBDD -> query($requeteBureau);
		while ($ligneBureau = $resultatBureau -> fetch_assoc()) {
			if($ligneUtilisateurs['Id'] == $ligneBureau['Id']) {
				$bureau = $ligneBureau['label'];
			}
		}
		
		$requeteQrCode = "SELECT * FROM qrcode";
		$resultatQrCode = $connexionBDD -> query($requeteQrCode);
		while ($ligneQrCode = $resultatQrCode -> fetch_assoc()) {
			if($ligneUtilisateurs['Id'] == $ligneQrCode['id']) {
				$qrCode = $ligneQrCode['valeur'];
			}
		}
		
		echo $ligneUtilisateurs['first_name'] . ' ' . $ligneUtilisateurs['second_name']  . ' ' . $bureau . ' ' . $qrCode .  '<br>';
	}
	
	
	
	
	
	mysqli_close($connexionBDD);
?>
