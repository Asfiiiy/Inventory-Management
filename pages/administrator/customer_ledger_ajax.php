<?php

include "include/db.php";

if(isset($_POST['cust_id']))
{
  $cust_id = $_POST['cust_id'];
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];

  $queryR = "SELECT SUM(debit) AS dr, SUM(credit) AS cr FROM customer_ledger WHERE customer_id = '$cust_id' AND Ldate BETWEEN '$from_date' AND '$to_date' ORDER BY Ldate, id";
  $resultR = mysqli_query($connection,$queryR);
  $rowDataR = mysqli_fetch_array($resultR);
  $DR  = $rowDataR['dr'];
  $CR   = $rowDataR['cr'];

?>
<?php
    // Get customer name
    $queryCustomer = "SELECT name FROM customer WHERE id = '$cust_id'";
    $resultCustomer = mysqli_query($connection, $queryCustomer);
    $customerData = mysqli_fetch_array($resultCustomer);
    $customer_name = $customerData['name'];
  
    // Get current date
    $current_date = date("d-m-Y");
  
    // Modify PDF and Excel title
    $pdf_title = $current_date . "          Customer Ledger          " . $customer_name;
    $excel_title = $current_date . "          Customer Ledger          " . $customer_name;

?>
<h4 class="text-right text-secondary">Current Balance :
    <?php echo number_format(floatval($DR) - floatval($CR), 2); ?>
</h4>
<div class="table-responsive">
    <table class="table table-bordered text-center datatable table-striped" data-page-length="10000000"
        id="export_table">
        <thead class="my-table-style text-white printcolor">
            <tr>
                <th>S.No</th>
                <th width="12%">Date</th>
                <th width="15%">Invoice #</th>
                <th width="38%">Description</th>
                <th width="15%">DR.</th>
                <th width="15%">CR.</th>
                <th width="15%">Balance</th>
            </tr>
        </thead>
        <tbody class="table-font-size">
            <?php
            $count=0;
            $totalCR=0;
            $totalDR=0;

            $query = "SELECT * FROM customer_ledger WHERE customer_id = '$cust_id' AND Ldate BETWEEN '$from_date' AND '$to_date' ORDER BY Ldate, id";
            $result = mysqli_query($connection, $query);
            while($rowData = mysqli_fetch_array($result))
            {
                $count++;
                $Ldate   = date("d-m-Y", strtotime($rowData['Ldate']));
                $sale_id   = $rowData['sale_id'];
                $debit   = $rowData['debit'];
                $credit   = $rowData['credit'];
                
                // Ensure debit and credit are numeric
                $totalDR += floatval($debit);
                $totalCR += floatval($credit);
                
                $balance = $totalDR - $totalCR;
                $details = $rowData['details'];

                // Format debit and credit for display
                $debit = ($debit == 0) ? '' : number_format(floatval($debit), 2);
                $credit = ($credit == 0) ? '' : number_format(floatval($credit), 2);

            ?>
            <tr class="my-table-row-hover">
                <td class="pt-2"><?php echo $count; ?></td>
                <td class="pt-2"><?php echo $Ldate; ?></td>
                <td class="pt-2"><?php if($sale_id==0){}else{echo $sale_id;} ?></td>
                <td class="pt-2"><?php echo $details; ?></td>
                <th class="text-danger pt-2"><?php echo $debit; ?></th>
                <th class="text-success pt-2"><?php echo $credit; ?></th>
                <th class="text-primary pt-2"><?php echo number_format(floatval($balance), 2); ?></th>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<br>
<?php } ?>
<script type="text/javascript">
$('#export_table').dataTable({
    dom: 'Bfrtip',
    buttons: [{
            extend: 'excelHtml5',
            title: 'Customer Ledger',
            text: 'Export to Excel',
            footer: true
        },
        {
            extend: 'pdfHtml5',
            title: 'Customer Ledger',
            text: 'Export to PDF',
            footer: true
        }
    ]
});
</script>