<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$sql = "
  SELECT 
    p.id_pelanggan, p.nama, p.alamat, p.email, p.no_hp,
    pw.nama_paket
  FROM pelanggan p
  LEFT JOIN paket_wifi pw ON p.id_paket = pw.id_paket
  LIMIT 100
";
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
      padding: 0;
      background-color: #eef2f7;
    }

    .table-container {
      max-width: 1100px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 10px;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #2c3e50;
      font-weight: 600;
      font-size: 24px;
    }

    .actions {
      text-align: right;
      margin-bottom: 15px;
    }

    .actions a {
      background-color: #3498db;
      color: white;
      padding: 10px 16px;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .actions a:hover {
      background-color: #2980b9;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    td {
      padding: 14px 18px;
      text-align: left;
      border-bottom: 1px solid #ddd;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 180px;
}

    th, td {
      padding: 14px 18px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #3498db;
      color: white;
      font-weight: 600;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #ecf6fc;
    }

    .crud-link {
      text-decoration: none;
      margin-right: 10px;
      color: #3498db;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .crud-link:hover {
      color: #21618c;
      text-decoration: underline;
    }

    .no-data {
      text-align: center;
      padding: 20px;
      color: #888;
      font-style: italic;
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
        <th>Paket Wifi</th>
        <th>Aksi</th>
      </tr>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td title="<?= htmlspecialchars($row['nama']) ?>"><?= htmlspecialchars($row['nama']) ?></td>
            <td title="<?= htmlspecialchars($row['alamat']) ?>"><?= htmlspecialchars($row['alamat']) ?></td>
            <td title="<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></td>
            <td title="<?= htmlspecialchars($row['no_hp']) ?>"><?= htmlspecialchars($row['no_hp']) ?></td>
            <td title="<?= htmlspecialchars($row['nama_paket']) ?>"><?= $row['nama_paket'] ? htmlspecialchars($row['nama_paket']) : '-' ?></td>
            <td>
              <a class="crud-link" href="/projeknvcnet/pages/admin/admin-page/form-pelanggan.php?id=<?= $row['id_pelanggan'] ?>">✏️ Edit</a>
              <a class="crud-link" href="/projeknvcnet/pages/admin/admin-page/hapus-pelanggan.php?id=<?= $row['id_pelanggan'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="6">Tidak ada data ditemukan.</td></tr>
      <?php endif; ?>
    </table>
  </div>

</body>
</html>