<?php
include "inc/header.php";

if (session::get('adminLogin')==false){
echo "<script>window.location = 'login.php'</script>";
}
?>

<div class="container">
<div class="card-body">
<?php
if (isset($_GET['action']) and $_GET['action'] == 'update') {
    echo '<h2 class="font-italic text-center">Update your profile</h2>';
} else {
    echo '<h2 class="font-italic text-center">Your profile</h2>';
}
?>

<div class="card-body">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <?php
            $value = $admin->adminProfile();

            if (isset($_POST['update'])){
                $admin->updateAdminProfile($_POST);
                echo "<script>window.location = 'profile.php'</script>";
            }
            ?>

            <?php
            if (isset($_GET['action']) and $_GET['action'] == 'update') {
                ?>
                <form action="" method="post">
                    <table class="table font-italic text-center">
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><input type="text" name="name" value="<?php echo $value['admin_name']; ?>"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><input type="email" name="email" value="<?php echo $value['admin_email']; ?>"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td><input type="text" name="username" value="<?php echo $value['admin_username']; ?>"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><input type="submit" name="update" value="Update" class="btn btn-success"></td>
                        </tr>
                    </table>
                </form>
                <?php
            } else {
                ?>
                <table class="table font-italic text-center">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?php echo $value['admin_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?php echo $value['admin_email']; ?></td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>:</td>
                        <td><?php echo $value['admin_username']; ?></td>
                    </tr>
                </table>
                <h5><a href="?action=update" class="float-right font-italic nav-link">Update your profile</a></h5>
                <br><br>
                <h6><a href="admin_changePassword.php" class="float-right text-danger font-italic nav-link">Change password</a></h6>
            <?php } ?>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</div>
</div>

<?php
include "inc/footer.php";
?>
