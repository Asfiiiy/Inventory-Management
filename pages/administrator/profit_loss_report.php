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
      <div class="col-md-12" style="margin-top:10px;">
        <h4 class="text-center">Profit & Loss Report</h4>
        <hr class="shadow">
<div class="row">
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
        </div>
        
<div class="row">
<div class="col-md-12 table-responsive" id="ajaxData">

</div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include "include/footer.php"; ?>
<script type="text/javascript">
function getDetails(){
    let from_date = document.getElementById("from_date").value;
    let to_date = document.getElementById("to_date").value;
    $.ajax({
      method: 'POST',
      url: 'profit_loss_ajax.php',
      data: {
        from_date: from_date,
        to_date:to_date
      },
      datatype: "html",
      success: function(result) {
        $("#ajaxData").html(result);
      }
    });
}

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
