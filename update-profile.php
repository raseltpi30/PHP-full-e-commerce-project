<?php 
require_once('includes/header.php');
$id = $_SESSION['user']['id'];
$profile = GetSingleData2('ogani',$id);
if(isset($_POST['registration_form'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $photo = $_FILES['photo'];

    // if already used items 
    $mobileCount = InputCount('mobile','ogani',$mobile);
    $usernameCount = InputCount('username','ogani',$username);
    $emailCount = InputCount('email','ogani',$email);
    $pattern1 = "/^[a-z-0-9]+$/";

    // photo add 
    $target_directory = "uploads/user_profile/";
    $target = $target_directory. basename($_FILES["photo"]["name"]);
    $extension = strtolower(pathinfo($target,PATHINFO_EXTENSION));

    if(empty($name)){
        $error = "Name is Required!";
    }
    elseif(empty($username)){
        $error = "Username is Required!";
    }
    elseif(!preg_match($pattern1,$username)){
        $error = "Username doesn't support any Special or White Space or Uppsercase Characters!";
    }
    elseif($usernameCount != 0){
        $error = "Username Already Used!";
    }
    elseif(empty($email)){
        $error = "Email is Required!";
    }
    elseif($emailCount != 0){
        $error = "Email Already Used!";
    }
    elseif(empty($mobile)){
        $error = "Mobile Number is Required!";
    }
    elseif($mobileCount !=0){
        $error = "Mobile ALready used!";
    }
    elseif(empty($password)){
        $error = "Password is Required!";
    }
    elseif(strlen($password) < 6 OR strlen($password) > 15){
        $error = "Password Must be 6 to 15 digits!";
    }
    elseif($password != $confirm_password){
        $error = "Password & Confirm Password Doesn't Match!";
    }
    elseif(empty($photo['name'])){
        $error = "Photo is Required!";
    }
    elseif($extension != 'jpg' AND $extension !='png'){
        $error = "Photo must be jpg or png format!";
    }
    else{
        $created_at = date('Y-m-d H:i:s');
        $password = SHA1($password);
        $new_name = "photo-".rand(1111,9999).rand(1111,9999).".".$extension;
        move_uploaded_file($_FILES['photo']['tmp_name'],$target_directory.$new_name);

        $stm = $connection->prepare("INSERT INTO ogani(name,username,email,mobile,password,photo,created_at) VALUES(?,?,?,?,?,?,?)");
        $stm->execute(array($name,$username,$email,$mobile,$password,$new_name,$created_at));

        $success = "Registration Successfully!";
        unset($_POST);
    }
    
}
?>
<div class="container">
    <div class="login-area py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 mt-2">
                    <div class="card card-body shadow">
                        <h3>Update Profile</h3>
                        <hr>
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
                        <hr>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name :</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name" value="<?php value('name');?>">
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">User Name :</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Enter Your Username" value="<?php value('username');?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Enter Your Email" value="<?php value('email');?>">
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile :</label>
                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Your Mobile" value="<?php value('mobile');?>">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password :</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password" value="<?php value('password');?>">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Password :</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" value="<?php value('password');?>">
                            </div>
                            <div class="mb-3">
                                <label for="photo">Choose a file *</label>
                                <input type="file" name="photo" id="" class="form-control" id="photo">
                            </div>
                            <div class="mb-3">
                                <input type="submit" name="registration_form" class="btn btn-primary w-100" value="Registration">
                            </div>
                            Already have an account?  <a href="login.php" style="color:blue;padding:10px">Login Now</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
require_once('includes/footer.php');
?>