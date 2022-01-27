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

?>