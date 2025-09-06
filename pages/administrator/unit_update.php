<?php include("include/header.php");
if (isset($_GET['unit_id'])) {
  $unit_id = $_GET['unit_id'];
  $query = "SELECT * FROM units WHERE id='$unit_id'";
  $result = mysqli_query($connection, $query);
  $totalRows = mysqli_fetch_array($result);
  $unit = $totalRows['unit'];
}
?>

<div class="page-content">
  <!--breadcrumb-->
  <div class="page-content container-fluid">
    <!--  Start Row  -->
    <div class="card my-only-div-shadow">
      <div class="card-body">
        <h3>Update unit</h3>
        <br>
        <form method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>unit</label>
                <input type="text" name="unit_name" value="<?php echo $unit ?>" class="form-control">

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
  $unit_name = $_POST['unit_name'];
  $query = "UPDATE `units` SET `unit`='$unit_name' WHERE id='$unit_id'";
  $run = mysqli_query($connection, $query);
  if ($run) {
    echo "<!DOCTYPE html>
      <html>
      <body>
        <script>
        Swal.fire(
        'Updated!',
        'unit has been successfully Updated!',
        'success'
        ).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'unit.php';
        }
        });
        </script>
      </body>
      </html>";
  }
}



?>