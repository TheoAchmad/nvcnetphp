<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ambil data dari form
$id       = $_POST['id'] ?? '';
$nama     = $_POST['nama'] ?? '';
$alamat   = $_POST['alamat'] ?? '';
$email    = $_POST['email'] ?? '';
$no_hp    = $_POST['telepon'] ?? '';
$id_paket = $_POST['id_paket'] ?? '';
$source   = $_POST['source'] ?? ''; // asal form

// Validasi dasar
if (empty($nama)) {
    exit("❌ Nama wajib diisi.");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("❌ Format email tidak valid.");
}

// MODE: UPDATE jika ada ID
if ($id) {
    // Cek email duplikat (kecuali milik sendiri)
    $cek = $conn->prepare("SELECT id_pelanggan FROM pelanggan WHERE email = ? AND id_pelanggan != ?");
    $cek->bind_param("si", $email, $id);
    $cek->execute();
    $cek->store_result();
    if ($cek->num_rows > 0) {
        exit("❌ Email sudah terdaftar oleh pelanggan lain.");
    }

    // Cek no_hp duplikat (kecuali milik sendiri)
    $cek = $conn->prepare("SELECT id_pelanggan FROM pelanggan WHERE no_hp = ? AND id_pelanggan != ?");
    $cek->bind_param("si", $no_hp, $id);
    $cek->execute();
    $cek->store_result();
    if ($cek->num_rows > 0) {
        exit("❌ Nomor HP sudah digunakan oleh pelanggan lain.");
    }

    // Update data
    $stmt = $conn->prepare("UPDATE pelanggan SET nama=?, alamat=?, email=?, no_hp=?, id_paket=? WHERE id_pelanggan=?");
    $stmt->bind_param("ssssii", $nama, $alamat, $email, $no_hp, $id_paket, $id);
    $stmt->execute();

} else {
    // Cek email duplikat
    $cek = $conn->prepare("SELECT id_pelanggan FROM pelanggan WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $cek->store_result();
    if ($cek->num_rows > 0) {
        exit("❌ Email sudah terdaftar.");
    }

    // Cek no_hp duplikat
    $cek = $conn->prepare("SELECT id_pelanggan FROM pelanggan WHERE no_hp = ?");
    $cek->bind_param("s", $no_hp);
    $cek->execute();
    $cek->store_result();
    if ($cek->num_rows > 0) {
        exit("❌ Nomor HP sudah terdaftar.");
    }

    // INSERT pelanggan
    $stmt = $conn->prepare("INSERT INTO pelanggan (nama, alamat, email, no_hp, id_paket) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nama, $alamat, $email, $no_hp, $id_paket);
    $stmt->execute();

    $id_pelanggan = $stmt->insert_id;

    // INSERT pembelian (opsional)
    if (!empty($id_paket)) {
        $stmt2 = $conn->prepare("INSERT INTO pembelian (id_pelanggan, id_paket, tanggal_pembelian) VALUES (?, ?, NOW())");
        $stmt2->bind_param("ii", $id_pelanggan, $id_paket);
        $stmt2->execute();
    }
}

// Redirect sesuai asal
if ($source === 'contact') {
    header("Location: ../../../pages/contact.php");
    exit;
} elseif ($source === 'dashboard') {
    header("Location: ../index.php");
    exit;
} else {
    echo "✅ Data berhasil diproses.";
}
?>