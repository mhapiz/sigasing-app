<?php
if (isset($_GET['id'])) {

  $database = new Database();
  $db = $database->getConnection();

  $id = $_GET['id'];
  $findSql = "SELECT * FROM lokasi WHERE id = ?";
  $stmt = $db->prepare($findSql);
  $stmt->bindParam(1, $id);
  $stmt->execute();
  $row = $stmt->fetch();
  if (isset($row['id'])) {

    if (isset($_POST['button_update'])) {


      $updateSql = "SELECT * FROM lokasi WHERE nama_lokasi = ? AND id = ?";
      $stmt = $db->prepare($updateSql);
      $stmt->bindParam(1, $_POST['nama_lokasi']);
      $stmt->bindParam(2, $_POST['id']);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
?>
        <div class="alert alert-danger alert-dismissible">
          <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
          <h5><i class="icon fas fa-ban"></i>Gagal</h5>
          Nama lokasi sama sudah ada
        </div>
    <?php
      } else {
        $updateSql = "UPDATE lokasi SET nama_lokasi = ? WHERE id = ?";
        $stmt = $db->prepare($updateSql);
        $stmt->bindParam(1, $_POST['nama_lokasi']);
        $stmt->bindParam(2, $_POST['id']);
        if ($stmt->execute()) {
          $_SESSION['hasil'] = true;
          $_SESSION['pesan'] = 'Data berhasil diubah!';
        } else {
          $_SESSION['hasil'] = false;
          $_SESSION['pesan'] = 'Data gagal diubah!';
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
            <h1>Ubah Data Lokasi</h1>
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
          <h3>Ubah Lokasi</h3>
        </div>
        <div class="card-body">
          <form method="POST">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <div class="form-group">
              <label>Nama Lokasi</label>
              <input type="text" name="nama_lokasi" class="form-control" value="<?= $row['nama_lokasi'] ?>" placeholder="Nama Lokasi">
            </div>
            <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
              <i class="fa fa-times" aria-hidden="true"></i> Batal
            </a>
            <button type="submit" name="button_update" class="btn btn-success btn-sm float-right">
              <i class="fas fa-save"></i> Ubah
            </button>
          </form>
        </div>
      </div>
    </section>

<?php
  } else {
    echo "<meta http-equiv='refresh' content='0; url=?page=lokasiread'>";
  }
} else {
  echo "<meta http-equiv='refresh' content='0; url=?page=lokasiread'>";
}
?>