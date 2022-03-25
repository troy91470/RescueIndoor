// Lucas Deshayes & Clement Robin

#include <ros.h>
#include <std_msgs/Empty.h>
#include <std_msgs/String.h>
#include <Servo.h>

// Declaration du noeud Ros
ros::NodeHandle  nh;

std_msgs::String OurMotorState;
ros::Publisher Motorstate("state", &OurMotorState);

// Variables pour les moteurs de la remorques
Servo moteur;
Servo moteur2;

char MotorUp[3] = "Up";
char MotorDown[5] = "Down";

// Fonction callback lors de la publication d'un msg vide sur le topic "opendoor" pour ouvrir la remorque du robot
void OpenDoor( const std_msgs::Empty& toggle_msg) {
    OurMotorState.data = MotorUp;
    printState();
}

// Fonction callback lors de la publication d'un msg vide sur le topic "closedoor" pour fermer la remorque du robot
void CloseDoor( const std_msgs::Empty& toggle_msg) {
    OurMotorState.data = MotorDown;
    printState();
}

// Subscriber pour les actions de la remorque du robot
ros::Subscriber<std_msgs::Empty> subServoOpen("opendoor", &OpenDoor );
ros::Subscriber<std_msgs::Empty> subServoClose("closedoor", &CloseDoor );

void setup()  
{
    nh.initNode();

    nh.subscribe(subServoOpen);
    nh.subscribe(subServoClose);

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