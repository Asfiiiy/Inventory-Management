 
<!-- <link href="../../assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
<link href="../../assets/css/bootstrap.min.css" rel="stylesheet"> -->
<?php include("include/db.php");
include 'barcode128.php'; ?>
<style>
p.inline {display: inline-block;
margin-bottom: 1.5%;}
span { font-size: 13px;}

</style>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin-top: 0px;  /* this affects the margin in the printer settings */
/*        margin-right: 10px;*/

    }

</style>

 <div style="margin-left: 25%;  margin-top: 0px; ">
   

 <?php
if (isset($_POST['saveData'])) {
	foreach ($_POST['checkbox'] as $key => $value){
          $query= "SELECT p.product_name,p.product_code,(SELECT `sale_price` FROM `stock_items` sp WHERE sp.product_id = '$value' ORDER BY `sale_price` DESC LIMIT 1) as saleprice FROM stock_items as s INNER JOIN products as p on p.id = s.product_id WHERE p.id ='$value' group by s.product_code";
            $run= mysqli_query($connection,$query);
        while($row = mysqli_fetch_array($run)){
            // $id = $row['id'];
            $product_name = $row['product_name'];
            $product_code = $row['product_code'];
             $sale_price = $row['saleprice'];
          
                 echo "<p class='inline'><span style='font-size:23px;'><b>Waseem</b></span>&nbsp&nbsp<br><span ><b style='font-size:15px;'>Item: $product_name</b></span></p>".bar128(stripcslashes($product_code))."<span style='font-size:15px;'><b>Price: ".$sale_price." </b><span>&nbsp&nbsp&nbsp&nbsp;<br>";

           }}} ?>

</div>
  <div style=" color: white;">. </div>
<script type="text/javascript">
  window.onload=function(){
    window.print();
     window.onafterprint = function() {
      window.location.href = 'product_details.php';
    } 
  }
</script>