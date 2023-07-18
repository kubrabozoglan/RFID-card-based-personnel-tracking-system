
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Personel Takip Sistemi</title>
<link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
 <script src ="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function(){
    $('#tablo').DataTable();
    
});
    </script>
    
    <style>
    body{
        background-color:#EEEEEE;}
        
    .container{
      position:relative;
      left:15%;
      top:10%;
      width:70%;
      margin-top:5%}
      
    .ekle{
       
       background-color:grey;
       width:110px;
       height:26px;
       text-align:center;
       margin-bottom:20px;
       padding-top:4px;
       border
        }
    .link{
            text-decoration:none;
            color:white;}
            
    .navbar { background-color: #537188;
         overflow: hidden; } 
    .navbar a { float: right; 
        font-size:18px;
        display: block; 
        color: white; 
        text-align: center; 
        padding: 14px 16px; 
        text-decoration: none; }
    .nav{
        margin-top:0px;
        }
    </style>
</head>
 
<body>
    <div class="container nav">
    <div class="navbar">
        <a href="/pts/giris.php">Çıkış Yap</a>
        <a href="/pts/yetkiDuzenle.php">Yetki Düzenleme</a>
        <a href="/pts/yetkiEkle.php">Yetki Ekleme</a>
        <a href="/pts/kartAktiflikEkle.php">Kart Aktiflik Durumu</a>
        <a href="/pts/kartEkle.php">Kullanıcı Kart Atama</a>
        <a href="/pts/personelEkle.php">Kullanıcı Ekle</a>
    </div>
    </div>
    <div class='container'>
       
   <table id="tablo" class="display" style="width:100%">
        <thead>
            <tr>
                <th>PERSONEL ADI</th>
                <th>PERSONEL SOYADI</th>
                <th>MODÜL ADI</th>
                <th>DURUM</th>
                <th>İŞLEM ZAMANI</th>
            </tr>
        </thead>
        
                <tfoot>
            <tr>
                <th>personel adı</th>
                <th>personel soyadı</th>
                <th>modül adı</th>
                <th>durum</th>
                <th>işlem zamanı</th>

            </tr>
        </tfoot>
      </div>  
        <?php
        
        error_reporting(0);
$servername= "localhost";
$username= "root";
$password="kubra123";
$dbname= "pts";


$conn = new mysqli($servername, $username, $password, $dbname);
$new = mysqli_set_charset($conn, "utf8");
if($conn-> connect_error){
	
	die("Bağlantı hatası: " . $conn->connect_error);	
}

$query = "SELECT * FROM Kullanicilar JOIN kullaniciKart ON Kullanicilar.kullanici_id=kullaniciKart.kullanici_id JOIN Durum ON kullaniciKart.kart_id=Durum.kart_id JOIN Modul ON Durum.modul_id=Modul.modul_id";
$result = $conn->query($query);


if ($result->num_rows > 0) {

  
    while($row = $result->fetch_assoc()) {
       if($row["aciklama"] == "yetki var"){
        echo "<tr style='background-color:#03C988;'>";
        echo "<td>".$row["kullanici_ad"]."</td>";
        echo "<td>".$row["kullanici_soyad"]."</td>";
        echo "<td>".$row["modul_ad"]."</td>";
        echo "<td>".$row["aciklama"]."</td>";
        echo "<td>".$row["islem_tarihi"]."</td>";        
        echo "</tr>";          
       }
       elseif($row["aciklama"] == "yetki yok"){
        echo "<tr style='background-color:#D83A56;'>";
        echo "<td>".$row["kullanici_ad"]."</td>";
        echo "<td>".$row["kullanici_soyad"]."</td>";
        echo "<td>".$row["modul_ad"]."</td>";
        echo "<td>".$row["aciklama"]."</td>";
        echo "<td>".$row["islem_tarihi"]."</td>";        
        echo "</tr>";
      }
      else{
        echo "<tr style='background-color:#F98404;'>";
        echo "<td>".$row["kullanici_ad"]."</td>";
        echo "<td>".$row["kullanici_soyad"]."</td>";
        echo "<td>".$row["modul_ad"]."</td>";
        echo "<td>".$row["aciklama"]."</td>";
        echo "<td>".$row["islem_tarihi"]."</td>";        
        echo "</tr>";
         }
    }

    echo "</table>";

} else {
    echo "Kayıt bulunamadı.";
}

$conn->close();

?>
        
        
        
    </table>
    
    </body>
    </html>
    
