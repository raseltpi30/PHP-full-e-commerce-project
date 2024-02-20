<?php 
require_once('includes/header.php');
$id = $_SESSION['user']['id'];
$profile = GetSingleData2('ogani',$id);
?>
<div class="container-fluid">
    <div class="row p-5">
        <div class="col-lg-5 col-xl-5 m-auto">
            <div class="card">
                <div class="card-body p-5 shadow">
                    <div class="media align-items-center mb-4 profile">

                    <img class="mr-3" src="uploads/user_profile/<?php echo $profile['photo']; ?>" width="80" height="80" alt="">


                    <div class="media-body">
                        <h3 class="mb-0"><?php echo $profile['name']; ?></h3>
                        <p class="text-muted mb-0"><?php echo $profile['username']; ?></p>
                    </div>
                    </div>
                    <h4>About</h4>
                    <ul class="card-profile__info">
                        <strong class="text-dark mr-4">Mobile :</strong><span><?php echo $profile['mobile']; ?></span>
                        <br>
                        <strong class="text-dark mr-4">Email :</strong><span><?php echo $profile['email']; ?></span>
                    </ul>
                    <div class="col-12 mt-4">
                        <a href="update-profile.php?id=<?php echo $id; ?>" class="btn btn-danger px-5">Update Profile</a>
                    </div>
                </div>
            </div>  
        </div>
        
    </div>
</div>
<?php require_once('includes/footer.php'); ?>