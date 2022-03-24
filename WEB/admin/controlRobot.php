<?php
	require("../functions.php");
	
	if (!isSessionActive()) 
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
      // This function connects to the rosbridge server running on the local computer on port 9090
      var rosServer = new ROSLIB.Ros({
          //url : 'ws://192.168.43.7:9090'
          url : 'ws://192.168.43.7:9090'
      });

      // If there is an error on the backend, an 'error' emit will be emitted.
      rosServer.on('error', function(error) {
        document.getElementById('connecting').style.display = 'none';
        document.getElementById('connected').style.display = 'none';
        document.getElementById('closed').style.display = 'none';
        document.getElementById('error').style.display = 'inline';
        console.log(error);
      });

      // Find out exactly when we made a connection.
      rosServer.on('connection', function() {
        console.log('Connection made!');
        document.getElementById('connecting').style.display = 'none';
        document.getElementById('error').style.display = 'none';
        document.getElementById('closed').style.display = 'none';
        document.getElementById('connected').style.display = 'inline';
      });

      rosServer.on('close', function() {
        console.log('Connection closed.');
        document.getElementById('connecting').style.display = 'none';
        document.getElementById('connected').style.display = 'none';
        document.getElementById('closed').style.display = 'inline';
      });


    // These lines create a topic object as defined by roslibjs
    var forwardTopic = new ROSLIB.Topic({
        ros : rosServer,
        name : 'forward',
        messageType : 'std_msgs/Empty'
    });
    var backwardTopic = new ROSLIB.Topic({
        ros : rosServer,
        name : 'backward',
        messageType : 'std_msgs/Empty'
    });
    var rightTopic = new ROSLIB.Topic({
        ros : rosServer,
        name : 'right',
        messageType : 'std_msgs/Empty'
    });
    var leftTopic = new ROSLIB.Topic({
        ros : rosServer,
        name : 'left',
        messageType : 'std_msgs/Empty'
    });
    var stopTopic = new ROSLIB.Topic({
        ros : rosServer,
        name : 'stop',
        messageType : 'std_msgs/Empty'
    });
    var upTopic = new ROSLIB.Topic({
        ros : rosServer,
        name : 'up',
        messageType : 'std_msgs/Empty'
    });
    var downTopic = new ROSLIB.Topic({
        ros : rosServer,
        name : 'down',
        messageType : 'std_msgs/Empty'
    });
    var openTopic = new ROSLIB.Topic({
        ros : rosServer,
        name : 'opendoor',
        messageType : 'std_msgs/Empty'
    });
    var closeTopic = new ROSLIB.Topic({
        ros : rosServer,
        name : 'closedoor',
        messageType : 'std_msgs/Empty'
    });
    var lineFolllower = new ROSLIB.Topic({
        ros : rosServer,
        name : 'linefollow',
        messageType : 'std_msgs/Empty'
    });

    /* This function:
    - retrieves numeric values from the text boxes
    - assigns these values to the appropriate values in the twist message
    - publishes the message to the cmd_vel topic.
    */
    function pubMessage(topic) {
      topic.publish();
    }

    // TEST
		var listeBureaux = new ROSLIB.Topic({
			ros : rosServer,
			name : '/listeTopic',
			messageType : 'std_msgs/String'
		});
		var messageBureaux = new ROSLIB.Message({
      data: "314;315;999;5;456"
    });
		// var messageBureaux2 = new ROSLIB.Message("lucas est dans le binks");
    function testMSG() {
      listeBureaux.publish(messageBureaux);
      // listeBureaux.publish(messageBureaux2);
    }

    </script>

  </head>

  <body>
    <div class="divBoutons">
      <div class="row">
        <div class="colonne10">
          <a href="menu.php">
            <input  class="bouton-top" type="submit" value='retour'>
          </a>
        </div>
        <div class="colonne11">
          <a href="../deconnexion.php">
            <input  class="bouton-top" type="submit" value='Deconnexion'>
          </a>
        </div>
      </div>
    </div>

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
      


      <div class="divCenter">
        <img id="liveStream" src="http://192.168.43.197:8080/stream?topic=/cv_camera/image_raw" />
        
      </div>

      <br>
      </div>

    <div class="divBottom">
      <form >
          <div class="sub-main">
            <input class="bouton" type="submit" value="Avancer"  id="sendMsg"  onclick="pubMessage(forwardTopic)">
          </div>
          <div class="sub-main">
            <input class="bouton" type="submit" value="Reculer"  id="sendMsg"  onclick="pubMessage(backwardTopic)">
          </div>
          <div class="sub-main">
            <input class="bouton" type="submit" value="Stop"  id="sendMsg" style="background:red" onclick="pubMessage(stopTopic)">
          </div>
          <div class="sub-main">
            <input class="bouton" type="submit" value="Gauche"  id="sendMsg"  onclick="pubMessage(leftTopic)">
          </div>
          <div class="sub-main">
            <input class="bouton" type="submit" value="Droite"  id="sendMsg"  onclick="pubMessage(rightTopic)">
          </div>
          <div class="sub-main">
            <input class="bouton" type="submit" value="V+"  id="sendMsg"  onclick="pubMessage(upTopic)">
          </div>
          <div class="sub-main">
            <input class="bouton" type="submit" value="V-"  id="sendMsg"  onclick="pubMessage(downTopic)">
          </div>
          <div class="sub-main">
            <input class="bouton" type="submit" value="Test MSG"  id="sendMsg"  onclick="testMSG()">
          </div>
          <div class="sub-main">
            <input class="bouton" type="submit" value="Ouverture"  id="sendMsg"  onclick="pubMessage(openTopic)">
          </div>
          <div class="sub-main">
            <input class="bouton" type="submit" value="Fermeture"  id="sendMsg"  onclick="pubMessage(closeTopic)">
          </div>
          <div class="sub-main">
            <input class="bouton" type="submit" value="lineFolllower"  id="sendMsg"  onclick="pubMessage(lineFolllower)">
          </div>
      </form>
    </div>
  </body>
</html>

 