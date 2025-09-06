<?php include("include/header.php") ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="mt-3 text-dark">Purchase Details</h4>
      </div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-dark my-only-div-shadow" class="text-center">
          <div class="card-header">
          </div>
          <br>

          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <!-- table start -->
            <table class="table table-bordered table-striped text-center datatable my-only-div-shadow" data-page-length="50">
              <thead class="my-table-style text-white">
                <tr>
                  <th class="text-center">S.No</th>
                  <th class="text-left">Supplier Name</th>
                   <th>Total Balance</th>
                </tr>
              </thead>
              <tbody class="table-font-size">
                <?php
                $serial = 0;
                  $select2 = "SELECT sp.supplier_id,SUM(sp.credit) AS totalcredit,SUM(sp.debit) AS totaldebit,s.supplier_name,sp.Ldate FROM supplier_ledger AS sp
                INNER JOIN supplier AS s ON  s.id =sp.supplier_id GROUP BY sp.supplier_id";
                  $run2 = mysqli_query($connection, $select2);
                  while($row2 = mysqli_fetch_array($run2)){
                  $serial++;
                    $totalcredit    = $row2['totalcredit'];
                    $totaldebit    = $row2['totaldebit'];    
                   $supplier_name    = $row2['supplier_name'];
                   $payment_date    = $row2['Ldate'];
                   $id    = $row2['supplier_id'];
                ?>
                  <tr class="my-table-row-hover">
                    <td class="pt-2"><?php echo $serial; ?></td>
                    <td class="text-left pt-2"><a href="supplier_pay_details.php?id=<?php echo $id ?>"><?php echo $supplier_name ?></a></td>
                    <td class="pt-2"><b><?php echo number_format($totalcredit - $totaldebit); ?></b></td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
include("include/footer.php")
?>


<script>
  function deleteData(purchase_id) {
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
        window.location.href = "purchase_detail.php?purchaseId=" + purchase_id;
      }
    });
  }
</script>
<?php
if (isset($_GET['purchaseId'])) {
  $purchaseId = $_GET['purchaseId'];
  // SUM OF stock items and Purchase Items
  $fetch_stock = "SELECT SUM(si.quantity) AS stock_qty,SUM(pi.quantity) AS pi_quantity FROM stock_items AS si
   INNER JOIN purchase_items AS pi ON pi.id = si.purchase_item_id
   INNER JOIN purchase AS p ON p.id = pi.purchase_id
   WHERE p.id = '$purchaseId'";
  $runFetch_stock = mysqli_query($connection, $fetch_stock);
  $row_stock = mysqli_fetch_array($runFetch_stock);
  $stock_qty = $row_stock['stock_qty'];
  $pi_quantity = $row_stock['pi_quantity'];

  if ($pi_quantity == $stock_qty) {
    // DELETION OF STOCK ITEMS
    $sql1  = "DELETE si FROM `stock_items` AS si
    INNER JOIN purchase_items AS pi ON pi.id = si.purchase_item_id
    INNER JOIN purchase AS p ON p.id = pi.purchase_id WHERE p.id = '$purchaseId'";
    $run1 = mysqli_query($connection, $sql1);
    // DELETION OF PURCHASE ITEMS
    $sql2  = "DELETE FROM purchase_items WHERE purchase_id = '$purchaseId'";
    $run2 = mysqli_query($connection, $sql2);
    if ($run2) {
      // DELETION OF PURCHASE 
      $sql3  = "DELETE FROM purchase WHERE id = '$purchaseId'";
      $run3 = mysqli_query($connection, $sql3);
      if ($run3) {
        echo "<!DOCTYPE html>
          <html>
            <body>
              <script>
              Swal.fire(
              'Deleted!',
              'Purchase has been successfully deleted!',
              'success'
              ).then((result) => {
              if (result.isConfirmed) {
              window.location.href = 'purchase_detail.php'
              }
              });
              </script>
            </body>
          </html>";
      }
    }
  } elseif ($pi_quantity != $stock_qty) {
    echo "<!DOCTYPE html>
      <html>
      <body>
        <script>
        Swal.fire(
        'Error !',
        'This purchase cannot be Deleted because it is sale out !',
        'error'
        ).then((result) => {
        if (result.isConfirmed) {
        window.location.href='purchase_detail.php'
        }
        });
        </script>
      </body>
      </html>";
  }
}
?>