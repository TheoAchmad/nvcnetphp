<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$sql = "
  SELECT 
    p.id_pelanggan, p.nama, p.alamat, p.email, p.no_hp,
    pw.nama_paket, p.status
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
      max-width: 1200px;
      margin: 0 auto;
      background: #fff;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      border-radius: 12px;
    }

    .header-wrapper {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      flex-wrap: wrap;
      gap: 15px;
    }

    h2 {
      margin: 0;
      color: var(--text-dark);
      font-weight: 700;
      font-size: 24px;
    }

    .btn-add {
      background-color: var(--primary);
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      box-shadow: 0 2px 5px rgba(52, 152, 219, 0.3);
    }

    .btn-add:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
    }

    /* Table Styling */
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

    /* Specific Column Widths & Truncation */
    .col-limit {
      max-width: 200px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    
    .col-id {
      width: 50px;
      font-weight: 600;
      color: var(--primary);
    }

    /* Status Badges */
    .badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: capitalize;
    }

    .badge.booking {
      background-color: rgba(230, 126, 34, 0.15);
      color: var(--warning);
    }

    .badge.active {
      background-color: rgba(39, 174, 96, 0.15);
      color: var(--success);
    }

    /* Action Buttons */
    .action-group {
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .btn-action {
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 12px;
      font-weight: 600;
      transition: background 0.2s;
      border: 1px solid transparent;
      cursor: pointer;
    }

    .btn-edit {
      color: var(--primary);
      background-color: rgba(52, 152, 219, 0.1);
    }

    .btn-edit:hover {
      background-color: var(--primary);
      color: white;
    }

    .btn-confirm {
      color: var(--success);
      background-color: rgba(39, 174, 96, 0.1);
      border: none;
      display: inline-block;
    }

    .btn-confirm:hover {
      background-color: var(--success);
      color: white;
    }

    .no-data {
      text-align: center;
      padding: 40px;
      color: var(--text-gray);
      font-style: italic;
    }

    .confirm-button.cancel {
  color: #e74c3c;
}
.confirm-button.cancel:hover {
  text-decoration: underline;
}

    /* Mobile Scroll Hint */
    @media (max-width: 768px) {
      .table-responsive {
        box-shadow: inset -5px 0 5px -5px rgba(0,0,0,0.1);
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header-wrapper">
      <h2>Data Pelanggan</h2>
      <a href="/projeknvcnet/pages/admin/admin-page/form-pelanggan.php" class="btn-add">
        <span>+</span> Tambah Pelanggan
      </a>
    </div>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th width="5%">ID</th>
            <th width="15%">Nama</th>
            <th width="20%">Alamat</th>
            <th width="15%">Email</th>
            <th width="10%">No HP</th>
            <th width="15%">Paket</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td class="col-id">#<?= htmlspecialchars($row['id_pelanggan']) ?></td>
                
                <td style="font-weight: 500;">
                    <?= htmlspecialchars($row['nama']) ?>
                </td>
                
                <td class="col-limit" title="<?= htmlspecialchars($row['alamat']) ?>">
                  <?= htmlspecialchars($row['alamat']) ?>
                </td>
                
                <td class="col-limit" title="<?= htmlspecialchars($row['email']) ?>">
                  <?= htmlspecialchars($row['email']) ?>
                </td>
                
                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                
                <td>
                    <?= $row['nama_paket'] ? htmlspecialchars($row['nama_paket']) : '<span style="color:#ccc">-</span>' ?>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="no-data">
                Tidak ada data pelanggan ditemukan.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>