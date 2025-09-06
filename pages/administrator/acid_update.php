<?php include("include/header.php");
if (isset($_GET['id'])) {
  $charge_id = $_GET['id'];
  $query2 = "SELECT *
                  FROM acid AS p
                   WHERE p.id = '$charge_id'";
  $runData = mysqli_query($connection, $query2);
  $rowData = mysqli_fetch_array($runData);
  $id = $rowData['id'];
  $customer_name = $rowData['customer_name'];
  $purchase_date = $rowData['purchase_date'];
  $product_name = $rowData['product_name'];;
  $price  = $rowData['price'];
  $description  = $rowData['description'];

}
?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row">
    <div class="col-md-12">
      <h3>Update Acid Record</h3>
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
              <div class="col-md-6">
                <div class="form-group">
                  <label>Customer Name</label>
                  <input type="text" class="form-control" value="<?php echo $customer_name;  ?>" placeholder="Enter Customer Name" name="customer_name">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Purchase Date</label>
                  <input type="date" class="form-control" value="<?php echo $purchase_date;  ?>" name="purchase_date">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Product Name</label>
                  <input type="text" class="form-control" value="<?php echo $product_name;  ?>" name="product_name">
                </div>
              </div>
             
              <div class="col-md-6">
                <div class="form-group">
                  <label>Price</label>
                  <input type="number" class="form-control" value="<?php echo $price;  ?>" name="price">
                </div>
              </div>
             
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" placeholder="Description" name="description"><?php echo $description ?></textarea>
                </div>
              </div>
              <div class="col-md-4">
                      <!-- <div class="form-group">
                        <label>Image</label>
                        <input id="file1" type="file" name="image" onchange="showImage1(event)" t accept="image/*" class="form-control" style="overflow: hidden;">
                      </div> -->
                    </div>
                    <div class="col-md-2">
                      <!-- <div class="form-group mr-3 mt-3">
                        <img id="log1" class="shadow" style="border: 1px blue solid; border-radius: 10%; margin-top: -4%" width="120px;" height="130px" src="<?php if($product_image == NULL OR $product_image ==''){echo "../../images/product.png";}else{
                          echo "$path";
                        }
                        ?>" alt="">
                      </div> -->
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
    $customer_name =  $_POST['customer_name'];
    $purchase_date =  $_POST['purchase_date'];
    $product_name =  $_POST['product_name'];
    $price =  $_POST['price'];

    $Description = $_POST['description'];
//     $profImage = $_FILES['image']['name'];
//       $temp_profImage  = $_FILES['image']['tmp_name'];
//       if ($profImage =='') {
//         $userImage = $product_image;
//       }else{
//         $userImage = date("y-m-d-h-i-s").$profImage;
//       unlink($path);
//       $pathImg1U    = "../../images/product_image/" . $userImage;
//       move_uploaded_file($temp_profImage, $pathImg1U);
// }
    $insert = "UPDATE `acid` SET `customer_name`='$customer_name',`purchase_date`='$purchase_date',`product_name`='$product_name',`price`='$price',`description`='$Description' WHERE id = '$charge_id'";
    $run = mysqli_query($connection, $insert);
    if ($run) {
    //   $insert1 = "UPDATE `stock_items` SET `product_code`='$pro_code' WHERE product_id = '$product_id'";
    // $run1 = mysqli_query($connection, $insert1);

    //    $insert2 = "UPDATE `sale_items` SET `product_code`='$pro_code' WHERE product_id = '$product_id'";
    // $run2 = mysqli_query($connection, $insert2);

    //    $insert3 = "UPDATE `purchase_items` SET `product_code`='$pro_code' WHERE product_id = '$product_id'";
    // $run3 = mysqli_query($connection, $insert3);
      echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Updated!',
                          'Acid has been successfully Updated!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'acids_details.php';
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
                                'Acid not add, Some error occure',
                                'error'
                                ).then((result) => {
                                if (result.isConfirmed) {
                                window.location.href = 'acids_details.php';
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