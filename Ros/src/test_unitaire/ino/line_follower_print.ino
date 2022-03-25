// Clément ROBIN

#define DROITE A0 //ir sensor Right
#define GAUCHE A1 //ir sensor Left

void setup() {
  Serial.begin(9600);
  pinMode(DROITE, INPUT); // declare ir sensor as input  
  pinMode(GAUCHE, INPUT); // declare ir sensor as input
}

void loop() {
  int g = digitalRead(GAUCHE); // lit la valeur du capteur gauche
  int d = digitalRead(DROITE); // lit la valeur du capteur droit
  delay(500);

// 1 noir
// 0 blanc

  // si le capteur de gauche et le capteur de droit voient du noir, le robot est sur la ligne alors il avance
  if((d == 1)&&(g == 1)){
     Serial.println("avancer");
  }
   // si le capteur de gauche voit du blanc et le capteur de droit voit du noir, le robot est sur la gauche de la ligne alors il tourne a droite
  if((d == 1)&&(g == 0)){
    Serial.println("tourner a droite");
  }
  // si le capteur de gauche voit du noir et le capteur de droit voit du blanc, le robot est sur la droite de la ligne alors il tourne a gauche
  if((d == 0)&&(g == 1)){
     Serial.println("touner a gauche");  
  }
  // si le capteur de gauche et le capteur de droit voient du blanc, le robot n'est pas sur la ligne alors il s'arrête
  if((d == 0)&&(g == 0)){
    Serial.println("pas de ligne");
  }
}
