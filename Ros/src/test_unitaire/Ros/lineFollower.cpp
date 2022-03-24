// Reda guendouz & Abinav Sairin

#include <ros.h>
#include <std_msgs/Empty.h>
#include <std_msgs/String.h>

ros::NodeHandle  nh;

std_msgs::String OurMotorState;
ros::Publisher Motorstate("state", &OurMotorState);

// Tableaux des messages pour les actions moteurs
char MotorForward[8] = "Forward";
char MotorLeft[5] = "Left";
char MotorRight[6] = "Right";
char MotorStop[5] = "Stop";

// Fonction callback lors de la publication d'un msg vide sur le topic "linefollow" pour diriger le robot a l'aide du line follower
void LineFollower( const std_msgs::Empty& toggle_msg) {
  // Boucle tant que aucun Qr code n'a était scanner
  while(statusQrCode) {
    int g = digitalRead(GAUCHE); // Recupere la valeur du capteur de gauche
    int d = digitalRead(DROITE); // Recupere la valeur du capteur de droite
    delay(500);

    // Affichage du statut en fonction des valeurs des deux capteurs
    if((d == 0)&&(g == 0)){
        OurMotorState.data = MotorForward;
        printState();
    }
    if((d == 0)&&(g == 1)){
        OurMotorState.data = MotorRight;
        printState();
    }
    if((d == 1)&&(g == 0)){
        OurMotorState.data = MotorLeft;
        printState(); 
    }
    if((d == 1)&&(g == 1)){
        OurMotorState.data = MotorStop;
        printState(); 
    }
  }
}

void setup()  
{
    nh.initNode();

    nh.subscribe(subForward);
    nh.subscribe(subLeft);
    nh.subscribe(subRight);
    nh.subscribe(subStop);

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