<!DOCTYPE html>
<html>
<head>
    <title>Kart Ekle</title>
     <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
            text-align:center;
        }
        form { 
            max-width: 300px; 
            margin: 0 auto; 
            padding: 20px; 
            background-color: #fff; 
            border-radius: 5px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); } 

        label {
            display: block;
            margin-top: 10px;
            text-align:center;
            font-weight: bold;
        }
        select{
			margin-left:85px;
		}

        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1B6B93;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left:35%; 
        }

        input[type="submit"]:hover {
            background-color: #164B60;
        }

        .success-message {
            color: green;
            margin-top: 10px;
            margin-left:44%;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            margin-left:44%;
             
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
            margin: 0 auto; 
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
        // Veritabanı bağlantısı için gerekli bilgileri buraya girin
        $servername = "localhost";
        $username = "root";
        $password = "kubra123";
        $dbname = "pts";

        // Formdan gönderilen verileri al
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $kullanici_id = $_POST['kullanici'];
            $kart_id = $_POST['kart'];
            

            // Veritabanı bağlantısını oluştur
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Bağlantıyı kontrol et ve hata varsa ekrana yazdır
            if ($conn->connect_error) {
                die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
            }

            // KullaniciKart tablosuna veri ekle
            $sql = "INSERT INTO kullaniciKart (kullanici_id, kart_id) VALUES ('$kullanici_id', '$kart_id')";
            

            if ($conn->query($sql) === TRUE) {
              echo '<p class="success-message">Yeni kart başarıyla eklendi</p>';
            } else {
                echo '<p class="error-message">Veritabanına veri eklenirken hata oluştu: ' . $conn->error . '</p>';
            }
        

            // Veritabanı bağlantısını kapat
            $conn->close();
        }
    ?>

    <h2>Kullanıcı Kartları</h2>

    <!-- Veri ekleme formunu göster -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="kullanici">Kullanıcı:</label><br>
        <select name="kullanici">
            <?php
                // Veritabanı bağlantısını oluştur
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Bağlantıyı kontrol et ve hata varsa ekrana yazdır
                if ($conn->connect_error) {
                    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
                }

                // Kullanicilar tablosundaki kullanici_ad ve kullanici_soyad verilerini sorgula
                $sql = "SELECT kullanici_id, kullanici_ad, kullanici_soyad FROM Kullanicilar";
                $result = $conn->query($sql);
                

                // Sonuçları kontrol et ve seçenekleri oluştur
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row["kullanici_id"]."'>".$row["kullanici_ad"]." ".$row["kullanici_soyad"]."</option>";
                    }
                } else {
                    echo "<option value=''>Kayıt bulunamadı</option>";
                }

                // Veritabanı bağlantısını kapat
                $conn->close();
            ?>
        </select><br><br>

        <label for="kart">Kart Numarası:</label><br>
        <select name="kart">
            <?php
                // Veritabanı bağlantısını oluştur
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Bağlantıyı kontrol et ve hata varsa ekrana yazdır
                if ($conn->connect_error) {
                    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
                }

                // Kart tablosundaki kart_numarasi verilerini sorgula
                $sql = "SELECT kart_id, kart_numarasi FROM Kart";
                $result = $conn->query($sql);

                // Sonuçları kontrol et ve seçenekleri oluştur
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row["kart_id"]."'>".$row["kart_numarasi"]."</option>";
} 
} else { 
	
	echo "<option value='Kayıt bulunamadı'</option>"; }
            // Veritabanı bağlantısını kapat
            $conn->close();
        ?>
    </select><br><br>

    <input type="submit" value="Kart Ekle">
   <br><br>
        
        <a href="/pts/index2.php" class="link" ><div class="anasayfayadon">Anasayfa</div></a>
    
    
</form>
</body> </html>
