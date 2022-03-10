<?php
	require("functions.php");
	//Les informations de la BDD
	if (!is_session_active()) {
		header('Location: index.php');
	}
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
	<link rel="stylesheet" type="text/css" href="css/main_connexion.css">
<!--===============================================================================================-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>

</head>
<body>
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100">
					<form method="post" action="">
					<span class="le-title-personnaliser">
							Liste des employés
						</span>
						<table>
							<thead>
								<tr class="table100-head">								
									<th class="column1">Livrer</th>
									<th class="column2">Bureau</th>
									<th class="column3">Prénom</th>
									<th class="column4">Nom</th>
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
										$requeteUtilisateurs = "SELECT * FROM user";
										$resultatUtilisateurs = $connexionBDD -> query($requeteUtilisateurs);
										$numeroLigne = 1;
										while ($ligneUtilisateur = $resultatUtilisateurs -> fetch_assoc()) {
											$first_name_utilisateur = $ligneUtilisateur['first_name'];
											$second_name_utilisateur = $ligneUtilisateur['second_name'];
											$office_utilisateur = $ligneUtilisateur['office'];
										

											// https://www.creativejuiz.fr/blog/tutoriels/personnaliser-aspect-boutons-radio-checkbox-css
											if ($office_utilisateur != NULL) {
												echo('<tr>
													<td>
														<input type="checkbox" class="demo" id="demo'.$numeroLigne.'" name="office[]" value='.$office_utilisateur.'>
														<label for="demo'.$numeroLigne.'"></label>
													</td>
													<td>'.$office_utilisateur.'</td>
													<td>'.$first_name_utilisateur.'</td>
													<td>'.$second_name_utilisateur.'</td>
												</tr>');
											}
										}	
										mysqli_close($connexionBDD);
									?>

									<!--<tr>
										<td>
											<input type="checkbox" class="demo" id="demo">
											<label for="demo"></label>
										</td>
										<td>115</td>
										<td>non</td>
										<td>oui</td>
									</tr>

									<tr>
										<td>
											<input type="checkbox" class="demo" id="demo1">
											<label for="demo1"></label>
										</td>
										<td>1115</td>
										<td>noooon</td>
										<td>oui</td>
									</tr>

									<tr>
										<td>
											<input type="checkbox" class="demo" id="demo2">
											<label for="demo2"></label>
										</td>
										<td>11555</td>
										<td>non</td>
										<td>ouiiiiii</td>
									</tr>-->

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

	<!--<input type="checkbox" class="demo5" id="demo5">
													-->
	

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
	if(isset($_POST['office']) && is_array($_POST['office'])){
		$listhOffices="";
		$flad=0;
		foreach($_POST['office'] as $valeur){
			if ($flag==0) {
				$listOffices = $listOffices."$valeur";
				$flag=1;
			} else {
				$listOffices = $listOffices.";$valeur";
			}
			//echo("<script>alert('aaa |{$valeur}|')</script>");
		}
		echo("<script>alert('oui|$listOffices|')</script>");

	}
?>