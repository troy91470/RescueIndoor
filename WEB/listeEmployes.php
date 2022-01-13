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
	session_start();
	include("logs.php");
?>


<form method="post" action="">
	<table>
		<thead>
			<tr>
				<th>Bureau à livrer</th>
				<th>Prénom de l'employé</th>
				<th>Nom de l'employé</th>
				<th>QRCode du bureau</th>
			</tr>
		</thead>
		<tbody>
			<?php	
				// Connexion à la BDDs 
				$connexionBDD = new mysqli($servername,$username,$password);
				mysqli_select_db($connexionBDD, $gw_databaseName);


				// Vérifier la connexion
				if($connexionBDD->connect_error) {
					die("Connection failed: " . $connexionBDD->connect_error);
				}
								
				$requeteBureau = "SELECT * FROM bureau";
				$resultatBureau = $connexionBDD -> query($requeteBureau);
				while ($ligneBureau = $resultatBureau -> fetch_assoc()) {
					$first_name_utilisateur = NULL;
					$second_name_utilisateur = NULL;
					$qrCode = NULL;

					$requeteUtilisateurs = "SELECT * FROM utilisateurs";
					$resultatUtilisateurs = $connexionBDD -> query($requeteUtilisateurs);
					while ($ligneUtilisateurs = $resultatUtilisateurs -> fetch_assoc()) {
						if($ligneBureau['Id'] == $ligneUtilisateurs['Id']) {
							$first_name_utilisateur = $ligneUtilisateurs['first_name'];
							$second_name_utilisateur = $ligneUtilisateurs['second_name'];

						}
					}
					
					$requeteQrCode = "SELECT * FROM qrcode";
					$resultatQrCode = $connexionBDD -> query($requeteQrCode);
					while ($ligneQrCode = $resultatQrCode -> fetch_assoc()) {
						if($ligneBureau['Id'] == $ligneQrCode['id']) {
							$qrCode = $ligneQrCode['valeur'];
						}
					}
					
					echo '<tr><td><input type="checkbox" name="bureaux[]" value="'.$ligneBureau['label'].'">'.$ligneBureau['label'].'</td>
				<td>'.$first_name_utilisateur.'</td><td>'.$second_name_utilisateur.'</td><td>'.$qrCode.'</tr>';
				}
				
				mysqli_close($connexionBDD);
			?>
		<tbody>
	</table>

	<input type="submit" value="Livrer ces bureaux">
<form>

<!-- FONCTION RECUPERANT LES BUREAUX SELECTIONNES -->
<?php
	if(!empty($_POST['bureaux'])){
		foreach($_POST['bureaux'] as $valeur){
			echo $valeur; //ligne à changer (donnée à injecter)
		}
	}
?>


<!-- PASSAGE A L'OUVERTURE DE LA REMORQUE -->

<!-- FONCTION RECUPERANT LES BUREAUX SELECTIONNER -->
