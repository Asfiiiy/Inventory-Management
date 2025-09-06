<?php

include "include/db.php";

if(isset($_POST['supplierId']))
{
  $supplierId = $_POST['supplierId'];
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];

  $queryR = "SELECT SUM(debit) AS dr, SUM(credit) AS cr FROM supplier_ledger WHERE supplier_id = '$supplierId' AND Ldate BETWEEN '$from_date' AND '$to_date' ORDER BY Ldate, id";
  $resultR = mysqli_query($connection,$queryR);
  $rowDataR = mysqli_fetch_array($resultR);
  $DR  = $rowDataR['dr'];
  $CR   = $rowDataR['cr'];
?>
  <h4 class="text-right text-dark">Current Balance : <?php echo number_format($DR-$CR,2); ?></h4>
  <table class="table table-bordered text-center" style="font-size:12px;">
    <thead class="bg-dark text-white printcolor">
      <tr>
        <th>S.No</th>
        <th width="12%">Date</th>
        <th width="38%">Description</th>
        <th width="15%">DR.</th>
        <th width="15%">CR.</th>
        <th width="15%">Balance</th>
      </tr>
    </thead>
    <tbody>
    <?php
      $count=0;
      $totalCR=0;
      $totalDR=0;

      $query = "SELECT * FROM supplier_ledger WHERE supplier_id = '$supplierId' AND Ldate BETWEEN '$from_date' AND '$to_date' ORDER BY Ldate, id";
      $result = mysqli_query($connection,$query);
      while($rowData = mysqli_fetch_array($result))
      {
        $count++;
        $Ldate   = date("d-m-Y",strtotime($rowData['Ldate']));
        $purchase_id   = $rowData['purchase_id'];
        $payment_id   = $rowData['payment_id'];
        $debit   = $rowData['debit'];
        $credit   = $rowData['credit'];
        if ($debit =='') {
          $debit=0;
        }
        if ($credit =='') {
          $credit = 0;
        }
        $totalDR += $debit;

        $totalCR += $credit;
        $balance   = $totalDR-$totalCR;

        $details   = $rowData['details'];
        if($debit == 0)
        {
          $debit = '';
        }
        else
        {
          $debit = number_format($debit,2);
        }
        if($credit == 0)
        {
          $credit = '';
        }
        else
        {
          $credit = number_format($credit,2);
        }
      ?>
      <tr>
        <td><?php echo $count; ?></td>
        <td><?php echo $Ldate; ?></td>
        <td><?php echo $details; ?></td>
        <th class="text-danger"><?php echo $debit; ?></th>
        <th class="text-success"><?php echo $credit; ?></th>
        <th class="text-primary"><?php echo number_format($balance,2); ?></th>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <br>
<?php } ?>