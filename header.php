<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>My Scholar Portal</title>
  <link rel="icon" href="<?= basedir ?>favicon.png">



  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>


<script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>

<script src="js/scripts.js"></script>



<!-- charts js -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.min.js" integrity="sha512-JxJpoAvmomz0MbIgw9mx+zZJLEvC6hIgQ6NcpFhVmbK1Uh5WynnRTTSGv3BTZMNBpPbocmdSJfldgV5lVnPtIw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.esm.js" integrity="sha512-AkokDu8R9+LVbslO9+I//wXqyzwawAqooTvniMvXvPpy25mSY5k0hskzrGO7cMBPJ/9hW+8yBiDGtmsiIXS0+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.esm.min.js" integrity="sha512-Rg0WJ+klqfdwwQgwQN06M6u2YevDPzvd8U85HKzSDCJUD1V5vE8xr7aH2d7fZqKgQTNunoXMA4W5Kn9ntP2osA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.js" integrity="sha512-+POM1aKUkb5l91zDBDtxn0dlY5wazuQFtCXin/47Z+eE7AnMuFBMrNjkZA1P6m+infsMMSthlsPNh1rjBtAPBA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/helpers.esm.js" integrity="sha512-oRhPhd7fX61NWUaVpgrMzJjjJpah3tSHo+gIbnZC/Q+5Iuwyj6Q9kMipsBBkGmAS7aGnAQOl76X6PKha3bVaIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/helpers.esm.min.js" integrity="sha512-m4VsSgMQ0Mw2iOS3ysNMINQNje3Q5c4AXeZXCVv60HjGMXy2iqZFo9c64itcXZ3ndsPOn5sOk4RgYWC1mBeEmQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>








<link href="<?= basedir ?>css/styles.css" rel="stylesheet" />
  <link href="<?= basedir ?>css/test.css" rel="stylesheet" />
<link href="<?= basedir ?>css/custom-style.css" rel="stylesheet" />






<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

</head>





<body class="sb-nav-fixed">




<?php
    Auth::requireLogin();
    // if (Auth::isAdmin() || Auth::isSecretary()) {
    // } else {
    //     Url::redirect("/admin/index.php");
    // }
?>

<?php    if (Auth::isAdmin()) { ?>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark border-bottom-red">
    <?php } ?>

<?php    if (Auth::isSecretary()) { ?>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark border-bottom-orange">
    <?php } ?>

    <?php    if (Auth::isTeacher()) { ?>
            <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark border-bottom-green">
        <?php } ?>

<?php    if (Auth::isStudent()) { ?>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark border-bottom-blue">
    <?php } ?>




    <img src="<?= basedir ?>images/app_icon_round_logo.png" alt="photo" width="40" class="ml-2">
    <a class="navbar-brand mr-3" href="<?= basedir ?>index.php">My Scholar</a>
    <button class="btn btn-link btn-sm order-0 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">


                <?php if ($_SESSION['user_photo']) : ?>
                    <img src="<?= basedir ?>/uploads/<?= $_SESSION['user_photo'] ?>" alt="userPhoto" class="rounded-circle" width="30">
                <?php else: ?>
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="userPhoto" class="rounded-circle" width="30">
                <?php endif; ?>

                <?php
                echo $_SESSION['user_username'];
                ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <!-- <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a> -->
          <!-- <div class="dropdown-divider"></div> -->

          <a class="dropdown-item" href="<?= basedir ?>logout.php">Έξοδος</a>
        </div>
      </li>
    </ul>
  </nav>
