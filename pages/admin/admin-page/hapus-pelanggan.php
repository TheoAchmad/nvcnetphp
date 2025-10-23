<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$id = $_GET['id'] ?? '';

if ($id) {
  // Hapus pembelian dulu (jika ada relasi)
  $stmt1 = $conn->prepare("DELETE FROM pembelian WHERE id_pelanggan = ?");
  $stmt1->bind_param("i", $id);
  $stmt1->execute();

  // Hapus pelanggan
  $stmt2 = $conn->prepare("DELETE FROM pelanggan WHERE id_pelanggan = ?");
  $stmt2->bind_param("i", $id);
  $stmt2->execute();

  header("Location: ../index.php");
  exit;
} else {
  echo "❌ ID tidak ditemukan.";
}
?>