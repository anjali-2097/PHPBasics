<?php
include('../db/config.php');
$sql ="SELECT id,role,fname,lname,email,address,gender,phonenumber,technology_id,image,status FROM `user`";
// $result = $conn->query($sql);
$result = mysqli_query($conn,$sql);

$i=0;
while ($data = mysqli_fetch_assoc($result)) {
   $data2[]=$data;
   $sql2 = "SELECT GROUP_CONCAT(name SEPARATOR ',') AS techname
   FROM technology WHERE id IN (".$data['technology_id'].")";
   $row2 = mysqli_query($conn,$sql2);
   $data3 = mysqli_fetch_assoc($row2);

   $data2[$i]['techname'] = $data3['techname'];
   unset($data2[$i]['technology_id']);
   $i++;
}

foreach($data2 as $key => $data) {
  foreach ($data as $key1 => $value) {
     $head[] = $key1;
  }
  break;
}

$fp = fopen('php://output', 'w');

if ($fp && $result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="export_users.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, array_values($head)); 
    foreach ($data2 as $key => $value) {
      fputcsv($fp, array_values($value));
    }
    die;
}
?>