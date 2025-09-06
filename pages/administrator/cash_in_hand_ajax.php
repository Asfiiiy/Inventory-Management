<?php
	include "include/db.php";

	if(isset($_POST['from_date']) AND isset($_POST['to_date']) AND isset($_POST['order_by']))
	{
  	$from_date = $_POST['from_date'];
  	$to_date = $_POST['to_date'];
  	$order_by = $_POST['order_by'];
?>

<div class="table-responsive">
    <table class="table text-center table-bordered table-hover datatable table-striped" data-page-length="1000000" id="export_table">
  <thead class="my-table-style text-white" class="printcolor">
    <tr>
      <th>S.No</th>
      <th>Date</th>
      <th>Name/Contact</th>
      <th>Payment Via</th>
      <th class="text-left">Cash IN</th>
      <th class="text-left">Cash OUT</th>
      <th>Slip No</th>
      <th>Details</th>
      <th class="printBlock">Receipt</th>
      <th class="printBlock">Action</th>
    </tr>
  </thead>
  <tbody class="table-font-size">
    <?php
    $serial = 0;
  $select1 = "SELECT c.id, c.pay_date, c.pay_person, c.contact, p.method, c.amount, c.pay_status, c.slip_no, c.details, c.receipt, c.pay_by, cio.customer FROM cash_history AS c LEFT JOIN customer_in_out AS cio ON cio.id = c.cust_INOUT_id LEFT JOIN payment_method AS p ON p.id = c.pay_type_id WHERE c.pay_date BETWEEN '$from_date' AND '$to_date' ORDER BY c.pay_date $order_by";
    $run1 = mysqli_query($connection,$select1);
    $totalOut = 0;
    $totalIn = 0;
    while($row = mysqli_fetch_array($run1))
    {
      $serial++;
      $payment_date = date("d-m-Y",strtotime($row['pay_date']));
      $cashId = $row['id'];
      if($row['customer'] != "")
      {
        $customer = $row['customer'];
      }
      else
      {
        $customer = $row['pay_person'];
      }
      
      $contact = $row['contact'];
      $method = $row['method'];
      $amount = number_format($row['amount']);
      $pay_status = $row['pay_status'];
      $slip_no = $row['slip_no'];
      $details = $row['details'];
      $pay_by = $row['pay_by'];
      $receipt = $row['receipt'];
      if($pay_by == 'Direct Cash')
      {
        $pathImg    = "../../images/admin/cash_in_hand_recp/".$receipt;
      }
      elseif($pay_by == 'Sale' OR $pay_by == 'Customer Payment')
      {
        $pathImg    = "../../images/admin/customers_recp/".$receipt;
      }
      elseif($pay_by == 'Supplier Payment' OR $pay_by == 'Purchase')
      {
        $pathImg    = "../../images/admin/suppliers_recp/".$receipt;
      }
      elseif($pay_by == 'Expense')
      {
        $pathImg = "../../images/admin/exp_recpt/" . $receipt;
      }
      else
      {
        $pathImg = '';
      }
      
    ?>
    <tr class="my-table-row-hover">
      <td class="pt-2"><?php echo $serial; ?></td>
      <td class="pt-2"><?php echo $payment_date ?></td>
      <td class="pt-2"><?php echo $customer."/".$contact; ?></td>
      <td class="pt-2"><?php echo $method ?></td>
      <td class="inPay text-left pt-2"><i class="fa fa-arrow-down text-success" aria-hidden="true"></i> <?php if($pay_status == 'IN'){ echo $amount; $totalIn += str_replace(',','',$amount); } else { echo 0; } ?></td>
      <td class="outPay text-left pt-2"><i class="fa fa-arrow-up text-danger" aria-hidden="true"></i> <?php if($pay_status == 'OUT'){ echo $amount; $totalOut += str_replace(',','',$amount); } else { echo 0; } ?></td>
      <td class="pt-2"><?php echo $slip_no; ?></td>
      <td class="pt-2"><?php echo $details; ?></td>
      <td class="printBlock">
        <?php
          if($receipt != '')
          { ?>
          <a href="<?php echo $pathImg ?>" target="_blank"><img src="<?php echo $pathImg ?>" width="70px" height="50px" style="border-radius: 5%" ></a>
          <?php }
          else
          {
          echo "Not Uploaded";
          }
        ?>
      </td>
      <td class="printBlock">
        <?php
          if($pay_by == 'Direct Cash')
          { ?>
          <a href="cash_in_hand_update.php?id=<?php echo $cashId ?>" class="btn btn-success btn-sm shadow title" title="Update"><i class="fa fa-edit"></i></a>
          <input type="hidden" id="imgPath<?php echo $cashId ?>" value="<?php echo $pathImg ?>">
          <a class="btn btn-sm btn-danger mt-1 shadow text-white" title="Delete" onclick="deleteData(<?php echo $cashId ?>)"><span><i class="fa fa-trash-alt"></i></span></a>
          <?php }
        ?>
      </td>
    </tr>
    <?php } ?>
  </tbody>
  <footer>
    <tr style="background: grey; color: white" class="printcolor">
      <th></th>
      <th></th>
      <th></th>
      <th class="text-right">Total</th>
      <th class="text-left"><?php echo number_format($totalIn) ?></th>
      <th class="text-left"><?php echo number_format($totalOut) ?></th>
      <th></th>
      <th>Cash IN Hand = <?php echo number_format($totalIn-$totalOut); ?></th>
      <th class="printBlock"></th>
      <th class="printBlock"></th>
    </tr>
  </footer>
</table>
</div>

<?php } ?>