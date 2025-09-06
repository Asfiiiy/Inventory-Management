<?php include("include/header.php") ?>
<div class="page-content container-fluid">
  <!--  Start Row  -->
  <div class="row">
    <div class="col-md-12">
      <h3>Customer Payment</h3>
    </div>
    <div class="col-md-12">
      <div class="card my-only-div-shadow">
        <div class="card-body">
          <form method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Customer/Contact</label>
                  <select class="form-control select2" id="cust_id" onchange="getDetails(),getCust()" name="customer_id" required>
                    <option value="">Choose</option>
                    <?php
                    $fetchData1 = "SELECT * FROM customer ORDER BY name ASC";
                    $runData1 = mysqli_query($connection, $fetchData1);
                    while ($rowData1 = mysqli_fetch_array($runData1)) {

                      $id         = $rowData1['id'];
                      $name       = $rowData1['name'];
                      $mobile   = $rowData1['mobile'];
                      echo "<option value='$id'>$name / $mobile</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
               <input type="hidden" id="custName" name="custName">
            <input type="hidden" id="cust_mobile" name="mobile">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Date</label>
                  <input type="date" name="pay_date" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Total Amount</label>
                  <input type="text" placeholder="Total Amount" class="form-control" id="total" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Payment Via</label>
                  <select class="form-control" name="pay_bank">
                    <?php
                    $payType = "SELECT * FROM payment_method ORDER BY method ASC";
                    $run_payType = mysqli_query($connection, $payType);
                    while ($row1 = mysqli_fetch_array($run_payType)) {
                    ?>
                      <option value="<?php echo $row1['id']; ?>"> <?php echo $row1['method']; ?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>New Payment</label>
                  <input type="text" name="paid" id="newPaid" placeholder="New Payment" autocomplete="off" onkeyup="getDues()" class="form-control" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>New Remaining</label>
                  <input type="number" name="new_dues" id="new_dues" placeholder="New Remaining" class="form-control" readonly required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Slip No</label>
                  <input type="text" name="slip_no" class="form-control" placeholder="Slip No">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Upload Receipt</label>
                  <input type="file" accept="image/*" name="recp_file" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Details</label>
                  <textarea class="form-control" placeholder="Details" name="details"></textarea>
                </div>
              </div>
            </div>
             <div class="row">
            <div class="col-md-12">
            <!--   <div class="col-md-4">
                          <input type="checkbox" name="bank_status" onchange="checkTicket(1)" value="1" id="checktkt1"> <b class="text-primary">Transection Through Account</b>
                        </div> -->
                       <div id="ticket_ptr1" style="display: none">
                        <hr>
                        <div class="row" onkeyup="checkInputs(1)">
                          <div class="col-md-4">
                          <div class="form-group">
                            <label>Select Account</label>
                            <select class="form-control select2" onchange="getbank()" id="accountId" name="account_tittle">
                              <option value="">Choose</option>
                              <?php
                                $fetchData2= "SELECT id, account_tittle FROM cash_in_bank";
                                $runData2 = mysqli_query($connection,$fetchData2);
                                while($rowData2 = mysqli_fetch_array($runData2)) {
                                  
                                  $id         = $rowData2['id'];
                                  $account_tittle       = $rowData2['account_tittle'];
                                  echo "<option value='$id'>$account_tittle</option>";
                                }
                              ?>
                              
                            </select>
                          </div>
                        </div>
                        
                          <div class="col-md-4">
                            <label>Account No</label>
                            <input type="text" id="account_no" class="form-control"  placeholder="Account No" readonly>
                          </div>
                          <div class="col-md-4">
                            <label>Iban</label>
                            <input type="text" id="iban" class="form-control" placeholder="Iban" readonly>
                          </div>
                        </div>
                      </div>
            </div>
          </div>

            <br>

            <div class="row">
              <div class="col-md-12">
                <center>
                  <input type="submit" class="btn btn-success shadow" value="Add" name="saveData">
                </center>
              </div>
            </div>

          </form>
          <?php
          if (isset($_POST['saveData'])) {
            // account Insertion Credit variable
            $account_id   = $_POST['account_tittle'];
            // @$bank_status   = $_POST['bank_status'];
            $customer_id = $_POST['customer_id'];
             $custName = $_POST['custName'];
              $mobile = $_POST['mobile'];
            $pay_date   = $_POST['pay_date'];
            $pay_bank = $_POST['pay_bank'];
            $paid       = $_POST['paid'];
            $new_dues       = $_POST['new_dues'];
            $slip_no = $_POST['slip_no'];
            $image      = $_FILES['recp_file']['name'];
            $temp_img   = $_FILES['recp_file']['tmp_name'];
            if ($image == '') {
              $recp_file = '';
            } else {
              $recp_file = date("Y-m-d H-i") . $image;
            }
            $pathImg    = "../../images/admin/customers_recp/" . $recp_file;
            $details       = $_POST['details'];

            $insert = "INSERT INTO `customer_payment`(`customer_id`, `payment_method_id`, `paid`, `payment_date`, `details`, `receipt`) VALUES ('$customer_id','$pay_bank','$paid', '$pay_date', '$details', '$recp_file')";
            $run = mysqli_query($connection, $insert);
            $pay_id = mysqli_insert_id($connection);
            if ($run) {

              move_uploaded_file($temp_img, $pathImg);

              
          if($pay_bank==1){
            $query_new = "INSERT INTO `account_cash`(`type`,`identifier`,`details`,`credit`,`debit`,`balance`,`date`) 
            VALUES ('1','customer_payment','$details','$paid','0','$new_dues','$pay_date')";
          }elseif($pay_bank==2){
            $query_new = "INSERT INTO `account_cash`(`type`,`identifier`,`details`,`credit`,`debit`,`balance`,`date`) 
            VALUES ('2','customer_payment','$details','$paid','0','$new_dues','$pay_date')";
          }
          $run_query_new = mysqli_query($connection, $query_new);


              $query3 = "INSERT INTO `customer_ledger`(`customer_id`, `payment_id`, `debit`, `credit`, `Ldate`, `details`) VALUES ('$customer_id','$pay_id','$paid',0,'$pay_date','$details')";
              $run3 = mysqli_query($connection, $query3);

              $insert2 = "INSERT INTO `cash_history`(`amount`, `pay_status`, `details`, `pay_date`, `pay_person`, `contact`,  `slip_no`, `receipt`, `pay_by`, `supplier_payment_id`, `pay_type_id`) VALUES ('$paid','IN','$details','$pay_date','$custName','$mobile','','$recp_file','Customer Payment','$customer_id', '$pay_bank')";
        $run2 = mysqli_query($connection, $insert2);
      //   if ($bank_status == 1) {
      //   $query5 = "INSERT INTO `cash_in_bank_history`( `cash_in_bank_id`, `bank_date`, `detail`, `credit`, `debit`) VALUES ('$account_id','$pay_date','$details','$paid',0)";
      // $run5 = mysqli_query($connection, $query5);
      //   // code...
      // }

              echo "<!DOCTYPE html>
                <html>
                  <body>
                    <script>
                    Swal.fire(
                    'Added !',
                    'Payment has been added successfully',
                    'success'
                    ).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href= 'customer_payment.php';
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
                    'Error !',
                    'Payment not add, Some error occure',
                    'error'
                    ).then((result) => {
                    if (result.isConfirmed) {
                    
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
 ///////////////////Get Data From Customer Ledgear//////////////////////
  function getDetails() {
    var cust_id = $('#cust_id').val();
    $.ajax({
      url: 'customer_payment_ajax.php',
      type: 'post',
      data: {
        'cust_id': cust_id
      },
      dataType: "json",
      success: function(result) {
        $("#total").val(result.total);
      }
    });
  }

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
  //////////////// Get Customer Data through Ajax///////////////////////////////
      function getCust() {
        var custID = $('#cust_id').val();
       
        $.ajax({
          url: 'customer_detail_ajax.php',
          type: 'post',
          data: {
            'customer_id': custID
          },
          dataType: "json",
          success: function(result) {
            $("#custName").val(result.customer_name);
            $("#cust_mobile").val(result.customer_mobile);
          }
        });
      }
       // disable bank inputs
      function checkTicket(id)
          {
            if($("#checktkt"+id).is(':checked'))
            {
              $("#ticket_ptr"+id).css("display","block");
            }
            else
            {
              $("#ticket_ptr"+id).css("display","none");
            }
            
          }
      function getbank() {
        var accountId = $('#accountId').val();

       
        $.ajax({
          url: 'account_detail_jason.php',
          type: 'post',
          data: {
            'accountId': accountId
          },
          dataType: "json",
          success: function(result) {
            $("#account_no").val(result.account_no);
            $("#iban").val(result.acount_iban);
          }
        });
      }
    </script>