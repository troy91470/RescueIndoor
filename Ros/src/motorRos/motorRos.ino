#include <ros.h>
#include <std_msgs/Empty.h>
#include <std_msgs/String.h>
#include <geometry_msgs/Vector3.h>
#include <Servo.h>

#define DROITE A0 //ir sensor Right
#define GAUCHE A1 //ir sensor Left
// 1 noir
// 0 blanc

// Variables pour les moteurs de la remorques
Servo moteur;
Servo moteur2;

int statusQrCode = 1;

// Variable pour la vitesse moteur
int motorSpeed = 60;

// Declaration du noeud Ros
ros::NodeHandle  nh;

// Variables pour les actions moteur
int motorAction = 0; // 0 : Stop ; 1 : Forward ; 2 : BackWard ; 3 : Left ; 4 : Right ; 
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

// Tableau message pour le line follower
char LineFollowerAlgo[13] = "LineFollower";

// Tableau message pour la remorque
char ServoOpenDoor[9] = "OpenDoor";
char ServoCloseDoor[10] = "CloseDoor";

// Variables pour la liste des bureaux
std_msgs::String OurListe;
std_msgs::String OurTab;
ros::Publisher Listestate("stateliste", &OurListe);
ros::Publisher Tabstate("valueBureau", &OurTab);
char ListeBureau[100] = "";
int TabBureau[100];
int nb_bureau;

// Fonction callback pour augmenter la vitesse du robot
void speedUp(const std_msgs::Empty& toggle_msg)
{
 if (motorSpeed < 110){
  motorSpeed += 10;
 }
 restartCommande();
 OurMotorState.data = MotorUp;
 printState();
}

// Fonction callback pour diminuer la vitesse du robot
void speedDown(const std_msgs::Empty& toggle_msg)
{
 if (motorSpeed > 20){
  motorSpeed -= 10;
 }
  restartCommande();
  OurMotorState.data = MotorDown;
  printState();
}

// Permet de re afficher
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

void Forward(const std_msgs::Empty& toggle_msg) 
{ 
motorCommande(motorSpeed, 0);
motorCommande(motorSpeed, 1); 
OurMotorState.data = MotorForward;
motorAction = 1;
printState();
} 

void Backward(const std_msgs::Empty& toggle_msg) 
{  
motorCommande(-motorSpeed, 0);
motorCommande(-motorSpeed, 1); 
OurMotorState.data = MotorBackward;
motorAction = 2;
printState();
} 

void Left( const std_msgs::Empty& toggle_msg) 
{  
motorCommande(-motorSpeed, 0);
motorCommande(motorSpeed, 1); 
OurMotorState.data = MotorLeft;
motorAction = 3;
printState();
} 

void Right( const std_msgs::Empty& toggle_msg) 
{  
motorCommande(motorSpeed, 0);
motorCommande(-motorSpeed, 1); 
OurMotorState.data = MotorRight;
motorAction = 4;
printState();
} 

void Stop( const std_msgs::Empty& toggle_msg) 
{  
motorCommande(0, 0);
motorCommande(0, 1); 
OurMotorState.data = MotorStop;
motorAction = 0;
printState();
} 

void OpenDoor( const std_msgs::Empty& toggle_msg) {
  
  for(int position = 160; position > 25; position --) {
    moteur.write(position);
    moteur2.write(180-position);
    delay(10);
  }
}

void CloseDoor( const std_msgs::Empty& toggle_msg) {
  for(int position = 25; position < 160; position ++) {
    moteur.write(position);
    moteur2.write(180-position);
    delay(10);
  }
}

void LineFollower( const std_msgs::Empty& toggle_msg) {
  while(statusQrCode) {
    int g = digitalRead(GAUCHE);
    int d = digitalRead(DROITE);
    delay(500);
  
    if((d == 0)&&(g == 0)){
      Forward(toggle_msg);
    }
    if((d == 0)&&(g == 1)){
      Right(toggle_msg);
    }
    if((d == 1)&&(g == 0)){
       Left(toggle_msg); 
    }
    if((d == 1)&&(g == 1)){
      Stop(toggle_msg);
    }
  }
}

void initListe( const std_msgs::String& msg)
{
  OurListe.data = msg.data;
  strcpy(ListeBureau, msg.data);
  char * liste = ListeBureau;
  char * str_number;
  nb_bureau = 0;
  while ((str_number = strsep(&liste,";"))) {
        TabBureau[nb_bureau] = atoi(str_number);
        nb_bureau++;
  }
  printStateTab();
  printStateListe();
}

void analyseQrCode(const std_msgs::String& msg)
{
  for(int i = 0; i < nb_bureau; i++)
  {
    if (atoi(msg.data) == TabBureau[i])
    {
      statusQrCode = 0;
      const std_msgs::Empty toggle_msg;
      OpenDoor(toggle_msg);
      delay(5000);
      CloseDoor(toggle_msg);
      //statusQrCode = 1;

    }
  }
}

// Subscriber pour les deplacements
ros::Subscriber<std_msgs::Empty> subForward("forward", &Forward );
ros::Subscriber<std_msgs::Empty> subBackward("backward", &Backward );
ros::Subscriber<std_msgs::Empty> subLeft("left", &Left );
ros::Subscriber<std_msgs::Empty> subRight("right", &Right ); 
ros::Subscriber<std_msgs::Empty> subStop("stop", &Stop ); 
ros::Subscriber<std_msgs::Empty> subUp("up", &speedUp ); 
ros::Subscriber<std_msgs::Empty> subDown("down", &speedDown );

// Subscriber pour le suiveur de ligne
ros::Subscriber<std_msgs::Empty> subLineFollower("linefollow", &LineFollower );

// Subscriber pour les actions de la remorque
ros::Subscriber<std_msgs::Empty> subServoOpen("opendoor", &OpenDoor );
ros::Subscriber<std_msgs::Empty> subServoClose("closedoor", &CloseDoor );

// Subscriber pour la liste des bureaux
ros::Subscriber<std_msgs::String> subListe("listeTopic", &initListe );

// Subscriber pour la valeur du QR Code
ros::Subscriber<std_msgs::String> subQrCode("qrCodeData", &analyseQrCode );


void setup()  
{
nh.initNode();

// noeud nh qui s'abonne aux actions déplacements
nh.subscribe(subUp);
nh.subscribe(subDown);
nh.subscribe(subForward);
nh.subscribe(subBackward);
nh.subscribe(subLeft);
nh.subscribe(subRight);
nh.subscribe(subStop);
nh.advertise(Motorstate);

// noeud nh qui s'abonne line follower
nh.subscribe(subLineFollower);

// noeud nh qui s'abonne aux actions de la remorque
nh.subscribe(subServoOpen);
nh.subscribe(subServoClose);

nh.subscribe (subQrCode);

// noeud nh qui s'abonne pour la liste des bureaux
nh.subscribe(subListe);
nh.advertise(Listestate);
nh.advertise(Tabstate);

Serial2.begin(9600);
pinMode(DROITE, INPUT); // declare if sensor as input  
pinMode(GAUCHE, INPUT); // declare ir sensor as input
moteur.attach(5);
moteur2.attach(7);
} 

void loop()  
{  
  
nh.spinOnce();  
delay(100);  
}

void printState(){
  Motorstate.publish( &OurMotorState );
}

void printStateListe(){
  Listestate.publish( &OurListe );
}

void printStateTab(){
  for (int i = 0; i < nb_bureau; i++){
      if (TabBureau[i] == 1){
        OurTab.data = "oui";
        Tabstate.publish( &OurTab );
      }
      else {
        OurTab.data = "non";
        Tabstate.publish( &OurTab );
      }
  }
}

void transferData(int val, byte mode)
{
  //fonction d'envoi des commande au pont en H
  byte address = 128;       //adresse du pont en H 001111 sur les selecteurs

  Serial2.write(address);
  Serial2.write(mode);
  Serial2.write(val);
  Serial2.write((address + mode + val) &  0b01111111);  
}

void motorCommande(int val, byte mot)
{
  if (mot){
    if (val > 0){
      transferData(val,1);
    }
    else {
      transferData(-val,0);
    }
  }
  else{
    if (val > 0){
      transferData(val,4);
    }
    else {
      transferData(-val,5);
    }
  }
      // Recule roues droite transferData(50, 0);
      // Avance roues droite transferData(50, 1);
      // Avance roues gauche transferData(50, 4);
      // Recule roues gauche transferData(50, 5);
}
