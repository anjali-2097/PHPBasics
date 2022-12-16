<?php
include('../db/config.php');
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin | Dashboard</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.2 -->
  <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Font Awesome Icons -->
  <!-- <link href="../assets/css/font-style.css" rel="stylesheet" type="text/css" /> -->
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- DATA TABLES -->
  <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  <!-- <link href="../assets/css/custom-select.css" rel="stylesheet"/> -->
  <link href="../assets/css/bootstrap-select.min.css" rel="stylesheet"/>
  <link href="../assets/css/jquery.notify.css" rel="stylesheet"/>
  <link href="../assets/css/bootstrap-multiselect.css" rel="stylesheet"/>
  
  <!-- Ionicons -->
  <link href="../assets/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <!-- AdminLTE Skins. Choose a skin from the css/skins 
     folder instead of downloading all of them to reduce the load. -->
     <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
     <link href="../assets/css/bootstrap-toggle.min.css" rel="stylesheet">
     <link href="../assets/css/custom.css" rel="stylesheet">

   </head>
   <body class="skin-blue">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <a href="../../index2.html" class="logo"><b>Admin</b>LTE</a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../assets/image/admin.jpg" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $_SESSION['fname'];?></span>
                </a>
                <ul class="dropdown-menu">
                
                  <li class="user-header">
                    <img src="../assets/image/admin.jpg" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $_SESSION['email'];?> - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="log_out.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <!-- =============================================== -->
      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../assets/image/admin.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['fname'];?></p>

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <hr>
          <?php if($_SESSION['role']=="1"){?>
            <ul class="sidebar-menu">
              <li><a href="admin_dashboard.php" style="margin-top: 60px;"><i class="fa fa-dashboard"></i> Dashboard </a></li>
              <li><a href="users.php"><i class="fa fa-circle-o"></i> Users</a></li>
              <li><a href="technology.php"><i class="fa fa-circle-o"></i> Technology</a></li>
            <?php }else{ ?>
              <ul class="sidebar-menu">
                <li><a href="user_dashboard.php" style="margin-top: 60px;"><i class="fa fa-dashboard"></i> Dashboard </a></li>
                <li><a href="user_profile.php"><i class="fa fa-circle-o"></i>Profile</a></li>
              <?php }?>
            </section>
            <!-- /.sidebar -->
          </aside>
          