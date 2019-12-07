<?php
include "inc/header.php";
?>

<main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<h1>Brand <a href="brand.php" class="btn btn-outline-secondary float-right">Refresh</a></h1>
<div class="card-body">
    <div class="row">
        <div class="col-md-5">
            <h3 class="text-center">
                <?php
                if (isset($_GET['brand_id'])) {
                    echo "Update brand";
                } else {
                    echo "Add new brand";
                }
                ?>
            </h3>
            <div class="card-body">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['add_brand'])) {
                    $insert = $br->addNewBrand($_POST['brand_name']);
                }

                if (isset($insert)) {
                    echo $insert;
                }

                if (isset($_POST['update_brand'])) {
                    $update = $br->updateBrand($_GET['brand_id'], $_POST['update_brand_name']);
                }

                if (isset($update)) {
                    echo $update;
                }

                if (isset($_GET['brand_id'])) {
                    $brnd = $br->getBrandById($_GET['brand_id']);
                    ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="brand_name">Brand name</label>
                            <input type="text" name="update_brand_name"
                                   value="<?php echo $brnd['brand_name']; ?>" id="brand_name"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="update_brand" class="btn btn-success" value="Update">
                        </div>
                    </form>
                    <?php
                } else {
                    ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="brand_name">Brand name</label>
                            <input type="text" name="brand_name" id="brand_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="add_brand" class="btn btn-success" value="Add">
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>

        <div class="col">
            <h3 class="text-center">Brands</h3>
            <?php
                if (isset($_GET['del_brand_id'])){
                    $br->deleteBrand($_GET['del_brand_id']);
                }
            ?>
            <table class="table text-center">
                <tr>
                    <th>Serial</th>
                    <th>Brand name</th>
                    <th>Action</th>
                </tr>
                <?php
                $brands = $br->getBrands();
                if ($brands) {
                    $i = 0;
                    while ($brand = $brands->fetch_assoc()) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $brand['brand_name']; ?></td>
                            <td>
                                <a href="brand.php?brand_id=<?php echo $brand['id']; ?>" class="text-primary">Edit</a>
                                &nbsp;<a href="brand.php?del_brand_id=<?php echo $brand['id']; ?>"
                                   onclick="return confirm('Are you sure ?')" class="text-danger">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } ?>

            </table>
        </div>
    </div>
</div>
</main>

<?php
include "inc/footer.php";
?>