<?php include("include/header.php") ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-dark my-only-div-shadow" class="text-center">
          <div class="card-header">
          </div>
          <br>

          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <section class="content">
              <div class="row">
                <div class="col-md-12 text-center">
                  <h3>Sale Report Specific Products</h3>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label><b>Sale From</b></label>
                    <input type="date" id="from" name="from" value="<?php echo date('Y-m-d'); ?>" class="form-control" max="<?php echo date('Y-m-d'); ?>" onchange="ajaxCall()" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label><b>Sale To</b></label>
                    <input type="date" name="to" id="to" value="<?php echo date('Y-m-d'); ?>" class="form-control" max="<?php echo date('Y-m-d'); ?>" onchange="ajaxCall()" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label><b>Product</b></label>
                    <select id="productId" onchange="ajaxCall()" class="form-control select2" required>
                      <option value="all">All</option>
                      <?php
                      $run_items = mysqli_query($connection, "SELECT p.id, p.product_name FROM products AS p ORDER BY p.product_name");
                      while ($row1 = mysqli_fetch_array($run_items)) {

                        $product_id = $row1['id'];
                        $product_title = $row1['product_name'];
                        echo "<option value='$product_id'>$product_title</option>";
                      } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div id="mainDiv" class="row">
                <div class="col-lg-12">
                  <button type="button" class="btn btn-success shadow mb-4" onclick="export_all()">Export To CSV</button>
                  <div class="panel ">
                    <div class="panel-body">
                      <div class="table-responsive" id="ajaxData">
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include("include/footer.php")
?>
<script type="text/javascript">
  document.onkeyup = function(e) {
    if (e.which == 27) {
      window.location.href = "index.php";
      e.preventDefault();
      e.stopPropagation();
    }
  };

  function export_all() {
    $('.data_table').DataTable().destroy();
    $("#export_table").tableHTMLExport({
      type: 'csv',
      filename: 'Sale Product Date Wise Report_' + Math.floor((Math.random() * 10000000) + 1) + '.csv',
    });
    $('#export_table').DataTable();
  }
</script>
<script>
  function ajaxCall() {
    var from = $('#from').val();
    var to = $('#to').val();
    var productId = $('#productId').val();

    $.ajax({
      type: 'POST',
      url: 'sale_report_ajax.php',
      data: {
        sale_from: from,
        sale_to: to,
        productId: productId
      },
      success: function(data) {

        $("#ajaxData").html(data);

      }
    }).done(function() {
      $(".data_table").DataTable();
      autoCall();
    });
  }
  window.onload = function() {
    ajaxCall();
  }

  function autoCall() {
    calculateTotal();
    calculatePrice();
    calculateStock();
    calculateQuantity();
  }

  function calculateTotal() {
    var sum = 0;
    //iterate through each td based on class and add the values
    $(".total").each(function() {
      var value = $(this).text();
      //add only if the value is number
      if (!isNaN(value) && value.length != 0) {
        sum += parseFloat(value);
      }
    });
    $('.sumTotal').text(sum);
  }

  function calculatePrice() {
    var sum = 0;
    //iterate through each td based on class and add the values
    $(".price").each(function() {
      var value = $(this).text();
      //add only if the value is number
      if (!isNaN(value) && value.length != 0) {
        sum += parseFloat(value);
      }
    });
    $('.sumprice').text(sum);
  }

  function calculateStock() {
    var sum = 0;
    //iterate through each td based on class and add the values
    $(".stock_qty").each(function() {
      var value = $(this).text();
      //add only if the value is number
      if (!isNaN(value) && value.length != 0) {
        sum += parseFloat(value);
      }
    });
    $('.sumStockqty').text(sum);
  }

  function calculateQuantity() {
    var sum = 0;
    //iterate through each td based on class and add the values
    $(".quantity").each(function() {
      var value = $(this).text();
      //add only if the value is number
      if (!isNaN(value) && value.length != 0) {
        sum += parseFloat(value);
      }
    });
    $('.sumQuantity').text(sum);
  }
</script>