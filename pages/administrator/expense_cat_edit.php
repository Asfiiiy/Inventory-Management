<?php
include "include/header.php";
$expense_cat_id = $_GET['expense_cat_id'];
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="m-0 text-dark">Edit Expense Category</h4>
      </div>
 
    </div>
  </div>
  <div class="col-md-12">
    <a href="expense_cat.php" class="btn btn-warning shadow mb-1">Back</a>
  </div>
</div>
<section class="content" >
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-dark">
          <div class="card-header">
            <!-- <div class="card-title">Expense Category Edit Form</div> -->
          </div>
          <br>
          <?php
            $query = "SELECT * FROM expenses_category WHERE id = '$expense_cat_id'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            $expense_cat = $row['expense_cat'];
          ?>
          <div class="card-body">
            <form method="post">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Expense Category</label>
                    <input type="text" class="form-control" value="<?php echo $expense_cat ?>" name="expense_cat_name" placeholder="Expense Category Name" required>
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
             $expense_cat_name   = $_POST['expense_cat_name'];
             $insert = "UPDATE expenses_category SET `expense_cat`='$expense_cat_name' WHERE id = '$expense_cat_id'";

              $run = mysqli_query($connection,$insert);
              if($run)
              {
              echo "<!DOCTYPE html>
                    <html>
                      <body> 
                      <script>
                      Swal.fire(
                        'Updated !',
                        'Expense Category has been updated successfully',
                        'success'
                      ).then((result) => {
                        if (result.isConfirmed) {
                           window.location.href = 'expense_cat.php';
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
                        'Expense Category not updated, Some error occure',
                        'error'
                      ).then((result) => {
                        if (result.isConfirmed) {
                           window.location.href = 'expense_cat.php';
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