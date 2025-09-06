<?php include("include/header.php") ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="row mb-2">
        <div class="col-md-12">
            <h3 class="ps-4">Account-wise Transaction Summary</h3>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!--  Start Row  -->
        <div class="row">
            <div class="col-md-12">
                <div class="card my-only-div-shadow">
                    <div class="card-body">
                        <br>
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-hover bg-white shadow datatable text-center table-striped">
                                <thead class="my-table-style text-white">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Payment Method</th>
                                        <th>Total Transaction Amount</th>
                                    </tr>
                                </thead>

                                <tbody class="table-font-size">
                                    <?php
                                    $s_no = 0; 
                                    $fetchData = "SELECT 
                                        pm.method AS payment_method, 
                                        SUM(ch.amount) AS total_transaction_amount
                                    FROM 
                                        cash_history ch 
                                    JOIN 
                                        payment_method pm 
                                    ON 
                                        ch.pay_type_id = pm.id 
                                    GROUP BY 
                                        pm.method;";
                                    
                                    $runFetch = mysqli_query($connection, $fetchData); // Running the query
                                    while ($rowData = mysqli_fetch_array($runFetch)) {
                                        $s_no++;
                                        $payment_method = $rowData['payment_method'];
                                        $total_transaction_amount = $rowData['total_transaction_amount'];
                                    ?>
                                    <tr>
                                        <td><?php echo $s_no; ?></td>
                                        <td><?php echo $payment_method; ?></td>
                                        <td><?php echo number_format($total_transaction_amount, 2); // Format the amount ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row  -->
    </div>
</div>
<?php include("include/footer.php") ?>