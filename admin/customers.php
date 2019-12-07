<?php
require_once 'inc/header.php';
?>

<?php 
    if (isset($_GET['d_id'])) {
        $cust->disable($_GET['d_id']);
    }

    if (isset($_GET['e_id'])) {
        $cust->enable($_GET['e_id']);
    }
 ?>
    <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
        <h1 class="font-italic text-center">Customers</h1>

        <table class="table text-center">

                <tr>
                    <th>Seri</th>
                    <th>Nama Customer</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Activation Status</th>
                    <th>Action</th>
                </tr>
        <?php 
            $customersData = $cust->customersData();
            $cd_rows = $customersData->num_rows;
            if ($cd_rows > 0) {
                $i = 0;
                while ($cd = $customersData->fetch_assoc()) {
                    $i++;
        ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $cd['customer_name']; ?></td>
                    <td><?php echo $cd['customer_phone']; ?></td>
                    <td><?php echo $cd['customer_email']; ?></td>
                    <th>
                        <?php 
                            if ($cd['activation_status'] == 'Yes') {
                                echo "<span class='text-success'>".$cd['activation_status']."</span>";
                            } else {
                                echo "<span class='text-danger'>".$cd['activation_status']."</span>";
                            }
                            
                        ?>
                    </th>
                    <td class="font-italic">
                        <?php if ($cd['enable_disable'] == 'Enable') { ?>
                            <a href="?d_id=<?php echo $cd['customer_id']; ?>" class="text-danger" onclick="return confirm('Are you sure to Disable this account?');">Disable</a>
                        <?php }else{ ?>
                            <a href="?e_id=<?php echo $cd['customer_id']; ?>" class="text-success">Enable</a>
                        <?php } ?>
                    </td>
                </tr>
          <?php } } ?>     
        </table>
    </main>

<?php require_once 'inc/footer.php'; ?>