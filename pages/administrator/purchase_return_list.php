<?php include("include/header.php") ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-1">
      <div class="col-md-6">
        <h4 class="text-dark">Return Purchase Product List</h4>
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
        <div class="card card-dark my-only-div-shadow">
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
                  <th>supplier</th>
                  <th>Product</th>
                  <th>Return Quantity</th>
                  <th>Return Price</th>
                  <th>Return Date</th>
                </tr>
              </thead>
              <tbody class="table-font-size">
                <?php
                $count = 0; 
                $query = "SELECT purchase_return.product_qty, purchase_return.return_price,purchase_return.return_date, supplier.supplier_name, products.product_name FROM purchase_return
JOIN supplier ON supplier.id = purchase_return.supplier_id
JOIN products ON products.id = purchase_return.product_id";
                $result = mysqli_query($connection, $query);
                while ($rowData = mysqli_fetch_array($result)) {
                  $count++;
                  $supplier_name = $rowData['supplier_name'];
                  $product_name = $rowData['product_name'];
                  $product_qty = $rowData['product_qty'];
                  $return_price = $rowData['return_price'];
                  $return_date = $rowData['return_date'];
                ?>
                  <tr class="my-table-row-hover">
                    <td class="pt-2"><?php echo $count; ?></td>
                    <td class="pt-2"><?php echo $supplier_name; ?></td>
                    <td class="pt-2"><?php echo $product_name; ?></td>
                    <td class="pt-2"><?php echo $product_qty; ?></td>
                    <td class="pt-2"><?php echo $return_price; ?></td>
                    <td class="pt-2"><?php echo $return_date; ?></td>
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
<?php include("include/footer.php") ?>
