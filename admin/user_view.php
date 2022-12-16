<?php
session_start();
if(!isset($_SESSION['email']))
{
  header("location:../index.php");
}
include('../admin_template/header.php');
$id=$_GET['id'];
$sql="SELECT * FROM user  WHERE id='$id'";
$row = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($row);

$sql2 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
FROM technology WHERE id IN (".$data['technology_id'].")";
$row1 = mysqli_query($conn,$sql2);
$data2 = mysqli_fetch_assoc($row1);

$data['techname'] = $data2['techname'];
unset($data['technology_id']);
?>
<style type="text/css">
input {
  font-weight: bold;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      User Detail
    </h1>
    <ol class="breadcrumb">
     <li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="users.php"><i class="fa fa-users"></i> Users</a></li>
     <li class="active"><i class="fa fa-user"></i> User detail</li>
   </ol> 
 </section>
 <section class="content">
  <div class="box">
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
         <div class="col-md-6">
          <div class="form-group">
            <label>First Name:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <input type="text" class="form-control" value="<?php echo $data['fname']?>" readonly/>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Last Name:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <input type="text" class="form-control" value="<?php echo $data['lname']?>" readonly/>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
       <div class="col-md-7">
        <div class="form-group">
          <label>Email ID:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-envelope"></i>
            </div>
            <input type="text" class="form-control" value="<?php echo $data['email']?>" size="20" readonly/>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <label>Profile Image:</label>
        <img src="../assets/image/<?php echo $data['image']?>" width="150px">
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-6">
      <div class="col-md-6">
        <div class="form-group has-feedback">
          <label>Gender:</label><br>
          <label class="checkboxcont" style="display: block; float: left;">
            <input type="radio" id="Male" name="gender" value="male" <?php if( $data['gender']=="male"){echo "checked";} ?> disabled>
            <span class="checkmark checkmarkradio"></span>Male
          </label>
          <label class="checkboxcont" style="display: inline-block;     margin-left: 15px;">
            <input type="radio" id="Female" name="gender" value="female" <?php if( $data['gender']=="female"){echo "checked";} ?> disabled>
            <span class="checkmark checkmarkradio"></span>Female
          </label>
        </div> 
      </div>
      <div class="col-md-6">
       <div class="form-group">
         <label>Address:</label><br>
         <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-home"></i>
          </div>
          <input type="text" class="form-control" value="<?php echo $data['address']?>" readonly/>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="col-md-6">
      <div class="form-group">
       <label>Phone Number:</label>
       <div class="input-group">
        <div class="input-group-addon">
          <i class="fa fa-phone"></i>
        </div>
        <input type="text" class="form-control" value="<?php echo $data['phonenumber']?>" readonly/>
      </div>
    </div>
  </div>
  <div class="col-md-6">
   <div class="form-group">
    <label>Technology:</label>
    <div class="input-group">
      <div class="input-group-addon">
        <i class="fa fa-user"></i>
      </div>
      <input type="text" class="form-control" value="<?php echo $data['techname']?>" readonly/>
    </div>
  </div>
</div>
</div>
</div>
<?php
$upload_image=explode(',', $data['multi_image']);
if(!empty($upload_image['0'])){
  ?>
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-12">
        <label>Uploaded File & Images:</label><br>
        <?php 
        foreach ($upload_image as $value) {
          $ext = pathinfo($value, PATHINFO_EXTENSION);
          if($ext=="pdf"){
            ?>
            <a href="../assets/image2/<?php echo $value?>" download><img src="../assets/image2/pdf.png" width="120px" height="70px" title="<?php echo $value?>" style="margin-left: 10px"></a>
          <?php }else if($ext=="docx"){ ?>
            <a href="../assets/image2/<?php echo $value?>" download><img src="../assets/image2/doc.png" width="100px" height="70px" title="<?php echo $value?>" style="margin-left: 10px"></a>
          <?php }else if($ext=="xls" || $ext=="xlsx" || $ext=="csv"){ ?>
            <a href="../assets/image2/<?php echo $value?>" download><img src="../assets/image2/axcel.png" width="130px" height="80px" title="<?php echo $value?>" style="margin-left: 10px"></a>
          <?php }else{ ?>
            <a href="../assets/image2/<?php echo $value?>" download><img src="../assets/image2/<?php echo $value?>" width="130px" height="80px" style="margin-left: 10px"></a>
          <?php }} ?>
        </div>
      </div>
    </div>
  <?php } ?>
</div>
</div>
</div>
</section>
</div>
<?php
include('../admin_template/footer.php');
?>