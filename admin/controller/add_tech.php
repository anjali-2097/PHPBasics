<?php
include('../../db/config.php');
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


?>