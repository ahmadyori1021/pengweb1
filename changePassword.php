<?php
include "inc/header.php";

if (session::get('cust_login')==false){
echo "<script>window.location = 'home.php'</script>";
}
?>

<div class="container">
<div class="card-body">
    <h2 class="font-italic text-center">Ganti password</h2>
<div class="card-body">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
<?php
    if (isset($_POST['updatePassword'])){
        $changed = $cust->changePassword($_POST);
        if (isset($changed)){
            echo $changed;
        }
    }
?>
                <form action="" method="post">
                    <table class="table font-italic text-center">
                        <tr>
                            <td>password lama</td>
                            <td>:</td>
                            <td><input type="password" name="oldPassword" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>password baru</td>
                            <td>:</td>
                            <td><input type="password" name="newPassword" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Confirm password baru</td>
                            <td>:</td>
                            <td><input type="password" name="confirmNewPassword" class="form-control"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><input type="submit" name="updatePassword" value="Change" class="btn btn-secondary"></td>
                        </tr>
                    </table>
                </form>

        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</div>
</div>

<?php
include "inc/footer.php";
?>
