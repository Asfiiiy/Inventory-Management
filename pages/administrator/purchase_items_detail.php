<?php include("include/header.php") ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6">
                <h4 class="mt-3 text-dark">Purchase Items Details</h4>
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
                                    <th>Product </th>
                                    <th>Purchase Price</th>
                                    <th>Weight/kg</th>
                                    <th>Total Cans</th>
                                    <th>Purchase Total </th>
                                    <th>Date</th>
                                    <th width="9%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-font-size">
                                <?php
                $purchase_id = $_GET['id'];
                $count = 0;
                $query = "SELECT p.id AS pur_Id,p.purchase_date,pro.product_name,pi.id, pi.purchase_price,pi.quantity,pi.total_cans, pi.purchase_total FROM purchase_items AS pi
                     INNER JOIN purchase AS p ON p.id = pi.purchase_id
                     INNER JOIN products AS pro ON pro.id = pi.product_id WHERE pi.purchase_id='$purchase_id' ORDER BY pi.id DESC";
                $result = mysqli_query($connection, $query);
                $totalRows = mysqli_num_rows($result);
                while ($rowData = mysqli_fetch_array($result)) {
                  $count++;
                  $id   = $rowData['id'];
                  $pur_Id   = $rowData['pur_Id'];
                  $product_name   = $rowData['product_name'];
                  $purchase_price   = $rowData['purchase_price'];
                  $qty   = $rowData['quantity'];
                  $total_cans = $rowData['total_cans'];
                  $purchase_total   = $rowData['purchase_total'];
                  $purchase_date   = $rowData['purchase_date'];

                ?>
                                <tr class="my-table-row-hover">
                                    <td class="pt-2"><?php echo $count; ?></td>
                                    <td class="pt-2"><?php echo $product_name; ?></td>
                                    <td class="pt-2"><?php echo $purchase_price; ?></td>
                                    <td class="pt-2"><?php echo $qty; ?></td>
                                    <td class="pt-2"><?php echo $total_cans; ?></td>
                                    <td class="pt-2"><?php echo $purchase_total; ?></td>
                                    <td class="pt-2"><?php echo $purchase_date; ?></td>
                                    <td>
                                        <a href="purchase_items_detail.php?id=<?php echo $purchase_id ?>&editId=<?php echo $id ?>&purQty=<?php echo $qty ?>"
                                            class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                        <?php if ($totalRows > 1) { ?>
                                        <a class="btn btn-sm mt-1 btn-danger shadow text-white title" title="Delete"
                                            onclick="deleteData(<?php echo $id ?>,<?php echo $pur_Id ?>,<?php echo $qty ?>)"><span><i
                                                    class="bx bx-trash-alt"></i></span></a>
                                        <?php } ?>
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
function deleteData(id, pur_Id, qty) {
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
            window.location.href = "purchase_items_detail.php?deleteId=" + id + "&id=" + pur_Id + "&quantity=" +
                qty;
        }
    });
}
</script>

<?php
if (isset($_GET['editId'])) {
  $editId = $_GET['editId'];
  $purQty = $_GET['purQty'];
  $fetch = "SELECT quantity FROM stock_items WHERE purchase_item_id = '$editId'";
  $runFetch = mysqli_query($connection, $fetch);
  $row = mysqli_fetch_array($runFetch);
  $stkQty = $row['quantity'];

  if ($purQty == $stkQty) {
    echo "<script>window.location.href='purchase_item_view.php?pur_item_id=$editId'</script>";
  } else {
    echo "<!DOCTYPE html>
    <html>
    <body>
      <script>
      Swal.fire(
      'Error !',
      'This purchase cannot be edit because it is sale out !',
      'error'
      ).then((result) => {
      if (result.isConfirmed) {
      window.location.href='purchase_items_detail.php?id=$purchase_id';
      }
      });
      </script>
    </body>
    </html>";
  }
}
//////Deletion Query OF purchase Item And Stock

if (isset($_GET['deleteId'])) {
  $deleteId = $_GET['deleteId'];
  $quantity = $_GET['quantity'];
  $fetch = "SELECT quantity FROM stock_items WHERE purchase_item_id = '$deleteId'";
  $runFetch = mysqli_query($connection, $fetch);
  $row = mysqli_fetch_array($runFetch);
  $stkQty = $row['quantity'];

  if ($quantity == $stkQty) {

    $fetch2 = "SELECT pi.purchase_id AS purcha_Id,pi.purchase_total FROM purchase_items AS pi WHERE pi.id = '$deleteId'";
    $runFetch2 = mysqli_query($connection, $fetch2);
    $row2 = mysqli_fetch_array($runFetch2);
    $purcha_Id = $row2['purcha_Id'];
    $purchase_total = $row2['purchase_total'];

    $sql3  = "UPDATE purchase SET purchase_grand_total = purchase_grand_total - $purchase_total, after_discount_purchase = purchase_grand_total - total_discount WHERE id = '$purcha_Id'";
    $run3 = mysqli_query($connection, $sql3);

    $fetch3 = "SELECT after_discount_purchase FROM purchase WHERE id = '$purcha_Id'";
    $runFetch3 = mysqli_query($connection, $fetch3);
    $row3 = mysqli_fetch_array($runFetch3);
    $after_discount_purchase = $row3['after_discount_purchase'];

    $sql4  = "UPDATE supplier_ledger SET debit = $after_discount_purchase WHERE purchase_id = '$purcha_Id'";
    $run4 = mysqli_query($connection, $sql4);

    $sql1  = "DELETE FROM purchase_items WHERE id = '$deleteId'";
    $run1 = mysqli_query($connection, $sql1);
    if ($run1) {
      $sql2  = "DELETE FROM stock_items WHERE purchase_item_id = '$deleteId'";
      $run2 = mysqli_query($connection, $sql2);
      if ($run2) {
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
              window.location.href='purchase_items_detail.php?id=$purchase_id';
            }
            });
            </script>
          </body>
        </html>";
      }
    }
  } elseif ($quantity != $stkQty) {
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
        window.location.href='purchase_items_detail.php?id=$purchase_id';
        }
        });
        </script>
      </body>
      </html>";
  }
}
?>