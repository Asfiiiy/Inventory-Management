<?php
include("include/header.php");
    $pay_id=$_GET['pay_id'];
   // $cust_id = $_GET['cust_id'];

    $delete_supplier_payment = "DELETE FROM supplier_payment WHERE id='$pay_id'";
    $runquery1=mysqli_query($connection,$delete_supplier_payment);

    if($runquery1){
        $delete_supplier_ledger = "DELETE FROM supplier_ledger WHERE payment_id='$pay_id'";
        $runquery2=mysqli_query($connection,$delete_supplier_ledger);
        if($runquery2){
            $delete_cash_history = "DELETE FROM cash_history WHERE supplier_payment_id='$pay_id'";
            $runquery3=mysqli_query($connection,$delete_cash_history);
            if($runquery3){
                echo "<!DOCTYPE html>
                <html>
                  <body>
                    <script>
                    Swal.fire(
                    'Done!',
                    'Payment has been deleted',
                    'success'
                    ).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href= 'supplier_payment_list.php';
                    }
                    });
                    </script>
                  </body>
                </html>";
            }else{
                echo "<!DOCTYPE html>
                <html>
                  <body>
                    <script>
                    Swal.fire(
                    'Error !',
                    'Try Again',
                    'error'
                    ).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href= 'supplier_payment_list.php';
                    }
                    });
                    </script>
                  </body>
                </html>";
            }
        }else{
            echo "<!DOCTYPE html>
            <html>
              <body>
                <script>
                Swal.fire(
                'Error !',
                'Try Again',
                'error'
                ).then((result) => {
                if (result.isConfirmed) {
                  window.location.href= 'supplier_payment_list.php';
                }
                });
                </script>
              </body>
            </html>";
        }

    }else{
        echo "<!DOCTYPE html>
        <html>
          <body>
            <script>
            Swal.fire(
            'Error !',
            'Try Again',
            'error'
            ).then((result) => {
            if (result.isConfirmed) {
              window.location.href= 'supplier_payment_list.php';
            }
            });
            </script>
          </body>
        </html>";
    }
?>