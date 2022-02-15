<?php include_once 'partials/cssdatatables.php';
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
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Rekap Penggajian Bulan <span class="font-weight-bold"><?= $bulan_terbilang ?></span> Tahun <span class="font-weight-bold"><?= $tahun ?></span> </h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="?page=home"> Home</a>
          </li>
          <li class="breadcrumb-item">Rekap Penggajian Bulan <span class="font-weight-bold"><?= $bulan_terbilang ?></span> Tahun <span class="font-weight-bold"><?= $tahun ?></span></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>


<div class="content">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Rekap Penggajian Tahun Bulan <span class="font-weight-bold"><?= $bulan_terbilang ?></span> Tahun <span class="font-weight-bold"><?= $tahun ?></span></h3>
      <a href="export/penggajianrekapbulan-pdf.php?tahun=<?= $tahun ?>&bulan=<?= $bulan ?>" class="btn btn-success btn-sm float-right" target="_blank">
        <i class="fas fa-save mr-2   "></i>
        Export PDF</a>
    </div>
    <div class="card-body">
      <table id="mytable" class="table table-bordered table-hover">
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
        <tbody>
          <?php
          $database = new Database();
          $db = $database->getConnection();
          $selectSql = "SELECT * FROM penggajian as p
                        INNER JOIN karyawan as k ON p.karyawan_id = k.id
                        WHERE p.tahun = '$tahun' AND p.bulan = '$bulan'
          ";

          $stmt = $db->prepare($selectSql);
          $stmt->execute();
          $total_semua = 0;
          $no = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $total = $row['gapok'] + $row['tunjangan'] + $row['uang_makan'];
            $total_semua += $total;
          ?>

            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['nik'] ?></td>
              <td><?= $row['nama_lengkap'] ?></td>
              <td class="text-right">Rp <?= number_format($row['gapok'], 0, ',', '.') ?></td>
              <td class="text-right">Rp <?= number_format($row['tunjangan'], 0, ',', '.') ?></td>
              <td class="text-right">Rp <?= number_format($row['uang_makan'], 0, ',', '.') ?></td>
              <td class="text-right">Rp <?= number_format($total, 0, ',', '.') ?></td>

            </tr>
          <?php
          }
          ?>

        </tbody>
        <tbody>
          <tr>
            <td colspan="6" class="text-center font-weight-bold">Total</td>
            <td class="text-right font-weight-bold">Rp <?= number_format($total_semua, 0, ',', '.') ?> </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>



<?php include_once "partials/scripts.php" ?>
<?php include_once "partials/scriptsdatatables.php" ?>
<script>
  $(function() {
    $('#mytable').DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    }).buttons().container().appendTo('#mytable_wrapper .col-md-6:eq(0)');
  });
</script>