#include <ros.h>
#include <std_msgs/Empty.h>
#include <std_msgs/String.h>

ros::NodeHandle  nh;

std_msgs::String OurMotorState;
ros::Publisher Motorstate("state", &OurMotorState);

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
nh.spinOnce();  
delay(100);  
}

