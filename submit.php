<?php
session_start();
$id = $_SESSION['user']['id'];
require_once('config.php');
if(isset($_POST['product_id'])){
    $result = GetTableData4('cart',$id);
    foreach ($result as $key=> $row){        
        if($row['product_id'] == $_POST['product_id']){
            $result[$key]['quantity']=$_POST['quantity'];
            $total_price = $row['price'] * $_POST['quantity'];
            $stm = $connection->prepare("UPDATE cart SET quantity=?,total_price=? WHERE product_id=? AND user_id=?");
            $stm->execute(array($result[$key]['quantity'],$total_price,$row['product_id'],$id));
        }           
    }
}
if(isset($error)) :?>
    <div class="alert alert-danger">
        <?php  echo $error ?>
    </div>
<?php endif; ?>
<?php if(isset($success)) :?>
    <div class="alert alert-success">
        <?php  echo $success ?>
    </div>
<?php endif; ?>