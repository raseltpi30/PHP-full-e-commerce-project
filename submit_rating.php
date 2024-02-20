<?php  
session_start();
require_once('config.php');
$user_id = $_SESSION['user']['id'];
$product_id = $_SESSION['request']; //come form product 
if(isset($_POST['rating_data'])){
    date_default_timezone_set("ASIA/DHAKA");
    $time = date("Y-m-d h:i:sa");
    $data = array(
        ':user_rating' => '$_POST["rating_data"]',
        ':user_review' => '$_POST["user_review"]',
    );
    $stm = $connection->prepare("SELECT user_id FROM rating WHERE product_id=? AND user_id=?");
    $stm->execute(array($product_id,$user_id));
    $re = $stm->rowCount();

    if($re != 0){
        echo "You have already review this product!";
    }else{
        $stm = $connection->prepare("INSERT INTO rating(user_id,product_id,user_rating,user_review,datetime) VALUES(?,?,?,?,?)");
        $stm->execute(array($user_id,$product_id,$_POST["rating_data"],$_POST["user_review"],$time));
        echo "Thanks For Your Review!";
    }
}
if(isset($_POST['action'])){
    $average_rating = 0;
    $total_review = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;
    $total_user_rating = 0;

    $stm=$connection->prepare("SELECT * FROM rating WHERE product_id=?");
    $stm->execute(array($product_id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    foreach($result as $row){
        if($row['user_rating'] == 5){
            $five_star_review++;
        }
        if($row['user_rating'] == 4){
            $four_star_review++;
        }
        if($row['user_rating'] == 3){
            $three_star_review++;
        }
        if($row['user_rating'] == 2){
            $two_star_review++;
        }
        if($row['user_rating'] == 1){
            $one_star_review++;
        }
        $total_review++;

        $total_user_rating = $total_user_rating + $row['user_rating'];
    }
    $average_rating = $total_user_rating / $total_review;
    $output = array(
        'average_rating' => number_format($average_rating,1),
        'total_review' => $total_review,
        'five_star_review' => $five_star_review,
        'four_star_review' => $four_star_review,
        'three_star_review' => $three_star_review,
        'two_star_review' => $two_star_review,
        'one_star_review' => $one_star_review,
    );
    echo json_encode($output);
}

?>