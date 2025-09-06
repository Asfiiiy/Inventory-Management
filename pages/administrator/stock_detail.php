<?php include("include/header.php") ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-6">
                <h4 class="mt-3 text-dark">Stock Details</h4>
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
                    </div>
                    <br>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <!-- table start -->
                        <table class="table table-bordered text-center datatable table-striped my-only-div-shadow">
                            <thead class="my-table-style text-white">
                                <tr>
                                    <th>S.No</th>
                                    <th>Product</th>
                                    <!--  <th>Average Price </th> -->
                                    <th>Weight/kg </th>
                                    <th>Alert Quantity </th>
                                    <th>Total Cans</th>

                                </tr>
                            </thead>
                            <tbody class="table-font-size">
                                <?php
                $count = 0;
                $query = "SELECT p.product_name AS pro_name, p.brand AS brand, alert_quantity,ROUND(SUM(s.purchase_price * s.quantity)/SUM(s.quantity),3) AS avrgPrice, SUM(s.quantity) AS qty, SUM(s.cans) AS total_cans FROM stock_items AS s
                   INNER JOIN products AS p ON p.id = s.product_id 
                   WHERE s.quantity != '0' GROUP BY s.product_id";
                $result = mysqli_query($connection, $query);
                while ($rowData = mysqli_fetch_array($result)) {
                  $count++;
                  $pro_name   = $rowData['pro_name'];
                  $brand = $rowData['brand'];
                  $avrgPrice   = $rowData['avrgPrice'];
                  $qty   = $rowData['qty'];
                  $alert_quantity   = $rowData['alert_quantity'];
                  $total_cans = $rowData['total_cans'];

                ?>
                                <tr class="my-table-row-hover">
                                    <td class="pt-2"><?php echo $count; ?></td>
                                    <td class="pt-2"><?php echo $pro_name; ?></td>
                                    <!--  <td class="pt-2"><?php echo $avrgPrice; ?></td> -->
                                    <td class="pt-2"><?php echo $qty; ?></td>
                                    <td class="pt-2"><?php echo $alert_quantity; ?> </td>
                                    <td class="pt-2"><?php echo $total_cans; ?> </td>

                                    <!--                   <td>
                    <a href="purchase_vehicle_view.php?id=<?php echo $id; ?>" class="mt-1 btn btn-primary shadow btn-sm title" title="Purchase View"><i class="fa fa-eye"></i></a>
                    <a href="purchase_edit.php?id=<?php echo $id ?>" class="btn btn-sm btn-info mt-1 shadow title" title="Edit"><span><i class="fa fa-edit"></i></span></a>
                    <a class="btn btn-sm mt-1 btn-danger shadow text-white title" title="Delete" onclick="deleteData(<?php echo $id ?>)"><span><i class="fa fa-trash-alt"></i></span></a>
                  </td> -->
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
<?php
include("include/footer.php")
?>