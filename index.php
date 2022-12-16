<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Log in</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- Bootstrap 3.3.2 -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- Font Awesome Icons -->
	<link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	<!-- iCheck -->
	<link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/jquery.notify.css" rel="stylesheet"/>
	<style type="text/css">

	.lblerror label.error {
		color: #FB9678;
		position: absolute;
		width: 100%;
		top: 33px;
		line-height: 14px;
		left: 0px;
	}

	.rediocheckbox_set label{
		margin-left: 15px;
	}

	.login_error{
		color: #FB9678;
		font-weight: bold;
	}

</style>
</head>
<body class="login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="../../index2.html"><b>Admin</b>LTE</a>
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">Sign in to start your session</p>
			<form id="form_login" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<div class="input-group lblerror">
						<div class="input-group-addon">
							<i class="fa fa-envelope"></i>
						</div>
						<input type="text" class="form-control" name="user_email" id="user_email" placeholder="Email"/>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group lblerror">
						<div class="input-group-addon">
							<i class="fa fa-lock"></i>
						</div>
						<input type="password" class="form-control" name="user_pass" id="user_pass" placeholder="Password"/>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-8">    
						<div class="checkbox icheck">
							<label>
								<input type="checkbox" name="rememberme" id="rememberme"> Remember Me
							</label>
							<p class="login_error" style="display: none;"></p>
						</div>                        
					</div><!-- /.col -->
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
					</div><!-- /.col -->
				</div>
			</form>

			<a href="" data-toggle="modal" data-target="#forget_pass_modal">I forgot my password</a><br>
		</div><!-- /.login-box-body -->
	</div><!-- /.login-box -->



	<div class="modal" id="forget_pass_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit User</h4>
				</div>
				<form id="form_forget_pass" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<div class="input-group lblerror">
								<div class="input-group-addon">
									<i class="fa fa-envelope"></i>
								</div>
								<input type="text" class="form-control" id="email" name="Email" placeholder="Enter Your Email ID"/>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>
						<button type="submit" class="btn btn-primary">Send Mail</button>
					</div>
				</form> 
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<?php

	if(isset($_COOKIE["user_email"]) && isset($_COOKIE["user_password"]))
	{
		$email=$_COOKIE['user_email'];
		$password=$_COOKIE['user_password'];

		echo "<script>
		document.getElementById('user_email').value='$email';
		document.getElementById('user_pass').value='$password';
		</script>";
	}
	?>
	<script src="assets/js/jquery.min.js"></script>
	<!-- jQuery 2.1.3 -->
	<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
	<!-- Bootstrap 3.3.2 JS -->
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- iCheck -->
	<script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<!-- 	<script src="../adminpanel/assets/js/custom.js"></script> -->
	<script src="assets/js/jquery.validate.js"></script>
	<script src="assets/js/jquery.notify.js"></script>
	<script type="text/javascript">
		$(document).on('submit', '#form_login', function(e) {
			e.preventDefault();
			var email = $('#user_email').val();
			var password = $('#user_pass').val();
			var remember = $('#rememberme').is(':checked');

			if( $("#form_login").validate()){
				$.ajax({
					type: 'POST',
					url: "admin/controller/adminlogin_check.php", 
					data: {user_id:email,user_pass:password,remember:remember,flag:"login"},
					dataType: "json",
					success: function(data){
						if(data.success==1){
							window.location="admin/admin_dashboard.php";
						}else if(data.success==2){
							window.location="user/user_dashboard.php";
						}else{
							// $(".login_error").attr("style", "display:block");
							// $('.login_error').text(data.message);
							$.notify({
								wrapper: 'body',
								message: data.message,
								type: 'error',
								position: 3,
								dir: 'rtl',
								duration: 4000
							});
							return false;
						}
					}
				})
			}
		});

		$(document).on('submit', '#form_forget_pass', function(e) {
			e.preventDefault();
			var email = $('#email').val();
			if( $("#form_forget_pass").validate()){
				$.ajax({
					type: 'POST',
					url: "admin/controller/adminlogin_check.php", 
					data: {email:email,flag:"forget_pass"},
					dataType: "json",
					success: function(data){
						console.log(data);
						$('#forget_pass_modal').modal('hide');
						if(data.success==1){
							$.notify({
								wrapper: 'body',
								message: data.data,
								type: 'success',
								position: 3,
								dir: 'rtl',
								duration: 4000
							});
						}else{
							// $(".login_error").attr("style", "display:block");
							// $('.login_error').text(data.message);
							$.notify({
								wrapper: 'body',
								message: data.data,
								type: 'error',
								position: 3,
								dir: 'rtl',
								duration: 4000
							});
							return false;
						}
					}
				})
			}
		});


		$("#form_login").validate({
			rules: {
				user_email: {
					required: true
				},
				user_pass: {
					required: true
				}
			},messages:{
				user_email: {
					required:"Enter your Email ID"
				},
				user_pass: {
					required:"Enter your Password"
				}
			}
		});

		$("#form_forget_pass").validate({
			rules: {
				Email: {
					required: true
				}
			},messages:{
				Email: {
					required:"Enter your Email ID"
				}
			}
		});

		$(document).ready(function(){
			$('#forget_pass_modal').on('aria-hidden.bs.modal', function () { 
				$(this).find('form')[0].reset();
				$(this).validate().resetForm();
			});
		});
	</script>
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