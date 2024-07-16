<?php
require_once('includes/header.php'); 
$id = $_SESSION['user']['id'];
$result = GetTableData4('cart',$id);
if(!isset($_SESSION['user'])){
    ?>
    <script>
        setTimeout(function(){
            window.location.href="login.php";
        });
    </script>
    <?php
}
// if(isset($_POST['Mode_quantity'])){
//     foreach ($result as $key=> $row){
//         if($row['product_name'] == $_POST['product_name']){
//             $data_quantity = getProductName('quantity',$row['product_id']);  
//             if($data_quantity < $_POST['Mode_quantity']){
//                 $error = $row['product_name']." Out Of Stock";
//             }
//             else{
//                 $data_price = $row['price'];
//                 $total_price = $data_price * $_POST['Mode_quantity'];
//                 $result[$key]['quantity']=$_POST['Mode_quantity'];
//                 $stm = $connection->prepare("UPDATE cart SET quantity=?,total_price=? WHERE product_id=?");
//                 $stm->execute(array($result[$key]['quantity'],$total_price,$row['product_id'])); 
//             }          
//         }           
//     }
// }
if(isset($_POST['order_product'])){
    $success = "Success";   
    echo "<script>
        window.location.href='checkout.php';
    </script>";               
}
?>
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Shopping Cart</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="success text-center">
<?php if(isset($_REQUEST['success'])):?>
        <div class="alert alert-success">
            <?php echo $_REQUEST['success'];  ?>
        </div> 
    <?php endif; ?>
</div>
<!-- Breadcrumb Section End -->
<!-- Shoping Cart Section Begin -->
<?php
$cartCount = cartCount('cart');
if($cartCount != 0) : ?>
<section class="shoping-cart spad">
    <div class="container">
            <?php if(isset($error)) :?>
                <div class="alert alert-danger">
                    <?php  echo $error ?>
                </div>
            <?php endif; ?>
            <?php if(isset($success)) :?>
                <div class="alert alert-success">
                    <?php  echo $success ?>
                </div>
            <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">     
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $gt = 0;
                            $total_quantity = 0;
                            $result = GetTableData4('cart',$id);
                            foreach ($result as $row) :
                            ?>
                            <tr class="cartpage">        
                                <td class="shoping__cart__item">
                                    <img style="width: 100px;height:100px" src="../our_store/uploads/products/<?php echo GetNameByid('products', 'photo', $row['product_id'])  ?>" alt="">
                                    <h5><?php echo $row['product_name']; ?></h5> <input type="hidden" class="product_id" name="product_id" value="<?php echo $row['product_id'] ?>">
                                </td>

                                <td class="shoping__cart__price">
                                    <span>$<?php echo $row['price']; ?></span>                                   
                                    <input class="iprice" style="width:50%;border: none; text-align:center" type="hidden" value="<?php echo $row['price']; ?>" readonly>
                                </td>
                                <td class="shoping__cart__quantity">
                                    <div class="quantity">
                                        <input type="hidden" name="" class="product_id" value="<?php echo $row['product_id'] ?>">
                                        <div class="input-group">
                                            <div class="decrement-btn changeQuantity" style="cursor: pointer">
                                                <span class="input-group-text">-</span>
                                            </div>
                                                <input type="text" class="qty-input form-control" maxlength="2" max="10" value="<?php echo $row['quantity'] ?>">
                                            <div class="increment-btn changeQuantity" id="increment" style="cursor: pointer">
                                                <span class="input-group-text">+</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <!-- <td class="itotal"></td> -->
                                <td class="shoping__cart__total">
                                    <div class="item-total d-flex justify-content-center">
                                        <div class="dollar">$</div>
                                        <div class="a"><?php echo $row['price'] * $row['quantity']; ?></div>
                                    </div>
                                </td> 
                                <!-- <td class="shoping__cart__total"></td> -->
                                <td class="shoping__cart__item__close">
                                    <a onclick="return confirm('Are you Sure?');" class="btn btn-sm" href="cart-delete.php?id=<?php echo $row['id']  ?>"><span  style="color:#000" class="icon_close"></span></a>
                                </td>
                                <td><?php 
                                    $gt += $row['total_price'];
                                    $total_quantity += $row['quantity'];
                                ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Discount Codes</h5>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">APPLY COUPON</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul class="d-flex justify-content-between">
                        <div class="cart-total d-felx">
                        <li>Total( <?php 
                        echo $total_quantity." "."Items";
                        ?> )</li>
                        </div>
                        <div class="total d-flex justify-content-end align-items-start text-bold">
                            <div style="font-weight:700;color:#dd2222;" class="dollar">$</div>
                            <span style="font-weight:700;color:#dd2222;" id="gtotal"><?php echo $gt; ?></span>
                        </div>
                    </ul>
                    <form action="" method="POST">                           
                        <input type="hidden" id="product_name"   name="product_name" value="<?php echo $row['product_name'] ?>">
                        
                        <input type="hidden" id="total_price" name="total_price" value="<?php echo $row['total_price'] ?>">

                        <input style="border:none" name="order_product" type="submit" class="primary-btn" value="PROCEED TO CHECKOUT">                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php else: ?>
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <div class="shoping__cart__table">
                <div class="alert-alert-danger text-center p-5">
                    <h1>Cart is Empty</h1>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- Shoping Cart Section End -->

<?php require_once('includes/footer.php'); ?>