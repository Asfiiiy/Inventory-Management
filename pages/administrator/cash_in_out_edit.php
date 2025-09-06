<?php
include "include/header.php";
$customer_id = $_GET['customer_id'];
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="m-0 text-dark">Edit User</h4>
      </div>
    </div>
  </div>
  <div class="col-md-12">
            <a href="cash_in_out.php" class="btn btn-warning shadow mb-1">Back</a>
          </div>
</div>
<section class="content" >
  <div class="container-fluid" class="text-center">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-dark" class="text-center">
          <br>
          <?php
            $query = "SELECT * FROM customer_in_out WHERE id = '$customer_id'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            $customer = $row['customer'];
          ?>
          <div class="card-body">
            <form method="post">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>User Name</label>
                    <input type="text" class="form-control" value="<?php echo $customer ?>" name="cus_name" placeholder="User Name" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <center>
                  <input type="submit" class="btn btn-success shadow" value="Update" name="saveUser">
                  </center>
                </div>
              </div>
            </form>
            <?php
            if(isset($_POST['saveUser']))
            {
             $cus_name   = $_POST['cus_name'];
             $insert = "UPDATE customer_in_out SET `customer`='$cus_name' WHERE id = '$customer_id'";

              $run = mysqli_query($connection,$insert);
              if($run)
              {
              echo "<!DOCTYPE html>
                    <html>
                      <body> 
                      <script>
                      Swal.fire(
                        'Updated !',
                        'User has been updated successfully',
                        'success'
                      ).then((result) => {
                        if (result.isConfirmed) {
                           window.location.href = 'cash_in_out.php';
                        }
                      });
                      </script>
                      </body>
                    </html>";
              }
              else
              {
              echo "<!DOCTYPE html>
                    <html>
                      <body> 
                      <script>
                      Swal.fire(
                        'Error !',
                        'User not updated, Some error occure',
                        'error'
                      ).then((result) => {
                        if (result.isConfirmed) {
                           window.location.href = 'cash_in_out_edit.php?customer_id=$customer_id';
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
    </div>
<?php include "include/footer.php"; ?>