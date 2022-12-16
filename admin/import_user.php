<?php
include('../db/config.php');

$filename=$_FILES["file"]["name"];
print_r($filename);
die();
$ext=substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));

if($ext=="csv")
{
  $file = fopen($filename, "r");
         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
         {
         	print_r($emapData);
         	die();
            $sql = "INSERT INTO user(role,fname,lname,email,password,address,phonenumber,gender,technology_id,image,multi_image,status) VALUES ('$role','$f_name','$l_name','$email','$password','$address','$phonenumber','$gender','$technology', '$image','$data2','$status')";
            mysqli_query($sql);
         }
         fclose($file);
         echo "CSV File has been successfully Imported.";
}
else {
    echo "Error: Please Upload only CSV File";
}
?>