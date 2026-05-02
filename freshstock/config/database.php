<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "freshstock";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>