<?php 
require_once('includes/header.php');
$user_id = $_SESSION['user']['id'];
$user = GetSingleData2('ogani',$user_id);
$cartItems = GetTableData4('cart',$user_id);
if(!isset($_SESSION['user'])){
    ?>
        <script>
            window.location.href='login.php';
        </script>
    <?php
}
if(count($cartItems)==0){
    ?>
        <script>
            alert('Cart Is Empty!...Please add Product On Your shoping cart for shoping!');
            window.location.href='shoping-cart.php';
        </script>
    <?php
}

if(isset($_POST['order_form'])){
    $name = $_POST['name'];
    $lastName = $_POST['lastname'];
    $country = $_POST['country'];
    $address = $_POST['address'];
    $town = $_POST['town'];
    $postcode = $_POST['postcode'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $grand_total = $_POST['grand_total'];
    $password = $_POST['password'];
    $db_password = $user['password'];
    $password_hash = SHA1($password); 

    if(empty($name)){
        $error = "Name is Required!";
    }
    elseif(empty($country)){
        $error = "Country Name is Required!";
    }
    elseif(empty($address)){
        $error = "Address is Required!";
    }
    elseif(empty($postcode)){
        $error = "Postcode is Required!";
    }
    elseif(empty($mobile)){
        $error = "Mobile is Required!";
    }
    elseif(empty($email)){
        $error = "Email is Required!";
    }
    elseif(empty($password)){
        $error = "Password is Required!";
    }
    elseif($db_password != $password_hash){
        $error = "Password is Wrong!";
    }
    else {
        $created_at = date('Y-m-d H:i:s');
        $con=mysqli_connect("localhost","root","","user_store");
        $query1 = "INSERT INTO `customer_details`(`name`, `lastname`, `country`, `address`, `town`, `postcode`, `mobile`, `email`, `grand_total`, `status`, `created_at`) VALUES ('$name','$lastName','$country','$address','$town','$postcode','$mobile','$email','$grand_total','Pending','$created_at')";
        if(mysqli_query($con,$query1)){            
            $Order_ID=mysqli_insert_id($con);
            foreach($cartItems as $key => $values){
                $data_quantity = getProductName('quantity',$values['product_id']); 
                echo $data_quantity;
                $product_id = $values['product_id'];
                $Item_Name = $values['product_name'];
                $Price = $values['price'];
                $Quantity = $values['quantity'];
                $Total_price = $values['total_price'];
                $query2= "INSERT INTO `order_to`(`order_id`,`user_id`,`product_id`,`product_name`, `price`, `quantity`, `total_price`, `status`, `created_at`) VALUES ('$Order_ID','$user_id','$product_id','$Item_Name','$Price','$Quantity','$Total_price','Pending','$created_at')";
                $stmt = mysqli_query($con,$query2);

                $success = "Order Placed Successfully";
                unset($_POST);
                $query3 = DeleteTableData3('cart');
                echo "<script>
                    setTimeout(function(){
                        window.location.href='shoping-cart.php';
                    },2000);
                </script>"; 
                $new_quantity = $data_quantity - $Quantity;
                $stm = $connection->prepare("UPDATE products SET quantity=? WHERE id=?");
                $stm->execute(array($new_quantity,$values['product_id']));
            }
        }
    }
}
// if(isset($_POST['delete'])){
//     $delete = DeleteTableData4('customer_details');
//     $delete = DeleteTableData4('order_to');
// }
?>


<!-- <form action="" method="POST">
    <input type="submit" value="Delete" name="delete">
</form> -->
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg"> +
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Checkout</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                </h6>
            </div>
        </div>
        <div class="checkout__form">
            <?php if(isset($error)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <?php if(isset($success)) : ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            <h4>Billing Details</h4>
            <form action="" method="POST">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Customer First Name<span>*</span></p>
                                    <input type="text" placeholder="Name" name="name" value="<?php echo $user['name']; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Last Name<span>*</span></p>
                                    <input type="text" placeholder="Optional" name="lastname" value="<?php value('country');?>">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <label for="country">Country<span>*</span></label>
                            <input type="text" name="country" value="<?php value('country');?>" id="country">
                        </div>
                        <div class="checkout__input">
                            <label for="address">Address<span>*</span></label>
                            <input type="text" placeholder="Street Address" class="checkout__input__add" name="address" value="<?php value('address');?>">
                        </div>
                        <div class="checkout__input">
                            <p>Town/City<span>*</span></p>
                            <input type="text" name="town" value="<?php value('town');?>">
                        </div>
                        <div class="checkout__input">
                            <p>Postcode / ZIP<span>*</span></p>
                            <input type="text" name="postcode" value="<?php value('postcode');?>">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <label for="mobile">Phone<span>*</span></label>
                                    <input type="text" placeholder="Mobile" name="mobile" id="mobile" value="<?php echo $user['mobile']; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <label for="email">Email<span>*</span></label>
                                    <input type="text" placeholder="email" name="email" id="email" value="<?php echo $user['email']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Account Password<span>*</span></p>
                            <input name="password" type="password" value="<?php value('password'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>
                                <?php 
                                $total_price = 0;
                                foreach($cartItems as $title) : ?>
                                <li class="text-capitalize"><?php echo $title['product_name']; ?> <span>$<?php echo $title['total_price']; ?></span></li>
                                <?php $total_price+= $title['price'] * $title['quantity'] ?>
                                <?php endforeach; ?>
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal <span>$<?php echo $total_price; ?></span></div>
                            <div class="checkout__order__total">Total <span>$<?php echo $total_price; ?></span></div>
                            <div class="checkout__input__checkbox">
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Check Payment
                                    <input type="checkbox" id="payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="checkbox" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <input name="grand_total" type="hidden" value="<?php echo $total_price; ?>">
                            <input type="submit" class="site-btn" value="Place order" name="order_form">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->
<?php require_once('includes/footer.php'); ?>
