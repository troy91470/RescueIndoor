<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), Clément ROBIN (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But de la page: 
		Sur cette page, l'administrateur peut 
-->

<?php
require("../functions.php");
if (!isSessionActive() || $_SESSION['isAdmin'] != 1) 
{
    header('Location: ../index.php');
}
?>

<html>
    <head>
        <title>Générateur QR code</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript">
            function generateBarCode()
            {
                var nric = $('#text').val();
                var url = 'https://api.qrserver.com/v1/create-qr-code/?data=' + nric + '&amp;size=50x50';
                $('#barcode').attr('src', url);
                $('#barcode').attr('title', nric);
            }
        </script>
        <link rel="stylesheet" type="text/css" href="../css/qrcode.css">
        <link rel="icon" type="image/png" href="../images/icons/qrcode.ico"/>
    </head>
    <body> 
        <div class="row">

            <!-- Bouton de retour au menu -->
            <div class="colonne10">
                <a href="menu.php">
                    <input  class="bouton-top" type="submit" value='retour'>
                </a>
            </div>

            <!-- Bouton de déconnexion -->
            <div class="colonne11">
                <a href="../deconnexion.php">
                    <input  class="bouton-top" type="submit" value='Deconnexion'>
                </a>
            </div>
        </div>

        <div class="titre">Génération de QRcode</div>
        <div class="reste">
            <!--zone de saisie du numero de bureau -->
            <input class="saisie" id="text" type="text" style="Width:20%" value="Numéro de bureau"  onkeypress='generateBarCode();' onblur='generateBarCode();'/> 
            <!-- Image du QRcode généré -->
            <img class="qrcode" id='barcode' src="https://api.qrserver.com/v1/create-qr-code/?data=314&amp;size=100x100" alt="" title="qrCode" />
        </div>
    </body>
</html>