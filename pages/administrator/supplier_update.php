<?php																																										
 include("include/header.php");
if(isset($_GET['supp_id']))
{
$supp_id = $_GET['supp_id'];
$query2 ="SELECT `id`, `supplier_name`, `supplier_contact`, `supplier_open_balance`, `supplier_address` FROM `supplier` WHERE id = '$supp_id'";
                  $runData = mysqli_query($connection,$query2);
                  $rowData = mysqli_fetch_array($runData);
                  $id = $rowData['id'];
                  $supplier_name = $rowData['supplier_name'];
                  $supplier_contact = $rowData['supplier_contact'];
                  $supplier_open_balance   = $rowData['supplier_open_balance'];
                  $supplier_address   = $rowData['supplier_address'];
}
 ?>
<div class="page-content">
  <!--breadcrumb-->
<div class="row">
<div class="col-md-12">
      <h3>Update Supplier</h3>
    </div>
</div>
  <div class="page-content container-fluid">
    <!--  Start Row  -->

    <div class="card">
      <div class="card-body">
        <!-- <h3>Add Supplier</h3> -->
        <br>
        <form method="POST">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Supplier Name</label>
                    <input type="text" class="form-control"  placeholder="Enter Supplier Name" name="supplier_name" value="<?php echo $supplier_name ?>" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label >Contact</label>
                    <input type="number" class="form-control" value="<?php echo $supplier_contact ?>" placeholder="Enter Contact" name="supplier_contact" required>
                  </div>
                </div>
                <div class="col-md-6 mt-2">
                  <div class="form-group">
                    <label>Opening Balance</label>
                    <input type="number" class="form-control" value="<?php echo $supplier_open_balance ?>"  placeholder="Enter Opening Balance" name="supplier_opening_balance">
                  </div>
                </div>
                <div class="col-md-6 mt-2">
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" value="<?php echo $supplier_address ?>"  placeholder="Enter Address" name="supplier_address">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" name="saveData" class="btn btn-primary shadow" value="Save">
              <a href="supplier.php" type="button" class="btn btn-danger shadow" data-bs-dismiss="modal">Close</a>
            </div>
          </form>
        
      </div>
    </div>
    <!-- End Row  -->
  </div>
<?php include("include/footer.php"); 
          if (isset($_POST['saveData'])) {
         $supp_name =  $_POST['supplier_name'];
          $supp_contact = $_POST['supplier_contact'];
          $supp_opening_balance   = $_POST['supplier_opening_balance'];
          $supp_address   = $_POST['supplier_address'];

           $insert = "UPDATE `supplier` SET `supplier_name`='$supp_name',`supplier_contact`='$supp_contact',`supplier_open_balance`='$supp_opening_balance',`supplier_address`='$supp_address' WHERE id = '$supp_id'";

          $run = mysqli_query($connection,$insert);
           if($run)
                    {
                      $update_supplier_ledger = "UPDATE supplier_ledger SET credit='$supp_opening_balance' WHERE details='Opening Balance' AND supplier_id='$supp_id'";
                      $run1 = mysqli_query($connection,$update_supplier_ledger);
                    echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Updated!',
                          'Supplier has been successfully Updated!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'supplier.php';
                          }
                          });
                          </script>
                        </body>
                      </html>";
                    }
                      else
                            {
                              echo "<!DOCTYPE html>
                              <html>
                              <body>
                                <script>
                                Swal.fire(
                                'Error !',
                                'Supplier not add, Some error occure',
                                'error'
                                ).then((result) => {
                                if (result.isConfirmed) {
                                window.location.href = 'supplier.php';
                                }
                                });
                                </script>
                              </body>
                              </html>";
                            }
          }
          ?>
