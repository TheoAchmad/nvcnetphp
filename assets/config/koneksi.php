<?php
$host = "localhost";
$user = "ojokerro_theogusss";
$pass = "theoachmadalfareza";
$db   = "ojokerro_nvcnetwork";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Koneksi gagal: " . $conn->connect_error);
}
?>