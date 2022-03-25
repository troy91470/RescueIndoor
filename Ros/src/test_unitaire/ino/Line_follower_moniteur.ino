//Abinav SAIRIN MT4

#define DROITE A0 //ir sensor Right
#define GAUCHE A1 //ir sensor Left

// 1 noir
// 0 blanc

void setup() {
  Serial.begin(9600);
  pinMode(DROITE, INPUT); // declare if sensor as input  
  pinMode(GAUCHE, INPUT); // declare ir sensor as input
}

void loop() {
  //Serial.print("sensor gauche : ");
  //Serial.println();
  //Serial.print("sensor droite : ");
  //Serial.println(analogRead(DROITE));
  int g = digitalRead(GAUCHE);
  int d = digitalRead(DROITE);
  delay(500);

  if((d == 1)&&(g == 1)){//si 2 capteurs sur la ligne
     Serial.println("avancer");
  }
  if((d == 1)&&(g == 0)){//si capteur doite sur la ligne et capteur gauche dehors 
    Serial.println("tourner a droite");
  }
  if((d == 0)&&(g == 1)){//si capteur gauche sur la ligne et capteur droite dehors 
     Serial.println("touner a gauche");  
  }
  if((d == 0)&&(g == 0)){//si capteur gauche et capteur droite dehors 
    Serial.println("pas de ligne");
  }
