<?php
include "lib/db.php";
include "lib/session.php";
session::start();
spl_autoload_register(function ($class) {
    include "classes/" . $class . ".php";
});

$fm = new format();
$br = new brand();
$cat = new category();
$wl = new wishlist();
$product = new product();
$cart = new cart();
$cust = new customer();
$order = new order();
$contact = new contact();

$path = $_SERVER['SCRIPT_FILENAME'];
$c_page = basename($path, '.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KadoMoe</title>

    <!-- Custom styles for this template -->
    <link href="assets/bootstrap/shop-homepage.css" rel="stylesheet">
    <link href="assets/bootstrap/main.css" rel="stylesheet">
    
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" style="color: #78ff4c" href="index.php"><img src="images/logonya.png" width="100px" height="30px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?php if ($c_page == 'home') echo 'active' ?>" href="home.php">Home
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <?php
                    if (session::get('cust_login') == true) { ?>
                        <a class="nav-link <?php if ($c_page == 'profile') echo 'active' ?>" href="profile.php">Profile</a>
                    <?php } ?>
                </li> -->
                <li class="">
                    <a class="nav-link <?php if ($c_page == 'cart') echo 'active' ?>" href="cart.php">
                        Cart
                        <?php
                        if (isset($_SESSION['cart'])) {
                            $pro_quantity = array_column($_SESSION['cart'], 'pro_quantity');
                            $sum = array_sum($pro_quantity);
                            if (!empty($_SESSION['cart'])) {
                                echo '<span style="color: #fff632;">(' . $sum . ')</span>';
                            }
                        }
                        ?>
                    </a>
                </li>
                <li class="nav-item">
                    <?php
                    if (session::get('cust_login') == true) { ?>
                    <a class="nav-link <?php if ($c_page == 'wishlist') echo 'active' ?>" href="wishlist.php">Wishlist
                        <?php
                            $count = $wl->countWishlistProducts();
                            if ($count > 0){
                                echo "<span class='text-warning'>(".$count.")</span>";
                            }
                        ?>
                    </a>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <?php
                    $rows = mysqli_num_rows($cust->getOrders());
                    $newRows = $cust->newOrderRows();
                    if ($rows > 0) {
                        ?>
                        <a class="nav-link <?php if ($c_page == 'order') echo 'active' ?>" href="order.php">Orders
                            <?php
                            if ($newRows > 0) {
                                echo '<span style="color: yellow">(' . $newRows . ')</span>';
                            }
                            ?>
                        </a>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($c_page == 'contact') echo 'active' ?>" href="contact.php">Contact
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form action="searchProduct.php" method="post" class="form-inline mt-2 mt-md-0">
                        <input type="text" name="keyword" class="form-control mr-sm-2" placeholder="Search for products" required>
                        <input type="submit" name="search" value="Search" class="btn btn-outline-primary">
                    </form>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <?php
                if (session::get('cust_login') == true) {
                    if (isset($_GET['action']) and $_GET['action'] == 'logout') {
                        $cust->logout();
                    }
                    echo '<li class="nav-item"><a class="nav-link text-success" href="profile.php"><strong class="text-warning">Welcome! </strong>' . session::get('cust_name') . '</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="?action=logout">Logout</a></li>';
                } else { ?>
                    <li class="nav-item"><a class="nav-link <?php if ($c_page == 'registration') echo 'active' ?>" href="registration.php">Registration</a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($c_page == 'login') echo 'active' ?>" href="login.php">Login</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>