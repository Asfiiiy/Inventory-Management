<?php include("include/header.php") ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6 ms-2">
        <h4 class="mt-3 text-dark">Sale Details</h4>
      </div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid" class="text-center">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12 ">
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
                  <th>Customer</th>
                  <th>Total Sale Amount</th>
                  <th>Date</th>
                  <th width="9%">Action</th>
                </tr>
              </thead>
              <tbody class="table-font-size">
                <?php
                $count = 0;
                $query = "SELECT s.id, s.after_discount,s.sale_date, c.name,s.walk_in_cust_name  FROM sale AS s LEFT JOIN customer AS c ON c.id = s.customer_id ORDER BY s.id DESC";
                $result = mysqli_query($connection, $query);
                while ($rowData = mysqli_fetch_array($result)) {
                  $count++;
                  $sale_id   = $rowData['id'];
                  $customer   = $rowData['name'];
                  $customer_walk_in   = $rowData['walk_in_cust_name'];
                  $after_discount   = $rowData['after_discount'];
                  $sale_date   = date("d-m-Y", strtotime($rowData['sale_date']));

                ?>
                  <tr class="my-table-row-hover">
                    <td class="pt-2"><?php echo $count; ?></td>
                     <td class="pt-2"><?php echo $customer;  if($customer_walk_in==0){}else{echo" - "; echo $customer_walk_in;}?></td>
                    <td class="pt-2"><?php echo $after_discount; ?></td>
                    <td class="pt-2"><?php echo $sale_date; ?></td>
                    <td>
                      <a href="sale_items_detail.php?id=<?php echo $sale_id; ?>" class="mt-1 btn btn-primary shadow btn-sm title" title="Sale View"><i class="ps-1 bx bx-show"></i></a>

                      <a href="sale_print_details.php?id=<?php echo $sale_id; ?>" class="mt-1 btn btn-info shadow btn-sm title" title="Print View"><i class="ps-1 bx bx-printer"></i></a>

                      <a href="product_barcode.php?sale_id=<?php echo $sale_id ?>" class="Data_Ajax title btn btn-primary btn-sm" title="Bar Code"><i class="bx bx-barcode"></i></a>

                      <a class="btn btn-sm mt-1 btn-danger shadow text-white title" title="Delete" onclick="deleteData(<?php echo $sale_id ?>)"><span><i class="ps-1 bx bx-trash-alt"></i></span></a>
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
  function deleteData(sale_id) {
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
        window.location.href = "sale_details.php?saleId=" + sale_id;
      }
    });
  }
</script>
<?php
//////Deletion Query OF purchase Item And Stock

if (isset($_GET['saleId'])) {
  $saleId = $_GET['saleId'];

  $fetch1 = "SELECT id, product_id, quantity, cans FROM sale_items WHERE sale_id = '$saleId'";
  $runFetch1 = mysqli_query($connection, $fetch1);
  while ($row1 = mysqli_fetch_array($runFetch1)) {
    $product_id = $row1['product_id'];
    $sale_item_id = $row1['id'];
    $item_qty = $row1['quantity'];
    $cans_qty = $row1['cans'];

    $fetch2 = "SELECT id FROM stock_items WHERE product_id = '$product_id' AND quantity > 0 ORDER BY stock_date,product_id ASC LIMIT 1 ";
    $runFetch2 = mysqli_query($connection, $fetch2);
    $row2 = mysqli_fetch_array($runFetch2);
    $stock_id = $row2['id'];

    $sql3  = "UPDATE stock_items SET quantity = quantity + $item_qty, cans = cans + $cans_qty WHERE id = '$stock_id'";
    $run3 = mysqli_query($connection, $sql3);

    $sql4  = "DELETE FROM sale_items WHERE id = '$sale_item_id'";
    $run4 = mysqli_query($connection, $sql4);
  }

  $sql6  = "DELETE FROM customer_ledger WHERE sale_id = '$saleId'";
  $run6 = mysqli_query($connection, $sql6);

  $sql5  = "DELETE FROM sale WHERE id = '$saleId'";
  $run5 = mysqli_query($connection, $sql5);


  if ($run5) {
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
          window.location.href='sale_details.php';
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
?>