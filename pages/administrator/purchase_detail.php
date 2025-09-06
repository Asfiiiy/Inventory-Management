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
  <div class="container-fluid" class="text-center">
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
            <table class="table table-bordered text-center datatable table-striped my-only-div-shadow">
              <thead class="my-table-style text-white">
                <tr>
                  <th>S.No</th>
                  <th>Supplier </th>
                  <th>Total Amount</th>
                  <th>Date </th>
                  <th width="9%">Action</th>
                </tr>
              </thead>
              <tbody class="table-font-size">
                <?php
                $count = 0;
                $query = "SELECT *,p.id AS pur_id,pi.id FROM purchase AS p 
                   LEFT JOIN supplier AS s ON s.id = p.supplier_id
                   LEFT JOIN purchase_items AS pi ON pi.purchase_id = p.id GROUP BY p.id
                   ORDER BY p.id DESC";
                $result = mysqli_query($connection, $query);
                while ($rowData = mysqli_fetch_array($result)) {
                  $count++;
                  $id   = $rowData['id'];
                  $purchase_id   = $rowData['pur_id'];
                  $supplier_name   = $rowData['supplier_name'];
                  $after_discount_purchase   = $rowData['after_discount_purchase'];
                  $date   = date("d-m-Y", strtotime($rowData['purchase_date']));

                ?>
                  <tr class="my-table-row-hover">
                    <td class="pt-2"><?php echo $count; ?></td>
                    <td class="pt-2"><?php echo $supplier_name; ?></td>
                    <td class="pt-2"><?php echo $after_discount_purchase; ?></td>
                    <td class="pt-2"><?php echo $date; ?></td>
                    <td>
                      <a href="purchase_items_detail.php?id=<?php echo $purchase_id; ?>" class="mt-1 btn btn-primary shadow btn-sm title" title="Purchase View"><i class="bx bx-show"></i></a>
                      <a class="btn btn-sm mt-1 btn-danger shadow text-white title" title="Delete" onclick="deleteData(<?php echo $purchase_id; ?>)"><span><i class="bx bx-trash-alt"></i></span></a>
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
      $sql4  = "DELETE FROM supplier_ledger WHERE purchase_id = '$purchaseId'";
      $run4 = mysqli_query($connection, $sql4);
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