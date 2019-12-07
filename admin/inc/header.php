<?php
include "../lib/db.php";
include "../lib/session.php";
session::start();
spl_autoload_register(function ($class) {
include "../classes/" . $class . ".php";
});

$fm = new format();
$br = new brand();
$cat = new category();
$product = new product();
$cust = new customer();
$admin = new admin();
$contact = new contact();

if (session::get('adminLogin') == false) {
echo "<script>window.location = 'login.php'</script>";
}
$path = $_SERVER['SCRIPT_FILENAME'];
$c_page = basename($path, '.php');

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../../../favicon.ico">

<title>Admin KadoMoe</title>

<!-- Bootstrap core CSS -->
<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="../assets/bootstrap/dashboard.css" rel="stylesheet">
</head>

<body>
<header>
<nav class="navbar navbar-expand-md navbar-dark border-bottom fixed-top bg-dark">
<a class="navbar-brand" href="index.php"><img src="logonya.png" width="100px" height="30px"></a>
<button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
        data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
        aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link <?php if ($c_page == 'dashboard') echo 'active' ?>" href="dashboard.php">Home</a>
        </li>  
        <!-- <li class="nav-item">
            <a class="nav-link <?php if ($c_page == 'profile') echo 'active' ?>" href="profile.php">Profile</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link" href="customerOrders.php"><?php
                $order = $cust->cmrOrderRows();
                if ($order > 0) {
                    echo "<span class='text-warning'>New orders (" . $order . ")</span>";
                }
                ?>   
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="customerOrders.php"><?php
                $confirmOrder = $cust->cmrOrderConfirmation();
                if ($confirmOrder > 0){
                    echo "<span class='text-warning'> Order confirmation (" . $confirmOrder . ")</span>";
                }
                ?>   
            </a>
        </li>
    </ul>
    <form class="form-inline mt-2 mt-md-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="profile.php"><?php if (isset($_SESSION['adminName']))
                    echo "<strong class='text-warning'>Welcome! </strong>" . $_SESSION['adminName']; ?></a>
        </li>
        <li class="nav-item">
            <?php
            if (isset($_GET['action']) and $_GET['action'] == 'logout') {
                unset($_SESSION['adminLogin']);
                unset($_SESSION['adminName']);
                unset($_SESSION['adminId']);

                echo "<script>window.location = 'login.php'</script>";
            }
            ?>
            <a class="nav-link" href="?action=logout">Logout</a>
        </li>
    </ul>
</div>
</nav>
</header>

<div class="container-fluid">
<div class="row">
<nav class="col-sm-3 col-md-2 d-none d-sm-block sidebar bg-dark">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <h4 class="text-center text-light">Menu</h4>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if ($c_page == 'customerOrders' || $c_page == 'orders') echo 'active'; ?>"
               href="customerOrders.php">Customer Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if ($c_page == 'customerMessages' || $c_page == 'viewMessage') echo 'active'; ?>"
               href="customerMessages.php">Inbox
               <?php 
                $pendingMessage = $contact->pendingMessage();
                if ($pendingMessage > 0)
                echo "<span class='text-warning'>(".$pendingMessage.")</span>"; 
               ?>
           </a>
        </li>
    </ul>

    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a class="nav-link <?php if ($c_page == 'products') echo 'active'; ?>"
               href="products.php">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if ($c_page == 'add_product') echo 'active'; ?>"
               href="add_product.php">Add New Product</a>
        </li>
    </ul>

    <ul class="nav nav-pills flex-column">
        <!-- <li class="nav-item">
            <a class="nav-link <?//php if ($c_page == 'brand') echo 'active'; ?>" href="brand.php">Brands</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link <?php if ($c_page == 'category') echo 'active'; ?>" href="category.php">Categories</a>
        </li>
    </ul>

    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a class="nav-link <?php if ($c_page == 'customers') echo 'active'; ?>" href="customers.php">Customers</a>
        </li>
    </ul>
    
</nav>
