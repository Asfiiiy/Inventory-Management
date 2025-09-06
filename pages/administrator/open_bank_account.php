<?php include("include/header.php") ?>
<div class="page-content container-fluid">
  <!--  Start Row  -->
  <div class="row">
    <div class="col-md-12">
      <h3>Account Details</h3>
    </div>
    <div class="col-md-12">
      <div class="card my-only-div-shadow">
        <div class="card-body table-responsive">
          <div class="text-left">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomer">
              Add Account
            </button>
            <!-- Modal -->
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover shadow table-striped datatable text-center my-only-div-shadow">
              <thead class="my-table-style text-white">
                <tr>
                  <th>S.No</th>
                  <th>Account Tittle</th>
                  <th>Account No</th>
                  <th>Branch</th>
                  <th>Address</th>
                  <th>Iban</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="table-font-size">
                <?php
                $count = 0;
                $query2 = "SELECT * FROM `cash_in_bank`";
                $runData = mysqli_query($connection, $query2);
                while ($rowData = mysqli_fetch_array($runData)) {
                  $count++;
                  $id = $rowData['id'];
                  $account_tittle = $rowData['account_tittle'];
                  $account_no = $rowData['account_no'];
                  $branch   = $rowData['branch'];
                  $address   = $rowData['address'];
                  $iban   = $rowData['iban'];

                ?>
                  <tr class="my-table-row-hover">
                    <td class="pt-2"><?php echo $count; ?></td>
                    <td class="pt-2"><?php echo $account_tittle; ?></td>
                    <td class="pt-2"><?php echo $account_no; ?></td>
                    <td class="pt-2"><?php echo $branch; ?></td>
                    <td class="pt-2"><?php echo $address; ?></td>
                    <td class="pt-2"><?php echo $iban; ?></td>
                    <td>

                      <a href="open_bank_account_edit.php?account_id=<?php echo $id ?>" class="Data_Ajax title btn btn-success btn-sm" data-id="" href="#edit" data-toggle='modal' title="Edit"><i class="bx bx-edit"></i></a>
                      <button onclick="deleteData(<?php echo $id ?>)" class=" btn btn-sm shadow btn-danger " title="Delete" name="delete"><i class="bx bx-trash"></i>
                      </button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Row  -->
</div>
<!-- delete and sweet alert -->
<script type="text/javascript">
  function deleteData(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "To delete the selected record !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "open_bank_account.php?deleteId=" + id;
      }
    });
  }
</script>
<?php
if (isset($_GET['deleteId'])) {
  $id = $_GET['deleteId'];
  $query = "DELETE FROM cash_in_bank WHERE id = '$id'";
  $run = mysqli_query($connection, $query);
  if ($run) {
    echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Deleted!',
                          'Account has been successfully Deleted!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'open_bank_account.php';
                          }
                          });
                          </script>
                        </body>
                      </html>";
  }
}
?>
<?php include("include/footer.php") ?>
<!-- add customer model -->
<div class="modal fade" id="addCustomer" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h6 class="modal-title text-white" id="addCustomerLabel">Add Account</h6>
        <button type="button" class="text-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Account Tittle</label>
                <input type="text" class="form-control" placeholder="Enter Tittle" name="account_tittle" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Account No</label>
                <input type="text" class="form-control" placeholder="Enter Account No" name="account_no" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Branch</label>
                <input type="text" class="form-control" placeholder="Enter Branch" name="account_branch">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Enter Address" name="account_address" >
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>IBAN</label>
                <input type="text" class="form-control" placeholder="Enter IBAN" name="account_iban">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label>Opening Balance</label>
                <input type="number" class="form-control" placeholder="Enter Opening Balance" name="open_balance" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" name="saveData" class="btn btn-primary shadow" value="Save">
          <button type="button" class="btn btn-danger shadow" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
      <?php
      if (isset($_POST['saveData'])) {
        $open_balance =  $_POST['open_balance'];
        $account_tittle =  $_POST['account_tittle'];
        $account_no = $_POST['account_no'];
        $account_branch   = $_POST['account_branch'];
        $account_address   = $_POST['account_address'];
        $account_iban   = $_POST['account_iban'];
            $date = date('y-m-d');
        $check = "SELECT * FROM cash_in_bank WHERE account_no = '$account_no'";
        $run_check = mysqli_query($connection, $check);
        $countRow = mysqli_num_rows($run_check);
        if ($countRow == 0) {
          $insert = "INSERT INTO `cash_in_bank`(`account_tittle`, `account_no`, `branch`, `address`, `iban`,`opening_balance`) VALUES ('$account_tittle','$account_no','$account_branch','$account_address','$account_iban','$open_balance')";
          $run = mysqli_query($connection, $insert);
              $account_Id = mysqli_insert_id($connection);

          if ($run) {
           $query5 = "INSERT INTO `cash_in_bank_history`( `cash_in_bank_id`, `bank_date`, `detail`, `credit`, `debit`) VALUES ('$account_Id','$date','Opening Balance','$open_balance',0)";
              $run5 = mysqli_query($connection, $query5);
            echo " <!DOCTYPE html>
            <html>
              <body>
                <script>
                Swal.fire(
                'Added!',
                'Account has been added successfully!',
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
        } else {
          echo "<!DOCTYPE html>
          <html>
            <body>
              <script>
              Swal.fire(
              'Error !',
              'Account with this number already exist',
              'error'
              ).then((result) => {
              if (result.isConfirmed) {
                window.location.href = 'open_bank_account.php';
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