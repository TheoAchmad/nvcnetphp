<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$id = $_GET['id'] ?? '';
$edit = false;
$data = ['nama'=>'', 'alamat'=>'', 'email'=>'', 'no_hp'=>''];

if ($id) {
  $edit = true;
  $stmt = $conn->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();
}
?>

<h2><?= $edit ? 'Edit' : 'Tambah' ?> Pelanggan</h2>
<form action="proses-pelanggan.php" method="POST">
  <input type="hidden" name="source" value="dashboard">
  <?php if ($edit): ?>
    <input type="hidden" name="id" value="<?= $id ?>">
  <?php endif; ?>
  <input type="text" name="nama" placeholder="Nama" value="<?= $data['nama'] ?>" required><br>
  <input type="text" name="alamat" placeholder="Alamat" value="<?= $data['alamat'] ?>"><br>
  <input type="email" name="email" placeholder="Email" value="<?= $data['email'] ?>"><br>
  <input type="text" name="telepon" placeholder="No HP" value="<?= $data['no_hp'] ?>"><br>
  <button type="submit"><?= $edit ? 'Update' : 'Simpan' ?></button>
</form>