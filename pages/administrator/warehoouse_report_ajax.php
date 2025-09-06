<?php include('include/db.php');
// sale Date Wise Report
if (isset($_POST['warehouseId'])) {
  $warehouseId = $_POST['warehouseId'];
?>
        <hr>
        <div class="row">
          <div class="col-md-12 my-only-div-shadow py-4">
            <div class="table-responsive" style="overflow-x:hidden !important;">
              <table class="table table-striped text-center table-bordered table-hover datatable my-only-div-shadow" id="export_table" data-page-length="10000000">
                <thead class="my-table-style printcolor text-white">
                  <tr>
                    <th>S.No</th>
                    <th>Product</th>
                    <th>quantity</th>
                   <th>date</th>
                  </tr>
                </thead>
                <tbody class="table-font-size">
                  <?php
                  $serial = 0;
                  $sumcredit = 0;
                  $sumdebit = 0;
                  $select1 = "SELECT p.product_name,s.quantity,h.warehouse,s.stock_date FROM `stock_items`  AS s
INNER JOIN ware_house AS h ON h.id = s.warehouse_id
INNER JOIN products AS p ON p.id = s.product_id
              WHERE s.warehouse_id = '$warehouseId'";
                  $run1 = mysqli_query($connection, $select1);
                  while ($row = mysqli_fetch_array($run1)) {
                    $serial++;
                          $product_name = $row['product_name'];
                          $quantity = $row['quantity'];
                          $stock_date = $row['stock_date'];
                  ?>
                    <tr class="my-table-row-hover">
                      <td class="pt-2"><?php echo $serial; ?></td>
                      <td class="pt-2"><?php echo $product_name ?></td>
                      <td class="pt-2"><?php echo $quantity ?></td>
                      <th class="pt-2"><?php echo $stock_date ?></th>
                      
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
                 <footer class="mt-5">
            <div class="container">
                 <div class="row printBlock">
          <div class="col-md-12 text-center">
            <!-- <button class="btn btn-primary" id="printBtn">Print</button> -->
           <!--  <button class="btn btn-danger" onclick="window.location.href = 'party_payment_list.php'">Close</button> -->
           <!--   <button type="button" class="btn btn-success shadow" onclick="export_all()">Export To CSV</button> -->
          </div>
        </div>
    </div>
            </footer>
        </div>
        <br>
<?php }






// Purchase Cat Wise Report
if (isset($_POST['purchase_prod_from1']) && isset($_POST['purchase_prod_to1'])) {
  $form = $_POST['purchase_prod_from1'];
  $to   = $_POST['purchase_prod_to1'];
  $catId   = $_POST['catId'];
?>
  <table class="table table-bordered data_table" id="export_table" data-page-length="50">
    <thead>
      <tr style="background: #000; color: #fff">
        <th>S.No</th>
        <th>Category</th>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $serial1  = 0;
      $queryy = "SELECT pc.cat_name,p.title AS pro, u.title AS u_name, h.price, h.qty, h.total, h.purchase_date FROM purchase_history AS h INNER JOIN product AS p ON p.id = h.product_id LEFT JOIN units AS u ON u.id = p.unit_id LEFT JOIN product_cat AS pc ON pc.id = p.category_id WHERE pc.id='$catId' AND h.purchase_date BETWEEN '$form' AND '$to' ORDER BY h.purchase_date, p.title ASC";
      $result = mysqli_query($connection, $queryy);

      while ($row1 = mysqli_fetch_array($result)) {
        echo $cat_name = $row1['cat_name'];
        $pro = $row1['pro'];
        $price = $row1['price'];
        $qty = $row1['qty'];
        $total = $row1['total'];
        $rec_date = date('d-m-Y', strtotime($row1['purchase_date']));
        $serial1++;
      ?>
        <tr>
          <td><?php echo $serial1; ?></td>
          <td><?php echo $cat_name; ?></td>
          <td><?php echo $pro; ?></td>
          <td class="used"><?php echo $price; ?></td>
          <td class="damaged"><?php echo $qty; ?></td>
          <td class="total"><?php echo $total; ?></td>
          <td><?php echo $rec_date; ?></td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr style="background: grey; color: white">
        <b>
          <td colspan="3">Sum of Total</td>
          <td class="sumUsed"></td>
          <td class="sumDamaged"></td>
          <td colspan="2" class="sumTotal"></td>
        </b>
      </tr>
    </tfoot>

  </table>
<?php }

?>