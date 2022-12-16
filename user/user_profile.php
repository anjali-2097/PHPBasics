<?php
session_start();
if(!isset($_SESSION['email']))
{
  header("location:../index.php");
}
include('../../db/config.php');
include('../admin_template/header.php');
?>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profile
    </h1>
    <ol class="breadcrumb">
      <li><a href="user_dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><i class="fa fa-users"></i>Profile</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="../assets/image/1.png" alt="User profile picture">

            <h3 class="profile-username text-center"><?php echo $_SESSION['fname'];?></h3>

            <p class="text-muted text-center">Software Engineer</p>

            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="col-md-9">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
              <li class="active"><a href="#Detail" data-toggle="tab">Detail</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="Detail">
        </div>
      </div>
    </div>
  </div>

</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include('../admin_template/footer.php');
?>