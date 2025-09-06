  <html>
<head>

<?php include("include/db.php");
      include 'barcode128.php';

?>
<style>
p.inline {display: inline-block;}
span { font-size: 13px;}
</style>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */

    }

    @media print{
    .page_break{
      page-break-after: always;
    }
  }
</style>
</head>
<body >
  <div style="margin-left: 45% ; ">
    <?php
            $query= "SELECT p.product_name,p.product_code,s.`sale_price` FROM products as p INNER JOIN stock_items as s on s.product_id = p.id";
            $run= mysqli_query($connection,$query);
            while($row = mysqli_fetch_array($run)){
            // $id = $row['id'];
            $product_name = $row['product_name'];
            $product_code = $row['product_code'];
            $sale_price = $row['sale_price'];
          
         

 echo "<p class='inline'><span ><b>Waseem designer</b></span>&nbsp&nbsp<br><span ><b>Item: $product_name</b></span>".bar128(stripcslashes($product_code))."<span ><b>Price: ".$sale_price." </b><span></p>&nbsp&nbsp&nbsp&nbsp";

}
    ?>
    <div class="page_break">
            </div> 
  </div>
   
</body>
</html>

<script type="text/javascript">
  window.onload=function(){
    window.print();
    //  window.onafterprint = function() {
    //   window.location.href = 'product_details.php';
    // } 
  }
</script>