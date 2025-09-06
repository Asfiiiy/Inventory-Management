<?php include("include/header.php") ?>
<div class="page-content container-fluid">
  <!--  Start Row  -->
  <div class="row">
    <div class="col-md-12">
      <h3>Supplier Payment List</h3>
    </div>
    <div class="col-md-12">
      <div class="card my-only-div-shadow">
        <div class="card-body table-responsive">
          <table class="table table-striped table-bordered datatable text-center my-only-div-shadow" data-page-length="25">
            <thead class="my-table-style text-white">
              <tr>
                <th>S.No</th>
                <th>Supplier Name</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="table-font-size">
         <?php
            $count = 0;
            $fetchData = "SELECT 
            sp.id AS `ID`, 
            s.supplier_name AS `Supplier Name`, 
            sp.paid AS `Total Amount`, 
            sp.payment_date AS `Date`
        FROM 
            supplier_payment sp
        JOIN 
            supplier s ON sp.supplier_id = s.id;";
            
$run_fetchData = mysqli_query($connection, $fetchData);

while ($fetchDataRow = mysqli_fetch_array($run_fetchData)) {
    $count++;
    $pay_id = $fetchDataRow['ID'];
    $supplier_name = $fetchDataRow['Supplier Name'];
    $total_amount = $fetchDataRow['Total Amount'];
    $date = $fetchDataRow['Date'];
?>
<tr>
    <td><?php echo $count; ?></td>
    <td><?php echo $supplier_name; ?></td>
    <td><?php echo $total_amount; ?></td>
    <td><?php echo $date; ?></td>
    <td>
        <a href="supplier_payment_list_edit.php?pay_id=<?php echo $pay_id; ?>">
            <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
        </a> 
        | 
        <a href="supplier_payment_list_delete.php?pay_id=<?php echo $pay_id; ?>">
            <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
        </a>
    </td>
</tr>
<?php
}
         ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- End Row  -->
</div>

<?php include("include/footer.php") ?>
