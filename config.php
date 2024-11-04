<?php
$servername = "localhost:3306";
$username = "root";
$password = "1234";
$dbname = "aigenerated_analysis";

// Veritabanı bağlantısı
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}
?>
