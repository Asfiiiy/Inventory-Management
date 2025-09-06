<?php include("include/header.php") ?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row mb-2">
    <div class="col-md-12">
      <h3>Sub Category Details</h3>
    </div>
    <div>
      <div class="page-content container-fluid">
        <!--  Start Row  -->
        <div class="row">
          <div class="col-md-12">
            <div class="card my-only-div-shadow">
              <div class="card-body">
                <div class="text-left">
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">
                    Add Sub Category
                  </button>
                  <!-- Modal -->
                  <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header bg-secondary">
                          <h6 class="modal-title text-white" id="addCategoryLabel">Add Sub Category</h6>
                          <button type="button" class="text-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post">
                          <div class="modal-body">
                            <label>Category</label>
                            <select class="form-control select2" name="category_id">
                              <option value="">Choose</option>
                              <?php
                              $fetch = "SELECT * FROM categories ORDER BY category ASC";
                              $runFetch = mysqli_query($connection, $fetch);
                              while ($row = mysqli_fetch_array($runFetch)) {
                                $id = $row['id'];
                                $category = $row['category'];
                              ?>
                                <option value="<?php echo $id; ?>"><?php echo $category; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="modal-body">
                            <label>Sub Category</label>
                            <input type="text" name="sub_category" placeholder="Enter Sub Category" class="form-control" required>
                          </div>
                          <div class="modal-footer">
                            <input type="submit" name="saveData" class="btn btn-primary shadow" value="Save">
                            <button type="button" class="btn btn-danger shadow" data-bs-dismiss="modal">Close</button>
                          </div>
                        </form>
                        <?php
                        if (isset($_POST['saveData'])) {
                          $category_id = $_POST['category_id'];
                          $sub_category = $_POST['sub_category'];

                          $insert = "INSERT INTO sub_categories (category_id, `sub_category`) VALUES ('$category_id','$sub_category')";
                          $run = mysqli_query($connection, $insert);
                          if ($run) {
                            echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Added!',
                          'Sub Catagory has been successfully added!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'sub_category.php';
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
                                'Sub Catagory not add, Some error occure',
                                'error'
                                ).then((result) => {
                                if (result.isConfirmed) {
                                window.location.href = 'sub_category.php';
                                }
                                });
                                </script>
                              </body>
                              </html>";
                          }
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <table class="table table-bordered table-hover bg-white shadow  datatable text-center" style="font-size: 12px">
                  <thead class="bg-dark text-white">
                    <th>S.No</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Action</th>
                  </thead>

                  <tbody>
                    <?php
                    $s_no = 0;
                    $fetchData = "SELECT c.id,c.category,sc.sub_category FROM sub_categories AS sc INNER JOIN categories AS c ON c.id = sc.category_id ORDER BY sc.id DESC";
                    $runFetch = mysqli_query($connection, $fetchData);
                    while ($rowData = mysqli_fetch_array($runFetch)) {
                      $s_no++;
                      $id = $rowData['id'];
                      $category = $rowData['category'];
                      $sub_category = $rowData['sub_category'];
                    ?>
                      <tr>
                        <td><?php echo $s_no; ?></td>
                        <td><?php echo $category; ?></td>
                        <td><?php echo $sub_category; ?></td>
                        <td>
                          <a class="Data_Ajax title shadow btn btn-success btn-sm" data-id="" href="#edit" data-toggle='modal' title="Edit"><i class="bx bx-edit"></i></a>
                          <a class="shadow btn btn-danger btn-sm" title="Delete" name="delete"><i class="bx bx-trash"></i></a>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- End Row  -->
      </div>
    </div>
    <?php include("include/footer.php") ?>