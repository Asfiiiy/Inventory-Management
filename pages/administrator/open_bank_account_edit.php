<?php include("include/header.php");
if (isset($_GET['account_id'])) {
  $account_id = $_GET['account_id'];
  $query2 = "SELECT * FROM `cash_in_bank` WHERE id = '$account_id'";
                $runData = mysqli_query($connection, $query2);
                $rowData = mysqli_fetch_array($runData);
                  $id = $rowData['id'];
                  $account_tittle = $rowData['account_tittle'];
                  $account_no = $rowData['account_no'];
                  $branch   = $rowData['branch'];
                  $address   = $rowData['address'];
                  $iban   = $rowData['iban'];
}
?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row">
    <div class="col-md-12">
      <h3>Update Account</h3>
    </div>
  </div>
  <div class="page-content container-fluid">
    <!--  Start Row  -->

    <div class="card my-only-div-shadow">
      <div class="card-body">
        <!-- <h3>Add Product</h3> -->
        <br>
     <form method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Account Tittle</label>
                <input type="text" class="form-control" value="<?php echo $account_tittle ?>" placeholder="Enter Tittle" name="account_tittle" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Account No</label>
                <input type="text" class="form-control" value="<?php echo $account_no ?>" placeholder="Enter Account No" name="account_no" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Branch</label>
                <input type="text" class="form-control" value="<?php echo $branch ?>" placeholder="Enter Branch" name="account_branch">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" value="<?php echo $address ?>" placeholder="Enter Address" name="account_address" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>IBAN</label>
                <input type="text" class="form-control" value="<?php echo $iban ?>" placeholder="Enter IBAN" name="account_iban">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" name="saveData" class="btn btn-primary shadow" value="Update">
          <a href="open_bank_account.php" class="btn btn-danger shadow" data-bs-dismiss="modal">Close</a>
        </div>
      </form>

      </div>
    </div>
    <!-- End Row  -->
  </div>
  <?php include("include/footer.php");
      if (isset($_POST['saveData'])) {
        $account_tittle =  $_POST['account_tittle'];
        $account_no = $_POST['account_no'];
        $account_branch   = $_POST['account_branch'];
        $account_address   = $_POST['account_address'];
        $account_iban   = $_POST['account_iban'];
          $insert = "UPDATE `cash_in_bank` SET `account_tittle`='$account_tittle',`account_no`=' $account_no',`branch`='$account_branch',`address`='$account_address',`iban`='$account_iban' WHERE id = '$account_id' ";
          $run = mysqli_query($connection, $insert);
          if ($run) {
            echo " <!DOCTYPE html>
            <html>
              <body>
                <script>
                Swal.fire(
                'Updated!',
                'Account has been Updated successfully!',
                'success'
                ).then((result) => {
                if (result.isConfirmed) {
                window.location.href = 'open_bank_account.php';
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
                'Customer not add, Some error occure',
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