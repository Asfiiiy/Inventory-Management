<?php include("include/header.php");
if (isset($_GET['cat_id'])) {
  $cat_id = $_GET['cat_id'];
  $query = "SELECT * FROM ware_house WHERE id='$cat_id'";
  $result = mysqli_query($connection, $query);
  $totalRows = mysqli_fetch_array($result);
  $warehouse = $totalRows['warehouse'];
}
?>

<div class="page-content">
  <!--breadcrumb-->
  <div class="page-content container-fluid">
    <!--  Start Row  -->
    <div class="card my-only-div-shadow">
      <div class="card-body">
        <h3>Update Ware House</h3>
        <br>
        <form method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Ware House</label>
                <input type="text" name="warehouse" value="<?php echo $warehouse ?>" class="form-control">

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
  $warehouse = $_POST['warehouse'];
  $query = "UPDATE `ware_house` SET `warehouse`='$warehouse' WHERE id='$cat_id'";
  $run = mysqli_query($connection, $query);

  if ($run) {
    echo "<!DOCTYPE html>
      <html>
      <body>
        <script>
        Swal.fire(
        'Updated!',
        'warehouse has been successfully Updated!',
        'success'
        ).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'add_ware_house.php';
        }
        });
        </script>
      </body>
      </html>";
  }
}



?>