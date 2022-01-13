<?php
	//Les informations de la BDD
	session_start();
	include("logs.php");
?>

<table>
		<!-- <thead>
			<tr>
				<th>Prénom de l'employé</th>
				<th>Nom de l'employé</th>
				<th>Bureau de l'employé</th>
			</tr>
		</thead> 
		<tbody> -->
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
					
					<tr>
						<details>
							<summary><?php echo $ligneUtilisateur['first_name'].'  '.$ligneUtilisateur['second_name'] ?></summary>
							<form method="post">
							    <div>
									<label for="first_name">Prénom:</label>
									<input type="text" value="<?php echo $ligneUtilisateur['first_name'] ?> "> 
								</div>
								<div>
									<label for="second_name">Nom:</label>
									<input type="text" value="<?php echo $ligneUtilisateur['second_name'] ?> ">
								</div>
								<div>
									<label for="bureau">Bureau:</label>
									<input type="text" value="<?php echo $bureauUtilisateur ?> ">
								</div>
							</form>
						</details>
					</tr>
					
			<?php	
				}
				mysqli_close($connexionBDD);
			?>
				
			
	</tbody>
</table>



