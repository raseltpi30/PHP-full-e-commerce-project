<?php 
session_start();
$id=$_SESSION['user'];
print_r($id);
// print_r($_SESSION['cart']);
// $hostname = "localhost";
// $database = "testing";
// $username = "root";
// $password = "";

// try{
//     $con = new PDO("mysql:host=$hostname;dbname=$database",$username,$password);
//     // set the PDO error mode to exception
//     $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
// }
// catch(PDOException $e){
//     echo "Connection failed: " . $e->getMessage();
// }
$con=mysqli_connect("localhost","root","","user_store");
if(mysqli_connect_error()){
    echo "<script>
            alert('Item ff Removed');
            window.location.href='mycart.php';
        </script>";
    exit();
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

    $password = $_POST['password'];
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
    else{
        echo "done";
        $query1 = "INSERT INTO `customer_details`(`name`, `lastname`, `country`, `address`, `town`, `postcode`, `mobile`, `email`) VALUES ('$name','$lastName','$country','$address','$town','$postcode','$mobile','$email')";
        if(mysqli_query($con,$query1)){
            
            $Order_ID=mysqli_insert_id($con);
            foreach($_SESSION['cart'] as $key => $values){
                $Item_Name = $values['product_name'];
                $Price = $values['price'];
                $Quantity = $values['quantity'];
                $Total_price = $values['total_price'];

                $query2= "INSERT INTO `order_to`(`order_id`, `product_name`, `price`, `quantity`, `total_price`) VALUES ('$Order_ID','$Item_Name','$Price','$Quantity','$Total_price')";
                $stmt = mysqli_query($con,$query2);
                unset($_SESSION['cart']);
            }
        }
        else{
            echo "<script>
            alert('Data Inset Failed');
            window.location.href='mycart.php';
        </script>"; 
        }
    }
}

?>

<?php if(isset($error)){
    echo "
    <script>
    window.location.href='checkout.php';
    </script>";
} ?>