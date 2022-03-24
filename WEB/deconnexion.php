<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But du fichier: 
		Appelé pour déconnecter l'utilisateur (enlève les sessions de ce dernier et le redirige à la page de connexion)
-->

<?php
	session_start();
	session_destroy();
	session_unset();
	header('Location: index.php');
?>