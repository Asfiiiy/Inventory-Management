<?php include("include/header.php");
  $pay_id=$_GET['pay_id'];
  $cust_id = $_GET['cust_id'];
?>
<div class="page-content container-fluid">
    <!--  Start Row  -->
    <?php
      $query1 = "SELECT customer_payment.paid, customer_payment.payment_date, SUM(customer_ledger.debit) AS t_debit, SUM(customer_ledger.credit) AS t_credit FROM customer_payment
JOIN customer_ledger ON customer_ledger.customer_id = customer_payment.customer_id
WHERE customer_payment.id='$pay_id' AND customer_payment.customer_id='$cust_id'";
$run_query1 = mysqli_query($connection, $query1);
while($query1RowData=mysqli_fetch_array($run_query1)){

  $paid_amount = $query1RowData['paid'];
  $paid_date = $query1RowData['payment_date'];
  $t_debit = $query1RowData['t_debit'];
  $t_credit = $query1RowData['t_credit'];
  $cal_t_amount = $t_credit-$t_debit;

}
?>
    <div class="row">
        <div class="col-md-12">
            <h3>Customer Payment Edit</h3>
        </div>
        <div class="col-md-12">
            <div class="card my-only-div-shadow">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="pay_date" value="<?php echo $paid_date; ?>"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Amount</label>
                                    <input type="text" placeholder="Total Amount" class="form-control" id="total"
                                        readonly value="<?php echo $cal_t_amount;?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment</label>
                                    <input type="text" name="paid" id="newPaid" placeholder="New Payment"
                                        value="<?php echo $paid_amount?>" autocomplete="off" onkeyup="getDues()"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Remaining</label>
                                    <input type="number" name="contact" id="new_dues" placeholder="New Remaining"
                                        class="form-control" readonly required>
                                </div>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <center>
                                    <input type="submit" class="btn btn-success shadow" value="Update" name="saveData">
                                </center>
                            </div>
                        </div>

                    </form>

                    <?php
          if (isset($_POST['saveData'])) {
            $pay_amt = $_POST['paid'];
            $pay_date = $_POST['pay_date'];
            
            
//Update Customer Ledger 
$insert = " UPDATE `customer_ledger` SET `debit`='$pay_amt', `Ldate` = '$pay_date' WHERE payment_id='$pay_id'";
$run = mysqli_query($connection,$insert);
if($run) {
// Update Customer Payment 
  $insert1 = "UPDATE `customer_payment` SET paid = '$pay_amt',`payment_date`='$pay_date' WHERE id= '$pay_id'";
  $run1= mysqli_query($connection,$insert1);
  // Update Cash History
$insert2 = "UPDATE cash_history SET amount = '$pay_amt' , `pay_date`= '$pay_date' WHERE client_payment_id = '$pay_id'";
$run2 = mysqli_query($connection,$insert2);
echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Updated!',
                          'Payment has been successfully Updated!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'customer_payment_list.php';
                          }
                          });
                          </script>
                        </body>
                      </html>";
}
else {
  echo "<!DOCTYPE html>
                          <html>
                          <body>
                            <script>
                            Swal.fire(
                            'Error !',
                            'payment not updated, Some error occure',
                            'error'
                            ).then((result) => {
                            if (result.isConfirmed) {
                            window.location.href = 'customer_payment_list.php';
                            }
                            });
                            </script>
                          </body>
                          </html>";
}
          }
          ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row  -->
</div>
<?php include("include/footer.php") ?>

<script type="text/javascript">
function getDues() {
    var total = parseFloat($('#total').val());
    var newPaid = parseFloat($('#newPaid').val());
    if ($('#newPaid').val() == '') {
        newPaid = 0;
    }
    if ($('#oldDues').val() == '') {
        oldDues = 0;
    }
    $("#new_dues").val(total - newPaid);
}
</script>