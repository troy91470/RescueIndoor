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
    return $connexionBDD;
}

function suppression($first_name, $second_name, $password, $office)
{
    
}


?>