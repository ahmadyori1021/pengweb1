<?php
include "../lib/db.php";
include "../lib/session.php";
include "../classes/admin.php";
session::start();
$admin = new admin();

if (session::get('adminLogin') == true){
    echo "<script>window.location = 'dashboard.php'</script>";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
    <!-- Bootstrap core CSS -->
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">

    <div class="text-center card-body">
        <h1>Admin Login</h1>
        <hr>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['login'])){
        $adminLogin = $admin->login($_POST);
    }
    ?>

    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4 card-body">
            <!--Admin Login form-->
            <form action="" method="post">
                <?php
                if (isset($adminLogin)){
                    echo $adminLogin;
                }
                ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-group">
                    <input type="submit" name="login" value="Login" class="btn btn-primary btn-block">
                </div>
            </form>

            <a href="">Forgotten password ?</a>
        </div>
        <div class="col-lg-4"></div>
    </div>

</div>
</body>
</html>