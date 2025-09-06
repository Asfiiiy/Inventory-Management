<?php include('include/db.php');
// production Date Wise Report
if (isset($_POST['purchase_from']) && isset($_POST['purchase_to'])) {
  $form = $_POST['purchase_from'];
  $to   = $_POST['purchase_to'];
?>
  <div class="table-responsive my-only-div-shadow py-4">
    <table class="table table-bordered data_table table-striped"   id="export_table">
      <thead class="my-table-style text-white">
        <tr>
          <th>S.No</th>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody class="table-font-size">
        <?php
        $serial  = 0;
        $query = mysqli_query($connection, "SELECT pro.product_name,pi.purchase_price,pi.quantity,pi.purchase_total,p.purchase_date FROM purchase AS p 
      INNER JOIN purchase_items AS pi ON pi.purchase_id= p.id
      INNER JOIN products AS pro ON pro.id = pi.product_id
        WHERE p.purchase_date BETWEEN '$form' AND '$to' ORDER BY p.purchase_date ASC");
        while ($row = mysqli_fetch_array($query)) {
          $pro = $row['product_name'];
          $price = $row['purchase_price'];
          $qty = $row['quantity'];
          $total = $row['purchase_total'];
          $rec_date = date('d-m-Y', strtotime($row['purchase_date']));
          $serial++;
        ?>
          <tr class="my-table-row-hover">
            <td class="pt-2"><?php echo $serial; ?></td>
            <td class="pt-2"><?php echo $pro; ?></td>
            <td class="used pt-2"><?php echo $price; ?></td>
            <td class="damaged pt-2"><?php echo $qty; ?></td>
            <td class="total"><?php echo $total; ?></td>
            <td class="pt-2"><?php echo $rec_date; ?></td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr style="background: grey; color: white">
          <b>
            <td colspan="2">Sum of Total</td>
            <td class="sumUsed"></td>
            <td class="sumDamaged"></td>
            <td  class="sumTotal"></td>
             <td  class=""></td>
          </b>
        </tr>
      </tfoot>

    </table>
  </div>
<?php }





// Purchase product Date Wise Report
if (isset($_POST['purchase_prod_from']) && isset($_POST['purchase_prod_to']) && isset($_POST['productId'])) {
  $from = $_POST['purchase_prod_from'];
  $to   = $_POST['purchase_prod_to'];
  $productId   = $_POST['productId'];
  //exit();
?>
  <table class="table table-bordered table-striped" id="export_table" data-page-length="100000000">
    <thead class="my-table-style text-white">
      <tr>
        <th>S.No</th>
        <th>Product</th>
        <th>Price Per Product</th>
        <th>Total Quantity</th>
        <th>Total Purchase Price</th>
       <!--  <th>Date</th> -->
      </tr>
    </thead>
    <tbody class="table-font-size">

    <!--   "SELECT pro.product_name,pi.purchase_price,pi.quantity,pi.purchase_total,p.purchase_date FROM purchase AS p  INNER JOIN purchase_items AS pi ON pi.purchase_id= p.id
     INNER JOIN products AS pro ON pro.id = pi.product_id WHERE (pi.product_id = '$productId' OR '$productId' = 'all')  AND p.purchase_date BETWEEN '$from' AND '$to' ORDER BY p.purchase_date, pro.product_name ASC "; -->


      <?php
      $serial  = 0;

     $q = "SELECT pro.product_name,pi.purchase_price,SUM(pi.quantity) as totalquantity,SUM(pi.purchase_total) as totalpurchase,p.purchase_date FROM purchase AS p INNER JOIN purchase_items AS pi ON pi.purchase_id= p.id INNER JOIN products AS pro ON pro.id = pi.product_id WHERE (pi.product_id = '$productId' OR '$productId' = 'all') AND p.purchase_date BETWEEN '$from' AND '$to' GROUP BY pi.product_id ORDER BY pro.product_name ASC ";

      $query = mysqli_query($connection,$q);
      while ($row = mysqli_fetch_array($query)) {
        $pro = $row['product_name'];
        $price = $row['purchase_price'];
        $qty = $row['totalquantity'];
        $total = $row['totalpurchase'];
        $rec_date = date('d-m-Y', strtotime($row['purchase_date']));
        $serial++;
      ?>
        <tr class="my-table-row-hover">
          <td class="pt-2"><?php echo $serial; ?></td>
          <td class="pt-2"><?php echo $pro; ?></td>
          <td class="used pt-2"><?php echo $price; ?></td>
          <td class="damaged pt-2"><?php echo $qty; ?></td>
          <td class="total pt-2"><?php echo $total; ?></td>
         <!--  <td class="pt-2"><?php echo $rec_date; ?></td> -->
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr style="background: grey; color: white">
        <b>
          <td>Sum of Total</td>
          <td></td>
          <td class="sumUsed"></td>
          <td class="sumDamaged"></td>
          <td colspan="1" class="sumTotal"></td>
          <!--  <td  class=""></td> -->
        </b>
      </tr>
    </tfoot>

  </table>
<?php }




// Purchase product Date Wise Report
if (isset($_POST['prod_avg_from']) && isset($_POST['prod_avg_to'])) {
  $from = $_POST['prod_avg_from'];
  $to   = $_POST['prod_avg_to'];
  $productId   = $_POST['productId'];
?>
  <table class="table table-bordered data_table table-striped" id="export_table" data-page-length="50">
    <thead class="my-table-style text-white">
      <tr>
        <th>S.No</th>
        <th>Product</th>
        <th>Average Price</th>
        <th>Quantity</th>
      </tr>
    </thead>
    <tbody class="table-font-size">
      <?php
      $serial  = 0;
      $query = mysqli_query($connection, "SELECT pt.product_name AS pro, SUM(pi.quantity) AS qty, SUM(pi.purchase_total) AS total,pi.product_id,p.purchase_date FROM purchase AS p 
  INNER JOIN purchase_items AS pi ON pi.purchase_id= p.id
  INNER JOIN products AS pt ON pt.id = pi.product_id
  
  WHERE (pi.product_id = '$productId' OR '$productId' = 'all') AND p.purchase_date BETWEEN '$from' AND '$to' GROUP BY pi.product_id ORDER BY pt.product_name ASC");
      while ($row = mysqli_fetch_array($query)) {
        $pro = $row['pro'];
        $qty = $row['qty'];
        $total = $row['total'];
        $avgPrice = ROUND(($total / $qty), 2);
        $serial++;
      ?>
        <tr class="my-table-row-hover">
          <td class="pt-2"><?php echo $serial; ?></td>
          <td class="pt-2"><?php echo $pro; ?></td>
          <td class="avg_prc pt-2"><?php echo $avgPrice; ?></td>
          <td class="quaty pt-2"><?php echo $qty; ?></td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr style="background: grey; color: white">
        <b>
          <td colspan="2">Sum of Total</td>
          <td class="sumAvg_prc"></td>
          <td class="sumQuaty"></td>
      </tr>
    </tfoot>

  </table>
<?php
}

// Purchase Cat Wise Report
if (isset($_POST['purchase_prod_from1']) && isset($_POST['purchase_prod_to1'])) {
  $form = $_POST['purchase_prod_from1'];
  $to   = $_POST['purchase_prod_to1'];
  $catId   = $_POST['catId'];
?>
  <table class="table table-bordered data_table table-striped" id="export_table" data-page-length="50">
    <thead class="my-table-style text-white">
      <tr>
        <th>S.No</th>
        <th>Category</th>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody class="table-font-size">
      <?php
      $serial1  = 0;
      $queryy = "SELECT pc.cat_name,p.title AS pro, u.title AS u_name, h.price, h.qty, h.total, h.purchase_date FROM purchase_history AS h INNER JOIN product AS p ON p.id = h.product_id LEFT JOIN units AS u ON u.id = p.unit_id LEFT JOIN product_cat AS pc ON pc.id = p.category_id WHERE pc.id='$catId' AND h.purchase_date BETWEEN '$form' AND '$to' ORDER BY h.purchase_date, p.title ASC";
      $result = mysqli_query($connection, $queryy);

      while ($row1 = mysqli_fetch_array($result)) {
        echo $cat_name = $row1['cat_name'];
        $pro = $row1['pro'];
        $u_name = $row1['u_name'];
        $price = $row1['price'];
        $qty = $row1['qty'];
        $total = $row1['total'];
        $rec_date = date('d-m-Y', strtotime($row1['purchase_date']));
        $serial1++;
      ?>
        <tr class="my-table-row-hover">
          <td class="pt-2"><?php echo $serial1; ?></td>
          <td class="pt-2"><?php echo $cat_name; ?></td>
          <td class="pt-2"><?php echo $pro . " (" . $u_name . ")"; ?></td>
          <td class="used pt-2"><?php echo $price; ?></td>
          <td class="damaged pt-2"><?php echo $qty; ?></td>
          <td class="total pt-2"><?php echo $total; ?></td>
          <td class="pt-2"><?php echo $rec_date; ?></td>
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

                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Purchase_report Excel',
                        text:'Export to excel',
                        footer:true

                       //  Columns to export
                       //  exportOptions: {
                       //     columns: [0, 1, 2, 3,4,5,6,7]
                       // }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Purchase_report PDF',
                        text: 'Export to PDF',
                        number: 'Export to PDF',
                        footer:true
                       
                       //  Columns to export
                       //  exportOptions: {
                       //     columns: [0, 1, 2, 3, 4, 5, 6,7]
                       // }

                    }



                ]

            });
                    
                    

    </script>
