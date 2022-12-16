
<div class="content-wrapper">
	<section class="content-header">
		<h1>Users</h1>
		<ol class="breadcrumb">
			<li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><i class="fa fa-users"></i> Users</li>
		</ol>
	</section>
</div>

//////////////////////////////////////////////////////////////////////////////////////////////////////

<script src="assets/js/jquery.min.js"></script>
<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>


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
		<div class="col-xs-4">
			<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
		</div><!-- /.col -->
	</div>
</form>

<script type="text/javascript">

	$(document).ready(function(){

		$(document).on('submit', '#form_login', function(e) {
			e.preventDefault();
			var email = $('#user_email').val();
			var password = $('#user_pass').val();

			$.ajax({
				type: 'POST',
				url: "admin/controller/adminlogin_check.php", 
				data: {user_id:email,user_pass:password},
				dataType: "json",
				success: function(data){
					
					if(data.success==1){
						window.location="admin/user.php";
					}else{
						window.location="index.php";
					}
				}
			})
		});

	});

</script>

<?php

$responce['success']=1;

echo json_encode($responce);

?>

//////////////////////////////////////////////////////////////


<table>
	<tr>
		<th><strong>S.No</strong></th> 
		<th><strong>Name</strong></th>
		<th><strong>Email</strong></th>
		<th><strong>Phone Number</strong></th>
		<th><strong>address</strong></th>
	</tr>
	<?php
	foreach ($users as $info) {
		?>
		<tr>
			<td><?php echo $count; ?></td>
			<td><?php echo $info["user_name"]; ?></td>
			<td><?php echo $info["user_email"]; ?></td>
			<td><?php echo $info["user_mob"]; ?></td>
			<td><?php echo $info["user_add"]; ?></td>
		</tr>
	<?php  }  ?>			  
</table>

