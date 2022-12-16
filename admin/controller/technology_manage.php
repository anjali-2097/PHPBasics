<?php
include('../../db/config.php');
// error_reporting(-1);
// ini_set('display_errors', 'On');

// add user in database
if($_POST['flag']=="add_technology") {
	$technology=$_POST['technology'];
	$sql ="SELECT name FROM technology WHERE name='$technology'";
	$result1 = mysqli_query($conn,$sql);
	$count = mysqli_num_rows($result1);
	if($count==0)
	{
		$delete_status=0;
		$sql = "INSERT INTO technology(name,is_deleted) VALUES ('$technology','$delete_status')";
		$res = mysqli_query($conn,$sql);
		$id=mysqli_insert_id($conn);

		$result['id']=$id;
		$result['message']="Success";
		$result['success']=1;

		echo json_encode($result); 
	}else{
		$result['message']="Technology already exist. Please Add another Technology.";
		$result['success']=0;
		echo json_encode($result);
	}
}
// Query for delete technology 
if($_POST['flag']=="delete_technology")
{
  $id=$_POST['id'];
  $sql="DELETE FROM technology WHERE id='$id'";
  $deleted = mysqli_query($conn,$sql);

  $result['message']="Success";
  $result['success']=1;

  echo json_encode($result); 
}

// Query for select technology data to edit form
if($_POST['flag']=="edit_technology"){
  $id=$_POST['id'];
  $sql="SELECT * FROM technology WHERE id='$id'";
  $edit_responce = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($edit_responce); 
  
  $result['data']=$row;
  $result['message']="Success";
  $result['success']=1;
  echo json_encode($result); 
}

if($_POST['flag']=="edit_technology_update") {
	$technology=$_POST['technology'];
	$id=$_POST['id'];
	 $sql ="UPDATE technology SET name='$technology' WHERE id='$id'";
	$res = mysqli_query($conn,$sql);

	$result['message']="Success";
	$result['success']=1;

	echo json_encode($result); 
}

?>

