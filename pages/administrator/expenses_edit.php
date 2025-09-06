<?php
include "include/header.php";
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="m-0 text-dark">Edit Expense</h4>
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
          <br>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- form start -->
            <?php
            $get_id = $_GET['exp_id'];
            $fetchData = "SELECT ec.id, ec.expense_cat, e.expense_person, e.amount, e.details, e.exp_date, e.receipt FROM expenses AS e LEFT JOIN expenses_category  AS ec ON ec.id = e.cat_id WHERE e.id = '$get_id' ORDER BY e.id DESC";
            $runData = mysqli_query($connection, $fetchData);
            $rowData = mysqli_fetch_array($runData);
            $cat_idU       = $rowData['id'];
            $expense_catU       = $rowData['expense_cat'];
            $expense_personU   = $rowData['expense_person'];
            $amountU   = $rowData['amount'];
            $detailsU    = $rowData['details'];
            $exp_dateU      = $rowData['exp_date'];
            $receipt      = $rowData['receipt'];
            $pathImg = "../../images/admin/exp_recpt/" . $receipt;
            ?>
            <form method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Date</label>
                      <input type="date" value="<?php echo $exp_dateU ?>" class="form-control" name="expense_date">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Expense Category</label>
                      <select class="form-control select2" name="exp_cat" required>
                        <option value="">Choose</option>
                        <?php
                        $query2 = "SELECT * FROM `expenses_category`";
                        $runData = mysqli_query($connection, $query2);
                        while ($rowData = mysqli_fetch_array($runData)) {
                          $count++;
                          $id = $rowData['id'];
                          $expense_cat  = $rowData['expense_cat'];
                        ?>
                          <option <?php if ($id == $cat_idU) {
                                    echo "selected";
                                  } ?> value='<?php echo $id ?>'><?php echo  $expense_cat ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Expense's Person</label>
                      <input type="text" name="exp_person" placeholder="Expense's Person" class="form-control" value="<?php echo  $expense_personU ?>" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Expense's Amount</label>
                      <input type="number" name="exp_amount" placeholder="Expense's Amount" class="form-control" value="<?php echo $amountU ?>" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Details</label>
                      <textarea placeholder="Expense's Details" name="details" class="form-control"><?php echo $detailsU ?></textarea>
                    </div>
                  </div>

                  <div class="col-md-4">
                  <div class="form-group">
                    <label>Profile Image</label>
                    <input id="receipt" name="receipt" onchange="showImage1(event)" type="file"
                    accept="image/*" class="form-control" style="overflow: hidden;"
                    placeholder="Insert Your Image">
                  </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-7">
                  <div class="form-group mr-3 mt-0">
                    <img id="log1" class="shadow"
                    style="border: 1px blue solid; border-radius: 10%; margin-top: -4%"
                    width="120px;" height="130px" src="<?php
                    if($pathImg == NULL OR $pathImg == '')
                    {
                    echo "../../images/file_icon.png";
                    }
                    else
                    {
                      echo $pathImg;
                    }
                    ?> " alt="">
                  </div>
                </div>
                </div>

                <br>
                <div class="row">
                  <div class="col-md-12">
                    <center>
                      <input type="submit" class="btn btn-success shadow" value="Update" name="saveData">
                      <a href="expenses_list.php" class="btn btn-danger shadow">Cancel</a>
                    </center>
                  </div>
                </div>
              </div>
            </form>
            <?php
            if (isset($_POST['saveData'])) {
              $expense_date      = $_POST['expense_date'];
              $exp_cat  = $_POST['exp_cat'];
              $exp_person     = $_POST['exp_person'];
              $exp_amount    = $_POST['exp_amount'];
              $details    = $_POST['details'];
              if ($_FILES['receipt']['name'] == '') {
                $certImage = $receipt;
              } else {
                $certImage = $expense_date . $_FILES['receipt']['name'];
                $temp_certImage = $_FILES['receipt']['tmp_name'];
                 $pathImg1U = "../../images/admin/exp_recpt/" . $certImage;
                move_uploaded_file($temp_certImage, $pathImg1U);
                @unlink($pathImg);
              }

              $insert = "UPDATE `expenses` SET `cat_id` = '$exp_cat', `expense_person` = '$exp_person', `amount` = '$exp_amount', `details` = '$details', `exp_date` = '$expense_date',`receipt` = '$certImage'  WHERE id = '$get_id'";
              $run = mysqli_query($connection, $insert);
              if ($run) {
                echo "<!DOCTYPE html>
                <html>
                  <body>
                    <script>
                    Swal.fire(
                    'Updated !',
                    'Expense has been update successfully',
                    'success'
                    ).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href= 'expenses_list.php';
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
                    window.location.href = 'expenses_edit.php?exp_id=$get_id';
                    }
                    });
                    </script>
                  </body>
                </html>";
              }
            }
            ?>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- Col-12 -->
    </div>
    <!-- row -->
  </div>
</section>
<?php include "include/footer.php"; ?>

<script>

var showImage1 = function(event) {
var uploadField = document.getElementById("receipt");
if (uploadField.files[0].size > 300000) {
uploadField.value = "";
Swal.fire(
'Error !',
'File Size is too big! Upload logo under 300kB !',
'error'
).then((result) => {
if (result.isConfirmed) {
}
});
} else {
var logoId = document.getElementById('log1');
logoId.src = URL.createObjectURL(event.target.files[0]);
}
}
</script>