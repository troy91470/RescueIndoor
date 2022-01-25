#include <ros.h>
#include <std_msgs/Empty.h>
#include <std_msgs/String.h>
#include <geometry_msgs/Vector3.h>

int motorSpeed = 60;

ros::NodeHandle  nh;

std_msgs::String OurMotorState;
ros::Publisher Motorstate("state", &OurMotorState);

char MotorForward[8] = "Forward";
char MotorBackward[9] = "Backward";
char MotorLeft[5] = "Left";
char MotorRight[6] = "Right";
char MotorStop[5] = "Stop";
char MotorUp[3] = "Up";
char MotorDown[5] = "Down";


void speedUp(const std_msgs::Empty& toggle_msg)
{
 if (motorSpeed < 110){
  motorSpeed += 10;
 }
 OurMotorState.data = MotorUp;
}

void speedDown(const std_msgs::Empty& toggle_msg)
{
 if (motorSpeed > 20){
  motorSpeed -= 10;
 }
  OurMotorState.data = MotorDown;
}


void Forward(const std_msgs::Empty& toggle_msg) 
{ 
motorCommande(motorSpeed, 0);
motorCommande(motorSpeed, 1); 
OurMotorState.data = MotorForward;
} 

void Backward(const std_msgs::Empty& toggle_msg) 
{  
motorCommande(-motorSpeed, 0);
motorCommande(-motorSpeed, 1); 
OurMotorState.data = MotorBackward;
} 

void Left( const std_msgs::Empty& toggle_msg) 
{  
motorCommande(-motorSpeed, 0);
motorCommande(motorSpeed, 1); 
OurMotorState.data = MotorLeft;
} 

void Right( const std_msgs::Empty& toggle_msg) 
{  
motorCommande(motorSpeed, 0);
motorCommande(-motorSpeed, 1); 
OurMotorState.data = MotorRight;
} 

void Stop( const std_msgs::Empty& toggle_msg) 
{  
motorCommande(0, 0);
motorCommande(0, 1); 
OurMotorState.data = MotorStop;
} 

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
nh.subscribe(subUp);
nh.subscribe(subDown);
nh.subscribe(subForward);
nh.subscribe(subBackward);
nh.subscribe(subLeft);
nh.subscribe(subRight);
nh.subscribe(subStop);
nh.advertise(Motorstate);
Serial2.begin(9600);
} 

void loop()  
{  
Motorstate.publish( &OurMotorState );
nh.spinOnce();  
delay(100);  
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
