<?php include "inc/header.php"; ?>

<div class="container">
<div class="row">
    <div class="col-md-3">
        <?php include "inc/categories.php";?>
        <?php //include "inc/brands.php";?>
    </div>

    <div class="col-md-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img class="d-block img-fluid" src="images/slider1.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block img-fluid" src="images/slider2.png" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block img-fluid" src="images/slider 3.png" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <h2>Terlaris</h2>

        <div class="row">
            <?php
            $f_pros = $product->getFeaturedProducts();
            if ($f_pros) {
                while ($f_pro = $f_pros->fetch_assoc()) {

                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="card-body border">
                            <a href="details.php?pro_id=<?php echo $f_pro['pro_id']; ?>"><img
                                    class="card-img-top" src="<?php echo $f_pro['image']; ?>" height="200"
                                    alt="">
                            </a><hr>
                            <h5>
                                <a href="details.php?pro_id=<?php echo $f_pro['pro_id']; ?>"><?php echo $f_pro['pro_name']; ?></a>
                            </h5>
                            <h6>Rp. <?php echo $f_pro['price']; ?></h6>
                            <p class="card-text"><?php echo $fm->textShorten($f_pro['description'], 80); ?></p>

                            <a href="details.php?pro_id=<?php echo $f_pro['pro_id']; ?>"
                               class="btn btn-danger text-light btn-block">Angkut Gan</a>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
        <hr>

        <h2>Produk Baru</h2>

        <div class="row">

            <?php
            $per_page = 6;
            if (isset($_GET['p'])) {
                $page = $_GET['p'];
            } else {
                $page = 1;
            }
            $start_from = ($page - 1) * $per_page;

            $n_pros = $product->getNewProducts($start_from, $per_page);
            $n_pros_rows = $n_pros->num_rows;
            if ($n_pros) {
                while ($n_pro = $n_pros->fetch_assoc()) {

                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="card-body border">
                            <a href="details.php?pro_id=<?php echo $n_pro['pro_id']; ?>"><img
                                    class="card-img-top" src="<?php echo $n_pro['image']; ?>" height="200" alt="">
                            </a><hr>
                            <h5 class="card-title">
                                <a href="details.php?pro_id=<?php echo $n_pro['pro_id']; ?>"><?php echo $n_pro['pro_name']; ?></a>
                            </h5>
                            <h6>Rp. <?php echo $n_pro['price']; ?></h6>
                            <p class="card-text"><?php echo $fm->textShorten($n_pro['description'], 80); ?></p>

                            <a href="details.php?pro_id=<?php echo $n_pro['pro_id']; ?>"
                               class="btn btn-danger text-light btn-block">Angkut Gan</a>
                        </div>
                    </div>
                <?php } } ?>
        </div>

            <?php 
                $p_rows = $product->getNewProductsForPagination();
                if (isset($_GET['p'])) {
                    if($_GET['p'] == $p_rows){
                        $first_page = "Go to first page";
                    }else{
                        $p = $_GET['p'] + 1;
                    }
                } else {
                    $p = 2;
                }
             ?>

    </div>
</div>
</div>

<?php include "inc/footer.php"; ?>