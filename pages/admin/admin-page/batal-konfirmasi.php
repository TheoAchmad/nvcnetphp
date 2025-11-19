<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$id_pelanggan = $_POST['id_pelanggan'] ?? '';

if (!$id_pelanggan) {
  exit("❌ ID pelanggan tidak ditemukan.");
}

// Ubah status pelanggan ke 'nonaktif'
$stmt1 = $conn->prepare("UPDATE pelanggan SET status = 'nonaktif' WHERE id_pelanggan = ?");
$stmt1->bind_param("i", $id_pelanggan);
$stmt1->execute();

// Ubah status pembelian menjadi 'terputus'
$stmt2 = $conn->prepare("UPDATE pembelian SET status_pembelian = 'terputus' WHERE id_pelanggan = ?");
$stmt2->bind_param("i", $id_pelanggan);
$stmt2->execute();

header("Location: /projeknvcnet/pages/admin/index.php");
exit;
?>