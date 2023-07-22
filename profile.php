<?php 
    include 'core/init.php';

    if(!isset($_SESSION["user_data"])) {
        $user_object->redirect('/index.php');
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user['name'] = $_POST['user_name']; 
        $user['password'] = $_POST['user_password']; 
        $user['photo'] = $_FILES['photo'];
        if($user_object->update_login_user_info($user)){
            $success_message = 'Your information Updated successfully';
        }else{
            $error_message = 'Something went wrong try again';
        } 
    }
    $user_data = $user_object->get_login_user_info();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="vendor-front/bootstrap-5.3.0/bootstrap.css">
    <link rel="stylesheet" href="vendor-front/css/parsley.css">
    <link rel="stylesheet" href="vendor-front/css/style.css">
</head>

<body class="bg-info">

    <div class="container py-5">
        <div class="row justify-content-center my-5">
            <div class="col-lg-5 col-md-7 col-sm-9 col-11">
                <form action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method="post" class="border rounded shadow py-3 px-3 bg-white" id="profile_form" enctype="multipart/form-data">
                    <h2 class="text-center text-capitalize pt-2 pb-4 m-0">Update your information</h2>
                    <div id="image-profile" class="mb-2">
                        <img class="mx-auto d-block " src="<?php echo BASE_URL ."/" . $user_data["user_profile"]?>" alt="">
                    </div>
                    <label for="name" class="form-label ">Name</label>
                    <input type="text" name="user_name" id="name" class="form-control" placeholder="Enter your name"
                    data-parsley-pattern="/^[a-zA-Z\s]+$/" required value="<?php echo $user_data["user_name"] ?>"/>

                    <label for="email" class="form-label mt-2">Email</label>
                    <input type="email" name="user_email" id="email" class="form-control" placeholder="Enter your email"
                    data-parsley-type="email" disabled  value="<?php echo $user_data["user_email"] ?>"/>
                    
                    <label for="password" class="form-label mt-2">Password</label>
                    <input type="password" name="user_password" id="password" class="form-control" placeholder="Enter your password"
                    data-parsley-minlength="6" data-parsley-maxlenght="12" data-parsley-pattern="^[a-zA-Z0-9]+$"  />
                    
                    <label for="" class="form-label mt-2">Your image</label>
                    <div class="input-group mb-3">                        
                        <input type="file" class="form-control" id="inputGroupFile01" name="photo">
                    </div>

                    <input type="submit" value="Update Information" class="btn btn-info d-block my-3 mx-auto">

                    <p class="my-0">Go back to <a href="<?php echo BASE_URL ?>/chatroom.php" class="link-primary link-underline-opacity-25 link-underline-opacity-100-hover">Chatroom page</a></p>
                    <div class="">
                    <?php
                        if($success_message != null) {
                            echo success_message($success_message);
                        }
                        if($error_message != null) {
                            echo error_message($error_message);
                        }                    
                    ?>
                    </div>
                </form>
            </div>
        </div>        
    </div>
    <script src="vendor-front/js/jquery-3.7.0.min.js"></script>
    <script src="vendor-front/js/parsley.js"></script>
    <script src="vendor-front/bootstrap-5.3.0/bootstrap.bundle.js"></script>

    <script>
        $(document).ready(function(){
            $("#profile_form").parsley();
        });
    </script>
</body>
</html>