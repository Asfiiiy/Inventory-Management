<?php
include 'include/db.php';
if(isset($_POST['accountId']))
{
  $accountId = $_POST['accountId'];
   $select = "SELECT SUM(credit) AS totalcredit,SUM(debit) AS totaldebit FROM cash_in_bank_history WHERE cash_in_bank_id = '$accountId'";
  $run = mysqli_query($connection,$select);
  $row = mysqli_fetch_array($run);
  $totalcredit = $row['totalcredit'];
  $totaldebit = $row['totaldebit'];
  $curent_balance = $totalcredit - $totaldebit;
  $data = array('current_balance' => $curent_balance);
  echo json_encode($data);
}
?>
