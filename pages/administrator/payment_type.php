<?php
include "include/header.php";
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="m-0 text-dark">Add Payment Type</h4>
      </div>
    </div>
  </div>
</div>
<section class="content" >
  <div class="container-fluid" class="text-center">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-dark" class="text-center">
          <br>
          <div class="card-body">
            <form method="post">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Bank Name</label>
                    <input type="text" class="form-control" name="payment_name" placeholder="Bank Name/Payment Type" required>
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
            if(isset($_POST['saveUser']))
            {
            $payment_name = $_POST['payment_name'];
            $insert = "INSERT INTO `payment_method`(`method`) VALUES ('$payment_name')";
            $run = mysqli_query($connection,$insert);
            if($run)
            {
            echo "<!DOCTYPE html>
                  <html>
                    <body> 
                    <script>
                    Swal.fire(
                      'Added !',
                      'Payment Type has been added successfully',
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
                      'Payment Type not add, Some error occure',
                      'error'
                    ).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = 'payment_type.php';
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
        <<table class="table table-bordered table-hover shadow table-striped  datatable text-center my-only-div-shadow">
          <thead class="my-table-style text-white">
            <tr>
              <th>S.No</th>
              <th>Bank Name/Payment Type</th>
              <th>Action</th>
            </tr>
            
          </thead>
          <tbody class="table-font-size">
            <?php
            $count = 0;
            $query2 = "SELECT * FROM `payment_method`";
            $runData = mysqli_query($connection,$query2);
            while($rowData = mysqli_fetch_array($runData)) {
            $count++;
            $id = $rowData['id'];
            $payment  = $rowData['method'];
            ?>
            <tr class="my-table-row-hover">
              <td><?php echo $count; ?></td>
              <td><?php echo $payment;?></td>
              <td>
                <a href="payment_type_edit.php?bank_id=<?php echo $id ?>" class="btn btn-sm btn-info shadow title" title="Edit"><span><i class="fa fa-edit"></i></span></a>

                <input type="hidden" id="bank_id<?php echo $count ?>" value="<?php echo $id ?>">
                  <a class="btn btn-sm btn-danger shadow text-white" title="Delete"
                  onclick="deleteData(<?php echo $count ?>)"><span><i class="fa fa-trash-alt"></i></span></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
  <?php
  if(isset($_GET['deleteId']))
  {
    $id = $_GET['deleteId'];
    $delete = "DELETE FROM payment_method WHERE id = '$id'";
    $run = mysqli_query($connection,$delete);
    if($run)
    {
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
             window.location.href = 'payment_type.php';
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
  function deleteData(id)
  {
    var bank_id = $("#bank_id"+id).val();
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
        window.location.href= "payment_type.php?deleteId="+bank_id;
      }
  });

  }
</script>