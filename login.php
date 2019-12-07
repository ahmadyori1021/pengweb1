<?php
require_once 'inc/header.php';

if (session::get('cust_login')==true){
    echo "<script>window.location = 'home.php'</script>";
}
?>

    <div class="container">
        <div class="card">
            <h1 class="text-center card-header text-secondary">User Login</h1>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['login'])) {
                            $login = $cust->login($_POST);
                            if ($login){
                                echo $login;
                            }
                        }
                        ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control"
                                       <?php
                                       if (isset($_COOKIE['cust_email'])){
                                           echo "value=".$_COOKIE['cust_email'];
                                       }else{
                                           echo "placeholder='Enter your email'";
                                       }
                                       ?>>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    <?php
                                    if (isset($_COOKIE['cust_pass'])){
                                        echo "value=".$_COOKIE['cust_pass'];
                                    }else{
                                        echo "placeholder='Enter your password'";
                                    }
                                    ?>>
                            </div>
                            <div class="checkbox form-group">
                                <label class="text-primary"><input type="checkbox" name="remember"
                                        <?php
                                        if (isset($_COOKIE['cust_pass'])){
                                            echo "checked";
                                        }
                                        ?>
                                    > Ingat</label>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login" class="btn btn-outline-info btn-block">Log in
                                </button>
                            </div>

                            <hr>
                            <h5 class="text-center">OR</h5>
                            <hr>

                            <div class="form-group">
                                <a href="registration.php" class="btn btn-success btn-block">Create New Account</a>
                            </div>
                            <a href="">Lupa password ?</a><br>
                            <a href="">Help center</a>
                        </form>
                    </div>

                    <div class="col-md-4"></div>
                </div>
            </div>
        </div>
    </div>

<?php require_once 'inc/footer.php'; ?>