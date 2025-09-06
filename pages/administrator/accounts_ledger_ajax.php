<?php include('include/db.php');
if (isset($_POST['from']) && isset($_POST['to']) && isset($_POST['account_type'])) {
  $from = $_POST['from'];
  $to   = $_POST['to'];
  $account_type   = $_POST['account_type'];
?>
  <div class="table-responsive my-only-div-shadow py-4">
    <table class="table table-bordered data_table table-striped" id="export_table" data-page-length="1000000000">
      <thead class="my-table-style text-white">
        <tr>
          <th>S.No</th>
          <th>Date</th>
          <th>Type</th>
          <th>Details</th>
          <th>Credit</th>
          <th>Debit</th>
        </tr>
      </thead>
      <tbody class="table-font-size">
        <?php 
        $sr=0;
        $t_credit=0;
        $t_debit=0;
        $get_data = "SELECT * FROM account_cash WHERE `date` BETWEEN '$from' AND '$to' AND `type`='$account_type'";
        $run_data = mysqli_query($connection,$get_data);
        while($data_row = mysqli_fetch_array($run_data)){
            $sr++;
$id= $data_row['id'];
$identifier	= $data_row['identifier'];
$details	= $data_row['details'];
$credit	= $data_row['credit'];
$debit	= $data_row['debit'];
$date	= $data_row['date'];

$t_credit+=$credit;
$t_debit+=$debit;
?>

<tr>
    <td><?php echo $sr;?></td>
    <td><?php echo $date;?></td>
    <td><?php echo $identifier;?></td>
    <td><?php echo $details;?></td>
    <td><?php echo $credit;?></td>
    <td><?php echo $debit;?></td>
</tr>
<?php 
}
?>
<tr>
<td colspan="4"><span style="float:right;">Total:</span></td> 
<td><strong><?php echo $t_credit;?></strong></td>
<td><strong><?php echo $t_debit;?></strong></td>
</tr>
      </tbody>
    </table>
  </div>
<?php }

?>
