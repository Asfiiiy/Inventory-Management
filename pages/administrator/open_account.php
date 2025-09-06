<?php include("include/header.php") ?>
<div class="page-content">
  <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="m-0 text-dark">Open Account</h4>
      </div>
    </div>
  </div>
</div>
<section class="content" >
  <div class="container-fluid" class="text-center">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-dark">
          <br>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- form start -->
            <form method="post">
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Opening Balance</label>
                      <input type="number" name="balance" placeholder="Opening Balance In PKR" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Date</label>
                      <input type="date" name="open_date" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                    </div>
                  </div>
                </div>
                  
                <br>
                <div class="row">
                  <div class="col-md-12">
                    <center>
                    <input type="submit" class="btn btn-success shadow" value="Open Account" name="saveData">
                    </center>
                  </div>
                </div>
              </div>
            </form>
              <?php
              if(isset($_POST['saveData']))
              {
              $balance      = $_POST['balance'];
              $open_date     = $_POST['open_date'];

              $insert = "INSERT INTO `cash_in_hand`(`opening_balance`, `cash`, `opening_date`) VALUES ('$balance','$balance','$open_date')";
              $run = mysqli_query($connection,$insert);

              $insert2 = "INSERT INTO `cash_history`(`amount`, `pay_status`, `details`, `pay_date`) VALUES ('$balance','IN','Opening Balance','$open_date')";
              $run2 = mysqli_query($connection,$insert2);
              
              if($run2)
              {
              echo "<!DOCTYPE html>
              <html>
                <body>
                  <script>
                  Swal.fire(
                  'Opened !',
                  'Account has been opened successfully',
                  'success'
                  ).then((result) => {
                  if (result.isConfirmed) {
                  window.location.href= 'cash_in_hand.php';
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
                  'Account not open, Some error occure',
                  'error'
                  ).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href= 'open_account.php';
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
</div>
 
<?php include("include/footer.php") ?>
          