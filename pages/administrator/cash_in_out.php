<?php
include "include/header.php";
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="m-0 text-dark">Add Cash IN & OUT User</h4>
      </div>

    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid" class="text-center">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-dark my-only-div-shadow" class="text-center">
          <br>
          <div class="card-body">
            <form method="post">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>User Name</label>
                    <input type="text" class="form-control" name="customer" placeholder="User Name" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <center>
                    <input type="submit" class="btn btn-success shadow" value="Add" name="saveUser">
                  </center>
                </div>
              </div>
            </form>
            <?php
            if (isset($_POST['saveUser'])) {
              $customer = $_POST['customer'];
              $insert = "INSERT INTO `customer_in_out`(`customer`) VALUES ('$customer')";
              $run = mysqli_query($connection, $insert);
              if ($run) {
                echo "<!DOCTYPE html>
                  <html>
                    <body> 
                    <script>
                    Swal.fire(
                      'Added !',
                      'User has been added successfully',
                      'success'
                    ).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = 'cash_in_out.php';
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
                      'User not add, Some error occure',
                      'error'
                    ).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = 'cash_in_out.php';
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

    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive my-only-div-shadow py-4 px-2">
          <table class="table table-striped table-bordered bg-white text-center datatable ">
            <thead class="my-table-style text-white">
              <tr>
                <th>S.No</th>
                <th>User</th>
                <th>Action</th>
              </tr>

            </thead>
            <tbody class="table-font-size">
              <?php
              $count = 0;
              $query2 = "SELECT * FROM `customer_in_out`";
              $runData = mysqli_query($connection, $query2);
              while ($rowData = mysqli_fetch_array($runData)) {
                $count++;
                $id = $rowData['id'];
                $customer  = $rowData['customer'];
              ?>
                <tr class="my-table-row-hover">
                  <td class="pt-2"><?php echo $count; ?></td>
                  <td class="pt-2"><?php echo $customer; ?></td>
                  <td>
                    <a href="cash_in_out_edit.php?customer_id=<?php echo $id ?>" class="mt-1 btn btn-primary shadow btn-sm title" title="Edit"><span><i class="bx bx-edit"></i></span></a>

                    <input type="hidden" id="customer_id<?php echo $count ?>" value="<?php echo $id ?>">
                    <a class="btn btn-sm mt-1 btn-danger shadow text-white title" title="Delete" onclick="deleteData(<?php echo $count ?>)"><span><i class="bx bx-trash-alt"></i></span></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</section>
</div>
<?php
if (isset($_GET['deleteId'])) {
  $id = $_GET['deleteId'];
  $delete = "DELETE FROM customer_in_out WHERE id = '$id'";
  $run = mysqli_query($connection, $delete);
  if ($run) {
    echo "<!DOCTYPE html>
      <html>
        <body> 
        <script>
        Swal.fire(
          'Deleted !',
          'The selected record has been deleted',
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
}
?>
<?php include "include/footer.php"; ?>


<script>
  function deleteData(id) {
    var customer_id = $("#customer_id" + id).val();
    Swal.fire({
      title: 'Are you sure?',
      text: "To delete the selected record !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "cash_in_out.php?deleteId=" + customer_id;
      }
    });

  }
</script>