#include <SoftwareSerial.h>
#include <SabertoothSimplified.h>
#include <Sabertooth.h>

#include <ros.h>
#include <std_msgs/Empty.h>
#include <geometry_msgs/Vector3.h>


ros::NodeHandle  nh; //node 

int vitesseD = 0; //vitesse moteur 1
int vitesseG = 0; //vitesse moteur 2

//Init ST
Sabertooth ST(128);

//Allumer la led avec message vide
void messageCb1( const std_msgs::Empty& toggle_msg){
  digitalWrite(13, HIGH-digitalRead(13));   // blink the led
}


//Donner la vitesse de chaque moteur
void messageCb2( const geometry_msgs::Vector3& cmd_msg){
  vitesseD=(int) cmd_msg.x;
  vitesseG=(int) cmd_msg.y;

  ST.motor(0,vitesseD);
  delay(10);
  ST.motor(1,vitesseG);
}

//Subscribe au deux fonctions 
ros::Subscriber<std_msgs::Empty> sub1("toggle_led", &messageCb1 );
ros::Subscriber<geometry_msgs::Vector3> sub2("cmd_mot", &messageCb2 );


//Setup
void setup()
{ 
  //Led
  pinMode(13, OUTPUT);
  
  //Node
  nh.initNode();

  //Sub
  nh.subscribe(sub1);
  nh.subscribe(sub2);

  //connexion au ST
  Serial3.begin(9600);
  //ST.autobaud();

  vitesseD = 10;
  vitesseG = 10;
  
  //Donner la vitesse au moteur
  delay(10);
  ST.motor(0,vitesseD);
  delay(10);
  ST.motor(1,vitesseG);

  //init_sabertooth();

}

void loop()
{  
  nh.spinOnce();
  delay(1);
}


/*


void commande1(int val, byte mode)
{
  //fonction d'envoi des commande au pont en H
  byte address = 128;       //adresse du pont en H 001111 sur les selecteurs

  Serial3.write(address);
  Serial3.write(mode);
  Serial3.write(val);
  Serial3.write((address + mode + val) &  0b01111111);

  /*
    mySerial3.write(address);
    mySerial3.write(mode);
    mySerial3.write(val);
    mySerial3.write((address + mode + val) &  0b01111111);
  */
/*}*/



/*
void output1(int val, byte mot)
{
  if (mot == 0)
  {
    if (val > 127)
      commande1(127, 0 );
    else if ( val > 0)
      commande1(val, 0);
    else if (val > -127)
      commande1(-val, 1);
    else
      commande1(127, 1);
  }
  else
  {
    /* moteur 0 et 1 ont un sens opposé */
    /*if (val > 127)
    {
      commande1(127, 1 + 4 );
    }
    else if ( val > 0)
    {
      commande1(val, 1 + 4 );
    }
    else if (val > -127)
    {
      commande1(-val, 4);
    }
    else
    {
      commande1(127, 4);
    }
  }
}*/


void init_sabertooth()
{
  byte address = 128;
  Serial3.write(address);
  Serial3.write(16);  // ramping
  Serial3.write(10);
  Serial3.write((address + 16 + 10) &  0b01111111);
  delay(10);
  Serial3.write(address);
  Serial3.write(14);  // Time0ut
  Serial3.write(10);   // 10x100ms=1S
  Serial3.write((address + 14 + 10) &  0b01111111);
  delay(10);
}
