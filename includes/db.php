<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "suckhoe_canhan";

$conn = new mysqli($servername, $username, $password, $database);
mysqli_set_charset($conn, "utf8");

if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}
?>