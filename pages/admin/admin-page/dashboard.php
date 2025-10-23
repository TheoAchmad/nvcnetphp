<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$sql = "SELECT id_pelanggan, nama, alamat, email, no_hp FROM pelanggan LIMIT 100";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pelanggan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f9f9f9;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .table-container {
      max-width: 1000px;
      margin: auto;
      background: #fff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 8px;
    }

    .actions {
      text-align: right;
      margin-bottom: 10px;
    }

    .actions a {
      background-color: #0077cc;
      color: white;
      padding: 8px 12px;
      text-decoration: none;
      border-radius: 4px;
      font-weight: 600;
    }

    .actions a:hover {
      background-color: #005fa3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #0077cc;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #e6f7ff;
    }

    .crud-link {
      text-decoration: none;
      margin-right: 8px;
      color: #0077cc;
      font-weight: 600;
    }

    .crud-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="table-container">
    <h2>Data Pelanggan</h2>

    <div class="actions">
      <a href="/projeknvcnet/pages/admin/admin-page/form-pelanggan.php">+ Tambah Pelanggan</a>
    </div>

    <table>
      <tr>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Email</th>
        <th>No HP</th>
        <th>Aksi</th>
      </tr>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['alamat']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['no_hp']) ?></td>
            <td>
              <a class="crud-link" href="/projeknvcnet/pages/admin/admin-page/form-pelanggan.php?id=<?= $row['id_pelanggan'] ?>">✏️ Edit</a>
              <a class="crud-link" href="/projeknvcnet/pages/admin/admin-page/hapus-pelanggan.php?id=<?= $row['id_pelanggan'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">Tidak ada data ditemukan.</td></tr>
      <?php endif; ?>
    </table>
  </div>

</body>
</html>