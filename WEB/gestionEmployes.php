<?php
	//Les informations de la BDD
	session_start();
	require("logs.php");
	require("functions.php");
?>


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
	$users=array();
	$idLigne = 0;
	while ($ligneUtilisateur = $resultatUtilisateurs -> fetch_assoc()) {
		$idUser = $ligneUtilisateur['id_user'];
		$bureauUtilisateur = $ligneUtilisateur['id_user'];
		$idLigne = $idLigne+1;

?>

		<details>
			<summary><?php echo $ligneUtilisateur['first_name'].'  '.$ligneUtilisateur['second_name'] ?></summary>
			<form method="post">
				<label for="first_name">Prénom:</label>
				<input type="text" placeholder="<?php echo $ligneUtilisateur['first_name']?>"> 
				<label for="second_name">Nom:</label>
				<input type="text" placeholder="<?php echo $ligneUtilisateur['second_name']?>">
				<label for="bureau">Bureau:</label>
				<input type="text" placeholder="<?php echo $ligneUtilisateur['office']?>">
				<input type="text" value="<?php echo $idUser?>" hidden name="idUser">								
				<input type="submit" value="Modifier" name="option">
				<input type="submit" value="Supprimer" name="option">
			</form>
		</details>				

<?php
	}
?>
	
<form method="post">
	<label for="firstName">Prénom:</label>
	<input type="text" placeholder="Prénom de l'employé" name="firstName" required>
	<label for="secondName">Nom:</label>
	<input type="text" placeholder="Nom de l'employé" name="secondName" required>
	<label for="password">Mot de passe:</label>
	<input type="text" placeholder="Mot de passe de l'employé" name="password" required>
	<label for="office">Bureau:</label>
	<input type="text" placeholder="Bureau de l'employé" name="office">
	<label for="isAdmin">Administrateur?:</label>
	<input type="checkbox" id="is_admin" name="isAdmin">
	<input type="submit" value="Ajouter" name="option">
	
	<?php
		//modification de l'employé dans la BDD
		if(isset($_POST["option"])){
			if ($_POST["option"] == "Modifier") {
				$idUser = $_POST['idUser'];
				echo("modification\n");
				modification_employe($idUser, $_POST['first_name'], $_POST['second_name'], $_POST['bureau']);
				echo "<script>alert('Suppression effectuee.')</script>";
			}
			//suppression de l'employé dans la BDD
			elseif ($_POST["option"] == "Supprimer") {
					$idUser = $_POST['idUser'];
					suppression_employe($idUser);
					echo "<script>alert('Suppression effectuee.')</script>";
			} 

			//insertion de l'employé saisi dans la BDD
			elseif ($_POST["option"] == "Ajouter") {  
				if(isset($_POST['isAdmin'])){
					$isAdmin = 1;
				}
				else{
					$isAdmin = 0;
				}

				if($_POST['office'] == "Indefini")
				{
					ajout_employe($_POST['firstName'],$_POST['secondName'],NULL,$_POST['password'],$isAdmin);
				}
				else
				{
					ajout_employe($_POST['firstName'],$_POST['secondName'],$_POST['office'],$_POST['password'],$isAdmin);
				}
			}
		}
	?>
</form> <!-- ajout employe -->


<?php	
	mysqli_close($connexionBDD);
?>
