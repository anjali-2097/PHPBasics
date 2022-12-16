<?php
error_reporting(0);

session_start();
if(!isset($_SESSION['email']))
{
	header("location:../index.php");
}
$now = time();
if ($now > $_SESSION['expire']) {
	unset($_SESSION['data']);
}
include('../admin_template/header.php');
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Users</h1>
		<ol class="breadcrumb">
			<li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><i class="fa fa-users"></i> Users</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="col-md-6">
							<select name="filter_technology" id="Filter_Technology" class="form-control">
								<option selected value="">Select Technology</option>
								<?php
								$sql1 ="SELECT * FROM technology";
								$result = mysqli_query($conn,$sql1);
								while($row = mysqli_fetch_assoc($result)) {
									?>
									<option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6">
							<select name="filter_gender" id="Filter_Gender" class="form-control">
								<option selected value="">Select Gender</option>
								<option value="male">Male</option>
								<option value="female">Female</option>
							</select>
						</div>
					</div>




					<div class="col-md-6">
						<button type="button" class="btn btn-primary apply_filter" style="margin-right: 10px;">Apply</button>
						<button type="button" class="btn clear_filter" style="background-color: #EF534E;">Clear</button>
						<button type="button" data-toggle="modal" data-target="#addtechno" class="btn btn-primary" style="float: right; margin-right: 10px;">add tech</button>
					</div>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
		<!-- Default box -->
		<div class="box">
			<div class="box-header">
				<div style="float: left;">
					<?php 
					if(isset($_SESSION['data'])){
						?>
						<label class="session_data">
							Total inserted user is :<?php echo $_SESSION['data']['inserted_count']; ?><br>
							Total updated user is :<?php echo $_SESSION['data']['updated_count']; ?><br>
							Total incorect detail is :<?php echo $_SESSION['data']['incorrect_count']; ?>
						</label>
					<?php }?>
				</div>
				<button type="button" class="btn multidelete" style="float: right; background-color: #EF534E;">Delete</button>
				<button type="button" data-toggle="modal" data-target="#add_user" class="btn btn-primary" style="float: right; margin-right: 10px;">Add User</button>
				<a href="save_csv.php"><button type="button" class="btn btn-primary" style="float: right; margin-right: 10px;" onClick="return confirmation()">Create csv file</button></a>
				<button type="button" data-toggle="modal" data-target="#import_user_modal" class="btn btn-primary" style="float: right; margin-right: 10px;">import user file</button>
			</div><!-- /.box-header -->
			<div class="box-body">
				<table id="user_table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th><label class="checkboxcont">
								<input type="checkbox" id="Selectall" class="select_all_box" name="select_all">
								<span class="checkmark" style="margin-top: -12px;"></span>
							</label></th>
							<th><strong>S.No</strong></th> 
							<th><strong>First Name</strong></th>
							<th><strong>Last Name</strong></th>
							<th><strong>Email</strong></th>
							<th><strong>Phone Number</strong></th>
							<th><strong>Technology</strong></th>
							<th><strong>Image</strong></th>
							<th><strong>Status</strong></th>
							<th class="actionbtn"><strong>action</strong></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count=1;
						$sel_query="SELECT * FROM `user`";
						// $sel_query="SELECT user.*, technology.name FROM user LEFT JOIN technology ON user.technology_id = technology.id";
						$result = mysqli_query($conn,$sel_query);
						

						while($row = mysqli_fetch_assoc($result)) {
							$sql2 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
							FROM technology WHERE id IN (".$row['technology_id'].")";
							$row2 = mysqli_query($conn,$sql2);
							$data2 = mysqli_fetch_assoc($row2);
							if($row['role']==2){
								?>
								<tr id="<?php echo $row["id"]; ?>">
									<td><label class="checkboxcont">
										<input type="checkbox" data-id="<?php echo $row["id"]; ?>" class="markall">
										<span class="checkmark"></span>
									</label></td>
									<td><?php echo $count; ?></td>
									<td><?php echo $row["fname"]; ?></td>
									<td><?php echo $row["lname"]; ?></td>
									<td><?php echo $row["email"]; ?></td>
									<td><?php echo $row["phonenumber"]; ?></td>
									<td><?php echo $data2["techname"]; ?></td>
									<td><img src="../assets/image/<?php echo $row["image"]; ?>" width="100px" height="100px"></td>
									<?php 
									if(($row['status'])==1) 
										{$checked ='checked'; }
									else{
										$checked ='';
									}
									?>
									<td><input class="change_status" id="switch" type="checkbox" data-toggle="toggle" data-id="<?php echo $row["id"]; ?>" <?php echo $checked ?>>
									</td>
									<td class="actionbtn">
										<a href="user_view.php?id=<?=$row['id']?>"><button class="btn btn-default btn-sm edit_user_modal" data-id="<?=$row['id']?>" style="margin-right: 5px; background-color: #FDE671;">
											<span class="fa fa-eye"></span>
										</button></a>

										<button data-toggle="modal" data-target="#edit_user_modal" class="btn btn-default btn-sm edit_user_modal" data-id="<?=$row['id']?>" data-count="<?=$count?>" style="margin-right: 5px; background-color: #F2AF4A;">
											<span class="glyphicon glyphicon-pencil"></span>
										</button>

										<button class="delete_user btn btn-default btn-sm" data-id="<?php echo $row["id"]; ?>" style="background-color: #EF534E;"><span class="glyphicon glyphicon-trash"></span></button>
									</td>
								</tr>
								<?php $count++; $sr_no[]=$count; }} ?>

							</tbody>
						</table>
						<input type="hidden" name="srno" class="srno" value="<?=count($sr_no)?>">
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</section><!-- /.content -->
		</div><!-- /.content-wrapper -->

		<div class="modal fade" id="add_user">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Add User</h4>
					</div>
					<form id="form_reg" method="post" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<div class="input-group lblerror">
											<div class="input-group-addon">
												<i class="fa fa-user"></i>
											</div>
											<input type="text" class="form-control" id="Fname" name="f_name" placeholder="Enter user first name"/>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="input-group lblerror">
											<div class="input-group-addon">
												<i class="fa fa-user"></i>
											</div>
											<input type="text" class="form-control" id="Lname" name="l_name" placeholder="Enter user last name"/>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<div class="input-group lblerror">
											<div class="input-group-addon">
												<i class="fa fa-envelope"></i>
											</div>
											<input type="email" class="form-control" name="email"  id="Email" placeholder="Enter E-mail" size="30"/>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="input-group lblerror">
											<div class="input-group-addon">
												<i class="fa fa-phone"></i>
											</div>
											<input type="text" class="form-control" id="Phonenumber" name="phone_number" placeholder="Enter Contact Number" size="10" pattern="[0-9]{10}"/>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<div class="input-group lblerror">
											<div class="input-group-addon">
												<i class="fa fa-lock"></i>
											</div>
											<input type="password" class="form-control" id="Password" name="password" placeholder="Enter Password"/>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="input-group lblerror">
											<div class="input-group-addon">
												<i class="fa fa-lock"></i>
											</div>
											<input type="password" class="form-control" id="Retypepassword" name="retype_password" placeholder="Re-Enter Password"/>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group has-feedback">
										<select name="address" id="Address" class="form-control">
											<option selected >Select City</option>
											<option> Ahmedabad </option>
											<option>Surat</option>
											<option>Navsari</option>
											<option> Valsad</option>
											<option> Bharuch</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group has-feedback">
										<select name="technology[]" id="Technology" class="multipleSelect" multiple>
											<?php
											$sql1 ="SELECT * FROM technology";
											$result = mysqli_query($conn,$sql1);
											while($row = mysqli_fetch_assoc($result)) {
												?>
												<option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group has-feedback">
										<label>Gender:</label>
										<p class="radio_button">
											<label class="checkboxcont">
												<input type="radio" id="Male" name="gender" value="male">Male
												<span class="checkmark checkmarkradio"></span>
											</label>
											<label class="checkboxcont">
												<input type="radio" id="Female" name="gender" value="female">Female
												<span class="checkmark checkmarkradio"></span>
											</label>
										</p>
									</div> 
								</div>
							<!-- <div class="form-group has-feedback">
								<label>Technology:</label>
								<p class="check_box">
									<label class="checkboxcont">PHP
										<input type="checkbox" id="PHP" name="technology[]" value="php">
										<span class="checkmark"></span>
									</label>
									<label class="checkboxcont">Android
										<input type="checkbox" id="Android" name="technology[]" value="android">
										<span class="checkmark"></span>
									</label>
									<label class="checkboxcont">Java
										<input type="checkbox" id="Java" name="technology[]" value="java">
										<span class="checkmark"></span>
									</label>
								</p>
							</div> class="select2 m-b-10 select2-multiple"-->
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<label>Upload profile Image:</label>
									<input type="file" name="fileToUpload" id="profile-img">
									<img src="" id="profile-img-tag" width="150px"/>
								</div>
							</div>
						</div>    
						<!-- <div>
							<p class="errordata" style="display: none;"></p>
						</div> -->
						<div class="row">
							<div class="col-md-12">
								<label>Upload multiple Image:</label>
								<input type="file" name="file2_upload[]" multiple id="gallery-photo-add">
								
							</div>
							<div class="gallery"></div>
						</div>
						<input type="hidden" name="multiple_img" id="multiple_img" value="">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>
						<input type="hidden" name="register_user" value="1">
						<button type="submit" class="btn btn-primary">Add</button>
					</div>
				</form>  
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal" id="edit_user_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit User</h4>
				</div>
				<form id="form_edit" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group lblerror">
										<div class="input-group-addon">
											<i class="fa fa-user"></i>
										</div>
										<input type="text" class="form-control" id="edit_Fname" name="f_name" placeholder="Enter user first name"/>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group lblerror">
										<div class="input-group-addon">
											<i class="fa fa-user"></i>
										</div>
										<input type="text" class="form-control" id="edit_Lname" name="l_name" placeholder="Enter user last name"/>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group lblerror">
										<div class="input-group-addon">
											<i class="fa fa-envelope"></i>
										</div>
										<input type="email" class="form-control" name="email"  id="edit_Email" placeholder="Enter E-mail" size="30"/>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group lblerror">
										<div class="input-group-addon">
											<i class="fa fa-phone"></i>
										</div>
										<input type="text" class="form-control" id="edit_Phonenumber" name="phone_number" placeholder="Enter Contact Number" size="10" pattern="[0-9]{10}" value="<?php echo $row['phonenumber']; ?>"/>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<select name="address" id="edit_Address" class="form-control">
										<option selected >Select City</option>
										<option> Ahmedabad </option>
										<option>Surat</option>
										<option>Navsari</option>
										<option> Valsad</option>
										<option> Bharuch</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<select name="technology[]" id="edit_Technology" class="multipleSelect" multiple>
										<?php
										$sql1 ="SELECT * FROM technology";
										$result = mysqli_query($conn,$sql1);
										while($row = mysqli_fetch_assoc($result)) {
											?>
											<option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group has-feedback rediocheckbox_set">
									<label>Gender:</label>
									<p class="radio_button">
										<label class="checkboxcont">
											<input type="radio" id="edit_Male" name="gender" class="flat-red" value="male">Male
											<span class="checkmark checkmarkradio"></span>
										</label>
										<label class="checkboxcont">
											<input type="radio" id="edit_Female" name="gender" class="flat-red" value="female">Female
											<span class="checkmark checkmarkradio"></span>
										</label>
									</p>
								</div> 
							</div>
							<div class="col-md-6">
								<div class="form-group has-feedback">
									<label>Upload Image:</label>
									<input type="file" name="fileToUpload" id="edit_profile-img">
									<img src="" width="100px" height="100px" id="edit_profile-img-tag">

								</div>
							</div>
						</div>
							<!-- <div class="form-group has-feedback rediocheckbox_set">
								<label>Technology:</label>
								<p class="check_box">
									<label class="checkboxcont">PHP
										<input type="checkbox" class="flat-red" id="edit_PHP" name="technology[]" value="php">
										<span class="checkmark"></span>
									</label>
									<label class="checkboxcont">Android
										<input type="checkbox" class="flat-red" id="edit_Android" name="technology[]" value="android">
										<span class="checkmark"></span>
									</label>
									<label class="checkboxcont">Java
										<input type="checkbox" class="flat-red" id="edit_Java" name="technology[]" value="java">
										<span class="checkmark"></span>
									</label>
								</p>
							</div> -->
							


							<!-- <div>
								<p class="edit_error" style="display: none;"></p>
							</div> -->

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>
							<input type="hidden" id="edit_srno" name="edit_srno" value="">
							<input type="hidden" id="editid" name="edit_id" value="">
							<input type="hidden" id="editimage" name="edit_image" value="">
							<input type="hidden" name="edit_user_data" value="1">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form> 
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade" id="import_user_modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Import User csv file</h4>
					</div>
					<form id="form_import_user" method="post" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="form-group">
								<div class="input-group lblerror">
									<input type="file" name="file" id="file">
								</div>
							</div>
							<div>
								<p class="errordata" style="display: none;"></p>
							</div>  
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>
							<button type="submit" class="btn btn-primary">Import</button>
						</div>
					</form>  
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->


		<div class="modal fade" id="addtechno">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">add technology</h4>
					</div>
					<form id="add__tech" method="post" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="form-group">
								<div class="input-group lblerror">
									Technology:<input type="text" name="tech_name" id="tech_name">
								</div>
							</div>
							<div>
								<p class="errordata" style="display: none;"></p>
							</div>  
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>
							<button type="submit" class="btn btn-primary">add</button>
						</div>
					</form>  
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		
		<?php
		include('../admin_template/footer.php');
		?>