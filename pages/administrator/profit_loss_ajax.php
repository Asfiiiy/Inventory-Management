<table class="table table-striped text-center table-bordered datatable" style="font-size: 12px" id="export_table" data-page-length="100">
  <thead class="bg-dark text-white printcolor">
    <tr>
      <th>Date</th>
      <th>Invoice #</th>
      <th>Product</th>
      <th>Purchase</th>
      <th>Qty</th>
      <th>Sale</th>
      <th>Profit / Loss</th>
    </tr>
  </thead>
  <tbody>
   <?php
    include "include/db.php";
    if(isset($_POST['from_date']) && isset($_POST['to_date'])){
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];

  $get_data = "SELECT profit_loss_data.sale_id, profit_loss_data.date,profit_loss_data.total_purchase,profit_loss_data.qty,profit_loss_data.total_sale, products.product_name, customer.name FROM profit_loss_data
JOIN products on products.id=profit_loss_data.pro_id
JOIN customer on customer.id = profit_loss_data.cust_id WHERE profit_loss_data.date BETWEEN '$from_date' AND '$to_date'";
    $run_query1=mysqli_query($connection,$get_data);
    $grand_purchase=0;
    $grand_sale=0;
    $grand_qty=0;
    while($row=mysqli_fetch_array($run_query1))
    {
        $invoice_id = $row['sale_id'];
        $date = $row['date'];
        $purchase = $row['total_purchase'];
        $quantity = $row['qty'];
        $sale = $row['total_sale'];
        $product_name = $row['product_name'];
        $customer_name = $row['name'];
        $grand_purchase+=$purchase;
        $grand_sale+=$sale;
        $grand_qty+=$quantity;
   ?>

    <tr>
    <td><?php echo $invoice_id;?></td>
    <td><?php echo $date;?></td>
    <td><?php echo $product_name;?></td>
    <td><?php echo $purchase;?></td>
    <td><?php echo $quantity;?></td>
    <td><?php echo $sale;?></td>
     <?php
     if($sale-$purchase>0){ ?>
        <td class="font-weight-bold" style="background-color:#AFE1AF;"><strong>Profit - RS: <?php echo $sale-$purchase;?></strong></td>
    <?php }elseif($sale-$purchase<0){ ?>
        <td class="font-weight-bold" style="background-color:#D22B2B; color:#ffffff;"><strong>Loss - RS: <?php echo $purchase-$sale;?></strong></td>
    <?php }
     ?>
    </tr>
  <?php } }?>
  <tr>
    <td colspan="3"><span style="float:right;"><strong>Total:</strong></span></td>
    <td colspan=""><strong>Rs: <?php echo $grand_purchase;?></strong></td>
    <td colspan=""><strong><?php echo $grand_qty;?></strong></td>
    <td colspan=""><strong>Rs: <?php echo $sale;?></strong></td>
    <td colspan=""></td>
  </tr>
  </tbody>
</table>