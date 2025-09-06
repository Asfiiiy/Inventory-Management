

<link href="../../assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
<link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
<?php include("include/db.php"); ?>
 <style>
  @media print{
    .page_break{
      page-break-after: always;
    }
  }
 </style>

 <?php
 $sale_id = $_GET['sale_id'];
            $query= "SELECT * FROM `sale_items` WHERE sale_id = '$sale_id'";
            $run= mysqli_query($connection,$query);
            while($row = mysqli_fetch_array($run)){
            $id = $row['product_id'];
            $product_code = $row['product_code'];
          ?>
          
             <div class="row">
            <div class="col-4">
            </div>
          </div>
           <div class="row">
            <div class="col-4 mt-5">
            </div>
          </div>
           <div class="row">
            <div class="col-4 mt-5">
            </div>
          </div>
           <div class="row">
            <div class="col-md-3 mt-5 text-center">
            </div>
            <div class="col-md-6 mt-5 text-center">
             <center><img src="generate.php?code=<?php echo $product_code?>" alt="" width='100%'><br>
              <h1 style="font-size: 100px"><?php echo $product_code?></h1></center>
            </div>
           
          </div>     
           <div class="page_break">
            </div>    
<?php }?>

<script type="text/javascript">
  window.onload=function(){
    window.print();
     window.onafterprint = function() {
      window.location.href = 'sale_details.php';
    } 
  }
</script>