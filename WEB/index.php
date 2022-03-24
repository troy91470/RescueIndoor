<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But du fichier: 
		Sur......................
-->

<?php
	require("functions.php");

	$afficher_erreurs = TRUE;

	if ($afficher_erreurs) 
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

	if (!isSessionActive()) 
	{
		header('Location: connexion.php');
	} 
	else 
	{
		header('Location: menu.php');
	}
?>

