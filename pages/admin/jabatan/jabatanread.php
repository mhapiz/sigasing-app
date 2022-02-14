<?php include_once 'partials/cssdatatables.php'; ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Jabatan</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="?page=home"> Home</a>
          </li>
          <li class="breadcrumb-item">Jabatan</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>


<div class="content">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Data Jabatan</h3>
      <a href="?page=jabatancreate" class="btn btn-success btn-sm float-right">
        <i class="fa fa-plus-circle"></i> Tambah Data</a>
    </div>
    <div class="card-body">
      <table id="mytable" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Jabatan</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan</th>
            <th>Uang Makan</th>
            <th style="width: 150px;">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $database = new Database();
          $db = $database->getConnection();

          $selectSql = "SELECT * FROM jabatan";

          $stmt = $db->prepare($selectSql);
          $stmt->execute();

          $no = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>

            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['nama_jabatan'] ?></td>
              <td class="text-right">Rp <?= number_format($row['gapok_jabatan'], 0, ',', '.') ?></td>
              <td class="text-right">Rp <?= number_format($row['tunjangan_jabatan'], 0, ',', '.') ?></td>
              <td class="text-right">Rp <?= number_format($row['uang_makan_perhari'], 0, ',', '.') ?></td>
              <td>
                <a href="?page=jabatanupdate&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                  <i class="fa fa-edit"></i> Edit</a>
                <a href="?page=jabatandelete&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
                  <i class="fa fa-trash"></i> Hapus</a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Nama Jabatan</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan</th>
            <th>Uang Makan</th>
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