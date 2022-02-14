<?php
$database = new Database();
$db = $database->getConnection();

if (isset($_POST['button_create'])) {

  $nik = $_POST['nik'];
  $nama_lengkap = $_POST['nama_lengkap'];
  $handphone = $_POST['handphone'];
  $email = $_POST['email'];
  $tanggal_masuk = $_POST['tanggal_masuk'];
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $peran = 'USER';

  $validateSql = "SELECT * FROM karyawan WHERE nama_lengkap = '$nama_lengkap' AND nik = '$nik'";

  $stmt = $db->prepare($validateSql);
  $stmt->execute();

  $count = $stmt->rowCount();

  if ($count > 0) {
    echo "<script>alert('Nama karyawan sudah ada!');</script>";
  } else {

    $insert_pengguna_sql = "INSERT INTO pengguna SET username = ? , password = ? , peran = ? ";

    $stmt_insert_pengguna = $db->prepare($insert_pengguna_sql);
    $stmt_insert_pengguna->bindParam(1, $username);
    $stmt_insert_pengguna->bindParam(2, $password);
    $stmt_insert_pengguna->bindParam(3, $peran);
    $stmt_insert_pengguna->execute();

    // cari id pengguna dlus
    $pengguna_last_id_sql = 'SELECT id FROM pengguna ORDER BY id DESC LIMIT 1';
    $stmt_pengguna_last_id = $db->prepare($pengguna_last_id_sql);
    $stmt_pengguna_last_id->execute();
    $pengguna_last_id = $stmt_pengguna_last_id->fetch();
    $pengguna_id = $pengguna_last_id['id'];
    //

    $insert_karyawan_sql = 'INSERT INTO karyawan SET nik = ? , nama_lengkap = ? , handphone = ? , email = ? , tanggal_masuk = ? , pengguna_id = ? ';
    $stmt_insert_karyawan = $db->prepare($insert_karyawan_sql);
    $stmt_insert_karyawan->bindParam(1, $nik);
    $stmt_insert_karyawan->bindParam(2, $nama_lengkap);
    $stmt_insert_karyawan->bindParam(3, $handphone);
    $stmt_insert_karyawan->bindParam(4, $email);
    $stmt_insert_karyawan->bindParam(5, $tanggal_masuk);
    $stmt_insert_karyawan->bindParam(6, $pengguna_id);



    if ($stmt_insert_karyawan->execute()) {

      $_SESSION['hasil'] = true;
      $_SESSION['pesan'] = 'Data berhasil ditambahkan!';
    } else {

      $_SESSION['hasil'] = false;
      $_SESSION['pesan'] = 'Data gagal ditambahkan!';
    }
    echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
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
        <h1>Tambah Data Karyawan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="?page=home">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a href="?page=karyawanread">Karyawan</a>
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
      <h3>Tambah Karyawan </h3>
    </div>
    <div class="card-body">
      <form method="POST">
        <div class="form-group">
          <label>NIK</label>
          <input type="text" name="nik" class="form-control" placeholder="NIK">
        </div>
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap">
        </div>
        <div class="form-group">
          <label>No. Handphone</label>
          <input type="text" name="handphone" class="form-control" placeholder="No. Handphone">
        </div>
        <div class="form-group">
          <label>Email </label>
          <input type="email" name="email" class="form-control" placeholder="Email ">
        </div>
        <div class="form-group">
          <label>Tanggal Masuk </label>
          <input type="date" name="tanggal_masuk" class="form-control" placeholder="Tanggal Masuk ">
        </div>

        <hr>
        <h4>Pengguna</h4>
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" class="form-control" placeholder="Username">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" placeholder="Password">
        </div>

        <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right">
          <i class="fa fa-times" aria-hidden="true"></i> Batal
        </a>
        <button type="submit" name="button_create" class="btn btn-success btn-sm float-right">
          <i class="fas fa-save"></i> Simpan
        </button>
      </form>
    </div>
  </div>
</section>