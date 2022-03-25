/* Nzingulu Pathé
 Première Code qui permet d'afficher la valeur mesurée par le capteur. 
 */
#include <SoftwareSerial.h>
#include "MeOrion.h"

MeLineFollower lineFinder(PORT_6); /* Line Finder module can only be connected to PORT_3, PORT_4, PORT_5, PORT_6 of base shield. */


void setup()
{
  Serial.begin(9600);
  while (!Serial);
}

void loop()
{
  float sensorState = lineFinder.readSensors();  // lecture de la valeur mesurée par le capteur.
  Serial.print("Valeur mesurée par le capteur = "); Serial.print(sensorState); // Affichage de la valeur
  Serial.println();   // laisser une ligne vide
  delay (5000);  // Attente de 5 secondes
}
