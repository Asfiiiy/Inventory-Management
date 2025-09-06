<?php include("include/header.php") ?>
<div class="page-content">
  <!--breadcrumb-->
  <div class="row mb-2">
    <div class="col-md-12 ">
      <h3 class="ps-4">Unit Details</h3>
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
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUnit">
                    Add Unit
                  </button>
                  <!-- Modal -->
                  <div class="modal fade" id="addUnit" tabindex="-1" aria-labelledby="addUnitLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header bg-secondary">
                          <h6 class="modal-title text-white" id="addUnitLabel">Add Unit</h6>
                          <button type="button" class="text-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post">
                          <div class="modal-body">
                            <label>Unit</label>
                            <input type="text" name="unit" placeholder="Enter Unit" class="form-control" required>
                          </div>
                          <div class="modal-footer">
                            <input type="submit" name="saveData" class="btn btn-primary shadow" value="Save">
                            <button type="button" class="btn btn-danger shadow" data-bs-dismiss="modal">Close</button>
                          </div>
                        </form>
                        <?php
                        if (isset($_POST['saveData'])) {
                          $unit = $_POST['unit'];

                          $insert = "INSERT INTO units (`unit`) VALUES ('$unit')";
                          $run = mysqli_query($connection, $insert);
                          if ($run) {
                            echo " <!DOCTYPE html>
                      <html>
                        <body>
                          <script>
                          Swal.fire(
                          'Added!',
                          'Unit has been successfully added!',
                          'success'
                          ).then((result) => {
                          if (result.isConfirmed) {
                          window.location.href = 'unit.php';
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
                                'Unit not add, Some error occure',
                                'error'
                                ).then((result) => {
                                if (result.isConfirmed) {
                                window.location.href = 'unit.php';
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
                <div class="table-responsive py-2">
                  <table class="table table-bordered table-hover bg-white shadow  datatable text-center table-striped">
                    <thead class="my-table-style text-white">
                      <th>S.No</th>
                      <th>Unit</th>
                      <th>Action</th>
                    </thead>

                    <tbody class="table-font-size">
                      <?php
                      $s_no = 0;
                      $fetchData = "SELECT * FROM units ORDER BY id DESC";
                      $runFetch = mysqli_query($connection, $fetchData);
                      while ($rowData = mysqli_fetch_array($runFetch)) {
                        $s_no++;
                        $id = $rowData['id'];
                        $unit = $rowData['unit'];
                      ?>
                        <tr class="my-table-row-hover">
                          <td class="pt-2"><?php echo $s_no; ?></td>
                          <td class="pt-2"><?php echo $unit; ?></td>
                          <td>
                            <a href="unit_update.php?unit_id=<?php echo $id ?>" class="Data_Ajax title shadow btn btn-success btn-sm"><i class="bx bx-edit"></i></a>
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
            window.location.href = "unit.php?unit_id=" + id;
          }
        });
      }
    </script>
    <?php
    //////Deletion Query OF unit

    if (isset($_GET['unit_id'])) {
      $unit_id = $_GET['unit_id'];

      $sql1  = "DELETE FROM units WHERE id = '$unit_id'";
      $run1 = mysqli_query($connection, $sql1);


      if ($run1) {
        echo "<!DOCTYPE html>
        <html>
          <body>
            <script>
            Swal.fire(
            'Deleted!',
            'unit has been successfully deleted!',
            'success'
            ).then((result) => {
            if (result.isConfirmed) {
              window.location.href='unit.php';
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
        'This unit cannot be Deleted',
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