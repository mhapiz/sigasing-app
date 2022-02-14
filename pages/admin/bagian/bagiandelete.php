<?php
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $database = new Database();
  $db = $database->getConnection();

  $deleteSql = "DELETE FROM bagian WHERE id = ?";
  $stmt = $db->prepare($deleteSql);
  $stmt->bindParam(1, $id);
  if ($stmt->execute()) {
    $_SESSION['hasil'] = true;
    $_SESSION['pesan'] = 'Data berhasil dihapus!';
  } else {
    $_SESSION['hasil'] = false;
    $_SESSION['pesan'] = 'Data gagal dihapus!';
  }
}
echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
