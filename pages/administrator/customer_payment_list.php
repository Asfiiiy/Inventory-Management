<?php include("include/header.php") ?>
<div class="page-content container-fluid">
  <!--  Start Row  -->
  <div class="row">
    <div class="col-md-12">
      <h3>Customer Payment List</h3>
    </div>
    <div class="col-md-12">
      <div class="card my-only-div-shadow">
        <div class="card-body table-responsive">
          <table class="table table-striped table-bordered datatable text-center my-only-div-shadow" data-page-length="25">
            <thead class="my-table-style text-white">
              <tr>
                <th>S.No</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="table-font-size">
         <?php
            $count = 0;
            $fetchData = "SELECT customer_payment.id, customer_payment.customer_id,customer.name ,customer_payment.paid, customer_payment.payment_date FROM customer_payment
JOIN customer ON customer.id = customer_payment.customer_id ORDER BY customer_payment.id DESC";
$run_fetchData = mysqli_query($connection,$fetchData);

while($fetchDataRow = mysqli_fetch_array($run_fetchData)){
$count++;
$pay_id = $fetchDataRow['id'];
$cust_id = $fetchDataRow['customer_id'];
$cust_name = $fetchDataRow['name'];
$amount = $fetchDataRow['paid'];
$date = $fetchDataRow['payment_date'];
?>
<tr>
<td><?php echo $count;?></td>
    <td><?php echo $cust_name;?></td>
    <td><?php echo $amount?></td>
    <td><?php echo $date?></td>
    <td><a href="customer_payment_list_edit.php?pay_id=<?php echo $pay_id;?>&cust_id=<?php echo $cust_id;?>"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></a> | <a href="customer_payment_list_delete.php?pay_id=<?php echo $pay_id;?>&cust_id=<?php echo $cust_id;?>"> <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button> </a></td>
</tr>
<?php
}
         ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- End Row  -->
</div>

<?php include("include/footer.php") ?>