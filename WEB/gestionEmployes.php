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
	$idLigne=0;
	$users=array();
	while ($ligneUtilisateur = $resultatUtilisateurs -> fetch_assoc()) {
		$idUser = $ligneUtilisateur['id_user'];
		$bureauUtilisateur = NULL;
		
		$requeteBureaux = "SELECT * FROM office";
		$resultatBureaux = $connexionBDD -> query($requeteBureaux);
		while ($ligneBureau = $resultatBureaux -> fetch_assoc()) {
			$idLigne++;
			if($ligneBureau['id_user'] == $ligneUtilisateur['id_user']) {
				$bureauUtilisateur = $ligneBureau['label'];
			}
			$users[$idLigne] = array($ligneUtilisateur['first_name'], $ligneUtilisateur['second_name'], $ligneUtilisateur['password']);
		}

?>
		
<details>
	<summary><?php echo $ligneUtilisateur['first_name'].'  '.$ligneUtilisateur['second_name'] ?></summary>
	<form method="post">
		<label for="first_name">Prénom:</label>
		<input type="text" placeholder="<?php echo $ligneUtilisateur['first_name']?>"> 
		<label for="second_name">Nom:</label>
		<input type="text" placeholder="<?php echo $ligneUtilisateur['second_name']?>">
		<label for="bureau">Bureau:</label>
		<select>
		<?php
			$requeteSelectOffice = "SELECT * FROM office";
			$resultatOffice = $connexionBDD -> query($requeteSelectOffice);
			while ($ligneOffice = $resultatOffice -> fetch_assoc()) {
				if($ligneOffice['label'] == $bureauUtilisateur){
					echo $bureauUtilisateur;
					echo "<option value='".$ligneOffice['label']."' selected>".$ligneOffice['label']."</option>";
				}
				else{
					echo "<option value='".$ligneOffice['label']."'>".$ligneOffice['label']."</option>";
				}
			}
		?>
		</select>
		<input type="text" value="<?php echo $idLigne?>" disabled hidden name="idLine">								
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
	<label for="office">Bureau:</label>
	<select>
		<?php
			$requeteSelectOffice = "SELECT * FROM office";
			$resultatOffice = $connexionBDD -> query($requeteSelectOffice);
			while ($ligneOffice = $resultatOffice -> fetch_assoc()) {
				echo "<option value='".$ligneOffice['label']."'>".$ligneOffice['label']."</option>";
			}
		?>
	</select>
	<label for="password">Mot de passe:</label>
	<input type="text" placeholder="Mot de passe de l'employé" name="password" required>
	<label for="isAdmin">Administrateur?:</label>
	<input type="checkbox" id="is_admin" name="isAdmin" checked>
	<input type="submit" value="Ajouter" name="option">
	
	<?php
		//modification de l'employé dans la BDD
		if(isset($_POST["option"])){
			if ($_POST["option"] == "Modifier") {
				echo("modification\n");
				modification_employe($users[$_POST['idLine']][0], $users[$_POST['idLine']][1], $users[$_POST['idLine']][1], "312");
				echo "<script>alert(\"Suppression effectuee.\")</script>";
			} 

			//suppression de l'employé dans la BDD
			elseif ($_POST["option"] == "Supprimer") {
					$test = $users[$_POST['idLine']][0];
					$test = $_POST['idLine'];
					echo("suppression |$test|");
					suppression_employe($users[$_POST['idLine']][0], $users[$_POST['idLine']][1], $users[$_POST['idLine']][2], "312");
					echo "<script>alert(\"Suppression effectuee.\")</script>";
			} 

			//insertion de l'employé saisi dans la BDD
			elseif ($_POST["option"] == "Ajouter") {   
				/////VERIFIER QUE LE BUREAU N'EST PAS DEJA OCCUPE -> SINON DEMANDE SI ON DEGAGE L'AUTRE
					
				$requeteSelectSamePerson = "SELECT count(*) FROM user WHERE first_name='".$_POST['firstName']."' and second_name='".$_POST['secondName']."'";
				$result = $connexionBDD -> query($requeteSelectSamePerson);
				$result = $result -> fetch_array();
				$existsAlready = (bool) ($result[0]);
				if($existsAlready){
					echo "<script>alert(\"Cette personne existe déjà dans la base de donnée.\")</script>";
				}
				else{
					if(isset($_POST['isAdmin'])){
						$isAdmin = 1; 
					}
					else{
						$isAdmin = 0;
					}
					$requeteInsertEmployes = "INSERT INTO user (first_name,second_name,password,is_admin) VALUES ('".$_POST['firstName']."','".$_POST['secondName']."','".$_POST['password']."',".$isAdmin.")"; 	
					$connexionBDD -> query($requeteInsertEmployes);
					
					//éventuelle insertion de l'employé à un bureau dans la BDD
					if(isset($_POST['office']) && !empty($_POST['office'])){
						$requeteSelectIdEmployee = "SELECT id_user FROM user WHERE first_name='".$_POST['firstName']."' and second_name='".$_POST['secondName']."' and password='".$_POST['password']."'"; 	
						$result = $connexionBDD -> query($requeteSelectIdEmployee);
						$result = $result -> fetch_array();
						$idUser = intval($result[0]);
						$requeteInsertEmployesForOffice = "INSERT INTO office(id_user) VALUES ('".$idUser."')"; 	
						$connexionBDD -> query($requeteInsertEmployesForOffice);
					}
					
					if(!headers_sent()){
						exit(header("Refresh:0"));
					}
				}
			}
		}
	?>
</form> <!-- ajout employe -->


<?php	
	mysqli_close($connexionBDD);
?>
