<?php include("include/header.php") ?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row mb-2">
    <div class="col-md-12">
      <h3 class="ps-4">Model Details</h3>
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
                    Add Model
                  </button>
                  <!-- Modal -->
                  <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header bg-secondary">
                          <h6 class="modal-title text-white" id="addCategoryLabel">Add Model</h6>
                          <button type="button" class="text-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post">
                          <div class="modal-body">
                            <label>Model Name</label>
                            <input type="text" name="category" placeholder="Enter Model" class="form-control" required>
                          </div>
                          <div class="modal-footer">
                            <input type="submit" name="saveData" class="btn btn-primary shadow" value="Save">
                            <button type="button" class="btn btn-danger shadow" data-bs-dismiss="modal">Close</button>
                          </div>
                        </form>
                        <?php
                        if (isset($_POST['saveData'])) {
                          $category = $_POST['category'];

                          $insert = "INSERT INTO categories (`category`) VALUES ('$category')";
                          $run = mysqli_query($connection, $insert);
                          if ($run) {
                            echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Added!',
                          'Model has been successfully added!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'category.php';
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
                                'Model not add, Some error occure',
                                'error'
                                ).then((result) => {
                                if (result.isConfirmed) {
                                window.location.href = 'category.php';
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
                <div class="table-responsive">
                  <table class="table table-bordered table-hover bg-white shadow  datatable text-center table-striped">
                    <thead class="my-table-style text-white">
                      <th>S.No</th>
                      <th>Model</th>
                      <th>Action</th>
                    </thead>

                    <tbody class="table-font-size">
                      <?php
                      $s_no = 0;
                      $fetchData = "SELECT * FROM categories ORDER BY id DESC";
                      $runFetch = mysqli_query($connection, $fetchData);
                      while ($rowData = mysqli_fetch_array($runFetch)) {
                        $s_no++;
                        $id = $rowData['id'];
                        $category = $rowData['category'];
                      ?>
                        <tr class="my-table-row-hover">
                          <td class="pt-2"><?php echo $s_no; ?></td>
                          <td class="pt-2"><?php echo $category; ?></td>
                          <td>
                            <a href="category_update.php?cat_id=<?php echo $id ?>" class="Data_Ajax title shadow btn btn-success btn-sm"><i class="bx bx-edit"></i></a>
                            <a class="btn btn-sm mt-1 btn-danger shadow text-white title" title="Delete" onclick="deleteData(<?php echo $id ?>)"><span><i class="bx bx-trash-alt"></i></span></a>
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
    <script type="text/javascript">
      function deleteData(id) {
        Swal.fire({
          title: 'Are you sure?',
          text: "To delete the selected record !",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "category.php?cat_id=" + id;
          }
        });
      }
    </script>
    <?php
    //////Deletion Query OF Category

    if (isset($_GET['cat_id'])) {
      $cat_id = $_GET['cat_id'];

      $sql1  = "DELETE FROM categories WHERE id = '$cat_id'";
      $run1 = mysqli_query($connection, $sql1);


      if ($run1) {
        echo "<!DOCTYPE html>
        <html>
          <body>
            <script>
            Swal.fire(
            'Deleted!',
            'Model has been successfully deleted!',
            'success'
            ).then((result) => {
            if (result.isConfirmed) {
              window.location.href='category.php';
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
        'This Model cannot be Deleted',
        'error'
        ).then((result) => {
        if (result.isConfirmed) {
        }
        });
        </script>
      </body>
      </html>";
      }
    }
    ?>