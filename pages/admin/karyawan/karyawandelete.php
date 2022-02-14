<?php
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $database = new Database();
  $db = $database->getConnection();

  $select_karyawan_sql = "SELECT pengguna_id FROM karyawan WHERE id = ?";
  $stmt_select_karyawan = $db->prepare($select_karyawan_sql);
  $stmt_select_karyawan->bindParam(1, $id);
  $stmt_select_karyawan->execute();
  $karyawan = $stmt_select_karyawan->fetch();

  $delete_pengguna_sql = "DELETE FROM pengguna WHERE id = ?";
  $stmt_delete_pengguna = $db->prepare($delete_pengguna_sql);
  $stmt_delete_pengguna->bindParam(1, $karyawan['pengguna_id']);
  $stmt_delete_pengguna->execute();

  $delete_karyawan_sql = "DELETE FROM karyawan WHERE id = ?";
  $stmt_delete_karyawan = $db->prepare($delete_karyawan_sql);
  $stmt_delete_karyawan->bindParam(1, $id);
  if ($stmt_delete_karyawan->execute()) {
    $_SESSION['hasil'] = true;
    $_SESSION['pesan'] = 'Data berhasil dihapus!';
  } else {
    $_SESSION['hasil'] = false;
    $_SESSION['pesan'] = 'Data gagal dihapus!';
  }
}
echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
