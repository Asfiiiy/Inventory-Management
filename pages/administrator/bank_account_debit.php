<?php include("include/header.php") ?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row">
    <div class="col-md-12">
      <h3 class="ps-4">Account Debit</h3>
    </div>
  </div>
  <div class="page-content container-fluid">
    <!--  Start Row  -->

    <div class="card">
      <div class="card-body my-only-div-shadow">
        <!-- <h3>Add Product</h3> -->
        <br>
        <form method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label>Select Account</label>
                  <select class="form-control select2" onchange="getDetails()" id="accountId" name="account_tittle">
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
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label>Current Balance</label>
                  <input type="text" class="form-control" id="currentId" placeholder="Current Balance" name="alert_quality" readonly>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label>Debit Amount</label>
                  <input type="text" class="form-control" placeholder="Debit Amount" name="debit">
                </div>
              </div>
              <div class="col-md-4 mt-2">
              <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control"  value="<?php echo date("Y-m-d"); ?>" name="date" required>
              </div>
            </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" placeholder="Description" name="details"></textarea>
                </div>
              </div>
              
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" name="saveData" class="btn btn-primary shadow" value="Save">
            <button type="button" class="btn btn-danger shadow" data-bs-dismiss="modal">Close</button>
          </div>
        </form>


      </div>
    </div>
    <!-- End Row  -->
  </div>
  <?php include("include/footer.php") ?>
  <?php
  if (isset($_POST['saveData'])) {
    $account_Id =  $_POST['account_tittle'];
    $debit = $_POST['debit'];
    $date = $_POST['date'];
    $details = $_POST['details'];
     $insert = "INSERT INTO `cash_in_bank_history`(`cash_in_bank_id`, `bank_date`, `detail`, `credit`, `debit`) VALUES ('$account_Id','$date','$details',0,'$debit')";
      $run = mysqli_query($connection, $insert);

    if ($run) {
      
      echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Added!',
                          'Debit has been successfully added!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'bank_account_debit.php';
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
                                'Debit not add, Some error occure',
                                'error'
                                ).then((result) => {
                                if (result.isConfirmed) {
                                window.location.href = 'bank_account_debit.php';
                                }
                                });
                                </script>
                              </body>
                              </html>";
    }
  }
  ?>
  <script type="text/javascript">
  	function getDetails() {
        var accountId = $('#accountId').val();
       
        $.ajax({
          url: 'debit_ajax.php',
          type: 'post',
          data: {
            'accountId': accountId
          },
          dataType: "json",
          success: function(result) {
            $("#currentId").val(result.current_balance);
          }
        });
      }
  </script>