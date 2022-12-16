<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Log in</title>
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
<style type="text/css">
.login-box-msg {
color: red;
}
</style>
</head>
<body class="login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="../../index2.html"><b>Admin</b>LTE</a>
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg"><b>Your password reset link is expired</b></p>
			

		</div><!-- /.login-box-body -->
	</div><!-- /.login-box -->

	<script src="../assets/js/jquery.min.js"></script>
	<!-- jQuery 2.1.3 -->
	<script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
	<!-- Bootstrap 3.3.2 JS -->
	<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- iCheck -->
	<script src="../plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<!-- 	<script src="../adminpanel/assets/js/custom.js"></script> -->
	<script src="../assets/js/jquery.validate.js"></script>
	<script src="../assets/js/jquery.notify.js"></script>
	<script>
		$(function () {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
      });
		});
	</script>
</body>
</html>