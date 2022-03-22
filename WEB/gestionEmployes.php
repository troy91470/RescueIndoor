<?php
	//Les informations de la BDD
	require("functions.php");
	if (!is_session_active()) {
		header('Location: index.php');
	}
	require("logs.php");


	// Connexion à la BDDs 
	$connexionBDD = new mysqli($servername,$username,$password);
	mysqli_select_db($connexionBDD, $gw_databaseName);


	// Vérifier la connexion
	if($connexionBDD->connect_error) {
		die("Connection failed: " . $connexionBDD->connect_error);
	}
					
	$requeteUtilisateurs = "SELECT * FROM user";
	$resultatUtilisateurs = $connexionBDD -> query($requeteUtilisateurs);
	$users=array();
	$idLigne = 0;
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
	<title>Gestion</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/admin.ico"/>
	<link rel="stylesheet" type="text/css" href="css/gestionEmployes.css">
	<!--===============================================================================================-->	
	</head>
	<div class="titre">Gestion des employés</div>
	<br><br>
	<body>
<?php
	while ($ligneUtilisateur = $resultatUtilisateurs -> fetch_assoc()) {
		$idUser = $ligneUtilisateur['id_user'];
		$bureauUtilisateur = $ligneUtilisateur['id_user'];
		$idLigne = $idLigne+1;
?>

	<details>
		<summary><?php echo $ligneUtilisateur['first_name'].'  '.$ligneUtilisateur['second_name'] ?></summary>
		<form method="post">
			<div class="row">
				<div class="column1">
					<label for="first_name">Prénom :</label>
				</div>					
				<div class="column2">
					<input class="saisie" type="text" name="firstNameModif" placeholder="<?php echo $ligneUtilisateur['first_name']?>"> 
				</div>		
				<div class="column1">
					<label for="second_name">Nom :</label>
				</div>	
				<div class="column2">
					<input class="saisie" type="text" name="secondNameModif" placeholder="<?php echo $ligneUtilisateur['second_name']?>">
				</div>
			</div>

			<div class="row">
				<div class="column3">
					<label for="emailModifier">Adresse mail :</label>
				</div>
				<div class="column4">
					<input class="saisie" type="text" name="emailModif" placeholder="<?php echo $ligneUtilisateur['email']?>"> 
				</div>
				<div class="column1">
					<label for="bureau">Bureau :</label>
				</div>
				<div class="column2">	
					<div class="quantity">
						<input type="number" name="officeModif" min="1" max="10240" step="1" value="<?php echo $ligneUtilisateur['office']?>">
					</div>
				</div>
			</div>
				<!--<input class="saisie" type="text" value="php echo $idUser?>" hidden name="idUser">-->	
			<div class="row">
				<div class="column5">
					<input class="bouton" type="submit" value="Modifier" name="option">
				</div>	
				<div class="column5">
					<input class="bouton" type="submit" value="Supprimer" name="option">
				</div>
			</div>
		</form>
	</details>
<?php
	}
?>
<br>
<br>
<br>
<details>
		<summary class="ajoutBackground">Ajout d'un nouvel employé</summary>
		

	<form method="post">
		<div class="row">
			<div class="column1">
				<label for="firstName">Prénom</label>
			</div>
			<div class="column2">
				<input class="saisie" type="text" placeholder="Prénom de l'employé" name="firstName" required>
			</div>
			<div class="column1">
				<label for="secondName">Nom</label>
			</div>
			<div class="column2">
				<input class="saisie" type="text" placeholder="Nom de l'employé" name="secondName" required>
			</div>
		</div>

		<div class="row">
			<div class="column3">
				<label for="emailAjouter">Adresse mail</label>
			</div>
			<div class="column4">
				<input class="saisie" type="text" placeholder="Email de l'employé" name="emailAjouter" required>
			</div>
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
			<div class="column3">
				<label for="password">Mot de passe</label>
			</div>
			<div class="column2">
				<input class="saisie" type="text" placeholder="Mot de passe	" name="password" required>
			</div>
			<div class="column3">
				<label for="isAdmin">Administrateur</label>	
			</div>
			<div class="column9">
				<input type="checkbox" class="demo" id="demo1" name="isAdmin">
				<label for="demo1"></label>
			</div>
		</div>
		<div class="row">
			<div class="column6">
				<input class="bouton" type="submit" value="Ajouter" name="option">
				</div>
			</div>
		</div>

	<?php
		//modification de l'employé dans la BDD
		if(isset($_POST["option"])){
			if ($_POST["option"] == "Modifier") {
				$idUser = $_POST['idUser'];
				modification_employe($idUser, $_POST['emailModif'], $_POST['firstNameModif'], $_POST['secondNameModif'], $_POST['officeModif']);
			}
			//suppression de l'employé dans la BDD
			elseif ($_POST["option"] == "Supprimer") {
					$idUser = $_POST['idUser'];
					suppression_employe($idUser);
					echo "<script>alert('Suppression effectuée.')</script>";
			} 

			//insertion de l'employé saisi dans la BDD
			elseif ($_POST["option"] == "Ajouter") {  
				if(isset($_POST['isAdmin'])){
					$isAdmin = 1;
				} else {
					$isAdmin = 0;
				}

				if(!empty($_POST['office']) && isset($_POST['office']))
				{
					ajout_employe($_POST['emailAjouter'], $_POST['firstName'],$_POST['secondName'],$_POST['office'],$_POST['password'],$isAdmin);
				} 
				else {
					ajout_employe($_POST['emailAjouter'], $_POST['firstName'],$_POST['secondName'],NULL,$_POST['password'],$isAdmin);
				}
				
			}
		}
	?>
		</form> <!-- ajout employe -->
	</details>
<script src="js/gestionEmployes.js"></script>
</body>
</html>

<?php	
	mysqli_close($connexionBDD);
?>
