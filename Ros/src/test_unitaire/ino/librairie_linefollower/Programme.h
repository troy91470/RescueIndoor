/* Define to prevent recursive inclusion -------------------------------------*/

/*
 * https://stackoverflow-com.translate.goog/questions/3246803/why-use-ifndef-class-h-and-define-class-h-in-h-file-but-not-in-cpp?_x_tr_sl=en&_x_tr_tl=fr&_x_tr_hl=fr&_x_tr_pto=sc
 */
#ifndef Programme_H
#define Programme_H


/*

Pour l’utilisateur d’une bibliothèque, les prototypes sont situés dans un fichier particulier appelé fichier en-tête, d’extension .h (Header).
Ce fichier en‐tête doit être inclus (recopié) au sommet du fichier source .cpp qui utilise la fonction, grâce à la directive :

 orsque l’on veut séparer son code en plusieurs fichiers, il y a certaines choses à respecter. 
 Ainsi, à chaque fois que l’on veut créer un nouveau fichier de code on ne vas pas en créer un mais deux ! 
 Le premier fichier aura l’extension .h signifiant header , c’est ce que nous allons voir maintenant. 
 Ce fichier va regrouper les prototypes des fonctions ainsi que les définitions de structures ou de classes mais nous verrons cela après. 
 Le prototype d’une fonction représente un peu un contrat. 
 Il va définir le nom de la fonction, ce qui rentre à l’intérieur (les paramètres) et ce qui en sort (la variable de retour). 
 Ainsi, votre programme principal aura une idée de comment fonctionne extérieurement votre fonction.
 Un peu comme s’il s’adressait à une boîte noire. Si l’on devait écrire l’exemple ci-dessus on pourrait avoir le contenu de fichier suivant :
 Voir: https://eskimon.fr/tuto-arduino-905-organisez-votre-code-en-fichiers#s%C3%A9parer-en-fichiers
 */

/* Includes ------------------------------------------------------------------*/
/*
 * Les bibliothéques
 */
#include <stdint.h>
#include <stdbool.h>
#include <Arduino.h>
#include "MeConfig.h"
#ifdef ME_PORT_DEFINED
#include "MePort.h"
#endif // ME_PORT_DEFINED

/* Exported macro ------------------------------------------------------------*/
#define I2C_ERROR                              (-1)
#define I2C_OK                                (0)
#define RGBLINEFOLLOWER_DEFAULT_ADDRESS      (0x20)
#define RGBLINEFOLLOWER_DEVICE_ID             (0xFA)

//RGBLineFollower IIC Register Address
#define RGBLINEFOLLOWER_DEVICE_ID_ADDR                  (0x00)
#define RGBLINEFOLLOWER_RGB1_ADDR                       (0x01)
#define RGBLINEFOLLOWER_RGB2_ADDR                       (0x02)
#define RGBLINEFOLLOWER_RGB3_ADDR                       (0x03)
#define RGBLINEFOLLOWER_RGB4_ADDR                       (0x04)
#define RGBLINEFOLLOWER_TURNOFFSET_L_ADDR               (0x05)
#define RGBLINEFOLLOWER_TURNOFFSET_H_ADDR               (0x06)
#define RGBLINEFOLLOWER_STATE_ADDR                      (0x07)
#define RGBLINEFOLLOWER_RGB1_BACKGROUND_THRESHOLD_ADDR  (0x08)
#define RGBLINEFOLLOWER_RGB2_BACKGROUND_THRESHOLD_ADDR  (0x09)
#define RGBLINEFOLLOWER_RGB3_BACKGROUND_THRESHOLD_ADDR  (0x0A)
#define RGBLINEFOLLOWER_RGB4_BACKGROUND_THRESHOLD_ADDR  (0x0B)
#define RGBLINEFOLLOWER_RGB1_TRACK_THRESHOLD_ADDR       (0x0C)
#define RGBLINEFOLLOWER_RGB2_TRACK_THRESHOLD_ADDR       (0x0D)
#define RGBLINEFOLLOWER_RGB3_TRACK_THRESHOLD_ADDR       (0x0E)
#define RGBLINEFOLLOWER_RGB4_TRACK_THRESHOLD_ADDR       (0x0F)
#define RGBLINEFOLLOWER_GET_VERSION_ADDR                (0x10)
#define RGBLINEFOLLOWER_STUDY_ADDR                      (0x31)
#define RGBLINEFOLLOWER_SET_RGB_ADDR                    (0x32)


//RGBLineFollower index
#define RGB1_INDEX    0
#define RGB2_INDEX    1
#define RGB3_INDEX    2
#define RGB4_INDEX    3

//RGBLineFollower number
#define RGBLINEFOLLOWER_NUM            (0x04)

//address
#define ADDRESS1    0
#define ADDRESS2    1
#define ADDRESS3    2
#define ADDRESS4    3

//study types
#define STUDY_IDLE          0
#define STUDY_BACKGROUND    1
#define STUDY_TRACK         2


//RGB culour
#define RGB_COLOUR_RED      1
#define RGB_COLOUR_GREEN    2
#define RGB_COLOUR_BLUE     3



#ifndef ME_PORT_DEFINED   // #ifndef = IF Not DEFined (si ce n'est pas défini)

class MeRGBLineFollower

#else // !ME_PORT_DEFINED


 /// Déclaration de la classe MeRGBLineFollower 

 /*
  * Rappel sur les classes en Arduino: https://www.locoduino.org/spip.php?article87
  */
 
class MeRGBLineFollower : public MePort
#endif // !ME_PORT_DEFINED
{
  public:
    #ifdef ME_PORT_DEFINED
      MeRGBLineFollower(void);
      MeRGBLineFollower(uint8_t port);
      MeRGBLineFollower(uint8_t port, uint8_t address);
    #else
      MeRGBLineFollower(uint8_t AD0, uint8_t INT, uint8_t address);
    #endif  //  ME_PORT_DEFINED
      void setpin(uint8_t AD0, uint8_t INT);
      void begin();
      uint8_t getDevAddr(void);
      uint8_t getADCValueRGB1(void); // Fonction permettant de connaitre la valeur de RGB1
      uint8_t getADCValueRGB2(void); // Fonction permettant de connaitre la valeur de RGB2
      uint8_t getADCValueRGB3(void); // Fonction permettant de connaitre la valeur de RGB3
      uint8_t getADCValueRGB4(void); // Fonction permettant de connaitre la valeur de RGB4
      void setKp(float value);
      void updataSensorValue(void);
      uint8_t getStudyTypes(void);
      int8_t studyBackground(void);
      int8_t studyTrack(void);
      int8_t getThreshold(void);
      int8_t setRGBColour(uint8_t colour);
      int8_t setBackgroundThreshold(uint8_t ch, uint8_t threshold);
      int8_t setTrackThreshold(uint8_t ch, uint8_t threshold);
      uint8_t getBackgroundThreshold(uint8_t ch);
      uint8_t getTrackThreshold(uint8_t ch);
      void getFirmwareVersion(char *buffer);
      void loop(void);
  
  
private: // Déclarations des Attributs + fonctions 
      uint8_t i2cData[25];
      uint8_t adcOutput[RGBLINEFOLLOWER_NUM];
      uint8_t Device_Address;
      float Kp;
      uint8_t study_types;
      uint32_t iic_error_count;
      unsigned long updata_time;
      int8_t writeReg(uint8_t reg, uint8_t data);
      int8_t readData(uint8_t start, uint8_t *buffer, uint8_t size);
      int8_t writeData(uint8_t start, const uint8_t *pData, uint8_t size);
 
};
#endif //  Fin de "#ifndef Programme_H"

/*
 * #ifndef FILE_H
   #define FILE_H
   
 ... Declarations etc here ...
 
    #endif
 */
