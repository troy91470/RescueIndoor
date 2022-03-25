<!-- 
	Auteurs: Marwane BARAHOUI (IATIC4), Clément ROBIN (IATIC4), et Thomas ROY (IATIC4)

	Nom du projet: Rescue Indoor

	But de la page: 
		Sur cette page, l'administrateur peut visualiser ce que voit la caméra du robot. Il peut aussi contrôler la vitesse, la rotation et l'avancement du robot, et l'ouverture/fermeture de la remorque.
-->


<?php
	require("../functions.php");

  if (!isSessionActive() || $_SESSION['isAdmin'] != 1) 
	{
		header('Location: ../index.php');
	}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />

    <link rel="stylesheet" type="text/css" href="../css/control_ros.css">

    <script src="https://static.robotwebtools.org/EventEmitter2/current/eventemitter2.min.js"></script>
    <script src="http://static.robotwebtools.org/roslibjs/current/roslib.min.js"></script>


    <script>
      // Cette fonction se connecte à la passerelle Ros fonctionnant sur l'ordinateur local sur le port 9090
      var rosServer = new ROSLIB.Ros({
          url : 'ws://192.168.43.7:9090'
      });

      // Cette fonction émet un message d'erreur s'il y a une erreur au niveau du backend
      rosServer.on('error', function(error) {
        document.getElementById('connecting').style.display = 'none';
        document.getElementById('connected').style.display = 'none';
        document.getElementById('closed').style.display = 'none';
        document.getElementById('error').style.display = 'inline';
        console.log(error);
      });

      // Cette fonction trouve le moment exact où la connexion est établie
      rosServer.on('connection', function() {
        console.log('Connection made!');
        document.getElementById('connecting').style.display = 'none';
        document.getElementById('error').style.display = 'none';
        document.getElementById('closed').style.display = 'none';
        document.getElementById('connected').style.display = 'inline';
      });

      // Cette fonction trouve quand la connexion est fermée
      rosServer.on('close', function() {
        console.log('Connection closed.');
        document.getElementById('connecting').style.display = 'none';
        document.getElementById('connected').style.display = 'none';
        document.getElementById('closed').style.display = 'inline';
      });


      // These lines create a topic object as defined by roslibjs:
      // Topic permettant de faire avancer le robot
      var forwardTopic = new ROSLIB.Topic({
          ros : rosServer,
          name : 'forward',
          messageType : 'std_msgs/Empty'
      });

      // Topic permettant de faire reculer le robot
      var backwardTopic = new ROSLIB.Topic({
          ros : rosServer,
          name : 'backward',
          messageType : 'std_msgs/Empty'
      });

      // Topic permettant de faire une rotation droite au robot
      var rightTopic = new ROSLIB.Topic({
          ros : rosServer,
          name : 'right',
          messageType : 'std_msgs/Empty'
      });

      // Topic permettant de faire une rotation gauche au robot
      var leftTopic = new ROSLIB.Topic({
          ros : rosServer,
          name : 'left',
          messageType : 'std_msgs/Empty'
      });

      // Topic permettant d'arrêter le robot
      var stopTopic = new ROSLIB.Topic({
          ros : rosServer,
          name : 'stop',
          messageType : 'std_msgs/Empty'
      });

      // Topic permettant d'accélérer la vitesse de déplacement du robot
      var upTopic = new ROSLIB.Topic({
          ros : rosServer,
          name : 'up',
          messageType : 'std_msgs/Empty'
      });

      // Topic permettant de ralentir la vitesse de déplacement du robot
      var downTopic = new ROSLIB.Topic({
          ros : rosServer,
          name : 'down',
          messageType : 'std_msgs/Empty'
      });

      // Topic permettant d'ouvrir la remorque du robot
      var openTopic = new ROSLIB.Topic({
          ros : rosServer,
          name : 'opendoor',
          messageType : 'std_msgs/Empty'
      });

      // Topic permettant de fermer la remorque du robot
      var closeTopic = new ROSLIB.Topic({
          ros : rosServer,
          name : 'closedoor',
          messageType : 'std_msgs/Empty'
      });

      // Topic permettant d'activer le suivi de ligne du robot
      var lineFollower = new ROSLIB.Topic({
          ros : rosServer,
          name : 'linefollow',
          messageType : 'std_msgs/Empty'
      });

      //Cette fonction publie le topic donné en entrée sur cmd_vel
      function pubMessage(topic) {
        topic.publish();
      }


      // TESTS d'envoi de chaîne de caractères
      var listeBureaux = new ROSLIB.Topic({
        ros : rosServer,
        name : '/listeTopic',
        messageType : 'std_msgs/String'
      });

      var messageBureaux = new ROSLIB.Message({
        data: "314;315;999;5;456"
      });

      function testMSG() {
        listeBureaux.publish(messageBureaux);
      }

    </script>
  </head>


  <body>
    <div class="divBoutons">
      <div class="row">

        <!-- Bouton de retour au menu -->
        <div class="colonne10">
          <a href="menu.php">
            <input  class="bouton-top" type="submit" value='retour'>
          </a>
        </div>

        <!-- Bouton de deconnexion -->
        <div class="colonne11">
          <a href="../deconnexion.php">
            <input  class="bouton-top" type="submit" value='Deconnexion'>
          </a>
        </div>

      </div>
    </div>

     <!-- Inidique l'état de la connexion à la passerelle Ros -->
    <div class="divTop">
      <div id="statusIndicator">
        <p id="connecting">
          Connecting to rosbridge...
        </p>
        <p id="connected" style="color:#00D600; display:none">
          Connected
        </p>
        <p id="error" style="color:#FF0000; display:none">
          Error in the backend!
        </p>
        <p id="closed" style="display:none">
          Connection closed.
        </p>
      </div>
      

      <!-- Live affichant ce que voit la caméra du robot -->
      <div class="divCenter">
        <img id="liveStream" src="http://192.168.43.197:8080/stream?topic=/cv_camera/image_raw" /> 
      </div>

      <br>
      </div>

    <div class="divBottom">
      <form >
          <!-- Bouton permettant de faire avancer le robot -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="Avancer"  id="sendMsg"  onclick="pubMessage(forwardTopic)">
          </div>

         <!-- Bouton permettant de faire reculer le robot -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="Reculer"  id="sendMsg"  onclick="pubMessage(backwardTopic)">
          </div>

          <!-- Bouton permettant d'arrêter le robot -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="Stop"  id="sendMsg" style="background:red" onclick="pubMessage(stopTopic)">
          </div>

           <!-- Bouton permettant de faire une rotation gauche au robot -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="Gauche"  id="sendMsg"  onclick="pubMessage(leftTopic)">
          </div>

          <!-- Bouton permettant de faire une rotation droite au robot -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="Droite"  id="sendMsg"  onclick="pubMessage(rightTopic)">
          </div>

          <!-- Bouton permettant d'augmenter la vitesse de déplacement le robot -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="V+"  id="sendMsg"  onclick="pubMessage(upTopic)">
          </div>

          <!-- Bouton permettant de diminuer la vitesse de déplacement le robot -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="V-"  id="sendMsg"  onclick="pubMessage(downTopic)">
          </div>

          <!-- Bouton permettant d'envoyer un message test -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="Test MSG"  id="sendMsg"  onclick="testMSG()">
          </div>

          <!-- Bouton permettant d'ouvrir la remorque du robot -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="Ouverture"  id="sendMsg"  onclick="pubMessage(openTopic)">
          </div>

          <!-- Bouton permettant de fermer la remorque du robot -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="Fermeture"  id="sendMsg"  onclick="pubMessage(closeTopic)">
          </div>

           <!-- Bouton permettant d'activer le suivi de ligne du robot -->
          <div class="sub-main">
            <input class="bouton" type="submit" value="lineFollower"  id="sendMsg"  onclick="pubMessage(lineFollower)">
          </div>

      </form>
    </div>
  </body>
</html>

 