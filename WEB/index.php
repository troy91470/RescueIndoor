<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But du fichier: 
		Sur ce fichier, on indique ce qu'il se passe lorsqu'on arrive sur notre site Web.
-->

<?php
	require("functions.php");

	if (!isSessionActive()) //S'il n'y a pas de session active, on va sur la page connexion.php
	{
		header('Location: connexion.php');
	} 
	else 
	{
		if($_SESSION['isAdmin'] == 1) //S'il y a une session admin d'active, on va sur la page adminMenu.php
		{
			header('Location: admin/menu.php');
		}
		else //Sinon si c'est une session d'utilisateur 'classique', on va sur la page userMenu.php
		{
			header('Location: user/menu.php');
		}
	}
?>

