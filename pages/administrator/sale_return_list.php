<?php include("include/header.php") ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-1">
      <div class="col-md-6">
        <h4 class="text-dark">Return Product List</h4>
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
            <!-- <a href="sale_details.php" class="btn btn-success btn-sm">Back</a> -->
          </div>

          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <!-- table start -->
            <table class="table table-bordered text-center datatable table-striped my-only-div-shadow">
              <thead class="my-table-style text-white">
                <tr>
                  <th>S.No</th>
                  <th>Customer </th>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Discount </th>
                  <th width="">Return Price</th>
                  <th>Return Date</th>

                </tr>
              </thead>
              <tbody class="table-font-size">
                <?php
               
                $count = 0;
                $query = "select sr.id as sale_return_id,sr.customer_id,sr.product_id,sr.product_price as product_price,sr.discount as discount,sr.return_price as      return_price,sr.return_date as return_date,
                          c.id as customer_id,c.name as customer_name,
                          p.id as product_id,p.product_name as product_name
                          from sale_return as sr 
                          inner join customer as c
                          on c.id = sr.customer_id
                          inner join products as p 
                          on p.id = sr.product_id
                          ORDER BY sr.id ASC";
                $result = mysqli_query($connection, $query);
                $totalRows = mysqli_num_rows($result);
                while ($rowData = mysqli_fetch_array($result)) {
                  $count++;
                  $sale_return_id   = $rowData['sale_return_id'];
                  $customer_name   = $rowData['customer_name'];
                  $product_name   = $rowData['product_name'];
                  $product_price   = $rowData['product_price'];
                  $discount   = $rowData['discount'];
                  $return_price   = $rowData['return_price'];
                  $return_date   = $rowData['return_date'];

                ?>
                  <tr class="my-table-row-hover">
                    <td class="pt-2"><?php echo $count; ?></td>
                    <td class="pt-2"><?php echo $customer_name; ?></td>
                    <td class="pt-2"><?php echo $product_name; ?></td>
                    <td class="pt-2"><?php echo $product_price; ?></td>
                    <td class="pt-2"><?php echo $discount; ?></td>
                    <td class="pt-2"><?php echo $return_price; ?></td>
                    <td class="pt-2"><?php echo $return_date; ?></td>
                 <!--    <td>
                      <a href="sale_items_detail_update.php?id=<?php echo $sa_item_id ?>" class="btn btn-success btn-sm"><i class="ps-1 fa fa-edit"></i></a>

                      <a class="btn btn-sm btn-danger shadow text-white title" title="Delete" onclick="deleteData(<?php echo $sale_id ?>,<?php echo $sa_item_id ?>,<?php echo $product_id ?>,<?php echo $quantity ?>)"><span><i class="ps-1 bx bx-trash-alt"></i></span></a>
                    </td> -->
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


<!-- <script type="text/javascript">
  function deleteData(sale_id, sale_item_id, product_id, quantity) {
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
        window.location.href = "sale_items_detail.php?id=" + sale_id + "&sale_itemId=" + sale_item_id + "&quantity=" + quantity + "&pro_id=" + product_id;
      }
    });
  }
</script> -->
<?php
//////Deletion Query OF purchase Item And Stock

// if (isset($_GET['pro_id']) && ($_GET['id']) && ($_GET['sale_itemId']) && ($_GET['quantity'])) {
//   $pro_id = $_GET['pro_id'];
//   $saleId = $_GET['id'];
//   $sale_itemId = $_GET['sale_itemId'];
//   $quantity = $_GET['quantity'];

//   $fetch2 = "SELECT si.sale_id AS sales_Id,si.total_price FROM sale_items AS si WHERE si.id = '$sale_itemId'";
//   $runFetch2 = mysqli_query($connection, $fetch2);
//   $row2 = mysqli_fetch_array($runFetch2);
//   $sales_Id = $row2['sales_Id'];
//   $total_price = $row2['total_price'];

//   $sql3  = "UPDATE sale SET grand_total_sale = grand_total_sale - $total_price, after_discount = grand_total_sale - discount WHERE id = '$sales_Id'";
//   $run3 = mysqli_query($connection, $sql3);

//   $fetch3 = "SELECT after_discount FROM sale WHERE id = '$sales_Id'";
//   $runFetch3 = mysqli_query($connection, $fetch3);
//   $row3 = mysqli_fetch_array($runFetch3);
//   $after_discount = $row3['after_discount'];

//   $sql4  = "UPDATE customer_ledger SET debit = $after_discount WHERE sale_id = '$sales_Id'";
//   $run4 = mysqli_query($connection, $sql4);

//   $sql1  = "DELETE FROM sale_items WHERE id = '$sale_itemId'";
//   $run1 = mysqli_query($connection, $sql1);

//   $fetch = "SELECT id FROM stock_items WHERE product_id = '$pro_id' AND quantity > 0 ORDER BY stock_date,id ASC LIMIT 1 ";
//   $runFetch = mysqli_query($connection, $fetch);
//   $row = mysqli_fetch_array($runFetch);
//   $stock_id = $row['id'];
//   $sql2  = "UPDATE stock_items SET quantity = quantity + $quantity WHERE id='$stock_id'";
//   $run2 = mysqli_query($connection, $sql2);
//   if ($run2) {
//     echo "<!DOCTYPE html>
//         <html>
//           <body>
//             <script>
//             Swal.fire(
//             'Deleted!',
//             'Sale has been successfully deleted!',
//             'success'
//             ).then((result) => {
//             if (result.isConfirmed) {
//               window.location.href='sale_items_detail.php?id=$sale_id';
//             }
//             });
//             </script>
//           </body>
//         </html>";
//   } else {
//     echo "<!DOCTYPE html>
//       <html>
//       <body>
//         <script>
//         Swal.fire(
//         'Error !',
//         'This Sale cannot be Deleted',
//         'error'
//         ).then((result) => {
//         if (result.isConfirmed) {
//         }
//         });
//         </script>
//       </body>
//       </html>";
//   }
// }

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