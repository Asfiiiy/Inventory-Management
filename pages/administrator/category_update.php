<?php include("include/header.php");
if (isset($_GET['cat_id'])) {
  $cat_id = $_GET['cat_id'];
  $query = "SELECT * FROM categories WHERE id='$cat_id'";
  $result = mysqli_query($connection, $query);
  $totalRows = mysqli_fetch_array($result);
  $category = $totalRows['category'];
}
?>

<div class="page-content">
  <!--breadcrumb-->
  <div class="page-content container-fluid">
    <!--  Start Row  -->
    <div class="card my-only-div-shadow">
      <div class="card-body">
        <h3>Update Model</h3>
        <br>
        <form method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Model</label>
                <input type="text" name="cat_name" value="<?php echo $category ?>" class="form-control">

              </div>
            </div>
          </div>
      </div>
    </div>
    <br>
    <div class="modal-footer">
      <input type="submit" name="saveData" class="btn btn-primary shadow" value="Update">
    </div>
    </form>
  </div>
</div>
<!-- End Row  -->
</div>
<?php
if (isset($_POST['saveData'])) {
  $cat_name = $_POST['cat_name'];
  $query = "UPDATE `categories` SET `category`='$cat_name' WHERE id='$cat_id'";
  $run = mysqli_query($connection, $query);
  if ($run) {
    echo "<!DOCTYPE html>
      <html>
      <body>
        <script>
        Swal.fire(
        'Updated!',
        'Model has been successfully Updated!',
        'success'
        ).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'category.php';
        }
        });
        </script>
      </body>
      </html>";
  }
}



?>