<h5 class="my-3 bg-dark list-group-item text-white">Categories</h5>
<div class="list-group">
    <?php
    $cts = $cat->getCategories();
    if ($cts) {
        while ($ct = $cts->fetch_assoc()) {
            ?>
            <a href='productsByCat.php?cat_id=<?php echo $ct['id']; ?>' class='list-group-item
<?php
            if (isset($_GET['cat_id']) AND $_GET['cat_id'] == $ct['id']) echo 'active';
            ?>
'><?php echo $ct['cat_name']; ?></a>
        <?php }
    } ?>
</div>

