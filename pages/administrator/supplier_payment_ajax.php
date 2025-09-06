<?php
include 'include/db.php';
if(isset($_POST['supplier_id']))
{
  $supId = $_POST['supplier_id'];
  $select1 = "SELECT SUM(sl.credit - sl.debit) AS Balance
     FROM   supplier_ledger sl
               WHERE sl.supplier_id = '$supId'";
  $run1 = mysqli_query($connection,$select1);

  $select2 = "SELECT SUM(paid) AS totalpaid FROM supplier_payment WHERE supplier_id = '$supId'";
  $run2 = mysqli_query($connection,$select2);
                  
  $countRow = mysqli_num_rows($run1);
  if($countRow != '0' OR $countRow != 0)
  {
    $row2 = mysqli_fetch_array($run2);
    $row = mysqli_fetch_array($run1);
    
    if($row['Balance'] == '')
    {
      $Balance = 0;
    }
    else
    {
      $Balance = $row['Balance'];
    }

    if($row2['totalpaid'] == '')
    {
      $totalpaid = 0;
    }
    else
    {
      $totalpaid = $row2['totalpaid'];
    }
    $final_Amount = $Balance;
  }
  else
  {
    $final_Amount = 0;
  }
  
  $data = array('total' => $final_Amount);
  echo json_encode($data);
}
?>
