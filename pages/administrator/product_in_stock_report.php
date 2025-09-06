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
              <div class="box-header with-border">
                <center>
                  <h2>IN STOCK PRODUCTS INFORMATION</h2>
                </center><br>
              </div>
              <div class="panel" style="margin-left:3%">
                <div class="panel-heading">
                  <!--  <h3 class="panel-title">
          <i class="fa fa-fw ti-credit-card"></i> Report
      </h3>
      <span class="pull-right">
          <i class="fa fa-fw ti-angle-up clickable"></i>
          <i class="fa fa-fw ti-close removepanel clickable"></i>
      </span> -->
                </div>
                <div id="printablediv" class="panel-body">
                  <div id="mainDiv" class="row">
                    <div class="col-lg-12">
                      <button type="button" class="btn btn-success shadow mb-4" onclick="export_all()">Export To CSV</button>
                      <div class="panel ">
                        <div class="panel-body">
                          <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped my-only-div-shadow" data-page-length="50" id="sample_1">
                              <thead class="my-table-style text-white">
                                <tr>
                                  <th class="text-center"><b>S.No</b></th>
                                  <th><b>Product</b></th>
                                  <th class="text-center"><b>Average Price</b></th>
                                  <th class="text-center"><b>Min Quantity</b></th>
                                  <th class="text-center"><b>Stock Quantity</b></th>
                                </tr>
                              </thead>
                              <tbody id="display" class="table-font-size">
                                <?php
                                $serial = 0;
                                $prodque =  "SELECT p.product_name AS pro_name, u.unit AS u_name, ROUND(SUM(s.purchase_price * s.quantity)/SUM(s.quantity),3) AS avrgPrice, SUM(s.quantity) AS qty, p.alert_quantity FROM stock_items AS s 
             INNER JOIN products AS p ON p.id = s.product_id 
             INNER JOIN units AS u ON u.id = p.product_unit_id
             WHERE s.quantity != '0' GROUP BY s.product_id";
                                $prodfun = mysqli_query($connection, $prodque);
                                while ($proddata = mysqli_fetch_array($prodfun)) {
                                  $pro_name = $proddata['pro_name'];
                                  $u_name  = $proddata['u_name'];
                                  $quantity = $proddata['qty'];
                                  $min_quantity = $proddata['alert_quantity'];
                                  $avgPrice = $proddata['avrgPrice'];

                                  $serial++;
                                ?>
                                  <tr class="my-table-row-hover">
                                    <td class="text-center pt-2"><?php echo $serial; ?></td>
                                    <td class="pt-2"><?php echo $pro_name . " (" . $u_name . ")"; ?></td>
                                    <td class="text-center pt-2"><?php echo $avgPrice; ?></td>
                                    <td class="text-center pt-2"><?php echo $min_quantity; ?></td>
                                    <td class="text-center pt-2"><?php echo $quantity; ?></td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
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
  function export_all() {
    $('#sample_1').DataTable().destroy();
    $("#sample_1").tableHTMLExport({
      type: 'csv',
      filename: 'Stock_' + Math.floor((Math.random() * 10000000) + 1) + '.csv',
    });
    $('#sample_1').DataTable();
  }
  document.onkeyup = function(e) {

    if (e.which == 27) {
      window.location.href = "index.php";
      e.preventDefault();
      e.stopPropagation();
    }
  };
</script>