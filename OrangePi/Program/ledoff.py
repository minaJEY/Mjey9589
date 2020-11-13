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

Led=port.PA11
gpio.init()
gpio.setcfg(Led, gpio.OUTPUT)
gpio.output(Led, 0)
