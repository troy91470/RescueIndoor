#define R_S A0 //ir sensor Right
#define L_S A1 //ir sensor Left


// Variable pour la vitesse moteur
int motorSpeed = 30;

void setup(){ // put your setup code here, to run once
  Serial2.begin(9600);
  Serial.begin(9600);
  pinMode(R_S, INPUT); // declare if sensor as input  
  pinMode(L_S, INPUT); // declare ir sensor as input
}


void loop(){
  Serial.print("sensor gauche : ");
  Serial.println(digitalRead(L_S));
  Serial.print("sensor droite : ");
  Serial.println(digitalRead(R_S));
  if((digitalRead(R_S) == 0)&&(digitalRead(L_S) == 0)){
    Serial.print("Avancer");
    Forward();
  }   //if Right Sensor and Left Sensor are at White color then it will call forword function

  if((digitalRead(R_S) == 0)&&(digitalRead(L_S) == 1)){
    Serial.print("Droite");
    Right();
  } //if Right Sensor is Black and Left Sensor is White then it will call turn Right function  

  if((digitalRead(R_S) == 1)&&(digitalRead(L_S) == 0)){
    Serial.print("Gauche");
    Left();
  }  //if Right Sensor is White and Left Sensor is Black then it will call turn Left function

  if((digitalRead(R_S) == 1)&&(digitalRead(L_S) == 1)){
    while(!(digitalRead(R_S) == 1)&&(digitalRead(L_S) == 1)){
      Serial.println("a-demi-tour");
      Backward();
    }
    while(!(digitalRead(R_S) == 0)&&(digitalRead(L_S) == 1)){
       Serial.println("g-demi-tour");
      Left();
    }
  } //if Right Sensor and Left Sensor are at Black color then it will call Stop function

  //Backward();
}

void Forward() 
{ 
  // actionne les deux moteurs du robot avec comme vitesse la valeur de motorSpeed
  motorCommande(motorSpeed, 0);
  motorCommande(motorSpeed, 1); 
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "backward" pour faire reculer le robot
void Backward() 
{ 
  // actionne les deux moteurs du robot avec comme vitesse la valeur de -motorSpeed
  motorCommande(-motorSpeed, 0);
  motorCommande(-motorSpeed, 1); 
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "left" pour faire tourner a gauche le robot
void Left() 
{ 
  // actionne les deux moteurs du robot avec comme vitesse la valeur de motorSpeed pour le moteur 1 et -motorSpeed pour le moteur 0
  motorCommande(-motorSpeed, 0);
  motorCommande(motorSpeed, 1); 
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "right" pour faire tourner a droite le robot
void Right() 
{ 
  // actionne les deux moteurs du robot avec comme vitesse la valeur de -motorSpeed pour le moteur 1 et motorSpeed pour le moteur 0
  motorCommande(motorSpeed, 0);
  motorCommande(-motorSpeed, 1); 
} 

// Fonction callback lors de la publication d'un msg vide sur le topic "stop" pour arreter le robot
void Stop() 
{  
  // arrete les deux moteurs du robot
  motorCommande(0, 0);
  motorCommande(0, 1); 
}

// Transfert des données pour les moteurs vers la carte arduino, envoi des commande au pont en H
void transferData(int val, byte mode)
{
  //adresse du pont en H 001111 sur les selecteurs
  byte address = 128;       

  Serial2.write(address);
  Serial2.write(mode);
  Serial2.write(val);
  Serial2.write((address + mode + val) &  0b01111111);  
}

// Appel le transfert de données en fonction du moteur et de la valeur
void motorCommande(int val, byte mot)
{
  if (mot){
    if (val > 0){
      transferData(val,1);
    }
    else {
      transferData(-val,0);
    }
  }
  else{
    if (val > 0){
      transferData(val,4);
    }
    else {
      transferData(-val,5);
    }
  }
}
