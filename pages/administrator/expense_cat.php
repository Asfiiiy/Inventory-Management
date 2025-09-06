<?php
include "include/header.php";
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="m-0 text-dark">Add Expenses Category</h4>
      </div>

    </div>
  </div>
</div>
<section class="content" >
  <div class="container-fluid" class="text-center">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-dark" class="text-center">
          <div class="card-header">
            <!-- <div class="card-title">Expenses Category Form</div> -->
          </div>
          <br>
          <div class="card-body">
            <form method="post">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Expenses Category</label>
                    <input type="text" class="form-control" name="expense_cat_name" placeholder="Expenses Category Name" required>
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
            $expense_cat_name = $_POST['expense_cat_name'];
            $insert = "INSERT INTO `expenses_category`(`company_id`,`expense_cat`) VALUES ('$company_Id','$expense_cat_name')";
            $run = mysqli_query($connection,$insert);
            if($run)
            {
            echo "<!DOCTYPE html>
                  <html>
                    <body> 
                    <script>
                    Swal.fire(
                      'Added !',
                      'Expenses Category has been added successfully',
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
                      'Expenses Category not add, Some error occure',
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
    
    <div class="row">
      <div class="col-md-12">
         <table class="table table-bordered text-center datatable table-striped my-only-div-shadow">
              <thead class="my-table-style text-white">
            <tr>
              <th>S.No</th>
              <th>Expenses Category</th>
              <th>Action</th>
            </tr>
            
          </thead>
          <tbody>
            <?php
            $count = 0;
            $query2 = "SELECT * FROM `expenses_category`";
            $runData = mysqli_query($connection,$query2);
            while($rowData = mysqli_fetch_array($runData)) {
            $count++;
            $id = $rowData['id'];
            $expense_cat  = $rowData['expense_cat'];
            ?>
            <tr class="my-table-row-hover">
              <td><?php echo $count; ?></td>
              <td><?php echo $expense_cat;?></td>
              <td>
                <a href="expense_cat_edit.php?expense_cat_id=<?php echo $id ?>" class="btn btn-sm btn-info shadow title" title="Edit"><span><i class="fa fa-edit"></i></span></a>

                <input type="hidden" id="expense_cat_id<?php echo $count ?>" value="<?php echo $id ?>">
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
    $delete = "DELETE FROM expenses_category WHERE id = '$id'";
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
                   window.location.href = 'expense_cat.php';
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
    var expense_cat_id = $("#expense_cat_id"+id).val();
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
        window.location.href= "expense_cat.php?deleteId="+expense_cat_id;
      }
  });

  }
</script>