<?php include_once 'partials/cssdatatables.php'; ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Karyawan</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="?page=home"> Home</a>
          </li>
          <li class="breadcrumb-item">Karyawan</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>


<div class="content">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Data Karyawan</h3>
      <a href="?page=karyawancreate" class="btn btn-success btn-sm float-right">
        <i class="fa fa-plus-circle"></i> Tambah Data</a>
    </div>
    <div class="card-body">
      <table id="mytable" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama Lengkap</th>
            <th>Jabatan Terkini</th>
            <th>Bagian Terkini</th>
            <th style="width: 150px;">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $database = new Database();
          $db = $database->getConnection();

          $selectSql = "SELECT k.*,
              (
                SELECT j.nama_jabatan FROM jabatan_karyawan AS jk
                INNER JOIN jabatan AS j ON jk.jabatan_id = j.id
                WHERE jk.karyawan_id = k.id ORDER BY jk.tanggal_mulai DESC LIMIT 1
              ) AS jabatan_terkini, 
              (
                SELECT b.nama_bagian FROM bagian_karyawan AS bk
                INNER JOIN bagian AS b ON bk.bagian_id = b.id
                WHERE bk.karyawan_id = k.id ORDER BY bk.tanggal_mulai DESC LIMIT 1
              ) AS bagian_terkini 
          FROM karyawan AS k
          ";

          $stmt = $db->prepare($selectSql);
          $stmt->execute();

          $no = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>

            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['nik'] ?></td>
              <td><?= $row['nama_lengkap'] ?></td>
              <td>
                <a href="?page=karyawanjabatan&id=<?= $row['id'] ?>" class="btn btn-sm btn-info">
                  <i class="fas fa-edit mr-1   "></i> <?= $row['jabatan_terkini'] == null ? 'Belum Ditentukan' : $row['jabatan_terkini'] ?>
                </a>
              </td>
              <td>
                <a href="?page=karyawanbagian&id=<?= $row['id'] ?>" class="btn btn-sm btn-info">
                  <i class="fas fa-edit mr-1   "></i> <?= $row['bagian_terkini'] == null ? 'Belum Ditentukan' : $row['bagian_terkini'] ?>
                </a>
              </td>
              <td>
                <a href="?page=karyawanupdate&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                  <i class="fa fa-edit"></i> Edit</a>
                <a href="?page=karyawandelete&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
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
            <th>NIK</th>
            <th>Nama Lengkap</th>
            <th>Jabatan Terkini</th>
            <th>Bagian Terkini</th>
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