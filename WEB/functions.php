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
        
        try {
            $requeteDeleteEmployeeForOffice = "UPDATE office SET id_user=NULL WHERE id_user=".$idUser;
            $connexionBDD -> query($requeteDeleteEmployeeForOffice);

            $requeteDeleteEmployee = "DELETE FROM user WHERE id_user=".$idUser; 	
            $connexionBDD -> query($requeteDeleteEmployee);
        } catch (Exception $e) {
            echo 'Exception  reçue: ',  $e->getMessage(), "\n";
        }

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

function ajout_employe($first_name, $second_name, $office, $password, $isAdmin)
{
    $connexionBDD = connexion_bd();

    $existsAlready = verification_same_person($first_name, $second_name);
    if($existsAlready){
        echo "<script>alert('Cette personne existe déjà dans la base de donnée.')</script>";
    }
    else{
        $hachedPassword = password_hash($password, PASSWORD_DEFAULT);
        $requeteInsertEmployes = "INSERT INTO user (first_name,second_name,password,is_admin) VALUES ('".$first_name."','".$second_name."','".$hachedPassword."',".$isAdmin.")"; 	
        $connexionBDD -> query($requeteInsertEmployes);
        
        //éventuelle insertion de l'employé à un bureau dans la BDD
        if($office != NULL){
            $requeteSelectIdUser = "SELECT * FROM user WHERE first_name='".$first_name."' and second_name='".$second_name."'";
            $resultatIdUser = $connexionBDD -> query($requeteSelectIdUser);

            while ($ligneUser = $resultatIdUser -> fetch_assoc()) {
                if (password_verify($password, $ligneUser['password'])) {
                    $idUser = $ligneUser['id_user'];

                    $requeteUpdateEmployesForOffice = "UPDATE office SET id_user='".$idUser."' WHERE label='".$office."'";
                    echo $requeteUpdateEmployesForOffice;
                    $connexionBDD -> query($requeteUpdateEmployesForOffice);
                }
            }
           
            
        }
        mysqli_close($connexionBDD);

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
    echo "<br/>require done<br/>";
    $ssh = new Net_SSH2('192.168.43.7');
    echo "<br/>bba";
    if (!$ssh->login('pi', 'raspberry')) {
        exit('Login Failed');
    }
    echo "aa";
    echo $ssh->exec('echo "'.$content.'" > deliveryRoute.txt');

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