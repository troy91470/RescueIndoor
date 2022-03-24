<?php
	require("functions.php");
	//Les informations de la BDD
	if (!is_session_active()) {
		header('Location: index.php');
	}
	require("logs.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Livraison</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
		<link rel="icon" type="image/png" href="images/icons/admin.ico"/>
		<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
		<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
		<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
		<link rel="stylesheet" type="text/css" href="css/listeEmployees.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<!--===============================================================================================-->
	</head>
		
	<body>
		<div class="row">
			<div class="colonne1">
				<a href="menu.php">
					<input  class="bouton-top" type="submit" value='retour'>
				</a>
			</div>
			<div class="colonne2">
				<a href="deconnexion.php">
					<input  class="bouton-top" type="submit" value='Deconnexion'>
				</a>
			</div>
		</div>
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
										<th class="column5">Email</th>
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
												$email_utilisateur = $ligneUtilisateur['email'];

												// https://www.creativejuiz.fr/blog/tutoriels/personnaliser-aspect-boutons-radio-checkbox-css
												if ($office_utilisateur !== NULL) {
													$valeur_utilisateur="(".$office_utilisateur.",".$email_utilisateur.")";
													echo('<tr>
														<td>
															<input type="checkbox" class="demo" id="demo'.$numeroLigne.'" name="office[]" value='.$valeur_utilisateur.'>
															<label for="demo'.$numeroLigne.'"></label>
														</td>
														<td>'.$office_utilisateur.'</td>
														<td>'.$first_name_utilisateur.'</td>
														<td>'.$second_name_utilisateur.'</td>
														<td>'.$email_utilisateur.'</td>
													</tr>');
												}
												$numeroLigne++;
											}	
											mysqli_close($connexionBDD);
										?>
								</tbody>
							</table>
							<div class="container-bouton">
								<input  class="bouton" type="submit" id='submit' value='Livrer ces bureaux'>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="js/main_liste.js"></script>
<!--===============================================================================================-->


	<?php
	if(isset($_POST['office']) && is_array($_POST['office']) && !empty($_POST['office'])){
		$listOffices="";
		$flag=0;
		foreach($_POST['office'] as $valeur){
			if ($flag==0) {
				$listOffices = $listOffices."$valeur";
				$flag=1;
			} else {
				$listOffices = $listOffices.";$valeur";
			}
			//echo("<script>alert('aaa |{$valeur}|')</script>");
		}
	?>
	<script>
		var ouvertureRemorque = new ROSLIB.Topic({
			ros : rosServer,
			name : '/OUVERTUREREMORQUE',
			messageType : 'std_msgs/Empty'
		});
		var listeBureaux = new ROSLIB.Topic({
			ros : rosServer,
			name : '/listeTopic',
			messageType : 'std_msgs/String'
		});
		var messageBureaux = new ROSLIB.Message({
      		data: <?php echo($listOffices); ?> // "(314,a@mail.com);(415,b@mail.com);(785,c@mail.com)"
    	});
      	listeBureaux.publish(messageBureaux);
		ouvertureRemorque.publish();
	</script>
	<?php
		echo("<script>alert('Envois des bureaux suivants : {$listOffices}')</script>");
	}
	?>

</body>
</html>
