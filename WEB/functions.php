<?php
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
       
        
        $requeteDeleteEmployeeForOffice = "UPDATE office SET id_user=NULL WHERE id_user=".$idUser;
        echo $requeteDeleteEmployeeForOffice;
        $connexionBDD -> query($requeteDeleteEmployeeForOffice);

        $requeteDeleteEmployee = "DELETE FROM user WHERE id_user=".$idUser; 	
        echo $requeteDeleteEmployee;
        $connexionBDD -> query($requeteDeleteEmployee);


        if(!headers_sent()){
           exit(header("Refresh:0"));
        }

        mysqli_close($connexionBDD);
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
    $existsAlready = verification_same_person($first_name, $second_name);
    if($existsAlready){
        echo "<script>alert(\"Cette personne existe déjà dans la base de donnée.\")</script>";
    }
    else{
        echo "ça passe !";
    }
    mysqli_close();
}

function ajout_employe($idUser, $first_name, $second_name, $office, $isAdmin)
{
    $existsAlready = verification_same_person($first_name, $second_name);
    if($existsAlready){
        echo "<script>alert('Cette personne existe déjà dans la base de donnée.')</script>";
        mysqli_close();
    }
    else{
        $hachedPassword = password_hash($password, PASSWORD_DEFAULT);
        $requeteInsertEmployes = "INSERT INTO user (first_name,second_name,password,is_admin) VALUES ('".$first_name."','".$second_name."','".$hachedPassword."',".$isAdmin.")"; 	
        $connexionBDD -> query($requeteInsertEmployes);
        
        //éventuelle insertion de l'employé à un bureau dans la BDD
        if(!empty($office)){
            $requeteSelectIdEmployee = "SELECT id_user FROM user WHERE first_name='".$first_name."' and second_name='".$second_name;
            while ($ligneUtilisateur = $requeteSelectIdEmployee -> fetch_assoc()) {
                if (password_verify($password, $ligneUtilisateur['password'])) {
                    $idUser = intval($ligneUtilisateur['id_user']);
                    $requeteInsertEmployesForOffice = "INSERT INTO office(id_user) VALUES ('".$idUser."')"; 	
                    $connexionBDD -> query($requeteInsertEmployesForOffice);
                }
            }
        }
        mysqli_close();
        if(!headers_sent()){
            exit(header("Refresh:0"));
        }
    }
}

function fill_file_route($listOffices){
    $filename = 'deliveryRoute.txt';

    if (is_writable($filename)) {
        // verification existence
        if (!$fp = fopen($filename, 'w')) {
            echo "Impossible d'ouvrir le fichier ($filename)";
            exit;
        }

        // verification ecriture
        if (fwrite($fp, $listOffices) === FALSE) {
            echo "Impossible d'écrire dans le fichier ($filename)";
            exit;
        }
        // fermeture du fichier
        fclose($fp);
    } else {
        echo "Le fichier $filename n'est pas accessible en écriture.";
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