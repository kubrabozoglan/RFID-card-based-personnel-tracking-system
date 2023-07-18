from pirc522 import RFID
import signal
import time
import datetime
import mysql.connector

import RPi.GPIO as GPIO
GPIO.setwarnings(False)

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="kubra123",
  database="pts"
)
x = mydb.cursor()
rdr = RFID()
util = rdr.util()
util.debug = True
print("Kart bekleniyor...")
rdr.wait_for_tag()
(error, data) = rdr.request()
 
if not error:
    print("Kart Algilandi!")
    (error, uid) = rdr.anticoll()
    if not error:
        kart_uid = str(uid[0])+" "+str(uid[1])+" "+str(uid[2])+" "+str(uid[3])+" "+str(uid[4])
        print(kart_uid)
        sql = "INSERT INTO `Kart` (`kart_numarasi`, `isActive`) VALUES (%s, %s)"
        val = (kart_uid, "1")
        x.execute(sql, val)
        mydb.commit()
        print("record inserted.")
    
      
     
        



