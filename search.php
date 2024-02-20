<?php 
require_once('includes/header.php');  
?>
<div class="container">
    <div class="row justify-content-center">
    <div class="featured__item text-center m-5">
        <div class="featured__item__pic set-bg" data-setbg="../our_store/uploads/products/<?php echo $_SESSION['search']['photo']; ?>">
        <img src="../our_store/uploads/products/<?php echo $_SESSION['search']['photo'] ?>" alt="">
        <ul class="featured__item__pic__hover">
            <li><a href="#"><i class="fa fa-heart"></i></a></li>
            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
        </ul>
        </div>
        <div class="featured__item__text">
        <h5><a style="color:#000;font-weight:700;text-transform:uppercase;" href="product-details.php?id=<?php echo $_SESSION['search']['id'];?>"><?php echo $_SESSION['search']['product_name']; ?></a></h5>
        <h5>$<?php echo $_SESSION['search']['price']; ?></h5>
        </div>
        </div>
    </div>
</div>
<section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Related Product</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php 
                $stm = $connection->prepare("SELECT * FROM products WHERE product_category=?");
                $stm->execute(array($_SESSION['search']['product_category']));
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);

                foreach($result as $row) :
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <a href="product-details.php?id=<?php echo $row['id']; ?>"><div class="product__item__pic set-bg" data-setbg="../our_store/uploads/products/<?php echo $row['photo']; ?>">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div></a>
                        <div class="product__item__text">
                            <h6 class="text-capitalize"><a href="product-details.php?id=<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></a></h6>
                            <h5>$<?php echo $row['price']; ?></h5>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php require_once('includes/footer.php');  ?>