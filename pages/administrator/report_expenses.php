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
    .printBlock, .switcher-btn,.page-footer
    {
      display: none !important;
    }
    .container-fluid{
      margin-left: -50% !important;
      width: 130% !important;


    }
    .dataTable{
      display: none;

    }
  
  }
</style>
<div class="content-header">
  <div class="container-fluid">
  </div>
</div>
<section class="content" >
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <h4 class="text-center"><br>Expenses Date Wise Report</h4>
        <hr class="shadow">
        <div class="row">
          <div class="col-md-4 printBlock">
              <div class="form-group">
                <label>Expenses Category</label>
                <select class="form-control select2" id="cat_id" onchange="getDetails()">
                    <option value="all" selected>All</option>
                  <?php
                    $select = "SELECT * FROM expenses_category ORDER BY expense_cat ASC";
                    $run = mysqli_query($connection,$select);
                    while($row=mysqli_fetch_array($run))
                    {
                      $id  = $row['id'];
                      $name = $row['expense_cat'];
                      echo '<option value="'.$id.'">'.$name.'</option>';
                    }
                    ?>
                  </select>
              </div> 
            </div>
          <div class="col-md-4 printBlock">
            <div class="form-group">
              <label>From Date</label>
               <input type="date" name="start_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" id="from_date" onchange="getDetails()">
            </div>
          </div>
          <div class="col-md-4 printBlock">
            <div class="form-group">
              <label>To Date</label>
               <input type="date" name="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" id="to_date" onchange="getDetails()">
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12 table-responsive" id="ajaxData"></div>
        </div>
        <div class="row banner_id" style="display:none">
          <br>
          <br>
          <div class="col-md-12 text-right">
            <p class="mb-0">______________________</p>
            <h5 class="mt-0 mr-4">Signature</h5>
          </div>
        </div>
      </div>
      <br>
      <!-- Col-12 -->
    </div>
    <!-- row -->
  </div>
</section>
<?php include "include/footer.php"; ?>
<script type="text/javascript">

function export_all()
{
  $('.dataTable').DataTable().destroy();
  $('#export_table').DataTable().destroy();

  $("#export_table").tableHTMLExport({
    type:'csv',
    filename:'Expense_Report_'+Math.floor((Math.random() * 1000000) + 1)+'.csv',
  });
  $('#export_table').DataTable();

}

window.onload = function ()
{
  getDetails();
}
function getDetails()
{
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
      var cat_id = $('#cat_id').val();

  $("#preloader").fadeIn(100);

  $.ajax({
    url:'report_expenses_ajax.php',
    type:'post',
    data:
    {
      'from_date':from_date,
      'to_date':to_date,
      'cat_id':cat_id,

    },
    dataType : "html",
    success: function(result)
    {
      $("#ajaxData").html(result);
    }
  }).done(function (){
    $(".datatable").DataTable();
    $("#preloader").fadeOut(100);
  });
}



function printData()
{

  $('.datatable').DataTable().destroy();
  $('#export_table').DataTable().destroy();
  
  window.print();

}
</script>