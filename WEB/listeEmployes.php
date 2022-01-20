<?php
	//Les informations de la BDD
	session_start();
	require("logs.php");
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
								
				$requeteBureau = "SELECT * FROM office";
				$resultatBureau = $connexionBDD -> query($requeteBureau);
				while ($ligneBureau = $resultatBureau -> fetch_assoc()) {
					$first_name_utilisateur = NULL;
					$second_name_utilisateur = NULL;
					$qrCode = NULL;

					$requeteUtilisateurs = "SELECT * FROM user";
					$resultatUtilisateurs = $connexionBDD -> query($requeteUtilisateurs);
					while ($ligneUtilisateur = $resultatUtilisateurs -> fetch_assoc()) {
						if($ligneBureau['id_user'] == $ligneUtilisateur['id_user']) {
							$first_name_utilisateur = $ligneUtilisateur['first_name'];
							$second_name_utilisateur = $ligneUtilisateur['second_name'];
						}
					}
					
					$requeteQrCode = "SELECT * FROM qrcode";
					$resultatQrCode = $connexionBDD -> query($requeteQrCode);
					while ($ligneQrCode = $resultatQrCode -> fetch_assoc()) {
						if($ligneBureau['id_qrcode'] == $ligneQrCode['id_qrcode']) {
							$qrCode = $ligneQrCode['path'];
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
