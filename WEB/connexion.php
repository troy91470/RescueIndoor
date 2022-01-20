<?php
	//Les informations de la BDD
	session_start();
    require("logs.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Connexion Robot</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
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
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form method='post' class="login100-form validate-form">
					<span class="login100-form-title">
						Connexion Robot Rescue Indoor
					</span>
					
					<div class="wrap-input100 validate-input" data-validate = "Prénom requis">
						<input class="input100" type="text" name="first_name" placeholder="Prénom">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user-circle-o" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Nom requis">
						<input class="input100" type="text" name="second_name" placeholder="Nom">
						
						<span class="symbol-input100">
							<i class="fa fa-user-circle" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Mot de passe requis">
						<input class="input100" type="password" name="password" placeholder="Mot de passe">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<!--<input class="login100-form-btn">-->
						<input  class="login100-form-btn" type="submit" id='submit' value='LOGIN'>
					</div>
					

					<!--<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>-->
				</form>
			</div>
		</div>
	</div>

	<?php

		if(isset($_POST['first_name']) && isset($_POST['second_name']) && isset($_POST['password']) && !empty($_POST['first_name']) && !empty($_POST['second_name']) && !empty($_POST['password']) ) {
			// Connexion à la BDD
			$connexionBDD = new mysqli($servername,$username,$password);
			mysqli_select_db($connexionBDD, $gw_databaseName);


			// Vérifier la connexion
			if($connexionBDD->connect_error) {
				die("Connection failed: " . $connexionBDD->connect_error);
			}

			$first_name = $_POST['first_name']; 
			$second_name = $_POST['second_name'];
			$password = $_POST['password'];

			$sql = "SELECT * FROM user WHERE first_name='$first_name' AND second_name='$second_name' AND password='$password'";
			$result = mysqli_query($connexionBDD,$sql);
			$total = mysqli_num_rows($result);
			// lever erreur : echo(mysqli_error(($connexionBDD)));
			if ($total!=0) {
				echo("<br/>connexion reussie");
				$_SESSION[$first_name]=$first_name;
				$_SESSION[$second_name]=$second_name;
				mysqli_close($connexionBDD);
				header('Location: listeEmployes.php');
			} else {
				echo("<br/>identifiants incorrects");
			}
			
			mysqli_close($connexionBDD);
		}
	?>
	
	

	
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
	<script src="js/main.js"></script>

</body>
</html>