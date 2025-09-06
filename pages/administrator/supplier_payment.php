<?php include("include/header.php"); ?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row mb-2">
    <div class="col-md-12">
      <h3 class="ps-4">Supplier Payment</h3>
    </div>
  </div>
  <div class="page-content container-fluid">
    <!--  Start Row  -->
    <div class="row">
      <div class="col-md-12">
        <div class="card my-only-div-shadow">
          <div class="card-body">
            <br>
            <form method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Supplier/Contact</label>
                      <select id="supplierid" onchange="getDetails(),Getsupp()"  name="supplier" class="form-control select2" required>
                        <option value="">Choose</option>
                        <?php
                        $supplier = "SELECT s.id, s.supplier_name, s.supplier_contact FROM supplier AS s ORDER BY s.supplier_name ASC";
                        $run_supplier = mysqli_query($connection, $supplier);
                        while ($row1 = mysqli_fetch_array($run_supplier)) {
                        ?>
                          <option value="<?php echo $row1['id']; ?>"> <?php echo $row1['supplier_name'] . " / " . $row1['supplier_contact']; ?> </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <!-- Hidden Input Field For Supplier -->
                  <input type="hidden" id="supName" name="suplName">
                      <input type="hidden" id="sup_mobile" name="mobile">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Date</label>
                      <input type="date" name="payDate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Amount (Rs)</label>
                      <input type="text" name="total_payment" class="form-control" placeholder="Total Amount" id="total" readonly>
                    </div>
                  </div>
                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label>Old Paid (Rs)</label>
                      <input type="text" name="old_paid" class="form-control" placeholder="Total Amount" id="oldPaid" readonly>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Old Dues (Rs)</label>
                      <input type="text" name="old_dues" class="form-control" placeholder="Total Amount" id="oldDues" readonly>
                    </div>
                  </div> -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Payment Via</label>
                      <select class="form-control select2" name="pay_bank">
                        <option value="">Choose</option>
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
                      <label>New Payment (Rs)</label>
                      <input type="number" name="new_paid" id="newPaid" class="form-control" required onkeyup="getDues()" step="any" autocomplete="off" placeholder="Total Amount">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>New Remaining (Rs)</label>
                      <input type="text" name="new_dues" id="newDues" class="form-control" placeholder="New Remaining" readonly>
                    </div>
                  </div>
                 <!--  <div class="col-md-4">
                    <div class="form-group">
                      <label>Slip No</label>
                      <input type="text" name="slip_no" class="form-control" placeholder="Slip No">
                    </div>
                  </div> -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Upload Receipt</label>
                      <input type="file" accept="image/*" name="recp_file" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Details</label>
                      <textarea name="details" placeholder="Payment Details" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
                <!-- Account Jason -->
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
              </div>
            </form>
            <?php
            if (isset($_POST['saveData'])) {
              $suplName = $_POST['suplName'];
              $mobile = $_POST['mobile'];
              $pay_bank = $_POST['pay_bank'];
              $supplier = $_POST['supplier'];
              $payDate = $_POST['payDate'];
              $new_paid = $_POST['new_paid'];
              $new_dues = $_POST['new_dues'];
              $image      = $_FILES['recp_file']['name'];
              $temp_img   = $_FILES['recp_file']['tmp_name'];
              
              if ($image == '') {
                $recp_file = '';
              } else {
                $recp_file = date("Y-m-d H-i") . $image;
              }
              $details = $_POST['details'];
              $pathImg    = "../../images/admin/suppliers_recp/" . $recp_file;
              // Acount detail Variable
              $account_id   = $_POST['account_tittle'];
              // @$bank_status   = $_POST['bank_status'];


              if($pay_bank==1){
                $query_new = "INSERT INTO `account_cash`(`type`,`identifier`,`details`,`credit`,`debit`,`balance`,`date`) 
                VALUES ('1','supplier_payment','$details','0','$new_paid','$new_dues','$payDate')";
              }elseif($pay_bank==2){
                $query_new = "INSERT INTO `account_cash`(`type`,`identifier`,`details`,`credit`,`debit`,`balance`,`date`) 
                VALUES ('2','supplier_payment','$details','0','$new_paid','$new_dues','$payDate')";
              }
              $run_query_new = mysqli_query($connection, $query_new);


              $query1 = "INSERT INTO `supplier_payment`(`supplier_id`, `paid`, `payment_date`, `details`, `receipt`, `payment_method_id`) VALUES ('$supplier','$new_paid','$payDate','$details','$recp_file', '$pay_bank')";
              $run1 = mysqli_query($connection, $query1);
              $invoice_id = mysqli_insert_id($connection);

              if ($run1) {
                $query3 = "INSERT INTO `supplier_ledger`(`supplier_id`, `payment_id`, `debit`, `credit`, `Ldate`, `details`) VALUES ('$supplier','$invoice_id','$new_paid',0,'$payDate','$details')";
                $run3 = mysqli_query($connection, $query3);

                    $insert2 = "INSERT INTO `cash_history`(`amount`, `pay_status`, `details`, `pay_date`, `pay_person`, `contact`,  `slip_no`, `receipt`, `pay_by`, `supplier_payment_id`, `pay_type_id`) VALUES ('$new_paid','OUT','$details','$payDate','$suplName','$mobile','0','$recp_file','Purchase Payment','$supplier', '$pay_bank')";
                $run2 = mysqli_query($connection, $insert2);

                move_uploaded_file($temp_img, $pathImg);
              //   if ($bank_status == 1) {
              // $query5 = "INSERT INTO `cash_in_bank_history`( `cash_in_bank_id`, `bank_date`, `detail`, `credit`, `debit`) VALUES ('$account_id','$payDate','$details',0,'$new_paid')";
              // $run5 = mysqli_query($connection, $query5);
              //     }
                echo "<!DOCTYPE html>
                  <html>
                    <body>
                      <script>
                      Swal.fire(
                      'Added !',
                      'Supplier\'s Payment has been added successfully',
                      'success'
                      ).then((result) => {
                      if (result.isConfirmed) {
                      window.location.href= 'supplier_payment.php';
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
                      'Supplier\'s Payment not add, Some error occure',
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
  </div>
</div>

<?php include("include/footer.php") ?>

<script type="text/javascript">
  function getDetails() {

    var supplier_id = $('#supplierid').val();
    $.ajax({
      url: 'supplier_payment_ajax.php',
      type: 'post',
      data: {
        'supplier_id': supplier_id
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
    $("#newDues").val(total - newPaid);
  }
</script>
<script type="text/javascript">
      function Getsupp() {
        var suppl_id = $('#supplierid').val();

       
        $.ajax({
          url: 'supplier_detail_ajax.php',
          type: 'post',
          data: {
            'supplier_id': suppl_id
          },
          dataType: "json",
          success: function(result) {
            $("#supName").val(result.suplier_name);
            $("#sup_mobile").val(result.suplier_mobile);
          }
        });
      }

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