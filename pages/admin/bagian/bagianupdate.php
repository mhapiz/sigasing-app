<?php
if (isset($_GET['id'])) {

  $database = new Database();
  $db = $database->getConnection();

  $id = $_GET['id'];
  $findSql = "SELECT * FROM bagian WHERE id = ?";
  $stmt = $db->prepare($findSql);
  $stmt->bindParam(1, $id);
  $stmt->execute();
  $row = $stmt->fetch();
  if (isset($row['id'])) {

    if (isset($_POST['button_update'])) {


      $updateSql = "SELECT * FROM bagian WHERE nama_bagian = ? AND id = ?";
      $stmt = $db->prepare($updateSql);
      $stmt->bindParam(1, $_POST['nama_bagian']);
      $stmt->bindParam(2, $_POST['id']);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
?>
        <div class="alert alert-danger alert-dismissible">
          <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
          <h5><i class="icon fas fa-ban"></i>Gagal</h5>
          Nama bagian sama sudah ada
        </div>
    <?php
      } else {
        $updateSql = "UPDATE bagian SET nama_bagian = ? , karyawan_id = ? , lokasi_id = ? WHERE id = ?";
        $stmt = $db->prepare($updateSql);
        $stmt->bindParam(1, $_POST['nama_bagian']);
        $stmt->bindParam(2, $_POST['karyawan_id']);
        $stmt->bindParam(3, $_POST['lokasi_id']);
        $stmt->bindParam(4, $_POST['id']);
        if ($stmt->execute()) {
          $_SESSION['hasil'] = true;
          $_SESSION['pesan'] = 'Data berhasil diubah!';
        } else {
          $_SESSION['hasil'] = false;
          $_SESSION['pesan'] = 'Data gagal diubah!';
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
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
            <h1>Ubah Data Bagian</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="?page=home">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="?page=bagianread">Bagian</a>
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
          <h3>Tambah Bagian</h3>
        </div>
        <div class="card-body">
          <form method="POST">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <div class="form-group">
              <label>Nama Bagian</label>
              <input type="text" name="nama_bagian" class="form-control" value="<?= $row['nama_bagian'] ?>" placeholder="Nama bagian">
            </div>

            <div class="form-group">
              <label>Kepala Bagian</label>
              <select name="karyawan_id" class="form-control custom-select">
                <option value="">--Pilih Kepala Bagian--</option>
                <?php
                $selectSql = "SELECT * FROM karyawan";
                $stmt_karyawan = $db->prepare($selectSql);
                $stmt_karyawan->execute();
                while ($row_karyawan = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)) {
                  $selected = ($row_karyawan['id'] == $row['karyawan_id']) ? 'selected' : '';
                  echo "<option value=\"" . $row_karyawan["id"] . "\" " . $selected . ">" . $row_karyawan["nama_lengkap"] . "</option>";
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label>Lokasi Bagian</label>
              <select name="lokasi_id" class="form-control custom-select">
                <option value="">--Pilih Lokasi Bagian--</option>
                <?php
                $selectSql = "SELECT * FROM lokasi";
                $stmt_lokasi = $db->prepare($selectSql);
                $stmt_lokasi->execute();
                while ($row_lokasi = $stmt_lokasi->fetch(PDO::FETCH_ASSOC)) {
                  $selected = ($row_lokasi['id'] == $row['lokasi_id']) ? 'selected' : '';
                  echo "<option value=\"" . $row_lokasi["id"] . "\" " . $selected . ">" . $row_lokasi["nama_lokasi"] . "</option>";
                }
                ?>
              </select>
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
    echo "<meta http-equiv='refresh' content='0; url=?page=bagianread'>";
  }
} else {
  echo "<meta http-equiv='refresh' content='0; url=?page=bagianread'>";
}
?>