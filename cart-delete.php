<?php  
session_start();
require_once('config.php');

DeleteTableData2('cart',$_REQUEST['id']);
header('location:shoping-cart.php?success="Cart Delete Successfully!"');
?>