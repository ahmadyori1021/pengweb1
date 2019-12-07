<?php
include 'inc/header.php';

if (empty($_SESSION['cart'])) {
    echo "<script>window.location = 'home.php'</script>";
}
?>

    <div class="container">
        <div class="card-body">
            <h1 class="text-center card-header text-secondary"><i>My Cart</i></h1>
            <br>
            <table class="table text-center">
                <tr>
                    <th>Seri</th>
                    <th>Name Produk</th>
                    <th>Gambar</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Total Harga</th>
                    <th>Action</th>
                </tr>

                <?php

                if (isset($_GET['del_product_key'])) {
                    $del_product_key = $_GET['del_product_key'];
                    foreach ($_SESSION['cart'] as $pro_key => $item) {
                        if ($pro_key == $del_product_key) {
                            unset($_SESSION['cart'][$pro_key]);
                            echo "<meta http-equiv='refresh' content=\"0;URL=?id=live\">";
                        }

                        if (empty($_SESSION['cart'])) {
                            echo '<script>window.location = "home.php"</script>';
                        }
                    }
                }
                ?>

                <?php
                if (isset($_SESSION['cart'])) {
                    $i = 0;
                    $sub_total = 0;
                    foreach ($_SESSION['cart'] as $key => $item) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $item['pro_name'] ?></td>
                            <td><img src="<?php echo $item['pro_image'] ?>" height="60" width="90" alt=""></td>
                            <td><?php echo $item['pro_price'] ?></td>
                            <td><?php echo $item['pro_quantity'] ?></td>
                            <td>
                                <?php
                                $total = $item['pro_price'] * $item['pro_quantity'];
                                echo $total;
                                $sub_total += $total;
                                ?>
                            </td>
                            <td><a href="?del_product_key=<?php echo $key; ?>"
                                   class="btn font-weight-bold text-danger">X</a></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <div class="card-body border">
                        <h6>Sub Total : <?php echo $sub_total; ?></h6>
                        <h6>
                            pajak(10%) :
                            <?php
                            $vat = ($sub_total * 10) / 100;
                            echo $vat;
                            ?>
                        </h6>
                        <h6>Total : <?php echo $sub_total + $vat; ?></h6>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-sm-2">
                    <a href="home.php" class="btn btn-outline-dark font-italic">Lanjutkan Belanja</a>
                </div>
                <div class="col-sm-7"></div>

                <div class="col-sm-3">
                    <?php
                    if (isset($_GET['action']) and $_GET['action'] == 'order') {
                        $cust->order();
                        echo "<script>window.location = 'paymentGateway.php'</script>";
                    }

                    if (session::get('cust_login') == true) {
                        echo '<a href="?action=order" class="btn btn-warning font-italic">Order Now !</a>';
                    } else {
                        echo "<span class='text-danger'><a href='registration.php'>Register</a> OR <a href='login.php'>Login</a> here and Order now.</span>";
                    }
                    ?>
                </div>
            </div>
            <br>

        </div>
    </div>

<?php include 'inc/footer.php'; ?>