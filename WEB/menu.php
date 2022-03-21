<?php
	require("functions.php");
	if (!is_session_active()) {
		header('Location: index.php');
	}	
    require("logs.php");
?>

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
                <input  class="bouton" type="submit" name="Redirection" value="Admin">
            </div>
            <div class="container-bouton">
                <input  class="bouton" type="submit" name="Redirection" value="Livraison">
            </div>
            <div class="container-bouton">
                <input  class="bouton" type="submit" name="Redirection" value="Gestion">
            </div>
        </form>
    </div>
</body>

<?php
    if(isset($_POST["Redirection"])){
        if ($_POST["Redirection"] == "Admin") {
            header('Location: ros_test.html');
        }
        if ($_POST["Redirection"] == "Livraison") {         
            header('Location: listeEmployes.php');
        }        
        if ($_POST["Redirection"] == "Gestion") {         
            header('Location: gestionEmployes.php');
        }
    } 


?>
</html>