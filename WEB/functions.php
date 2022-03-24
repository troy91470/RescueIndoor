<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But du fichier: 
		Ce fichier comporte diverses fonctions. 
-->


<?php

    //Fonction renvoyant le booléen vrai si la session de l'utilisateur est active, et faux sinon
    function isSessionActive()
    {
        session_start();
        if (isset($_SESSION['count'])) return TRUE;
        else {
            session_destroy();
            session_unset();
            return FALSE;
        }
    }


    //Fonction renvoyant la connexion à la base de données
    function connexionBDD(){
        require("logs.php");

        $lsConnexionBDD = new mysqli($gwServername, $gwUsername, $gwPassword); //variable permettant d'avoir la connexion au serveur SQL
        mysqli_select_db($lsConnexionBDD, $gwDatabaseName);

        // Vérifier la connexion
        if($lsConnexionBDD -> connect_error) 
        {
            die("Connection failed: " . $lsConnexionBDD -> connect_error);
        }
        else
        {
            //S'il n'y a pas d'erreur à la connexion, on peut continuer normalement
        }

        return $lsConnexionBDD;
    }


    //Fonction supprimant l'employé dans la BDD grâce à son id
    function deleteEmployee($pnIdUser)
    {
        $lsConnexionBDD = connexionBDD(); //variable permettant d'avoir la connexion au serveur SQL
        
        try 
        {
            $requestDeleteEmployee = "DELETE FROM user WHERE id_user=".$pnIdUser; 
            $lsConnexionBDD -> query($requeteDeleteEmployee);
        } 
        catch (Exception $e) 
        {
            echo 'Exception  reçue: ',  $e -> getMessage(), "\n";
        }

        mysqli_close($lsConnexionBDD);
        echo "<script>window.location=window.location;</script>";
    }

function isUserAlreadyExists($email){
    $lsConnexionBDD = connexionBDD();
    $requeteUserExists = "SELECT count(*) FROM user WHERE email='".$email."'";
    $result = $lsConnexionBDD -> query($requeteUserExists);
    $result = $result -> fetch_array();
    return (bool) ($result[0]);
}

function editEmployee($idUser, $email, $first_name, $second_name, $office)
{
    $lsConnexionBDD = connexionBDD(); //variable permettant d'avoir la connexion au serveur SQL

    $emailModif = $email;
    $firstNameModif = $first_name;
    $secondNameModif = $second_name;
    $officeModif = $office;

    if($emailModif == NULL)
    {
        $requeteSelectFirstName = "SELECT email FROM user WHERE id_user='".$idUser."'";
        $emailModif = $lsConnexionBDD -> query($requeteSelectFirstName);
        $emailModif = $emailModif -> fetch_array()[0];
    }
    else
    {
        if(!filter_var($emailModif, FILTER_VALIDATE_EMAIL))
        {
            $emailModif = -1;
            echo "<script>alert('Adresse mail non valide.')</script>";
        }

        $existsAlready = isUserAlreadyExists($emailModif);
        if($existsAlready)
        {
            $emailModif = -1;
            echo "<script>alert('Cette adresse mail est déjà utilisée.')</script>";
        }
    }

    if($firstNameModif == NULL)
    {
        $requeteSelectFirstName = "SELECT first_name FROM user WHERE id_user='".$idUser."'";
        $firstNameModif = $lsConnexionBDD -> query($requeteSelectFirstName);
        $firstNameModif = $firstNameModif -> fetch_array()[0];
    }

    if($secondNameModif == NULL)
    {
        $requeteSelectSecondName = "SELECT second_name FROM user WHERE id_user='".$idUser."'";
        $secondNameModif = $lsConnexionBDD -> query($requeteSelectSecondName);
        $secondNameModif = $secondNameModif -> fetch_array()[0];
    }

    if($officeModif == NULL)
    {
        $requeteSelectOffice = "SELECT office FROM user WHERE id_user='".$idUser."'";
        $officeModif = $lsConnexionBDD -> query($requeteSelectOffice); 
        $officeModif = $officeModif -> fetch_array()[0];
    }

    if($emailModif != -1)
    {    
        $requeteUpdateEmployes = "UPDATE user SET email='".$emailModif."', first_name='".$firstNameModif."', second_name='".$secondNameModif."', office=".$officeModif." WHERE id_user=".$idUser; 	
        $lsConnexionBDD -> query($requeteUpdateEmployes);
        echo "<script>window.location=window.location;</script>";
    }

    mysqli_close($lsConnexionBDD);
}

function addEmployee($email, $first_name, $second_name, $office, $password, $isAdmin)
{
    $lsConnexionBDD = connexionBDD(); //variable permettant d'avoir la connexion au serveur SQL

    $existsAlready = isUserAlreadyExists($email);
    if($existsAlready)
    {
        echo "<script>alert('Cette adresse mail est déjà utilisée.')</script>";
    }
    else if(!filter_var($_POST['emailAjouter'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script>alert('Adresse mail non valide.')</script>";
    }
    else
    {
        $hachedPassword = password_hash($password, PASSWORD_DEFAULT);
        if($office != NULL)
        {
            $requeteInsertEmployes = "INSERT INTO user (first_name,second_name,email,password,office,is_admin) VALUES ('".$first_name."','".$second_name."','".$email."','".$hachedPassword."','".$office."','".$isAdmin."')"; 
        }
        else
        {
            $requeteInsertEmployes = "INSERT INTO user (first_name,second_name,email,password,is_admin) VALUES ('".$first_name."','".$second_name."','".$email."','".$hachedPassword."','".$isAdmin."')"; 	
        }
        
        $lsConnexionBDD -> query($requeteInsertEmployes);
        mysqli_close($lsConnexionBDD);

        echo "<script>window.location=window.location;</script>";
    }
}

function sendRoute($content)
{
    set_include_path(get_include_path() . PATH_SEPARATOR . 'phplibs/phpseclib');
    require('phplibs/phpseclib/Net/SSH2.php');
    require('logs.php');
    echo "<br/>require done<br/>";
    $ssh = new Net_SSH2($ros_ip);
    echo "<br/>connection done";

    if (!$ssh -> login($ros_username, $ros_password)) 
    {
        exit('Login Failed');
    }
    else
    {
        //
    }

    $ssh -> exec("echo 'aaa' > ssh_fonctionne.txt");
    echo "<br/>evrything done";
}

?>