<?php include('include/db.php');
// sale Date Wise Report
if (isset($_POST['supplierId'])) {
  $supplierId = $_POST['supplierId'];
?>
<?php
   $select1 = "SELECT SUM(s.credit) AS sumCreidt,SUM(s.debit) AS sumDebit,sup.supplier_name,sup.supplier_contact,sup.supplier_address FROM supplier_ledger AS s LEFT JOIN supplier AS sup ON sup.id = s.supplier_id  WHERE s.supplier_id  = '$supplierId'";
        $run1 = mysqli_query($connection, $select1);
        $row = mysqli_fetch_array($run1);
        $name = $row['supplier_name'];
        $sumCreidt = $row['sumCreidt'];
        $sumDebit = $row['sumDebit'];
        $mobile = $row['supplier_contact'];
        $address = $row['supplier_address'];
        ?>

        <input type="hidden" id="supId" value="<?php echo $supplierId ?>">
            <!-- <h3 style="margin-top:50px">Customer Payment Details</h3> -->
          </div>
        </div>
        <hr class="shadow" style="border: 1px solid grey;">

        <div class="row my-only-div-shadow py-4">
          <div class="col-md-12">
            <table class="table_print" width="100%">
              <tr>
          <td>Customer : <b><?php echo $name ?></b></td>
          <td>Contact : <b><?php echo $mobile ?></b></td>
          <td>Address : <b><?php echo $address ?></b></td>
        </tr>
        <tr>
          <td>Total Balance (Rs) : <b><?php echo number_format( $sumCreidt - $sumDebit ); ?></b></td>
          <td>Total Credit (Rs) : <b><?php echo number_format($sumCreidt); ?></b></td>
        <td>Total Debit (Rs) : <b><?php echo number_format($sumDebit); ?></b></td>
      </tr>
       </table>
       </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 my-only-div-shadow py-4">
            <div class="table-responsive" style="overflow-x:hidden !important;">
              <table class="table table-striped text-center table-bordered table-hover datatable my-only-div-shadow" id="export_table" data-page-length="10000000">
                <thead class="my-table-style printcolor text-white">
                  <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Detail</th>
                   <th>Credit</th>
                    <th>Debit</th>
                    <th>Balance</th>
                  </tr>
                </thead>
                <tbody class="table-font-size">
                  <?php
                  $serial = 0;
                  $sumcredit = 0;
                  $sumdebit = 0;
                  $select1 = "SELECT sl.Ldate,sl.details,sl.debit,sl.credit,SUM(s.credit - s.debit) AS Balance
                  FROM   supplier_ledger sl,
               supplier_ledger s    
              WHERE s.id <= sl.id AND s.supplier_id = '$supplierId' AND sl.supplier_id = '$supplierId' GROUP BY sl.id,sl.debit, sl.credit";
                  $run1 = mysqli_query($connection, $select1);
                  while ($row = mysqli_fetch_array($run1)) {
                    $serial++;
                    $Balance = $row['Balance'];
                    $credit = $row['credit'];
                    $debit = $row['debit'];
                    $details = $row['details'];
                    $Ldate = $row['Ldate'];
                    $sumcredit += $credit;
                    $sumdebit += $debit;
                  ?>
                    <tr class="my-table-row-hover">
                      <td class="pt-2"><?php echo $serial; ?></td>
                      <td class="pt-2"><?php echo $Ldate ?></td>
                      <td class="pt-2"><?php echo $details ?></td>
                      <th class="pt-2"><?php echo $credit ?></th>
                      <td class="pt-2"><?php echo $debit ?></td>
                      <td class="pt-2"><?php echo $Balance ?></td>
                      
                    </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr style="background: grey; color: white" class="printcolor">
                    <th colspan="3">Total</th>
                    <th class="text-white"><?php echo number_format($sumcredit); ?></th>
                    <th class="text-white"><?php echo number_format($sumdebit); ?></th>
                    <th class="text-white"><?php echo number_format($sumcredit - $sumdebit); ?></th>
                  </tr>
                </tfoot>
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
<script type="text/javascript">
       $('#export_table').dataTable({
               
                dom: 'Bfrtip',

                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Sale_report Excel',
                        text:'Export to excel',
                        footer:true

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
                        footer:true
                       
                       //  Columns to export
                       //  exportOptions: {
                       //     columns: [0, 1, 2, 3, 4, 5, 6,7]
                       // }

                    }



                ]

            });
                    
                    

    </script>