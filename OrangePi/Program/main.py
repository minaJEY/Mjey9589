import serial
import time
import os
import sys
from pyA20.gpio import gpio
from pyA20.gpio import port
import dht
import datetime
import subprocess
import smtplib
import OPi.GPIO as GPIO
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BOARD)
GPIO.setup(15, GPIO.IN)         #Read output from PIR motion sensor
GPIO.setup(26, GPIO.OUT)         #Read output from PIR motion sensor
GPIO.setup(22, GPIO.OUT)         #Read output from PIR motion sensor
PIN2 = port.PA6
gpio.init()
port = serial.Serial("/dev/ttyS1", baudrate=9600, timeout=3.0)

msg = """From: Smart Home <Smart Home>
MIME-Version: 1.0
Content-type: text/html
Subject: Smart Home

  <div style="color: #fff !important; background-color:#f44336 !important;">
    <h3>Warning!</h3>
    <p>Temperature High</p>
    
  </div>
"""
mailmsg=msg

def set_mail(param):	
	try:
		server="smtp.gmail.com"
        	serveruser="mina.jeyroudi@gmail.com"
        	passw="21051376"
        	user="mina.jeyroudi@gmail.com"
        	server_ssl = smtplib.SMTP_SSL(server, 465)
        	server_ssl.ehlo() # optional, called by login()
        	server_ssl.login(serveruser, passw)  
        	# ssl server doesn't support or need tls, so don't call server_ssl.starttls() 
        	server_ssl.sendmail(serveruser, user, msg)
        	#server_ssl.quit()
        	server_ssl.close()
        	print ('successfully sent the mail')
	except:
		print "err in send mail"


pot=0
gas=0
to=0
ho=0
send_mail=0

while True:
	if(pot==6):
		port.write("p")
		time.sleep(1)
		pot=0

	if(gas==2):	
		port.write("g")
		time.sleep(1)
		gas=0
		srl=port.readline()
		print srl
		with open('/usr/local/bin/gas', 'w') as file:
			file.write(srl)	

	
	i=GPIO.input(15)

	if i==0:                 #When output from motion sensor is LOW
		GPIO.output (26, GPIO.LOW)
		motion= "No movement detected"
		print motion
		with open('/usr/local/bin/motion', 'w') as file:
			file.write(motion)
		time.sleep(3)
		
	elif i==1:               #When output from motion sensor is HIGH
		GPIO.output (26, GPIO.HIGH)
		motion= "Movement detected"
		print motion
		with open('/usr/local/bin/motion', 'w') as file:
			file.write(motion)
		time.sleep(5)


	try:
		instance = dht.DHT(pin=PIN2, sensor=11)
		result = instance.read()
		if result.is_valid():
			ho=result.humidity;
			print ho
			to=result.temperature
			print to
			if(to>=30):
				GPIO.output (22, GPIO.HIGH)
				with open('/usr/local/bin/fan', 'w') as file:
					file.write('on')
				if(send_mail==0):
					set_mail(mailmsg)
					send_mail=1	
				
			else:
				GPIO.output (22, GPIO.LOW)
				with open('/usr/local/bin/fan', 'w') as file:
					file.write('off')
							
			with open('/usr/local/bin/temperatureot', 'w') as file:
			  file.write(str(to))
			with open('/usr/local/bin/humidityot', 'w') as file:
			  file.write(str(ho))

			time.sleep(1)
	except:
		print "err in dht"
	
	gas += 1
	pot += 1



	
	


