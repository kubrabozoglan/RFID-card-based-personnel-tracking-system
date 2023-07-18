<!DOCTYPE html>
<html>
<head>
    <title>Yetki Güncelleme</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            display: inline-block;
            margin-bottom: 10px;
        }

        .kart-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .kart-id {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .yetki-durumu {
            margin-bottom: 5px;
        }

        .guncelle-btn {
            background-color: #1B6B93;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            cursor: pointer;
            margin-left:10px;
        }
        .guncelle-btn:hover{
			background-color: #164B60;
			}
            .anasayfayadon{
            margin-top: 20px;
            padding-left: 25px;
            padding-top:10px;
            background-color: #1B6B93;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width:95px;
            height:30px;
            
            }
            
        .anasayfayadon:hover{
            background-color: #164B60;
            }
        .link{
            text-decoration:none;
            }
    </style>
</head>
<body>
    <?php
    // Veritabanı bağlantısı için gerekli bilgileri burada ayarlayın
    $servername = "localhost";
    $username = "root";
    $password = "kubra123";
    $dbname = "pts";

    // Veritabanına bağlanma
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol etme
    if ($conn->connect_error) {
        die("Veritabanına bağlanılamadı: " . $conn->connect_error);
    }
      echo "<a href='/pts/index2.php' class='link' >";
            echo "<div class='anasayfayadon'>Anasayfa";
            echo "</div>";
            echo "</a>";
    // Kart numarasını veritabanından çekme
    $sql = "SELECT DISTINCT * FROM Kart";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Sonuçları döngüyle işleme
        while ($row = $result->fetch_assoc()) {
            $kartNumarasi = $row["kart_numarasi"];
            $kartID = $row["kart_id"];
            $kartIsActive = $row["isActive"];
            
            
            echo "<div class='kart-container'>";
            echo "<div class='kart-id'>Kart Id: " . $kartID . "</div>";
            echo "<div>Kart Numarası: " . $kartNumarasi . "</div>";
            echo "<div class='yetki-durumu'>Aktiflik Durumu: ";
            
            if ($kartIsActive == 1) {
                echo "Aktif";
            } else {
                echo "Pasif";
            }
            
            echo "</div>";
            
            echo "<form action='' method='POST'>";
            echo "<select name='isActive'>";
            echo "<option value='1' " . ($kartIsActive == 1 ? 'selected' : '') . ">Aktif</option>";
            echo "<option value='0' " . ($kartIsActive == 0 ? 'selected' : '') . ">Pasif</option>";
            echo "</select>";
            echo "<input type='hidden' name='kartIDno' value='$kartID'>";
            echo "<input class='guncelle-btn' type='submit' value='Güncelle'>";
            echo "</form>";
            echo "</div>";
            

            // Veri güncelleme işlemi
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $newIsActive = $_POST["isActive"];
                $newkartIDno = $_POST["kartIDno"];

                // Güncelleme sorgusunu oluşturma
                $updateSql = "UPDATE Kart SET isActive = '$newIsActive' WHERE kart_id='$newkartIDno'";

                if ($conn->query($updateSql) === TRUE) {
                    echo "<div class='success-msg'>Veri başarıyla güncellendi.</div>";

                    // isActive değerine göre "aciklama" sütununu güncelleme
                    $aciklama = ($newIsActive == 1) ? "yetki var" : "yetki yok";
                    $updateAciklamaSql = "UPDATE Durum SET aciklama = '$aciklama' WHERE kart_id='$newkartIDno'";

                    if ($conn->query($updateAciklamaSql) === TRUE) {
                        echo "<div class='success-msg'>Durum başarıyla güncellendi.</div>";
                    } else {
                        echo "<div class='error-msg'>Durum güncelleme hatası: " . $conn->error . "</div>";
                        
} 
header("Location:index2.php");
exit();

} else { 
	echo "<div class='error-msg'>Güncelleme hatası: " . $conn->error . "</div>"; 
	}
	}
	 }
	  } else { 
		  echo "<div class='error-msg'>Kayıt bulunamadı.</div>"; 
		  }

// Veritabanı bağlantısını kapatma
$conn->close();
?>
</body> 
</html>
