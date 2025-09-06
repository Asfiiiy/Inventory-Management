<?php include("include/header.php");
if (isset($_GET['cust_id'])) {
  $cust_id = $_GET['cust_id'];
  $query2 = "SELECT * FROM `customer` WHERE id = '$cust_id'";
  $runData = mysqli_query($connection, $query2);
  $rowData = mysqli_fetch_array($runData);
  $id = $rowData['id'];
  $cus_name = $rowData['name'];
  $cus_contact = $rowData['mobile'];
  $cus_open_balance   = $rowData['opening_balance'];
  $cus_address   = $rowData['address'];
}
?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row">
    <div class="col-md-12">
      <h3 class="ps-4">Update Customer</h3>
    </div>
  </div>
  <div class="page-content container-fluid">
    <!--  Start Row  -->

    <div class="card my-only-div-shadow">
      <div class="card-body">
        <!-- <h3>Add Customer</h3> -->
        <br>
        <form method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Customer Name</label>
                  <input type="text" class="form-control" value="<?php echo $cus_name ?>" placeholder="Enter Customer Name" name="cust_name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Contact</label>
                  <input type="text" class="form-control" value="<?php echo $cus_contact ?>" placeholder=" Enter Contact" name="cust_contact" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Opening Balance</label>
                  <input type="number" class="form-control" value="<?php echo $cus_open_balance ?>" placeholder="Enter Opening Balance" name="cust_opening_balance" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" value="<?php echo $cus_address ?>" placeholder="Enter Address" name="cust_address">
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
  <?php include("include/footer.php");
  if (isset($_POST['saveData'])) {
    $cust_name =  $_POST['cust_name'];
    $cust_contact = $_POST['cust_contact'];
    $cust_opening_balance   = $_POST['cust_opening_balance'];
    $cust_address   = $_POST['cust_address'];

    $insert = "UPDATE `customer` SET `name`='$cust_name',`mobile`='$cust_contact',`opening_balance`='$cust_opening_balance',`address`='$cust_address' WHERE id = '$cust_id'";

    $run = mysqli_query($connection, $insert);
    if ($run) {
      echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Updated!',
                          'Customer has been successfully Updated!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'customer_add.php';
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
                                window.location.href = 'customer_add.php';
                                }
                                });
                                </script>
                              </body>
                              </html>";
    }
  }
  ?>