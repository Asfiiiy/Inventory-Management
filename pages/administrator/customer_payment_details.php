<?php include("include/header.php") ?>
<div class="page-content container-fluid">
  <!--  Start Row  -->
  <div class="row">
    <div class="col-md-12">
      <h3>Customer Payment Details</h3>
    </div>
    <div class="col-md-12">
      <div class="card my-only-div-shadow">
        <div class="card-body table-responsive">
          <table class="table table-striped table-bordered datatable text-center my-only-div-shadow" data-page-length="25">
            <thead class="my-table-style text-white">
              <tr>
                <th>S.No</th>
                <th>Customer Name</th>
                <th>Total Amount</th>

              </tr>
            </thead>
            <tbody class="table-font-size">
              <?php
              $count = 0;
              $grandTotal=0;
              $totalamount=0;
              $fetchData = "SELECT cp.customer_id,SUM(cp.credit) AS totalcredit,SUM(cp.debit) AS totaldebit,c.name,cp.Ldate FROM customer_ledger AS cp
                INNER JOIN customer AS c ON  c.id =cp.customer_id GROUP BY cp.customer_id";
              $runData = mysqli_query($connection, $fetchData);
              while ($row2 = mysqli_fetch_array($runData)) {
                $count++;
                if ($row2['totalcredit'] == '') {
                    $totalcredit   = 0;
                  } else {
                    $totalcredit    = $row2['totalcredit'];
                  }
                  if ($row2['totaldebit'] == '') {
                    $totaldebit   = 0;
                  } else {
                    $totaldebit    = $row2['totaldebit'];
                  }
                   $name    = $row2['name'];
                   $payment_date    = $row2['Ldate'];
                   $id    = $row2['customer_id'];
                


              ?>
         <?php
                $totalamount= $totalcredit - $totaldebit;
                $grandTotal+= $totalamount;
         ?>
                <tr class="my-table-row-hover">
                  <td class="pt-2"><?php echo $count ?></td>
                  <td><a href="customer_payment_history.php?id=<?php echo $id ?>"><b><?php echo $name ?></b></a></td>

                  <td class="pt-2"><b><?php echo $totalcredit - $totaldebit ?></b></td>

                </tr>
             
              <?php } ?>
              <tr>
              <td style="" colspan="2"><span style="float:right;"><strong>Total:</strong>&nbsp;</span></td>
                <td style=""><strong><?php echo $grandTotal?></strong></td>

                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- End Row  -->
</div>
<?php include("include/footer.php") ?>