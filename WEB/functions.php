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
        if (isset($_SESSION['count']))
        {
            return TRUE;
        }
        else 
        {
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


    //Fonction renvoyant le booléen vrai si l'email donné en paramètre existe déjà dans la BDD, sinon la fonction renvoie faux
    function isEmailAlreadyExists($pwEmail)
    {
        $lsConnexionBDD = connexionBDD(); //variable permettant d'avoir la connexion au serveur SQL
        $lsRequestEmailExists = "SELECT count(*) FROM user WHERE email='".$pwEmail."'"; //requête comptant le nombre de fois où l'email spécifié est dans la BDD (est censé être 0 ou 1)
        $lsResult = $lsConnexionBDD -> query($lsRequestEmailExists); //résultat de la requête lsRequestEmailExists
        $lsResult = $lsResult -> fetch_array();
        return (bool) ($lsResult[0]);
    }


    //Fonction supprimant l'employé dans la BDD grâce à son id
    function deleteEmployee($pnIdUser)
    {
        $lsConnexionBDD = connexionBDD(); //variable permettant d'avoir la connexion au serveur SQL

        try 
        {
            if($_SESSION['idUser'] == $pnIdUser) //si l'administrateur essaie de se supprimer lui-même, une confirmation lui est proposée
            {  
                echo 
                "<script>
                    if(window.confirm('Voulez-vous vraiment supprimer votre compte ?'))
                    {
                        var lbIsToDeletedMyselfJS = 1;
                    }
                    else
                    {
                        var lbIsToDeletedMyselfJS = 0;
                    }
                </script>";

                $lbIsToDeletedMyselfPHP = echo "<script>document.write(lbIsToDeletedMyselfJS)</script>";
                echo $lbIsToDeletedMyselfPHP;
                if($lbIsToDeletedMyselfPHP == "1")
                {
                    echo "<script> alert('enfinnnnnnnnnnnnnnnn');</script>";
                    /*$lsRequestDeleteEmployee = "DELETE FROM user WHERE id_user=".$pnIdUser;  //Requête SQL permettant de supprimer les utilisateurs avec l'id spécifié
                    $lsConnexionBDD -> query($lsRequestDeleteEmployee);
                    mysqli_close($lsConnexionBDD);
                    echo "<script>document.location.href = '../deconnexion.php'</script>";*/
                }
                else
                {
                    echo  "<script> alert('ooooooooooooooooo'); </script>";
                }   
            }
            else
            {
                $lsRequestDeleteEmployee = "DELETE FROM user WHERE id_user=".$pnIdUser;  //Requête SQL permettant de supprimer les utilisateurs avec l'id spécifié
                $lsConnexionBDD -> query($lsRequestDeleteEmployee);
                mysqli_close($lsConnexionBDD);
                echo "<script>window.location=window.location;</script>";  
            }
        } 
        catch (Exception $e) 
        {
            echo 'Exception  reçue: ',  $e -> getMessage(), "\n";
        }

        mysqli_close($lsConnexionBDD);
    }


    //Fonction modifiant éventuellement l'email, le prénom, le nom et le bureau de l'employé identifié par son id
    function editEmployee($pnIdUser, $pwEmail, $pwFirstName, $pwSecondName, $pnOffice)
    {
        $lsConnexionBDD = connexionBDD(); //variable permettant d'avoir la connexion au serveur SQL

        $lwEmail = $pwEmail; //variable qui est dédié à contenir l'email modifié
        $lwFirstName = $pwFirstName;  //variable qui est dédié à contenir le prénom modifié
        $lwSecondName = $pwSecondName;  //variable qui est dédié à contenir le nom modifié
        $lnOffice = $pnOffice; //variable qui est dédié à contenir le bureau modifié

        if($lwEmail == NULL) //si l'email est null, c'est qu'il n'est pas modifié, on récupère donc la valeur qu'il a dans la BDD
        {
            $lsRequestSelectEmail = "SELECT email FROM user WHERE id_user='".$pnIdUser."'"; //Requête SQL permettant de récupérer l'email de l'utilisateur identifié par l'id pnIdUser
            $lwEmail = $lsConnexionBDD -> query($lsRequestSelectEmail);
            $lwEmail = $lwEmail -> fetch_array()[0];
        }
        else
        {
            if(!filter_var($lwEmail, FILTER_VALIDATE_EMAIL)) //si l'email n'a pas le bon format, on met une valeur montrant que l'email est incorrect
            {
                $lwEmail = -1;
                echo "<script>alert('Adresse mail non valide.')</script>";
            }

            $lbEmailAlreadyExists = isEmailAlreadyExists($lwEmail); //Variable qui contient le booléen vrai si l'email existe dans la BDD, sinon renvoie faux
            if($lbEmailAlreadyExists) //si l'email existe déjà, on met une valeur montrant que l'email est incorrect
            {
                $lwEmail = -1;
                echo "<script>alert('Cette adresse mail est déjà utilisée.')</script>";
            }
        }

        if($lwFirstName == NULL) //si le prénom est null, c'est qu'il n'est pas modifié, on récupère donc la valeur qu'il a dans la BDD
        {
            $lsRequestSelectFirstName = "SELECT first_name FROM user WHERE id_user='".$pnIdUser."'"; //Requête SQL permettant de récupérer le prénom de l'utilisateur identifié par l'id pnIdUser
            $lwFirstName = $lsConnexionBDD -> query($lsRequestSelectFirstName);
            $lwFirstName = $lwFirstName -> fetch_array()[0];
        }

        if($lwSecondName == NULL) //si le nom est null, c'est qu'il n'est pas modifié, on récupère donc la valeur qu'il a dans la BDD
        {
            $lsRequestSelectSecondName = "SELECT second_name FROM user WHERE id_user='".$pnIdUser."'"; //Requête SQL permettant de récupérer le nom de l'utilisateur identifié par l'id pnIdUser
            $lwSecondName = $lsConnexionBDD -> query($lsRequestSelectSecondName);
            $lwSecondName = $lwSecondName -> fetch_array()[0];
        }

        if($lnOffice == NULL) //si le bureau est null, c'est qu'il n'est pas modifié, on récupère donc la valeur qu'il a dans la BDD
        {
            $lsRequestSelectOffice = "SELECT office FROM user WHERE id_user='".$pnIdUser."'"; //Requête SQL permettant de récupérer le bureau de l'utilisateur identifié par l'id pnIdUser
            $lnOffice = $lsConnexionBDD -> query($lsRequestSelectOffice); 
            $lnOffice = $lnOffice -> fetch_array()[0];
        }

        if($lwEmail != -1) //si l'email n'est pas incorrect, on modifie les données de l'employé dans la BDD
        {    
            $lsRequestUpdateEmployee = "UPDATE user SET email='".$lwEmail."', first_name='".$lwFirstName."', second_name='".$lwSecondName."', office=".$lnOffice." WHERE id_user=".$pnIdUser;  //Requête SQL permettant modifier les données de l'utilisateur identifié par l'id pnIdUser	
            $lsConnexionBDD -> query($lsRequestUpdateEmployee);
            echo "<script>window.location=window.location;</script>";
        }

        mysqli_close($lsConnexionBDD);
    }


    //Fonction ajoutant un employé à la BDD
    function addEmployee($pwEmail, $pwFirstName, $pwSecondName, $pnOffice, $pwPassword, $pbIsAdmin)
    {
        $lsConnexionBDD = connexionBDD(); //variable permettant d'avoir la connexion au serveur SQL

        $lbEmailAlreadyExists = isEmailAlreadyExists($pwEmail); //Variable qui contient le booléen vrai si l'email existe dans la BDD, sinon renvoie faux

        if($lbEmailAlreadyExists) //si l'email existe déjà dans la BDD
        {
            echo "<script>alert('Cette adresse mail est déjà utilisée.')</script>";
        }
        else if(!filter_var($_POST['emailAjouter'], FILTER_VALIDATE_EMAIL)) //si l'email a un format non valide
        {
            echo "<script>alert('Adresse mail non valide.')</script>";
        }
        else //sinon on crée l'utilisateur
        {
            $lwHachedPassword = password_hash($pwPassword, PASSWORD_DEFAULT); //hache le mot de passe du nouvel utilisateur
            if($pnOffice != NULL)
            {
                $lwRequestInsertEmployee = "INSERT INTO user (first_name,second_name,email,password,office,is_admin) VALUES ('".$pwFirstName."','".$pwSecondName."','".$pwEmail."','".$lwHachedPassword."','".$pnOffice."','".$pbIsAdmin."')"; //insère un nouvel utilisateur avec bureau
            }
            else
            {
                $lwRequestInsertEmployee = "INSERT INTO user (first_name,second_name,email,password,is_admin) VALUES ('".$pwFirstName."','".$pwSecondName."','".$pwEmail."','".$lwHachedPassword."','".$pbIsAdmin."')"; //insère un nouvel utilisateur sans bureau
            }
            
            $lsConnexionBDD -> query($lwRequestInsertEmployee);
            mysqli_close($lsConnexionBDD);

            echo "<script>window.location=window.location;</script>";
        }
    }

?>