<!DOCTYPE html>
<html>
<head>
    <title>Personel Takip Sistemi</title>
    <style> body { 
            font-family: Arial, sans-serif; 
            background-color: #f2f2f2; } 
        h2 { color: #333;
             text-align: center; } 
        form { 
            max-width: 300px; 
            margin: 0 auto; 
            padding: 20px; 
            background-color: #fff; 
            border-radius: 5px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); } 
        label { 
            font-weight: bold; 
            display: block; 
            margin-bottom: 5px; } 
        input[type="text"], input[type="password"] { 
            width: 95%; 
            padding: 8px; 
            margin-bottom: 10px; 
            border: 1px solid #ccc; 
            border-radius: 4px; } 
        input[type="submit"] { 
            width: 100%; 
            padding: 8px; 
            background-color: #1B6B93; 
            color: #fff; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; } 
        input[type="submit"]:hover { 
            background-color: #164B60; }
    
        .hata{
             max-width: 300px; 
             height:40px;
             padding-top:20px;
             margin: 0 auto; 
             background-color:#D83A56;
             color:white;
             margin-top:5px;
             text-align:center;
            }
    </style>
</head>
<body>
    <h2>YÖNETİCİ GİRİŞİ</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="kullanici_ad">Kullanıcı Adı:</label>
        <input type="text" name="kullanici_ad" required>

        <label for="kullanici_sifre">Şifre:</label>
        <input type="password" name="kullanici_sifre" required>

        <input type="submit" value="Giriş Yap">
    </form>


<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "kubra123";
$dbname = "pts";

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Veritabanına bağlanılamadı: " . $conn->connect_error);
}

// Formdan gelen verileri al
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici_ad = $_POST["kullanici_ad"];
    $kullanici_sifre = $_POST["kullanici_sifre"];

    // Kullanıcıyı veritabanında ara
    $sql = "SELECT KullaniciRol.*, Rol.rol_ad
            FROM KullaniciRol
            INNER JOIN Rol ON KullaniciRol.rol_id = Rol.rol_id
            WHERE KullaniciRol.isActive = 1
            AND KullaniciRol.kullanici_id = (
                SELECT kullanici_id
                FROM Kullanicilar
                WHERE kullanici_ad = '$kullanici_ad'
                AND kullanici_sifre = '$kullanici_sifre'
            )";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Kullanıcı bulundu, rol kontrolü yap
        $row = $result->fetch_assoc();
        if ($row["rol_ad"] === "admin") {
            header("Location: /pts/index2.php"); 
        } else {
            echo "Bu sayfaya erişim izniniz yok.";
        }
    } else {
        echo "<div class='hata'>Kullanıcı adı veya şifre hatalı.</div>";
    }
}
?>

</body>
</html>
