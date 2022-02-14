<?php
if (isset($_POST['button_create'])) {

  $nama_jabatan = $_POST['nama_jabatan'];
  $gapok_jabatan = $_POST['gapok_jabatan'];
  $tunjangan_jabatan = $_POST['tunjangan_jabatan'];
  $uang_makan_perhari = $_POST['uang_makan_perhari'];

  $database = new Database();
  $db = $database->getConnection();

  $validateSql = "SELECT * FROM jabatan WHERE nama_jabatan = '$nama_jabatan'";

  $stmt = $db->prepare($validateSql);
  $stmt->execute();

  $count = $stmt->rowCount();

  if ($count > 0) {
    echo "<script>alert('Nama Jabatan sudah ada!');</script>";
  } else {
    $insertSql = "INSERT INTO jabatan SET nama_jabatan = ? , gapok_jabatan = ? , tunjangan_jabatan = ? , uang_makan_perhari = ?";

    $stmt = $db->prepare($insertSql);
    $stmt->bindParam(1, $nama_jabatan);
    $stmt->bindParam(2, $gapok_jabatan);
    $stmt->bindParam(3, $tunjangan_jabatan);
    $stmt->bindParam(4, $uang_makan_perhari);



    if ($stmt->execute()) {

      $_SESSION['hasil'] = true;
      $_SESSION['pesan'] = 'Data berhasil ditambahkan!';
    } else {

      $_SESSION['hasil'] = false;
      $_SESSION['pesan'] = 'Data gagal ditambahkan!';
    }
    echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
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
        <h1>Tambah Data Jabatan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="?page=home">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a href="?page=jabatanread">Jabatan</a>
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
      <h3>Tambah Jabatan</h3>
    </div>
    <div class="card-body">
      <form method="POST">
        <div class="form-group">
          <label>Nama Jabatan</label>
          <input type="text" name="nama_jabatan" class="form-control" placeholder="Nama Jabatan">
        </div>
        <div class="form-group">
          <label>Gaji Pokok Jabatan</label>
          <input type="number" name="gapok_jabatan" class="form-control" placeholder="Gaji Pokok Jabatan" onkeypress="return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46">
        </div>
        <div class="form-group">
          <label>Tunjangan Jabatan</label>
          <input type="number" name="tunjangan_jabatan" class="form-control" placeholder="Tunjangan Jabatan" onkeypress="return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46">
        </div>
        <div class="form-group">
          <label>Uang Makan Perhari</label>
          <input type="number" name="uang_makan_perhari" class="form-control" placeholder="Uang Makan Perhari" onkeypress="return (event.charCode > 47 && event.charCode < 58) || event.charCode == 46">
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