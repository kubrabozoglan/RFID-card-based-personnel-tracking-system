<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Ekle</title>
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
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 300px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1B6B93;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left:30%; 
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
            margin-left:30%;
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
    // Veritabanı bağlantısı için gerekli bilgileri burada tanımlayın
    $servername = "localhost";
    $username = "root";
    $password = "kubra123";
    $dbname = "pts";

    // Veritabanı bağlantısını oluştur
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
    }

    // Birimlerin veritabanından çekilmesi
    $sql_birim = "SELECT birim_id, birim_ad FROM Birim";
    $result_birim = $conn->query($sql_birim);

    // Form gönderildiğinde çalışacak kod
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Formdaki alanlardan verileri al
        $kullanici_ad = $_POST["kullanici_ad"];
        $kullanici_soyad = $_POST["kullanici_soyad"];
        $kullanici_tel = $_POST["kullanici_tel"];
        $kullanici_mail = $_POST["kullanici_mail"];
        $kullanici_sifre = $_POST["kullanici_sifre"];
        $birim_id = $_POST["birim_id"];

        // Veritabanına veri ekleme sorgusu
        $sql = "INSERT INTO Kullanicilar (kullanici_ad, kullanici_soyad, kullanici_tel, kullanici_mail, kullanici_sifre, birim_id)
                VALUES ('$kullanici_ad', '$kullanici_soyad', '$kullanici_tel', '$kullanici_mail', '$kullanici_sifre', $birim_id)";

        if ($conn->query($sql) === TRUE) {
            echo '<p class="success-message">Yeni kullanıcı başarıyla eklendi</p>';
        } else {
            echo '<p class="error-message">Veritabanına veri eklenirken hata oluştu: ' . $conn->error . '</p>';
        }
    }

    // Veritabanı bağlantısını kapat
    $conn->close();
    ?>

    <h2>Kullanıcı Ekle</h2>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="kullanici_ad">Ad:</label>
        <input type="text" name="kullanici_ad" required>

        <label for="kullanici_soyad">Soyad:</label>
        <input type="text" name="kullanici_soyad" required>

        <label for="kullanici_tel">Telefon:</label>
        <input type="text" name="kullanici_tel" required>

        <label for="kullanici_mail">E-posta:</label>
        <input type="email" name="kullanici_mail" required>
               <label for="birim_id">Birim Adı:</label>
        <select name="birim_id" required>
            <?php
            if ($result_birim->num_rows > 0) {
                while ($row_birim = $result_birim->fetch_assoc()) {
                    echo '<option value="' . $row_birim["birim_id"] . '">' . $row_birim["birim_ad"] . '</option>';
                }
            }
            
            ?>
        </select>
        <br><br>
        <input type="submit" value="Kullanıcı Ekle"><br><br>
        <a href="/pts/index2.php" class="link" ><div class="anasayfayadon">Anasayfa</div></a>
    </form>
</body>
</html>
