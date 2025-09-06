<?php
session_start();
if (!isset($_SESSION['admin_pos'])) {
  echo "<script>window.location.href = '../../index.php'; </script>";
}
$user_id = $_SESSION['admin_pos'];
$curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
$fetchData1 = "SELECT * FROM system_users WHERE id='$user_id'";
$runData1 = mysqli_query($connection, $fetchData1);
$rowData1 = mysqli_fetch_array($runData1);

  $role_id       = $rowData1['role_id'];
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function() {
            //alert("Document is ready!");
           // alert(<?php echo $role_id; ?>);
          if(<?php echo $role_id; ?> != 1 )  {
            $('.z').hide();
           
          }
          else{
             $('.z').show();
          }
        });
    </script>
<!--sidebar wrapper -->
<div class="sidebar-wrapper printBlock" data-simplebar="true">

  <div class="sidebar-header ">
    <a href="dashboard.php" class="d-flex justify-content-center">
      <div>
        <!-- <img src="../../images/fun_logo.jpeg" width="100%" height="100%"  alt="logo icon"> -->
        <h4 class="mt-2">MG POS</h4>
      </div>
      <div>
      </div>
    </a>
    <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
    </div>
  </div>
  <!--navigation-->

  <ul class="metismenu" id="menu" >
    <li>
      <a href="dashboard.php">
        <div class="parent-icon"><i class='bx bx-home'></i>
        </div>
        <div class="menu-title">Dashboard</div>
      </a>

    </li>
<!--   <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class='bx bx-money'></i>
        </div>
        <div class="menu-title">Cash In Hand</div>
      </a>
      <ul>
        <?php
        $menuCheck = "SELECT * FROM cash_in_hand";
        $runmenuCheck = mysqli_query($connection, $menuCheck);
        $countCheck = mysqli_num_rows($runmenuCheck);
        if ($countCheck == 0) {
        ?>
          <li> <a href="open_account.php"><i class="bx bx-right-arrow-alt"></i>Open Account</a>
          </li>

        <?php } else { ?>
          <li> <a href="cash_in_hand.php"><i class="bx bx-right-arrow-alt"></i>Cash In Hand</a>
          </li>
        <?php } ?>
      </ul>
    </li>  -->
   <!--    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class='bx bxs-bank'></i>
        </div>
        <div class="menu-title">Cash In Bank</div>
      </a>
      <ul>
          <li> <a href="open_bank_account.php"><i class="bx bx-right-arrow-alt"></i>Create Account</a>
          </li>
          <li> <a href="bank_account_detail.php"><i class="bx bx-right-arrow-alt"></i>Account Detail</a>
          </li>
          <li> <a href="bank_account_debit.php"><i class="bx bx-right-arrow-alt"></i>Debit</a>
          </li>
      </ul>
    </li> -->
    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bxl-sass'></i>
        </div>
        <div class="menu-title">Sale</div>
      </a>
      <ul>
        <li><a href="sale_add.php"><i class="bx bx-right-arrow-alt"></i>Add Sale</a>
        </li>
        <li class="z"><a href="sale_details.php"><i class="bx bx-right-arrow-alt"></i>Sale Detail</a>
        </li>

      </ul>
    </li>
       <li class="z">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bx-purchase-tag'></i>
        </div>
        <div class="menu-title">Purchase</div>
      </a>
      <ul>
        <li><a href="purchase.php"><i class="bx bx-right-arrow-alt"></i>Add Purchase</a>
        </li>
        <li><a href="purchase_detail.php"><i class="bx bx-right-arrow-alt"></i>Purchase Detail</a>
        </li>
      </ul>
    </li>


    <li class="z">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class='bx bx-cart-alt'></i>
        </div>
        <div class="menu-title">Products</div>
      </a>
      <ul>
        <li> <a href="add_product.php"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
        </li>
        <li> <a href="product_details.php"><i class="bx bx-right-arrow-alt"></i>Product Details</a>
        </li>
      </ul>
    </li>

    <li class="z">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bx-user'></i>
        </div>
        <div class="menu-title">Supplier</div>
      </a>
      <ul>
        <li> <a href="supplier.php"><i class="bx bx-right-arrow-alt"></i>Supplier</a>
        </li>
        <li> <a href="supplier_payment.php"><i class="bx bx-right-arrow-alt"></i>Payment</a>
        </li>
        <li> <a href="supplier_payment_list.php"><i class="bx bx-right-arrow-alt"></i>Payment List</a>
        </li>
        <li> <a href="supplier_payment_details.php"><i class="bx bx-right-arrow-alt"></i>Payment Details</a>
        </li>
        <!-- <li> <a href="supplier_ledger.php"><i class="bx bx-right-arrow-alt"></i>Ledger</a>
        </li> -->
      </ul>
    </li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bx-user'></i>
        </div>
        <div class="menu-title">Customer</div>
      </a>
      <ul>
        <li> <a href="customer_add.php"><i class="bx bx-right-arrow-alt"></i>Customer</a>
        </li>
        <li> <a href="customer_payment.php"><i class="bx bx-right-arrow-alt"></i>Customer Payment</a>
        </li>
        <li> <a href="customer_payment_list.php"><i class="bx bx-right-arrow-alt"></i>Payment List</a>
        </li>
       <li> <a href="customer_payment_details.php"><i class="bx bx-right-arrow-alt"></i>Payment Details</a></li>
       <li> <a href="customer_ledger.php"><i class="bx bx-right-arrow-alt"></i>Customer Ledger</a>
        </li>
      </ul>
    </li>
 <!--   <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bx-store'></i>
        </div>
        <div class="menu-title">Stock</div>
      </a>
      <ul>
        <li><a href="stock_detail.php"><i class="bx bx-right-arrow-alt"></i>Stock Detail</a>
        </li>
      </ul> 
    </li> -->

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bx-spreadsheet'></i>
        </div>
        <div class="menu-title">Reports</div>
      </a>
      <ul>
      <li><a href="purchase_pro_and_date_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Purchase Report</a></li>
      <li><a href="sale_product_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Sale Report</a></li>
      <li><a href="customer_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Customer Payment Report</a></li>
      <li><a href="supplier_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Supplier Payment Report</a></li>
      <li><a href="stock_product_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Stock Product Report</a></li>
      <li><a href="report_expenses.php"><i class="bx bx-right-arrow-alt"></i>Expences Report</a></li>
      </ul>
    </li>

    <!-- <li class ="z">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bx-spreadsheet'></i>
        </div>
        <div class="menu-title">Purchase Reports</div>
      </a>
      <ul>
       <li><a href="purchase_date_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Date Wise Report</a>
        </li> 
        <li><a href="purchase_pro_and_date_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Product Wise Report</a>
        </li>
      <li><a href="report_purchase_avg_price.php"><i class="bx bx-right-arrow-alt"></i>Average Wise Report</a>
        </li>
      </ul>
    </li>

    <li class ="z">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bx-spreadsheet'></i>
        </div>
        <div class="menu-title">Sale Reports</div>
      </a>
      <ul>
      <li><a href="sale_date_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Date Wise Report</a>
        </li>
        <li><a href="sale_product_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Product Wise Report</a>
        </li>
      </ul>
    </li>

     <li class ="z">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bx-spreadsheet'></i>
        </div>
        <div class="menu-title">Stock Reports</div>
      </a>
      <ul>
        <li><a href="stock_product_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Stock Product Report</a>
        </li>
     <li><a href="sale_product_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Product Wise Report</a>
        </li>
     </ul>
    </li>

      
   <li>

      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bx-spreadsheet'></i>
        </div>
        <div class="menu-title">Customer Reports</div>
      </a>
      <ul>
        <li><a href="customer_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Customer Payment Report</a>
        </li>
      </ul>
    </li>
     <li class ="z">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon "><i class='bx bx-spreadsheet'></i>
        </div>
        <div class="menu-title">Supplier Reports</div>
      </a>
      <ul>
        <li><a href="supplier_wise_report.php"><i class="bx bx-right-arrow-alt"></i>Supplier Payment Report</a>
        </li>
      </ul>
    </li>
      <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class='bx bx-spreadsheet'></i>
        </div>
        <div class="menu-title">Expences Reports</div>
      </a>
      <ul>
        <li><a href="report_expenses.php"><i class="bx bx-right-arrow-alt"></i>Expences Report</a>
        </li>
      </ul>
    </li>
    <li><a href="profit_loss_report.php"><div class="parent-icon"><i class="bx bx-arrow-to-top"></i></div>Profit & Loss</a></li>
    <li>
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class='bx bx-export' ></i>
            </div>
            <div class="menu-title">Expenses</div>
          </a>
          <ul>
           <li> <a href="expense_add.php"><i class="bx bx-right-arrow-alt"></i>Add Expenses</a>
            </li>
            <li> <a href="expenses_list.php"><i class="bx bx-right-arrow-alt"></i>List Expenses</a>
            </li>
          </ul>
        </li> -->


         <li class ="z">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class='bx bx-export' ></i>
            </div>
            <div class="menu-title">Sale Return</div>
          </a>
          <ul>
            <li> <a href="total_sale.php"><i class="bx bx-right-arrow-alt"></i>Sale List</a>
            </li>

         <li> <a href="sale_return_list.php"><i class="bx bx-right-arrow-alt"></i>Return Product List</a></li>
          </ul>
        </li>
        <li class ="z">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class='bx bx-export' ></i>
            </div>
            <div class="menu-title">Purchase Return</div>
          </a>
          <ul>
            <li> <a href="total_purchase.php"><i class="bx bx-right-arrow-alt"></i>Purchase List</a>
            </li>

         <li> <a href="purchase_return_list.php"><i class="bx bx-right-arrow-alt"></i>Return Product List</a></li>
          </ul>
        </li>

    <li class ="z">
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class='bx bx-cog'></i>
        </div>
        <div class="menu-title">Setting</div>
      </a>
      <ul>
        <li><a href="category.php"><i class="bx bx-right-arrow-alt"></i>Model/Category</a>
        </li>
        <li><a href="payment_type.php"><i class="bx bx-right-arrow-alt"></i>Add Payment Type</a>
            </li>
     <!--     <li><a href="add_ware_house.php"><i class="bx bx-right-arrow-alt"></i>Add Ware House</a>
            </li> -->
        <!-- <li><a href="unit.php"><i class="bx bx-right-arrow-alt"></i>Unit</a>
        </li> 
        <li><a href="expense_cat.php"><i class="bx bx-right-arrow-alt"></i>Expenses Category</a>
            </li>
             <li><a href="cash_in_out.php"><i class="bx bx-right-arrow-alt"></i>Cash IN & OUT User</a> -->
            </li>        
      </ul>
    </li>
    <li class ="z"><a href="dbBackup.php"><i class="bx bx-right-arrow-alt"></i>DB Backup </a>
            </li>
           <!--     <li><a href="barcode_print.php"><i class="bx bx-right-arrow-alt"></i>Bar Code Print </a>
            </li>  --> 
  </ul>
  <!--end navigation-->

</div>
<!--end sidebar wrapper -->

