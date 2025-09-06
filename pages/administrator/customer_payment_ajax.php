<?php
include 'include/db.php';
if(isset($_POST['cust_id']))
{
  $cust_id = $_POST['cust_id'];
  $select1 = "SELECT SUM(cl.credit - cl.debit) AS Balance
     FROM   customer_ledger cl
               WHERE cl.customer_id = '$cust_id'";
  $run1 = mysqli_query($connection,$select1);

                  
  $countRow = mysqli_num_rows($run1);
  if($countRow != '0' OR $countRow != 0)
  {
    $row = mysqli_fetch_array($run1);
    if($row['Balance'] == '')
    {
      $Balance = 0;
    }
    else
    {
      $Balance = $row['Balance'];
      $final_Amount = $Balance;
    }
  }
 else
  {
    $final_Amount = 0;
  }

  
  $data = array('total' => $final_Amount);
  echo json_encode($data);
}
?>
