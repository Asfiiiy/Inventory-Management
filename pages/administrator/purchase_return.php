<?php include("include/header.php"); ?>
<?php
$current_date = date('Y-m-d'); 
if (isset($_GET['invoice_id']) && isset($_GET['purchase_item_id']) && isset($_GET['product_id']) && isset($_GET['supplier_id']) && isset($_GET['total_price'])) {
    $purchase_id = $_GET['invoice_id'];
    $purchase_item_id = $_GET['purchase_item_id'];
    $product_id = $_GET['product_id'];
    $supplier_id = $_GET['supplier_id'];
    $total_price = $_GET['total_price'];

    $purchase_quantity = $_POST['purchase_quantity'];
    $purchase_price = $_POST['purchase_price'];
    $previous_purchase_quantity = $_POST['previous_purchase_quantity'];
    

    $price_per_qty = $purchase_price*$purchase_quantity;
    $new_price = $total_price-$price_per_qty;
    $new_qty = $previous_purchase_quantity-$purchase_quantity;


    $update_purchase = "UPDATE purchase SET after_discount_purchase='$new_price' WHERE id='$purchase_id' AND supplier_id='$supplier_id'";
    $run_update_purchase=mysqli_query($connection,$update_purchase);
    if($run_update_purchase){
     $update_purchase_items= "UPDATE purchase_items SET quantity='$new_qty', purchase_total='$new_price' WHERE purchase_id='$purchase_id' AND product_id='$product_id'";
     $run_update_purchase_items=mysqli_query($connection,$update_purchase_items);
     if($run_update_purchase_items){

        $update_stock_item= "UPDATE stock_items SET quantity='$new_qty' WHERE purchase_item_id='$purchase_item_id' AND product_id='$product_id'";
        $run_update_stock_item=mysqli_query($connection,$update_stock_item);

        $update_supplier_ledger= "UPDATE supplier_ledger SET credit='$new_price' WHERE supplier_id='$supplier_id' AND purchase_id='$purchase_id'";
        $run_update_supplier_ledger=mysqli_query($connection,$update_supplier_ledger);

        $insert_purchase_return = "INSERT INTO purchase_return(supplier_id,purchase_id,product_id,product_qty,return_price,return_date) VALUES('$supplier_id','$purchase_id',
        '$product_id','$new_qty','$new_price','$current_date')";
        $run_insert_purchase_return=mysqli_query($connection,$insert_purchase_return);

        if($run_insert_purchase_return){
            echo'<script>
            Swal.fire({
      position: "center",
      icon: "success",
      title: "Return Successfull",
      showConfirmButton: false,
      timer: 1000
    }).then(() => {
      setTimeout(() => {
        window.location.href = "total_purchase.php";
      }, 1000);
    });
    </script>';
        }else{
            echo'<script>
            Swal.fire({
      position: "center",
      icon: "error",
      title: "Problem Occured! Try Again",
      showConfirmButton: false,
      timer: 1000
    }).then(() => {
      setTimeout(() => {
        window.location.href = "total_purchase.php";
      }, 1000);
    });
    </script>';
        }

     }else{
        echo'<script>
        Swal.fire({
  position: "center",
  icon: "error",
  title: "Problem Occured! Try Again",
  showConfirmButton: false,
  timer: 1000
}).then(() => {
  setTimeout(() => {
    window.location.href = "total_purchase.php";
  }, 1000);
});
</script>';
     }

    }else{
        echo'<script>
        Swal.fire({
  position: "center",
  icon: "error",
  title: "Problem Occured! Try Again",
  showConfirmButton: false,
  timer: 1000
}).then(() => {
  setTimeout(() => {
    window.location.href = "total_purchase.php";
  }, 1000);
});
</script>';
    }
} 
?>

<?php include("include/footer.php"); ?>