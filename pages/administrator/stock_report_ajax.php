  <?php include('include/db.php');
if ( isset($_POST['productId'])) {
  $from = $_POST['sale_from'];
  $to   = $_POST['sale_to'];
  $productId   = $_POST['productId'];
?>
  <div class="table-responsive my-only-div-shadow py-4">
    <table class="table table-bordered data_table table-striped" id="export_table" data-page-length="100000000">
      <thead class="my-table-style text-white">
        <tr>
          <th>S.No</th>
                  <th>Product</th>
                  <th>Buying Quantity</th>
                  <th>Sale Quantity</th>
                  <th>Stock Quantity</th>
                  <th>T Purchase Price</th>
                <!--<th>T Sale Price </th> -->
        </tr>
      </thead>
      <tbody class="table-font-size">
<!-- SELECT p.product_name AS pro_name,(SUM(s.quantity)) as totalquantity ,s.stock_date,SUM(s.sale_price*s.quantity) AS saleprice,SUM(s.purchase_price*s.quantity) AS purchaseprice FROM stock_items AS s INNER JOIN products AS p ON p.id = s.product_id WHERE s.stock_date BETWEEN '$from' AND '$to' AND (s.product_id = '$productId' OR '$productId' = 'all') GROUP BY s.product_id ORDER BY p.product_name ASC -->

        <?php
        $serial  = 0;
 

    $new ="SELECT p.product_name AS product_name,(SUM(pi.quantity)) as opening_stock, SUM(pi.total_cans) AS t_p_cans, SUM(s.cans) AS t_stck_cans,(SUM(s.quantity)) as current_stock,
    ((SUM(pi.quantity))-(SUM(s.quantity))) as closing_stock,SUM(si.total_price) AS sale_price,
    SUM(pi.purchase_total) AS purchase_price FROM stock_items AS s
    INNER JOIN purchase_items AS pi ON pi.id = s.purchase_item_id 
    INNER JOIN sale_items AS si ON si.product_id= pi.product_id 
    INNER JOIN products AS p ON p.id = s.product_id WHERE s.stock_date BETWEEN '$from' AND '$to' AND (s.product_id = '$productId' OR '$productId' = 'all') 
    group BY s.product_id ORDER by p.product_name ASC";

   $query = mysqli_query($connection,$new);
   $total_rem_can=0;
   $total_opening_stock=0;
   $total_closing_stock=0;
   $total_current_stock=0;
   $total_saleprice=0;
   $total_purchaseprice=0;
   $g_pur_cans =0;
   $g_stk_cans =0;
   $g_rem_cans =0;
        while ($row = mysqli_fetch_array($query)) {
          $saleprice = $row['sale_price'];
          $total_saleprice+=$saleprice;

           $purchaseprice = $row['purchase_price'];
           $total_purchaseprice+=$purchaseprice;

           $opening_stock=$row['opening_stock'];
           $total_opening_stock+=$opening_stock;

           $closing_stock=$row['closing_stock'];
           $total_closing_stock+=$closing_stock;

           $current_stock=$row['current_stock'];
           $total_current_stock+= $current_stock;

           $total_pur_cans = $row['t_p_cans'];
           $total_stk_cans = $row['t_stck_cans'];
           $total_rem_can = $total_pur_cans-$total_stk_cans;

           $g_pur_cans+=$total_pur_cans;
           $g_stk_cans+=$total_stk_cans;
           $g_rem_cans+=$total_rem_can;
          $serial++;
        ?>
          <tr class="my-table-row-hover">
            <td class="pt-2"><?php echo $serial; ?></td>
            <td class="pt-2"><?php echo $row['product_name']; ?></td>
            <td ><?php echo $opening_stock; ?> KG&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $total_pur_cans;?> Cans</td>
           <td ><?php echo $closing_stock; ?> KG&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $total_rem_can;?> Cans</td>  
           <td><?php echo $current_stock; ?> KG&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $total_stk_cans;?> Cans</td>

            <td class=""><?php echo  $purchaseprice; ?></td>
            <!-- <td class=""><?php echo  $saleprice ; ?></td> -->
          </tr>
        <?php } ?>
      </tbody>


      <tfoot>
        <tr style="background: grey; color: white">
          <b>
            <td colspan="2" class=""><span style="float:right;"><strong>Sum of Total:</strong></span></td>
            <td><strong><?php echo $total_opening_stock;?> KG&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $g_pur_cans;?> Cans</strong></td>
            <td><strong><?php echo $total_closing_stock;?> KG&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $g_rem_cans;?> Cans</strong></td>
            <td><strong><?php echo $total_current_stock;?> KG&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $g_stk_cans;?> Cans</strong></td>
            <td><strong><?php echo $total_purchaseprice;?></strong></td>
            <!-- <td><strong><?php echo $total_saleprice;?></strong></td> -->
          </b>
        </tr>
      </tfoot>

    </table>
  </div>
<?php }
// Date wise sale

?>
 <script type="text/javascript">
       $('#export_table').dataTable({
               
                dom: 'Bfrtip',

                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Stock_report Excel',
                        text:'Export to excel',
                        footer:true

                       //  Columns to export
                       //  exportOptions: {
                       //     columns: [0, 1, 2, 3,4,5,6,7]
                       // }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Stock_report PDF',
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