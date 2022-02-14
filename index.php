<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">


<?php include_once 'partials/head.php' ?>
<?php include_once 'database/database.php' ?>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include_once 'partials/nav.php' ?>
    <?php include_once 'partials/sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php include_once 'routes.php' ?>
    </div>
    <!-- /.content-wrapper -->
    <?php include_once 'partials/control.php' ?>
    <?php include_once 'partials/footer.php' ?>
  </div>
  <!-- ./wrapper -->

  <?php include_once 'partials/scripts.php' ?>

</body>

</html>