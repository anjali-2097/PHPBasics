<?php
include('../../db/config.php');
include("../../Classes/PHPExcel/IOFactory.php");
include("../../Classes/PHPExcel.php");
// error_reporting(-1);
// ini_set('display_errors', 'On');

// add user in database
if($_POST['flag']=="form_reg_submit") 
{
  $role="2";
  $status="0";
  $f_name =  mysqli_real_escape_string($conn, $_POST['f_name']);
  $l_name =  mysqli_real_escape_string($conn, $_POST['l_name']);
  $password =  mysqli_real_escape_string($conn, $_POST['password']);
  $password = md5($password);
  $address =  mysqli_real_escape_string($conn, $_POST['address']);
  $city =  mysqli_real_escape_string($conn, $_POST['address']);
  $phonenumber =  mysqli_real_escape_string($conn, $_POST['phone_number']);
  $email =  mysqli_real_escape_string($conn, $_POST['email']);
  $gender =  mysqli_real_escape_string($conn, $_POST['gender']);
  $multiimage=  mysqli_real_escape_string($conn, $_POST['multiple_img']);
  $data1 = ltrim($multiimage, ',');
  $data2 = ltrim($data1, ',');

  //$technology =  mysqli_real_escape_string($conn, $_POST['technology']);
  $technology =  mysqli_real_escape_string($conn,implode(',', $_POST['technology']));

  if(!empty($_FILES["fileToUpload"]["name"])){
    $response = image_upload_check($_FILES);
  }else{
    $result['message']="Please browse image";
    $result['success']=0;
    echo json_encode($result);
  }

  if($response['success']==0){

    echo json_encode($response); 
  }else{
    $image = $response['data'];
    $sql1 ="SELECT email FROM user WHERE email='$email'";
    $result1 = mysqli_query($conn,$sql1);
    $count1 = mysqli_num_rows($result1);
    if($count1==0)
    {
     $sql = "INSERT INTO user(role,fname,lname,email,password,address,phonenumber,gender,technology_id,image,multi_image,status) VALUES ('$role','$f_name','$l_name','$email','$password','$address','$phonenumber','$gender','$technology', '$image','$data2','$status')";

     $res = mysqli_query($conn,$sql);
     $id=mysqli_insert_id($conn);
     $sql1="SELECT * FROM user  WHERE id='$id'";
     $row1 = mysqli_query($conn,$sql1);
     $data = mysqli_fetch_assoc($row1);

     $sql2 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
     FROM technology WHERE id IN (".$data['technology_id'].")";
     $row2 = mysqli_query($conn,$sql2);
     $data2 = mysqli_fetch_assoc($row2);

     $data['techname'] = $data2['techname'];

     $result['data']=$data;
     $result['message']="Success";
     $result['success']=1;

     echo json_encode($result); 
   }else
   {
    $result['data']="";
    $result['message']="EMAIL ALREADY EXIST. Please REGISTER by another E_mail Id.";
    $result['success']=0;
    echo json_encode($result);
  }
}
}
// query for delete user
if($_POST['flag']=="delete_user")
{
  $id=$_POST['id'];
  $sql="DELETE FROM user WHERE id='$id'";
  $deleted = mysqli_query($conn,$sql);

  $result['message']="Success";
  $result['success']=1;

  echo json_encode($result); 
}
// Query for chainge status of user
if($_POST['flag']=="toggle_button"){
  $id=$_POST['id'];
  $status=$_POST['status'];
  $sql ="UPDATE user SET status='$status' WHERE id='$id'";
  $response = mysqli_query($conn,$sql);

  if($response){
    $result['message']="Success";
    $result['success']=1;
  }else{
    $result['message']="";
    $result['success']=0;
  }
  echo json_encode($result); 
}
// Query for select user data to edit form
if($_POST['flag']=="edit_user"){
  $id=$_POST['id'];
  $sql="SELECT * FROM user WHERE id='$id'";
  $edit_responce = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($edit_responce); 
  
  $result['data']=$row;
  $result['message']="Success";
  $result['success']=1;
  echo json_encode($result); 
}
// query for update user data 
if(isset($_POST['edit_user_data']) && $_POST['edit_user_data']==1) 
{
  $id=mysqli_real_escape_string($conn, $_POST['edit_id']);
  $f_name =  mysqli_real_escape_string($conn, $_POST['f_name']);
  $l_name =  mysqli_real_escape_string($conn, $_POST['l_name']);
  $address =  mysqli_real_escape_string($conn, $_POST['address']);
  $city =  mysqli_real_escape_string($conn, $_POST['address']);
  $phonenumber =  mysqli_real_escape_string($conn, $_POST['phone_number']);
  $email =  mysqli_real_escape_string($conn, $_POST['email']);
  $gender =  mysqli_real_escape_string($conn, $_POST['gender']);
  // $technology =  mysqli_real_escape_string($conn, $_POST['technology']);
  $technology =  mysqli_real_escape_string($conn,implode(',', $_POST['technology']));
  $image =$_POST['edit_image'];

  if(!empty($_FILES["fileToUpload"]["name"])){
    $response = image_upload_check($_FILES);
    if($response['success']==0){
      echo json_encode($response); 
    }else{
      $image=$response['data'];
    }
  }else{
    $image=$image;
  }

  $sql ="UPDATE user SET fname='$f_name', lname='$l_name', email='$email', address='$city', phonenumber='$phonenumber', gender='$gender', technology_id='$technology', image='$image', updated_date='$date' WHERE id='$id'";

  $editdata_responce = mysqli_query($conn,$sql);

  $sql="SELECT * FROM user WHERE id='$id'";
  $row1 = mysqli_query($conn,$sql);
  $data = mysqli_fetch_assoc($row1);
  // $sql="SELECT user.*, technology.name FROM user LEFT JOIN technology ON user.technology_id = technology.id WHERE user.id='$id'";

  $sql2 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
  FROM technology WHERE id IN (".$data['technology_id'].")";
  $row2 = mysqli_query($conn,$sql2);
  $data2 = mysqli_fetch_assoc($row2);

  $data['techname'] = $data2['techname'];

  $result['data']=$data;
  $result['message']="Success";
  $result['success']=1;
  echo json_encode($result); 
  
}

function image_upload_check($files){

 $target_dir = "../../assets/image/";
 $target_file = $target_dir . basename($files["fileToUpload"]["name"]);
 $uploadOk = 1;
 $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 $check = getimagesize($files["fileToUpload"]["tmp_name"]);

 if($check !== false) 
 {
  $uploadOk = 1;
} 
else 
{
        // echo "File is not an image.";
  $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
  $uploadOk = 0;
$message="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  $result['data']="";
  $result['message']=$message;
  $result['success']=0;
  return  $result;
// if everything is ok, try to upload file
} else {
 if (move_uploaded_file($files["fileToUpload"]["tmp_name"], $target_file)) {

   $image = basename( $files["fileToUpload"]["name"]); 

   $result['data']=$image;
   $result['message']="";
   $result['success']=1;
   return $result;

 } else {
   $result['data']="";
   $result['message']="Sorry, there was an error uploading your file.";
   $result['success']=0;

   return  $result;

 }
} 

}
// multiple file select 
if($_POST['flag']=="multi_image"){
 $target_dir = "../../assets/image2";
 $image_array=array();
 foreach($_FILES["file2_upload"]["name"] as $key=>$name)
 {
  $tmp_name = $_FILES["file2_upload"]["tmp_name"][$key];
  $name = $_FILES["file2_upload"]["name"][$key];
  move_uploaded_file($tmp_name, "$target_dir/$name");
  array_push($image_array, $name);
}
$result['data']=$image_array;
$result['message']="image upload successfuly";
$result['success']=1;

echo json_encode($result); 
}

//query for insert and update user data from uploaded csv file
if($_POST['flag']=="form_import_user"){

  if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
    $allowedExtensions = array("xls","xlsx","csv");
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    if(in_array($ext, $allowedExtensions)) {
     $file_size = $_FILES['file']['size'] / 1024;

     if($file_size < 50) {
       $file = "../../assets/upload_csv/".$_FILES['file']['name'];
       $isUploaded = copy($_FILES['file']['tmp_name'], $file);

       if($isUploaded) {

        try {
          $objPHPExcel = PHPExcel_IOFactory::load($file);
        } catch (Exception $e) {
         die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME). '": ' . $e->getMessage());
       }

       $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
       foreach ($cell_collection as $cell) 
       {
         $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
         $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
         $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
         if ($row == 1) 
         {
          $header[]= $data_value;
        } 
        else 
        {
          $arr_data[$row][] = $data_value;
        }
      }
      foreach($arr_data as $data){
       $data2[]=array_combine($header, $data);
     }
     $incorrect_data_count=0;
     $inserted_data_count=0;
     $updated_data_count=0;
     foreach($data2 as $data){
      if(!empty($data)){

        $sql ="SELECT email FROM user WHERE email='".$data['email']."'";
        $response = mysqli_query($conn,$sql);

        if($response->num_rows > 0){

          $exp=explode(",",$data['name']);
          $imp=implode('\',\'', $exp);

          $sql2 = "SELECT GROUP_CONCAT(id SEPARATOR ',') AS technology_id
          FROM technology WHERE name IN ('".$imp."')";

          $row2 = mysqli_query($conn,$sql2);
          $data3 = mysqli_fetch_assoc($row2);

          $sql2 ="UPDATE user SET role='".$data['role']."', fname='".$data['fname']."', lname='".$data['lname']."', address='".$data['address']."', phonenumber='".$data['phonenumber']."', gender='".$data['gender']."', technology_id='".$data3['technology_id']."' WHERE email='".$data['email']."'";

          $res = mysqli_query($conn,$sql1);

          $sql3="SELECT * FROM user  WHERE email='".$data['email']."'";
          $row1 = mysqli_query($conn,$sql3);
          $id_data = mysqli_fetch_assoc($row1);

          $sql4 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
          FROM technology WHERE id IN (".$id_data['technology_id'].")";
          $row3 = mysqli_query($conn,$sql4);
          $data2 = mysqli_fetch_assoc($row3);

          $id_data['techname'] = $data2['techname'];
          $updated_data_count++;
        }else{

          $exp=explode(",",$data['name']);
          $imp=implode('\',\'', $exp);

          $sql2 = "SELECT GROUP_CONCAT(id SEPARATOR ',') AS technology_id
          FROM technology WHERE name IN ('".$imp."')";

          $row2 = mysqli_query($conn,$sql2);
          $data3 = mysqli_fetch_assoc($row2);
          $sql2 = "INSERT INTO user(role,fname,lname,email,password,address,phonenumber,gender,technology_id,status) VALUES ('".$data['role']."','".$data['fname']."','".$data['lname']."','".$data['email']."','".$data['password']."','".$data['address']."','".$data['phonenumber']."','".$data['gender']."','".$data3['technology_id']."','".$data['status']."')";

          $res = mysqli_query($conn,$sql2);

          $id=mysqli_insert_id($conn);
          $sql3="SELECT * FROM user  WHERE id='$id'";
          $row1 = mysqli_query($conn,$sql3);
          $id_data = mysqli_fetch_assoc($row1);

          $sql4 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
          FROM technology WHERE id IN (".$id_data['technology_id'].")";
          $row3 = mysqli_query($conn,$sql4);
          $data2 = mysqli_fetch_assoc($row3);

          $id_data['techname'] = $data2['techname'];
          $inserted_data_count++;
        }
      }else{
        $incorrect_data_count++;
      }
    }  


    $result['inserted_count']= $inserted_data_count;
    $result['updated_count']= $updated_data_count;
    $result['incorrect_count']= $incorrect_data_count;
    $result['message']="File has been successfully Imported.";
    $result['success']=1;
    session_start();
    $_SESSION['data']=$result;
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);

    echo json_encode($result); 
  } else {
   $result['data']="";
   $result['message']="Error: File not uploaded!";
   $result['success']=0;
   echo json_encode($result); 
 }
} else { 
  $result['data']="";
  $result['message']="Error: Maximum file size should not cross 50 KB on size!";
  $result['success']=0;
  echo json_encode($result); 
}
} else {
  $result['data']="";
  $result['message']="Error: This type of file not allowed!";
  $result['success']=0;
  echo json_encode($result); 
}
} else {
  $result['data']="";
  $result['message']="Error: Select an excel file first!";
  $result['success']=0;
  echo json_encode($result); 
}
}
//query for delete multiple user
if($_POST['flag']=="delete_selected_user"){

  $id= implode(',', $_POST['id']);
  $sql = "DELETE FROM user WHERE id IN (". $id.")";
  $response = mysqli_query($conn,$sql);

  $result['message']="success";
  $result['success']=1;
  echo json_encode($result); 
}

if($_POST['flag']=="filter"){
 $id=$_POST['id'];
 $gender=$_POST['gender'];

 if(!empty($id) && !empty($gender)){
  $sql="SELECT * FROM user  WHERE FIND_IN_SET('$id', technology_id) AND gender='$gender'";
   $response = mysqli_query($conn,$sql);

   $i=0;
   while ($data = mysqli_fetch_assoc($response)) {
    $data1[]=$data;
    $sql2 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
     FROM technology WHERE id IN (".$data['technology_id'].")";
    $row = mysqli_query($conn,$sql2);
    $data2 = mysqli_fetch_assoc($row);
    $data1[$i]['techname']=$data2['techname'];
    $i++;
  }
 }else if(!empty($id) && empty($gender)){
   $sql="SELECT * FROM user  WHERE FIND_IN_SET('$id', technology_id)";
   $response = mysqli_query($conn,$sql);

   $i=0;
   while ($data = mysqli_fetch_assoc($response)) {
    $data1[]=$data;
    $sql2 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
     FROM technology WHERE id IN (".$data['technology_id'].")";
    $row = mysqli_query($conn,$sql2);
    $data2 = mysqli_fetch_assoc($row);
    $data1[$i]['techname']=$data2['techname'];
    $i++;
  }
 }else if (empty($id) && !empty($gender)) {
  $sql="SELECT * FROM user  WHERE gender='$gender'";
  $response = mysqli_query($conn,$sql);

   $i=0;
   while ($data = mysqli_fetch_assoc($response)) {
    $data1[]=$data;
    $sql2 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
    FROM technology WHERE id IN (".$data['technology_id'].")";
  
    $row = mysqli_query($conn,$sql2);
    $data2 = mysqli_fetch_assoc($row);
    $data1[$i]['techname']=$data2['techname'];
    $i++;
  }
 }else{
  $sql="SELECT * FROM user  WHERE role=2";
   $response = mysqli_query($conn,$sql);

   $i=0;
   while ($data = mysqli_fetch_assoc($response)) {
    $data1[]=$data;
    $sql2 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
    FROM technology WHERE id IN (".$data['technology_id'].")";
    $row = mysqli_query($conn,$sql2);
    $data2 = mysqli_fetch_assoc($row);
    $data1[$i]['techname']=$data2['techname'];
    $i++;
  }
} 
$result['data']=$data1;
$result['message']="success";
$result['success']=1;
echo json_encode($result);

}

?>

