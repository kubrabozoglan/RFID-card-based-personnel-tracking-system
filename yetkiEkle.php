<!DOCTYPE html>
<html>
<head>
    <title>Yetki Ekleme</title>
    <style> body { font-family: Arial, sans-serif; } 
    h1 { color: #333; } 
    label { display: block; margin-bottom: 10px; } 
    select, input[type="submit"] { padding: 5px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; } 
    select { width: 200px; } 
    input[type="submit"] { background-color: #1B6B93; color: white; cursor: pointer; } 
    input[type="submit"]:hover { background-color: #164B60; }
    .container{
      position:relative;
      left:40%;
      width:70%;
      margin-top:5%}
        .success-message {
            color: green;
            margin-top: 10px;
            margin-left:40%;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            margin-left:40%;
             
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
	<div class="container">
    <h1>Karta Yetki Verme</h1>

    <?php
    // Veritabanı bağlantısı
    $servername = "localhost";
    $username = "root";
    $password = "kubra123";
    $dbname = "pts";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }

    // Modül adlarını getir
    $modulQuery = "SELECT modul_id, modul_ad FROM Modul  ";
    $modulResult = $conn->query($modulQuery);

    // Kart numaralarını getir
    $kartQuery = "SELECT kart_id, kart_numarasi FROM Kart WHERE isActive = 1";
    $kartResult = $conn->query($kartQuery);
    ?>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="modul">Modül Adı:</label>
        <select name="modul" id="modul">
            <?php
            if ($modulResult->num_rows > 0) {
                while ($row = $modulResult->fetch_assoc()) {
                    echo '<option value="' . $row["modul_id"] . '">' . $row["modul_ad"] . '</option>';
                }
            }
            ?>
        </select>

        <br><br>

        <label for="kart">Kart Numarası:</label>
        <select name="kart" id="kart">
            <?php
            if ($kartResult->num_rows > 0) {
                while ($row = $kartResult->fetch_assoc()) {
                    echo '<option value="' . $row["kart_id"] . '">' . $row["kart_numarasi"] . '</option>';
                }
            }
            ?>
        </select>

        <br><br>

        <label for="isActive">Yetki Durumu</label>
        <select  name="isActive" required>
			<option value="1">Yetkili</option>
			<option value="0">Yetkisiz</option>
         </select>
        <br><br>

        <input type="submit" value="Yetki Ekle">
        <a href="/pts/index2.php" class="link" ><div class="anasayfayadon">Anasayfa</div></a>
    </form>
    </div>

    <?php
    // Form gönderildiğinde çalışacak kod bloğu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Form verilerini al
        $modulId = $_POST['modul'];
        $kartId = $_POST['kart'];
        $isActive = isset($_POST['isActive']) ? 1 : 0;

        // Yetki tablosuna ekle
        $ekleQuery = "INSERT INTO Yetki (kart_id, modul_id, isActive, kayit_tarihi) VALUES ('$kartId', '$modulId', '$isActive', NOW())";

        if ($conn->query($ekleQuery) === TRUE) {
            echo '<p class="success-message">Yetki başarıyla verildi</p>';
        } else {
             echo '<p class="error-message">Veritabanına veri eklenirken hata oluştu: ' . $conn->error . '</p>';
        }
    }

    $conn->close();
    ?>
</body>
</html>
