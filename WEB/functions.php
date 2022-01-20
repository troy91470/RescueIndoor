<?php
	require("logs.php");

    function test()
    {
        echo("ok;");
    }

    function bd_connexion(){
        $connexionBDD = new mysqli($servername,$username,$password);
        mysqli_select_db($connexionBDD, $gw_databaseName);
        // Vérifier la connexion
        if($connexionBDD->connect_error) {
            die("Connection failed: " . $connexionBDD->connect_error);
        }
        return $connexionBDD;
    }

    function suppression($first_name, $second_name, $password, $office)
    {
        $connexionBDD = bd_connexion();
    }

    function add_employee($first_name, $second_name, $password, $office)
    {
        echo "TODO";
    }


?>