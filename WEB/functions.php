<?php


    function is_session_active()
    {
        session_start();
        if (isset($_SESSION['count'])) return TRUE;
        else {
            session_destroy();
            session_unset();
            return FALSE;
        }
    }

    function connexion_bd(){
        require("logs.php");
        $connexionBDD = new mysqli($servername,$username,$password);
        mysqli_select_db($connexionBDD, $gw_databaseName);
        // Vérifier la connexion
        if($connexionBDD->connect_error) {
            die("Connection failed: " . $connexionBDD->connect_error);
        }
        return $connexionBDD;
    }

    function suppression_employe($idUser)
    {
        $connexionBDD = connexion_bd();
        
        try {
            $requeteDeleteEmployee = "DELETE FROM user WHERE id_user=".$idUser; 	
            $connexionBDD -> query($requeteDeleteEmployee);
        } catch (Exception $e) {
            echo 'Exception  reçue: ',  $e->getMessage(), "\n";
        }

        mysqli_close($connexionBDD);
        echo "<script>window.location=window.location;</script>";
    }

function user_exists_already($email){
    $connexionBDD = connexion_bd();
    $requeteUserExists = "SELECT count(*) FROM user WHERE email='".$email."'";
    $result = $connexionBDD -> query($requeteUserExists);
    $result = $result -> fetch_array();
    return (bool) ($result[0]);
}

function modification_employe($idUser, $email, $first_name, $second_name, $office)
{
    $connexionBDD = connexion_bd();

    $emailModif = $email;
    $firstNameModif = $first_name;
    $secondNameModif = $second_name;
    $officeModif = $office;

    if($emailModif == NULL)
    {
        $requeteSelectFirstName = "SELECT email FROM user WHERE id_user='".$idUser."'";
        $emailModif = $connexionBDD -> query($requeteSelectFirstName);
        $emailModif = $emailModif -> fetch_array()[0];
    }
    else
    {
        if(!filter_var($emailModif, FILTER_VALIDATE_EMAIL)){
            $emailModif = -1;
            echo "<script>alert('Adresse mail non valide.')</script>";
        }

        $existsAlready = user_exists_already($emailModif);
        if($existsAlready){
            $emailModif = -1;
            echo "<script>alert('Cette adresse mail est déjà utilisée.')</script>";
        }
    }

    if($firstNameModif == NULL)
    {
        $requeteSelectFirstName = "SELECT first_name FROM user WHERE id_user='".$idUser."'";
        $firstNameModif = $connexionBDD -> query($requeteSelectFirstName);
        $firstNameModif = $firstNameModif -> fetch_array()[0];
    }
    if($secondNameModif == NULL)
    {
        $requeteSelectSecondName = "SELECT second_name FROM user WHERE id_user='".$idUser."'";
        $secondNameModif = $connexionBDD -> query($requeteSelectSecondName);
        $secondNameModif = $secondNameModif -> fetch_array()[0];
    }
    if($officeModif == NULL)
    {
        $requeteSelectOffice = "SELECT office FROM user WHERE id_user='".$idUser."'";
        $officeModif = $connexionBDD -> query($requeteSelectOffice); 
        $officeModif = $officeModif -> fetch_array()[0];
    }

    if($emailModif != -1)
    {    
        $requeteUpdateEmployes = "UPDATE user SET email='".$emailModif."', first_name='".$firstNameModif."', second_name='".$secondNameModif."', office=".$officeModif." WHERE id_user=".$idUser; 	
        $connexionBDD -> query($requeteUpdateEmployes);
        echo "<script>window.location=window.location;</script>";
    }

    mysqli_close($connexionBDD);
}

function ajout_employe($email, $first_name, $second_name, $office, $password, $isAdmin)
{
    $connexionBDD = connexion_bd();

    //TODO -> test mail

    $existsAlready = user_exists_already($email);
    if($existsAlready){
        echo "<script>alert('Cette adresse mail est déjà utilisée.')</script>";
    }
    else if(!filter_var($_POST['emailAjouter'], FILTER_VALIDATE_EMAIL)){
        echo "<script>alert('Adresse mail non valide.')</script>";
    }
    else{
        $hachedPassword = password_hash($password, PASSWORD_DEFAULT);
        if($office != NULL)
        {
            $requeteInsertEmployes = "INSERT INTO user (first_name,second_name,email,password,office,is_admin) VALUES ('".$first_name."','".$second_name."','".$email."','".$hachedPassword."','".$office."','".$isAdmin."')"; 
        }
        else
        {
            $requeteInsertEmployes = "INSERT INTO user (first_name,second_name,email,password,is_admin) VALUES ('".$first_name."','".$second_name."','".$email."','".$hachedPassword."','".$isAdmin."')"; 	
        }
        
        $connexionBDD -> query($requeteInsertEmployes);
        mysqli_close($connexionBDD);

        echo "<script>window.location=window.location;</script>";
    }
}

function send_route($content){
    set_include_path(get_include_path() . PATH_SEPARATOR . 'phplibs/phpseclib');
    require('phplibs/phpseclib/Net/SSH2.php');
    require('logs.php');
    echo "<br/>require done<br/>";
    $ssh = new Net_SSH2($ros_ip);
    echo "<br/>connection done";

    if (!$ssh->login($ros_username, $ros_password)) {
        exit('Login Failed');
    }

    $ssh->exec("echo 'aaa' > ssh_fonctionne.txt");
    echo "<br/>evrything done";

/*
echo "route donnng";
$connection = ssh2_connect('192.168.43.7', 22);
$o = shell_exec("pwd");
echo "<br/>oui: $o<br/>";
ssh2_auth_password($connection, 'pi', 'raspberry');

ssh2_scp_send($connection, './deliveryRoute.txt', '/home/pi', 0664);
echo "faim pizza burger manger";
*/
}

?>