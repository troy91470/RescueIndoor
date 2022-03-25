<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), Clément ROBIN (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But de la page: 
		Sur cette page, l'administrateur peut ajouter, modifier ou supprimer un utilisateur dans la base de données.
-->


<?php
	require("../functions.php");
	
	if (!isSessionActive() || $_SESSION['isAdmin'] !== 1) 
	{
		header('Location: ../index.php');
	}
	
	$lsConnexionBDD = connexionBDD(); //variable permettant d'avoir la connexion au serveur SQL
					
	$lsRequestSelectUsers = "SELECT * FROM user"; //requête selectionnant les utilisateurs
	$lsResultUsers = $lsConnexionBDD -> query($lsRequestSelectUsers); //résultat de la requête lsRequestSelectUsers
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Gestion</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Packages CSS -->
		<!--===============================================================================================-->	
		<link rel="icon" type="image/png" href="../images/icons/admin.ico"/>
		<link rel="stylesheet" type="text/css" href="../css/manageEmployee.css">
		<!--===============================================================================================-->	
	</head>

	<div class="row">

		<!-- Bouton de retour au menu -->
		<div class="colonne10">
			<a href="menu.php">
				<input  class="bouton-top" type="submit" value='retour'>
			</a>
		</div>

		<!-- Bouton de déconnexion -->
		<div class="colonne11">
			<a href="../deconnexion.php">
				<input  class="bouton-top" type="submit" value='Deconnexion'>
			</a>
		</div>
	</div>

	<div class="titre">Gestion des employés</div>
	<br><br>
	<body>

		<?php
			while ($lsLineUser = $lsResultUsers -> fetch_assoc()) //lsLineUser récupère ligne par ligne les données de lsResultUsers
			{
				$lnIdUser = $lsLineUser['id_user']; //id de l'utilisateur correspondant à la ligne lue
		?>

        		<!-- Liste des utilisateurs existants déjà dans la BDD -->
				<details>
					<summary><?php echo $lsLineUser['first_name'].'  '.$lsLineUser['second_name'] ?></summary>
					<form method="post">
						<div class="row">
						    <!-- Prénom de l'utilisateur déplié -->
							<div class="column1">
								<label for="first_name">Prénom</label>
							</div>		
							<div class="column2">
								<input class="saisie" type="text" name="firstNameModif" placeholder="<?php echo $lsLineUser['first_name']?>"> 
							</div>	
							
							 <!-- Nom de l'utilisateur déplié -->
							<div class="column1">
								<label for="second_name">Nom</label>
							</div>	
							<div class="column2">
								<input class="saisie" type="text" name="secondNameModif" placeholder="<?php echo $lsLineUser['second_name']?>">
							</div>
						</div>

						<div class="row">
							<!-- Email de l'utilisateur déplié -->
							<div class="column3">
								<label for="emailModifier">Adresse mail</label>
							</div>
							<div class="column4">
								<input class="saisie" type="text" name="emailModif" placeholder="<?php echo $lsLineUser['email']?>"> 
							</div>

							<!-- Numéro de bureau de l'utilisateur déplié -->
							<div class="column1">
								<label for="bureau">Bureau</label>
							</div>
							<div class="column2">	
								<div class="quantity">
									<input type="number" name="officeModif" min="1" max="10240" step="1" value="<?php echo $lsLineUser['office']?>">
								</div>
							</div>
						</div>
						<input type="text" value="<?php echo $lnIdUser?>" hidden name="idUser">

						<div class="row">
							<!-- Bouton de modification de l'utilisateur déplié -->
							<div class="column5">
								<input class="bouton" type="submit" value="Modifier" name="option">
							</div>

							<!-- Bouton de suppression de l'utilisateur déplié -->
							<div class="column5">
								<input class="bouton" type="submit" value="Supprimer" name="option">
							</div>

						</div>
					</form>
				</details>
		<?php
			}
		?>

		<br><br><br>
		
		<details>
			<summary class="ajoutBackground">Ajout d'un nouvel employé</summary>

			<form method="post">
				<div class="row">
					<!-- Prénom de l'employé à ajouter -->
					<div class="column1">
						<label for="firstName">Prénom</label>
					</div>
					<div class="column2">
						<input class="saisie" type="text" placeholder="Prénom de l'employé" name="firstName" required>
					</div>

					<!-- Nom de l'employé à ajouter -->
					<div class="column1">
						<label for="secondName">Nom</label>
					</div>
					<div class="column2">
						<input class="saisie" type="text" placeholder="Nom de l'employé" name="secondName" required>
					</div>
				</div>


				<div class="row">
					<!-- Adresse mail de l'employé à ajouter -->
					<div class="column3">
						<label for="emailAjouter">Adresse mail</label>
					</div>
					<div class="column4">
						<input class="saisie" type="text" placeholder="Email de l'employé" name="emailAjouter" required>
					</div>

					<!-- Numéro de bureau de l'employé à ajouter -->
					<div class="column1">
						<label for="office">Bureau</label>
					</div>
					<div class="column2">
						<div class="quantity">
							<input type="number" name="office" min="1" max="10240" step="1" value="1">
						</div>
					</div>
				</div>


				<div class="row">
					<!-- Mot de passe de l'employé à ajouter -->
					<div class="column3">
						<label for="password">Mot de passe</label>
					</div>
					<div class="column2">
						<input class="saisie" type="password" placeholder="Mot de passe" name="password" required>
					</div>

					<!-- Booléen indiquant si l'employé à ajouter est un administrateur ou non -->
					<div class="column3">
						<label for="isAdmin">Administrateur</label>	
					</div>
					<div class="column9">
						<input type="checkbox" class="demo" id="demo1" name="isAdmin">
						<label for="demo1"></label>
					</div>
				</div>


				<div class="row">
					<!-- Bouton d'ajout de l'utilisateur -->
					<div class="column6">
						<input class="bouton" type="submit" value="Ajouter" name="option">
					</div>
				</div>
			</div>


			<?php
				//modification de l'employé dans la BDD
				if(isset($_POST["option"]))
				{
					if ($_POST["option"] == "Modifier") 
					{
						$lnIdUserModified = $_POST['idUser']; //id de l'utilisateur à modifier
						editEmployee($lnIdUserModified, $_POST['emailModif'], $_POST['firstNameModif'], $_POST['secondNameModif'], $_POST['officeModif']);
					}
					//suppression de l'employé dans la BDD
					elseif ($_POST["option"] == "Supprimer") 
					{
						$lnIdUserDeleted = $_POST['idUser']; //id de l'utilisateur à supprimer
						deleteEmployee($lnIdUserDeleted);
					} 

					//insertion de l'employé saisi dans la BDD
					elseif ($_POST["option"] == "Ajouter") 
					{  
						if(isset($_POST['isAdmin']))
						{
							$lbIsAdmin = 1;  //booléen indiquant si le nouvel utilisateur est un administrateur (1) ou non (0)
						} 
						else 
						{
							$lbIsAdmin = 0;
						}

						if(!empty($_POST['office']) && isset($_POST['office']))
						{
							addEmployee($_POST['emailAjouter'], $_POST['firstName'],$_POST['secondName'],$_POST['office'],$_POST['password'],$lbIsAdmin);
						} 
						else 
						{
							addEmployee($_POST['emailAjouter'], $_POST['firstName'],$_POST['secondName'],NULL,$_POST['password'],$lbIsAdmin);
						}
					}
				}
			?>
			</form> <!-- ajout employe -->
		</details>
		<script src="../js/manageEmployee.js"></script>
	</body>
</html>

<?php	
	mysqli_close($lsConnexionBDD);
?>
