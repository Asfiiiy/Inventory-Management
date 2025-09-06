<?php
include("include/db.php");
if(isset($_POST['pro_code']))
{
  

  $pro_code = $_POST['pro_code'];
  $query = "SELECT s.product_id,p.product_name,(SELECT `sale_price` FROM `stock_items` WHERE `product_code` = '$pro_code' ORDER BY `sale_price` DESC LIMIT 1) AS avrgPrice , SUM(s.quantity) AS qty FROM stock_items AS s
  INNER JOIN products AS p On p.id = s.product_id
   WHERE s.quantity > 0 AND s.product_code = '$pro_code' ORDER by stock_date ASC";
  $result = mysqli_query($connection,$query);
  $rowData = mysqli_fetch_array($result);
  $product_id   = $rowData['product_id'];
  $sale_price   = $rowData['avrgPrice'];
   if($sale_price == "")
  {
    $sale_price = 0;
  }
  $qty   = $rowData['qty'];
  if($qty == "")
  {
    $qty = 0;
  }
  $product_name   = $rowData['product_name'];
  $get_pur_price = "SELECT purchase_price FROM purchase_items WHERE product_id='$product_id' ORDER BY id DESC LIMIT 1";
  $run_pur_price=mysqli_query($connection,$get_pur_price);
  $rowData_pur_price = mysqli_fetch_array($run_pur_price);
  $pur_price = $rowData_pur_price['purchase_price'];
  $data = array('stock_Qty' => $qty,'product_name' => $product_name,'product_id' => $product_id,'sale_price' =>$sale_price,'pur_price'=>$pur_price);
  echo json_encode($data);
}
//Fetch stock qty at first postion
if(isset($_POST['product_id_for_sQty']))
{
  $product_id= $_POST['product_id_for_sQty'];
  
  $select_item = "SELECT id, quantity FROM `stock_items` WHERE product_code = '$product_id' AND quantity > 0 ORDER BY stock_date, id ASC LIMIT 1";
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
    <input type="hidden" name="row[]" value="<?php echo $row_no ?>">
    <input type="hidden" name="singleQty[]" id="singlQty<?php echo $row_no ?>">
    <input type="hidden" name="stockId[]" id="stkId<?php echo $row_no ?>">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label>Product</label>

                <!-- ********************************************************************** -->
                <select class="form-control select2" id="pro_code<?php echo $row_no ?>" name="product_code[]"
                    onchange="checkStock(<?php echo $row_no ?>)" autofocus required>
                    <option value="">Choose</option>
                    <?php
                            $query = "SELECT id, product_code, product_name FROM products";
                            $run_check = mysqli_query($connection, $query);
                            while ($Data = mysqli_fetch_array($run_check)) {
                              $p_id = $Data['id'];
                              $product_id = $Data['product_code'];
                              $product_name = $Data['product_name'];
                            ?>
                    <option value="<?php echo $product_id; ?>" data-product-id="<?php echo $p_id; ?>">
                        <?php echo $product_name; ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" name="product_id[]" id="product_id<?php echo $row_no ?>" value="">
                <!-- ********************************************************************** -->
            </div>
        </div>
        <div class="col-md-2" style="margin-left:-16px; width:124px;">
            <div class="form-group ">
                <label>Purchase P</label>
                <input type="number" name="pur_price[]" id="pur_price<?php echo $row_no ?>" class="form-control"
                    readonly>
            </div>
        </div>
        <div class="col-md-2" style="margin-left:-16px; width:140px;">
            <div class="form-group ">
                <label>Sale Price</label>
                <input type="number" step="any" name="sale_price[]" id="sale_price<?php echo $row_no ?>"
                    onchange="sale_price(<?php echo $row_no ?>)" class="form-control" placeholder="Sale Price">
            </div>
        </div>
        <div class="col-md-2" style="margin-left:-16px; width:132px;">
            <div class="form-group ">
                <label>Weight/kg</label>
                <input type="number" step="any" name="stockQty[]" id="stockQty<?php echo $row_no ?>" readonly
                    class="form-control" placeholder="Stock Qty" required>
            </div>
        </div>
        <div class="col-md-2" style="margin-left:-16px; width:132px;">
            <div class="form-group">
                <label>Weight/kg</label>
                <input type="number" step="any" name="quantity[]" class="form-control" placeholder="Quantity" value="1"
                    onchange="sale_price(<?php echo $row_no ?>)" id="quantity<?php echo $row_no ?>">
            </div>
        </div>
        <div class="col-md-2" style="margin-left:-16px; width:130px;">
            <div class="form-group">
                <label>Cans</label>
                <input type="number" step="any" name="cans[]" class="form-control" placeholder="Number of Cans"
                    id="quantity1" required>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label>Sale Total</label>
                <input type="number" step="any" name="sale_total[]" class="form-control" placeholder="Sale Total"
                    id="sale_total<?php echo $row_no ?>" readonly>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <br>
                <button type="button" class="btn btn-danger shadow" onclick="remove_row(<?php echo $row_no ?>)"><i
                        class="bx bx-minus"></i></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$('.focus').focus();
</script>
<script>
function checkStock(id) {
   // orderRow();
    var pro_code = $("#pro_code" + id).val();

    $.ajax({
        url: 'sale_add_ajax.php',
        method: 'post',
        data: {
            pro_code: pro_code
        },
        dataType: 'json',
        success: function(data) {
            $("#pur_price" + id).val(data.pur_price);
            $("#stockQty" + id).val(data.stock_Qty);
            // $("#sale_price" + id).val(data.sale_price);
            $("#product_id" + id).val(data.product_id);
            sale_price(id);
        }
    }).done(function() {
        singleQuantity(id);
        finaly_discounts();
        remainAmount();
    });
}
</script>
<?php } ?>