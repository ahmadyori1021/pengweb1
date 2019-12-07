<?php
require_once 'inc/header.php';

if (!isset($_GET['cmr_id'])) {
    echo "<script>window.location = 'customerOrders.php'</script>";
}
?>

    <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
        <h1 class="font-italic text-center">Orders</h1>

        <?php
        if (isset($_GET['shift_id'])) {
            $cust->shift_info($_GET['shift_id']);
            //echo "<meta http-equiv='refresh' content=\"0;URL=?id=live\">";
        }
        ?>

        <table class="table table-bordered text-center">

            <?php
            if (isset($_GET['cmr_id'])) {
                $cmr_id = $_GET['cmr_id'];
                $c_orders = $cust->customerOrders($cmr_id);
                $rows = mysqli_num_rows($c_orders);
                if ($rows > 0) { ?>
                    <tr>
                        <th>Seri</th>
                        <th>Nama Produk</th>
                        <th>Gambar</th>
                        <th>Quantity</th>
                        <th>Harga</th>
                        <th>Order date</th>
                    </tr>
                    <?php
                    $i = 0;
                    $total_price = 0;
                    while ($c_order = $c_orders->fetch_assoc()) {
                        $i++;

                        $total_price += $c_order['price'] * $c_order['quantity'];
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $c_order['pro_name']; ?></td>
                            <td>
                                <img src="../<?php echo $c_order['image']; ?>" height="60" alt="">
                            </td>
                            <td><?php echo $c_order['quantity']; ?></td>
                            <td><?php echo $c_order['price']; ?></td>
                            <td><?php echo $fm->dateFormat($c_order['order_date']); ?></td>
                        </tr>
                    <?php } } else { ?>
                    <h2 class="text-center text-danger">There is no order available !</h2>
                <?php }
            } ?>
        </table>

        <div class="row text-center">
            <div class="col-md-6 card-body">
                <h4>Products shift information</h4>
                <hr>
                <?php
                if (isset($_GET['cmr_id'])) {
                    $cmr_id = $_GET['cmr_id'];
                    $c_ords = $cust->customerOrders($cmr_id);
                    $c_ord = $c_ords->fetch_assoc();
                    ?>
                    <?php if ($c_ord['status'] == 0) { ?>
                        <a href='?shift_id=<?php echo $c_ord['cmr_id'] ?>&cmr_id=<?php echo $c_ord['cmr_id'] ?>'
                           class='btn btn-warning font-italic btn-lg'>Shift</a>
                    <?php } elseif ($c_ord['status'] == 1) { ?>
                        <span style='font-size: 35px'
                              class='text-danger font-weight-bold font-italic'>Shifting</span>
                    <?php } elseif ($c_ord['status'] == 2) { ?>
                        <span style='font-size: 35px'
                              class='text-success font-weight-bold font-italic'>Shifted</span>
                    <?php } } ?>
            </div>

            <div class="col-md-6 card-body">
                <h4>Total Harga</h4>
                <hr>
                <h5><i>Sub Total : <?php echo $total_price; ?></i></h5>
                <h5><i>pajak(10%) : <?php echo $vat = ($total_price / 100) * 10; ?></i></h5>
                <h5><i>Total : <?php echo $total_price + $vat; ?></i></h5>
            </div>
        </div>

        <?php
        if (isset($_GET['cmr_id'])) {
            $cust_info = $cust->customerOrders($_GET['cmr_id'])->fetch_assoc(); ?>
            <div class="row card-body font-italic">
                <div class="col-md-6 card-body border">
                    <h4>Nama : </h4>
                    <h5 class="text-secondary"><?php echo $cust_info['customer_name']; ?></h5>
                    <h4>Phone : </h4>
                    <h5 class="text-secondary"><?php echo $cust_info['customer_phone']; ?></h5>
                </div>
                <div class="col-md-6 card-body border">
                    <h4>Alamat : </h4>
                    <h5 class="text-secondary"><?php echo $cust_info['customer_address']; ?></h5>
                </div>
            </div>
        <?php } ?>
    </main>

<?php require_once 'inc/footer.php'; ?>