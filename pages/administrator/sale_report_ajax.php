  <?php include('include/db.php');
if (isset($_POST['sale_from']) && isset($_POST['sale_to']) && isset($_POST['productId'])) {
  $from = $_POST['sale_from'];
  $to   = $_POST['sale_to'];
  $productId   = $_POST['productId'];
?>
  <div class="table-responsive my-only-div-shadow py-4">
      <table class="table table-bordered data_table table-striped" id="export_table" data-page-length="1000000000">
          <thead class="my-table-style text-white">
              <tr>
                  <th>S.No</th>
                  <th>Product</th>
                  <th>Price Per Product</th>
                  <!-- <th>Stock Quantity</th> -->
                  <th>Sale Weight/kg</th>
                  <th> Total Sale Price</th>
                  <!-- <th>Date</th> -->
              </tr>
          </thead>
          <tbody class="table-font-size">
              <!--  SELECT pro.product_name,si.price,si.stock_qty,si.quantity,si.total_price,s.sale_date FROM sale_items AS si INNER JOIN sale AS s ON s.id= si.sale_id INNER JOIN products AS pro ON pro.id = si.product_id  
      WHERE s.sale_date BETWEEN '$from' AND '$to'  AND (si.product_id = '$productId' OR '$productId' = 'all') ORDER by s.sale_date -->
              <?php
        $serial  = 0;
      $new ="SELECT pro.product_name,si.price,si.stock_qty,SUM(si.quantity) as totalquantity,SUM(si.total_price) as totalprice,s.sale_date FROM sale_items AS si INNER JOIN sale AS s ON s.id= si.sale_id INNER JOIN products AS pro ON pro.id = si.product_id WHERE s.sale_date BETWEEN '$from' AND '$to' AND (si.product_id = '$productId' OR '$productId' = 'all') GROUP by product_id ORDER BY pro.product_name ASC";

   $query = mysqli_query($connection,$new);
        while ($row = mysqli_fetch_array($query)) {
          $rec_date = date('d-m-Y', strtotime($row['sale_date']));
          $serial++;
        ?>
              <tr class="my-table-row-hover">
                  <td class="pt-2"><?php echo $serial; ?></td>
                  <td class="pt-2"><?php echo $row['product_name']; ?></td>
                  <td class="price pt-2"><?php echo $row['price']; ?></td>
                  <!-- <td class="stock_qty pt-2"><?php echo $row['stock_qty']; ?></td> -->
                  <td class="quantity pt-2"><?php echo  $row['totalquantity']; ?></td>
                  <td class="total"><?php echo $row['totalprice']; ?></td>
                  <!--  <td class="pt-2"><?php echo $rec_date; ?></td> -->
              </tr>
              <?php } ?>
          </tbody>
          <tfoot>
              <tr style="background: grey; color: white">
                  <b>
                      <td colspan="1" class="pt-2">Sum of Total</td>
                      <td colspan="1" class="pt-2"></td>
                      <td class="sumprice pt-2"></td>
                      <!-- <td class="sumStockqty pt-2"></td> -->
                      <td class="sumQuantity pt-2"></td>
                      <td colspan="1" class="sumTotal pt-2"></td>
                      <!--  <td colspan="1" class="pt-2"></td> -->
                  </b>
              </tr>
          </tfoot>

      </table>
  </div>
  <?php }
// Date wise sale
if (isset($_POST['sale_from_date']) && isset($_POST['sale_to_date'])) {
  $from_date = $_POST['sale_from_date'];
  $to_date   = $_POST['sale_to_date'];
?>
  <div class="table-responsive my-only-div-shadow py-4">
      <table class="table table-bordered data_table table-striped" id="export_table" data-page-length="100000000">
          <thead class="my-table-style text-white">
              <tr>
                  <th>S.No</th>
                  <th>Price</th>
                  <!-- <th>Price</th>
          <th>Stock Quantity</th>
          <th>Sale Quantity</th>
          <th>Sale Total</th> -->
                  <th>Date</th>
              </tr>
          </thead>
          <tbody class="table-font-size">
              <?php
        $serial  = 0;
         $query = mysqli_query($connection, "SELECT * from `sale` where sale_date BETWEEN '$from_date' AND '$to_date'  ORDER by sale_date");
        while ($row = mysqli_fetch_array($query)) {
        
          $serial++;
        ?>
              <tr class="my-table-row-hover">
                  <td class="pt-2"><?php echo $serial; ?></td>
                  <td class="price pt-2"><?php echo $row['after_discount']; ?></td>
                  <td class=" pt-2"><?php echo $row['sale_date']; ?></td>
                  <!-- <td class="stock_qty pt-2"><?php echo $row['stock_qty']; ?></td>
            <td class="quantity pt-2"><?php echo  $row['quantity']; ?></td>
            <td class="total"><?php echo $row['total_price']; ?></td>
            <td class="pt-2"><?php echo $rec_date; ?></td> -->
              </tr>
              <?php } ?>
          </tbody>
          <tfoot>
              <tr style="background: grey; color: white">
                  <b>
                      <td colspan="1" class="pt-2">Sum of Total</td>
                      <td class="sumprice pt-2"></td>
                      <td class=" pt-2"></td>
                      <!--  <td class="sumQuantity pt-2"></td>
            <td colspan="2" class="sumTotal pt-2"></td> -->
                  </b>
              </tr>
          </tfoot>

      </table>
  </div>
  <?php }







// Purchase Cat Wise Report
if (isset($_POST['purchase_prod_from1']) && isset($_POST['purchase_prod_to1'])) {
  $form = $_POST['purchase_prod_from1'];
  $to   = $_POST['purchase_prod_to1'];
  $catId   = $_POST['catId'];
?>
  <table class="table table-bordered data_table" id="export_table" data-page-length="100000000">
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
  <script type="text/javascript">
$('#export_table').dataTable({

    dom: 'Bfrtip',

    buttons: [{
            extend: 'excelHtml5',
            title: 'Sale_report Excel',
            text: 'Export to excel',
            footer: true

            //  Columns to export
            //  exportOptions: {
            //     columns: [0, 1, 2, 3,4,5,6,7]
            // }
        },
        {
            extend: 'pdfHtml5',
            title: 'Sale_report PDF',
            text: 'Export to PDF',
            number: 'Export to PDF',
            footer: true

            //  Columns to export
            //  exportOptions: {
            //     columns: [0, 1, 2, 3, 4, 5, 6,7]
            // }

        }



    ]

});
  </script>