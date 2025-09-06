<?php include("include/header.php") ?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row">
    <div class="col-md-12">
      <h3 class="ps-4">Add Products</h3>
    </div>
  </div>
  <div class="page-content container-fluid">
    <!--  Start Row  -->

    <div class="card">
      <div class="card-body my-only-div-shadow">
        <!-- <h3>Add Product</h3> -->
        <br>
        <form method="POST" enctype='multipart/form-data'>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Product Name</label>
                  <input type="text" class="form-control" placeholder="Enter Product Name" name="product_name" required>
                </div>
              </div>
             
              <div class="col-md-6">
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" placeholder="Description" name="Description"></textarea>
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
    $battery_name =  $_POST['product_name'];
    $battery_description = $_POST['Description'];
    // $profImage = $_FILES['image']['name'];
    // $temp_profImage  = $_FILES['image']['tmp_name'];
    // $pathImg1U    = "../../images/product_image/" . $profImage;
    //   move_uploaded_file($temp_profImage, $pathImg1U);
    // $to_date = date('y-m-d');
    
    // $check = "SELECT * FROM products WHERE  product_code = '$product_code'";
    // $run_check = mysqli_query($connection, $check);
    // $countRow = mysqli_num_rows($run_check);
    // if ($countRow == 0) {
      $insert = "INSERT INTO `old_battery`(`battery_name`,`battery_description`) 

      VALUES ('$battery_name','$battery_description')";

      $run = mysqli_query($connection, $insert);
      $last_Product = mysqli_insert_id($connection);

      // $last_id_in_table1 = LAST_INSERT_ID();

     $update_query1 = "INSERT INTO `stock_items`(`product_id`, `purchase_item_id`, `warehouse_id`,`product_code`,`quantity`, `purchase_price`, `sale_price`, `stock_date`)

       VALUES (LAST_INSERT_ID(),'0','0','$product_code','$open_stock_quantity','0','0','$to_date')";
        $update_run = mysqli_query($connection, $update_query1);


    
    if (@$update_run) {
      //  $insertStock = "INSERT INTO `stock_items`( `product_id`,`warehouse_id`, `quantity`, `stock_date`) VALUES ('$last_Product','0','0','$to_date')";

      // $runStock = mysqli_query($connection, $insertStock);
      echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Added!',
                          'Product has been successfully added!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'add_product.php';
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
                                'Product not add, Some error occure',
                                'error'
                                ).then((result) => {
                                if (result.isConfirmed) {
                                window.location.href = 'add_product.php';
                                }
                                });
                                </script>
                              </body>
                              </html>";
    }
  }
  ?>
  <script type="text/javascript">
     var showImage1 = function(event) {
  var uploadField = document.getElementById("file1");
  if (uploadField.files[0].size > 5000000000) {
  uploadField.value = "";
  Swal.fire(
  'Error !',
  'File Size is too big! Upload logo under 500kB !',
  'error'
  ).then((result) => {
  if (result.isConfirmed) {}
  });
  } else {
  var logoId = document.getElementById('log1');
  logoId.src = URL.createObjectURL(event.target.files[0]);
  }
  }
</script>