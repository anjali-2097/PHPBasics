<?php
include('../db/config.php');
$email=$_GET['id'];
$key=$_GET['key'];
$sql ="SELECT gen_key FROM user WHERE email='$email'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
$data_key=$row['gen_key'];
if($key==$data_key){
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Reset pass</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- Bootstrap 3.3.2 -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- Font Awesome Icons -->
	<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	<!-- iCheck -->
	<link href="../plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
	<link href="../assets/css/jquery.notify.css" rel="stylesheet"/>
</head>
<body class="login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="../../index2.html"><b>Admin</b>LTE</a>
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">Reset your password here</p>
			<form action="controller/adminlogin_check.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<div class="input-group lblerror">
						<div class="input-group-addon">
							<i class="fa fa-lock"></i>
						</div>
						<input type="password" class="form-control" name="password" id="Password" placeholder="Password" required/>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group lblerror">
						<div class="input-group-addon">
							<i class="fa fa-lock"></i>
						</div>
						<input type="password" class="form-control" name="confirmpass" id="Confirm_pass" placeholder="Confirm Password" required/>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-8">
						<input type="hidden" name="data" value="<?php echo $email; ?>">  
					</div>
					<div class="col-xs-4">
						<button type="submit" name="reset_pass" class="btn btn-primary btn-block btn-flat">Save</button>
					</div><!-- /.col -->
				</div>
			</form>
		</div><!-- /.login-box-body -->
	</div><!-- /.login-box -->

	<script src="../assets/js/jquery.min.js"></script>
	<!-- jQuery 2.1.3 -->
	<script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
	<!-- Bootstrap 3.3.2 JS -->
	<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- 	<script src="../adminpanel/assets/js/custom.js"></script> -->
	<script src="../assets/js/jquery.validate.js"></script>
	<script src="../assets/js/jquery.notify.js"></script>
</body>
</html>
<?php 
}else{
	header("location:link_expire.php");
}
?>