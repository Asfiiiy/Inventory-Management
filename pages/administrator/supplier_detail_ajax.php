<?php
include 'include/db.php';
if(isset($_POST['supplier_id']))
{
  $supId = $_POST['supplier_id'];
   $select = "SELECT `supplier_name`, `supplier_contact` FROM `supplier` WHERE id = '$supId'";
  $run = mysqli_query($connection,$select);
  $row = mysqli_fetch_array($run);
  $supplier_name = $row['supplier_name'];
  $mobile = $row['supplier_contact'];
  $data = array('suplier_name' => $supplier_name, 'suplier_mobile' => $mobile);
  echo json_encode($data);
}
?>
