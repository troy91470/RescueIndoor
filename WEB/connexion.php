
<?php
	//Les informations de la BDD
	session_start();
    include("logs.php");
?>

<form method='post'>
	<label>Prénom</label>
	<input type="text" placeholder="Entrer le prénom" name="first_name" required><br>

	<label>Nom</label>
	<input type="text" placeholder="Entrer le nom" name="second_name" required> <br>

	<label>Mot de passe</label>
	<input type="password" placeholder="Entrer le mot de passe" name="password" required>

	<input type="submit" id='submit' value='LOGIN'>

	<?php
		// Connexion à la BDDs 
		$connexionBDD = new mysqli($servername,$username,$password);
		mysqli_select_db($connexionBDD, $gw_databaseName);


		// Vérifier la connexion
		if($connexionBDD->connect_error) {
			die("Connection failed: " . $connexionBDD->connect_error);
		}

		if(isset($_POST['first_name']) && isset($_POST['second_name']) && isset($_POST['password']) && !empty($_POST['first_name']) && !empty($_POST['second_name']) && !empty($_POST['password']) ) {
			$first_name = $_POST['first_name'];
			$second_name = $_POST['second_name'];
			$sql = "SELECT * FROM utilisateurs WHERE first_name='$first_name' AND second_name='$second_name' AND password='$password'";
			$result = mysqli_query($connexionBDD,$sql);
			$total = mysqli_num_rows($result);
			echo(mysqli_error(($connexionBDD)));
			if ($total!=0) {
				echo("<br/>connexion reussie");
				$_SESSION[$first_name]=$first_name;
				$_SESSION[$second_name]=$second_name;
				header('Location: listeEmployes.php');
			} else {
				echo("<br/>identifiants incorrects");
			}
		}
		mysqli_close($connexionBDD);
	?>
</form>


