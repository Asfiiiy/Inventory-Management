<?php
include("include/header.php");

// Set date for daily calculations
$dialy_Date = date('Y-m-d');


// Total Sale
$queryTotalSale1 = "SELECT SUM(after_discount) AS TotalSale FROM sale";
$runTotalSale1 = mysqli_query($connection, $queryTotalSale1);
$rowTotalSale1 = mysqli_fetch_array($runTotalSale1);
$TotalSale1 = $rowTotalSale1['TotalSale'] ?: 0;  // Assign 0 if the result is null or empty

// Total Purchase
$queryTotalPurchase1 = "SELECT SUM(after_discount_purchase) AS TotalPurchase FROM purchase";
$runTotalPurchase1 = mysqli_query($connection, $queryTotalPurchase1);
$rowTotalPurchase1 = mysqli_fetch_array($runTotalPurchase1);
$TotalPurchase1 = $rowTotalPurchase1['TotalPurchase'] ?: 0;  // Assign 0 if the result is null or empty

// Total Sale for the current day
$queryTotalSale = "SELECT SUM(after_discount) AS TotalSale FROM sale WHERE sale_date = '$dialy_Date'";
$runTotalSale = mysqli_query($connection, $queryTotalSale);
$rowTotalSale = mysqli_fetch_array($runTotalSale);
$TotalSale = $rowTotalSale['TotalSale'] ?: 0;  // Assign 0 if the result is null or empty

// Total Purchase for the current day
$queryTotalPurchase = "SELECT SUM(after_discount_purchase) AS TotalPurchase FROM purchase WHERE purchase_date = '$dialy_Date'";
$runTotalPurchase = mysqli_query($connection, $queryTotalPurchase);
$rowTotalPurchase = mysqli_fetch_array($runTotalPurchase);
$TotalPurchase = $rowTotalPurchase['TotalPurchase'] ?: 0;  // Assign 0 if the result is null or empty

// Total Stock
$queryTotalStock = "SELECT SUM(quantity) AS TotalStock FROM stock_items";
$runTotalStock = mysqli_query($connection, $queryTotalStock);
$rowTotalStock = mysqli_fetch_array($runTotalStock);
$TotalStock = $rowTotalStock['TotalStock'] ?: 0;  // Assign 0 if the result is null or empty

// Total Money Owed to Suppliers (credit - debit)
$queryTotalOwed = "SELECT SUM(credit) - SUM(debit) AS total_money_you_owe_suppliers FROM supplier_ledger";
$runTotalOwed = mysqli_query($connection, $queryTotalOwed);
$rowTotalOwed = mysqli_fetch_array($runTotalOwed);
$TotalMoneyOwed = $rowTotalOwed['total_money_you_owe_suppliers'] ?: 0;  // Assign 0 if the result is null or empty

// Total Money Customers Owe
$query4 = "SELECT SUM(debit) - SUM(credit) AS total_money_customers_owe FROM `customer_ledger` JOIN customer ON customer.id = customer_ledger.customer_id";
$runData4 = mysqli_query($connection, $query4);
$rowData4 = mysqli_fetch_array($runData4);
$totalMoneyCustomersOwe = $rowData4['total_money_customers_owe'];
if ($totalMoneyCustomersOwe == 0 OR $totalMoneyCustomersOwe == '') {
    $totalMoneyCustomersOwe = 0;
}
?>

<div class="page-content">
    <div class="row">
        <h3>Current Date Record (<?php echo $dialy_Date; ?>)</h3>
        <hr>
    </div>
    <div class="row row-cols-1 row-cols-lg-3">
        <!-- Total Sale Card -->
        <div class="col">
            <a href="sale_date_wise_report.php">
                <div class="card radius-10 border border-primary">
                    <div class="card-body my-only-div-shadow my-div-bg">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Total Sale</p>
                                <h4 class="font-weight-bold"><?php echo $TotalSale; ?></h4>
                                <p class="text-success mb-0 font-13">Current Day</p>
                            </div>
                            <div class="widgets-icons bg-gradient-cosmic text-white"><i class='bx bx-refresh'></i></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Purchase Card -->
        <div class="col">
            <a href="purchase_date_wise_report.php">
                <div class="card radius-10 border border-danger">
                    <div class="card-body my-only-div-shadow my-div-bg">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Total Purchase</p>
                                <h4 class="font-weight-bold"><?php echo $TotalPurchase; ?></h4>
                                <p class="text-secondary mb-0 font-13">Current Day</p>
                            </div>
                            <div class="widgets-icons bg-gradient-burning text-white"><i class='bx bx-group'></i></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Stock Items Card -->
        <div class="col">
            <a href="stock_detail.php">
                <div class="card radius-10 border border-success">
                    <div class="card-body my-only-div-shadow my-div-bg">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Total Stock Items</p>
                                <h4 class="font-weight-bold"><?php echo $TotalStock; ?></h4>
                                <p class="text-secondary mb-0 font-13">Current Day</p>
                            </div>
                            <div class="widgets-icons bg-gradient-lush text-white"><i class='bx bx-time'></i></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <h3>Total Records (Overall)</h3>
        <hr>
    </div>
    <div class="row row-cols-1 row-cols-lg-3">
        <!-- Total Sale (Overall) Card -->
        <div class="col">
            <a href="sale_date_wise_report.php">
                <div class="card radius-10 border border-primary">
                    <div class="card-body my-only-div-shadow my-div-bg">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Total Sale</p>
                                <h4 class="font-weight-bold"><?php echo $TotalSale1; ?></h4>
                            </div>
                            <div class="widgets-icons bg-gradient-cosmic text-white"><i class='bx bx-refresh'></i></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Purchase (Overall) Card -->
        <div class="col">
            <a href="purchase_date_wise_report.php">
                <div class="card radius-10 border border-danger">
                    <div class="card-body my-only-div-shadow my-div-bg">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Total Purchase</p>
                                <h4 class="font-weight-bold"><?php echo $TotalPurchase1; ?></h4>
                            </div>
                            <div class="widgets-icons bg-gradient-burning text-white"><i class='bx bx-group'></i></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Money Owed to Suppliers Card -->
        <div class="col">
            <a href="supplier_wise_report.php">
                <div class="card radius-10 border border-warning">
                    <div class="card-body my-only-div-shadow my-div-bg">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Total Money Owed to Suppliers</p>
                                <h4 class="font-weight-bold"><?php echo $TotalMoneyOwed; ?></h4>
                            </div>
                            <div class="widgets-icons bg-gradient-warning text-white"><i class='bx bx-credit-card'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Total Money Customers Owe Card -->
        <div class="col">
            <a href="customer_wise_report.php">
                <div class="card radius-10 border border-warning">
                    <div class="card-body my-only-div-shadow my-div-bg">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Total Money Customers Owe</p>
                                <h4 class="font-weight-bold"><?php echo $totalMoneyCustomersOwe ?></h4>
                                <p class="text-secondary mb-0 font-13">All-time</p>
                            </div>
                            <div class="widgets-icons bg-gradient-warning text-white"><i class='bx bx-wallet'></i></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include("include/footer.php"); ?>