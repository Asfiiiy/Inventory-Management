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
table {
    border-collapse: collapse;
    width: 100%;
}

th,
td {
    border: 1px solid black;
}

@media print {
    @page {
        margin: 0.2in;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
    }
}

.center-text {
    text-align: center;
}
</style>
<?php

  $id = $_GET['id'];
  $discount = $_GET['discount'];
  $paid = $_GET['paid'];
  $remain_amount = $_GET['remain_amount'];

$select = "SELECT c.name,c.address,c.mobile,c.email,s.after_discount,s.id,s.walk_in_cust_name FROM sale AS s
INNER JOIN customer AS c ON c.id = s.customer_id
WHERE s.id = '$id'";
  $run = mysqli_query($connection,$select);
  $row = mysqli_fetch_array($run);

  $after_discount = $row['after_discount'];
  $name = $row['name'];
  $walk_in_cust_name = $row['walk_in_cust_name'];
  $address = $row['address'];
  $mobile = $row['mobile'];
  $id = $row['id'];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row mb-1">
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
                <div class="col-sm-1 col-md-1"></div>
                <div class="col-sm-4 col-md-4"><span><b>Invoice: &nbsp;&nbsp;<?php echo $id ?></b></span></div>
                <div class="col-sm-4 col-md-4">
                    <span><b>Name:</b>&nbsp;&nbsp;<?php echo $name; if($walk_in_cust_name==0){}else{echo" - "; echo $walk_in_cust_name;} ?></span>
                </div>
                <div class="col-sm-3 col-md-3">
                    <span><b>Date:</b>&nbsp;&nbsp;<?php echo date('d-m-Y',strtotime(date('Y-m-d'))) ?></span>
                </div>
            </div>
            <div class="row">
                <center id="span"><b style="font-size:14px;">Item List</b></center>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-2"></div>
                <div class="col-md-8 col-sm-8">
                    <table width="100%" id="mytable">
                        <thead>
                            <tr>
                                <th style="width:30px;font-size:12px;">Sr</th>
                                <th style="padding-left:10px;font-size:12px;">Product</th>
                                <th style="text-align:center;font-size:12px;">Total Cans</th>
                                <th style="text-align:center;font-size:12px;">Price</th>
                                <th style="text-align:center;font-size:12px;">Weight/kg</th>
                                <th style="text-align:center;font-size:12px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ------------------------fetch data from item list ------------------->
                            <?php
  $select1 = "SELECT si.price,si.quantity,si.total_price,si.cans,p.product_name FROM `sale_items` AS si
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
    $total_cans = $row1['cans'];
    $total_qty+=$quantity;
    $grand_total+=$total_price;
?>
                            <tr>
                                <td style="padding-left:10px;font-size:12px;"><?php echo $i;?></td>
                                <td style="padding-left:10px;width:400px;font-size:12px;"><?php echo $product_name ?>
                                </td>
                                <td style="width:150px; text-align:center;font-size:12px;"><?php echo $total_cans ?>
                                </td>
                                <td style="width:150px; text-align:center;font-size:12px;"><?php echo intval($price) ?>
                                </td>
                                <td style="width:80px;text-align:center;font-size:12px;">
                                    &nbsp;&nbsp;<?php echo $quantity ?></td>

                                <td style="width:150px;text-align:center;font-size:12px;">
                                    <b><?php echo intval($total_price) ?></b>
                                </td>
                            </tr>

                            <?php } ?>
                            <!--------------------------- End------------------------- -->

                            <tr>
                                <td style="font-size:12px;" colspan="4"><span style="float:right;">Total:&nbsp;</span>
                                </td>
                                <td style="font-size:12px;" class="center-text"><?php echo $total_qty?></td>
                                <td style="font-size:12px;" class="center-text"><?php echo intval($grand_total) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-2 col-sm-2"></div>
            </div>

            <div class="row mt-1">
                <div class="col-md-2 col-sm-2"></div>
                <div class="col-md-8 col-sm-8">
                    <div style="">
                        <table width="100%">
                            <tr>
                                <th style="padding-left:25px;font-size:12px;">Discount</th>
                                <td style="text-align:center;font-size:12px;"><?php echo intval($discount) ?></td>
                            </tr>
                            <tr>
                                <th style="padding-left:25px;font-size:12px;">After Discount</th>
                                <td style="text-align:center;font-size:12px;"><?php echo intval($after_discount) ?></td>
                            </tr>
                            <tr>
                                <th style="padding-left:25px;font-size:12px;">Paid</th>
                                <td style="text-align:center;font-size:12px;"><?php echo intval($paid) ?></td>
                            </tr>
                            <tr>
                                <th style="padding-left:25px;font-size:12px;">Remaining</th>
                                <td style="text-align:center;font-size:12px;"><?php echo intval($remain_amount) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2"></div>
            </div>
            <center>
                <span style="font-size: 10px;">
                    <center><b>&copy; Software Developed By MindGigs</b></center>
                </span>
                <span style="font-size: 7px;">
                    <center><b>Contact (+92) 302 8844114</b></center>
                </span>

            </center>
        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
    integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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