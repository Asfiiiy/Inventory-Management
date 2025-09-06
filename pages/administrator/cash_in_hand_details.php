<?php
include "include/header.php";
?>
<br>
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
 .table-responsive{
  overflow-x: hidden;
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12 text-center">
            <h4 class="p-0 m-0">CASH IN HAND DETAILS</h4>
          </div>
        </div>
        <hr class="shadow">
        <div class="row printBlock">
          <div class="col-md-4">
            <div class="form-group">
              <label>Date From</label>
               <input type="date" name="start_date" class="form-control" value="<?php echo date('Y-m-d',strtotime('-7 day')); ?>" id="from_date" onchange="getDetails()">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Date To</label>
               <input type="date" name="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" id="to_date" onchange="getDetails()">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Order By</label>
              <select  id="order_by" class="form-control select2" onchange="getDetails()">
                 <option value="DESC">DESC</option>
                 <option value="ASC">ASC</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row printBlock">
          <div class="col-md-12">
            <div class="form-group text-right">
              <button type="button" class="btn btn-info shadow" onclick="export_all()">Export To CSV</button>
              <button class="btn btn-primary shadow" onclick="printData()">Print</button>
              <button class="btn btn-danger shadow" onclick="window.location.href = 'cash_in_hand.php'">Close</button>
            </div>
          </div>
        </div>
        <hr class="shadow mt-0" style="border: 1px solid grey;">
        <div class="table-responsive" id="ajaxData"></div>
        <br>
      </div>
    </div>
  </div>
</section>
<?php include "include/footer.php"; ?>

<script type="text/javascript">
function getDetails()
{
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  var order_by = $('#order_by').val();
  $("#preloader").fadeIn(100);

  $.ajax({
    url:'cash_in_hand_ajax.php',
    type:'post',
    data:
    {
      'order_by':order_by,
      'from_date':from_date,
      'to_date':to_date
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
</script>

<script>
  function deleteData(id)
  {
    var imgPath = $("#imgPath"+id).val();
        Swal.fire({
        title: 'Are you sure?',
        text: "To delete the selected record !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href= "cash_in_hand_details.php?deleteId="+id+"&path="+imgPath;
      }
  });

  }
</script>

<?php
  if(isset($_GET['deleteId']))
  {
    $id = $_GET['deleteId'];
    $path = $_GET['path'];
    $delete = "DELETE FROM cash_history WHERE id = '$id'";
    $run = mysqli_query($connection,$delete);
    if($run)
    {
      unlink($path);
      echo "<!DOCTYPE html>
      <html>
        <body> 
        <script>
        Swal.fire(
          'Deleted !',
          'The selected record has been deleted',
          'success'
        ).then((result) => {
          if (result.isConfirmed) {
             window.location.href = 'cash_in_hand_details.php';
          }
        });
        </script>
        </body>
      </html>";
    }
  }
?>

<script type="text/javascript">

function export_all()
{
  $('.dataTable').DataTable().destroy();
  $("#export_table").tableHTMLExport({
    type:'csv',
    filename:'Cash_In_Hand_Report_'+Math.floor((Math.random() * 1000000) + 1)+'.csv',
  });
  $('#export_table').DataTable();
}

  window.onload = function()
  {
    getDetails();
  }

  function printData()
  {
    $('.datatable').DataTable().destroy();
    $('#export_table').DataTable().destroy();
    window.print();
    getDetails();
  }
</script>

