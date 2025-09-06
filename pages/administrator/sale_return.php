<?php include("include/header.php") ?> <?php
$current_date = date('y-m-d');
if(isset($_POST['sale_quantity']))
{	
        'Quantity : '. $quantity = $_POST['sale_quantity'];
  }
        $invoice_id = $_GET['invoice_id'];
        $sale_item_id = $_GET['sale_item_id'];
        $discount = $_GET['discount'];
        $product_id = $_GET['product_id'];
 $check_qry = mysqli_query($connection, "SELECT COUNT(*) as recordCount FROM sale_items  where  sale_id = '$invoice_id'") or die (mysqli_error($connection));
       $row = $check_qry->fetch_assoc();
       $recordCount = $row['recordCount'];
   
       'Per head Discount'.$discount_div =  $discount / $recordCount;
$query1 = "select price,quantity from sale_items where id = '$sale_item_id'";
        $run1 = mysqli_query($connection, $query1);
        $row1 = mysqli_fetch_array($run1);
        'Product Orignal Price :'.$price = $row1['price'];
        'Quantity Sale :'.$quantity_sale = $row1['quantity'];
        'Item Price After discount :'.$item_price_afterDiscount = ($price * $quantity) - $discount_div;
$query2 = "select discount,after_discount from sale where id = '$invoice_id'";
        $run2 = mysqli_query($connection, $query2);
        $row2 = mysqli_fetch_array($run2);
        'Old Discount :'.$old_discount = $row2['discount'];
        'Old price After Discount :'.$old_after_discount = $row2['after_discount'];
  //update this data in sale and sale_items
        'New  Discount :'.$new_discount = $old_discount - $discount_div;
        'New price After Discount :'.$new_price_after_discount = $old_after_discount - $item_price_afterDiscount;   
   //       if ($quantity_sale == 1){
   // echo 'New  quantity  :'.$new_quantity = $quantity_sale;
   //       }
   //       else{
          'New  quantity  :'.$new_quantity = $quantity_sale - $quantity;
          'New  Total price for sale_item  :'.$new_total_price = $price * $new_quantity;

       //  }
$query3 = "select quantity from stock_items where product_id = '$product_id'";
        $run3 = mysqli_query($connection, $query3);
        $row3 = mysqli_fetch_array($run3);
        'Available Stock Quantity  :'.$Available_stock_quantity = $row3['quantity'];
        'New Stock Quantity :'.$stock_new_quantity = $Available_stock_quantity + $quantity;  
$query4 = "select customer_id from sale where id = '$invoice_id'";
        $run4 = mysqli_query($connection, $query4);
        $row4 = mysqli_fetch_array($run4);
        'Customer Id  :'.$customer_id = $row4['customer_id'];
       
//Die();
                    // Update sale table
        $update_sale = "UPDATE `sale` SET `discount`='$new_discount',`after_discount`='$new_price_after_discount' WHERE id = '$invoice_id'";
        $run1 = mysqli_query($connection, $update_sale);


                    // Update sale_items table
        $update_sale_items = "UPDATE `sale_items` SET `quantity`='$new_quantity',`total_price`='$new_total_price' WHERE id = '$sale_item_id'";
        $run2 = mysqli_query($connection, $update_sale_items);


                     // Update stock_items table
        $update_stock = "UPDATE `stock_items` SET `quantity`='$stock_new_quantity' WHERE product_id = '$product_id'";
        $run3 = mysqli_query($connection, $update_stock);

 
                       // Insert customer_payment table
        $insert_customer_payment = "INSERT INTO `customer_payment`(`sale_id`, `customer_id`, `payment_method_id`, `paid`, `payment_date`, `details`) VALUES ('0','$customer_id','1','$item_price_afterDiscount','$current_date','Product Return $item_price_afterDiscount paid to Customer Discount Subtracted')";
        $run4 = mysqli_query($connection, $insert_customer_payment);
        $lastInsertId = mysqli_insert_id($connection);

                       // Insert customer_ledger table
        $insert_customer_ledger = "INSERT INTO `customer_ledger`(`customer_id`, `sale_id`, `payment_id`, `debit`, `credit`, `Ldate`, `details`) VALUES ('$customer_id','0','$lastInsertId','$item_price_afterDiscount','$item_price_afterDiscount','$current_date','Product Return $item_price_afterDiscount paid to Customer Discount Subtracted')";
        $run5 = mysqli_query($connection, $insert_customer_ledger);


             // Insert sale_return table
        $insert_sale_return = "INSERT INTO `sale_return`(`customer_id`, `sale_id`, `product_id`, `product_price`, `discount`, `return_price`, `return_date`) VALUES                                            ('$customer_id','0','$product_id','$price','$discount_div','$item_price_afterDiscount','$current_date')";
        $run6 = mysqli_query($connection, $insert_sale_return);



         // Insert cash_history table
        $insert_cash_history = "INSERT INTO `cash_history`(`amount`, `pay_status`, `pay_by`, `details`, `pay_date`, `pay_person`, `contact`, `pay_type_id`, `slip_no`, `receipt`, `supplier_payment_id`) VALUES ('$item_price_afterDiscount','OUT','Return','Product Return $item_price_afterDiscount paid to Customer Discount Subtracted','$current_date','Admin','1111111111','Direct','0','0','1')";
        $run7 = mysqli_query($connection, $insert_cash_history);

 echo "<script>
    window.location = 'total_sale.php?msg=Product_Return';
</script>";       
        ?>