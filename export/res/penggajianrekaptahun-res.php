<?php
$tahun = $_GET['tahun'];
?>
<style type="text/css">
  table {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  th {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
  }

  td {
    border: 1px solid black;
    padding: 8px;
  }

  td.angka {
    text-align: right;
  }
</style>
<span style="font-size: 20px; font-weight: bold">Rekapitulasi Penggajian Tahun <?= $tahun ?><br></span>
<br>
<br>
<table>
  <colgroup>
    <col style="width: 5%" class="angka">
    <col style="width: 15%" class="angka">
    <col style="width: 20%" class="angka">
    <col style="width: 20%" class="angka">
    <col style="width: 20%" class="angka">
    <col style="width: 20%" class="angka">
  </colgroup>
  <thead>
    <tr>
      <th>No</th>
      <th>Bulan</th>
      <th>Gaji Pokok</th>
      <th>Tunjangan</th>
      <th>Uang Makan</th>
      <th>Total</th>
    </tr>
  </thead>
  <?php
  include "../database/database.php";
  $database = new Database();
  $db = $database->getConnection();


  $selectSql = " SELECT bulan, tahun, 
    SUM(p.gapok) jumlah_gapok, 
    SUM(p.tunjangan) jumlah_tunjangan, 
    SUM(p.uang_makan) jumlah_uang_makan, 
    SUM(p.gapok) + SUM(p.tunjangan) + SUM(p.uang_makan) total
    FROM penggajian AS p WHERE p.tahun = '$tahun'
    GROUP BY bulan          
  ";

  $stmt = $db->prepare($selectSql);
  $stmt->execute();
  $no = 1;
  $total_jumlah_gapok = 0;
  $total_jumlah_tunjangan = 0;
  $total_jumlah_uang_makan = 0;
  $total_total = 0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    switch ($row['bulan']) {
      case '01':
        $bulan = 'Januari';
        break;
      case '02':
        $bulan = 'Februari';
        break;
      case '03':
        $bulan = 'Maret';
        break;
      case '04':
        $bulan = 'April';
        break;
      case '05':
        $bulan = 'Mei';
        break;
      case '06':
        $bulan = 'Juni';
        break;
      case '07':
        $bulan = 'Juli';
        break;
      case '08':
        $bulan = 'Agustus';
        break;
      case '09':
        $bulan = 'September';
        break;
      case '10':
        $bulan = 'Oktober';
        break;
      case '11':
        $bulan = 'November';
        break;
      case '12':
        $bulan = 'Desember';
        break;

      default:
        $bulan = '...';
        break;
    }

    $total_jumlah_gapok += $row['jumlah_gapok'];
    $total_jumlah_tunjangan += $row['jumlah_tunjangan'];
    $total_jumlah_uang_makan += $row['jumlah_uang_makan'];
    $total_total += $row['total'];
  ?>
    <tr>
      <td style="text-align: center;"><?= $no++ ?></td>
      <td><?= $bulan ?></td>
      <td><?= 'Rp ' . number_format($row['jumlah_gapok'], 0, ',', '.') ?></td>
      <td><?= 'Rp ' . number_format($row['jumlah_tunjangan'], 0, ',', '.') ?></td>
      <td><?= 'Rp ' . number_format($row['jumlah_uang_makan'], 0, ',', '.') ?></td>
      <td><?= 'Rp ' . number_format($row['total'], 0, ',', '.') ?></td>
    </tr>
  <?php
  }
  ?>
  <tr>
    <td colspan="2">Grand Total</td>
    <td><?= 'Rp ' . number_format($total_jumlah_gapok, 0, ',', '.') ?></td>
    <td><?= 'Rp ' . number_format($total_jumlah_tunjangan, 0, ',', '.') ?></td>
    <td><?= 'Rp ' . number_format($total_jumlah_uang_makan, 0, ',', '.') ?></td>
    <td><?= 'Rp ' . number_format($total_total, 0, ',', '.') ?></td>
  </tr>
</table>