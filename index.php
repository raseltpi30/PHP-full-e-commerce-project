<?php 
require_once('includes/header-home.php'); 

if(isset($_POST['search_btn'])){
    $search = $_POST['product_name'];
    $stm = $connection->prepare("SELECT * FROM products WHERE product_name=?");
    $stm->execute(array($search));
    $result = $stm->rowCount(); 
    if(empty($search)){
        $error = "Please Enter a Product Name!";
    }
    elseif($result==0){
        $error = "Product Not Found!";
    }
    else{
        $result2 = $stm->fetch(PDO::FETCH_ASSOC);
        print_r($result2);
        $_SESSION['search'] = $result2;
        ?>
        <script>
            setTimeout(function(){
                window.location.href="search.php";
            });
        </script>

        <?php
    }
}
?>
<div class="container">
    <?php if(isset($error)) : ?>
        <div class="alert alert-danger text-center">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
</div>
<!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All Categories</span>
                        </div>
                        <ul>
                            <?php $cat = GetTableData2('categories');
                            foreach($cat as $row) :
                            ?>

                            <li><a style="text-transform:capitalize;" href="#meat"><?php echo $row['category_name']; ?></a></li>

                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="" method="POST">
                                <div class="hero__search__categories">
                                    All Categories
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" name="product_name" placeholder="What do yo u need?" id="search" value="<?php value('product_name');?>">
                                <button type="submit" class="site-btn" name="search_btn">SEARCH</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>+65 11.188.888</h5>
                                <span>support 24/7 time</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
                        <div class="hero__text">
                            <span>FRUIT FRESH</span>
                            <h2>Vegetable <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="#" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <?php 
                    $products = GetTableData2('products');
                    foreach ($products as $product) :
                    ?>
                    <div class="col-lg-3">
                            <div class="categories__item set-bg">
                            <img src="../our_store/uploads/products/<?php echo $product['photo']; ?>" alt="">
                            <h5><a href="product-details.php?id=<?php echo $product['id'];?>"><?php echo $product['product_name']; ?></a></h5>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                    <div class="featured__controls" id="meat">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            <?php $catName = GetTableData2('categories'); 
                            foreach($catName as $cat) :
                                                      
                            ?>
                            <li data-filter=".fresh-meat-<?php echo $cat['id'] ?>"><?php echo $cat['category_name']; ?></li> 

                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <?php
                $getProduct = GetTableData2('products');
                foreach($getProduct as $product1) :
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 text-capitalize mix oranges fresh-meat-<?php echo getProductCategoryName('id',$product1['product_category']); ?>">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="../our_store/uploads/products/<?php echo $product1['photo']; ?>">
                        <img src="../our_store/uploads/products/<?php echo $product1['photo'] ?>" alt="">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h5><a style="color:#000;font-weight:700;text-transform:uppercase;" href="product-details.php?id=<?php echo $product1['id'];?>"><?php echo $product1['product_name']; ?></a></h5>
                            <h5>$<?php echo $product1['price']; ?></h5>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Latest Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <?php $getProduct = GetTableData2('products');
                            foreach ($getProduct as $product):
                            ?>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../our_store/uploads/products/<?php echo $product['photo']; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $product['product_name']; ?></h6>
                                        <span>$<?php echo $product['price']; ?></span>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Top Rated Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <?php $getProduct = GetTableData2('products');
                            foreach ($getProduct as $product):
                            ?>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../our_store/uploads/products/<?php echo $product['photo']; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $product['product_name']; ?></h6>
                                        <span>$<?php echo $product['price']; ?></span>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Review Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <?php $getProduct = GetTableData2('products');
                            foreach ($getProduct as $product):
                            ?>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="../our_store/uploads/products/<?php echo $product['photo']; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $product['product_name']; ?></h6>
                                        <span>$<?php echo $product['price']; ?></span>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-1.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Cooking tips make cooking simple</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-2.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-3.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Visit the clean farm in the US</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Blog Section End -->
<?php require_once('includes/footer.php'); ?>