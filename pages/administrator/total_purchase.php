<?php include("include/header.php") ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6">
                <h4 class="mt-3 text-dark">Total Purchase</h4>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid" class="text-center">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-dark my-only-div-shadow" class="text-center">
                    <div class="card-header">
                        <?php  
                        $total_purchase = 0;
                        $slct_total =mysqli_query($connection,"SELECT SUM(quantity) AS totalpurchase FROM purchase_items");
                        while($rowtotal=mysqli_fetch_array($slct_total)) {
                            echo '<b>Total Purchase Items : </b>'.$total_purchase = $rowtotal['totalpurchase'];
                        } ?>
                    </div>
                    <br>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <!-- table start -->
                        <table class="table table-bordered text-center datatable table-striped my-only-div-shadow">
                            <thead class="my-table-style text-white">
                                <tr>
                                    <th>S.No</th>
                                    <th>Invoice No</th>
                                    <th>Total</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody class="table-font-size">
                                <?php
                                $count = 1;
                                $query = "SELECT * FROM purchase";
                                $result = mysqli_query($connection, $query);
                                while ($rowData = mysqli_fetch_array($result)) {
                                    $id = $rowData['id'];
                                    $after_discount = $rowData['after_discount_purchase'];
                                    $supp_id = $rowData['supplier_id'];
                                ?>
                                <tr class="my-table-row-hover">
                                    <td class="pt-2"><?php echo $count++; ?></td>
                                    <td class="pt-2"><?php echo $id; ?></td>
                                    <td class="pt-2"><?php echo $after_discount; ?></td>
                                    <td class="pt-2">
                                        <?php
                                        // get invoice details
                                        $select_qry1 = mysqli_query($connection, 
                                            "SELECT pi.id AS purchase_item_id, p.id AS product_id, p.product_name, 
                                                    pi.product_code, pi.quantity AS purchase_quantity, pi.purchase_price
                                             FROM purchase_items AS pi
                                             INNER JOIN products AS p ON p.id = pi.product_id
                                             WHERE pi.purchase_id = $id"
                                        ) or die(mysqli_error($connection));

                                        echo '<table class="table table-bordered">';
                                        echo '<tr class="success">';
                                        echo '<th>Product Code</th>';
                                        echo '<th>Product</th>';
                                        echo '<th>Return Quantity</th>';
                                        echo '<th>Price</th>';
                                        echo '<th>Return</th>';
                                        echo '</tr>';

                                        while ($row1 = mysqli_fetch_array($select_qry1)) {
                                            echo '<tr>';
                                            echo '<td>'.$row1['product_code'].'</td>';
                                            echo '<td>'.$row1['product_name'].'</td>';
                                            echo '<td>';
                                            echo '<form action="purchase_return.php?invoice_id='.$id.'&purchase_item_id='.$row1['purchase_item_id'].'&product_id='.$row1['product_id'].'&supplier_id='.$supp_id.'&total_price='.$after_discount.'" method="POST">';
                                            echo '<input type="text" name="purchase_quantity" value="'.$row1['purchase_quantity'].'" class="form-control" style="width:70px;"/>
                                                  <input type="hidden" name="previous_purchase_quantity" value="'.$row1['purchase_quantity'].'" class="form-control" style="width:70px;"/>';
                                            echo '</td>';
                                            echo '<td><input type="text" name="purchase_price" readonly value="'.(int)$row1['purchase_price'].'" class="form-control" style="width:100px;"/></td>';
                                            echo '<td><button type="submit" class="btn btn-danger btn-sm">Return</button></td>';
                                            echo '</tr>';
                                            echo '</form>';
                                        }
                                        echo '</table>';
                                        ?>
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
</section>
<?php include("include/footer.php") ?>
