<?php
include 'include/db.php';
if(isset($_POST['customer_id']))
{
  $supId = $_POST['customer_id'];
   $select = "SELECT `name`, `mobile` FROM `customer` WHERE id = '$supId'";
  $run = mysqli_query($connection,$select);
  $row = mysqli_fetch_array($run);
  $name = $row['name'];
  $mobile = $row['mobile'];
  $data = array('customer_name' => $name, 'customer_mobile' => $mobile);
  echo json_encode($data);
}
?>
