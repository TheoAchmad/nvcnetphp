<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$sql = "SELECT nama_paket, harga FROM paket_wifi ORDER BY harga ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Paket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #3498db;
      --primary-dark: #2980b9;
      --bg-light: #eef2f7;
      --text-dark: #2c3e50;
      --text-gray: #7f8c8d;
      --success: #27ae60;
      --warning: #e67e22;
      --danger: #e74c3c;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 20px;
      background-color: var(--bg-light);
      color: var(--text-dark);
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      background: #fff;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      border-radius: 12px;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 24px;
      font-weight: 700;
      color: var(--text-dark);
    }

    .table-responsive {
      width: 100%;
      overflow-x: auto;
      border-radius: 8px;
      border: 1px solid #eee;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      white-space: nowrap;
    }

    thead {
      background-color: #f8f9fa;
    }

    th {
      padding: 15px;
      text-align: left;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-gray);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-bottom: 2px solid #eee;
    }

    td {
      padding: 15px;
      font-size: 14px;
      border-bottom: 1px solid #eee;
      vertical-align: middle;
    }

    tr:hover td {
      background-color: #fbfbfb;
    }

    .col-limit {
      max-width: 300px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .price {
      font-weight: 600;
      color: var(--success);
    }

    .no-data {
      text-align: center;
      padding: 40px;
      color: var(--text-gray);
      font-style: italic;
    }

    @media (max-width: 768px) {
      .table-responsive {
        box-shadow: inset -5px 0 5px -5px rgba(0,0,0,0.1);
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Daftar Paket & Harga</h2>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Nama Paket</th>
            <th>Harga</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td class="col-limit"><?= htmlspecialchars($row['nama_paket']) ?></td>
                <td class="price">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="2" class="no-data">Tidak ada data paket tersedia.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>