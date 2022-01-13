<?php
	//Les informations de la BDD
	session_start();
	include("logs.php");
?>

<table>
		<thead>
			<tr>
				<th>Prénom de l'employé</th>
				<th>Nom de l'employé</th>
				<th>Bureau de l'employé</th>
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

					if($bureauUtilisateur == NULL){
						echo '<tr onclick="ouvrePopup()"><td>'.$ligneUtilisateur['first_name'].'</td><td>'.$ligneUtilisateur['second_name'].'</td><td> NON DEFINI </td></tr>';
					}
					else{
						echo '<tr onclick="ouvrePopup()"><td>'.$ligneUtilisateur['first_name'].'</td><td>'.$ligneUtilisateur['second_name'].'</td><td>'.$bureauUtilisateur.'</td></tr>';
					}
				}				
				
				mysqli_close($connexionBDD);
			?>
	</tbody>
</table>

<form method="post" action="">


<form>


<script type="text/javascript">
	function ouvrePopup()
	{
		window.open("about:blank", "hello", "width=200,height=200");	
	}
</script>

