<?php
session_start();
$id = $_SESSION['user']['id'];
require_once('../config.php');
if(isset($_POST['Mode_quantity'])){
    $result = GetTableData4('cart',$id);
    print_r($result);
    foreach ($result as $key=> $row){
        if($row['product_name'] == $_POST['product_name']){
           $result[$key]['quantity']=$_POST['Mode_quantity'];
           $stm = $connection->prepare("UPDATE cart SET quantity=? WHERE product_id=?");
           $stm->execute(array($result[$key]['quantity'],$row['product_id']));
           echo "<script>
           window.location.href='shoping-cart.php';
        </script>";
           
        }           
    }
}


?>