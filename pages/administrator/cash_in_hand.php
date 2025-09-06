<?php
include "include/header.php";
?>

<section class="content" >
  <div class="container-fluid" class="text-center">
    <div class="row">
      <div class="col-md-12">
        <br>
        <h4 class="text-center bg-secondary text-white p-5 shadow">Account Details</h4>

        <br><br>

        <div class="text-center">
          <h3>
            <a href="cash_in_hand_details.php" class="text-success">
              <?php
                $Check = "SELECT SUM(CASE WHEN pay_status = 'IN' THEN amount ELSE NULL END) AS in_pay, SUM(CASE WHEN pay_status = 'OUT' THEN amount ELSE NULL END) AS out_pay FROM cash_history";
                $runCheck = mysqli_query($connection,$Check);
                $checkRow = mysqli_num_rows($runCheck);
                if($checkRow == 0)
                {
                  echo 0;
                }
                else
                {
                  $row = mysqli_fetch_array($runCheck);
                  $out_pay = $row['out_pay'];
                  $in_pay = $row['in_pay'];
                  $cash = $in_pay - $out_pay;
                  echo number_format($cash);
                }
              ?>
                
            </a></h3>
          <h5>Cash IN Hand</h5>
          <br>
          <a href="#debit" data-bs-toggle="modal" class="btn btn-success shadow">Cash IN</a>
          <a href="#credit" data-bs-toggle="modal" class="btn btn-danger shadow">Cash OUT</a>
        </div>

        <div class="text-center">

        </div>
          
      </div>
    </div>
  </div>
</section>
<?php include "include/footer.php"; ?>

<div class="modal fade" id="debit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered rounded mw-100 w-50" role="document">
    <div class="modal-content">
      <h2 class="bg-success p-2 text-white text-center">Cash IN</h2>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Date</label>
                <input type="date" name="inCash_date" value="<?php echo date('Y-m-d'); ?>" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Person Name</label>
                <select class="form-control" name="inCash_name" required>
                  <option value="">Choose</option>
                  <?php
                    $payType = "SELECT * FROM customer_in_out ORDER BY customer ASC";
                    $run_payType = mysqli_query($connection,$payType);
                    while ($row1=mysqli_fetch_array($run_payType))
                    {
                    ?>
                    <option value="<?php echo $row1['id']; ?>"> <?php echo $row1['customer']; ?> </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Contact</label>
                <input type="text" name="inCash_contact" placeholder="Contact No" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Payment Via</label>
                <select class="form-control" name="inCash_bank">
                  <option value="">Choose</option>
                  <?php
                    $payType = "SELECT * FROM payment_method ORDER BY method ASC";
                    $run_payType = mysqli_query($connection,$payType);
                    while ($row1=mysqli_fetch_array($run_payType))
                    {
                    ?>
                    <option value="<?php echo $row1['id']; ?>"> <?php echo $row1['method']; ?> </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Amount</label>
                <input type="number" name="inCash_amount" placeholder="Amount IN" class="form-control" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Slip No</label>
                <input type="text" name="in_slip_no" class="form-control" placeholder="Slip No">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Receipt</label>
                <input type="file" accept="image/*" name="in_recp_file" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Details</label>
                <textarea name="inCash_details" placeholder="Cash IN Details" class="form-control"></textarea>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-danger shadow" data-bs-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-success shadow" value="Pay" name="saveIn">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
  if(isset($_POST['saveIn']))
  {
    $inCash_date   = $_POST['inCash_date'];
    $inCash_amount      = $_POST['inCash_amount'];
    $inCash_details  = $_POST['inCash_details'];
    $pay_status  = "IN";

    $inCash_name  = $_POST['inCash_name'];

    $inCash_contact  = $_POST['inCash_contact'];
    $inCash_bank  = $_POST['inCash_bank'];
    $in_slip_no  = $_POST['in_slip_no'];

    $in_image      = $_FILES['in_recp_file']['name'];
    $in_temp_img   = $_FILES['in_recp_file']['tmp_name'];
    if($in_image == '')
    {
      $in_recp_file = '';
    }
    else
    {
      $in_recp_file = date("Y-m-d H-i").$in_image;
    }
    $in_pathImg    = "../../images/admin/cash_in_hand_recp/".$in_recp_file;

    $insert = "INSERT INTO `cash_history`(`amount`, `pay_status`, `details`, `pay_date`, `pay_person`, `contact`, `pay_type_id`, `slip_no`, `receipt`, `pay_by`, `cust_INOUT_id`) VALUES ('$inCash_amount','$pay_status','$inCash_details','$inCash_date','Direct IN','$inCash_contact','$inCash_bank','$in_slip_no','$in_recp_file', 'Direct Cash', '$inCash_name')";
    $run = mysqli_query($connection,$insert);
    if($run)
    {
      move_uploaded_file($in_temp_img,$in_pathImg);
      echo "<!DOCTYPE html>
        <html>
          <body>
            <script>
            Swal.fire(
            'Cash IN !',
            'Cash has been IN successfully',
            'success'
            ).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'cash_in_hand.php';
            }
            });
            </script>
          </body>
        </html>";
    }
  }
?>


<div class="modal fade" id="credit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered rounded mw-100 w-50" role="document">
    <div class="modal-content">
      <h2 class="bg-danger p-2 text-white text-center">Cash OUT</h2>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Date</label>
                <input type="date" name="outCash_date" value="<?php echo date('Y-m-d'); ?>" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Person Name</label>
                <select class="form-control" name="outCash_name" required>
                  <option value="">Choose</option>
                  <?php
                    $payType = "SELECT * FROM customer_in_out ORDER BY customer ASC";
                    $run_payType = mysqli_query($connection,$payType);
                    while ($row1=mysqli_fetch_array($run_payType))
                    {
                    ?>
                    <option value="<?php echo $row1['id']; ?>"> <?php echo $row1['customer']; ?> </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Contact</label>
                <input type="text" name="outCash_contact" placeholder="Contact No" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Payment Via</label>
                <select class="form-control" name="outCash_bank">
                  <option value="">Choose</option>
                  <?php
                    $payType = "SELECT * FROM payment_method ORDER BY method ASC";
                    $run_payType = mysqli_query($connection,$payType);
                    while ($row1=mysqli_fetch_array($run_payType))
                    {
                    ?>
                    <option value="<?php echo $row1['id']; ?>"> <?php echo $row1['method']; ?> </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Amount</label>
                <input type="number" name="outCash_amount" placeholder="Amount OUT" class="form-control" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Slip No</label>
                <input type="text" name="out_slip_no" class="form-control" placeholder="Slip No">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Receipt</label>
                <input type="file" accept="image/*" name="out_recp_file" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Details</label>
                <textarea name="outCash_details" placeholder="Cash OUT Details" class="form-control"></textarea>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-danger shadow" data-bs-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-success shadow" value="Pay" name="saveOut">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
  if(isset($_POST['saveOut']))
  {
    $outCash_date   = $_POST['outCash_date'];
    $outCash_amount      = $_POST['outCash_amount'];
    $outCash_details  = $_POST['outCash_details'];
    $pay_status  = "OUT";

    $outCash_name  = $_POST['outCash_name'];
    $outCash_contact  = $_POST['outCash_contact'];
    $outCash_bank  = $_POST['outCash_bank'];
    $out_slip_no  = $_POST['out_slip_no'];

    $out_image      = $_FILES['out_recp_file']['name'];
    $out_temp_img   = $_FILES['out_recp_file']['tmp_name'];
    if($out_image == '')
    {
      $out_recp_file = '';
    }
    else
    {
      $out_recp_file = date("Y-m-d H-i").$out_image;
    }
    $out_pathImg    = "../../images/admin/cash_in_hand_recp/".$out_recp_file;
    $insert = "INSERT INTO `cash_history`(`amount`, `pay_status`, `details`, `pay_date`, `pay_person`, `contact`, `pay_type_id`, `slip_no`, `receipt`, `pay_by`, `cust_INOUT_id`) VALUES ('$outCash_amount','$pay_status','$outCash_details','$outCash_date','Direct OUT','$outCash_contact','$outCash_bank','$out_slip_no','$out_recp_file','Direct Cash','$outCash_name')";
    $run = mysqli_query($connection,$insert);
    if($run)
    {
      move_uploaded_file($out_temp_img,$out_pathImg);
      echo "<!DOCTYPE html>
        <html>
          <body>
            <script>
            Swal.fire(
            'Cash OUT !',
            'Cash has been OUT successfully',
            'success'
            ).then((result) => {
            if (result.isConfirmed) {
             window.location.href = 'cash_in_hand.php';
            }
            });
            </script>
          </body>
        </html>";
    }
  }
?>