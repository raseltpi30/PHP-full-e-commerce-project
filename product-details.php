<?php
require_once('includes/header.php'); 
if(isset($_SESSION['user'])){
    $id = $_REQUEST['id'];
    $_SESSION['request'] = $_REQUEST['id']; //work for submit_rating
    $user_id = $_SESSION['user']['id'];
    $products = GetSingleData2('products',$id); 
    $product2 = GetTableData2('products'); 
}
  
else{
    ?>
    <script>
        setTimeout(function(){
            window.location.href="login.php";
        });
    </script>
    <?php
}
if(isset($_POST['cart_form'])){
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $dbQuantity = $products['quantity'];

    $stm = $connection->prepare("SELECT product_id FROM cart WHERE user_id=? AND product_id=?");
    $stm->execute(array($user_id,$id));
    $cartCount = $stm->rowCount();

    if($quantity == 0){
        $error = "Quantity Must Be More Than 0!";
    }
    elseif($cartCount != 0){
        $error = "Product Already in The Cart!";
    }
    elseif($quantity > $dbQuantity){
        $error = "Product Quantity Out of stock!";
    }
    else{
        $created_at = date('Y-m-d H:i:s');
        $data_price = $products['price'];
        $total_price = $data_price * $quantity;
        $stm = $connection->prepare("INSERT INTO cart(user_id,product_id,product_name,price,quantity,total_price,created_at) VALUES(?,?,?,?,?,?,?)");
        $stm->execute(array($user_id,$id,$product_name,$price,$quantity,$total_price,$created_at));

        $success = "Data Insert To cart is Successfully!";  
    }
}
?>
<?php 
if(isset($_REQUEST['id'])){
    $stm = $connection->prepare("SELECT id FROM products where id=?");
    $stm->execute(array($id));
    $result = $stm->rowCount(); 
    if($result != 1){
        $error = "Product Not Found!";
    }
    else{
        ?>
        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2><?php echo getProductCategoryName('category_name',$products['product_category']); ?> Package</h2>
                            <div class="breadcrumb__option">
                                <a href="./index.html">Home</a>
                                <a href="./index.html"><?php echo getProductCategoryName('category_name',$products['product_category']); ?></a>
                                <span><?php echo getProductCategoryName('category_name',$products['product_category']); ?> Package</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
        
        <!-- Product Details Section Begin -->
        <section class="product-details spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="product__details__pic">
                                <div class="product__details__pic__item">
                                    <img class="product__details__pic__item--large" src="../our_store/uploads/products/<?php echo $products['photo'] ?>" alt="">
                                </div>
                                <div class="product__details__pic__slider owl-carousel">
                                    <?php $allProduct = GetTableData2('products');
                                    foreach ($allProduct as $row) :
                                    ?>
                                        <a href="product-details.php?id=<?php echo $row['id']; ?>"><img src="../our_store/uploads/products/<?php echo $row['photo'] ?>" alt=""></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="product__details__text">
                                <h3><?php echo $products['product_name']; ?></h3>
                                <div class="product__details__rating">
                                    <i class="fas fa-star star-light mr-1 main-star"></i>
                                    <i class="fas fa-star star-light mr-1 main-star"></i>
                                    <i class="fas fa-star star-light mr-1 main-star"></i>
                                    <i class="fas fa-star star-light mr-1 main-star"></i>
                                    <i class="fas fa-star star-light mr-1 main-star"></i>
                                    <b><span id="average_rating">0.0</span> / 5</b> 
                                    (<span id="total_review">0</span> reviews)           
                                    <button style="margin-left: 30px;" type="button" id="add_review" class="btn btn-sm btn-primary">Review</button>
                                </div>
                                <div class="product__details__price">
                                    $<?php echo $products['price'] ?>
                                </div>
                                <p><?php echo $products['descriptions'] ?></p>

                                <div class="product__details__quantity">
                                    <?php if (isset($error)) : ?>
                                        <div class="alert alert-danger">
                                            <?php echo $error; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($success)) : ?>
                                        <div class="alert alert-success">
                                            <?php echo $success; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="quantity">
                                    <form action="" method="POST">
                                            <div class="pro-qty">
                                            <input min="1" max="5" type="text" id="quantity" value="1" name="quantity">

                                            <input type="hidden" id="hidden" name="hidden" value="">
                                                <!-- <input type="hidden" id="total_price" name="total_price" value=""> -->
                                            </div>
                                            <input type="hidden" id="product_id" name="product_id" value="<?php echo $products['id'] ?>">

                                            <input type="hidden" id="product_name" name="product_name" value="<?php echo $products['product_name'] ?>">
                                            <input type="hidden" id="price" name="price" value="<?php echo $products['price'] ?>">
                                            <input style="border:none" type="submit" class="primary-btn" name="cart_form" value="ADD TO CARD">
                                        </form>
                                    </div>
                                </div>
                                <ul>
                                    <li><b>Availability</b>
                                        <?php
                                        if ($products['quantity'] == 0) {
                                            echo 'Product Out Of Stock';
                                        }
                                        else{
                                            echo '<span>Product In Stock</span>';
                                        }

                                        ?>
                                    </li>
                                    <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                                    <li><b>Weight</b> <span><?php echo $products['weight'] ?>kg</span></li>
                                    <li><b>Share on</b>
                                        <div class="share">
                                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            <a href="#"><i class="fa-brands fa-pinterest-p"></i></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="product__details__tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab" aria-selected="false">Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Reviews <span>
                                            (<?php 
                                            $stm = $connection->prepare("SELECT * FROM rating WHERE product_id=?");
                                            $stm->execute(array($_REQUEST['id']));
                                            $re = $stm->rowCount();
                                            echo $re;                                        
                                        ?>)
                                        </span></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                        <div class="product__details__tab__desc">
                                            <h6>Products Infomation</h6>
                                            <p><?php echo $products['descriptions'] ?></p>
                                            <!-- <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                                    ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                                    elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                                    porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                                    nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                                    Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed
                                                    porttitor lectus nibh. Vestibulum ac diam sit amet quam vehicula elementum
                                                    sed sit amet dui. Proin eget tortor risus.</p> -->
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                                        <div class="product__details__tab__desc">
                                            <h6>Products Infomation</h6>
                                            <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                                Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                                Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                                sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                                eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                                Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                                sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                                diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                                ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                                Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                                Proin eget tortor risus.</p>
                                            <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                                ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                                elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                                porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                                nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</p>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                                        <div class="product__details__tab__desc">
                                            <h6>Products Review & Rating<h6> 
                                            <div class="row">
                                                <?php 
                                                    $stm=$connection->prepare("SELECT * FROM rating WHERE product_id=?");
                                                    $stm->execute(array($id));
                                                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach($result as $row) :
                                                    $image_profile = GetNameByid('ogani','photo',$row['user_id']);
                                                ?>
                                                <div class="col-sm-1 text-center">
                                                    <img style="border-radius: 100%; object-fit:cover;max-width:unset;" src="uploads/user_profile/<?php echo $image_profile;?>" width="80px" height="80px">
                                                </div>

                                                <div class="col-sm-5 col-md-5">
                                                    <div class="commenttext-justify float-left">
                                                        <h4 class="mb-2"><?php echo GetNameByid('ogani','name',$row['user_id']); ?></h4>
                                                        <div class="star">
                                                            <?php if($row['user_rating']==5) : ?>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                            <?php elseif($row['user_rating']==4): ?>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                            <?php elseif($row['user_rating']==3): ?>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                            <?php elseif($row['user_rating']==2): ?>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                            <?php else: ?>
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                        <p class="mt-2"><?php echo $row['user_review'] ?></p>
                                                        <div class="post-span text-right"><span><?php echo $row['datetime']; ?></span></div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>                                                      
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <!-- Product Details Section End -->

        <!-- Related Product Section Begin -->
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
                    $stm->execute(array($products['product_category']));
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $row) :
                    ?>
                        <div class="col-md-3">
                            <div class="product__item__pic set-bg" data-setbg="../our_store/uploads/products/<?php echo $row['photo'];?>">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6 class="text-capitalize"><a href="product-details.php?id=<?php echo $row['id'];?>"><?php echo $row['product_name']; ?></a></h6>
                                <h5>$<?php echo $row['price']; ?></h5>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
            </div>
        </section>
        <!-- Related Product Section End -->
        <?php
    }
}
?>
<div class="container">
    <?php if(isset($error)) : ?>
            <h1 style="padding:100px;" class="alert text-center">
                <?php echo $error; ?>
            </h1>
        </div>
    <?php endif; ?>
</div>   
<?php require_once('includes/footer.php') ?>

<div id="review_modal" class="modal" tabindex="1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="text-center mt-2 mb-4">
                    <i class="fas fa-star satr-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                    <i class="fas fa-star satr-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                    <i class="fas fa-star satr-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                    <i class="fas fa-star satr-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                    <i class="fas fa-star satr-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                </h4>
                <div class="form-group mb-3">
                    <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Your Review Here"></textarea>
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-primary" id="submit_review">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>