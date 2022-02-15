<?php include_once 'partials/cssdatatables.php';
$tahun = $_GET['tahun'];
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Rekap Penggajian <?= $tahun ?> </h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="?page=home"> Home</a>
          </li>
          <li class="breadcrumb-item">Rekap Penggajian <?= $tahun ?></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>


<div class="content">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Rekap Penggajian Tahun <?= $tahun ?></h3>
      <a href="export/penggajianrekaptahun-pdf.php?tahun=<?= $tahun ?>" class="btn btn-success btn-sm float-right" target="_blank">
        <i class="fas fa-save mr-2   "></i>
        Export PDF</a>
    </div>
    <div class="card-body">
      <table id="mytable" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan</th>
            <th>Uang Makan</th>
            <th>Total</th>
            <th style="width: 70px;">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $database = new Database();
          $db = $database->getConnection();

          $selectSql = " SELECT bulan, tahun, 
                        SUM(p.gapok) jumlah_gapok, 
                        SUM(p.tunjangan) jumlah_tunjangan, 
                        SUM(p.uang_makan) jumlah_makan, 
                        SUM(p.gapok) + SUM(p.tunjangan) + SUM(p.uang_makan) total
                        FROM penggajian AS p WHERE p.tahun = '$tahun'
                        GROUP BY bulan          
          ";

          $stmt = $db->prepare($selectSql);
          $stmt->execute();

          $no = 1;
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
          ?>

            <tr>
              <td><?= $no++ ?></td>
              <td><?= $bulan ?></td>
              <td class="text-right">Rp <?= number_format($row['jumlah_gapok'], 0, ',', '.') ?></td>
              <td class="text-right">Rp <?= number_format($row['jumlah_tunjangan'], 0, ',', '.') ?></td>
              <td class="text-right">Rp <?= number_format($row['jumlah_makan'], 0, ',', '.') ?></td>
              <td class="text-right">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
              <td>
                <a href="?page=penggajianrekapbulan&bulan=<?= $row['bulan'] ?>&tahun=<?= $tahun ?>" class="btn btn-info btn-sm mr-1">
                  <i class="fas fa-info mr-2"></i> Rincian
                </a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan</th>
            <th>Uang Makan</th>
            <th>Total</th>
            <th>Opsi</th>
          </tr>
        </tfoot>
        <tbody>
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