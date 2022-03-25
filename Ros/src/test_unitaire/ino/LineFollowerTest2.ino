// Nzingulu Pathé
#include <Wire.h> // Bibiothéque qui permet de communiquer en utilisant le protocole I2C
#include "MeOrion.h"

const int MPU = 0x20; // L'adresse I2C du capteur Line Follower
const uint8_t donneeRecue = Wire.read();

MeLineFollower lineFinder(PORT_6);

void setup() 
{
  // put your setup code here, to run once:
  Serial.begin(9600); // Communication en série à 9600 bauds.
  Serial.println ("Requête de lecture sur le bus I2C");

  Wire.begin(); //Initialisation (lancement) de la librairie "Wire" et de l'I2C.
  const uint8_t nombreDeDonneesRecues=Wire.requestFrom(MPU,2);
}

void loop() {
  // put your main code here, to run repeatedly:
  

  // On affiche la donnée
  Serial.print ("Donnée reçue ="); Serial.println (donneeRecue, HEX); 

   int sensorState = lineFinder.readSensors();
   
   
  switch(sensorState)
  {
    case S1_IN_S2_IN: 
        Serial.println("Sensor 1 and 2 are inside of black line"); 
        // On peut rajouter une fonction qui permet de faire avancer le rebot tout droit par exemple: tout_droit(). 
        Serial.print ("Valeur mesurée =");Serial.println (sensorState); Serial.println();
        break;

    
    case S1_IN_S2_OUT: 
        Serial.println("Sensor 2 is outside of black line"); 
        // On peut rajouter une fonction qui permet de faire tourner le rebot à droite par exemple: droite().
        Serial.print ("Valeur mesurée =");Serial.println (sensorState); Serial.println();
        break;

    
    case S1_OUT_S2_IN: 
        Serial.println("Sensor 1 is outside of black line"); 
         // On peut rajouter une fonction qui permet de faire tourner le rebot à gauche par exemple: gauche().
        Serial.print ("Valeur mesurée =");Serial.println (sensorState); Serial.println();
        break;
   
    
    case S1_OUT_S2_OUT: 
       Serial.println("Sensor 1 and 2 are outside of black line");
       // On peut rajouter une fonction qui permet d'arreter le rebot par exemple: arreter().
       Serial.print ("Valeur mesurée =");Serial.println (sensorState); Serial.println();
       break;
  
    
    default: 
       // On peut rajouter une fonction qui permet de faire reculer le rebot par exemple: reculer().
       Serial.print ("Valeur mesurée =");Serial.println (sensorState); Serial.println();
       break;
   
  }
  delay(2000);

}
