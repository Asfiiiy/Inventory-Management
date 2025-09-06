<?php
include("include/db.php");
if(isset($_POST['pro_code']))
{
  

  $pro_code = $_POST['pro_code'];

  // Average Price
    // $query = "SELECT ROUND((SUM(s.sale_price * s.quantity)/SUM(s.quantity)),2) AS avrgPrice, SUM(s.quantity) AS qty FROM stock_items AS s
  //  WHERE s.quantity > 0 AND s.product_code = '$pro_code'";
  // $result = mysqli_query($connection,$query);
  // $rowData = mysqli_fetch_array($result);
  // $avrgPrice   = $rowData['avrgPrice'];
  //  if($avrgPrice == "")
  // {
  //   $avrgPrice = 0;
  // }
  // $qty   = $rowData['qty'];
  // if($qty == "")
  // {
  //   $qty = 0;
  // }

  $query = "SELECT ROUND((SUM(s.sale_price * s.quantity)/SUM(s.quantity)),2) AS avrgPrice, SUM(s.quantity) AS qty FROM stock_items AS s
   WHERE s.quantity > 0 AND s.product_code = '$pro_code'";
  $result = mysqli_query($connection,$query);
  $rowData = mysqli_fetch_array($result);
  $avrgPrice   = $rowData['avrgPrice'];
   if($avrgPrice == "")
  {
    $avrgPrice = 0;
  }
  $qty   = $rowData['qty'];
  if($qty == "")
  {
    $qty = 0;
  }

 $queryPurchase = "SELECT product_name FROM products
   WHERE  product_code = '$pro_code'";
  $resultPurchase = mysqli_query($connection,$queryPurchase);
  $rowDataPurchase = mysqli_fetch_array($resultPurchase);
 
   $product_name   = $rowDataPurchase['product_name'];


  $data = array('stock_Qty' => $qty,'product_name' => $product_name,'avrgPrice' =>$avrgPrice);
  echo json_encode($data);
}
//Fetch stock qty at first postion
if(isset($_POST['product_id_for_sQty']))
{
  $product_id= $_POST['product_id_for_sQty'];
  
  $select_item = "SELECT id, quantity FROM `stock_items` WHERE product_id = '$product_id' AND quantity > 0 ORDER BY stock_date, id ASC LIMIT 1";
  $run_item = mysqli_query($connection,$select_item);
  $row=mysqli_fetch_array($run_item);

  $stock_id = $row['id'];
  $quantity=$row['quantity'];
  if($quantity == "")
  {
    $quantity = 0;
  }

  $data = ["stkid" => $stock_id, "quantity" => $quantity];

  echo json_encode($data);
}

// Sale Append rows
if(isset($_POST['row_no']))
{
  $row_no= $_POST['row_no'];
?>
<div class="col-md-12" id="new_row<?php echo $row_no ?>">
  <hr class="shadow">
  <input type="hidden"  name="row[]" value="<?php echo $row_no ?>">
  <input type="hidden" name="singleQty[]" id="singlQty<?php echo $row_no ?>">
  <input type="hidden" name="stockId[]" id="stkId<?php echo $row_no ?>">
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label>Product</label>
        <select class="form-control select2" name="product_id[]" id="product_id<?php echo $row_no ?>">
          <option value="">Choose</option>
          <?php
          $query = "SELECT product_name,id FROM products";
          $run_check = mysqli_query($connection,$query);
          while($Data = mysqli_fetch_array($run_check)) {
          $pro_id = $Data['id'];
          $product_name  = $Data['product_name'];
          ?>
          <option value="<?php echo $pro_id; ?>"><?php echo $product_name; ?>
          </option>
          <?php } ?>
        </select>
      </div>
    </div>
  
      <div class="col-md-2">
       <div class="form-group">
                  <label>Product Code</label>
                  <input type="number" name="product_code[]"  class="form-control focus"  id="pro_code<?php echo $row_no ?>"  onchange="checkStock(<?php echo $row_no ?>)" autofocus>
                   
                </div>
              </div>
    
    <div class="col-md-2">
      <div class="form-group ">
        <label>Sale Price</label>
        <input type="number" step="any" name="sale_price[]" id="sale_price<?php echo $row_no ?>" onkeyup="sale_price(<?php echo $row_no ?>)"  class="form-control" placeholder="Sale Price" >
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group ">
        <label>Stock Qty</label>
        <input type="number" step="any" name="stockQty[]" id="stockQty<?php echo $row_no ?>" readonly class="form-control" placeholder="Sale Qty" required>
      </div>
    </div>
    <div class="col-md-1">
      <div class="form-group">
        <label>Quantity</label>
        <input type="number" step="any" name="quantity[]" class="form-control" placeholder="Quantity" value="1" onkeyup="sale_price(<?php echo $row_no ?>)" id="quantity<?php echo $row_no ?>">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label>Sale Total</label>
        <input type="number" step="any" name="sale_total[]" class="form-control" placeholder="Sale Total" id="sale_total<?php echo $row_no ?>" readonly>
      </div>
    </div>
    <div class="col-md-1">
      <div class="form-group">
        <br>
        <button type="button" class="btn btn-danger shadow" onclick="remove_row(<?php echo $row_no ?>)"><i class="bx bx-minus"></i></button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $('.focus').focus();
</script>
<?php } ?>