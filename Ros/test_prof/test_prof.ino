/* 
 * rosserial Subscriber Example
 * Blinks an LED on callback
 */

#include <ros.h>
#include <std_msgs/Empty.h>
#include <geometry_msgs/Vector3.h>

ros::NodeHandle  nh;


int sortie0;
int sortie1;

void messageCb1( const std_msgs::Empty& toggle_msg){
  digitalWrite(13, HIGH-digitalRead(13));   // blink the led
}

void messageCb2( const geometry_msgs::Vector3& cmd_msg){
   sortie0=(int) cmd_msg.x;
   sortie1=(int) cmd_msg.y;

  output1(sortie0, 0);
  output1(sortie1, 1); 
}

ros::Subscriber<std_msgs::Empty> sub1("toggle_led", &messageCb1 );
ros::Subscriber<geometry_msgs::Vector3> sub2("cmd_mot", &messageCb2 );

void setup()
{ 
  nh.initNode();
  nh.subscribe(sub1);
  nh.subscribe(sub2);

  //Serial2.begin(9600);

  sortie1 = 50;
  sortie0 = 50;
  delay(10);
  /* droit */
  output1(sortie0, 0);
  delay(10);
  output1(sortie1, 1);

  // init_sabertooth();

}

void loop()
{  
  nh.spinOnce();
  delay(1);
}

void commande1(int val, byte mode)
{
  //fonction d'envoi des commande au pont en H
  byte address = 128;       //adresse du pont en H 001111 sur les selecteurs

  Serial2.write(address);
  Serial2.write(mode);
  Serial2.write(val);
  Serial2.write((address + mode + val) &  0b01111111);  
}

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
    if (val > 127)
      commande1(127, 1 + 4 );
    else if ( val > 0)
      commande1(val, 1 + 4 );
    else if (val > -127)
      commande1(-val, 4);
    else
      commande1(127, 4);
  }

}

/*
void init_sabertooth()
{
  byte address = 128;
  Serial3.write(address);
  Serial3.write(16);  // ramping
  Serial3.write(10);
  Serial3.write((address + 16 + 10) &  0b01111111);
  delay(10);
  //  Serial3.write(address);
  //  Serial3.write(15);  // baudrate
  //  Serial3.write(4);   // 2 - 9600 //4 -38400
  //  Serial3.write((address + 15 + 4) &  0b01111111);
  //  Serial3.begin(38400);
  //  delay(10);
  Serial3.write(address);
  Serial3.write(14);  // Time0ut
  Serial3.write(10);   // 10x100ms=1S
  Serial3.write((address + 14 + 10) &  0b01111111);
  delay(10);
}*/
