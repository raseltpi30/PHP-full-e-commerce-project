<?php
require_once('config.php');
session_start();
if(isset($_SESSION['user'])){
    $id = $_SESSION['user']['id'];
    $profile = GetSingleData2('ogani',$id);
};
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

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>
    <!-- favicon image  -->
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <!-- <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css"> -->
    <link rel="stylesheet" href="css/fontawesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="img/logo.png" alt=""></a>
        </div>
        <div class="col-lg-3">
                    <div class="header__cart">
                        <?php if (isset($_SESSION['user'])) : ?>
                            <ul>
                                <li><a href="shoping-cart.php"><i class="fa fa-heart"></i> <span>1</span></a></li>

                                <li><a href="shoping-cart.php"><i class="fa fa-shopping-bag"></i>
                                        <?php
                                        $stm = $connection->prepare("SELECT user_id FROM cart WHERE user_id=?");
                                        $stm->execute(array($_SESSION['user']['id']));
                                        $re = $stm->rowCount();
                                        ?>
                                        <span><?php echo $re ?></span></a></li>
                            </ul>
                        <?php else : ?>
                            <ul>
                                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                                <li><a href="shoping-cart.php"><i class="fa fa-shopping-bag"></i></a></li>
                            </ul>
                        <?php endif; ?>
                        <div class="header__cart__price">item: <span>$150.00</span></div>
                    </div>
                </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__language">
                <img src="img/language.png" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">Spanis</a></li>
                    <li><a href="#">English</a></li>
                </ul>
            </div>
            <div class="header__top__right__auth">
                <a href="../login.php"><i class="fa fa-user"></i>Login</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="../index.php">Home</a></li>
                <li><a href="./shop-grid.html">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.html">Shop Details</a></li>
                        <li><a href="./shoping-cart.php">Shoping Cart</a></li>
                        <li><a href="./checkout.php">Check Out</a></li>
                        <li><a href="./blog-details.html">Blog Details</a></li>
                    </ul>
                </li>
                <li><a href="./blog.html">Blog</a></li>
                <li><a href="./contact.html">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Free Shipping for all Order of $99</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <?php if(!isset($_SESSION['user'])) : ?>
                                    <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                                    <li>Free Shipping for all Order of $99</li>
                                <?php else : ?>
                                    <li><i class="fa fa-envelope"></i><?php echo $profile['email']; ?></li>
                                    <li>Free Shipping for all Order of $99</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                <a href="#"><i class="fa-brands fa-pinterest-p"></i></a>
                            </div>
                            <div class="header__top__right__language">
                                <img src="img/language.png" alt="">
                                <div>English</div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="#">Spanis</a></li>
                                    <li><a href="#">English</a></li>
                                </ul>
                            </div>
                            <div class="header__top__right__auth">
                                <?php if(!isset($_SESSION['user'])) : ?>
                                    <a href="login.php"><i class="fa fa-user"></i> Login Here</a>
                                <?php else: ?>
                                    <a href="profile.php"><small><?php echo $profile['username']; ?></small>&nbsp;&nbsp;
                                    <img style="height:30px;width:30px;border-radius:100%;" src="uploads/user_profile/<?php echo $profile['photo']; ?>" alt="<?php echo $profile['photo']; ?>"></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="index.php"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="index.php">Home</a></li>
                            <li><a href="./shop-grid.html">Shop</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="./shop-details.html">Shop Details</a></li>
                                    <li><a href="./shoping-cart.php">Shoping Cart</a></li>
                                    <li><a href="./checkout.php">Check Out</a></li>
                                    <li><a href="./blog-details.html">Blog Details</a></li>
                                    <li><a href="includes/logout.php">Logout</a></li>
                                </ul>
                            </li>
                            <li><a href="./blog.html">Blog</a></li>
                            <li><a href="./contact.html">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <?php if (isset($_SESSION['user'])) : ?>
                            <ul>
                                <li><a href="shoping-cart.php"><i class="fa fa-heart"></i> <span>1</span></a></li>

                                <li><a href="shoping-cart.php"><i class="fa fa-shopping-bag"></i>
                                <?php
                                $stm = $connection->prepare("SELECT user_id FROM cart WHERE user_id=?");
                                $stm->execute(array($_SESSION['user']['id']));
                                $re = $stm->rowCount();
                                ?>
                                <span><?php echo $re ?></span></a></li>
                            </ul> 
                        <?php else : ?>
                            <ul>
                                <li><a href="#"><i class="fa fa-heart"></i><span>1</span></a></li>
                                <li><a href="shoping-cart.php"><i class="fa fa-shopping-bag"></i></a></li>
                            </ul>
                        <?php endif; ?>
                        <div class="header__cart__price">item: <span>$150.00</span></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
<!-- Hero Section Begin -->
<section class="hero hero-normal">
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
            </div>
        </div>
    </div>
</section>
    <!-- Hero Section End -->
<div class="container">
<?php if(isset($error)) : ?>
    <div class="alert alert-danger text-center">
        <?php echo $error; ?>
    </div>
<?php endif; ?>
</div>

    