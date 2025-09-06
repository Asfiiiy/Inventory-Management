<?php
include "include/header.php";
?>
<style type="text/css">
  @media print {
    .printcolor
    {
      color: black !important;
      background: white !important;
    }
    .printBlock
    {
      display: none !important;
    }
  }
</style>
<div class="content-header">
  <div class="container-fluid">
  </div>
</div>
<section class="content" >
  <div class="container-fluid" class="text-center">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <h4 class="text-center">Summarize Profit & Loss Report</h4>
        <hr class="shadow">
<!--         <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>From Date</label>
               <input type="date" name="start_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" id="from_date" onchange="getDetails()">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>To Date</label>
               <input type="date" name="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" id="to_date" onchange="getDetails()">
            </div>
          </div>
        </div> -->
        
        <div class="row">
          <div class="col-md-12 table-responsive" id="ajaxData">
            <table class="table table-striped text-center table-bordered datatable" style="font-size: 12px" id="export_table" data-page-length="10000000">
  <thead class="bg-dark text-white printcolor">
    <tr>
      <th>S.No</th>
      <th>Date</th>
      <th>Total IN</th>
      <th>Total OUT</th>
      <th>Profit</th>
      <th>Loss</th>
    </tr>
  </thead>
  <tbody>
   <?php
    ////////////Cash IN & OUT Query
   $s_no = 0;
   $sumIN = 0;
   $sumOUT = 0;
   $sumProfit = 0;
   $sumLoss = 0;
    $select = "SELECT
       t2.Ldate,
        t1.debit AS b,
       t1.credit AS c    
FROM supplier_ledger t1
LEFT JOIN customer_ledger t2 ON t1.Ldate >= t2.Ldate
UNION
SELECT
       t1.Ldate,
        t1.debit,
       t1.credit
      
FROM customer_ledger t1
RIGHT JOIN supplier_ledger t2 ON t1.Ldate >= t2.Ldate
";
    $run = mysqli_query($connection,$select);
    while($row=mysqli_fetch_array($run))
    {
      $s_no++;
      $pay_date = date("d-m-Y",strtotime($row['Ldate']));
      $cl_Credit = $row['c'];
      if ($cl_Credit == NULL OR $cl_Credit == '')
      {
       $cl_Credit = 0;
      }

      $cl_Debit = $row['b'];
      if ($cl_Debit == NULL OR $cl_Debit == '')
      {
       $cl_Debit = 0;
      }

      $net_amount = $cl_Credit-$cl_Debit;

      $sumIN += $cl_Credit;
      $sumOUT += $cl_Debit;
      if($net_amount > 0)
      {
        $sumProfit += $net_amount;
      }
      else
      {
        $sumLoss += abs($net_amount);
      } 
   ?>

    <tr>
      <td><?php echo $s_no ?></td>
      <td><?php echo $pay_date ?></td>
      <td><?php echo number_format($cl_Credit); ?></td>
      <td><?php echo number_format($cl_Debit); ?></td>
      <td class="font-weight-bold bg-success printcolor text-white"><?php if($net_amount >= 0) { echo number_format($net_amount); } else { echo 0; } ?></td>
      <td class="font-weight-bold bg-danger printcolor text-white"><?php if($net_amount <= 0) { echo number_format(abs($net_amount)); } else { echo 0; } ?></td>
    </tr>
  <?php } ?>
  </tbody>
  <footer>
    <tr>
      <th></th>
      <th>Total</th>
      <th><?php echo number_format($sumIN); ?></th>
      <th><?php echo number_format($sumOUT); ?></th>
      <th class="bg-success printcolor"><?php echo number_format($sumProfit); ?></th>
      <th class="bg-danger printcolor"><?php echo number_format($sumLoss); ?></th>
    </tr>
  </footer>
</table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include "include/footer.php"; ?>
<script type="text/javascript">

function export_all()
{
  $('.dataTable').DataTable().destroy();
  $("#export_table").tableHTMLExport({
    type:'csv',
    filename:'Profit_Loss_Report_'+Math.floor((Math.random() * 1000000) + 1)+'.csv',
  });
  $('#export_table').DataTable();
}

       $('#export_table').dataTable({            
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Sale_report Excel',
                        text:'Export to excel',
                        footer:true
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Sale_report PDF',
                        text: 'Export to PDF',
                        number: 'Export to PDF',
                        footer:true
                    }
                ]

            });
    </script>