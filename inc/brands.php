<h5 class="my-3 bg-dark list-group-item text-white">Brands</h5>
<div class="list-group">
    <?php
    $brands = $br->getBrands();
    if ($brands) {
        while ($brand = $brands->fetch_assoc()) {
            ?>
            <a href="productsByBrand.php?brand_id=<?php echo $brand['id']; ?>"
               class="list-group-item <?php if (isset($_GET['brand_id']) AND $_GET['brand_id'] == $brand['id']) echo 'active'; ?>"><?php echo $brand['brand_name']; ?></a>
        <?php }
    } ?>
</div>