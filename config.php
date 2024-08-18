<?php
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "db_shopping_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
?>
