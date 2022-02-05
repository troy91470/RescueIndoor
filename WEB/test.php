<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reda=looser</title>
</head>
<body>
    
<?php

require("functions.php");
echo "test;";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$officesTest='320;415';

//session_start();

// Example

if ( is_session_active() === FALSE ){
    echo "session is not started !";
} else {
    echo "session is started !";
}
//send_route($officesTest);
?>
<button><a href="deconnexion.php">deco</a></button>
</body>
</html>
