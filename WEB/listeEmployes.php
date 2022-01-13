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


<form>
	<table>
		<thead>
			<tr>
				<th>Bureau à livrer</th>
				<th>Prénom de l'employé</th>
				<th>Nom de l'employé</th>
				<th>QRCode de l'employé</th>
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
					
					echo '<tr><td><input type="checkbox" id="'.$qrCode.'" name="'.$qrCode.'"><label for="'.$qrCode.'">'.$bureau.'</label></td>
				<td>'.$ligneUtilisateurs['first_name'].'</td><td>'.$ligneUtilisateurs['second_name'].'</td><td>'.$qrCode.'</tr>';
				}
				
				mysqli_close($connexionBDD);
			?>
		<tbody>
	</table>

	<button type="submit">Livrer ces bureaux</button>
<form>

<!-- FONCTION RECUPERANT LES BUREAUX SELECTIONNER -->
<!-- PASSAGE A L'OUVERTURE DE LA REMORQUE -->

<!-- FONCTION RECUPERANT LES BUREAUX SELECTIONNER -->
