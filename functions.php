<?php   

// if already one data exist
function InputCount($col,$tbl,$value){
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM $tbl WHERE $col=?");
    $stm->execute(array($value));
    $count=$stm->rowCount();

    return  $count;
}

function proCount($tbl){
    global $connection;
    $stm = $connection->prepare("SELECT id FROM $tbl");
	$stm->execute(array());
    $count = $stm->rowCount();

    return  $count;
}
function cartCount($tbl){
    global $connection;
    $stm = $connection->prepare("SELECT product_id FROM $tbl WHERE user_id=?");
	$stm->execute(array($_SESSION['user']['id']));
    $count = $stm->rowCount();

    return  $count;
}

function getProfile($id){
    global $connection;
    $stm = $connection->prepare("SELECT * FROM users WHERE id=?");
    $stm->execute(array($id));
    $result=$stm->fetch(PDO::FETCH_ASSOC);

    return  $result;
}

// Get Column Count
function GetColumnCount($tbl,$col,$value){
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM $tbl WHERE $col=?");
    $stm->execute(array($value));
    $count=$stm->rowCount(); 
    return  $count;
}
function GetTableData($tbl){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM $tbl WHERE user_id=?");
    $stm->execute(array($_SESSION['admin']['id']));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function GetTableData2($tbl){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM $tbl");
    $stm->execute(array());
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function GetTableData3($tbl){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM $tbl WHERE user_id=?");
    $stm->execute(array($_SESSION['admin']['id']));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function GetTableData4($tbl){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM $tbl WHERE user_id=?");
    $stm->execute(array($_SESSION['user']['id']));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
// Get Single Table Data
function GetSingleData($tbl,$id){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM $tbl WHERE user_id=? AND id=?");
    $stm->execute(array($_SESSION['admin']['id'],$id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
} 
// Get Single Table2 Data
function GetSingleData2($tbl,$id){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM $tbl WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
} 
function GetSingleData3($order_id){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM customer_details WHERE order_id=?");
    $stm->execute(array($order_id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
} 


// Delete Table Data
function DeleteTableData($tbl,$id){
    global $connection;
    $stm=$connection->prepare("DELETE FROM $tbl WHERE user_id=? AND id=?");
    $delete = $stm->execute(array($_SESSION['admin']['id'],$id));
    return $delete;
}
function DeleteTableData2($tbl,$id){
    global $connection;
    $stm=$connection->prepare("DELETE FROM $tbl WHERE user_id=? AND id=?");
    $delete = $stm->execute(array($_SESSION['user']['id'],$id));
    return $delete;
}
function DeleteTableData3($tbl){
    global $connection;
    $stm=$connection->prepare("DELETE FROM $tbl WHERE user_id=?");
    $delete = $stm->execute(array($_SESSION['user']['id']));
    return $delete;
}
function DeleteTableData4($tbl){
    global $connection;
    $stm=$connection->prepare("DELETE FROM $tbl");
    $delete = $stm->execute(array());
    return $delete;
}
function DeleteTableData5($tbl,$order_id){
    global $connection;
    $stm=$connection->prepare("DELETE FROM $tbl WHERE order_id=?");
    $delete = $stm->execute(array($order_id));
    return $delete;
}

function getProductCategoryName($col,$id){
    global $connection;
    $stm=$connection->prepare("SELECT $col FROM categories WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result[$col];
}
function getProductName($col,$id){
    global $connection;
    $stm=$connection->prepare("SELECT $col FROM products WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result[$col];
}
function getPurchaseName($col,$id){
    global $connection;
    $stm=$connection->prepare("SELECT $col FROM products WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result[$col];
}
function getManufactureName($col,$id){
    global $connection;
    $stm=$connection->prepare("SELECT $col FROM manufactures WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result[$col];
}
function existCount($col,$id){
    global $connection;
    $stm=$connection->prepare("SELECT $col FROM categories WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result[$col];
}

function GetNameByid($tbl, $col, $id){
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM $tbl WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result[$col];
}
function GetNameByid2($tbl, $col, $id){
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM $tbl WHERE order_id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result[$col];
}
function GetNameByid3($tbl, $col, $id){
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM $tbl WHERE product_id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result[$col];
}
function requestCount($id){
    global $connection;
    $stm = $connection->prepare("SELECT id FROM products where id=?");
    $stm->execute(array($id));
    $result = $stm->rowCount(); 
}
// for registration
function value($name){
    if(isset($_POST[$name])){
    echo $_POST[$name];
    }
}
function get_header(){
    require_once('includes/header.php');
}
function get_header2(){
    require_once('ogani/includes/header.php');
}
function get_footer(){
    require_once('includes/footer.php');
}
 