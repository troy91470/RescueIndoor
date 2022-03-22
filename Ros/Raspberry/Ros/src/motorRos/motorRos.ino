#include <ros.h>
#include <std_msgs/Empty.h>
#include <std_msgs/String.h>
#include <geometry_msgs/Vector3.h>
#include <Servo.h>

#define DROITE A0 //ir sensor Right
#define GAUCHE A1 //ir sensor Left
// 1 noir
// 0 blanc

Servo moteur;
Servo moteur2;

int motorSpeed = 60;

ros::NodeHandle  nh;

int motorAction = 0; // 0 : Stop ; 1 : Forward ; 2 : BackWard ; 3 : Left ; 4 : Right ; 
std_msgs::String OurMotorState;
ros::Publisher Motorstate("state", &OurMotorState);

char MotorForward[8] = "Forward";
char MotorBackward[9] = "Backward";
char MotorLeft[5] = "Left";
char MotorRight[6] = "Right";
char MotorStop[5] = "Stop";
char MotorUp[3] = "Up";
char MotorDown[5] = "Down";
char LineFollowerAlgo[13] = "LineFollower";
char ServoOpenDoor[9] = "OpenDoor";
char ServoCloseDoor[10] = "CloseDoor";


void speedUp(const std_msgs::Empty& toggle_msg)
{
 if (motorSpeed < 110){
  motorSpeed += 10;
 }
 restartCommande();
 OurMotorState.data = MotorUp;
 printState();
}

void speedDown(const std_msgs::Empty& toggle_msg)
{
 if (motorSpeed > 20){
  motorSpeed -= 10;
 }
  restartCommande();
  OurMotorState.data = MotorDown;
  printState();
}

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
  for(int position = 25; position < 160; position ++) {
    moteur.write(position);
    moteur2.write(180-position);
    delay(10);
  }
}

void CloseDoor( const std_msgs::Empty& toggle_msg) {
  for(int position = 160; position > 25; position --) {
    moteur.write(position);
    moteur2.write(180-position);
    delay(10);
  }
}

void LineFollower( const std_msgs::Empty& toggle_msg) {
  while(1) {
    int g = digitalRead(GAUCHE);
    int d = digitalRead(DROITE);
    delay(500);
  
    if((d == 1)&&(g == 1)){
      Forward(toggle_msg);
    }
    if((d == 1)&&(g == 0)){
      Right(toggle_msg);
    }
    if((d == 0)&&(g == 1)){
       Left(toggle_msg); 
    }
    if((d == 0)&&(g == 0)){
      Stop(toggle_msg);
    }
  }
}

ros::Subscriber<std_msgs::Empty> subForward("forward", &Forward );
ros::Subscriber<std_msgs::Empty> subBackward("backward", &Backward );
ros::Subscriber<std_msgs::Empty> subLeft("left", &Left );
ros::Subscriber<std_msgs::Empty> subRight("right", &Right ); 
ros::Subscriber<std_msgs::Empty> subStop("stop", &Stop ); 
ros::Subscriber<std_msgs::Empty> subUp("up", &speedUp ); 
ros::Subscriber<std_msgs::Empty> subDown("down", &speedDown );
ros::Subscriber<std_msgs::Empty> subLineFollower("linefollow", &LineFollower );
ros::Subscriber<std_msgs::Empty> subServoOpen("opendoor", &OpenDoor );
ros::Subscriber<std_msgs::Empty> subServoClose("closedoor", &CloseDoor );

void setup()  
{
nh.initNode();
nh.subscribe(subUp);
nh.subscribe(subDown);
nh.subscribe(subForward);
nh.subscribe(subBackward);
nh.subscribe(subLeft);
nh.subscribe(subRight);
nh.subscribe(subStop);
nh.subscribe(subLineFollower);
nh.subscribe(subServoOpen);
nh.subscribe(subServoClose);

nh.advertise(Motorstate);


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
