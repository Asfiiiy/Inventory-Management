<?php
include("include/db.php");

if(isset($_POST['pro_code']))
{
  

  $pro_code = $_POST['pro_code'];
  $query = "SELECT * FROM  products WHERE product_code = '$pro_code'";
  $result = mysqli_query($connection,$query);
  $rowData = mysqli_fetch_array($result);

  $product_id   = $rowData['id'];
  $product_name   = $rowData['product_name'];
  $data = array('product_name' => $product_name,'product_id' => $product_id);
  echo json_encode($data);
}
if(isset($_POST['count']))
{
  $count= $_POST['count'];
?>
<div class="col-md-12" id="edu_data_row<?php echo $count ?>">
  <hr class="shadow">
  <input type="hidden"  name="row[]" value="<?php echo $count ?>">
  <div class="row">
   
   <!-- <div class="col-md-2">
      <div class="form-group ">
        <label>Products Code</label>
        <input type="text" step="any" name="product_code[]" id="product_code<?php echo $count ?>" onchange="checkStock(<?php echo $count ?>)" autofocus class="form-control" placeholder="Code" required>
      </div> 
        </div> -->
 <div class="col-md-2">
      <div class="form-group">
        <label>Products</label>
       <!-- <input type="text" class="form-control" id="product_id<?php echo $count ?>"  readonly>
        <input type="hidden" class="form-control" id="product_idd<?php echo $count ?>" name="product_id[]"  readonly>  -->

        <!-- ****************************************************** -->
        <select class="form-control select2" id="product_id1" name="supplier_id" required>
                            <option value="">Choose</option>
                            <?php
                            $query = "SELECT id, product_name FROM products";
                            $run_check = mysqli_query($connection, $query);
                            while ($Data = mysqli_fetch_array($run_check)) {
                              $product_id = $Data['id'];
                              $product_name  = $Data['product_name'];
                            ?>
                              <option value="<?php echo $product_id; ?>"><?php echo $product_name; ?>
                              </option>
                            <?php } ?>
                          </select>

                              <!-- ****************************************************** -->

      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group ">
        <label>Purchase Price</label>
        <input type="number" step="any" name="purchase_price[]" id="purchase_price_Id<?php echo $count ?>" onkeyup="Purchase_Price(<?php echo $count ?>)" class="form-control" placeholder="Purchase Price" required>
      </div>
      </div>
      <!-- <div class="col-md-2">
      <div class="form-group ">
        <label>Sale Price</label>
        <input type="number" step="any" name="sale_price[]" id="sale_price_Id<?php echo $count ?>" class="form-control" placeholder="Sale Price" required>
      </div>
    </div> -->
    <div class="col-md-1">
      <div class="form-group ">
        <label>Quantity</label>
        <input type="number" step="any" name="quantity[]" class="form-control" placeholder="Quantity" value="1" onchange="Purchase_Price(<?php echo $count ?>)" id="quantity<?php echo $count ?>" required>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group ">
        <label>Purchase Total</label>
        <input type="number" step="any" name="purchase_total[]" class="form-control" placeholder="Purchase Total" readonly id="Purchase_Total_Id<?php echo $count ?>">
      </div>
    </div>
    <div class="col-md-1">
      <br>
      <button type="button" class="btn btn-danger shadow" onclick="remove_edu(<?php echo $count ?>)"><i
      class="bx bx-minus"></i></button>
    </div>
  </div>
</div>

<?php } ?>