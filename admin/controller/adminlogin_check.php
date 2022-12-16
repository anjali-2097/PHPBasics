<?php
include('../../db/config.php');
// error_reporting(-1);
// ini_set('display_errors', 'On');
if($_POST['flag']=="login")
{

  $email = $_POST['user_id'];
  $password = $_POST['user_pass'];

  $email = mysqli_real_escape_string($conn, $email);
  $password = mysqli_real_escape_string($conn, $password);
  $password1 = md5($password);

  $sql ="SELECT email,password FROM user WHERE email='$email' AND password='$password1'";
  $result = mysqli_query($conn,$sql);
  $count = mysqli_num_rows($result);

  if($count==1)
  {  

    if($_POST['remember']=="true")
    {

      setcookie('user_email', $email, time()+60*60*7, '/');
     setcookie('user_password', $password, time()+60*60*7, '/');

   }

   $role="1";
   $sql ="SELECT role,email,fname FROM user WHERE role='$role' AND email='$email'";
   $result = mysqli_query($conn,$sql);
   $row = mysqli_fetch_assoc($result);
   $count = mysqli_num_rows($result);

   if($count==1)
   {
     session_start();
     $_SESSION['role']="1";
     $_SESSION['email']=$email;
     $_SESSION['fname']=$row['fname'];
     
     $responce['message']="Success";
     $responce['success']=1;

     echo json_encode($responce);
   }
   else
   {
    $status="1";
    $sql ="SELECT status,fname FROM user WHERE status='$status' AND email='$email'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $count = mysqli_num_rows($result);
    if($count==1){
      session_start();
      $_SESSION['role']="2";
      $_SESSION['email']=$email;
      $_SESSION['fname']=$row['fname'];
      $responce['message']="Success";
      $responce['success']=2;

      echo json_encode($responce);
    }
    else
    {
     echo "<script>alert('You are deactive') </script>";
     echo "<script language=\"javascript\">\n";
     echo 'window.location="http://localhost/demo1/adminlogin.php";';
     echo "</script>";		
   }
 }
}
else
{
  $sql ="SELECT email FROM user WHERE email='$email'";
  $result = mysqli_query($conn,$sql);
  $count = mysqli_num_rows($result);
  if($count!=1){

   $responce['message']="This ID is not registered.";
   $responce['success']=0;

   echo json_encode($responce);
   return $responce;
 }
 $responce['message']="Password is incorrect.";
 $responce['success']=0;

 echo json_encode($responce);
}

}
//send mail for reset password 
if($_POST['flag']=="forget_pass"){

  $email = $_POST['email'];
  $sql ="SELECT email FROM user WHERE email='$email'";
  $result = mysqli_query($conn,$sql);
  $count = mysqli_num_rows($result);
  if($count==0){
    $responce['data']="Email ID is incorrect.";
    $responce['message']="success";
    $responce['success']=0;

    echo json_encode($responce);
  }else{
    $key=rand(0,99999);
    $query_sql ="UPDATE user SET gen_key='$key' WHERE email='$email'";
    $result = mysqli_query($conn,$query_sql);

    require_once "../../vendor/autoload.php";
    require_once "../../vendor/phpmailer/phpmailer/src/PHPMailer.php";

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->IsSMTP();                                    
    $mail->Host = "smtp.gmail.com";  
    $mail->SMTPAuth = true; 
    $mail->Port = 465;

    $mail->SMTPSecure = 'ssl';  
    $mail->Username = "Enter your username";  
    $mail->Password = 'Enter your password'; 
    $mail->setFrom('Username');
    $mail->AddAddress($email);

    $mail->IsHTML(true);                        
    $mail->Subject = "Forget password link.";
    $mail->Body    = '<a href="localhost/adminpanel/admin/reset_pass.php?id='.$email.'&key='.$key.'">click here to reset your password..</a>';

    if(!$mail->Send())
    {
     $responce['data']="Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
     $responce['message']="Success";
     $responce['success']=0;

     echo json_encode($responce);
     return true;
   }

   $responce['data']="Message has been sent";
   $responce['message']="Success";
   $responce['success']=1;

   echo json_encode($responce);
 }
}
//query for update reset password
if(isset($_POST['reset_pass'])){

  $password=$_POST['password'];
  $confirmpass=$_POST['confirmpass'];
  if($password==$confirmpass){
    $password=md5($password);
    $email=$_POST['data'];
    $key="";
    $query_sql ="UPDATE user SET gen_key='$key', password=$password WHERE email='$email'";

    $result = mysqli_query($conn,$query_sql);

    if($result){
      echo "<script>alert('password reset successfuly') </script>";
      echo "<script language=\"javascript\">\n";
      echo 'window.location="http://localhost/adminpanel/index.php";';
      echo "</script>"; 
    }
  }else{
    echo "<script>alert('Enter same password.') </script>";
  }
}
?>