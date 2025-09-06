<?php include("include/header.php") ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-6">
        <h4 class="mt-3 text-dark">Total Sales</h4>
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
            <?php  $total_sales = 0;
                            $slct_total =mysqli_query($connection,"select sum(quantity) as totalsales from sale_items");
                            while($rowtotal=mysqli_fetch_array($slct_total)) 
                               {
                                echo '<b>Total Sale Items : </b>'.$total_sales =  $rowtotal['totalsales'];
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
                                    <th>Discount</th>
                                    <th>Total</th>
                                    <th>Details</th>

                </tr>
              </thead>
              <tbody class="table-font-size">
                <?php
                $count = 1;
                $query = "select * from sale";
                $result = mysqli_query($connection, $query);
                while ($rowData = mysqli_fetch_array($result)) {
                  
                  $id   = $rowData['id'];
                  $discount   = $rowData['discount'];
                  $after_discount   = $rowData['after_discount'];
                //  $sale_date   = $rowData['sale_date'];

                ?>
                  <tr class="my-table-row-hover">
                    <td class="pt-2"><?php echo $count++; ?></td>
                    <td class="pt-2"><?php echo $id; ?></td>
                    <td class="pt-2"><?php echo $discount; ?></td>
                    <td class="pt-2"><?php echo $after_discount; ?></td>
                    <td class="pt-2">
                      


                      <?php

// get invoice details
$select_qry1 = mysqli_query($connection, "select si.id as sale_item_id,p.id as product_id,p.product_name as product_name,
si.product_code,si.quantity as sale_quantity,si.price
from sale_items as si
inner join products as p on p.id = si.product_id

                 and si.sale_id = $id

") or die(mysqli_error($connection));
                                 
                                echo '<table class="table table-bordered">';

                                echo '<tr class="success">';
                                echo '<th>Product Code</th>';
                                echo '<th>Product</th>';
                                echo '<th>Return Quantity</th>';
                                echo '<th>Price</th>';
                                echo '<th>Return</th>';
                                echo '</tr>';

                                  while($row1 = mysqli_fetch_array($select_qry1)){
                                      echo '<tr>';
                                      echo '<td>';
                                      echo $row1['product_code'];
                                                      echo '</td>';
                             
  echo '<td>';
echo $row1['product_name'];
echo '</td>';
echo '<td>';
//echo $row1['sale_quantity'];
echo '<form action="sale_return.php?invoice_id='.$id.'&sale_item_id='.$row1['sale_item_id'].'&product_id='.$row1['product_id'].'&discount='.$discount.'" method="POST">';
echo '<input type="text" name="sale_quantity" value="'.$row1['sale_quantity'].'" class="form-control" style="width:70px;"/>';

echo '</td>';

echo '<td>';
echo $row1['price'];
echo '</td>';
echo '<td>';
echo '   <button type="submit" class="btn btn-danger btn-sm">Return</button>';
echo '</td>';
echo '</tr>';

echo '</form>';
}
       // <a href="sale_return.php?invoice_id='.$id.'&sale_item_id='.$row1['sale_item_id'].'&product_id='.$row1['product_id'].'&discount='.$discount.'">Return</a>                           

                                  echo '</table>'; 





echo '</td>';

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
<?php
include("include/footer.php")
?>