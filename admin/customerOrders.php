<?php
require_once 'inc/header.php';
?>

    <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
        <h1 class="font-italic text-center">Customer Orders</h1>
        <?php
        if (isset($_GET['action']) and $_GET['action'] == 'del_pro') {
            $cust->deleteShiftedPro();
            echo "<meta http-equiv='refresh' content=\"0;URL=?id=live\">";
        }
        ?>

        <?php

        ?>
        <div class="card-body float-right">
            <a href="?action=del_pro" class="btn btn-danger"
               onclick="return confirm('Are you sure to delete shifted products ?')">Delete
                shifted products</a>
        </div>

        <table class="table table-striped text-center">

            <?php
            $c_orders = $cust->customerDistinctOrders();
            $rows = mysqli_num_rows($c_orders);
            if ($rows > 0) { ?>
                <tr>
                    <th>Serial No</th>
                    <th>Nama Customer</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>View Orders</th>
                </tr>
                <?php
                $i = 0;
                while ($c_order = $c_orders->fetch_assoc()) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $c_order['customer_name']; ?></td>
                        <td><?php echo $c_order['customer_phone']; ?></td>
                        <td><?php echo $c_order['customer_email']; ?></td>
                        <td>
                            <a href="orders.php?cmr_id=<?php echo $c_order['customer_id']; ?>"
                               class="btn
                            <?php
                               $cfm_val = $cust->customerOrders($c_order['customer_id'])->fetch_assoc();
                               if ($cfm_val['status'] == 2) {
                                   echo 'btn-success';
                               }elseif($cfm_val['status'] == 1){
                                    echo 'btn-warning';
                                }else{
                                   echo 'btn-primary';
                               }
                               ?>
                            ">View</a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <div class="card-body text-center">
                    <pre style="font-size: 25px; color: red">Orders not available !</pre>
                </div>
            <?php } ?>
        </table>
    </main>

<?php require_once 'inc/footer.php'; ?>