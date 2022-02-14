<?php include_once 'partials/cssdatatables.php'; ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Bagian</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="?page=home"> Home</a>
          </li>
          <li class="breadcrumb-item">Bagian</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>


<div class="content">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Data Bagian</h3>
      <a href="?page=bagiancreate" class="btn btn-success btn-sm float-right">
        <i class="fa fa-plus-circle"></i> Tambah Data</a>
    </div>
    <div class="card-body">
      <table id="mytable" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Bagian</th>
            <th>Nama Kepala Bagian</th>
            <th>Nama Lokasi Bagian</th>
            <th style="width: 150px;">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $database = new Database();
          $db = $database->getConnection();

          $selectSql = "SELECT b.*, k.nama_lengkap AS nama_kepala_bagian, l.nama_lokasi AS nama_lokasi_bagian FROM bagian AS b
          LEFT JOIN karyawan AS k ON b.karyawan_id = k.id
          LEFT JOIN lokasi AS l ON b.lokasi_id = l.id
          ";

          $stmt = $db->prepare($selectSql);
          $stmt->execute();

          $no = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>

            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['nama_bagian'] ?></td>
              <td><?= $row['nama_kepala_bagian'] ?></td>
              <td><?= $row['nama_lokasi_bagian'] ?></td>
              <td>
                <a href="?page=bagianupdate&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                  <i class="fa fa-edit"></i> Edit</a>
                <a href="?page=bagiandelete&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
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
            <th>Nama Bagian</th>
            <th>Nama Kepala Bagian</th>
            <th>Nama Lokasi Bagian</th>
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