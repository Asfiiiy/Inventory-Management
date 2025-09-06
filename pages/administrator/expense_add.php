<?php
include "include/header.php";
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="m-0 text-dark">Add New Expense</h4>
      </div>

    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid" class="text-center">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-dark" class="text-center">
          <div class="card-header">
            <div class="card-tools">
              <a href="expenses_list.php" class="btn btn-primary btn-sm shadow">Expenses's List</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- form start -->
            <form method="post" enctype="multipart/form-data">
              <div class="row m-0" id="edu_new_row">
                <div class="col-md-12 m-0" id="exp_new_data1">
                  <div class="row text-right">
                    <div class="col-md-12">
                      <div class="form-group">
                        <br>
                        <button type="button" class="btn btn-success shadow title" onclick="add_row()" title="Add More"><i class="fa fa-plus"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                      <div class="form-group">
                        <label>Expense Category</label>
                        <select class="form-control select2" name="exp_cat[]" required>
                          <option value="">Choose</option>
                          <?php
                          $query2 = "SELECT * FROM `expenses_category`";
                          $runData = mysqli_query($connection, $query2);
                          while ($rowData = mysqli_fetch_array($runData)) {
                            $count++;
                            $id = $rowData['id'];
                            $expense_cat  = $rowData['expense_cat'];
                            echo "<option value='$id'>$expense_cat</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="expense_date[]" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                      </div>
                    </div>
                   
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Expense's Person</label>
                        <input type="text" name="exp_person[]" placeholder="Expense's Person" class="form-control" autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Expense's Amount</label>
                        <input type="number" name="exp_amount[]" placeholder="Expense's Amount" class="form-control" autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Details</label>
                        <textarea placeholder="Expense's Details" name="details[]" class="form-control"></textarea>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Receipt</label>
                        <input type="file" name="receipt[]" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <center>
                    <input type="submit" class="btn btn-info shadow" value="Add" name="saveData">
                  </center>
                </div>
              </div>
            </form>
            <?php
            if (isset($_POST['saveData'])) {
              $count = COUNT($_POST['expense_date']);
              for ($i = 0; $i < $count; $i++) {
                $expense_date      = $_POST['expense_date'][$i];
                $exp_cat  = $_POST['exp_cat'][$i];
                $exp_person     = $_POST['exp_person'][$i];
                $exp_amount    = $_POST['exp_amount'][$i];
                $details    = $_POST['details'][$i];
                if($_FILES['receipt']['name'][$i] == '')
                {
                  $certImage = '';
                }
                else
                {
                  $certImage = date("Y-m-d H-i").$_FILES['receipt']['name'][$i];
                  $temp_certImage = $_FILES['receipt']['tmp_name'][$i];
                  $pathImg1U = "../../images/admin/exp_recpt/".$certImage;
                  move_uploaded_file($temp_certImage, $pathImg1U);
                }
                
                
                $insert = "INSERT INTO `expenses`(`cat_id`, `expense_person`, `amount`, `details`, `exp_date`,`receipt`) VALUES ('$exp_cat','$exp_person','$exp_amount','$details','$expense_date','$certImage')";
     
                $run = mysqli_query($connection, $insert);
                $expId = mysqli_insert_id($connection);


                
              }
              if ($run) {
              $insert2 = "INSERT INTO `cash_history`(`amount`, `pay_status`, `details`, `pay_date`, `pay_person`, `contact`, `receipt`, `pay_by`, `expense_id`) VALUES ('$exp_amount','OUT','$details','$expense_date','$exp_person','Expense','$certImage','Expense','$expId')";
               $run2 = mysqli_query($connection,$insert2);

                echo "<!DOCTYPE html>
              <html>
                <body>
                  <script>
                  Swal.fire(
                  'Added !',
                  'Expense has been added successfully',
                  'success'
                  ).then((result) => {
                  if (result.isConfirmed) {
                  window.location.href= 'expense_add.php';
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
                  'Expense not add, Some error occure',
                  'error'
                  ).then((result) => {
                  if (result.isConfirmed) {
                  window.location.href = 'expense_add.php';
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
  </div>
</section>
<?php include "include/footer.php"; ?>

<script>
  var autoIncNo = 1;

  function add_row() {
    autoIncNo++;
    $.ajax({
      url: 'expense_row.php',
      method: 'POST',
      data: {
        'count': autoIncNo
      },
      success(data) {
        $('#edu_new_row').append(data);
        $('.select2').select2({
          theme: 'bootstrap4'
        });
      }
    });
  }

  function remove_exp(id) {
    let div = '#exp_new_data'+id;
    $(div).remove();
  }
</script>