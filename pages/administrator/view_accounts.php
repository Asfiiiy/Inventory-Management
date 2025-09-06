<?php include("include/header.php"); 
$today=date('Y-m-d');
$query = "SELECT 
    SUM(CASE WHEN type = 1 THEN credit - debit ELSE 0 END) AS cash_amount,
    SUM(CASE WHEN type = 2 THEN credit - debit ELSE 0 END) AS online_amount
FROM account_cash";
$run_query= mysqli_query($connection,$query);
while($query_row_data = mysqli_fetch_array($run_query)){
$cash_amount = $query_row_data['cash_amount'];
$online_amount = $query_row_data['online_amount'];
}
?>
<br>
<div class="row m-3">
    <div class="col-12">
    <div class="card">
  <div class="card-header mt-2 mb-2">
    <h4>Account Balance</h4>
  </div>
  <div class="card-body">
    <div class="row">
        <div class="col-6">
        <div class="col">
            <a href="sale_date_wise_report.php">
                <div class="card radius-10 border border-primary">
                    <div class="card-body my-only-div-shadow my-div-bg">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                            <h5 class="mb-0">Amount in Cash</h5>
                                <h2 class="font-weight-bold"><?php if($cash_amount!='' || $cash_amount!=null){echo $cash_amount;}else{echo 0;}?></h2>
                            </div>
                            <div class="widgets-icons bg-gradient-cosmic text-white"><i class='bx bx-money'></i></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        </div>


        <div class="col-6">
        <div class="col">
            <a href="purchase_date_wise_report.php">
                <div class="card radius-10 border border-danger">
                    <div class="card-body my-only-div-shadow my-div-bg">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0">Amount in Bank</h5>
                                <h2 class="font-weight-bold"><?php if($online_amount!='' || $online_amount!=null){echo $online_amount;}else{echo 0;}?></h2>
                            </div>
                            <div class="widgets-icons bg-gradient-burning text-white"><i class='bx bx-credit-card'></i></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        </div>
          <div class="row mt-4">
            <div class="col-2">
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bx bx-plus"></i> Add Amount</button>
            </div>
          </div>
    </div>
  </div>
</div>
    </div>
</div>

<?php include("include/footer.php") ?>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="bx bx-plus"></i> Add Cash/Bank Amount</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
      <div class="row">
      <div class="col-6">
                            <div class="form-group">
                                <label>Select Account</label>
                                <select class="form-control select2" name="pay_type">
                                    <option value="1">Cash</option>
                                    <option value="2">Online/Bank</option>
                                </select>
                            </div>
                        </div>
      </div>
      <div class="row mt-2">
      <div class="col-2" style="width:80px;">
      <div class="form-check mt-4">
  <input class="form-check-input" type="radio" name="exampleRadios" value="credit" checked>
  <label class="form-check-label" for="cash">
    Credit
  </label>
</div>
       </div>
       <div class="col-2" style="width:80px;">
       <div class="form-check mt-4">
  <input class="form-check-input" type="radio" name="exampleRadios" value="debit">
  <label class="form-check-label" for="online">
    Debit
  </label>
</div>
</div>
<div class="col-5">
<div class="form-group">
                                <label>Enter Amount</label>
                                <input type="number" step="any" name="amount" id="amount" class="form-control"
                                placeholder="Enter Amount" value="0">
                            </div>
</div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit_amount" class="btn btn-primary">Add Amount</button>
      </div>
</form>
    </div>
  </div>
</div>

<?php 
if(isset($_POST['submit_amount'])){
    $pay_type  = $_POST['pay_type'];
    $amount = $_POST['amount'];
    $radio_type = $_POST['exampleRadios']; 

    if($pay_type==1){

        if($radio_type=='credit'){
        $query_new = "INSERT INTO `account_cash`(`type`,`identifier`,`details`,`credit`,`debit`,`date`) 
        VALUES ('1','Cash Amount Added','Mannual Credit Amount Added','$amount','0','$today')";
          }elseif($radio_type=='debit'){
            $query_new = "INSERT INTO `account_cash`(`type`,`identifier`,`details`,`credit`,`debit`,`date`) 
             VALUES ('1','Cash Amount Added','Mannual Debit Amount Added','0','$amount','$today')";
          }

      }elseif($pay_type==2){
        if($radio_type=='credit'){
            $query_new = "INSERT INTO `account_cash`(`type`,`identifier`,`details`,`credit`,`debit`,`date`) 
            VALUES ('2','Online Amount Added','Mannual Credit Amount Added','$amount','0','$today')";
              }elseif($radio_type=='debit'){
                $query_new = "INSERT INTO `account_cash`(`type`,`identifier`,`details`,`credit`,`debit`,`date`) 
                 VALUES ('2','Online Amount Added','Mannual Debit Amount Added','0','$amount','$today')";
              }
      }
      $run_query_new = mysqli_query($connection, $query_new);

      if($run_query_new){
        echo "<!DOCTYPE html>
        <html>
          <body>
            <script>
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Amount Added',
              timer: 1500, // 1.5 seconds
              showConfirmButton: false
            }).then(() => {
            window.location.href = 'view_accounts.php';
            });
            </script>
          </body>
        </html>";

      }else{
        echo "<!DOCTYPE html>
        <html>
          <body>
            <script>
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Amount not added, Some error occurred',
              timer: 1500, // 1.5 seconds
              showConfirmButton: false
            }).then(() => {
           window.location.href = 'view_accounts.php';
            });
            </script>
          </body>
        </html>";
      }
}
?>
   