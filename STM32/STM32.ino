// Include the Servo library 
#include <Servo.h> 
// Declare the Servo pin 
//int servoPin = PB6; 
// Create a servo object 
Servo Servo1; 
Servo Servo2;
String Return;
int smokeA0 = PA0;
// Your threshold value
int sensorThres = 1500;
void setup() { 
   // We need to attach the servo to the used pin number 
   Servo1.attach(PB7);
   Servo2.attach(PB6); 
   pinMode(smokeA0, INPUT);
  Serial1.begin(9600);
  pinMode(PB8, OUTPUT);
  pinMode(PC13, OUTPUT);
 digitalWrite(PC13, HIGH);
 Servo2.write(0);
 Servo1.write(0);
}
void loop(){ 
  while (Serial1.available() > 0) {
    Return = Serial1.readString();
  }

  if (Return != "")
  {     
     digitalWrite(PC13, HIGH);
   delay(500);
    digitalWrite(PC13, LOW);
    delay(500);
     digitalWrite(PC13, HIGH);
   delay(500);
   digitalWrite(PC13, LOW);
   if(Return=="o")
{ 
  digitalWrite(PC13, LOW);
   // Make servo go to 90 degrees 
   Servo2.write(90); 
   delay(3000);
   Servo2.write(0);
   delay(3000);
   Return="";
}
 
else if(Return=="g")
{
  int analogSensor = analogRead(smokeA0);
  Serial1.print("Pin A0: ");
  Serial1.println(analogSensor);
  // Checks if it has reached the threshold value
  if (analogSensor > sensorThres)
  {
     digitalWrite(PB8, HIGH);
     delay(1000);                       // wait for a second
  }
  else
  {
     digitalWrite(PB8, LOW);
     delay(1000);                       // wait for a second
  } 
  Return="";
}
   
   // Make servo go to 0 degrees
   //Servo2.write(0);
 

   //delay(1000);
  else if(Return=="p")
   {
   Servo1.write(0); 
   delay(3000); 
   // Make servo go to 90 degrees 
   Servo1.write(90);
   delay(2000); 
   Servo1.write(0);
   Return="";
   } 
}}
