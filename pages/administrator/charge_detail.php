<?php include("include/header.php") ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="mt-3 text-dark">Charge Details</h4>
      </div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid" class="text-center">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-dark my-only-div-shadow" class="text-center">
          <div class="card-header">
          </div>
          <br>

          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <!-- table start -->
            <table class="table table-bordered text-center datatable table-striped my-only-div-shadow">
              <thead class="my-table-style text-white">
                <tr>
                  <th>S.No</th>
                  <th>Customer Name </th>
                  <th>Purchase Date</th>
                  <th>Product Name</th>
                  <th>Price </th>
                  <th>Description </th>
                  <th width="9%">Action</th>
                </tr>
              </thead>
              <tbody class="table-font-size">
                <?php
                $count = 0;
                $query = "SELECT * FROM charge";
                $result = mysqli_query($connection, $query);
                while ($rowData = mysqli_fetch_array($result)) {
                  $count++;
                  $id   = $rowData['id'];
                  $customer_name   = $rowData['customer_name'];
                  $product_name   = $rowData['product_name'];
                  $purchase_date   = $rowData['purchase_date'];
                  $price   = $rowData['price'];
                  $description   = $rowData['description'];


                  // $date   = date("d-m-Y", strtotime($rowData['purchase_date']));

                ?>
                  <tr class="my-table-row-hover">
                    <td class="pt-2"><?php echo $count; ?></td>
                    <!-- <td class="pt-2"><?php echo $id; ?></td> -->

                    
                    <td class="pt-2"><?php echo $customer_name; ?></td>
                    <td class="pt-2"><?php echo $purchase_date; ?></td>
                    <td class="pt-2"><?php echo $product_name; ?></td>

                    <td class="pt-2"><?php echo $price; ?></td>
                    <td class="pt-2"><?php echo $description; ?></td>

                    
                    
                    <td>
                    <a href="charge_update.php?id=<?php echo $id ?>" class="mt-1 Data_Ajax title btn btn-success btn-sm" title="Edit"><i class="bx bx-edit"></i></a>

                      <!-- <a href="purchase_items_detail.php?id=<?php echo $id; ?>" class="mt-1 btn btn-primary shadow btn-sm title" title="Purchase View"><i class="bx bx-show"></i></a> -->
                      <a class="btn btn-sm mt-1 btn-danger shadow text-white title" title="Delete" onclick="deleteData(<?php echo $id; ?>)"><span><i class="bx bx-trash-alt"></i></span></a>
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
</section>
<?php
?>
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
                            window.location.href = "charge_detail.php?deleteId=" + id;
                          }
                        });
                      }
                    </script>
                    <?php
                    if (isset($_GET['deleteId'])) {
                      $id = $_GET['deleteId'];
                      $query = "DELETE FROM charge WHERE id = '$id'";
                      $run = mysqli_query($connection, $query);
                      if ($run) {
                        echo "<!DOCTYPE html>
                        <html>
                          <body>
                            <script>
                            Swal.fire(
                            'Deleted!',
                            'charge has been successfully Deleted!',
                            'success'
                            ).then((result) => {
                            if (result.isConfirmed) {
                              window.location.href = 'charge_detail.php';
                            }
                            });
                            </script>
                          </body>
                        </html>";
                      }
                    }
                    include("include/footer.php")

                    ?>