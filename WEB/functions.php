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
        header("Refresh:0");        
    }

function verification_same_person($first_name, $second_name){
    $connexionBDD = connexion_bd();
    $requeteSelectSamePerson = "SELECT count(*) FROM user WHERE first_name='".$first_name."' and second_name='".$second_name."'";
    $result = $connexionBDD -> query($requeteSelectSamePerson);
    $result = $result -> fetch_array();
    return (bool) ($result[0]);
}

function modification_employe($idUser, $first_name, $second_name, $office)
{
    $connexionBDD = connexion_bd();

    $firstNameModif = $first_name;
    $secondNameModif = $second_name;
    $officeModif = $office;

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

    $requeteUpdateEmployes = "UPDATE user SET first_name='".$firstNameModif."', second_name='".$secondNameModif."', office=".$officeModif." WHERE id_user=".$idUser; 	
    $connexionBDD -> query($requeteUpdateEmployes);

    mysqli_close($connexionBDD);
    header("Refresh:0");
}

function ajout_employe($first_name, $second_name, $office, $password, $isAdmin)
{
    $connexionBDD = connexion_bd();

    $existsAlready = verification_same_person($first_name, $second_name);
    if($existsAlready){
        echo "<script>alert('Cette personne existe déjà dans la base de donnée.')</script>";
    }
    else{
        $hachedPassword = password_hash($password, PASSWORD_DEFAULT);
        if($office != NULL)
            $requeteInsertEmployes = "INSERT INTO user (first_name,second_name,password,office,is_admin) VALUES ('".$first_name."','".$second_name."','".$hachedPassword."','".$office."',".$isAdmin.")"; 	
        else
            $requeteInsertEmployes = "INSERT INTO user (first_name,second_name,password,is_admin) VALUES ('".$first_name."','".$second_name."','".$hachedPassword."','".$isAdmin.")"; 	
        
        $connexionBDD -> query($requeteInsertEmployes);
        mysqli_close($connexionBDD);

        header("Refresh:0");
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