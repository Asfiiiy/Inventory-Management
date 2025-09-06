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
                  <h3>Account Ledger Report</h3>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label><b>Date From</b></label>
                    <input type="date" id="from" name="from" value="<?php echo date('Y-m-d'); ?>" class="form-control" max="<?php echo date('Y-m-d'); ?>" onchange="ajaxCall()" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label><b>Date To</b></label>
                    <input type="date" name="to" id="to" value="<?php echo date('Y-m-d'); ?>" class="form-control" max="<?php echo date('Y-m-d'); ?>" onchange="ajaxCall()" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label><b>Select Account</b></label>
                    <select id="account_type" onchange="ajaxCall()" class="form-control select2" required>
                      <option value="1">Cash</option>
                      <option value="2">Bank/Online</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="mainDiv" class="row">
                <div class="col-lg-12">
                  <!-- <button type="button" class="btn btn-success shadow mb-4" onclick="export_all()">Export To CSV</button> -->
                  <div class="panel ">
                    <div class="panel-body" id="print_area">
                      <div class="table-responsive" id="ajaxData">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                  <div class="container">
                 <div class="row printBlock">
          <div class="col-md-12 text-center">
            <button class="btn btn-primary" id="printBtn">Print</button>
             <button type="button" class="btn btn-success shadow" onclick="export_all()">Export To CSV</button>
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
      filename: 'Account_Ledger_Report_' + Math.floor((Math.random() * 10000000) + 1) + '.csv',
    });
    $('#export_table').DataTable();
  }
</script>
<script>
  function ajaxCall() {
    var from = $('#from').val();
    var to = $('#to').val();
    var account_type = $('#account_type').val();

    $.ajax({
      type: 'POST',
      url: 'accounts_ledger_ajax.php',
      data: {
        from: from,
        to: to,
        account_type: account_type
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
  $("#printBtn").click(function() {
  document.querySelectorAll('.dataTables_filter').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.dataTables_paginate').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.dataTables_length').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.dataTables_info').forEach(element => element.style.display = 'none');
    const today = new Date();
    const formattedDate = today.toLocaleDateString('en-GB', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
    const header = `
        <div style="text-align: center;">
            <h4>Account Ledger Report</h4>
            <p style="margin-top: -8px;">Dated:&nbsp;${formattedDate}</p>
        </div>
    `;
    var printContents = document.getElementById("print_area").innerHTML;
    printContents = header + printContents;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
});
</script>