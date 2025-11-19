<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$sql = "
  SELECT 
    pb.id_pembelian,
    p.nama AS nama_pelanggan,
    pw.nama_paket,
    pb.tanggal_pembelian,
    pb.status_pembelian
  FROM pembelian pb
  LEFT JOIN pelanggan p ON pb.id_pelanggan = p.id_pelanggan
  LEFT JOIN paket_wifi pw ON pb.id_paket = pw.id_paket
  ORDER BY pb.tanggal_pembelian DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Pembelian</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #eef2f7;
      color: #2c3e50;
    }

    .container {
      max-width: 1100px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 24px;
      font-weight: 700;
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
      color: #7f8c8d;
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

    .no-data {
      text-align: center;
      padding: 40px;
      color: #7f8c8d;
      font-style: italic;
    }

    .date {
      color: #27ae60;
      font-weight: 500;
    }

    .btn-confirm {
      background-color: rgba(39, 174, 96, 0.1);
      color: #27ae60;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    .btn-confirm:hover {
      background-color: #27ae60;
      color: #fff;
    }

    .btn-disabled {
      background-color: #f0f0f0;
      color: #aaa;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: 600;
      border: none;
      cursor: not-allowed;
    }

    .badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: capitalize;
    }

    .badge.aktif {
      background-color: rgba(39, 174, 96, 0.15);
      color: #27ae60;
    }

    .badge.terputus {
      background-color: rgba(127, 140, 141, 0.15);
      color: #7f8c8d;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Riwayat Pembelian</h2>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Pelanggan</th>
            <th>Paket</th>
            <th>Tanggal Pembelian</th>
            <th>Pembayaran Selanjutnya</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <?php
                $tanggal_pembelian = new DateTime($row['tanggal_pembelian']);
                $tanggal_berikutnya = clone $tanggal_pembelian;
                $tanggal_berikutnya->modify('+1 month');
                $statusPembelian = $row['status_pembelian'] ?? 'aktif';
                $badgeClass = $statusPembelian === 'terputus' ? 'terputus' : 'aktif';
              ?>
              <tr>
                <td>#<?= htmlspecialchars($row['id_pembelian']) ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                <td><?= htmlspecialchars($row['nama_paket']) ?></td>
                <td class="date"><?= $tanggal_pembelian->format('d M Y') ?></td>
                <td class="date"><?= $tanggal_berikutnya->format('d M Y') ?></td>
                <td><span class="badge <?= $badgeClass ?>"><?= $statusPembelian ?></span></td>
                <td>
                  <?php if ($statusPembelian === 'aktif'): ?>
                    <form method="POST" action="admin-page/konfirmasi-pembayaran.php" style="margin:0;">
                      <input type="hidden" name="id_pembelian" value="<?= $row['id_pembelian'] ?>">
                      <input type="hidden" name="tanggal_baru" value="<?= $tanggal_berikutnya->format('Y-m-d H:i:s') ?>">
                      <button type="submit" class="btn-confirm">✅</button>
                    </form>
                  <?php else: ?>
                    <button class="btn-disabled" disabled>🚫</button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="no-data">Belum ada data pembelian.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>