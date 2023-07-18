from pirc522 import RFID
import signal
import time
import datetime
import mysql.connector

import RPi.GPIO as GPIO
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BOARD)
GPIO.setup(11, GPIO.OUT)
GPIO.setup(13, GPIO.OUT)

def blink(pin):
    GPIO.output(pin,GPIO.HIGH)
    time.sleep(1)
    GPIO.output(pin,GPIO.LOW)
    time.sleep(1)
    return

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
        
        yetki = "SELECT Yetki.isActive FROM Yetki JOIN Kart ON Kart.kart_id= Yetki.kart_id  WHERE Kart.kart_numarasi = '"+kart_uid+"'"        
        x.execute(yetki)
        print(yetki)
        durum = x.fetchall()[0][0]
       
        print(durum)
        
        if(durum==1):
            durumMetni="yetki var"            
            for i in range(0,1):
                blink(11)
            
        elif(durum==0):
            durumMetni="yetki yok"            
            for i in range(0,1):
                blink(13)
            
        else:
            durumMetni="yetkisiz erisim"            
            for i in range(0,1):
                blink(13)
                blink(11)
        
        GPIO.cleanup()
        
        if(durumMetni=="yetkisiz erisim"):
            kart_id_durum = -1
        else:
            kart_id ="SELECT kart_id FROM Kart WHERE kart_numarasi = '"+kart_uid+"'"
            x.execute(kart_id)
            kart_id_durum = x.fetchall()[0][0]
            #print(kart_id_durum)        
       
        sql = "INSERT INTO `Durum` (`kart_id`,`modul_id`, `aciklama`,`islem_tarihi`) VALUES (%s, %s, %s, NOW())"
        val = (kart_id_durum, "1", durumMetni)
        x.execute(sql, val)
                
        mydb.commit()
       
      