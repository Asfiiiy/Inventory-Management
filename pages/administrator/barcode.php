   <html>
<head>
<!-- <link href="../../assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
<link href="../../assets/css/bootstrap.min.css" rel="stylesheet"> -->
<?php include("include/db.php"); 
      include 'barcode128.php';

?>
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

    }

</style>
</head>
<body >
  <div style="margin-left: 20%">
    <?php

     include("include/db.php"); 
 $product_id = $_GET['product_id'];
            $query= "SELECT p.product_name,p.product_code,(SELECT `sale_price` FROM `stock_items` sp WHERE sp.product_id = '$product_id' ORDER BY `sale_price` DESC LIMIT 1) as saleprice FROM products as p INNER JOIN stock_items as s  on s.product_id = p.id WHERE p.id = '$product_id'";
            $run= mysqli_query($connection,$query);
            $row = mysqli_fetch_array($run);
            // $id = $row['id'];
            $product_name = $row['product_name'];
            $product_code = $row['product_code'];
            $sale_price = $row['saleprice'];
          
         

      // echo bar128(stripcslashes($product_code));


      echo "<p class='inline'><span ><b style='font-size:23px;'>Waseem</b></span>&nbsp&nbsp<br><span class='bb'><b style='font-size:15px;'>Item: $product_name</b></span><span ></p>".bar128(stripcslashes($product_code))."</span><span><b style='font-size:15px;'>Price: ".$sale_price." </b><span>&nbsp&nbsp&nbsp&nbsp";

    ?>
  </div>
  <div style=" color: white;">. </div>
</body>
</html>

<script type="text/javascript">
  window.onload=function(){
    window.print();
    window.onafterprint = function() {
      window.location.href = 'product_details.php';
    } 
  }
</script>