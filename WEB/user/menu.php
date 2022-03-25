<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), Clément ROBIN (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But de la page: 
		Sur cette page, l'utilisateur peut choisir d'aller sur la page de livraison, de gestion d'employés, ou de contrôle du robot. L'utilisateur peut aussi se déconnecter.
-->


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Utilisateur - Livraison</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="../images/icons/menu.ico"/>
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../css/userMenu.css">
    <!--===============================================================================================-->
    </head>

    <body>
        <!-- Bouton de deconnexion -->
        <a href="../deconnexion.php">
            <input  class="deconnexion" type="submit" value='Deconnexion'>
        </a>
        <img class="image2" src="../images/icon-user.png" alt="IMG">

        <div class="message">
                    Votre compte est bien enregistré dans le service de livraison.
                    <br>
                    <br>
                    Il y a 2 cas possibles :
                    <br>
                    - Vous venez de recevoir un mail pour vous indiquez que vous avez 5 minutes pour récupérer votre colis devant votre bureau.
                    <br>
                    - Vous n'avons pas de livraison programmer pour le moment.
                    <br>
                    <br> <br> <br>
                    <div class="remarque">   
                        Remarque : Si vous avez manquez la livraison de votre colis, vous pouvez venir le chercher plus tard au bureau de l'administrateur selon ses horaires.
                    </div>
                    <br>
            <img class="image1" src="../images/logoIsty.png" alt="IMG">
        </div>
    </body>
</html>