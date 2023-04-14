 #include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 16, 2);

#include <SPI.h>
#include <Ethernet.h>

byte mac[] = { 0xA4, 0x97, 0xB1, 0xD8, 0x28, 0xEB }; //Setting MAC Address

int vcc1 = 5;
int gnd1 = 4;
int vcc2 = 6;
int vcc3 = 7;

//TEGANGAN
int pinTegangan = A1; 
float Vsensor ;//0.0;
float voltase ;//0.0;
float R1 = 30000.0;
float R2 = 7500.0; 

//ARUS
int pinArus = A0;   
int sensitivity = 100;
int adcValue= 0;
int offsetVoltage = 2500;
double adcVoltage = 0;
double currentValue = 0;

//RPM
float REV = 0;
int RPM_VALUE;
int PREVIOUS = 0;
int TIME;


char server[] = "192.200.200.2";
IPAddress ip(192,200,200,1); 
EthernetClient client; 

void setup() {
  //LCD
  lcd.init();
  lcd.backlight();
  lcd.begin(16, 2);
  lcd.setCursor(0, 0);   //KOLOM 0 BARIS 0 = KOLOM 1 BARIS 1
  lcd.print("MONITORING PLTA");        
  lcd.setCursor(0, 1);   //KOLOM 2 BARIS 1 = KOLOM 3 BARIS 2
  lcd.print("TRI ULIA SARI") ;
  delay (2000);
  lcd.clear();
   
  Serial.begin(9600);
  pinMode(pinTegangan, INPUT);
  pinMode(pinArus, INPUT);
  pinMode(vcc1, OUTPUT);
  pinMode(gnd1, OUTPUT);
  pinMode(vcc2, OUTPUT);
  pinMode(vcc3, OUTPUT);
  digitalWrite(vcc1,HIGH);
  digitalWrite(gnd1,LOW);
  digitalWrite(vcc2,HIGH);
  digitalWrite(vcc3, HIGH);
  
  Serial.println("Monitoring PLTA");
  attachInterrupt(1, INTERRUPT, RISING); //RPM di pin 3 digital
  
  if (Ethernet.begin(mac) == 0) {
  Serial.println("Failed to configure Ethernet using DHCP");
  Ethernet.begin(mac, ip);
  }
}
//------------------------------------------------------------------------------

/* Infinite Loop */
void loop(){
  //TEGANGAN
  float nilaiTegangan = analogRead(pinTegangan); 
  //Vsensor = ((nilaiTegangan * 0.00489) * 5 );
  // Vsensor = ((nilaiTegangan * 5.0) / 1024.0);
  // tegangan = abs( Vsensor / (R2/(R1+R2)));
  voltase = map(nilaiTegangan,0,1023,0,2500);
  voltase= (voltase/100) - 0.8;
  if( voltase < 0.5)  voltase = 0;
  Serial.print("Tegangan : ");
  Serial.print(voltase);
  Serial.println(" Volt");
  //delay(1000);

  //ARUS
  //adcValue = analogRead(pinArus);
  //adcVoltage = (adcValue / 1024.0) * 5000;
  //currentValue = abs((adcVoltage - offsetVoltage) / sensitivity);
  
  for(int i =0; i < 1000; i++) {
   currentValue =  currentValue + (.0264 * analogRead(A0) - 13.51)/1000;
  delay(1);
  }
  currentValue =abs(currentValue);
  Serial.print("Arus : ");
  Serial.println(currentValue);
  
  //RPM
  delay(100);
  detachInterrupt(0);                   
  TIME = millis() - PREVIOUS;          
  RPM_VALUE = abs((REV/TIME) * 60000);       
  PREVIOUS = millis();                  
  REV = 0;
  attachInterrupt(1, INTERRUPT, RISING);
  Serial.print("Kecepatan :");
  Serial.print(RPM_VALUE);
  Serial.println(" RPM");
  
 
  //tampilan LCD
  lcd.setCursor(0,0); //Baris 1
  lcd.print("V=");
  lcd.print(voltase,2);
  lcd.print("V");

  lcd.setCursor(8,0); //Baris 1
  lcd.print("A=");
  lcd.print(currentValue,2);
  lcd.print("A");

  lcd.setCursor(0,1); //Baris 2
  lcd.print("RPM = ");
  lcd.print(RPM_VALUE);
  lcd.print(" RPM");
   
  Sending_To_phpmyadmindatabase(); 
  delay(5000); // interval
}


void INTERRUPT()
{
  REV++;
}

void Sending_To_phpmyadmindatabase()   //CONNECTING WITH MYSQL
{
   if (client.connect(server, 80)) {
    Serial.println("connected");
    // Make a HTTP request:
    Serial.print("tegangan=");
    client.print("GET /plta/plta.php?tegangan=");     //YOUR URL
    Serial.println(voltase,1);
    client.print(voltase,1);
    client.print("&arus=");
    Serial.print("arus=");
    client.print(currentValue,1);
    Serial.println(currentValue,1);
    client.print("&rpm=");
    Serial.print("rpm=");
    client.print(RPM_VALUE);
    Serial.println(RPM_VALUE);
    client.print(" ");      //SPACE BEFORE HTTP/1.1 
    client.print("HTTP/1.1");
    client.println();
    client.println("Host: 192.200.200.2");
    client.println("Connection: close");
    client.println();
  } else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
}

//byte mac[] = { 0xDA, 0xE1, 0xE0, 0xBE, 0x34, 0x71 }; //Setting MAC Address
