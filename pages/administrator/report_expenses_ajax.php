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
	      <th width="13%">Date</th>
	      <th>Expenses</th>
	      <th>Expenses Person</th>
	      <th>Detail</th>
	      <th>Total Expenses</th>
	    </tr>
	  </thead>
	  <tbody>
	    <?php
	    	$count = 0;
	    	$totalExp = 0;
	            /////////////  Expenses Query  /////////////
       $fetch_Exp= "SELECT e.exp_date,e.details,ec.expense_cat,e.amount AS exp_amount,e.expense_person FROM expenses AS e INNER JOIN expenses_category AS ec ON ec.id = e.cat_id WHERE e.exp_date
        BETWEEN '$from_date' AND '$to_date' AND (e.cat_id = '$cat_id' OR '$cat_id' = 'all') ORDER BY e.exp_date ASC";
	    $runExp = mysqli_query($connection,$fetch_Exp);
	    while($rowExp = mysqli_fetch_array($runExp)) {
           $count++;
	    $expense_cat  = $rowExp['expense_cat'];
	    $exp_amount  = $rowExp['exp_amount'];
	    $details  = $rowExp['details'];
	    $expense_person  = $rowExp['expense_person'];
	    $exp_date  = date("d-m-Y", strtotime($rowExp['exp_date']));
	    $totalExp += $exp_amount;
         
	    ?>
	    <tr>
	    	<td><?php echo $count ?></td>    	
	    	<td><?php echo $exp_date ?></td>
	    	<td><?php echo $expense_cat ?></td>
	    	<td><?php echo $expense_person ?></td>
	        <td><?php echo $details ?></td>
	        <td><?php echo number_format($exp_amount); ?></td>
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
