<?php
include "include/header.php";
?>
<style type="text/css">

    .pagebreak { page-break-before: always; }
    @media print {
      
    .printBlock,.switcher-btn,.back-to-top
    {
      display: none !important;
    }
    .buttons-pdf,.buttons-excel{
      display: none !important;
    }
    .content{
      margin-left: -50%;
      width: 150%;
    }
    .row2{
      display: inline-block;
    }
  }
</style>
<section class="content">
  <div class="container-fluid">

    <div class="row container-fluid">
      <div class="col-md-12 ">

        <?php
        $cust_id = $_GET['id'];
        $select1 = "SELECT SUM(cl.credit) AS sumCreidt,SUM(cl.debit) AS sumDebit,cus.name,cus.mobile,cus.address FROM customer_ledger AS cl INNER JOIN customer AS cus ON cus.id = cl.customer_id  WHERE cl.customer_id = '$cust_id'";
        $run1 = mysqli_query($connection, $select1);
        $row = mysqli_fetch_array($run1);
        $name = $row['name'];
        $sumCreidt = $row['sumCreidt'];
        $sumDebit = $row['sumDebit'];
        $mobile = $row['mobile'];
        $address = $row['address'];
        ?>

        <input type="hidden" id="supId" value="<?php echo $cust_id ?>">

        <div class="row">
          <div class="col-md-12 text-center ">
            <h3 style="margin-top:50px">Customer Payment Details</h3>
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
            <div class="table-responsive">
              <table class="table table-striped text-center table-bordered table-hover datatable my-only-div-shadow" id="export_table" data-page-length="10000000">
                <thead class="my-table-style printcolor text-white">
                  <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Invoice #</th>
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
                  $select1 = "SELECT cl.sale_id,cl.Ldate,cl.details,cl.debit,cl.credit,SUM(c.credit - c.debit) AS Balance,SUM(c.credit) AS Bala,SUM(c.debit) AS Ba
                  FROM customer_ledger cl,
               customer_ledger c    
              WHERE c.id <= cl.id AND c.customer_id = '$cust_id' AND cl.customer_id = '$cust_id' GROUP BY cl.id,cl.debit, cl.credit";
                  $run1 = mysqli_query($connection, $select1);
                  while ($row = mysqli_fetch_array($run1)) {
                    $serial++;
                    $sale_id = $row['sale_id'];
                    $Balance = $row['Balance'];
                    $credit = $row['credit'];
                    $debit = $row['debit'];
                    $details = $row['details'];
                    $Ldate = $row['Ldate'];
                    $sumcredit = $row['Bala'];
                    $sumdebit = $row['Ba'];
                  ?>
                    <tr class="my-table-row-hover">
                      <td class="pt-2"><?php echo $serial; ?></td>
                      <td class="pt-2"><?php echo $Ldate ?></td>
                      <td class="pt-2"><?php if($sale_id==0){}else{echo $sale_id;}?></td>
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
            <button class="btn btn-primary" id="printBtn">Print</button>
             <button class="btn btn-danger" onclick="window.location.href = 'customer_payment_details.php'">Close</button>
             <button type="button" class="btn btn-success shadow" onclick="export_all()">Export To CSV</button>
          </div>
        </div>
    </div>
            </footer>
        </div>
        <br>
      </div>
    </div>

  </div>
</section>
<?php include "include/footer.php"; ?>

<script type="text/javascript">
      $("#printBtn").click(function()
  {
    window.print();

  });
      function export_all() {
    $('.data_table').DataTable().destroy();
    $("#export_table").tableHTMLExport({
      type: 'csv',
      filename: 'Customer Payment Leadger' + Math.floor((Math.random() * 10000000) + 1) + '.csv',
    });
    $('#export_table').DataTable();
  }
</script>
<script type="text/javascript">
       $('#export_table').dataTable({
        "bPaginate": false,
               
                dom: 'Bfrtip',

                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Customer Leadger Excel',
                        text:'Export to excel',
                        footer:true

                       //  Columns to export
                       //  exportOptions: {
                       //     columns: [0, 1, 2, 3,4,5,6,7]
                       // }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Customer Leadger PDF',
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