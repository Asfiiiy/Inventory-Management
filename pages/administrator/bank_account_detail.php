<?php include("include/header.php") ?>
<div class="page-content container-fluid">
  <!--  Start Row  -->
  <div class="row">
    <div class="col-md-12">
      <h3>Bank Account Payment Details</h3>
    </div>
    <div class="col-md-12">
      <div class="card my-only-div-shadow">
        <div class="card-body table-responsive">
          <table class="table table-striped table-bordered datatable text-center my-only-div-shadow" data-page-length="25">
            <thead class="my-table-style text-white">
              <tr>
                <th>S.No</th>
                <th>Account Tittle</th>
                <th>Account No</th>
                <th>Total Amount</th>
              </tr>
            </thead>
            <tbody class="table-font-size">
              <?php
              $count = 0;
              $fetchData = "SELECT cbh.cash_in_bank_id,SUM(cbh.credit) AS totalcredit,SUM(cbh.debit) AS totaldebit,c.account_tittle,c.account_no 
                  FROM  cash_in_bank_history AS cbh
                  INNER JOIN cash_in_bank AS c ON  c.id =cbh.cash_in_bank_id 
                  GROUP BY cbh.cash_in_bank_id";
              $runData = mysqli_query($connection, $fetchData);
              while ($row2 = mysqli_fetch_array($runData)) {
               
                if ($row2['totalcredit'] == '') 
                  {
                    $totalcredit   = 0;
                  } 
                  else 
                  {
                    $totalcredit    = $row2['totalcredit'];
                  }
                  if ($row2['totaldebit'] == '')
                  {
                    $totaldebit   = 0;
                  } 
                  else 
                  {
                    $totaldebit    = $row2['totaldebit'];
                  }
                   $count++;
                   $account_tittle    = $row2['account_tittle'];
                   $account_no    = $row2['account_no'];
                   $id    = $row2['cash_in_bank_id'];
              ?>
                <tr class="my-table-row-hover">
                  <td class="pt-2"><?php echo $count; ?></td>
                  <td><a href="account_pay_detail.php?id=<?php echo $id ?>"><b><?php echo $account_tittle ?></b></a></td>
                  <td class="pt-2"><b><?php echo $account_no ?></b></td>
                  <td class="pt-2"><b><?php echo $totalcredit - $totaldebit ?></b></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("include/footer.php"); ?>