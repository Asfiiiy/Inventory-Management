 <?php
    session_start();
    $now = time();
 
    if (!isset($_SESSION['admin_pos'])) {
        echo "Session not Set. Login"."<br>";
        ?>
            <a href="index.php">Login Here</a>
        <?php
    }
 
    elseif ($now > $_SESSION['expiry']) {
        session_destroy();
        echo "Your session has expired! Login again"."<br>";
        ?>
            <a href="index.php">Login Here</a>
        <?php
    }
    else{
        ?>
        <!DOCTYPE html>
        <html>
        <head>
        <title>How to Set Up Expiration to Sessions using PHP</title>
        </head>
        <body>
        <h2>Welcome -  <?php echo $_SESSION['admin_pos']; ?></h2>
        <a href="index.php">Logout</a>
        </body>
        </html>
        <?php
    }
?>