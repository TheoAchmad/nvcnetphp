<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$id_pembelian = $_POST['id_pembelian'] ?? '';
$tanggal_baru = $_POST['tanggal_baru'] ?? '';

if ($id_pembelian && $tanggal_baru) {
  $stmt = $conn->prepare("UPDATE pembelian SET tanggal_pembelian = ? WHERE id_pembelian = ?");
  $stmt->bind_param("si", $tanggal_baru, $id_pembelian);
  $stmt->execute();
}

header("Location: /projeknvcnet/pages/admin/index.php?page=pembelian");
exit;
?>