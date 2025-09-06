<?php include("include/header.php");
if (isset($_GET['product_id'])) {
  $product_id = $_GET['product_id'];
  $query2 = "SELECT p.product_code,p.product_image,p.id,p.product_name,c.id AS cat_id,c.category,p.alert_quantity,p.description,p.brand,p.product_unit
                  FROM products AS p
                  Left JOIN categories AS c
                  ON c.id = p.category_id
                   WHERE p.id = '$product_id'";
  $runData = mysqli_query($connection, $query2);
  $rowData = mysqli_fetch_array($runData);
  $id = $rowData['id'];
  $product_name = $rowData['product_name'];
  $product_code = $rowData['product_code'];
  $cat_id = $rowData['cat_id'];
  $category = $rowData['category'];
  $brand = $rowData['brand'];
  $product_unit = $rowData['product_unit'];
  $alert_quantity  = $rowData['alert_quantity'];
  $product_image  = $rowData['product_image'];
  $path  = "../../images/product_image/".$product_image;
  $description  = $rowData['description'];
}
?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row">
    <div class="col-md-12">
      <h3>Update Products</h3>
    </div>
  </div>
  <div class="page-content container-fluid">
    <!--  Start Row  -->

    <div class="card my-only-div-shadow">
      <div class="card-body">
        <!-- <h3>Add Product</h3> -->
        <br>
        <form method="POST" enctype='multipart/form-data'>
          <div class="modal-body">
            <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                  <label>Model</label>
                  <select class="form-control select2" name="category_id">
                    <option value="<?php echo $cat_id; ?>"><?php echo $category ?></option>
                    <?php
                    $query = "SELECT category,id FROM categories";
                    $run_check = mysqli_query($connection, $query);
                    while ($Data = mysqli_fetch_array($run_check)) {
                      $id = $Data['id'];
                      $category  = $Data['category'];
                    ?>
                      <option value="<?php echo $id; ?>"><?php echo $category; ?>
                      </option>
                    <?php } ?>

                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Brand</label>
                  <input type="text" class="form-control" placeholder="Enter Brand Name" name="Product_brand" value="<?php echo $brand; ?>" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Item Name</label>
                  <input type="text" class="form-control" value="<?php echo $product_name;  ?>" placeholder="Enter Product Name" name="product_name">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Item Code</label>
                  <input type="text" class="form-control" value="<?php echo $product_code;  ?>" placeholder="Enter Product Code" name="product_code" readonly>
                </div>
              </div>
              
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label>Unit</label>
                  <input type="text" class="form-control" value="<?php echo $product_unit; ?>" placeholder="Alert Quantity" name="product_unit">
                </div>
              </div>
              <!--<div class="col-md-4 mt-2">
                <div class="form-group">
                  <label>Open Stock Qty.</label>
                  <input type="number" class="form-control" value="<?php echo $alert_quantity ?>" placeholder="Alert Quantity" name="alert_quality">
                </div>
              </div> -->
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label>Alert Quantity</label>
                  <input type="number" class="form-control" value="<?php echo $alert_quantity ?>" placeholder="Alert Quantity" name="alert_quantity">
                </div>
              </div>
              <!-- <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label>Open stock Quantity</label>
                  <input type="text" class="form-control" value="<?php echo $open_stock_quantity ?>" placeholder="Open stock Quantity" name="open_stock_quantity">
                </div>
              </div> -->
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" placeholder="Description" name="Description" rows="5"><?php echo $description ?></textarea>
                </div>
              </div>
              <div class="col-md-4">
                      <div class="form-group">
                        <label>Image</label>
                        <input id="file1" type="file" name="image" onchange="showImage1(event)" t accept="image/*" class="form-control" style="overflow: hidden;">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group mr-3 mt-3">
                        <img id="log1" class="shadow" style="border: 1px blue solid; border-radius: 10%; margin-top: -4%" width="120px;" height="130px" src="<?php if($product_image == NULL OR $product_image ==''){echo "../../images/product.png";}else{
                          echo "$path";
                        }
                        ?>" alt="">
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
    $pro_name =  $_POST['product_name'];
    $pro_code =  $_POST['product_code'];
    $cat_id = $_POST['category_id'];
    $alert_quantity = $_POST['alert_quantity'];
    $p_unit = $_POST['product_unit'];
    $p_brand =$_POST['Product_brand'];

   // $open_stock_quantity = $_POST['alert_quality'];
    $Description = $_POST['Description'];
    $profImage = $_FILES['image']['name'];
      $temp_profImage  = $_FILES['image']['tmp_name'];
      if ($profImage =='') {
        $userImage = $product_image;
      }else{
        $userImage = date("y-m-d-h-i-s").$profImage;
      unlink($path);
      $pathImg1U    = "../../images/product_image/" . $userImage;
      move_uploaded_file($temp_profImage, $pathImg1U);
}
    $insert = "UPDATE `products` SET `product_name`='$pro_name',`product_code`='$pro_code',`category_id`='$cat_id',`alert_quantity`='$alert_quantity',`brand`='$p_brand',`description`='$Description',`product_image`='$userImage', `product_unit`='$p_unit' WHERE id = '$product_id'";
    $run = mysqli_query($connection, $insert);
    if ($run) {
       /*   $insert1 = "UPDATE `stock_items` SET `quantity`='$open_stock_quantity' WHERE product_id = '$product_id'";
    $run1 = mysqli_query($connection, $insert1);

   $insert2 = "UPDATE `sale_items` SET `product_code`='$pro_code' WHERE product_id = '$product_id'";
    $run2 = mysqli_query($connection, $insert2);

       $insert3 = "UPDATE `purchase_items` SET `product_code`='$pro_code' WHERE product_id = '$product_id'";
    $run3 = mysqli_query($connection, $insert3);  */

      echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Updated!',
                          'Product has been successfully Updated!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'product_details.php';
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
                                window.location.href = 'product_details.php';
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