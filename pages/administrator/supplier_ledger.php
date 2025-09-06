<?php
include "include/header.php";
?>
<br>
<section class="content">
  <div class="container-fluid">
    <h3 class="text-center">Supplier Ledger</h3><br>
    <div class="row my-only-div-shadow py-4">
      <div class="col-md-4">
        <div class="form-group">
          <label>Supplier Name</label>
          <select id="supplierId" class="form-control select2" onchange="getDetails()">
            <option value="">Choose</option>
            <?php
            $qry = "SELECT * FROM `supplier`";
            $run = mysqli_query($connection, $qry);
            while ($data = mysqli_fetch_array($run)) {
              $id = $data['id'];
              $name =  $data['supplier_name'];
            ?>
              <option value="<?php echo $id ?>"> <?php echo $name ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Date From</label>
          <input type="date" id="from_date" class="form-control" value="<?php echo date('Y-m-d', strtotime('-1 year')); ?>" onchange="getDetails()">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Date To</label>
          <input type="date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="getDetails()">
        </div>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-md-12 table-responsive" id="ajaxData">
      </div>
    </div>

  </div>
</section>
<?php include "include/footer.php"; ?>

<script>
  function getDetails() {
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var supplierId = $('#supplierId').val();

    $("#preloader").fadeIn(100);

    $.ajax({
      url: 'supplier_ledger_ajax.php',
      type: 'post',
      data: {
        'from_date': from_date,
        'to_date': to_date,
        'supplierId': supplierId
      },
      dataType: "html",
      success: function(result) {
        $("#ajaxData").html(result);
      }
    }).done(function() {
      $(".datatable").DataTable();
      $("#preloader").fadeOut(100);
    });
  }
</script>