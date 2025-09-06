<?php
	include "include/db.php";

	if(isset($_POST['from_date']) AND isset($_POST['to_date']) AND isset($_POST['cat_id']))
	{
  	$from_date = $_POST['from_date'];
  	$to_date = $_POST['to_date'];
  	$cat_id = $_POST['cat_id'];
?>
	<div class="row printBlock">
    <div class="col-md-12">
      <div class="form-group text-right">
        <button type="button" class="btn btn-info shadow" onclick="export_all()">Export To CSV</button>
        <button class="btn btn-primary shadow" onclick="printData()">Print</button>
        <button class="btn btn-danger shadow" onclick="window.location.href = 'report_expenses.php'">Close</button>
      </div>
    </div>
  </div>
  <hr>
	<table class="table table-striped text-center table-bordered datatable" style="font-size: 12px" data-page-length="10000000" id="export_table">
	  <thead class="bg-dark text-white printcolor">
	    <tr>
	      <th>S.No</th>
	      <th width="13%">Customer Name</th>
	      <th>Purchase Date</th>
	      <th>Product Name</th>
	      <th>Description</th>

	      <th>Price</th>
	    </tr>
	  </thead>
	  <tbody>
	    <?php
	    	$count = 0;
	    	$totalExp = 0;
	            /////////////  Expenses Query  /////////////
       $fetch_Exp= "SELECT e.customer_name,e.purchase_date,e.product_name,e.price As exp_amount,e.description FROM charge AS e  WHERE e.purchase_date
        BETWEEN '$from_date' AND '$to_date' AND (e.id = '$cat_id' OR '$cat_id' = 'all') ORDER BY e.purchase_date ASC";
	    $runExp = mysqli_query($connection,$fetch_Exp);
	    while($rowExp = mysqli_fetch_array($runExp)) {
           $count++;
	    $customer_name  = $rowExp['customer_name'];
	    $purchase_date  = $rowExp['purchase_date'];
	    $product_name  = $rowExp['product_name'];
	    $price  = $rowExp['exp_amount'];
	    $description  = $rowExp['description'];

	    // $exp_amount  = $rowExp['exp_amount'];
	    // $details  = $rowExp['details'];
	    // $expense_person  = $rowExp['expense_person'];
	    // $exp_date  = date("d-m-Y", strtotime($rowExp['exp_date']));
	    $totalExp += $price;
         
	    ?>
	    <tr>
	    	<td><?php echo $count ?></td>    	
	    	<td><?php echo $customer_name ?></td>
	    	<td><?php echo $purchase_date ?></td>
	    	<td><?php echo $product_name ?></td>
	        <td><?php echo $description ?></td>
	        <td><?php echo $price ?></td>

	        <!-- <td><?php echo number_format($totalExp); ?></td> -->
	    </tr>
	    <?php }?>
	 </tbody>
	 <tfoot>
      <tr style="background: grey; color: white" class="printcolor">
      	<th></th>
      	<th></th>
      	<th></th>
      	<th></th>
        <th class="text-right">Total Expenses</th>
        <th><?php echo number_format($totalExp); ?></th>
      </tr>
    </tfoot>
	</table>
	  
	<br>
<?php } ?>
<script type="text/javascript">
       $('#export_table').dataTable({
               
                dom: 'Bfrtip',

                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Expences_report Excel',
                        text:'Export to excel',
                        footer:true

                       //  Columns to export
                       //  exportOptions: {
                       //     columns: [0, 1, 2, 3,4,5,6,7]
                       // }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Expences_report PDF',
                        text: 'Export to PDF',
                        number: 'Export to PDF',
                        footer:true
                       
                       //  Columns to export
                       //  exportOptions: {
                       //     columns: [0, 1, 2, 3, 4, 5, 6,7]
                       // }

                    }



                ]

            });
                    
                    

    </script>
