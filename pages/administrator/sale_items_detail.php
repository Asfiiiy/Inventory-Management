<?php include("include/header.php") ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col-md-6">
                <h4 class="text-dark">Sale Items Details</h4>
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
                        <a href="sale_details.php" class="btn btn-success btn-sm">Back</a>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <!-- table start -->
                        <table class="table table-bordered text-center datatable table-striped my-only-div-shadow">
                            <thead class="my-table-style text-white">
                                <tr>
                                    <th>S.No</th>
                                    <th>Product </th>
                                    <th>Sale Price</th>
                                    <th>Weight/kg </th>
                                    <th>Sale Cans </th>
                                    <th>Sale Total </th>
                                    <th>Date</th>
                                    <th width="9%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-font-size">
                                <?php
                $sale_id = $_GET['id'];
                $count = 0;
                $query = "SELECT si.product_id,p.product_name,s.id AS sale_id,si.id AS sa_item_id,c.name,si.price,si.quantity,si.cans,si.total_price,s.sale_date FROM sale_items AS si

                          INNER JOIN sale AS s ON s.id = si.sale_id
                          LEFT JOIN customer AS c ON c.id = s.id
                          INNER JOIN products AS p ON p.id = si.product_id
                          WHERE si.sale_id='$sale_id' ORDER BY si.id DESC";
                $result = mysqli_query($connection, $query);
                $totalRows = mysqli_num_rows($result);
                while ($rowData = mysqli_fetch_array($result)) {
                  $count++;
                  $sale_id   = $rowData['sale_id'];
                  $sa_item_id   = $rowData['sa_item_id'];
                  $product_id   = $rowData['product_id'];
                  $product_name   = $rowData['product_name'];
                  $price   = $rowData['price'];
                  $quantity   = $rowData['quantity'];
                  $sale_cans = $rowData['cans'];
                  $total_price   = $rowData['total_price'];
                  $sale_date   = $rowData['sale_date'];

                ?>
                                <tr class="my-table-row-hover">
                                    <td class="pt-2"><?php echo $count; ?></td>
                                    <td class="pt-2"><?php echo $product_name; ?></td>
                                    <td class="pt-2"><?php echo $price; ?></td>
                                    <td class="pt-2"><?php echo $quantity; ?></td>
                                    <td class="pt-2"><?php echo $sale_cans; ?></td>
                                    <td class="pt-2"><?php echo $total_price; ?></td>
                                    <td class="pt-2"><?php echo $sale_date; ?></td>
                                    <td>
                                        <a href="sale_items_detail_update.php?id=<?php echo $sa_item_id ?>"
                                            class="btn btn-success btn-sm"><i class="ps-1 fa fa-edit"></i></a>

                                        <a class="btn btn-sm btn-danger shadow text-white title" title="Delete"
                                            onclick="deleteData(<?php echo $sale_id ?>,<?php echo $sa_item_id ?>,<?php echo $product_id ?>,<?php echo $quantity ?>,<?php echo $sale_cans ?>)"><span><i
                                                    class="ps-1 bx bx-trash-alt"></i></span></a>
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


<script type="text/javascript">
function deleteData(sale_id, sale_item_id, product_id, quantity, can_qty) {
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
            window.location.href = "sale_items_detail.php?id=" + sale_id + "&sale_itemId=" + sale_item_id +
                "&quantity=" + quantity + "&pro_id=" + product_id + "&can_qty=" + can_qty;
        }
    });
}
</script>
<?php
//////Deletion Query OF purchase Item And Stock

if (isset($_GET['pro_id']) && ($_GET['id']) && ($_GET['sale_itemId']) && ($_GET['quantity']) && ($_GET['can_qty']) ) {
  $pro_id = $_GET['pro_id'];
  $saleId = $_GET['id'];
  $sale_itemId = $_GET['sale_itemId'];
  $quantity = $_GET['quantity'];
  $can_qty = $_GET['can_qty'];

  $fetch2 = "SELECT si.sale_id AS sales_Id,si.total_price FROM sale_items AS si WHERE si.id = '$sale_itemId'";
  $runFetch2 = mysqli_query($connection, $fetch2);
  $row2 = mysqli_fetch_array($runFetch2);
  $sales_Id = $row2['sales_Id'];
  $total_price = $row2['total_price'];

  $sql3  = "UPDATE sale SET grand_total_sale = grand_total_sale - $total_price, after_discount = grand_total_sale - discount WHERE id = '$sales_Id'";
  $run3 = mysqli_query($connection, $sql3);

  $fetch3 = "SELECT after_discount FROM sale WHERE id = '$sales_Id'";
  $runFetch3 = mysqli_query($connection, $fetch3);
  $row3 = mysqli_fetch_array($runFetch3);
  $after_discount = $row3['after_discount'];

  $sql4  = "UPDATE customer_ledger SET debit = $after_discount WHERE sale_id = '$sales_Id'";
  $run4 = mysqli_query($connection, $sql4);

  $sql1  = "DELETE FROM sale_items WHERE id = '$sale_itemId'";
  $run1 = mysqli_query($connection, $sql1);

  $fetch = "SELECT id FROM stock_items WHERE product_id = '$pro_id' AND quantity > 0 ORDER BY stock_date,id ASC LIMIT 1 ";
  $runFetch = mysqli_query($connection, $fetch);
  $row = mysqli_fetch_array($runFetch);
  $stock_id = $row['id'];
  $sql2  = "UPDATE stock_items SET quantity = quantity + $quantity, cans = cans + $can_qty  WHERE id='$stock_id'";
  $run2 = mysqli_query($connection, $sql2);
  if ($run2) {
    echo "<!DOCTYPE html>
        <html>
          <body>
            <script>
            Swal.fire(
            'Deleted!',
            'Sale has been successfully deleted!',
            'success'
            ).then((result) => {
            if (result.isConfirmed) {
              window.location.href='sale_items_detail.php?id=$sale_id';
            }
            });
            </script>
          </body>
        </html>";
  } else {
    echo "<!DOCTYPE html>
      <html>
      <body>
        <script>
        Swal.fire(
        'Error !',
        'This Sale cannot be Deleted',
        'error'
        ).then((result) => {
        if (result.isConfirmed) {
        }
        });
        </script>
      </body>
      </html>";
  }
}

// if(isset($_GET['editId']))
// {
//   $editId = $_GET['editId'];
//   $purQty = $_GET['purQty'];
//   $fetch = "SELECT quantity FROM stock_items WHERE purchase_item_id = '$editId'";
//   $runFetch = mysqli_query($connection, $fetch);
//   $row = mysqli_fetch_array($runFetch);
//   $stkQty = $row['quantity'];

//   if($purQty == $stkQty)
//   {
//     echo "<script>window.location.href='purchase_item_view.php?pur_item_id=$editId'</script>";    
//   }
//   else
//   {
//     echo "<!DOCTYPE html>
//     <html>
//     <body>
//       <script>
//       Swal.fire(
//       'Error !',
//       'This purchase cannot be edit because it is sale out !',
//       'error'
//       ).then((result) => {
//       if (result.isConfirmed) {
//       window.location.href='purchase_items_detail.php?id=$purchase_id';
//       }
//       });
//       </script>
//     </body>
//     </html>";

//   }
// }
?>