


/*
 * Fichier où se trouve 
  Une fois cela fait, il va falloir taper le code de vos fonctions. Pour le besoin de l’exercice, je vais me contenter d’écrire des instructions bidons. 
  Dans la vraie vie de tous les jours, vous auriez bien sûr fait un joli code pour communiquer avec un module où je ne sais quoi encore bien sûr 
 */



#include "Programme.h" //fichier header où se trouve nos prototypes

#include <Arduino.h>
#include <Wire.h>
#include <SoftwareSerial.h>


/* Private functions */
#ifdef ME_PORT_DEFINED

MeRGBLineFollower::MeRGBLineFollower(void) : MePort(0)
{
  Device_Address = RGBLINEFOLLOWER_DEFAULT_ADDRESS;
}

MeRGBLineFollower::MeRGBLineFollower(uint8_t port) : MePort(port)
{
  Device_Address = RGBLINEFOLLOWER_DEFAULT_ADDRESS;
}

MeRGBLineFollower::MeRGBLineFollower(uint8_t port, uint8_t address) : MePort(port)
{
  //address0-11, address1-10, address2-01, address3-00
  pinMode(s1, OUTPUT);
  pinMode(s2, OUTPUT);
  if(address == ADDRESS1)
  {
    digitalWrite(s1,HIGH);
    digitalWrite(s2,HIGH);
  }
  else if(address == ADDRESS2)
  {
    digitalWrite(s1,LOW);
    digitalWrite(s2,HIGH);
  }
  else if(address == ADDRESS3)
  {
    digitalWrite(s1,HIGH);
    digitalWrite(s2,LOW);
  }
  else if(address == ADDRESS4)
  {
    digitalWrite(s1,LOW);
    digitalWrite(s2,LOW);
  }
  else
  { 
    digitalWrite(s1,HIGH);
    digitalWrite(s2,HIGH);
    address = ADDRESS1;
  }

  Device_Address = RGBLINEFOLLOWER_DEFAULT_ADDRESS + address;
}
#else  // ME_PORT_DEFINED


MeRGBLineFollower::MeRGBLineFollower(uint8_t AD0, uint8_t INT, uint8_t address)
{
  pinMode(AD0,OUTPUT);
  pinMode(INT,OUTPUT);

  //address0-11, address1-10, address2-01, address3-00
  if(address == ADDRESS1)
  {
    digitalWrite(AD0,HIGH);
    digitalWrite(INT,HIGH);
  }
  else if(address == ADDRESS2)
  {
    digitalWrite(AD0,LOW);
    digitalWrite(INT,HIGH);
  }
  else if(address == ADDRESS3)
  {
    digitalWrite(AD0,HIGH);
    digitalWrite(INT,LOW);
  }
  else if(address == ADDRESS4)
  {
    digitalWrite(AD0,LOW);
    digitalWrite(INT,LOW);
  }
  else
  { 
    digitalWrite(AD0,HIGH);
    digitalWrite(INT,HIGH);
    address = ADDRESS1;
  }

  Device_Address = RGBLINEFOLLOWER_DEFAULT_ADDRESS + address;
}

#endif // ME_PORT_DEFINED


void MeRGBLineFollower::setpin(uint8_t AD0, uint8_t INT)
{
  pinMode(AD0,OUTPUT);
  pinMode(INT,OUTPUT);

#ifdef ME_PORT_DEFINED
  s1 = AD0;
  s2 = INT;
#endif // ME_PORT_DEFINED
}


void MeRGBLineFollower::begin(void)
{
  uint8_t i;
  
  Kp = 0.3;
  study_types = STUDY_IDLE;
  iic_error_count = 0;
  
  Wire.begin();
  delay(10);
}

uint8_t MeRGBLineFollower::getADCValueRGB1(void)
{
  return adcOutput[RGB1_INDEX];
}



uint8_t MeRGBLineFollower::getADCValueRGB2(void)
{
  return adcOutput[RGB2_INDEX];
  Serial.println("Valeur de RGB2 = ");
  Serial.println(adcOutput[RGB2_INDEX]);
  //Serial.println
}


uint8_t MeRGBLineFollower::getADCValueRGB3(void)
{
  return adcOutput[RGB3_INDEX];
}


uint8_t MeRGBLineFollower::getADCValueRGB4(void)
{
  return adcOutput[RGB4_INDEX];
  
}


void MeRGBLineFollower::setKp(float value)
{
  if((value >= 0) && (value <= 1))
  {
    Kp = value;
  }
}

uint8_t MeRGBLineFollower::getStudyTypes(void)
{
  return study_types;
}


void MeRGBLineFollower::updataSensorValue(void)
{
  int8_t return_value;
  
  /* read data */
  return_value = readData(RGBLINEFOLLOWER_DEVICE_ID_ADDR, &i2cData[0], 8);
  if(return_value == I2C_OK)
  {
    if(i2cData[RGBLINEFOLLOWER_DEVICE_ID_ADDR] == RGBLINEFOLLOWER_DEVICE_ID)
    {
      adcOutput[RGB1_INDEX] = i2cData[RGBLINEFOLLOWER_RGB1_ADDR]; Serial.println(adcOutput[RGB1_INDEX]);
      adcOutput[RGB2_INDEX] = i2cData[RGBLINEFOLLOWER_RGB2_ADDR]; Serial.println(adcOutput[RGB2_INDEX]);
      adcOutput[RGB3_INDEX] = i2cData[RGBLINEFOLLOWER_RGB3_ADDR]; Serial.println(adcOutput[RGB3_INDEX]);
      adcOutput[RGB4_INDEX] = i2cData[RGBLINEFOLLOWER_RGB4_ADDR]; Serial.println(adcOutput[RGB4_INDEX]);
    }
    else
    {
      iic_error_count++;  
    }
  }

}


int8_t MeRGBLineFollower::readData(uint8_t start, uint8_t *buffer, uint8_t size)
{
  int16_t i = 0;
  int8_t return_value = 0;

  Wire.beginTransmission(Device_Address);
  return_value = Wire.write(start);
  if(return_value != 1)
  {
    return(I2C_ERROR);
  }
  return_value = Wire.endTransmission(false);
  if(return_value != 0)
  {
    return(return_value);
  }
  delayMicroseconds(1);
  /* Third parameter is true: relase I2C-bus after data is read. */
  Wire.requestFrom(Device_Address, size, (uint8_t)true);
  while(Wire.available() && i < size)
  {
    buffer[i++] = Wire.read();
  }
  delayMicroseconds(1);
  if(i != size)
  {
    return(I2C_ERROR);
  }
  return(0); //return: no error 
}


int8_t MeRGBLineFollower::writeData(uint8_t start, const uint8_t *pData, uint8_t size)
{
  int8_t return_value = 0;
  Wire.beginTransmission(Device_Address);
  return_value = Wire.write(start); 
  if(return_value != 1)
  {
    return(I2C_ERROR);
  }
  Wire.write(pData, size);  
  return_value = Wire.endTransmission(true); 
  return(return_value); //return: no error                     
}

void MeRGBLineFollower::loop(void)
{
  if(millis() - updata_time > 8)  
  {
    updata_time = millis();
    updataSensorValue();
  }

  getADCValueRGB1();
  getADCValueRGB2();
  getADCValueRGB3();
  getADCValueRGB4();
  delay (2000);

}


int8_t MeRGBLineFollower::studyBackground(void)
{
  int8_t return_value = 0;
  uint8_t data = STUDY_BACKGROUND;
  return_value = writeReg(RGBLINEFOLLOWER_STUDY_ADDR, data);
  return(return_value);
}


int8_t MeRGBLineFollower::studyTrack(void)
{
  int8_t return_value = 0;
  uint8_t data = STUDY_TRACK;
  return_value = writeReg(RGBLINEFOLLOWER_STUDY_ADDR, data);
  return(return_value);
}


int8_t MeRGBLineFollower::setRGBColour(uint8_t colour)
{
  int8_t return_value = 0;
  uint8_t data = colour;
  return_value = writeReg(RGBLINEFOLLOWER_SET_RGB_ADDR, data);
  return(return_value);
}


int8_t MeRGBLineFollower::setBackgroundThreshold(uint8_t ch, uint8_t threshold)
{
  int8_t return_value = 0;
  uint8_t data = threshold;

  if(ch > RGB4_INDEX)
  {
    return I2C_ERROR;
  }
  
  return_value = writeReg(RGBLINEFOLLOWER_RGB1_BACKGROUND_THRESHOLD_ADDR + ch, data);
  return(return_value);
}


int8_t MeRGBLineFollower::setTrackThreshold(uint8_t ch, uint8_t threshold)
{
  int8_t return_value = 0;
  uint8_t data = threshold;

  if(ch > RGB4_INDEX)
  {
    return I2C_ERROR;
  }
  
  return_value = writeReg(RGBLINEFOLLOWER_RGB1_TRACK_THRESHOLD_ADDR + ch, data);
  return(return_value);
}


uint8_t MeRGBLineFollower::getBackgroundThreshold(uint8_t ch)
{
  int8_t return_value = 0;
  uint8_t reg = RGBLINEFOLLOWER_RGB1_BACKGROUND_THRESHOLD_ADDR + ch;
  
  if(ch <= RGB4_INDEX)
  {
    return_value = readData(reg, &i2cData[reg], 1);
    delay(50);
    if(return_value == I2C_OK)
    {
      return i2cData[reg];
    }
    return i2cData[reg];
  }
  
  return 0;
}


uint8_t MeRGBLineFollower::getTrackThreshold(uint8_t ch)
{
  int8_t return_value = 0;
  uint8_t reg = RGBLINEFOLLOWER_RGB1_TRACK_THRESHOLD_ADDR + ch;
  
  if(ch <= RGB4_INDEX)
  {
    return_value = readData(reg, &i2cData[reg], 1);
    if(return_value == I2C_OK)
    {
      return i2cData[reg];
    }
    return i2cData[reg];
  }
  
  return 0;
}

void MeRGBLineFollower::getFirmwareVersion(char *buffer)
{
  int8_t return_value = 0;
  uint8_t reg = RGBLINEFOLLOWER_GET_VERSION_ADDR;

  return_value = readData(reg, &i2cData[reg], 8);
  if(return_value == I2C_OK)
  {
    memcpy(buffer, &i2cData[reg], 8);
  }
  memcpy(buffer, &i2cData[reg], 8);
}
