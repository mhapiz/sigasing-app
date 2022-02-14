<?php
$database = new Database();
$db = $database->getConnection();

if (isset($_POST['button_create'])) {

  $nama_bagian = $_POST['nama_bagian'];
  $karyawan_id = $_POST['karyawan_id'];
  $lokasi_id = $_POST['lokasi_id'];

  $validateSql = "SELECT * FROM bagian WHERE nama_bagian = '$nama_bagian'";

  $stmt = $db->prepare($validateSql);
  $stmt->execute();

  $count = $stmt->rowCount();

  if ($count > 0) {
    echo "<script>alert('Nama bagian sudah ada!');</script>";
  } else {
    $insertSql = "INSERT INTO bagian SET nama_bagian = ? , karyawan_id = ? , lokasi_id = ? ";

    $stmt = $db->prepare($insertSql);
    $stmt->bindParam(1, $nama_bagian);
    $stmt->bindParam(2, $karyawan_id);
    $stmt->bindParam(3, $lokasi_id);

    if ($stmt->execute()) {

      $_SESSION['hasil'] = true;
      $_SESSION['pesan'] = 'Data berhasil ditambahkan!';
    } else {

      $_SESSION['hasil'] = false;
      $_SESSION['pesan'] = 'Data gagal ditambahkan!';
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
        <h1>Tambah Data Bagian</h1>
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
      <h3>Tambah Bagian</h3>
    </div>
    <div class="card-body">
      <form method="POST">
        <div class="form-group">
          <label>Nama Bagian</label>
          <input type="text" name="nama_bagian" class="form-control" placeholder="Nama bagian">
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
              echo "<option value=\"" . $row_karyawan["id"] . "\">" . $row_karyawan["nama_lengkap"] . "</option>";
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
              echo "<option value=\"" . $row_lokasi["id"] . "\">" . $row_lokasi["nama_lokasi"] . "</option>";
            }
            ?>
          </select>
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