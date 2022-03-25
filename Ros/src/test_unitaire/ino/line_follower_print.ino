// Clément ROBIN

#define DROITE A0 //ir sensor Right
#define GAUCHE A1 //ir sensor Left

void setup() {
  Serial.begin(9600);
  pinMode(DROITE, INPUT); // declare ir sensor as input  
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

// 1 noir
// 0 blanc

  if((d == 1)&&(g == 1)){
     Serial.println("avancer");
  }
  if((d == 1)&&(g == 0)){
    Serial.println("tourner a droite");
  }
  if((d == 0)&&(g == 1)){
     Serial.println("touner a gauche");  
  }
  if((d == 0)&&(g == 0)){
    Serial.println("pas de ligne");
  }
}
