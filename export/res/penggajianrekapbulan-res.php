<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];

switch ($bulan) {
  case '01':
    $bulan_terbilang = 'Januari';
    break;
  case '02':
    $bulan_terbilang = 'Februari';
    break;
  case '03':
    $bulan_terbilang = 'Maret';
    break;
  case '04':
    $bulan_terbilang = 'April';
    break;
  case '05':
    $bulan_terbilang = 'Mei';
    break;
  case '06':
    $bulan_terbilang = 'Juni';
    break;
  case '07':
    $bulan_terbilang = 'Juli';
    break;
  case '08':
    $bulan_terbilang = 'Agustus';
    break;
  case '09':
    $bulan_terbilang = 'September';
    break;
  case '10':
    $bulan_terbilang = 'Oktober';
    break;
  case '11':
    $bulan_terbilang = 'November';
    break;
  case '12':
    $bulan_terbilang = 'Desember';
    break;

  default:
    $bulan_terbilang = '...';
    break;
}
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
<span style="font-size: 20px; font-weight: bold">Rekapitulasi Penggajian Bulan <?= $bulan_terbilang ?> Tahun <?= $tahun ?><br></span>
<br>
<br>
<table>
  <colgroup>
    <col style="width: 6%">
    <col style="width: 10%; text-align: center;">
    <col style="width: 22%">
    <col style="width: 15%" class="angka">
    <col style="width: 15%" class="angka">
    <col style="width: 15%" class="angka">
    <col style="width: 17%" class="angka">
  </colgroup>
  <thead>
    <tr>
      <th>No</th>
      <th>NIK</th>
      <th>Nama Lengkap</th>
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


  $selectSql = "SELECT * FROM penggajian as p
                INNER JOIN karyawan as k ON p.karyawan_id = k.id
                WHERE p.tahun = '$tahun' AND p.bulan = '$bulan'
  ";

  $stmt = $db->prepare($selectSql);
  $stmt->execute();
  $no = 1;
  $total_jumlah_gapok = 0;
  $total_jumlah_tunjangan = 0;
  $total_jumlah_uang_makan = 0;
  $total_semua = 0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


    $total = $row['gapok'] + $row['tunjangan'] + $row['uang_makan'];

    $total_jumlah_gapok += $row['gapok'];
    $total_jumlah_tunjangan += $row['tunjangan'];
    $total_jumlah_uang_makan += $row['uang_makan'];
    $total_semua += $total;
  ?>
    <tr>
      <td style="text-align: center;"><?= $no++ ?></td>
      <td><?= $row['nik'] ?></td>
      <td><?= $row['nama_lengkap'] ?></td>
      <td>Rp <?= number_format($row['gapok'], 0, ',', '.') ?></td>
      <td>Rp <?= number_format($row['tunjangan'], 0, ',', '.') ?></td>
      <td>Rp <?= number_format($row['uang_makan'], 0, ',', '.') ?></td>
      <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
    </tr>
  <?php
  }
  ?>
  <tr>
    <td colspan="3" style="text-align: center;font-weight: bold;">Grand Total</td>
    <td style="font-weight: bold;"><?= 'Rp ' . number_format($total_jumlah_gapok, 0, ',', '.') ?></td>
    <td style="font-weight: bold;"><?= 'Rp ' . number_format($total_jumlah_tunjangan, 0, ',', '.') ?></td>
    <td style="font-weight: bold;"><?= 'Rp ' . number_format($total_jumlah_uang_makan, 0, ',', '.') ?></td>
    <td style="font-weight: bold;"><?= 'Rp ' . number_format($total_semua, 0, ',', '.') ?></td>
  </tr>
</table>