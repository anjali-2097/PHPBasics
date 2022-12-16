<?php
session_start();
if(!isset($_SESSION['email']))
{
	header("location:../index.php");
}
include('../admin_template/header.php');
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Technology
		</h1>
		<ol class="breadcrumb">
			<li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Home </a></li>
			<li class="active">technology</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="box">
			<div class="box-header">
				<button type="button" data-toggle="modal" data-target="#add_technology_modal" class="btn btn-primary" style="float: right;">Add Technology</button>
			</div><!-- /.box-header -->
			<div class="box-body">
				<table id="technology_table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th><strong>Technology Name</strong></th> 
							<th><strong>Action</strong></th> 
						</tr>
					</thead>
					<tbody>
						<?php
						$count=1;
						$sel_query="SELECT * FROM `technology`";
						$result = mysqli_query($conn,$sel_query);
						while($row = mysqli_fetch_assoc($result)) {
							?>
							<tr id="<?php echo $row["id"]; ?>">
								<td><?php echo $row["name"]; ?></td>
								<td><button data-toggle="modal" data-target="#edit_technology_modal" class="btn btn-default btn-sm edit_technology_modalclass" data-id="<?=$row['id']?>" data-count="<?=$count?>">
											<span class="glyphicon glyphicon-pencil"></span>
										</button>
									<button class="delete_technology btn btn-default btn-sm" data-id="<?php echo $row["id"]; ?>"><span class="glyphicon glyphicon-trash"></span></button>
								</td>
							</tr>
							<?php $count++; $sr_no[]=$count; } ?>
						</tbody>
					</table>
				</div>
			</div>
		</section><!-- /.content -->
	</div><!-- /.content-wrapper -->

	<div class="modal fade" id="add_technology_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Add Technology</h4>
				</div>
				<form id="form_add_technology" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<div class="input-group lblerror">
								<div class="input-group-addon">
									<i class="fa"></i>
								</div>
								<input type="text" class="form-control" id="Technology" name="technology" placeholder="Enter Technology"/>
							</div>
						</div>
						<div>
							<p class="errordata" style="display: none;"></p>
						</div>  
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>  
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="edit_technology_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit Technology</h4>
				</div>
				<form id="form_edit_technology" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<div class="input-group lblerror">
								<div class="input-group-addon">
									<i class="fa"></i>
								</div>
								<input type="text" class="form-control" id="edit_Technology" name="technology" placeholder="Enter Technology"/>
								<input type="hidden" id="edit_id" value="">
							</div>
						</div>
						<div>
							<p class="errordata" style="display: none;"></p>
						</div>  
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>
						<button type="submit" class="btn btn-primary">Update changes</button>
					</div>
				</form>  
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<?php
	include('../admin_template/footer.php');
	?>