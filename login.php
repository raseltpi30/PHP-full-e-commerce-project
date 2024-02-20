<?php
require_once('includes/header.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $error = "Enter Your UserName!";
    } elseif (empty($password)) {
        $error = "Enter Your password!";
    } else {
        $password = SHA1($password);

        $stm = $connection->prepare("SELECT * FROM ogani WHERE username=? AND password=?");
        $stm->execute(array($username,$password));
        $cheekuser = $stm->rowCount();
        if ($cheekuser == 1) {
            $userData = $stm->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user'] = $userData;
            unset($_POST);
            ?>
                <script>
                    setTimeout(function(){
                        window.location.href="index.php";
                    });
                </script>
            <?php
        }
        else{
            $error = "Username Or Password is Wrong!";
        }
    }
} 
if (isset($_SESSION['user'])) {
    ?>
        <script>
            setTimeout(function(){
                window.location.href="index.php";
            },2000);
        </script>
    <?php
}
?>

<div class="login-area pb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 mt-5">
                <div class="card card-body shadow">
                    <h3>Login Here</h3>
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

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">User Name</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Enter Your User Name" value="<?php value('username'); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password" value="<?php value('password'); ?>">
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="login" class="btn btn-success" value="Login">
                        </div>
                        Don't have an account?  <a href="registration.php" style="color:blue;padding:10px">Registration Now</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("includes/footer.php"); ?>
 