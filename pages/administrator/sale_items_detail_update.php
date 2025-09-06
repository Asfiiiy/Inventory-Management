<?php include("include/header.php");
if (isset($_GET['id'])) {
  $sale_ItemId = $_GET['id'];
  $query = "SELECT si.sale_id, si.product_id, p.product_name, si.id AS sa_item_id, si.price, si.quantity, si.total_price, st_i.quantity AS stock_qty, si.cans 
            FROM sale_items AS si
            INNER JOIN products AS p ON p.id = si.product_id
            INNER JOIN stock_items AS st_i ON st_i.product_id = p.id
            WHERE si.id='$sale_ItemId'";
  $result = mysqli_query($connection, $query);
  $totalRows = mysqli_fetch_array($result);
  $product_name = $totalRows['product_name'];
  $price = $totalRows['price'];
  $quantity = $totalRows['quantity'];
  $total_price = $totalRows['total_price'];
  $stock_qty = $totalRows['stock_qty'];
  $sale_cans = $totalRows['cans'];
  $sale_idd = $totalRows['sale_id'];
}
?>

<div class="page-content">
    <div class="page-content container-fluid">
        <div class="card my-only-div-shadow">
            <div class="card-body">
                <h3 class="my-text-shadow">Update Sale</h3>
                <br>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="old_sale_price" value="<?php echo $price; ?>" class="form-control">
                    <input type="hidden" name="old_quantity" value="<?php echo $quantity; ?>" class="form-control">
                    <input type="hidden" name="old_sale_total" value="<?php echo $total_price; ?>" class="form-control">
                    <input type="hidden" name="old_cans" value="<?php echo $sale_cans; ?>" class="form-control">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Product</label>
                                <input type="text" name="" value="<?php echo $product_name ?>" class="form-control"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Sale Price</label>
                                <input type="number" step="any" name="sale_price" value="<?php echo $price ?>"
                                    id="salePrice1" readonly class="form-control" placeholder="Sale Price" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Weight/kg</label>
                                <input type="number" step="any" name="stockQty" id="stockQty1" readonly
                                    class="form-control" value="<?php echo $stock_qty ?>" placeholder="Stock Qty"
                                    onkeyup="findTotalQty(1)" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Weight/kg</label>
                                <input type="number" step="any" name="quantity" class="form-control"
                                    placeholder="Quantity" value="<?php echo $quantity ?>" value="1"
                                    onkeyup="salePricefetch(1),findTotalQty(1)" id="quantity1" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Sale Cans</label>
                                <input type="number" step="any" name="sale_cans" class="form-control" placeholder="Cans"
                                    value="<?php echo $sale_cans ?>" onkeyup="salePricefetch(1),findTotalQty(1)"
                                    id="saleCans1" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Sale Total</label>
                                <input type="number" step="any" name="sale_total" value="<?php echo $total_price ?>"
                                    class="form-control" placeholder="Sale Total" id="sale_total1" readonly>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <br>
        <div class="modal-footer">
            <input type="submit" name="saveData" class="btn btn-primary shadow my-shadow-btn" id="savebtn"
                value="Update">
            <a href="sale_items_detail.php?id=<?php echo $sale_idd ?>"
                class="btn btn-info shadow my-shadow-btn">Back</a>
        </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['saveData'])) {
  $new_sale_price = $_POST['sale_price'];
  $new_quantity = $_POST['quantity'];
  $new_sale_total = $_POST['sale_total'];
  $new_sale_cans = $_POST['sale_cans'];
  $old_quantity = $_POST['old_quantity'];
  $old_sale_total = $_POST['old_sale_total'];
  $old_cans = $_POST['old_cans'];
  
  // Update sale items with the new total price, quantity, and cans
  $query = "UPDATE `sale_items` SET `total_price`='$new_sale_total',`quantity`='$new_quantity', `cans`='$new_sale_cans' WHERE id='$sale_ItemId'";
  $run = mysqli_query($connection, $query);
  
  if ($run) {
    // Adjust stock quantity based on the changes in quantity and cans
    $fetch6 = "SELECT product_id, quantity, cans FROM sale_items WHERE id = '$sale_ItemId'";
    $runFetch6 = mysqli_query($connection, $fetch6);
    $row6 = mysqli_fetch_array($runFetch6);
    $product_id = $row6['product_id'];
    $quantity = $row6['quantity'];
    $cans = $row6['cans'];

    if ($old_quantity > $quantity) {
      $final_quantity =  $old_quantity - $quantity;
      $query1 = "UPDATE stock_items SET quantity= quantity + '$final_quantity' WHERE product_id ='$product_id'";
      $run1 = mysqli_query($connection, $query1);
    } else {
      $final_quantity = $quantity - $old_quantity;
      $update3 = "UPDATE stock_items SET quantity = quantity - $final_quantity WHERE product_id = '$product_id'";
      $runUpd3 = mysqli_query($connection, $update3);
    }

    $fetch4 = "SELECT sale_id, total_price FROM sale_items WHERE id = '$sale_ItemId'";
    $runFetch4 = mysqli_query($connection, $fetch4);
    $row4 = mysqli_fetch_array($runFetch4);
    $sale_id = $row4['sale_id'];
    $new_to_price = $row4['total_price'];
  }

  // Update sale total in customer ledger
  if ($old_sale_total > $new_to_price) {
    $final_sale_total = $old_sale_total - $new_to_price;
    $sql3  = "UPDATE sale SET after_discount = after_discount - $final_sale_total WHERE id = '$sale_id'";
    $run3 = mysqli_query($connection, $sql3);

    $fetch3 = "SELECT after_discount FROM sale WHERE id = '$sale_id'";
    $runFetch3 = mysqli_query($connection, $fetch3);
    $row3 = mysqli_fetch_array($runFetch3);
    $after_discount = $row3['after_discount'];

    $sql5  = "UPDATE customer_ledger SET credit = $after_discount WHERE sale_id = '$sale_id'";
    $run5 = mysqli_query($connection, $sql5);
  } else {
    $final_sale_total = $old_sale_total - $new_to_price;
    $sql3  = "UPDATE sale SET after_discount = after_discount - $final_sale_total WHERE id = '$sale_id'";
    $run3 = mysqli_query($connection, $sql3);

    $fetch4 = "SELECT after_discount FROM sale WHERE id = '$sale_id'";
    $runFetch4 = mysqli_query($connection, $fetch4);
    $row4 = mysqli_fetch_array($runFetch4);
    $after_discount = $row4['after_discount'];
    $sql6  = "UPDATE customer_ledger SET credit = $after_discount WHERE sale_id = '$sale_id'";
    $run6 = mysqli_query($connection, $sql6);
  }

  echo "<!DOCTYPE html>
      <html>
      <body>
        <script>
        Swal.fire(
        'Updated!',
        'Sale Item has been successfully Updated!',
        'success'
        ).then((result) => {
        if (result.isConfirmed) {
           window.location.href = 'sale_items_detail.php?id=$sale_id';
        }
        });
        </script>
      </body>
      </html>";
}
?>

<?php include("include/footer.php"); ?>
<script>
function findTotalQty(id) {
    let price = parseFloat(document.getElementById("salePrice" + id).value) || 0;
    let qty = parseFloat(document.getElementById("quantity" + id).value) || 0;
    document.getElementById("sale_total" + id).value = price * qty;
}
</script>