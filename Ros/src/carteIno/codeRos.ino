// Lucas Deshayes & Reda Guendouz

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
  // Si la vitesse du robot n'est pas deja au maximun augmentation de 10 unite
  if (motorSpeed < 110){
    motorSpeed += 10;
  }
  // re affiche le statut
  restartCommande();
  OurMotorState.data = MotorUp;
  printState();
}

// Fonction callback lors de la publication d'un msg vide sur le topic "down" pour diminuer la vitesse du robot
void speedDown(const std_msgs::Empty& toggle_msg)
{
  // Si la vitesse du robot n'est pas deja au minimum diminution de 10 unite
  if (motorSpeed > 20){
    motorSpeed -= 10;
  }
  // re affiche le statut
  restartCommande();
  OurMotorState.data = MotorDown;
  printState();
}

// Fonction callback lors de la publication d'un msg vide sur le topic "forward" pour faire avancer le robot
void Forward(const std_msgs::Empty& toggle_msg) 
{ 
  // actionne les deux moteurs du robot avec comme vitesse la valeur de motorSpeed
  motorCommande(motorSpeed, 0);
  motorCommande(motorSpeed, 1); 
  OurMotorState.data = MotorForward;
  motorAction = 1;
  printState();
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "backward" pour faire reculer le robot
void Backward(const std_msgs::Empty& toggle_msg) 
{ 
  // actionne les deux moteurs du robot avec comme vitesse la valeur de -motorSpeed
  motorCommande(-motorSpeed, 0);
  motorCommande(-motorSpeed, 1); 
  OurMotorState.data = MotorBackward;
  motorAction = 2;
  printState();
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "left" pour faire tourner a gauche le robot
void Left( const std_msgs::Empty& toggle_msg) 
{ 
  // actionne les deux moteurs du robot avec comme vitesse la valeur de motorSpeed pour le moteur 1 et -motorSpeed pour le moteur 0
  motorCommande(-motorSpeed, 0);
  motorCommande(motorSpeed, 1); 
  OurMotorState.data = MotorLeft;
  motorAction = 3;
  printState();
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "right" pour faire tourner a droite le robot
void Right( const std_msgs::Empty& toggle_msg) 
{ 
  // actionne les deux moteurs du robot avec comme vitesse la valeur de -motorSpeed pour le moteur 1 et motorSpeed pour le moteur 0
  motorCommande(motorSpeed, 0);
  motorCommande(-motorSpeed, 1); 
  OurMotorState.data = MotorRight;
  motorAction = 4;
  printState();
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "stop" pour arreter le robot
void Stop( const std_msgs::Empty& toggle_msg) 
{  
  // arrete les deux moteurs du robot
  motorCommande(0, 0);
  motorCommande(0, 1); 
  OurMotorState.data = MotorStop;
  motorAction = 0;
  printState();
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "opendoor" pour ouvrir la remorque du robot
void OpenDoor( const std_msgs::Empty& toggle_msg) {
  // Actionne les deux moteurs de la remorque pour l'ouverture, change l'angle dans une boucle for (de 160 à 25 degres)
  for(int position = 160; position > 25; position --) {
    moteur.write(position);
    moteur2.write(180-position);
    delay(10);
  }
}

// Fonction callback lors de la publication d'un msg vide sur le topic "closedoor" pour fermer la remorque du robot
void CloseDoor( const std_msgs::Empty& toggle_msg) {
  // Actionne les deux moteurs de la remorque pour l'ouverture, change l'angle dans une boucle for (de 25 à 160 degres)
  for(int position = 25; position < 160; position ++) {
    moteur.write(position);
    moteur2.write(180-position);
    delay(10);
  }
}

// Fonction callback lors de la publication d'un msg vide sur le topic "linefollow" pour diriger le robot a l'aide du line follower
void LineFollower( const std_msgs::Empty& toggle_msg) {
  // Boucle tant que aucun Qr code n'a était scanner
  while(statusQrCode) {
    int g = digitalRead(GAUCHE); // Recupere la valeur du capteur de gauche
    int d = digitalRead(DROITE); // Recupere la valeur du capteur de droite
    delay(500);

    // Publication d'un message en fonction de l'action a faire entre avancer, tourner et s'arreter
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

// Fonction callback lors de la publication de la liste des bureau sur le topic "listeTopic" pour recuperer la liste des bureau a livrer (recuperation du site web)
void initListe( const std_msgs::String& msg)
{
  OurListe.data = msg.data;
  strcpy(ListeBureau, msg.data);
  char * liste = ListeBureau;
  char * str_number;
  nb_bureau = 0;
  // Decoupage du msg reçu (xxx;xx;x;xx) en tableau de bireau en fonction du séparateur ';'
  while ((str_number = strsep(&liste,";"))) {
        TabBureau[nb_bureau] = atoi(str_number);
        nb_bureau++;
  }
  printStateListe();
}

// Fonction callback lors de la publication de la valeur d'un qr code trouver sur le topic "qrCodeData"
void analyseQrCode(const std_msgs::String& msg)
{
  // Verification de la valeur du Qr code scanner, si il appartient à la liste des bureaux
  for(int i = 0; i < nb_bureau; i++)
  {
    if (atoi(msg.data) == TabBureau[i])
    {
      statusQrCode = 0;
      const std_msgs::Empty toggle_msg;
      // ouverture de la remorque
      OpenDoor(toggle_msg);
      delay(10000); // Temps d'attente
      // fermeture de la remorque
      CloseDoor(toggle_msg);
      statusQrCode = 1;
    }
  }
}

// Subscriber pour les deplacements du robot
ros::Subscriber<std_msgs::Empty> subForward("forward", &Forward );
ros::Subscriber<std_msgs::Empty> subBackward("backward", &Backward );
ros::Subscriber<std_msgs::Empty> subLeft("left", &Left );
ros::Subscriber<std_msgs::Empty> subRight("right", &Right ); 
ros::Subscriber<std_msgs::Empty> subStop("stop", &Stop ); 
ros::Subscriber<std_msgs::Empty> subUp("up", &speedUp ); 
ros::Subscriber<std_msgs::Empty> subDown("down", &speedDown );

// Subscriber pour le suiveur de ligne du robot
ros::Subscriber<std_msgs::Empty> subLineFollower("linefollow", &LineFollower );

// Subscriber pour les actions de la remorque du robot
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

  // liaison et branchement des moteurs de la remorque
  pinMode(DROITE, INPUT); 
  pinMode(GAUCHE, INPUT);
  moteur.attach(5);
  moteur2.attach(7);
} 

// Fonction boucle du noeud ros
void loop()  
{    
  nh.spinOnce();  
  delay(100);  
}

// Affichage et publication du statut de l'action moteur en cours
void printState(){
  Motorstate.publish( &OurMotorState );
}

// Affichage et publication de la liste des bureaux
void printStateListe(){
  Listestate.publish( &OurListe );
}

// Transfert des données pour les moteurs vers la carte arduino, envoi des commande au pont en H
void transferData(int val, byte mode)
{
  //adresse du pont en H 001111 sur les selecteurs
  byte address = 128;       

  Serial2.write(address);
  Serial2.write(mode);
  Serial2.write(val);
  Serial2.write((address + mode + val) &  0b01111111);  
}

// Appel le transfert de données en fonction du moteur et de la valeur
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
}
