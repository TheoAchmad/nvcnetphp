<?php
include_once "../../../config/koneksi.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Data Pelanggan
$nama    = $_POST['nama'];
$alamat  = $_POST['alamat'];
$email   = $_POST['email'];
$no_hp   = $_POST['telepon'];

// Pilih Paket
$id_paket = $_POST['jenis_paket'];

// Validasi
if (empty($nama) || empty($id_paket)) {
    echo "❌ Data wajib diisi!";
    exit;
}

// Cek Email
$cek_email = mysqli_query($conn, "SELECT * FROM pelanggan WHERE email = '$email'");
if (mysqli_num_rows($cek_email) > 0) {
    echo "❌ Email sudah terdaftar!";
}

// Simpan Data Pelanggan
$sql_pelanggan = "INSERT INTO pelanggan (nama, alamat, email, no_hp) VALUES ('$nama', '$alamat', '$email', '$no_hp')";
$query_pelanggan = mysqli_query($conn, $sql_pelanggan);

// mengambil id pelanggan
$id_pelanggan = mysqli_insert_id($conn);

// Simpan Pembelian
$sql_pembelian = "INSERT INTO pembelian (id_pelanggan, id_paket, tanggal_pembelian) VALUES ('$id_pelanggan', '$id_paket', NOW())";
$query_pembelian = mysqli_query($conn, $sql_pembelian);

if ($query_pelanggan && $query_pembelian) {
    echo "✅ Data pelanggan dan pembelian berhasil disimpan.";
} else {
    echo "❌ Gagal menyimpan data: " . mysqli_error($conn);
}
?>