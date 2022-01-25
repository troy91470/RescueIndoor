<?php
	//Les informations de la BDD
	session_start();
	require("logs.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/admin.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util_liste.css">
	<link rel="stylesheet" type="text/css" href="css/main_liste.css">
	<link rel="stylesheet" type="text/css" href="css/util_connexion.css">
	<link rel="stylesheet" type="text/css" href="css/main_connexion.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100">
					<form method="post" action="">
						<table>
							<thead>
								<tr class="table100-head">								
									<th class="column1">Case</th>
									<th class="column2">Bureau à livrer</th>
									<th class="column3">Prénom de l'employé</th>
									<th class="column4">Nom de l'employé</th>
								</tr>
							</thead>
							<tbody>
									<!--<tr>
										<td class="column1">2017-09-29 01:22</td>
										<td class="column2">200398</td>
										<td class="column3">iPhone X 64Gb Grey</td>
									</tr>-->
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
											while ($ligneUtilisateur = $resultatUtilisateurs -> fetch_assoc()) {
												if($ligneBureau['Id'] == $ligneUtilisateur['Id']) {
													$first_name_utilisateur = $ligneUtilisateur['first_name'];
													$second_name_utilisateur = $ligneUtilisateur['second_name'];
												}
											}
											
											$requeteQrCode = "SELECT * FROM qrcode";
											$resultatQrCode = $connexionBDD -> query($requeteQrCode);
											while ($ligneQrCode = $resultatQrCode -> fetch_assoc()) {
												if($ligneBureau['Id'] == $ligneQrCode['id']) {
													$qrCode = $ligneQrCode['valeur'];
												}
											}
											
											// https://www.creativejuiz.fr/blog/tutoriels/personnaliser-aspect-boutons-radio-checkbox-css

											echo '<tr>
												<td><input type="checkbox" name="bureaux[]" value="'.$ligneBureau['label'].'"></td>
												<td>'.$ligneBureau['label'].'</td>
												<td>'.$first_name_utilisateur.'</td>
												<td>'.$second_name_utilisateur.'</td>
											</tr>';
										}
										
										mysqli_close($connexionBDD);
									?>
							</tbody>
						</table>
						<div class="container-login100-form-btn">
							<input  class="login100-form-btn" type="submit" id='submit' value='Livrer ces bureaux'>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	
	

<!--===============================================================================================-->	
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main_liste.js"></script>

</body>
</html>

<?php
	if(!empty($_POST['bureaux'])){
		foreach($_POST['bureaux'] as $valeur){
			echo $valeur;
		}
	}
?>