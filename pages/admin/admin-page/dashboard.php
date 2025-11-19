<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$sql = "
  SELECT 
    p.id_pelanggan, p.nama, p.alamat, p.email, p.no_hp,
    pw.nama_paket, p.status
  FROM pelanggan p
  LEFT JOIN paket_wifi pw ON p.id_paket = pw.id_paket
  ORDER BY p.id_pelanggan DESC
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
    :root {
      --primary: #3498db;
      --success: #27ae60;
      --warning: #e67e22;
      --danger: #e74c3c;
      --gray: #7f8c8d;
      --bg: #eef2f7;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background: var(--bg);
      margin: 0;
      padding: 20px;
      color: #2c3e50;
    }

    .container {
      max-width: 1200px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    h2 {
      margin-bottom: 25px;
      font-size: 24px;
      font-weight: 700;
    }

    .btn-add {
      background: var(--primary);
      color: #fff;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      float: right;
      margin-top: -50px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #eee;
      text-align: left;
    }

    th {
      background: #f8f9fa;
      font-size: 13px;
      text-transform: uppercase;
      color: var(--gray);
    }

    .badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: capitalize;
    }

    .booking { background: rgba(230, 126, 34, 0.15); color: var(--warning); }
    .confirmed { background: rgba(39, 174, 96, 0.15); color: var(--success); }
    .nonaktif { background: rgba(127, 140, 141, 0.15); color: var(--gray); }

    .action-group {
      display: flex;
      gap: 8px;
    }

    .btn {
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 600;
      border: none;
      cursor: pointer;
    }

    .btn-edit {
      background: rgba(52, 152, 219, 0.1);
      color: var(--primary);
    }

    .btn-confirm {
      background: rgba(39, 174, 96, 0.1);
      color: var(--success);
    }

    .btn-batal {
      background: rgba(231, 76, 60, 0.1);
      color: var(--danger);
    }

    .btn-disabled {
      background: #f0f0f0;
      color: #aaa;
      cursor: not-allowed;
    }

    .no-data {
      text-align: center;
      padding: 40px;
      color: var(--gray);
      font-style: italic;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Data Pelanggan</h2>
    <a href="admin-page/form-pelanggan.php" class="btn-add">+ Tambah</a>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Email</th>
          <th>No HP</th>
          <th>Paket</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php
              $status = $row['status'];
              $badgeClass = match ($status) {
                'booking' => 'booking',
                'confirmed' => 'confirmed',
                'nonaktif' => 'nonaktif',
                default => ''
              };
            ?>
            <tr>
              <td>#<?= $row['id_pelanggan'] ?></td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['alamat']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['no_hp']) ?></td>
              <td><?= $row['nama_paket'] ?? '<span style="color:#ccc">-</span>' ?></td>
              <td><span class="badge <?= $badgeClass ?>"><?= $status ?></span></td>
              <td>
                <div class="action-group">
                  <a href="form-pelanggan.php?id=<?= $row['id_pelanggan'] ?>" class="btn btn-edit">Edit</a>

                  <?php if ($status === 'booking'): ?>
                    <form method="POST" action="admin-page/konfirmasi-pelanggan.php">
                      <input type="hidden" name="id_pelanggan" value="<?= $row['id_pelanggan'] ?>">
                      <button type="submit" class="btn btn-confirm">✅</button>
                    </form>
                  <?php elseif ($status === 'confirmed'): ?>
                    <form method="POST" action="admin-page/batal-konfirmasi.php">
                      <input type="hidden" name="id_pelanggan" value="<?= $row['id_pelanggan'] ?>">
                      <button type="submit" class="btn btn-batal">❌</button>
                    </form>
                  <?php else: ?>
                    <button class="btn btn-disabled" disabled>🚫</button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="8" class="no-data">Tidak ada data pelanggan ditemukan.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>
</html>