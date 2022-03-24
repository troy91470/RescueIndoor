<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), Clément ROBIN (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But de la page: 
		Sur cette page, l'utilisateur saisi un email et un mot de passe afin de se connecter. Si la connexion est réussie, la session de l'utilisateur est démarrée et l'utilisateur est redirigé sur la page adminMenu.php. 
-->


<?php
	require("functions.php");

	if (isSessionActive()) 
	{
		header('Location: adminMenu.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Connexion Robot</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Packages CSS -->
		<!--===============================================================================================-->	
			<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
			<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
			<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
			<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
			<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
			<link rel="stylesheet" type="text/css" href="css/connexion.css">
		<!--===============================================================================================-->
	</head>
	<body>
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">
					<div class="login100-pic js-tilt" data-tilt>
						<img src="images/img-01.png" alt="IMG">
					</div>

					<!-- Formulaire de connexion -->
					<form method='post' class="login100-form validate-form">
						<span class="login100-form-title">
							Connexion Robot Rescue Indoor
						</span>
						
						<!-- Email -->
						<div class="wrap-input100 validate-input" data-validate = "Adresse mail requise">
							<input class="input100" type="text" name="email" placeholder="Adresse mail">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-user-circle-o" aria-hidden="true"></i>
							</span>
						</div>

						<!-- Mot de passe -->
						<div class="wrap-input100 validate-input" data-validate = "Mot de passe requis">
							<input class="input100" type="password" name="password" placeholder="Mot de passe">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
						</div>
						
						<!-- Bouton de confirmation -->
						<div class="container-login100-form-btn">
							<input  class="login100-form-btn" type="submit" id='submit' value='LOGIN'>
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php 
			if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']) ) 
			{
				$lsConnexionBDD = connexionBDD(); //variable permettant d'avoir la connexion au serveur SQL

				$lwEmail = $_POST['email'];  //variable stockant l'email saisi par l'utilisateur pour se connecter
				$lwPassword = $_POST['password']; //variable stockant le mot de passe saisi par l'utilisateur pour se connecter
				$lbLogin = false; //variable stockant le booléen indiquant si l'utilisateur s'est bien connecté ou non

				$lsRequestLogin = "SELECT * FROM user WHERE email='$lwEmail'"; //Requête SQL permettant de récupérer les utilisateurs avec l'adresse email spécifiée
				$lsResultUsersLogin = $lsConnexionBDD -> query($lsRequestLogin); //variable récupérant le résultat de la requête lsRequestLogin
				$lnNumberUser = mysqli_num_rows($lsResultUsersLogin); //variable indiquant le nombre d'utilisateurs avec l'adresse mail indiquée (ça ne sera jamais 2)

				if($lnNumberUser != 0)
				{
					while ($lsLineUser = $lsResultUsersLogin -> fetch_assoc()) //lsLineUser récupère ligne par ligne les données de lsResultUsersLogin
					{
						//L'utilisateur est connecté
						if (password_verify($lwPassword, $lsLineUser['password'])) 
						{
							$lbLogin = true;

							session_start();
							session_id($lsLineUser['id_user']);
							$_SESSION['count'] = 1;
							$_SESSION['email'] = $lwEmail;
							$_SESSION['isAdmin'] = $lsLineUser['is_admin'];

							mysqli_close($lsConnexionBDD);

							if($_SESSION['isAdmin'] == 1)
							{
								header('Location: adminMenu.php');
							}
							else
							{
								header('Location: userMenu.php');
							}
						}
					}

					//L'utilisateur ne s'est pas connecté
					if ( $lbLogin == false ) 
					{
						echo("<script>alert('mot de passe incorrect ')</script>");
					}
					else
					{
						//On ne rentre jamais ici car sinon cela veut dire que l'utilisateur est connecté
					}
				} 
				else
				{
					echo("<script>alert('identifiants incorrects')</script>");
				}

				mysqli_close($lsConnexionBDD);
			}
		?>
		

		<!-- Packages JavaScript pour le CSS-->
		<!-- ===============================================================================================-->	
			<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
			<script src="vendor/bootstrap/js/popper.js"></script>
			<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
			<script src="vendor/select2/select2.min.js"></script>
			<script src="vendor/tilt/tilt.jquery.min.js"></script>
			<script>
				$('.js-tilt').tilt({
					scale: 1.1
				})
			</script>
			<script src="js/main_connexion.js"></script>
		<!--===============================================================================================-->

	</body>
</html>