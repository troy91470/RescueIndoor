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
    
    mysqli_close();
}


?>