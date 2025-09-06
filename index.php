<?php
include('include/db.php');
session_start();
ob_start();
if(isset($_SESSION['admin_pos']))
{
echo "<script>window.location.href = 'pages/administrator/dashboard.php'; </script>";
}
else
{ ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--plugins-->
    <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/fun.png">
    <title>Sign IN</title>
  </head>
  <body class="bg-primary">
    <!--wrapper-->
    <div class="wrapper">
      <div class="container-fluid">
        <div class="mt-5 row"></div>
        <div class="row mt-5">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <div class="card shadow-lg">
              <div class="card-body">
                <div class="text-center">
                  <!--<img src="images/fun.png" width="100%" alt="Logo" />-->
                  <h3>MG POS</h3>
                </div>
                <hr class="shadow" style="border: 1px solid #7722ee;">
                <div class="p-4 rounded">
                  <div class="form-body">
                    <form class="row g-3" method="post">
                      <div class="col-12">
                        <label class="text-primary"><b>Email/Username</b></label>
                        <input type="text" name="managusername" class="form-control" value="<?php if(isset($_COOKIE["rememberAcount"])) { echo $_COOKIE["rememberAcount"]; } ?>" placeholder="Email/Username">
                      </div>
                      <div class="col-12">
                        <label class="text-primary"><b>Password</b></label>
                        <div class="input-group" id="show_hide_password">
                          <input type="password" name="managpassword" class="form-control border-end-0" value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>" placeholder="Password"> <a href="javascript:" class="input-group-text bg-transparent"><i class='fa fa-eye-slash'></i></a>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-check form-switch">
                          <input class="form-check-input" name="remember" type="checkbox" id="flexSwitchCheckChecked" checked>
                          <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                        </div>
                      </div>
                      <div class="col-md-6 text-end">
                        <a href="authentication-forgot-password.html">Forgot Password ?</a>
                      </div>
                      <div class="col-md-12 mt-5">
                        <div class="d-grid">
                          <button type="submit" name="login" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Sign in</button>
                        </div>
                      </div>
                    </form>
                    <?php
                      if (isset($_POST["login"]))
                      {
                        $username = $_POST["managusername"];
                        $password = $_POST["managpassword"];
          //   @$minutesBeforeSessionExpire=1;
          // if (isset($_SESSION['id']) && (time() - $_SESSION['id'] < ($minutesBeforeSessionExpire*2))) {
          //    echo "<script>window.location.href = 'contact.php'; </script>";  // destroy session data  
          // }
          // else{
          // $_SESSION['id'] = time(); // update last activity


                        $fetchData = "SELECT * FROM system_users WHERE (email = '$username' OR username = '$username') AND password = '$password'";
                        $runData = mysqli_query($connection,$fetchData);
                        $countData = mysqli_num_rows($runData);
                        if($countData != 0)
                        {
                          $rowData  = mysqli_fetch_array($runData);
                          $role_id  = $rowData['role_id'];
                          $user_id  = $rowData['id'];
                          $status = $rowData['status'];
                          if($status == '1')
                          {
                            // ======== Admin =============
                            if($role_id == '1')
                            {
                              $_SESSION["admin_pos"] = $user_id;
                            
                              if(isset($_SESSION["admin_pos"]))
                              {
                                if(!empty($_POST["remember"]))
                                {
                                  setcookie("rememberAcount",$username,time()+ (10 * 365 * 24 * 60 * 60));
                                  setcookie("member_password",$password,time()+ (10 * 365 * 24 * 60 * 60));
                                }
                                else
                                {
                                  if(isset($_COOKIE["rememberAcount"]))
                                  {
                                    setcookie ("rememberAcount","");
                                  }
                                  if(isset($_COOKIE["member_password"]))
                                  {
                                    setcookie ("member_password","");
                                  }
                                }
                                echo "<script>window.location.href = 'pages/administrator/dashboard.php'; </script>";
                              }
                            }
                            // =======Other Panel===============
                            elseif($role_id == '2')
                            {

                              //code here

                              $_SESSION["admin_pos"] = $user_id;
                            
                              if(isset($_SESSION["admin_pos"]))
                              {
                               if(!empty($_POST["remember"]))
                                {
                                  setcookie("rememberAcount",$username,time()+ (10 * 365 * 24 * 60 * 60));
                                  setcookie("member_password",$password,time()+ (10 * 365 * 24 * 60 * 60));
                                }
                                else
                                {
                                  if(isset($_COOKIE["rememberAcount"]))
                                  {
                                    setcookie ("rememberAcount","");
                                  }
                                  if(isset($_COOKIE["member_password"]))
                                  {
                                    setcookie ("member_password","");
                                  }
                                }
                                echo "<script>window.location.href = 'pages/administrator/dashboard.php'; </script>";
                              }
                              

                            }
                          }
                          // If account not approved by admin
                          else
                          {
                            echo "<span class='text-danger'><center>Your account created but not approved please contact with Administrator</center></span>";
                          }
                          //All user end here
                        }
                        // Wrong Username Or Password
                        else
                        {
                          echo "<span class='text-danger'><center>Email or Password is Incorrect</center></span>";
                        }
                      }
                    // }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4"></div>
        </div>
        <!--end row-->
      </div>
    </div>
  <!--end wrapper-->
  <!-- Bootstrap JS -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <!--plugins-->
  <script src="assets/js/jquery.min.js"></script>
  <!--Password show & hide js -->
  <script>
  $(document).ready(function () {
  $("#show_hide_password a").on('click', function (event) {
  event.preventDefault();
  if ($('#show_hide_password input').attr("type") == "text") {
  $('#show_hide_password input').attr('type', 'password');
  $('#show_hide_password i').addClass("fa-eye-slash");
  $('#show_hide_password i').removeClass("fa-eye");
  } else if ($('#show_hide_password input').attr("type") == "password") {
  $('#show_hide_password input').attr('type', 'text');
  $('#show_hide_password i').removeClass("fa-eye-slash");
  $('#show_hide_password i').addClass("fa-eye");
  }
  });
  });
  </script>
  <!--app JS-->
  <script src="assets/js/app.js"></script>
</body>
</html>

<?php } ?>

