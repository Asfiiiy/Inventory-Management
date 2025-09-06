<?php include("include/header.php") ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="row mb-2">
        <div class="col-md-10">
            <h3 class="ps-4">Products Details</h3>
        </div>
        <div class="col-md-2 float-right">
        </div>
    </div>
    <div>
        <div class="page-content container-fluid">
            <!--  Start Row  -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body my-only-div-shadow">
                            <div class="text-left"></div>
                            <br>
                            <div class="table-responsive">
                                <form action="selected_barcode.php" method="post">
                                    <input type="submit" name="saveData" class="btn btn-primary shadow mb-3"
                                        value="Print Selected Barcode">
                                    <table
                                        class="table table-bordered table-hover shadow table-striped datatable text-center my-only-div-shadow">
                                        <thead class="my-table-style text-white">
                                            <th><input type="checkbox" id="checkAll"> Check All</th>
                                            <th>S.No</th>
                                            <th>Item Name</th>
                                            <th>Item Code</th>
                                            <th>Opening Quantity</th>
                                            <th>Alert Quantity</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </thead>

                                        <tbody class="table-font-size">
                                            <?php
                                            $count = 0;
                                            $query2 = "SELECT p.product_code,p.brand,p.product_image,p.id,p.product_name,c.category,p.alert_quantity,p.description,p.open_stock_quantity
                                            FROM products AS p
                                            LEFT JOIN categories AS c
                                            ON c.id = p.category_id
                                            ORDER BY p.id DESC";
                                            $runData = mysqli_query($connection, $query2);
                                            while ($rowData = mysqli_fetch_array($runData)) {
                                                $count++;
                                                $id = $rowData['id'];
                                                $product_name = $rowData['product_name'];
                                                $product_code = $rowData['product_code'];
                                                $open_stock_quantity = $rowData['open_stock_quantity'];
                                                $category = $rowData['category'];
                                                $alert_quantity  = $rowData['alert_quantity'];
                                                $product_image  = $rowData['product_image'];
                                                $path  = "../../images/product_image/" . $product_image;
                                                $description  = $rowData['description'];
                                            ?>
                                            <tr class="my-table-row-hover">
                                                <td><input type="checkbox" name="checkbox[]" value="<?php echo $id ?>">
                                                </td>
                                                <td class="pt-2"><?php echo $count; ?></td>
                                                <td class="pt-2"><?php echo $product_name; ?></td>
                                                <td class="pt-2"><?php echo $product_code; ?></td>
                                                <td class="pt-2"><?php echo $open_stock_quantity; ?></td>
                                                <td class="pt-2"><?php echo $alert_quantity; ?></td>
                                                <td class="pt-2"><?php echo $description; ?></td>
                                                <td class="pt-2"><?php if ($product_image != '') { ?><img
                                                        src="<?php echo $path; ?>" width="100px">
                                                    <?php } else { echo "Not Uploaded"; } ?></td>
                                                <td class="d-inline-flex">
                                                    <a href="product_update.php?product_id=<?php echo $id ?>"
                                                        class="Data_Ajax title btn btn-success btn-sm" title="Edit"><i
                                                            class="bx bx-edit"></i></a>||
                                                    <a href="barcode.php?product_id=<?php echo $id ?>"
                                                        class="Data_Ajax title btn btn-primary btn-sm"
                                                        title="Bar Code"><i class="bx bx-barcode"></i></a>||
                                                    <a onclick="deleteData(<?php echo $id ?>)"
                                                        class="btn btn-sm shadow btn-danger" title="Delete"><i
                                                            class="bx bx-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row  -->
        </div>
    </div>

    <!-- delete and sweet alert -->
    <script type="text/javascript">
    function deleteData(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "To delete the selected record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "product_details.php?deleteId=" + id;
            }
        });
    }
    </script>
    <?php
    if (isset($_GET['deleteId'])) {
        $id = $_GET['deleteId'];
        $query = "DELETE FROM products WHERE id = '$id'";
        $run = mysqli_query($connection, $query);
        if ($run) {
            echo "<!DOCTYPE html>
            <html>
              <body>
                <script>
                Swal.fire(
                'Deleted!',
                'Product has been successfully Deleted!',
                'success'
                ).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = 'product_details.php';
                }
                });
                </script>
              </body>
            </html>";
        }
    }
    ?>
    <?php include("include/footer.php") ?>

    <script>
    $('#checkAll').click(function() {
        $('input:checkbox').prop('checked', this.checked);
    });
    </script>
</div>