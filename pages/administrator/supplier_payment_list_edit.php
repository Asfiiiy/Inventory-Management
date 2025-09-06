<?php include("include/header.php");
  $pay_id=$_GET['pay_id'];
?>
<div class="page-content container-fluid">
    <!--  Start Row  -->
    <?php
      $query1 = "SELECT supplier_payment.paid, supplier_payment.payment_date, 
                        SUM(supplier_ledger.debit) AS t_debit, 
                        SUM(supplier_ledger.credit) AS t_credit 
                 FROM supplier_payment
                 JOIN supplier_ledger 
                 ON supplier_ledger.supplier_id = supplier_payment.supplier_id
                 WHERE supplier_payment.id='$pay_id'";
      $run_query1 = mysqli_query($connection, $query1);
      if ($run_query1) {
          $query1RowData = mysqli_fetch_array($run_query1);
          $paid_amount = $query1RowData['paid'];
          $paid_date = $query1RowData['payment_date'];
          $t_debit = $query1RowData['t_debit'];
          $t_credit = $query1RowData['t_credit'];
          $cal_t_amount = $t_credit - $t_debit;
      } else {
          echo "Error: " . mysqli_error($connection);
      }
    ?>
    <div class="row">
        <div class="col-md-12">
            <h3>Supplier Payment Edit</h3>
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
                          
                          // Update Supplier Ledger 
                          $update_ledger = "UPDATE `supplier_ledger` 
                                            SET `debit`='$pay_amt', `Ldate` = '$pay_date' 
                                            WHERE payment_id='$pay_id'";
                          $run_ledger = mysqli_query($connection, $update_ledger);
                          
                          if ($run_ledger) {
                              // Update Supplier Payment 
                              $update_payment = "UPDATE `supplier_payment` 
                                                 SET `paid` = '$pay_amt', `payment_date` = '$pay_date' 
                                                 WHERE `id` = '$pay_id'";
                              $run_payment = mysqli_query($connection, $update_payment);
                              
                              // Update Cash History
                              $update_cash = "UPDATE `cash_history` 
                                              SET `amount` = '$pay_amt', `pay_date` = '$pay_date' 
                                              WHERE `supplier_payment_id` = '$pay_id'";
                              $run_cash = mysqli_query($connection, $update_cash);
                              
                              if ($run_payment && $run_cash) {
                                  echo "<!DOCTYPE html>
                                        <html>
                                          <body>
                                            <script>
                                              Swal.fire(
                                                'Updated!',
                                                'Payment has been successfully updated!',
                                                'success'
                                              ).then((result) => {
                                                if (result.isConfirmed) {
                                                  window.location.href = 'supplier_payment_list.php';
                                                }
                                              });
                                            </script>
                                          </body>
                                        </html>";
                              } else {
                                  echo "<!DOCTYPE html>
                                        <html>
                                          <body>
                                            <script>
                                              Swal.fire(
                                                'Error!',
                                                'Payment not updated, some error occurred.',
                                                'error'
                                              ).then((result) => {
                                                if (result.isConfirmed) {
                                                  window.location.href = 'supplier_payment_list.php';
                                                }
                                              });
                                            </script>
                                          </body>
                                        </html>";
                              }
                          } else {
                              echo "Error: " . mysqli_error($connection);
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
    $("#new_dues").val(total - newPaid);
}
</script>