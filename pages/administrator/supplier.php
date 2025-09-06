<?php include("include/header.php") ?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row mb-2">
    <div class="col-md-12">
      <h3 class="ps-4">Supplier Details</h3>
    </div>
    <div>
      <div class="page-content container-fluid">
        <!--  Start Row  -->
        <div class="row">
          <div class="col-md-12">
            <div class="card my-only-div-shadow">
              <div class="card-body">
                <div class="text-left">
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary my-shadow-btn" data-bs-toggle="modal" data-bs-target="#addProdcut">
                    Add Supplier
                  </button>
                  <!-- Modal -->
                </div>
                <br>
                <div class="table-responsive">
                  <table class="table table-bordered table-hover shadow datatable text-center table-striped my-only-div-shadow">
                    <thead class="my-table-style text-white">
                      <th>S.No</th>
                      <th>Supplier Name</th>
                      <th>Contact</th>
                      <th>Opening Balance</th>
                      <th>Address</th>
                      <th>Action</th>
                    </thead>
                    <tbody class="table-font-size">


                      <?php
                      $count = 0;
                      $query2 = "SELECT `id`, `supplier_name`, `supplier_contact`, `supplier_open_balance`, `supplier_address` FROM `supplier`";
                      $runData = mysqli_query($connection, $query2);
                      while ($rowData = mysqli_fetch_array($runData)) {
                        $count++;
                        $id = $rowData['id'];
                        $supplier_name = $rowData['supplier_name'];
                        $supplier_contact = $rowData['supplier_contact'];
                      $supplier_open_balance   = $rowData['supplier_open_balance'];
                        $supplier_address   = $rowData['supplier_address'];

                      ?>
                        <tr class="my-table-row-hover">
                          <td class="pt-2"><?php echo $count; ?></td>
                          <td class="pt-2"><?php echo $supplier_name; ?></td>
                          <td class="pt-2"><?php echo $supplier_contact; ?></td>
                          <td class="pt-2"><?php echo $supplier_open_balance; ?></td>
                          <td class="pt-2"><?php echo $supplier_address; ?></td>
                          <td>

                            <a href="supplier_update.php?supp_id=<?php echo $id ?>" class="Data_Ajax title btn btn-success btn-sm" data-id="" href="#edit" data-toggle='modal' title="Edit"><i class="bx bx-edit"></i></a>
                            <button onclick="deleteData(<?php echo $id ?>)" class=" btn btn-sm shadow btn-danger " title="Delete" name="delete"><i class="bx bx-trash"></i>
                            </button>
                          </td>
                        </tr>
                      <?php }
                      ?>
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
                              window.location.href = "supplier.php?deleteId=" + id;
                            }
                          });
                        }
                      </script>
                      <?php
                      if (isset($_GET['deleteId'])) {
                        $id = $_GET['deleteId'];
                        $query = "DELETE FROM supplier WHERE id = '$id'";
                        $run = mysqli_query($connection, $query);
                        if ($run) {
                          echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Deleted!',
                          'Supplier has been successfully Deleted!',
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
                      }
                      ?>
                      <!-- end of delete and sweet alert -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Row  -->
      </div>
    </div>
    <?php include("include/footer.php") ?>
    <!-- add product model -->
    <div class="modal fade" id="addProdcut" tabindex="-1" aria-labelledby="addProdcutLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-secondary">
            <h6 class="modal-title text-white" id="addProdcutLabel">Add Supplier</h6>
            <button type="button" class="text-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Supplier Name</label>
                    <input type="text" class="form-control" placeholder="Enter Supplier Name" name="supplier_name" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Contact</label>
                    <input type="number" class="form-control" placeholder=" Enter Contact" name="supplier_contact" required>
                  </div>
                </div>
                <div class="col-md-6 mt-2">
                  <div class="form-group">
                    <label>Opening Balance</label>
                    <input type="number" class="form-control" placeholder="Enter Opening Balance" name="supplier_opening_balance" >
                  </div>
                </div>
                <div class="col-md-6 mt-2">
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" placeholder="Enter Address" name="supplier_address">
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
            $supp_name =  $_POST['supplier_name'];
            $supp_contact = $_POST['supplier_contact'];
            $supp_opening_balance   = $_POST['supplier_opening_balance'];
            $supp_address   = $_POST['supplier_address'];
            $date = date('y-m-d');

            $check = "SELECT * FROM supplier WHERE supplier_name = '$supp_name'";
            $run_check = mysqli_query($connection, $check);
            $countRow = mysqli_num_rows($run_check);
            if ($countRow == 0) {
              $insert = "INSERT INTO supplier(supplier_name, supplier_contact,supplier_open_balance,supplier_address) VALUES ('$supp_name','$supp_contact','$supp_opening_balance','$supp_address')";
              $run = mysqli_query($connection, $insert);
              $supplier_Id = mysqli_insert_id($connection);
              
            }
            if ($run) {
              $query3 = "INSERT INTO `supplier_ledger`(`supplier_id`, `payment_id`, `debit`, `credit`, `Ldate`, `details`) VALUES ('$supplier_Id',0,0,'$supp_opening_balance','$date','Opening Balance')";
                  $run3 = mysqli_query($connection,$query3);
                  
              echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Added!',
                          'Supplier has been successfully added!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'supplier.php';
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
        </div>
      </div>
    </div>
    <!-- END of add product model -->