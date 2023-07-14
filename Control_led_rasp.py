import paho.mqtt.client as mqtt
import json
import RPi.GPIO as GPIO
from tkinter import *
from Read_sensor import on_mqtt
parent = Tk()
var = DoubleVar()
def sel(value):
    pwm.ChangeDutyCycle(value)
ledPin = 12
GPIO.setmode(GPIO.BOARD)
GPIO.setup(ledPin,GPIO.OUT)
GPIO.setwarnings(False)
pwm = GPIO.PWM(ledPin,100)
pwm.start(0)
Scale(parent,variable = var,orient=HORIZONTAL,command = lambda value: sel(var.get())).grid(row=0,column=1)
Label(parent, text = "light").grid(row = 0, column = 0)
Label(parent, text = "temperature").grid(row = 1, column = 0)
lbTemperature = Label(parent, text = ".")
lbTemperature.grid(row = 1, column = 1)
Label(parent, text = "humidity").grid(row = 2, column = 0)
lbHumidity = Label(parent, text = ".")
lbHumidity.grid(row = 2, column = 1)

def on_connect(client, userdata, flags, rc):
    print(f"Connected with result code {rc}")
    # Subscribe, which need to put into on_connect
    # If reconnect after losing the connection with the broker, it will continue to subscribe to the raspberry/topic topic
    client.subscribe("Home/BedRoom/#")

# The callback function, it will be triggered when receiving messages
def on_message(client, userdata, msg):
    #print(f"{msg.topic} {msg.payload}")
    if msg.topic == "Home/BedRoom/DHT22/Humidity":
        json_Dict = json.loads(msg.payload)
        Humidity = json_Dict['Humidity']
        print("Humidity: ",Humidity,"%")
        lbHumidity.config(text = Humidity)
    if msg.topic == "Home/BedRoom/DHT22/Temperature":
        json_Dict = json.loads(msg.payload)
        Temperature = json_Dict['Temperature']
        print("Temperature: ",Temperature)
        lbTemperature.config(text = Temperature)
client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

# Set the will message, when the Raspberry Pi is powered off, or the network is interrupted abnormally, it will send the will message to other clients
client.will_set('raspberry/status', b'{"status": "Off"}')

# Create connection, the three parameters are broker address, broker port number, and keep-alive time respectively
client.connect("192.168.43.13", 1883, 60)
client.loop_start()
# Set the network loop blocking, it will not actively end the program before calling disconnect() or the program crash
#client.loop_forever()
parent.mainloop()

