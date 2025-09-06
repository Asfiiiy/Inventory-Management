<?php
include 'include/db.php';
if(isset($_POST['accountId']))
{
  $accountId = $_POST['accountId'];
   $select = "SELECT `account_no`, `iban` FROM `cash_in_bank` WHERE id = '$accountId'";
  $run = mysqli_query($connection,$select);
  $row = mysqli_fetch_array($run);
  $account_no = $row['account_no'];
  $iban = $row['iban'];
  $data = array('account_no' => $account_no, 'acount_iban' => $iban);
  echo json_encode($data);
}
?>
