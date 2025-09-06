<?php include("include/header.php") ?>
      <div class="page-content container-fluid " style="margin: 40px 0px 0px 0px; overflow-y: none;">
            <h3 class="ps-4">Add Charging</h3>
            <div class="card">
              <div class="card-body my-only-div-shadow ">
                <form method="POST" enctype="multipart/form-data">
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                            <div class="col-md-4">
                              <!-- <input type="checkbox" name="customer_status" onchange="checkcustomer(1)" value="1" id="checkcustomer1"> <b class="text-primary">Creat New Supplier</b> -->
                            </div>
                            <div id="customer_ptr1" style="display: none">
                              <hr>
                              <div class="row">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Supplier Name</label>
                                      <input type="text" placeholder="Supplier Name" name="supplier_name" class="form-control">
                                    </div>
                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Contact</label>
                                      <input type="text" placeholder="Contact" name="supplier_contact" class="form-control">
                                    </div>
                                  </div>
                                </div>
                                <!--/row-->
                                <!--  Start Row  -->
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Opening Balance</label>
                                      <input type="number" placeholder="Opening Balance" name="supplier_opening_balance" class="form-control">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Address</label>
                                      <input type="text" placeholder="Address" name="supplier_address" class="form-control">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <br>
                          <hr>
                      <div class="col-md-6" id="clint_hide1">
                        <div class="form-group">
                          <label>Customer Name</label>
                          <input type="text" class="form-control" name="customer_name"  placeholder="Customer Name" required>
                        </div>
                      </div>
                      <input type="hidden" id="supName" name="suplName">
                      <input type="hidden" id="sup_mobile" name="mobile">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Date</label>
                          <input type="date" class="form-control" name="purchase_date"  value="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                      </div>

                      <div class="col-md-6" id="clint_hide1">
                        <div class="form-group">
                          <label>Product Name</label>
                          <input type="text" class="form-control" name="product_name"  placeholder="Product Name" required>
                        </div>
                      </div>

                      <div class="col-md-6" id="clint_hide1">
                        <div class="form-group">
                          <label>Price</label>
                          <input type="number" class="form-control" name="price"  placeholder="Enter Price" required>
                        </div>
                      </div>

                      <div class="col-md-6" id="clint_hide1">
                        <div class="form-group">
                          <label>Description</label>
                          <textarea type="text" class="form-control" name="description"  placeholder="Description" required></textarea>
                        </div>
                      </div>

                      <div class="col-md-6" id="clint_hide1">
                        <!-- <div class="form-group"> -->
                        <div class="form-group mt-5 ">
                     <input type="submit" name="saveData" class="btn btn-primary shadow" value="Save">
                           </div>
                        <!-- </div> -->
                      </div>
                     <!--  <div class="col-md-4">
                        <div class="form-group">
                          <label>Details</label>
                          <textarea name="purchase_detail" class="form-control" placeholder="Details"></textarea>
                        </div>
                      </div> -->
                    </div>
                    <div class="row mt-4" id="edu_new_row">
                      <div class="col-md-12" id="edu_data_row1">
                        <!-- <input type="hidden" name="row[]" value="1"> -->
                        <div class="row">
                      
                         <!-- remove for this project (Ajmal Batteries)
                           <div class="col-md-2">
                            <div class="form-group ">
                              <label>Product Code</label>
                              <input type="text" step="any" name="product_code[]" id="product_code1" class="form-control"  onchange="checkStock(1)" placeholder="Code" required autofocus>
                            </div>
                          </div> --> 

                              
                            

                          <!-- <div class="col-md-2">
                            <div class="form-group ">
                              <label>Charging Price</label>
                              <input type="number" step="any" name="purchase_price[]" id="purchase_price_Id1" onchange ="Purchase_Price(1)" class="form-control" placeholder="Purchase Price" required>
                            </div>
                          </div> -->
                          <!-- <div class="col-md-2">
                            <div class="form-group ">
                              <label>Sale Price</label>
                              <input type="number" step="any" name="sale_price[]" class="form-control" id="sale_price_Id1" placeholder="Sale Price" required>
                            </div>
                          </div> -->
                          <!-- <div class="col-md-1">
                            <div class="form-group ">
                              <label>Quantity</label>
                              <input type="number" step="any" name="quantity[]" class="form-control" placeholder="Quantity" value="1" onchange ="Purchase_Price(1)" id="quantity1" required>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group ">
                              <label>Charging Total</label>
                              <input type="number" step="any" name="purchase_total[]" class="form-control" placeholder="Purchase Total" id="Purchase_Total_Id1" readonly>
                            </div>
                          </div> -->
                          <!-- <div class="col-md-3 mt-4">
                      <div class="form-group ">
                        <label>Discount</label>
                        <input type="number" step="any" name="discount[]" class="form-control" placeholder="Discount" required onkeyup="First_Discount(1)" id="Discount1">
                      </div>
                    </div>                                   
                    <div class="col-md-3 mt-4">
                      <div class="form-group ">
                        <label>After Discount</label>
                        <input type="number" step="any" name="after_discount[]" class="form-control" placeholder="After Discount" readonly id="Final_Discount1">
                      </div>
                    </div> -->
                          <!-- <div class="col-md-1">
                            <div class="form-group">
                              <br>
                              <button type="button" class="btn btn-dark" onclick="orderRow()"><i class="fa fa-plus"></i></button>
                            </div>
                          </div> -->
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <!-- <div class="col-md-3 mt-4">
                        <div class="form-group ">
                          <label>Purchase Grand Total</label>
                          <input type="number" step="any" name="pur_grand_total" class="form-control" placeholder="Purchase Grand Total" id="purchase_grand_total" readonly>
                        </div>
                      </div>
                      <div class="col-md-3 mt-4">
                        <div class="form-group ">
                          <label>Discount Grand Total</label>
                          <input type="number" step="any" name="disc_grand_total" class="form-control" placeholder="Discount Grand Total" value="0" onkeyup="finaly_Discounts()" id="finaly_Discount">
                        </div>
                      </div> -->
                    </div>
                    
                      <hr>
                    <!-- <div class="row">

                      <div class="col-md-3">
                        <div class="form-group ">
                          <label>Final Charging Amount</label>
                          <input type="number" step="any" name="quan_grand_total" class="form-control"  placeholder="Final Purchase Amount" id="Final_Purchase" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group ">
                          <label>Paid Amount</label>
                          <input type="number" step="any" name="paid" class="form-control" id="paid_amount1" placeholder="Paid Amount">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Payment</label>
                          <select class="form-control select2" name="pay_type">
                            <option value="">Choose</option>
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
                      
                      <div class="col-md-3">
                        <div class="form-group ">
                          <label>Details</label>
                          <textarea name="details" class="form-control" placeholder="Details"></textarea>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group ">
                          <label>Recipt</label>
                          <input type="file" name="recp_file" class="form-control">
                        </div>
                      </div>
                    </div> -->
     <!--                <div class="col-md-4">
                          <input type="checkbox" name="bank_status" onchange="checkTicket(1)" value="1" id="checktkt1"> <b class="text-primary">Transection Through Account</b>
                        </div>
                       <div id="ticket_ptr1" style="display: none">
                        <hr>
                        <div class="row" onkeyup="checkInputs(1)">
                          <div class="col-md-4">
                          <div class="form-group">
                            <label>Select Account</label>
                            <select class="form-control select2" onchange="getbank()" id="accountId" name="account_tittle">
                              <option value="">Choose</option>
                             
                              
                            </select>
                          </div>
                        </div>
                        
                          <div class="col-md-4">
                            <label>Account No</label>
                            <input type="text" id="account_no" class="form-control"  placeholder="Account No" readonly>
                          </div>
                          <div class="col-md-4">
                            <label>Iban</label>
                            <input type="text" id="iban" class="form-control" placeholder="Iban" readonly>
                          </div>
                        </div>
                      </div> -->

                      <div class="col-md-8">
                        <!-- <div class="form-group mt-5 ">
                     <center><input type="submit" name="saveData" class="btn btn-primary shadow" value="Save"></center>
                           </div> -->
                           </div>
                      </div>
                    </div>
                   
                </form>
              </div>
            </div>
          </div>
    <?php include("include/footer.php") ?>

    <?php
    if (isset($_POST['saveData'])) 
    {
        // New Supplier Varaible
            // $supp_name =  $_POST['supplier_name'];
            // $supp_contact = $_POST['supplier_contact'];
            // $supp_opening_balance   = $_POST['supplier_opening_balance'];
            // $supp_address   = $_POST['supplier_address'];
            // $customer_status     = $_POST['customer_status'];
            // end////////////////////
      $customer_name = $_POST['customer_name'];
      $purchase_date = $_POST['purchase_date'];
      $product_name = $_POST['product_name'];
      $price = $_POST['price'];
      $description = $_POST['description'];
   
 
     
      // if ($customer_status == "") 
      // Insertion of purchase
    $query11 = "INSERT INTO `charge` (`customer_name`, `purchase_date`, `product_name`, `price`, `description`) 
    VALUES ('$customer_name', '$purchase_date', '$product_name', '$price', '$description')";
$run1 = mysqli_query($connection, $query11);
// $purchase_id = mysqli_insert_id($connection);
// $count = count($_POST['product_id']);

for ($i = 0; $i < $count; $i++) {
// $product_id = $_POST['product_id'][$i];
// // Extracting product_code from the selected option
// $query = "SELECT product_code FROM products WHERE id = '$product_id'";
// $result = mysqli_query($connection, $query);
// $row = mysqli_fetch_assoc($result);
// $product_code = $row['product_code'];

// $purchase_price = $_POST['purchase_price'][$i];
// $sale_price = $_POST['sale_price'][$i];
// $quantity = $_POST['quantity'][$i];
// $purchase_total = $_POST['purchase_total'][$i];

// Insertion Of purchase Item
// $query = "INSERT INTO `charge_items` (`purchase_id`, `product_id`, `warehouse_id`, `product_code`, `purchase_price`, `sale_price`, `quantity`, `purchase_total`) 
//         VALUES ('$purchase_id', '$product_id', '0', '$product_code', '$purchase_price', '$sale_price', '$quantity', '$purchase_total')";
// $run = mysqli_query($connection, $query);

// $last_id1 = mysqli_insert_id($connection);

// Insertion Of stock_items
// $update_query1 = "INSERT INTO `stock_items` (`product_id`, `purchase_item_id`, `warehouse_id`, `product_code`, `quantity`, `purchase_price`, `sale_price`, `stock_date`) 
//               VALUES ('$product_id', '$last_id1', '0', '$product_code', '$quantity', '$purchase_price', '$sale_price', '$purchase_date')";
// $update_run = mysqli_query($connection, $update_query1);
      }
      // if ($paid != 0) {

      //   $insert2 = "INSERT INTO `cash_history`(`amount`, `pay_status`, `details`, `pay_date`, `pay_person`, `contact`,  `slip_no`, `receipt`, `pay_by`, `supplier_payment_id`, `pay_type_id`) VALUES ('$final_pur_grand_total','OUT','$details','$purchase_date','$suplName','$mobile','$slip_no','$recp_file','Purchase','$supplier_id', '$pay_type')";
      //   $run2 = mysqli_query($connection, $insert2);

      //   /////////Insertion Of supplier_ledger

      // }
      // $query3 = "INSERT INTO `supplier_ledger`(`supplier_id`, `purchase_id`,`payment_id`,`debit`, `credit`, `Ldate`, `details`) VALUES ('$supplier_id','$purchase_id','$pay_type','$paid','$final_pur_grand_total','$purchase_date','$details')";
      // $run3 = mysqli_query($connection, $query3);
      // if ($bank_status == 1) {
      //   $query5 = "INSERT INTO `cash_in_bank_history`( `cash_in_bank_id`, `bank_date`, `detail`, `credit`, `debit`) VALUES ('$account_id','$purchase_date','$details',0,'$paid')";
      // $run5 = mysqli_query($connection, $query5);
      //   // code...
      // }
      if ($run1) {

        echo "<!DOCTYPE html>
      <html>
        <body>
          <script>
          Swal.fire(
          'Added!',
          'Charge has been successfully added!',
          'success'
          ).then((result) => {
          if (result.isConfirmed) {
          window.location.href = 'charge.php';
          }
          });
          </script>
        </body>
      </html>";
      } else {
        echo "<!DOCTYPE html>
              <html>
              <body>
                <script>
                Swal.fire(
                'Error !',
                'Charge not add, Some error occure',
                'error'
                ).then((result) => {
                if (result.isConfirmed) {
                window.location.href = 'charge.php';
                }
                });
                </script>
              </body>
              </html>";
      }

    }
    ?>
    <script type="text/javascript">
      let reorderid = 1;

      function orderRow() {
        reorderid++;
        $.ajax({
          url: 'charge_append_row.php',
          method: 'POST',
          data: {
            count: reorderid
          },
          success(data) {
            $('#edu_new_row').append(data);
            $('.select2').select2({
              theme: 'bootstrap4'

            });
          }

        });
      }

      function remove_edu(id) {
        let div = '#edu_data_row' + id;
        $(div).remove();
        calculate_grand_total();
        finaly_Discounts();
      }
    </script>
    <script type="text/javascript">
      function Purchase_Price(id) {
        var purchase_price_Id = $('#purchase_price_Id' + id).val();
        var quantity = $('#quantity' + id).val();
        $('#Purchase_Total_Id' + id).val((quantity * purchase_price_Id).toFixed(2));
        calculate_grand_total();
        finaly_Discounts();
      }
       function calculate_grand_total()
  {
    var grand_total_amount = 0;
    $("input[name^='row']").each(function () {
    var total_amount_input = "#Purchase_Total_Id" + $(this).val();
    grand_total_amount += Number($(total_amount_input).val());
    });
    $('#paid_amount1').val((grand_total_amount).toFixed(2));
    $('#Final_Purchase').val((grand_total_amount).toFixed(2));
  }

      function getDetails() {
        var suppl_id = $('#supp_iD').val();
       
        $.ajax({
          url: 'supplier_detail_ajax.php',
          type: 'post',
          data: {
            'supplier_id': suppl_id
          },
          dataType: "json",
          success: function(result) {
            $("#supName").val(result.suplier_name);
            $("#sup_mobile").val(result.suplier_mobile);
          }
        });
      }
          function checkTicket(id)
          {
            if($("#checktkt"+id).is(':checked'))
            {
              $("#ticket_ptr"+id).css("display","block");
            }
            else
            {
              $("#ticket_ptr"+id).css("display","none");
            }
            
          }

     function checkcustomer(id) {
            if ($("#checkcustomer" + id).is(':checked')) {
              $("#customer_ptr" + id).css("display", "block");
              $("#clint_hide" + id).css("display", "none");
            } else {
              $("#customer_ptr" + id).css("display", "none");
              $("#clint_hide" + id).css("display", "block");

            }

          }

   function checkStock(id)
  {    
    var pro_code = $("#product_code"+id).val();
    $.ajax({
      url: 'purchase_append_row.php',
      method: 'post',
      data: {

        pro_code: pro_code
      },
      dataType: 'json',
      success : function(data) {
        $("#product_id"+id).val(data.product_name);
        $("#product_idd"+id).val(data.product_id);
      }

    });

  
  
  }
    </script>