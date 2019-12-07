<?php
include "inc/header.php";
?>

    <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
        <h1>Category <a href="category.php" class="btn btn-outline-secondary float-right">Refresh</a></h1>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <h3 class="text-center">
                        <?php
                        if (isset($_GET['cat_id'])) {
                            echo "Update Category";
                        } else {
                            echo "Add new Category";
                        }
                        ?>
                    </h3>
                    <div class="card-body">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['add_cat'])) {
                            $insert = $cat->addNewCategory($_POST['cat_name']);
                        }

                        if (isset($insert)) {
                            echo $insert;
                        }

                        if (isset($_POST['update_cat'])) {
                            $update = $cat->updateCategory($_GET['cat_id'], $_POST['update_cat_name']);
                        }

                        if (isset($update)) {
                            echo $update;
                        }

                        if (isset($_GET['cat_id'])) {
                            $ct = $cat->getCategoryById($_GET['cat_id']);
                            ?>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_name">Category name</label>
                                    <input type="text" name="update_cat_name"
                                           value="<?php echo $ct['cat_name']; ?>" id="cat_name"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="update_cat" class="btn btn-success" value="Update">
                                </div>
                            </form>
                            <?php
                        } else {
                            ?>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_name">Category name</label>
                                    <input type="text" name="cat_name" id="cat_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="add_cat" class="btn btn-success" value="Add">
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>

                <div class="col">
                    <h3 class="text-center">Categories</h3>
                    <?php
                    if (isset($_GET['del_cat_id'])){
                        $cat->deleteCategory($_GET['del_cat_id']);
                    }
                    ?>
                    <table class="table text-center">
                        <tr>
                            <th>Serial</th>
                            <th>Brand name</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $cats = $cat->getCategories();
                        if ($cats) {
                            $i = 0;
                            while ($category = $cats->fetch_assoc()) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $category['cat_name']; ?></td>
                                    <td>
                                        <a href="category.php?cat_id=<?php echo $category['id']; ?>" class="text-primary">Edit</a>
                                        &nbsp;<a href="category.php?del_cat_id=<?php echo $category['id']; ?>"
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