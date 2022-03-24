<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), Clément ROBIN (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But de la page: 
		Sur cette page, l'utilisateur peut choisir d'aller sur la page de livraison, de gestion d'employés, ou de contrôle du robot. L'utilisateur peut aussi se déconnecter.
-->


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Menu - Livraison Rescue INDOOR</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="images/icons/menu.ico"/>
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/menu.css">
    <!--===============================================================================================-->
    </head>

    <body>
        	<!-- Bouton de déconnexion -->
            <a href="deconnexion.php">
                <input  class="deconnexion" type="submit" value='Deconnexion'>
            </a>

            <!-- Bouton pour aller sur la page de livraison -->
            <a href="delivery.php" style="text-decoration:none">
                    <input  class="bouton" type="submit" value='Livraison'>
            </a>

            <!-- Bouton pour aller sur la page de gestion d'employés -->
            <a href="managementEmployee.php" style="text-decoration:none">    
                <input class="bouton" type="submit" value='Gestion'>
            </a>

            <!-- Bouton pour aller sur la page de contrôle du robot -->
            <a href="robotControl.html" style="text-decoration:none">
                <input  class="bouton" type="submit" value='Contrôle à distance'>
            </a>
    </body>
</html>