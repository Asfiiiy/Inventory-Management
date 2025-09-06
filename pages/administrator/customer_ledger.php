<?php
include "include/header.php";
?>
<br>
<section class="content">
  <div class="container-fluid">
    <h4 class="text-center">Customer Ledger</h4><br>
    <div class="row my-only-div-shadow py-4">
      <div class="col-md-4">
        <div class="form-group">
          <label>Customer/Contact</label>
          <select class="form-control select2" id="cust_id" onchange="getDetails()" name="customer_id" required>
            <option value="">Choose</option>
            <?php
            $fetchData1 = "SELECT * FROM customer ORDER BY name ASC";
            $runData1 = mysqli_query($connection, $fetchData1);
            while ($rowData1 = mysqli_fetch_array($runData1)) {

              $id         = $rowData1['id'];
              $name       = $rowData1['name'];
              $mobile   = $rowData1['mobile'];
              echo "<option value='$id'>$name / $mobile</option>";
            }
            ?>
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

    <hr class="shadow">
    <script>
  function ajaxCall() {
    // var from = $('#from').val();
    // var to = $('#to').val();
    var customerId = $('#customerId').val();

    $.ajax({
      type: 'POST',
      url: 'customer_report_ajax.php',
      data: {
        // sale_from: from,
        // sale_to: to,
        customerId: customerId
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

    </script>
    <div class="row">
      <div class="col-md-12 table-responsive" id="ajaxData">
      </div>
    </div>

  </div>
</section>
<?php include "include/footer.php"; ?>

<script type="text/javascript">
  function getDetails() {
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var cust_id = $('#cust_id').val();

    $("#preloader").fadeIn(100);

    $.ajax({
      url: 'customer_ledger_ajax.php',
      type: 'post',
      data: {
        'from_date': from_date,
        'to_date': to_date,
        'cust_id': cust_id
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