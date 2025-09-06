  <?php include("include/header.php") ?>
  <div class="page-content container-fluid">
      <!--  Start Row  -->
      <style type="text/css">
      body {
          overflow-y: auto;
      }
      </style>

      <div class="card my-only-div-shadow">
          <div class="card-body mt-3">
              <h3>Add Sale</h3>
              <form method="POST" enctype="multipart/form-data" id="form">
                  <div class="row">
                      <!-- new Customer Add -->
                      <div class="col-md-12">
                          <!--             <div class="col-md-4">
              <input type="checkbox" name="customer_status" onchange="checkcustomer(1)" value="1" id="checkcustomer1"> <b class="text-primary">Creat New Customer</b>
            </div> -->
                          <div id="customer_ptr1" style="display: none">
                              <hr>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>Customer Name</label>
                                          <input type="text" class="form-control" placeholder="Enter Customer Name"
                                              name="cust_name">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>Contact</label>
                                          <input type="text" class="form-control" placeholder=" Enter Contact"
                                              name="cust_contact">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>Opening Balance</label>
                                          <input type="number" class="form-control" placeholder="Enter Opening Balance"
                                              name="cust_opening_balance">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>Address</label>
                                          <input type="text" class="form-control" placeholder="Enter Address"
                                              name="cust_address">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <hr>

                      <input type="hidden" id="custName" name="custName">
                      <input type="hidden" id="cust_mobile" name="mobile">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label style="display: flex; justify-content: space-between; align-items: center;">
                                  Customer
                                  <input type="checkbox" id="customerCheckbox" name="customerCheckbox"
                                      value="check_cust_name">
                              </label>
                              <select class="form-control select2" required name="customer_id" id="custID">
                                  <option value="1" selected>Walk-In</option>
                                  <?php
      $query = "SELECT name,id FROM customer where id != '1' order by id ASC";
      $run_check = mysqli_query($connection, $query);
      while ($Data = mysqli_fetch_array($run_check)) {
        $cust_id = $Data['id'];
        $name  = $Data['name'];
      ?>
                                  <option value="<?php echo $cust_id; ?>"><?php echo $name; ?></option>
                                  <?php } ?>
                              </select>
                              <input type="text" class="form-control" id="customerSearch" name="customerSearch"
                                  placeholder="Type Walk-in Cusotmer Name" style="display: none;">
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="form-group">
                              <label>Date</label>
                              <input type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>"
                                  name="sale_date" required>
                          </div>
                      </div>
                  </div>
                  <div class="row " id="append_row">
                      <div class="col-md-12" id="new_row1">
                          <input type="hidden" name="row[]" value="1">
                          <input type="hidden" name="singleQty[]" id="singlQty1">
                          <input type="hidden" name="stockId[]" id="stkId1">
                          <input type="hidden" name="final_ware_house_id[]" id="final_ware_house_id1">
                          <div class="row">

                              <!-- <div class="col-md-2">
                <div class="form-group">
                  <label>Product Code</label>
                  <input type="text" name="product_code[]" step="any" class="form-control"  id="pro_code1"  onchange="checkStock(1)">
                   
                </div>
              </div>  -->

                              <div class="col-md-2">
                                  <div class="form-group">
                                      <label>Product</label>

                                      <!-- <input type="text" class="form-control" id="product_id1" readonly>
                <input type="hidden" class="form-control" name="product_id[]" id="product_idd1" readonly> -->

                                      <!-- ********************************************************************** -->
                                      <select class="form-control select2" name="product_code[]" id="pro_code1"
                                          onchange="checkStock(1)" required>
                                          <option value="1">Choose</option>
                                          <?php
            $query = "SELECT id, product_code, product_name FROM products";
            $run_check = mysqli_query($connection, $query);
            while ($Data = mysqli_fetch_array($run_check)) {
                $p_id = $Data['id'];
                $product_id = $Data['product_code'];
                $product_name = $Data['product_name'];
            ?>
                                          <option value="<?php echo $product_id; ?>"
                                              data-product-id="<?php echo $p_id; ?>"><?php echo $product_name; ?>
                                          </option>
                                          <?php } ?>
                                      </select>

                                      <!-- Hidden input field for product_id -->
                                      <input type="hidden" name="product_id[]" id="product_id1" value="">

                                      <!-- ********************************************************************** -->
                                  </div>
                              </div>

                              <div class="col-md-2" style="margin-left:-16px; width:124px;">
                                  <div class="form-group ">
                                      <label>Purchase P</label>
                                      <input type="number" name="pur_price[]" id="pur_price1" class="form-control"
                                          readonly>
                                  </div>
                              </div>

                              <div class="col-md-2" style="margin-left:-16px; width:140px;">
                                  <div class="form-group ">
                                      <label>Sale Price</label>
                                      <input type="number" step="any" name="sale_price[]" id="sale_price1"
                                          class="form-control" placeholder="Sale Price" onchange="sale_price(1)"
                                          required>
                                  </div>
                              </div>
                              <div class="col-md-2" style="margin-left:-16px; width:132px;">
                                  <div class="form-group ">
                                      <label>Weight/kg</label>
                                      <input type="number" step="any" name="stockQty[]" id="stockQty1"
                                          class="form-control" placeholder="Stock Qty" required readonly>
                                  </div>
                              </div>

                              <div class="col-md-2" style="margin-left:-16px; width:132px;">
                                  <div class="form-group">
                                      <label>Weight/kg</label>
                                      <input type="number" step="any" name="quantity[]" class="form-control"
                                          placeholder="Quantity" value="1" onchange="sale_price(1)" id="quantity1"
                                          required>
                                  </div>
                              </div>
                              <div class="col-md-2" style="margin-left:-16px; width:130px;">
                                  <div class="form-group">
                                      <label>Cans</label>
                                      <input type="number" step="any" name="cans[]" class="form-control"
                                          placeholder="Cans Qty" id="quantity1" required>
                                  </div>
                              </div>
                              <div class="col-md-2">
                                  <div class="form-group">
                                      <label>Sale Total</label>
                                      <input type="number" step="any" name="sale_total[]" class="form-control"
                                          placeholder="Sale Total" id="sale_total1" readonly>
                                  </div>
                              </div>
                              <div class="col-md-1">
                                  <div class="form-group">
                                      <br>
                                      <button type="button" onclick="orderRow()" class="btn btn-dark"><i
                                              class="fa fa-plus"></i></button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-md-2 ">
                          <div class="form-group ">
                              <label>Final Sale Amount</label>
                              <input type="number" step="any" name="final_grand_total" class="form-control"
                                  placeholder="Final Sale Amount" id="final_sale1" readonly onchange="discounts(1)">
                          </div>
                      </div>
                      <!--  <div class="col-md-2 ">
              <div class="form-group ">
                <label>Discount</label>
                <input type="number" step="any" name="discount" class="form-control" placeholder="Discount" id="discount1" onchange="discounts(1)">
              </div>
            </div> -->
                      <div class="col-md-2 ">
                          <div class="form-group ">
                              <label>Paid Amount</label>
                              <input type="number" step="any" name="paid" id="paid_amount1" class="form-control"
                                  required placeholder="Paid Amount" onchange="remainAmount(1)">
                          </div>
                      </div>
                      <div class="col-md-2 ">
                          <div class="form-group ">
                              <label>Remaining Amount</label>
                              <input type="number" step="any" name="remain_amount" id="remainId1" class="form-control"
                                  placeholder="Remaining Amount" value="0" readonly>
                          </div>
                      </div>
                      <div class="col-md-2">
                            <div class="form-group">
                                <label>Payment Type</label>
                                <select class="form-control select2" name="pay_type">
                                    <?php
                            $query = "SELECT method,id FROM payment_method";
                            $run_check = mysqli_query($connection, $query);
                            while ($Data = mysqli_fetch_array($run_check)) {
                              $method_id = $Data['id'];
                              $method  = $Data['method'];
                            ?>
                                    <option value="<?php echo $method_id; ?>"><?php echo $method; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                      <div class="col-md-4 ">
                          <div class="form-group ">
                              <label>Details</label>
                              <textarea name="details" id="details" class="form-control"
                                  placeholder="Details"></textarea>
                          </div>
                      </div>

                      <div class="modal-footer">
                          <button class="btn btn-info" class="form-control" id="myBtn">Save</button>
                      </div>
              </form>

              <?php
       if (isset($_POST['details'])) {

          // new Customer ADD
        $cust_name =  $_POST['cust_name'];
        $cust_contact = $_POST['cust_contact'];
        $cust_opening_balance   = $_POST['cust_opening_balance'];
        $cust_address   = $_POST['cust_address'];
         // $customer_status     = $_POST['customer_status'];
        // end
          $customer_id = $_POST['customer_id'];
          $custName = $_POST['custName'];
          $mobile = $_POST['mobile'];
          $sale_date = $_POST['sale_date'];
          $final_grand_total = $_POST['final_grand_total'];
          $paid   = $_POST['paid'];
          $details   = $_POST['details'];
          $discount   = $_POST['discount'];
          $remain_amount   = $_POST['remain_amount'];
          $pay_type   = $_POST['pay_type'];

     
          ///////////Insertion of sale
           // $product_code1 = $_POST['product_code'];
           $stockQty1 = $_POST['stockQty'];
            $quantity1 = $_POST['quantity'];
       // $check="SELECT quantity FROM stock_items where quantity <= $stockQty1 AND `product_code`= '$product_code1'";

          if ($stockQty1 < $quantity1) {
             echo "<!DOCTYPE html>
            <html>
              <body>
                <script>
                Swal.fire(
                'Error !',
                'Stock Not Available',
                'error'
                ).then((result) => {
                if (result.isConfirmed) {
                }
                });
                </script>
              </body>
            </html>";
          } else {
          if(isset($_POST['customerCheckbox'])){
            $walk_in_cust_name   = $_POST['customerSearch'];
          }else{
            $walk_in_cust_name=0;
          }
          $query1 = "INSERT INTO `sale`(`customer_id`,`walk_in_cust_name`, `discount`, `after_discount`, `sale_date`) VALUES ('$customer_id','$walk_in_cust_name','$discount','$final_grand_total','$sale_date')";
          $run1 = mysqli_query($connection, $query1);
          $sale_id = mysqli_insert_id($connection);

          if($pay_type==1){
            $query_new = "INSERT INTO `account_cash`(`type`,`identifier`,`details`,`credit`,`debit`,`balance`,`date`) 
            VALUES ('1','sale','$details','$paid','0','$remain_amount','$sale_date')";
          }elseif($pay_type==2){
            $query_new = "INSERT INTO `account_cash`(`type`,`identifier`,`details`,`credit`,`debit`,`balance`,`date`) 
            VALUES ('2','sale','$details','$paid','0','$remain_amount','$sale_date')";
          }
          $run_query_new = mysqli_query($connection, $query_new);

          $count = COUNT($_POST['row']);

          for ($i = 0; $i < $count; $i++) {
            $product_id = $_POST['product_id'][$i];

            $product_code = $_POST['product_code'][$i];
          $sale_price = $_POST['sale_price'][$i];
          $stockQty = $_POST['stockQty'][$i];
            $pur_price = $_POST['pur_price'][$i];
            $quantity = $_POST['quantity'][$i];
            $no_of_cans = $_POST['cans'][$i];

            $sale_total = $_POST['sale_total'][$i];

            $req_total = $quantity;
            $singleQty = $_POST['singleQty'][$i];
            $stockId = $_POST['stockId'][$i];
// ...

// Insertion Of Sale Item
$query = "INSERT INTO `sale_items`(`sale_id`, `product_id`,`warehouse_id`,`product_code`, `price`, `stock_qty`, `quantity`, `cans`, `total_price`) 
VALUES ('$sale_id','$product_id','0','$product_code','$sale_price','$stockQty','$quantity','$no_of_cans','$sale_total')";
$run = mysqli_query($connection, $query);

// Update Stock
if ($singleQty >= $req_total) {
  $newqty = $singleQty - $req_total;
  $query = "UPDATE stock_items SET quantity = '$newqty' WHERE id = '$stockId' ";
  $runU = mysqli_query($connection, $query);
} else {
  $stock_item = "SELECT id, quantity FROM `stock_items` WHERE product_id = '$product_id' AND quantity > 0 ORDER BY stock_date ASC";
  $get_stock = mysqli_query($connection, $stock_item);
  while ($rowStock = mysqli_fetch_array($get_stock) and $req_total > 0) {
    $stk_id = $rowStock['id'];
    // $ware_houose_id = $rowStock['warehouse_id'];
    $stk_qty = $rowStock['quantity'];

    if ($stk_qty < $req_total) {
      $req_total -= $stk_qty;
      $update_sql = "UPDATE `stock_items` SET `quantity` = 0 WHERE id='$stk_id' ";
    } else {
      $req_total = $stk_qty - $req_total;
      $update_sql = "UPDATE `stock_items` SET `quantity`='$req_total', cans = cans - '$no_of_cans'  WHERE id='$stk_id' ";
      $req_total = 0;
    }
    $update_stock_item = mysqli_query($connection, $update_sql);
  }
}

// Update Cans
// $cans_query = "UPDATE stock_items SET cans = cans - '$no_of_cans' WHERE id = '$stockId' ";
// $cans_run = mysqli_query($connection, $cans_query);
            
          }
       
          /////Insertion Of customer_payment
          if ($paid != 0) {
            $query2 = "INSERT INTO `customer_payment`(`sale_id`, `customer_id`, `payment_method_id`, `paid`, `payment_date`, `details`, `receipt`) VALUES ('$sale_id','$customer_id','Direct','$paid','$sale_date','$details','0')";
            $run2 = mysqli_query($connection, $query2);
          }
          ////Insertion Of customer_ledger
          $query3 = "INSERT INTO `customer_ledger`(`customer_id`, `sale_id`, `payment_id`, `debit`, `credit`, `Ldate`, `details`) VALUES ('$customer_id','$sale_id','Direct','$paid','$final_grand_total','$sale_date','$details')";
          $run3 = mysqli_query($connection, $query3);
          if ($run1) {
              $insert2 = "INSERT INTO `cash_history`(`amount`, `pay_status`, `details`, `pay_date`, `pay_person`, `contact`,  `slip_no`, `receipt`, `pay_by`, `supplier_payment_id`, `pay_type_id`) VALUES ('$paid','IN','$details','$sale_date','$custName','$mobile','0','0','Sale','$customer_id', 'Direct')";
        $run2 = mysqli_query($connection, $insert2);
            echo "<!DOCTYPE html>
            <html>
              <body>
                <script>
                Swal.fire(
                'Added!',
                'Sale has been successfully added!',
                'success'
                ).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = 'sale_print.php?id=$sale_id&discount=$discount&paid=$paid&remain_amount=$remain_amount';
                }
                });
                </script>
              </body>
            </html>";
          }

           else {

            echo "<!DOCTYPE html>
            <html>
              <body>
                <script>
                Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'Sale not add, Some error occure',
                  timer: 1500, // 1.5 seconds
                  showConfirmButton: false
                }).then(() => {
               window.location.href = 'sale_add.php';
                });
                </script>
              </body>
            </html>";
          }
          } }
          
        ?>
          </div>
      </div>
      <!-- End Row  -->
  </div>
  <?php include("include/footer.php") ?>


  <script type="text/javascript">
var countRows = 1;

function orderRow() {
    countRows++;
    $.ajax({

        url: 'sale_add_ajax.php',
        method: 'POST',
        data: {
            row_no: countRows
        },
        success(data) {

            $('#append_row').append(data);


            $('.select2').select2({
                theme: 'bootstrap4'
            });
        }
    });

}

function remove_row(id) {
    let div = '#new_row' + id;
    $(div).remove();
    calculate_grand_total();
    finaly_discounts();

}

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
            $("#product_id" + id).val(data.product_id); // Update the hidden product_id field
            sale_price(id);
        }
    }).done(function() {
        singleQuantity(id);
        finaly_discounts();
        remainAmount();
    });
}


function singleQuantity(id) {

    var prod_id = $("#product_code" + id).val();
    $.ajax({
        type: 'POST',
        url: 'sale_add_ajax.php',
        dataType: "json",
        data: {
            product_id_for_sQty: prod_id,
            sale_price: sale_price
        },
        success: function(data) {
            $('#singlQty' + id).val(data.quantity);
        }
    });
}

function sale_price(id) {
    var salePrice = $('#sale_price' + id).val();
    var quantity = $('#quantity' + id).val();
    $('#sale_total' + id).val((quantity * salePrice).toFixed(2));
    calculate_grand_total();
    //discounts();
    remainAmount();
}

function calculate_grand_total() {
    var grand_total_amount = 0;
    $("input[name^='row']").each(function() {
        var total_amount_input = "#sale_total" + $(this).val();
        grand_total_amount += Number($(total_amount_input).val());
    });
    // $('#remainId1').val((grand_total_amount).toFixed(2));
    $('#final_sale1').val((grand_total_amount).toFixed(2));
    //  remainAmount();
}

function discounts(id) {
    // alert();
    var final_sale = $('#final_sale' + id).val();
    var discount = 0;
    //var discount=$('#discount'+ id).val();
    $('#final_sale' + id).val((final_sale - discount).toFixed(2));
    // $('#remainId'+ id).val((final_sale-discount).toFixed(2));

    $('#paid_amount' + id).val((final_sale - discount).toFixed(2));

    // var final_sale = parseFloat($('#final_sale' + id).val()) || 0;
    //   var discount = parseFloat($('#discount' + id).val()) || 0;
    //   var newpaid = final_sale - discount;
    //   $('#final_sale' + id).val(newpaid.toFixed(2));
    //     $('#remainId1').val((grand_total_amount).toFixed(2));
    //calculate_grand_total();
    //finaly_discounts();
    //remainAmount();
}

// function remainAmount(id)
// {

//    var Paidamount=$('#paid_amount'+id).val();
//   var final_sale=$('#final_sale'+id).val();
//       $('#remainId'+id).val((final_sale-Paidamount).toFixed(2));

// }

function remainAmount(id) {
    // var discount = parseFloat($('#discount' + id).val()) || 0;
    // var paidAmount = parseFloat($('#paid_amount' + id).val()) || 0;
    // var finalSale = parseFloat($('#final_sale' + id).val()) || 0;
    // var paidAmountAfterDiscount = paidAmount + discount;
    // var remainingAmount = finalSale - paidAmountAfterDiscount;
    // $('#remainId' + id).val(remainingAmount.toFixed(2));

    var remainId = parseFloat($('#final_sale' + id).val()) || 0;
    var paidAmount = parseFloat($('#paid_amount' + id).val()) || 0;

    $('#remainId' + id).val((remainId - paidAmount).toFixed(2));


    //discounts();
    //calculate_grand_total();

}
  </script>
  <script type="text/javascript">
function getDetails() {
    var custID = $('#custID').val();

    $.ajax({
        url: 'customer_detail_ajax.php',
        type: 'post',
        data: {
            'customer_id': custID
        },
        dataType: "json",
        success: function(result) {
            $("#custName").val(result.customer_name);
            $("#cust_mobile").val(result.customer_mobile);
        }
    });
}
// disable bank inputs
function checkTicket(id) {
    if ($("#checktkt" + id).is(':checked')) {
        $("#ticket_ptr" + id).css("display", "block");
    } else {
        $("#ticket_ptr" + id).css("display", "none");
    }

}

function getbank() {
    var accountId = $('#accountId').val();
    $.ajax({
        url: 'account_detail_jason.php',
        type: 'post',
        data: {
            'accountId': accountId
        },
        dataType: "json",
        success: function(result) {
            $("#account_no").val(result.account_no);
            $("#iban").val(result.acount_iban);
        }
    });
}
// new customer Hide AND Show
function checkcustomer(id) {
    if ($("#checkcustomer" + id).is(':checked')) {
        $("#customer_ptr" + id).css("display", "block");
        $("#clint_hide" + id).css("display", "none");
    } else {
        $("#customer_ptr" + id).css("display", "none");
        $("#clint_hide" + id).css("display", "block");

    }

}

function findTotalQty(id) {

    var totalQty = 0;
    $("input[name^='row']").each(function() {
        var total_amount_input = "#stockQty" + $(this).val();
        if ($(total_amount_input).val() == '') {
            total = 0;
        } else {
            total = parseFloat($(total_amount_input).val());
        }
        totalQty = total;
    });

    if (totalQty > 0) {
        Swal.fire(
            'Error !',
            'Total Quantity must be less than Stock Quantity!',
            'error'
        );
        $("#savebtn").attr("disabled", "disabled");

    } else {
        $("#savebtn").removeAttr("disabled");
    }
}
$('#pro_code1').focus();
  </script>


  <script>
var input = document.getElementById("details");
input.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("myBtn").click();
    }
});
  </script>

  <script>
document.getElementById('customerCheckbox').addEventListener('change', function() {
    var searchInput = document.getElementById('customerSearch');
    if (this.checked) {
        searchInput.style.display = 'block';
    } else {
        searchInput.style.display = 'none';
    }
});
  </script>