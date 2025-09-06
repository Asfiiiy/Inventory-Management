<?php
include 'include/db.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
    integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
body {
    color: black;
}

#invoice-POS {
    margin: 0 auto;
    width: 70mm;
    background: #FFF;
}

table {
    border-collapse: collapse;
    color: black;
}

table,
td,
th {
    border: 1px solid black;
    color: black;
}

td,
th {
    padding-left: 6px !important;
}

@media print {
    @page {
        margin: 0.2in;
    }

    #invoice-POS {
        margin-top: 0px;
        font-family: 'Times New Roman';
        width: 100%;
        color: black;

    }

    #logo {
        text-align: center !important;
    }
}

.center-text {
    text-align: center;
}
</style>
<?php

  $id = $_GET['id'];
  $select = "SELECT cl.credit,cl.debit,s.id AS sale_id,c.name,c.address,c.mobile,c.email,s.after_discount, s.walk_in_cust_name FROM  sale AS s
INNER JOIN customer AS c ON c.id = s.customer_id
INNER JOIN customer_ledger AS cl ON cl.sale_id = s.id
WHERE s.id = '$id'";
  $run = mysqli_query($connection,$select);
  $row = mysqli_fetch_array($run);

  $credit = $row['credit'];
  $debit = $row['debit'];
  $after_discount = $row['after_discount'];
  $sale_id = $row['sale_id'];
  $name = $row['name'];
  $walk_in_cust_name = $row['walk_in_cust_name'];
  $address = $row['address'];
  $mobile = $row['mobile'];
  $email = $row['email'];
?>

<div class="container-fluid">
    <div class="row">
        <h3 style="text-align:center;">
            <!-- <img src="include/faizan_auto_logo.jpg" alt="Faizan auto logo" width="60"> -->
            Al Safa Natural Pure Honey
        </h3>
    </div>
    <div class="row" style="border-bottom:1px solid gray;">
        <h6 style="text-align: center; margin-top:-10px;"><span
                style="font-size:12px;"><u><b>Contact:</b></u>&nbsp;&nbsp;&nbsp;+92 3322040399, 03051912533,
                03329191053</span>
            <br>
            <span style="font-size:12px;"><u><b>Address:</b></u>&nbsp;&nbsp;&nbsp;G. T Road Tarnab Farm Peshawar
            </span>
        </h6>
    </div>
    <div class="row" style="font-size:12px; border-bottom:1px dotted gray;">
        <div class="col-sm-4 col-md-4"><span><b>Invoice: &nbsp;&nbsp;<?php echo $id ?></b></span></div>
        <div class="col-sm-4 col-md-4">
            <span><b>Name:</b>&nbsp;&nbsp;<?php echo $name;  if($walk_in_cust_name==0){}else{echo" - "; echo $walk_in_cust_name;}?></span>
        </div>
        <div class="col-sm-4 col-md-4">
            <span><b>Date:</b>&nbsp;&nbsp;<?php echo date('d-m-Y',strtotime(date('Y-m-d'))) ?></span>
        </div>
    </div>
    <div class="row">
        <center id="span"><b style="font-size:14px;">Item List</b></center>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-2"></div>
        <div class="col-md-8 col-sm-8">
            <table border="1px solid grey" width="100%" id="mytable">

                <thead>
                    <tr align="left">
                        <th style="font-size:12px;">Sr</th>
                        <th style="font-size:12px;">Product</th>
                        <th style="font-size:12px;">Price</th>
                        <th style="font-size:12px; width:44px">Quantity</th>
                        <th style="font-size:12px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ------------------------fetch data from item list ------------------->
                    <?php
      $select1 = "SELECT si.price,si.quantity,si.total_price,p.product_name FROM `sale_items` AS si
          INNER JOIN products AS p ON p.id = si.product_id
          WHERE si.sale_id = '$id'";
      $run1 = mysqli_query($connection,$select1);
      $i=0;
      $total_qty=0;
      $grand_total=0;
      while ($row1 = mysqli_fetch_array($run1)) {
        $i++;         
        $product_name = $row1['product_name'];
        $quantity = $row1['quantity'];
        $price  = $row1['price'];
        $total_price  = $row1['total_price'];
        $total_qty+=$quantity;
        $grand_total+=$total_price;
    ?>
                    <tr>
                        <td style="font-size:12px;"><?php echo $i;?></td>
                        <td style="font-size:12px;"><?php echo $product_name ?></td>
                        <td style="font-size:12px;"><?php echo intval($price) ?></td>
                        <td style="font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $quantity ?></td>
                        <td style="font-size:12px;"><?php echo intval($total_price) ?></td>
                    </tr>

                    <?php } ?>
                    <!--------------------------- End------------------------- -->
                    <tr>
                        <td style="font-size:12px;" colspan="3"><span style="float:right;">Total:&nbsp;</span></td>
                        <td style="font-size:12px;" class="center-text"><?php echo $total_qty ?>&nbsp;</td>
                        <td style="font-size:12px;"><?php echo intval($grand_total) ?></td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="col-md-2 col-sm-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-2"></div>
        <div class="col-md-8 col-sm-8">
            <div style="margin-top: 5px;">
                <table width="100%">

                    <tr>
                        <th style="font-size:12px;">Total After Discount</th>
                        <th style="font-size:12px;">Paid</th>
                        <th style="font-size:12px;">Remaining</th>

                    </tr>
                    <tr>
                        <td style="font-size:12px;"><?php echo $credit ?></td>
                        <td style="font-size:12px;"><?php echo $debit ?></td>
                        <td style="font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $credit - $debit ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <span style="font-size: 10px;">
            <center><b>&copy; Software Developed By MindGigs</b></center>
        </span>
        <span style="font-size: 7px;">
            <center><b>Contact (+92) 302 8844114</b></center>
        </span>
    </div>
    <br>
    <br>
    <span style="float:right;"><?php echo "Signature ------------------"; ?>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</span>

</div>
<?php
include 'include/js_links.php';
?>

</body>

<script>
window.onload = function() {
    window.print();

    window.onafterprint = function() {
        window.location.href = "sale_add.php";
    }

    if ($("#mytable td").length == '0') {
        $("#mytable").hide();
        $("#span").hide();
    }
}
</script>