<?php
include "inc/header.php";
?>

<!-- Page Content -->
<div class="container">
<div class="row">
    <div class="col-md-9">
        <h1 class="card-body">DETAIL PRODUK</h1>
        <div class="card-body">
            <div class="row">
                <?php
                if (isset($_POST['add_to_cart'])) {
                    $cart->add_to_cart($_GET['pro_id'], $_POST['quantity']);
                    echo "<script>window.location = 'cart.php'</script>";
                }

                if (isset($_POST['add_to_wishlist'])){
                    $wl->addToWishlist($_GET['pro_id'], $_POST['quantity']);
                    echo "<script>window.location = 'wishlist.php'</script>";
                }

                if (isset($_GET['pro_id'])){
                $pro_details = $product->getProductById($_GET['pro_id']);
                ?>
                <div class="col-md-6">
                    <img src="<?php echo $pro_details['image']; ?>" class="img-fluid" alt="image"><br>
                    <a href="<?php echo $pro_details['image']; ?>" class="nav-link">View full size image</a>
                </div>
                <div class="col-md-6">
                    <h5>Nama Produk : <i><?php echo $pro_details['pro_name']; ?></i></h5>
                    <h5>Harga : <i>Rp <?php echo $pro_details['price']; ?></i></h5>
                    <h5>Category : <i><?php echo $pro_details['cat_name']; ?></i></h5>
                    <h5>Brand : <i><?php echo $pro_details['brand_name']; ?></i></h5>
                    <form method="post">
                        <h5>Quantity : <input type="number" name="quantity" value="1" class="form-control-sm">
                        </h5>
                        <input type="submit" name="add_to_cart" value="Add to cart"
                               class="btn btn-primary form-group">
                        <?php
                            if (session::get('cust_login') == true){
                        ?>
                        <input type="submit" name="add_to_wishlist" value="Add to wishlist"
                               class="btn btn-warning form-group">
                        <?php } ?>
                    </form>
                </div>
            </div>
            <hr>
            <h2>Details</h2>
            <p class="text-justify"><?php echo $pro_details['description']; ?></p>
        </div>
        <?php } else { ?>
            <script>window.location = 'home.php'</script>
        <?php } ?>
    </div>
    <div class="col-md-3">
        <?php include "inc/categories.php";?>
    </div>
</div>
</div>
<hr>
<!-- /.container -->

<?php
include "inc/footer.php";
?>