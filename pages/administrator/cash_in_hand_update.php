<?php
include "include/header.php";
?>

<section class="content" >
  <div class="container-fluid" class="text-center">
    <br>
    <h4 class="text-center">Edit Cash IN Hand</h4>
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow my-only-div-shadow">
          <div class="card-header my-table-style">
            <div class="card-title  text-white pt-2">Edit From</div>
          </div>
          <div class="card-body">
            <?php
            $cashId = $_GET['id'];
            $select1 = "SELECT p.id,cio.id AS customer_id, c.pay_date, cio.customer, c.contact, p.method, c.amount, c.pay_status, c.slip_no, c.details, c.receipt, c.pay_by FROM cash_history AS c LEFT JOIN payment_method AS p ON p.id = c.pay_type_id LEFT JOIN customer_in_out AS cio ON cio.id = c.pay_person  WHERE c.id = '$cashId'";
            $run1 = mysqli_query($connection,$select1);
            $row = mysqli_fetch_array($run1);

            $payment_dateU = $row['pay_date'];
            $customerU = $row['customer'];
            $customer_id = $row['customer_id'];
            $contactU = $row['contact'];
            $bank_nameU = $row['method'];
            $bank_idU = $row['id'];
            $amountU = $row['amount'];
            $pay_statusU = $row['pay_status'];
            $slip_noU = $row['slip_no'];
            $detailsU = $row['details'];
            $pay_byU = $row['pay_by'];
            $receiptU = $row['receipt'];
            $pathImgU    = "../../images/admin/cash_in_hand_recp/".$receiptU;
            ?>
            <form method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="Cash_date" value="<?php echo  $payment_dateU ?>" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Person Name</label>
                <select class="form-control" name="Cash_name" required>
                  <option value="">Choose</option>
                  <?php
                    $payType = "SELECT * FROM customer_in_out";
                    $run_payType = mysqli_query($connection,$payType);
                    while ($row2=mysqli_fetch_array($run_payType))
                    {
                    ?>
                    <option <?php if($customer_id == $row2['id']) { echo "selected"; } ?> value="<?php echo $row2['id']; ?>"> <?php echo $row2['customer']; ?> </option>
                      <?php } ?>
                </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Contact</label>
                    <input type="text" value="<?php echo $contactU ?>" name="Cash_contact" placeholder="Contact No" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Payment Via</label>
                    <select class="form-control" name="Cash_bank">
                      <option value="">Choose</option>
                      <?php
                        $payType = "SELECT * FROM payment_method ORDER BY method ASC";
                        $run_payType = mysqli_query($connection,$payType);
                        while ($row1=mysqli_fetch_array($run_payType))
                        {
                        ?>
                        <option <?php if($bank_idU == $row1['id']) { echo "selected"; } ?> value="<?php echo $row1['id']; ?>"> <?php echo $row1['method']; ?> </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Amount</label>
                    <input type="number" value="<?php echo $amountU ?>" name="Cash_amount" placeholder="Amount" class="form-control" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Slip No</label>
                    <input type="text" value="<?php echo $slip_noU ?>" name="slip_no" class="form-control" placeholder="Slip No">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Receipt</label>
                    <input type="file" accept="image/*" name="recp_file" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Details</label>
                    <textarea name="Cash_details" placeholder="Cash IN Details" class="form-control"><?php echo $detailsU ?></textarea>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12 text-center">
                  <a href="cash_in_hand_details.php" class="btn btn-danger shadow">Close</a>
                  <input type="submit" class="btn btn-success shadow" value="Update" name="saveData">
                </div>
              </div>
            </form>
            <?php
              if(isset($_POST['saveData']))
              {
                $Cash_date   = $_POST['Cash_date'];
                $Cash_amount      = $_POST['Cash_amount'];
                $Cash_details  = $_POST['Cash_details'];
                $Cash_name  = $_POST['Cash_name'];
                $Cash_contact  = $_POST['Cash_contact'];
                $Cash_bank  = $_POST['Cash_bank'];
                $slip_no  = $_POST['slip_no'];

                $image      = $_FILES['recp_file']['name'];
                $temp_img   = $_FILES['recp_file']['tmp_name'];
                if($image == '')
                {
                  $recp_file = $receiptU;
                }
                else
                {
                  $recp_file = date("Y-m-d H-i").$image;
                  $pathImg    = "../../images/admin/cash_in_hand_recp/".$recp_file;
                  unlink($pathImgU);
                  move_uploaded_file($temp_img,$pathImg);
                }
                

               $update = "UPDATE `cash_history` SET `amount` = '$Cash_amount', `details` = '$Cash_details', `pay_date` = '$Cash_date', `cust_INOUT_id` = '$Cash_name', `contact` = '$Cash_contact', `pay_type_id` = '$Cash_bank', `slip_no` = '$slip_no', `receipt` = '$recp_file' WHERE id = '$cashId'";
                $run = mysqli_query($connection,$update);
                

                if($run)
                {
                  
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
                          window.location.href = 'cash_in_hand_details.php';
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




