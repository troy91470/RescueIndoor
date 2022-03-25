// Clément ROBIN

#include <Servo.h>

Servo moteur;
Servo moteur2;

void setup() {
  //les moteurs sont attachés aux pins 5 et 7
  moteur.attach(5);
  moteur2.attach(7);
}

void loop() {

    ouvrir();
    delay(2000);
    fermer();
    delay(2000);
}

// Fonction qui fait tourner les moteurs pour ouvrir la remorque
void ouvrir() {
  for(int position = 25; position < 160; position ++) {
    moteur.write(position);
    moteur2.write(180-position);
    delay(10);
  }
}

// Fonction qui fait tourner les moteurs pour fermer la remorque 
void fermer() {
  for(int position = 160; position > 25; position --) {
    moteur.write(position);
    moteur2.write(180-position);
    delay(10);
  }
}
