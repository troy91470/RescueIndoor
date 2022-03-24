// Lucas Deshayes

#include <ros.h>
#include <std_msgs/Empty.h>
#include <std_msgs/String.h>

ros::NodeHandle  nh;

std_msgs::String OurMotorState;
ros::Publisher Motorstate("state", &OurMotorState);

// Tableaux des messages pour les actions moteurs
char MotorForward[8] = "Forward";
char MotorBackward[9] = "Backward";
char MotorLeft[5] = "Left";
char MotorRight[6] = "Right";
char MotorStop[5] = "Stop";
char MotorUp[3] = "Up";
char MotorDown[5] = "Down";

// Permet de re afficher le statut de l'action moteur apres un speedup/speeddown
void restartCommande(){
  std_msgs::Empty toggle_msg;
  switch (motorAction) {
  case 1:
    Forward(toggle_msg);
    break;
  case 2:
    Backward(toggle_msg);
    break;
  case 3:
    Left(toggle_msg);
    break;
  case 4:
    Right(toggle_msg);
    break;
  default:
    // statements
    break;
  }
}

// Fonction callback lors de la publication d'un msg vide sur le "topic" up pour augmenter la vitesse du robot
void speedUp(const std_msgs::Empty& toggle_msg)
{
  OurMotorState.data = MotorUp;
  printState();
}

// Fonction callback lors de la publication d'un msg vide sur le topic "down" pour diminuer la vitesse du robot
void speedDown(const std_msgs::Empty& toggle_msg)
{
  OurMotorState.data = MotorDown;
  printState();
}

// Fonction callback lors de la publication d'un msg vide sur le topic "forward" pour faire avancer le robot
void Forward(const std_msgs::Empty& toggle_msg) 
{ 
  OurMotorState.data = MotorForward;
  printState();
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "backward" pour faire reculer le robot
void Backward(const std_msgs::Empty& toggle_msg) 
{ 
  OurMotorState.data = MotorBackward;
  printState();
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "left" pour faire tourner a gauche le robot
void Left( const std_msgs::Empty& toggle_msg) 
{ 
  OurMotorState.data = MotorLeft;
  printState();
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "right" pour faire tourner a droite le robot
void Right( const std_msgs::Empty& toggle_msg) 
{  
  OurMotorState.data = MotorRight;
  printState();
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "stop" pour arreter le robot
void Stop( const std_msgs::Empty& toggle_msg) 
{  
  OurMotorState.data = MotorStop;
  printState();
} 

// Subscriber pour les deplacements du robot
ros::Subscriber<std_msgs::Empty> subForward("forward", &Forward );
ros::Subscriber<std_msgs::Empty> subBackward("backward", &Backward );
ros::Subscriber<std_msgs::Empty> subLeft("left", &Left );
ros::Subscriber<std_msgs::Empty> subRight("right", &Right ); 
ros::Subscriber<std_msgs::Empty> subStop("stop", &Stop ); 
ros::Subscriber<std_msgs::Empty> subUp("up", &speedUp ); 
ros::Subscriber<std_msgs::Empty> subDown("down", &speedDown );

void setup()  
{
    nh.initNode();

    nh.subscribe(subForward);
    nh.subscribe(subBackward);
    nh.subscribe(subLeft);
    nh.subscribe(subRight);
    nh.subscribe(subStop);
    nh.subscribe(subUp);
    nh.subscribe(subDown);

    nh.advertise(Motorstate);

    Serial2.begin(9600);
} 

void loop()  
{  
    nh.spinOnce();  
    delay(100);  
}

// Affichage et publication du statut de l'action moteur en cours
void printState(){
  Motorstate.publish( &OurMotorState );
}

