<?php


function test()
{
    echo("ok;");
}

	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$gw_databaseName = 'appliprojetinterfiliere';

function bd_connexion(){
    require("logs.php");
    $connexionBDD = new mysqli($servername,$username,$password);
    mysqli_select_db($connexionBDD, $gw_databaseName);
    // Vérifier la connexion
    if($connexionBDD->connect_error) {
        die("Connection failed: " . $connexionBDD->connect_error);
    }
    return $connexionBDD;
}

function suppression_employe($first_name, $second_name, $password, $office)
{
    $connexionBDD = bd_connexion();
    echo "fn: $first_name, sn: $second_name , pswd: $password";
    mysqli_close();
}

function verification_same_person($first_name, $second_name){
    $connexionBDD = bd_connexion();
    $requeteSelectSamePerson = "SELECT count(*) FROM user WHERE first_name='".$first_name."' and second_name='".$second_name."'";
    $result = $connexionBDD -> query($requeteSelectSamePerson);
    $result = $result -> fetch_array();
    return (bool) ($result[0]);
}

function modification_employe($first_name, $second_name, $password, $office)
{
    $existsAlready = verification_same_person($first_name, $second_name);
    if($existsAlready){
        echo "<script>alert(\"Cette personne existe déjà dans la base de donnée.\")</script>";
    }
    else{
        echo "ça passe !";
    }
    mysqli_close();
}

?>