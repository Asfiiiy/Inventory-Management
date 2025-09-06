<?php
include "include/header.php";
$bank_id = $_GET['bank_id'];
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="m-0 text-dark">Edit Payment Type</h4>
      </div>
    </div>
  </div>
  <div class="col-md-12">
            <a href="payment_type.php" class="btn btn-warning shadow mb-1">Back</a>
          </div>
</div>
<section class="content" >
  <div class="container-fluid" class="text-center">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-dark" class="text-center">
          <div class="card-header">
          </div>
          <br>
          <?php
            $query = "SELECT * FROM payment_method WHERE id = '$bank_id'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            $bank_name = $row['method'];
          ?>
          <div class="card-body">
            <form method="post">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Bank Name/Payment Type</label>
                    <input type="text" class="form-control" value="<?php echo $bank_name ?>" name="pay_name" placeholder="Bank Name/Payment Type" required>
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
             $pay_name   = $_POST['pay_name'];
             $insert = "UPDATE payment_method SET `method`='$pay_name' WHERE id = '$bank_id'";

              $run = mysqli_query($connection,$insert);
              if($run)
              {
              echo "<!DOCTYPE html>
                    <html>
                      <body> 
                      <script>
                      Swal.fire(
                        'Updated !',
                        'Payment Type has been updated successfully',
                        'success'
                      ).then((result) => {
                        if (result.isConfirmed) {
                           window.location.href = 'payment_type.php';
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
                        'Payment Type not updated, Some error occure',
                        'error'
                      ).then((result) => {
                        if (result.isConfirmed) {
                           window.location.href = 'payment_type_edit.php?bank_id=$bank_id';
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