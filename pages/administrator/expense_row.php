<?php
include('include/db.php');
date_default_timezone_set("Asia/Karachi");
if (isset($_POST['count'])) {
$count = $_POST['count'];
?>
<div class="col-md-12" id="exp_new_data<?php echo $count ?>">
  <div class="row text-right">
    <div class="col-md-12">
      <div class="form-group">
        <button type="button" class="btn btn-danger shadow title" title="Remove" onclick="remove_exp(<?php echo $count ?>)"><i class="fa fa-trash"></i></button>
      </div>
    </div>
  </div>
  <input type="hidden" name="row[]" value="<?php echo $count ?>">
  <hr>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label>Date</label>
        <input type="date" name="expense_date[]" value="<?php echo date('Y-m-d'); ?>" class="form-control">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>Expense Category</label>
        <select class="form-control select2" name="exp_cat[]" required>
          <option value="">Choose</option>
          <?php
          $query2 = "SELECT * FROM `expenses_category`";
          $runData = mysqli_query($connection, $query2);
          while ($rowData = mysqli_fetch_array($runData)) {
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
<?php } ?>