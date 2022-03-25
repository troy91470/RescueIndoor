<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), Clément ROBIN (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But de la page: 
		Sur cette page, l'utilisateur peut choisir quels utilisateurs livrer.
-->


<?php
	require("functions.php");
	require("logs.php");

	if (!isSessionActive()) 
	{
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Livraison</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Packages CSS -->
		<!--===============================================================================================-->	
		<link rel="icon" type="image/png" href="images/icons/admin.ico"/>
		<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
		<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
		<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
		<link rel="stylesheet" type="text/css" href="css/delivery.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
		<!--===============================================================================================-->
	</head>
		
	<body>
		<div class="row">

			<!-- Bouton de retour au menu -->
			<div class="colonne1">
				<a href="adminMenu.php">
					<input  class="bouton-top" type="submit" value='retour'>
				</a>
			</div>

			<!-- Bouton de déconnexion -->
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
											$lsConnexionBDD = connexionBDD(); //variable permettant d'avoir la connexion au serveur SQL

											$lsRequestUsers = "SELECT * FROM user"; //Requête SQL récupérant toutes les lignes de la BDD
											$lsResultUsers = $lsConnexionBDD -> query($lsRequestUsers); //variable récupérant le résultat de la requête lsRequestUsers
											$lnNumeroLigne = 1; //Variable permettant de donner le numéro de ligne aux checkboxs, et donc de les dissocier dans les fonctions
											while ($lsLineUser = $lsResultUsers -> fetch_assoc()) //lsLineUser récupère ligne par ligne les données de lsResultUsers
											{
												$lnOffice = $lsLineUser['office']; //Variable stockant l'éventuel numéro de bureau de l'utilisateur correspondant à la ligne lue
												$lwFirstName = $lsLineUser['first_name']; //Variable stockant le prénom de l'utilisateur correspondant à la ligne lue
												$lwSecondName = $lsLineUser['second_name']; //Variable stockant le nom de l'utilisateur correspondant à la ligne lue
												$lwEmail = $lsLineUser['email']; //Variable stockant l'email de l'utilisateur correspondant à la ligne lue

												if ($lnOffice !== NULL) 
												{
													$lwValueUser = "(".$lnOffice.",".$lwEmail.")"; //Couple bureau et email, exemple: "(314,a@mail.com)"
													echo('<tr>
														<td>
															<input type="checkbox" class="demo" id="demo'.$lnNumeroLigne.'" name="office[]" value='.$lwValueUser.'>
															<label for="demo'.$lnNumeroLigne.'"></label>
														</td>
														<td>'.$lnOffice.'</td>
														<td>'.$lwFirstName.'</td>
														<td>'.$lwSecondName.'</td>
														<td>'.$lwEmail.'</td>
													</tr>');
												}
												else
												{
													//Si l'utilisateur n'a pas de bureau, on ne peut pas le livrer, il ne faut donc pas l'afficher
												}

												$lnNumeroLigne++;
											}	
											mysqli_close($lsConnexionBDD);
										?>
								</tbody>
							</table>

							<!-- Bouton pour livrer les bureaux sélectionnés -->
							<div class="container-bouton">
								<input  class="bouton" type="submit" id='submit' value='Livrer ces bureaux'>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>


<!-- Packages JavaScript pour le CSS-->
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
		if(isset($_POST['office']) && is_array($_POST['office']) && !empty($_POST['office']))
		{
			$lvListOffices = ""; //liste de couples de valeurs d'utilisateurs, liste qui sera envoyée sur le RosBridge, exemple: "(314,a@mail.com);(415,b@mail.com);(785,c@mail.com)"
			foreach($_POST['office'] as $valeur)
			{
					$lvListOffices = $lvListOffices."$valeur";
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
      		data: <?php echo($lvListOffices); ?> 
    	});

      	listeBureaux.publish(messageBureaux);
		ouvertureRemorque.publish();
	</script>

	<?php
			echo("<script>alert('Envois des bureaux suivants : {$lvListOffices}')</script>");
		}
		else
		{
			//Sinon aucun bouton n'est cliqué et il ne se passe rien.
		}
	?>

</body>
</html>
