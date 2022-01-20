<?php
	//Les informations de la BDD
	session_start();
	include("logs.php");
	include("functions.php");
?>


			<?php	
				// Connexion à la BDDs 
				$connexionBDD = new mysqli($servername,$username,$password);
				mysqli_select_db($connexionBDD, $gw_databaseName);


				// Vérifier la connexion
				if($connexionBDD->connect_error) {
					die("Connection failed: " . $connexionBDD->connect_error);
				}
								
				$requeteUtilisateurs = "SELECT * FROM utilisateurs";
				$resultatUtilisateurs = $connexionBDD -> query($requeteUtilisateurs);
				while ($ligneUtilisateur = $resultatUtilisateurs -> fetch_assoc()) {
					$bureauUtilisateur = NULL;
					
					$requeteBureaux = "SELECT * FROM bureau";
					$resultatBureaux = $connexionBDD -> query($requeteBureaux);
					while ($ligneBureau = $resultatBureaux -> fetch_assoc()) {
						if($ligneBureau['Id'] == $ligneUtilisateur['Id']) {
							$bureauUtilisateur = $ligneBureau['label'];
						}
					}

			?>
					
			<details>
				<summary><?php echo $ligneUtilisateur['first_name'].'  '.$ligneUtilisateur['second_name'] ?></summary>
				<form method="post">
					<label for="first_name">Prénom:</label>
					<input type="text" value="<?php echo $ligneUtilisateur['first_name']?> "> 
					<label for="second_name">Nom:</label>
					<input type="text" value="<?php echo $ligneUtilisateur['second_name']?> ">
					<label for="bureau">Bureau:</label>
					<input type="text" value="<?php echo $bureauUtilisateur?> ">								
					<input type="submit" value="Modifier" name="option">
					<input type="submit" value="Supprimer" name="option">
				</form>
			</details>				
					
			<?php
				}
			?>
				
			<form method="post">
				<label for="first_name">Prénom:</label>
				<input type="text" placeholder="Prénom de l'employé" name="first_name" required>
				<label for="second_name">Nom:</label>
				<input type="text" placeholder="Nom de l'employé" name="second_name" required>
				<label for="bureau">Bureau:</label>
				<input type="number" placeholder="Bureau de l'employé" name="office">
				<label for="second_name">Mot de passe:</label>
				<input type="text" placeholder="Mot de passe de l'employé" name="password" required>
				<label for="second_name">Administrateur?:</label>
				<input type="checkbox" id="is_admin" name="is_admin" checked>
				<input type="submit" value="Ajouter" name="option">
				
				<?php
					//modification de l'employé dans la BDD
					if(isset($_POST["option"])){
						if ($_POST["option"] == "Modifier") {
							echo("modification\n");
						} 

						//suppression de l'employé dans la BDD
						elseif ($_POST["option"] == "Supprimer") {   
							echo("suppression\n");
							if(isset($_POST['first_name']) && isset($_POST['second_name']) && isset($_POST['office']) && isset($_POST['password']) && !empty($_POST['first_name'])) {
								suppression($_POST['first_name'], $_POST['second_name'], $_POST['password'], $_POST['office']);
								echo "<script>alert(\"Suppression effectuee.\")</script>";
							}
						} 

						//insertion de l'employé saisi dans la BDD
						elseif ($_POST["option"] == "Ajouter") {   
							if(isset($_POST['first_name']) && isset($_POST['second_name']) && isset($_POST['office']) && isset($_POST['password']) && !empty($_POST['first_name'])) {
								
								if(isset($_POST['is_admin'])){
									$is_admin = 1; 
								}
								else{
									$is_admin = 0;
								}
								$requeteInsertEmployes = "INSERT INTO utilisateurs (first_name,second_name,password,is_admin) VALUES ('".$_POST['first_name']."','".$_POST['second_name']."','".$_POST['password']."',".$is_admin.")"; 	
								$connexionBDD -> query($requeteInsertEmployes);
								
								if(isset($_POST['office']) && !empty($_POST['office'])){
									$requeteSelectIdEmployee = "SELECT id FROM utilisateurs WHERE first_name='".$_POST['first_name']."' and second_name='".$_POST['second_name']."' and password='".$_POST['password']."'"; 	
									$result = $connexionBDD -> query($requeteSelectIdEmployee);
									$result = $result -> fetch_array();
									$id_user = intval($result[0]);
									//$requeteInsertEmployesForOffice = "INSERT INTO offices (id_utilisateur) VALUES ('".$id_user."')"; 	
									//$connexionBDD -> query($requeteInsertEmployesForOffice);
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
