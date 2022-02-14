<?php
if (isset($_GET['id'])) {

  $database = new Database();
  $db = $database->getConnection();

  $id = $_GET['id'];
  $findSql = "SELECT karyawan.*, pengguna.username FROM karyawan INNER JOIN pengguna ON pengguna.id = karyawan.pengguna_id WHERE karyawan.id = ?";
  $stmt = $db->prepare($findSql);
  $stmt->bindParam(1, $id);
  $stmt->execute();
  $row = $stmt->fetch();
  if (isset($row['id'])) {

    if (isset($_POST['button_update'])) {
      $updateSql = "SELECT * FROM karyawan WHERE nama_lengkap = ? AND id = ?";
      $stmt = $db->prepare($updateSql);
      $stmt->bindParam(1, $_POST['nama_lengkap']);
      $stmt->bindParam(2, $_POST['id']);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
?>
        <div class="alert alert-danger alert-dismissible">
          <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
          <h5><i class="icon fas fa-ban"></i>Gagal</h5>
          Nama karyawan sama sudah ada
        </div>
    <?php
      } else {

        if ($_POST['password'] != null) {
          $update_pengguna_sql = "UPDATE pengguna SET username = ? , password = ? WHERE id = ?";
          $stmt_update_pengguna = $db->prepare($update_pengguna_sql);
          $stmt_update_pengguna->bindParam(1, $_POST['username']);
          $stmt_update_pengguna->bindParam(2, md5($_POST['password']));
          $stmt_update_pengguna->bindParam(3, $_POST['pengguna_id']);
          $stmt_update_pengguna->execute();
        } else {
          $update_pengguna_sql = "UPDATE pengguna SET username = ? WHERE id = ?";
          $stmt_update_pengguna = $db->prepare($update_pengguna_sql);
          $stmt_update_pengguna->bindParam(1, $_POST['username']);
          $stmt_update_pengguna->bindParam(2, $_POST['pengguna_id']);
          $stmt_update_pengguna->execute();
        }

        $update_karyawan_sql = "UPDATE karyawan SET nik = ? , nama_lengkap = ? , handphone = ? , email = ? , tanggal_masuk = ? WHERE id = ?";
        $stmt_update_karyawan = $db->prepare($update_karyawan_sql);
        $stmt_update_karyawan->bindParam(1, $_POST['nik']);
        $stmt_update_karyawan->bindParam(2, $_POST['nama_lengkap']);
        $stmt_update_karyawan->bindParam(3, $_POST['handphone']);
        $stmt_update_karyawan->bindParam(4, $_POST['email']);
        $stmt_update_karyawan->bindParam(5, $_POST['tanggal_masuk']);
        $stmt_update_karyawan->bindParam(6, $_POST['id']);

        if ($stmt_update_karyawan->execute()) {
          $_SESSION['hasil'] = true;
          $_SESSION['pesan'] = 'Data berhasil diubah!';
        } else {
          $_SESSION['hasil'] = false;
          $_SESSION['pesan'] = 'Data gagal diubah!';
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
            <h1>Ubah Data Karyawan</h1>
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
                Ubah Data
              </li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3>Ubah Data karyawan</h3>
        </div>
        <div class="card-body">
          <form method="POST">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="pengguna_id" value="<?= $row['pengguna_id'] ?>">
            <div class="form-group">
              <label>NIK</label>
              <input type="text" name="nik" class="form-control" value="<?= $row['nik'] ?>" placeholder="NIK">
            </div>
            <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" name="nama_lengkap" class="form-control" value="<?= $row['nama_lengkap'] ?>" placeholder="Nama Lengkap">
            </div>
            <div class="form-group">
              <label>No. Handphone</label>
              <input type="text" name="handphone" class="form-control" value="<?= $row['handphone'] ?>" placeholder="No. Handphone">
            </div>
            <div class="form-group">
              <label>Email </label>
              <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>" placeholder="Email ">
            </div>
            <div class="form-group">
              <label>Tanggal Masuk </label>
              <input type="date" name="tanggal_masuk" class="form-control" value="<?= $row['tanggal_masuk'] ?>" placeholder="Tanggal Masuk ">
            </div>

            <hr>
            <h4>Pengguna</h4>
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="username" class="form-control" value="<?= $row['username'] ?>" placeholder="Username">
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control" placeholder="Password">
            </div>

            <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
              <i class="fa fa-times" aria-hidden="true"></i> Batal
            </a>
            <button type="submit" name="button_update" class="btn btn-success btn-sm float-right">
              <i class="fas fa-save"></i> Simpan
            </button>
          </form>
        </div>
      </div>
    </section>

<?php
  } else {
    echo "<meta http-equiv='refresh' content='0; url=?page=karyawanread'>";
  }
} else {
  echo "<meta http-equiv='refresh' content='0; url=?page=karyawanread'>";
}
?>