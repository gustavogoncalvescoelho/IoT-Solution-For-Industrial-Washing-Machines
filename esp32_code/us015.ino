// Ultrasonic Sensor US015
// Range 2 cm to 400 cm

#include <WiFiClient.h>
#include <WebServer.h>

// Barrels perfil (Height, diameter and total volume)
float sensorH = 92.0;
float diameter = 52.6;
float volTotal = sq(diameter)*3.14*sensorH/4000;

// Time delay for the device to take the readings (value in ms)
int time_delay = 600000; // 600 000 ms = 10 min

// Pin mode settings for the ESP32
unsigned int triggerPin = 15;
unsigned int echoPin = 4;
unsigned long time_echo_us = 0;

// Variables to be uploaded on database
float distance = 0.0; // Distance measured by the ultrasonic sensor
float vol = 0.0;  // Liquid Volume (l)
int pct = 0;  // Capacity of the reservoir (%)

// Alert system
bool alert = false; // Aviso visual sobre a capacidade utilizada do barril (%)
int alert_low = 20;

const char* ssid = "Name of the Wireless Network";
const char* password = "Password";
const char* host = "Host domain";

// Onboard LED ESP32
#define LED 2

// The number of samples is better defined for 50
// As approached in the Chapter 'Results and Discussions' Subsection 5.1.1
int samples = 50;

// Environment Temperature
float temp = 20;

// System check
float x[2] = {0.0, 0.0};
int cont = 0;

// Readings from the sensor
int us015_distance(){
  float sum_distance = 0.0;
  float aux_distance[samples];

  float vel = 2.005*sqrt(temp+273.15);

  for(int i = 0; i < samples; i++){
    digitalWrite(triggerPin, HIGH);
    delayMicroseconds(30);
    digitalWrite(triggerPin, LOW);

    time_echo_us = pulseIn(echoPin, HIGH, 60000);

    if((time_echo_us < 30000) && (time_echo_us > 1)){
      float aux = (vel*time_echo_us)/(2*1000);
      aux_distance[i] = sqrt((aux*aux) - 2.25);
    }
    else{
      pinMode(echoPin, OUTPUT);
      digitalWrite(echoPin, LOW);
      delay(10);
      pinMode(echoPin, INPUT);
    }
    delay(50);
  }

  for(int j = 0; j < samples; j++){
   sum_distance = sum_distance + aux_distance[j];
  }

  distance = (sum_distance/samples);
  vol = volTotal - (sq(diameter)*3.14*distance/4000);
  pct = (vol/volTotal)*100;

  return distance, vol, pct;
}

void alert_led(){
  if(pct <= alert_low){
    alert = true;
    digitalWrite(LED, HIGH);
  }
  else{
    alert = false;
    digitalWrite(LED, LOW);
  }
}

void blink_led(){
    for(int i = 0; i < 10; i++){
      digitalWrite(LED, HIGH);
      delay(50);
      digitalWrite(LED, LOW);
      delay(50);
    }
}

void print_distance(){
    Serial.print("Distancia: ");
    Serial.print(distance);
    Serial.print("cm ");
    Serial.print("Volume atual: ");
    Serial.print(vol);
    Serial.print("L ");
    Serial.print("Capacidade: ");
    Serial.print(pct);
    Serial.println("%");
}

void setup() {
  pinMode(echoPin, INPUT);
  pinMode(triggerPin, OUTPUT);
  pinMode(LED, OUTPUT);

  us015_distance();
  x[0] = distance;

  Serial.begin(115200);
  delay(100);

  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }

  Serial.println();
  Serial.println("WiFi Connected");
  Serial.println("IP adress: ");
  Serial.println(WiFi.localIP());
  Serial.print("Netmask: ");
  Serial.println(WiFi.subnetMask());
  Serial.print("Gateway: ");
  Serial.println(WiFi.gatewayIP());
}

void loop() {
  x[1] = x[0];
  us015_distance();
  x[0] = distance;

  float dif = abs(x[0] - x[1]);

  if(cont < 5){
    if(dif > 10.0){
      cont++;
      vTaskDelay(pdMS_TO_TICKS(500)); //ticks para ms
      return;
    }else{
      cont = 0;
    }
  }else{
    cont = 0;
  }

  // In case the distance measured is shorter than 2 cm
  if(distance <= 2.0){
    Serial.println("Failed!");
    Serial.println("Distance Zero!");
    Serial.println();
    vTaskDelay(pdMS_TO_TICKS(500)); //ticks para ms
    return;
  }

  if(distance > sensorH){
    Serial.println("Failed!");
    Serial.println("Connect the device at the barrel!");
    Serial.println();
    vTaskDelay(pdMS_TO_TICKS(500));
    return;
  }

 if(isnan(distance)){
    Serial.println("Failed to read from the sensor!");
    Serial.println();
    vTaskDelay(pdMS_TO_TICKS(500));
    return;
  }

  blink_led();
  alert_led();

  print_distance();

  Serial.print("Connecting to ");
  Serial.println(host);

  WiFiClient client;
  const int httpPort = 80;

  if(!client.connect(host, httpPort)){
    Serial.println("Connection failed!");
    return;
  }

  String url = "/api/insert.php?dis=" + String(distance) + "&vol=" + String(vol) + "&pct=" + String(pct);
  Serial.print("Resquesting url: ");
  Serial.println(url);

  client.print(String("GET ") + url + " HTTP/1.1\r\n" + "Host: " + host + "\r\n" + "Connection: close\r\n\r\n");
  delay(500);

  while(client.available()){
    String line = client.readStringUntil('\r');
    Serial.println(line);
  }
  Serial.println("Closing connection");
  Serial.println();

  vTaskDelay(pdMS_TO_TICKS(time_delay));
}
