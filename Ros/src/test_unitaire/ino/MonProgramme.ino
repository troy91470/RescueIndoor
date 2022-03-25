/*
 * Fichier où se trouve le programme principal:
 * 
 */

#include "Programme.h" //fichier header où se trouve nos prototypes
#include <Arduino.h>
#include <MeAuriga.h>
#include <Wire.h>
#include <SoftwareSerial.h>


MeRGBLineFollower RGBLineFollower(PORT_6, ADDRESS2); // voir: https://www.locoduino.org/spip.php?article87 et http://www.louisreynier.com/fichiers/ArduinoClasses.pdf


uint8_t sensorstate;
uint8_t study_types = 0;

uint8_t RGB1, RGB2, RGB3, RGB4;

void setup() {
  // put your setup code here, to run once:

  RGBLineFollower.begin();
  RGBLineFollower.setKp(0.3);
  RGBLineFollower.setpin(11, 12);

}

void loop() {

  Serial.println ("début");
  // put your main code here, to run repeatedly:
RGBLineFollower.loop();
RGB1 = RGBLineFollower.getADCValueRGB1();
RGB2 = RGBLineFollower.getADCValueRGB2();
RGB2 = RGBLineFollower.getADCValueRGB3();
RGB2 = RGBLineFollower.getADCValueRGB4();

Serial.println ("RGB1 = ");Serial.println (RGB1);
Serial.println ("RGB2 = ");Serial.println (RGB2);
Serial.println ("RGB3 = ");Serial.println (RGB3);
Serial.println ("RGB4 = ");Serial.println (RGB4);

delay (2000);

}
