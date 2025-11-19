<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$id_pelanggan = $_POST['id_pelanggan'] ?? '';

if (!$id_pelanggan) {
  exit("❌ ID pelanggan tidak ditemukan.");
}

// Update status pelanggan
$stmt1 = $conn->prepare("UPDATE pelanggan SET status = 'confirmed' WHERE id_pelanggan = ?");
$stmt1->bind_param("i", $id_pelanggan);
$stmt1->execute();

// Masukkan ke tabel pembelian
$stmt2 = $conn->prepare("INSERT INTO pembelian (id_pelanggan, id_paket, tanggal_pembelian)
SELECT id_pelanggan, id_paket, NOW() FROM pelanggan WHERE id_pelanggan = ?");
$stmt2->bind_param("i", $id_pelanggan);
$stmt2->execute();

header("Location: /projeknvcnet/pages/admin/index.php");
exit;
?>