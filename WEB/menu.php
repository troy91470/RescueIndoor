<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!--  a changer -->	
	<link rel="icon" type="image/png" href="images/icons/menu.ico"/>


<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/menu.css">
<!--===============================================================================================-->

</head>
<body>
    <div class="container">
        <form method='post' class="oui">
            <div class="container-bouton">
                <input  class="bouton" type="submit" id='admin' value='Admin'>
            </div>
            <div class="container-bouton">
                <input  class="bouton" type="submit" id='livraison' value='Livraison'>
            </div>
            <div class="container-bouton">
                <input  class="bouton" type="submit" id='gestion' value='Gestion'>
            </div>
        </form>
    </div>
</body>

<?php
    /*switch($_POST['action_button']) {
        case 'admin' :
            header('Location: listeEmployes.php');
        break;
        case 'livraison':
            header('Location: listeEmployes.php');
        break;
        case 'gestion' :
            header('Location: listeEmployes.php');
        break;
        default:
            //no option selected ?
    } 
    if($_POST['Admin']) {

    }
    if($_POST['Livraison']) {
        header('Location: listeEmployes.php');
        
    }
    if($_POST['Gestion']) {
        
    }*/

?>
</html>