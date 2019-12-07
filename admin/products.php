<?php
include "inc/header.php";
?>

<?php
    if (isset($_GET['del_pro_id'])){
        $product->deleteProduct($_GET['del_pro_id']);
    }
?>

    <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
        <h1>Products <a href="products.php" class="btn btn-outline-secondary float-right">Refresh</a></h1>
        <div class="card-body">
            <table class="table text-center table-bordered">
                <tr>
                    <th>Seri</th>
                    <th>Nama</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>harga</th>
                    <th>Description</th>
                    <th>Gambar</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>

                <?php
                $pro = $product->getProducts();
                if ($pro) {
                    $i = 0;
                    while ($pr = $pro->fetch_assoc()) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $pr['pro_name']; ?></td>
                            <td><?php echo $pr['cat_name']; ?></td>
                            <td><?php echo $pr['brand_name']; ?></td>
                            <td><?php echo $pr['price']; ?></td>
                            <td><?php echo $fm->textShorten($pr['description'], 90); ?></td>
                            <td><img src="../<?php echo $pr['image']; ?>" height="70" alt="image"></td>
                            <td>
                                <?php
                                if ($pr['type'] == 0) {
                                    echo 'Featured';
                                } else {
                                    echo 'General';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="add_product.php?pro_id=<?php echo $pr['pro_id']; ?>">Edit</a>&nbsp;
                                <a href="products.php?del_pro_id=<?php echo $pr['pro_id']; ?>" class="text-danger"
                                   onclick="return confirm('Are you sure ?')">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </table>
        </div>
    </main>

<?php
include "inc/footer.php";
?>