<?php include("include/header.php") ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="row">
        <div class="col-md-12">
            <h3 class="ps-4">Add Product</h3>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Item Name"
                                        name="product_name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Item Code</label>
                                    <input type="text" class="form-control" placeholder="Enter Item Code"
                                        name="item_code">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input type="text" class="form-control" placeholder="Enter Unit" name="product_unit"
                                        required>
                                </div>
                            </div>
                            <!--  <div class="col-md-4">
                <div class="form-group">
                  <label>Open Stock Qty.</label>
                  <input type="number" class="form-control" placeholder="Enter Quantity" name="open_stock_quantity" required>
                </div>
              </div> -->

                            <!--  <div class="col-md-6">
                            <div class="form-group">
                              <label>Ware House</label>
                              <select class="form-control select2" name="ware_houose_id" id="ware_house_id1">
                                <option value="">Choose</option>
                                <?php
                                $query1 = "SELECT warehouse,id FROM ware_house";
                                $run_check1 = mysqli_query($connection, $query1);
                                while ($Data1 = mysqli_fetch_array($run_check1)) {
                                  $warehouse_id = $Data1['id'];
                                  $warehouse_name  = $Data1['warehouse'];
                                ?>
                                  <option value="<?php echo $warehouse_id; ?>"><?php echo $warehouse_name; ?>
                                  </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div> -->
                            <!--               <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label>Product Unit</label>
                  <select class="form-control select2" name="product_unit_id">
                    <option value="">Choose</option>
                    <?php
                    $query = "SELECT unit,id FROM units";
                    $run_check = mysqli_query($connection, $query);
                    while ($Data = mysqli_fetch_array($run_check)) {
                      $id = $Data['id'];
                      $unit  = $Data['unit'];
                    ?>
                      <option value="<?php echo $id; ?>"><?php echo $unit; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label>Product Purchase Unit</label>
                  <select class="form-control select2" name="purchase_unit">
                    <option value="">Choose</option>
                    <?php
                    $query = "SELECT unit,id FROM units";
                    $run_check = mysqli_query($connection, $query);
                    while ($Data = mysqli_fetch_array($run_check)) {
                      $id = $Data['id'];
                      $unit  = $Data['unit'];
                    ?>
                      <option value="<?php echo $id; ?>"><?php echo $unit; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label>Product Sale Unit</label>
                  <select class="form-control select2" name="sale_unit">
                    <option value="">Choose</option>
                    <?php
                    $query = "SELECT unit,id FROM units";
                    $run_check = mysqli_query($connection, $query);
                    while ($Data = mysqli_fetch_array($run_check)) {
                      $id = $Data['id'];
                      $unit  = $Data['unit'];
                    ?>
                      <option value="<?php echo $id; ?>"><?php echo $unit; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div> -->

                            <div class="form-group col-md-4">
                                <label>Alert Quantity</label>
                                <input type="number" class="form-control" placeholder="Alert quantity"
                                    name="alert_quantity" required>
                            </div>

                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" placeholder="Description" name="description"
                                        rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Upload Image</label>
                                    <input id="file1" type="file" name="product_image" onchange="showImage1(event)" t
                                        accept="image/*" class="form-control" style="overflow: hidden;">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mr-3 mt-3">
                                    <img id="log1" class="shadow"
                                        style="border: 1px blue solid; border-radius: 10%; margin-top: -4%"
                                        width="120px;" height="130px" src="../../images/product.png" alt="">
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
  if (isset($_POST['saveData'])) 
  {
    $item_name =  $_POST['product_name'];
    $product_unit = $_POST['product_unit'];
    $item_code = $_POST['item_code'];
    //$open_stock_quantity = $_POST['open_stock_quantity'];
    $alert_quantity = $_POST['alert_quantity'];
    $Description = $_POST['description'];
    $profImage = $_FILES['product_image']['name'];
    $temp_profImage  = $_FILES['product_image']['tmp_name'];
    $pathImg1U    = "../../images/product_image/" . $profImage;
    move_uploaded_file($temp_profImage, $pathImg1U);
    $to_date = date('y-m-d');
    
    $check = "SELECT * FROM products WHERE  product_code = '$item_code'";
    $run_check = mysqli_query($connection, $check);
    $countRow = mysqli_num_rows($run_check);
    if ($countRow == 0) 
    {
      $insert = "INSERT INTO products(product_name, brand, product_code ,category_id, product_unit, alert_quantity,open_stock_quantity, Description, product_image) VALUES ('$item_name','$brand','$item_code','$model','$product_unit','$alert_quantity','0','$Description','$profImage')";

      $run = mysqli_query($connection, $insert);
      $last_Product = mysqli_insert_id($connection);

      // $last_id_in_table1 = LAST_INSERT_ID();

     $update_query1 = "INSERT INTO stock_items(product_id, purchase_item_id, warehouse_id,product_code,quantity, purchase_price, sale_price, stock_date)

       VALUES ($last_Product,'0','0','$item_code','0','0','0','$to_date')";
        $update_run = mysqli_query($connection, $update_query1);
    }else{
      echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Added!',
                          'Product Already Exists!',
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
    if ($update_run) 
    {
      //  $insertStock = "INSERT INTO stock_items( product_id,warehouse_id, quantity, stock_date) VALUES ('$last_Product','0','0','$to_date')";

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
    let showImage1 = function(event) {
        let uploadField = document.getElementById("file1");
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
            let logoId = document.getElementById('log1');
            logoId.src = URL.createObjectURL(event.target.files[0]);
        }
    }
    </script>