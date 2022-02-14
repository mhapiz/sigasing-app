<?php
if (isset($_POST['button_create'])) {

  $nama_lokasi = $_POST['nama_lokasi'];

  $database = new Database();
  $db = $database->getConnection();

  $validateSql = "SELECT * FROM lokasi WHERE nama_lokasi = '$nama_lokasi'";

  $stmt = $db->prepare($validateSql);
  $stmt->execute();

  $count = $stmt->rowCount();

  if ($count > 0) {
    echo "<script>alert('Nama Lokasi sudah ada!');</script>";
  } else {
    $insertSql = "INSERT INTO lokasi SET nama_lokasi = ?";

    $stmt = $db->prepare($insertSql);
    $stmt->bindParam(1, $nama_lokasi);


    if ($stmt->execute()) {

      $_SESSION['hasil'] = true;
      $_SESSION['pesan'] = 'Data berhasil ditambahkan!';
    } else {

      $_SESSION['hasil'] = false;
      $_SESSION['pesan'] = 'Data gagal ditambahkan!';
    }
    echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
  }
}

?>

<section class="content-header">
  <div class="container-fluid">

    <?php
    if (isset($_SESSION['hasil'])) {
      if ($_SESSION['hasil']) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
          <h5>
            <i class="icon fas fa-check"></i>
            Berhasil
          </h5>
          <?= $_SESSION['pesan'] ?>
        </div>
      <?php
      } else {
      ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
          <h5>
            <i class="icon fas fa-ban"></i>
            Gagal
          </h5>
          <?= $_SESSION['pesan'] ?>
        </div>
    <?php
      }
    }

    ?>
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Tambah Data Lokasi</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="?page=home">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a href="?page=lokasiread">Lokasi</a>
          </li>
          <li class="breadcrumb-item active">
            Tambah Data
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-header">
      <h3>Tambah Lokasi</h3>
    </div>
    <div class="card-body">
      <form method="POST">
        <div class="form-group">
          <label>Nama Lokasi</label>
          <input type="text" name="nama_lokasi" class="form-control" placeholder="Nama Lokasi">
        </div>
        <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
          <i class="fa fa-times" aria-hidden="true"></i> Batal
        </a>
        <button type="submit" name="button_create" class="btn btn-success btn-sm float-right">
          <i class="fas fa-save"></i> Simpan
        </button>
      </form>
    </div>
  </div>
</section>