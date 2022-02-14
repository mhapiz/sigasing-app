<?php
if (isset($_GET['id'])) {

  $database = new Database();
  $db = $database->getConnection();

  $id = $_GET['id'];
  $findSql = "SELECT * FROM karyawan AS k WHERE k.id = ?";
  $stmt = $db->prepare($findSql);
  $stmt->bindParam(1, $id);
  $stmt->execute();
  $row = $stmt->fetch();
  if (isset($row['id'])) {

    if (isset($_POST['button_update'])) {

      $add_sql = "INSERT INTO bagian_karyawan SET karyawan_id = ?, bagian_id = ?, tanggal_mulai = ? ";
      $stmt = $db->prepare($add_sql);
      $stmt->bindParam(1, $_POST['karyawan_id']);
      $stmt->bindParam(2, $_POST['bagian_id']);
      $stmt->bindParam(3, $_POST['tanggal_mulai']);

      if ($stmt->execute()) {
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = 'Data berhasil ditambah!';
      } else {
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = 'Data gagal ditambah!';
      }
      echo "<meta http-equiv='refresh' content='0;url=?page=karyawanbagian&id=" . $id . "'>";
    }

    if (isset($_POST['button_delete'])) {

      $delete_sql = "DELETE FROM bagian_karyawan WHERE id = ?";
      $stmt = $db->prepare($delete_sql);
      $stmt->bindParam(1, $_POST['bk_id']);

      if ($stmt->execute()) {
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = 'Data berhasil dihapus!';
      } else {
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = 'Data gagal dihapus!';
      }
      echo "<meta http-equiv='refresh' content='0;url=?page=karyawanbagian&id=" . $id . "'>";
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
            <h1>Ubah Data Bagian Karyawan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="?page=home">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="?page=karyawanread">Bagian Karyawan</a>
              </li>
              <li class="breadcrumb-item active">
                Riwayat Bagian
              </li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3>Riwayat Bagian</h3>
        </div>
        <div class="card-body">
          <form method="POST">
            <input type="hidden" name="karyawan_id" value="<?= $row['id'] ?>">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>NIK</label>
                  <input type="text" class="form-control" name="nik" value="<?= $row['nik'] ?>" readonly>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>Handphone</label>
                  <input type="text" class="form-control" name="handphone" value="<?= $row['handphone'] ?>" readonly>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" class="form-control" name="nama_lengkap" value="<?= $row['nama_lengkap'] ?>" readonly>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>Pilih Bagian</label>
                  <select name="bagian_id" class="custom-select">
                    <option value="">--Pilih Bagian--</option>
                    <?php
                    $bagian_sql = "SELECT * FROM bagian";
                    $stmt_bagian = $db->prepare($bagian_sql);
                    $stmt_bagian->execute();
                    $bagian = $stmt_bagian->fetchAll();
                    foreach ($bagian as $row_bagian) {
                    ?>
                      <option value="<?= $row_bagian['id'] ?>"><?= $row_bagian['nama_bagian'] ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label>Tanggal Mulai</label>
                  <input type="date" class="form-control" name="tanggal_mulai">
                </div>
              </div>
            </div>

            <button type="submit" name="button_update" class="btn btn-success btn-sm btn-block">
              <i class="fas fa-save"></i> Simpan
            </button>
          </form>

          <table id="mytable" class="table table-bordered table-hover mt-3">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Bagian</th>
                <th>Tanggal Mulai</th>
                <th style="width: 100px;">Opsi</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $selectSql = "SELECT bk.*, b.nama_bagian FROM bagian_karyawan bk
                            LEFT JOIN bagian b ON bk.bagian_id = b.id
                            WHERE bk.karyawan_id = ? 
                            ORDER BY bk.tanggal_mulai DESC
              ";
              $stmt = $db->prepare($selectSql);
              $stmt->bindParam(1, $_GET['id']);
              $stmt->execute();
              $no = 1;
              while ($row_bagian = $stmt->fetch(PDO::FETCH_ASSOC)) {
              ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row_bagian['nama_bagian'] ?></td>
                  <td><?= $row_bagian['tanggal_mulai'] ?></td>
                  <td>

                    <form method="post">
                      <input type="hidden" name="bk_id" value="<?= $row_bagian['id'] ?>">
                      <input type="hidden" name="karyawan_id" value="<?= $row['id'] ?>">
                      <button type="submit" name="button_delete" class="btn btn-danger btn-sm mr-1" onclick="return confirm('Apakah Anda Yakin Menghapus Data?')">
                        <i class="fa fa-trash" aria-hidden="true"></i> Hapus

                      </button>

                    </form>

                  </td>
                </tr>
              <?php
              }
              ?>


            </tbody>
          </table>

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