<?php
include "inc/header.php";
?>

    <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
        <h1>
            <?php
            if (isset($_GET['pro_id'])) {
                echo 'Update Product';
            } else {
                echo 'Add New Product';
            }
            ?>
            <a href="add_product.php" class="btn btn-outline-secondary float-right">Refresh</a>
        </h1>
        <div class="card-body" style="width: 70%; margin: 0 auto">

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['add_product'])) {
                $insert = $product->addNewProduct($_POST, $_FILES);
                if (isset($insert)) {
                    echo $insert;
                }
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['update_product']) and isset($_GET['pro_id'])){
                $update = $product->updateProduct($_POST, $_FILES, $_GET['pro_id']);
                if (isset($update)) {
                    echo $update;
                }
            }
            ?>


            <?php
            if (isset($_GET['pro_id'])) {
                $pro_details = $product->getProductById($_GET['pro_id']);
                ?>
                <!--Update Product-->
                <form action="" method="post" enctype=multipart/form-data>
                    <div class="form-group">
                        <label for="pro_name">Nama Produk</label>
                        <input type="text" name="pro_name" id="pro_name" class="form-control"
                               value="<?php echo $pro_details['pro_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="cat_id" id="category" class="form-control">
                            <option>Pilih Category</option>
                            <?php
                            $cats = $cat->getCategories();
                            if ($cats) {
                                while ($cat_val = $cats->fetch_assoc()) {
                                    ?>
                                    <option
                                        <?php
                                        if ($cat_val['id'] == $pro_details['cat_id']) {
                                            echo 'selected';
                                        }
                                        ?>
                                            value="<?php echo $cat_val['id']; ?>"><?php echo $cat_val['cat_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <select name="brand_id" id="brand" class="form-control">
                            <option>Pilih Brand</option>
                            <?php
                            $brands = $br->getBrands();
                            if ($brands) {
                                while ($brand_val = $brands->fetch_assoc()) {
                                    ?>
                                    <option
                                        <?php
                                        if ($brand_val['id'] == $pro_details['brand_id']) {
                                            echo 'selected';
                                        }
                                        ?>
                                            value="<?php echo $brand_val['id']; ?>"><?php echo $brand_val['brand_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input type="number" name="price" id="price" class="form-control"
                               value="<?php echo $pro_details['price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Product Details</label>
                        <textarea name="description" id="description"
                                  class="form-control"><?php echo $pro_details['description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar</label><br>
                        <img src="../<?php echo $pro_details['image']; ?>" height="100" width="150" alt="">
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option>Select Product Type</option>
                            <?php if ($pro_details['type'] == 0) { ?>
                                <option selected value="0">Featured</option>
                                <option value="1">General</option>
                            <?php } else { ?>
                                <option value="0">Featured</option>
                                <option selected value="1">General</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="update_product" value="Update Product"
                               class="btn btn-primary btn-block">
                    </div>
                </form>
                <!--Update product end here-->
                <?php
            } else {
                ?>
                <!--Add Product-->
                <form action="" method="post" enctype=multipart/form-data>
                    <div class="form-group">
                        <label for="pro_name">Nama Produk</label>
                        <input type="text" name="pro_name" id="pro_name" class="form-control"
                               placeholder="Product name">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="cat_id" id="category" class="form-control">
                            <option>Select Category</option>
                            <?php
                            $cats = $cat->getCategories();
                            if ($cats) {
                                while ($cat_val = $cats->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $cat_val['id']; ?>"><?php echo $cat_val['cat_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <select name="brand_id" id="brand" class="form-control">
                            <option>Select Brand</option>
                            <?php
                            $brands = $br->getBrands();
                            if ($brands) {
                                while ($brand_val = $brands->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $brand_val['id']; ?>"><?php echo $brand_val['brand_name']; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input type="number" name="price" id="price" class="form-control"
                               placeholder="Product price">
                    </div>
                    <div class="form-group">
                        <label for="description">Product Details</label>
                        <textarea name="description" id="description" class="form-control"
                                  placeholder="Product description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option>Select Product Type</option>
                            <option value="0">Featured</option>
                            <option value="1">General</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="add_product" value="Add Product"
                               class="btn btn-primary btn-block">
                    </div>
                </form>
                <?php
            }
            ?>

        </div>
    </main>

<?php
include "inc/footer.php";
?>