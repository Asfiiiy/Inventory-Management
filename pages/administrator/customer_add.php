<?php include("include/header.php") ?>
<div class="page-content container-fluid">
  <!--  Start Row  -->
  <div class="row">
    <div class="col-md-12">
      <h3>Customer Details</h3>
    </div>
    <div class="col-md-12">
      <div class="card my-only-div-shadow">
        <div class="card-body table-responsive">
          <div class="text-left">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomer">
              Add Customer
            </button>
            <!-- Modal -->
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover shadow table-striped datatable text-center my-only-div-shadow">
              <thead class="my-table-style text-white">
                <tr>
                  <th>S.No</th>
                  <th>Customer Name</th>
                  <th>Contact</th>
                  <th>Opening Balance</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="table-font-size">
                <?php
                $count = 0;
                $query2 = "SELECT * FROM `customer` WHERE id!=1 ORDER BY id DESC";
                $runData = mysqli_query($connection, $query2);
                while ($rowData = mysqli_fetch_array($runData)) {
                  $count++;
                  $id = $rowData['id'];
                  $cus_name = $rowData['name'];
                  $cus_contact = $rowData['mobile'];
                  $cus_open_balance   = $rowData['opening_balance'];
                  $cus_address   = $rowData['address'];

                ?>
                  <tr class="my-table-row-hover">
                    <td class="pt-2"><?php echo $count; ?></td>
                    <td class="pt-2"><?php echo $cus_name; ?></td>
                    <td class="pt-2"><?php echo $cus_contact; ?></td>
                    <td class="pt-2"><?php echo $cus_open_balance; ?></td>
                    <td class="pt-2"><?php echo $cus_address; ?></td>
                    <td>

                      <a href="customer_update.php?cust_id=<?php echo $id ?>" class="Data_Ajax title btn btn-success btn-sm" data-id="" href="#edit" data-toggle='modal' title="Edit"><i class="bx bx-edit"></i></a>
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
        window.location.href = "customer_add.php?deleteId=" + id;
      }
    });
  }
</script>
<?php
if (isset($_GET['deleteId'])) {
  $id = $_GET['deleteId'];
  $query = "DELETE FROM customer WHERE id = '$id'";
  $run = mysqli_query($connection, $query);
  if ($run) {
    echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Deleted!',
                          'Customer has been successfully Deleted!',
                          'success'
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
<?php include("include/footer.php") ?>
<!-- add customer model -->
<div class="modal fade" id="addCustomer" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h6 class="modal-title text-white" id="addCustomerLabel">Add Customer</h6>
        <button type="button" class="text-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Customer Name</label>
                <input type="text" class="form-control" placeholder="Enter Customer Name" name="cust_name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Contact</label>
                <input type="text" class="form-control" placeholder=" Enter Contact" name="cust_contact" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Opening Balance</label>
                <input type="number" class="form-control" placeholder="Enter Opening Balance" name="cust_opening_balance" >
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Enter Address" name="cust_address">
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
        $cust_name =  $_POST['cust_name'];
        $cust_contact = $_POST['cust_contact'];
        $cust_opening_balance   = $_POST['cust_opening_balance'];
        $cust_address   = $_POST['cust_address'];
            $date = date('y-m-d');
        $check = "SELECT * FROM customer WHERE mobile = '$cust_contact' AND mobile !=''";
        $run_check = mysqli_query($connection, $check);
        $countRow = mysqli_num_rows($run_check);
        if ($countRow == 0) {
          $insert = "INSERT INTO `customer`(`name`, `address`, `mobile`, `opening_balance`) VALUES ('$cust_name','$cust_address','$cust_contact','$cust_opening_balance')";
          $run = mysqli_query($connection, $insert);
              $cus_Id = mysqli_insert_id($connection);

          if ($run) {
            $query3 = "INSERT INTO `customer_ledger`(`customer_id`, `payment_id`, `debit`, `credit`, `Ldate`, `details`) VALUES ('$cus_Id',0,0,'$cust_opening_balance','$date','Opening Balance')";
                  $run3 = mysqli_query($connection,$query3);
            echo " <!DOCTYPE html>
            <html>
              <body>
                <script>
                Swal.fire(
                'Added!',
                'Customer has been added successfully!',
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
              'Customer with this contact number already exist',
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
    </div>
  </div>
</div>