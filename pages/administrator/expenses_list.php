<?php
include "include/header.php";
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="m-0 text-dark">Expense's Details</h4>
      </div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid" class="text-center">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general Card elements -->
        <div class="card card-dark" class="text-center">
          <div class="card-header">
            <div class="card-tools">
              <a href="expense_add.php" class="btn btn-primary btn-sm shadow">Add New</a>
            </div>
          </div>
          <br>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <!-- Table start -->
            <table class="table table-bordered text-center datatable table-striped my-only-div-shadow">
              <thead class="my-table-style text-white">
                <tr>
                  <th>S.No</th>
                  <th>Date</th>
                  <th>Expense Category</th>
                  <th>Expense's Person</th>
                  <th>Expense's Amount</th>
                  <th>Details</th>
                  <th>Receipt</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $count = 0;
                $fetchData = "SELECT e.id, ec.expense_cat, e.expense_person, e.amount, e.details, e.exp_date, e.receipt FROM expenses AS e LEFT JOIN expenses_category  AS ec ON ec.id = e.cat_id ORDER BY e.id DESC";
                $runData = mysqli_query($connection, $fetchData);
                while ($rowData = mysqli_fetch_array($runData)) {
                  $count++;
                  $id         = $rowData['id'];
                  $expense_cat       = $rowData['expense_cat'];
                  $expense_person   = $rowData['expense_person'];
                  $amount   = $rowData['amount'];
                  $details    = $rowData['details'];
                  $exp_date      = date("d-m-Y", strtotime($rowData['exp_date']));
                  $receipt    = $rowData['receipt'];
                  $pathImg = "../../images/admin/exp_recpt/" . $receipt;
                ?>
                  <tr class="my-table-row-hover">
                    <td><?php echo $count ?></td>
                    <td><?php echo $exp_date ?></td>
                    <td><?php echo $expense_cat ?></td>
                    <td><?php echo $expense_person ?></td>
                    <td><?php echo $amount ?></td>
                    <td><?php echo $details ?></td>
                    <td>
                      <?php if($receipt != '') { ?>
                      <a href="<?php echo $pathImg ?>" target="_blank"><img src="<?php echo $pathImg ?>" height="100" width="100"></a>
                      <?php } else { echo "Not Uploaded"; } ?>
                    </td>
                    <td>
                      <a href="expenses_edit.php?exp_id=<?php echo $id ?>" class="btn btn-sm btn-info shadow title" title="Edit"><span><i class="bx bx-edit"></i></span></a>

                      <input type="hidden" id="exp_id<?php echo $count ?>" value="<?php echo $id ?>">
                      <input type="hidden" id="pathImg<?php echo $count ?>" value="<?php echo $pathImg ?>">
                      <a class="btn btn-sm btn-danger shadow text-white" title="Delete" onclick="deleteData(<?php echo $count ?>)"><span><i class="bx bx-trash"></i></span></a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<?php include "include/footer.php"; ?>
<script>
  function deleteData(id) {
    var exp_id = $("#exp_id" + id).val();
    var pathImg = $("#pathImg" + id).val();
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
        window.location.href = "expenses_list.php?deletId=" + exp_id + "&pathImg=" + pathImg;
      }
    });

  }
</script>
<?php
 if(isset($_GET['deletId']))
 {
 $id = $_GET['deletId'];
 $path = $_GET['pathImg'];
 @unlink($path);
  $delete = "DELETE FROM expenses WHERE id = '$id'";
  $run = mysqli_query($connection, $delete);
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
             window.location.href= 'expenses_list.php';
          }
        });
        </script>
        </body>
      </html>";
  }
}
?>