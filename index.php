<?php 
    include 'core/init.php';

    if(isset($_SESSION["user_data"])) {
        $user_object->redirect('/chatroom.php');
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // set values;
        $user_object->setUserEmail($_POST['user_email']);
        $user_object->setUserPassword($_POST['user_password']);
        // verify values And save;
        $user_data = $user_object->get_user_data_by_email();
        if($user_data != null) {
            if($user_data['user_status'] == 'Enable') {
                if(password_verify($user_object->getUserPassword(), $user_data['user_password'])){
                                       
                    if($user_object->update_user_login_data('Login', $user_data['user_id'])) {
                        session_regenerate_id();
                        
                        $_SESSION['user_data'] = [
                            'id'    =>  $user_data['user_id'],
                            'name'  =>  $user_data['user_name'],
                            'profile'   =>  $user_data['user_profile']
                        ];
                        $user_object->update_user_session_id(session_id());
                        $user_object->redirect('/chatroom.php');
                    }
                }else {
                    $error_message = 'Password address is wrong';
                }
            }else {
                $error_message = 'Please verify your email';
            }
        }else {
            $error_message = 'Email address is wrong';
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="vendor-front/bootstrap-5.3.0/bootstrap.css">
    <link rel="stylesheet" href="vendor-front/css/parsley.css">
    <link rel="stylesheet" href="vendor-front/css/style.css">
</head>

<body class="bg-primary">
<?php

    if(isset($_SESSION['success_message']) && $_SESSION['success_message'] != null) {
        echo auto_deleted_success_message($_SESSION['success_message']);
        // unset($_SESSION['success_message']);
    }                 
?>
    <div class="container py-5">
        <div class="row justify-content-center my-5">
            <div class="col-lg-5 col-md-7 col-sm-9 col-11">
                <form action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method="post" class="border rounded shadow py-3 px-3 bg-white" id="login_form">
                    <h2 class="text-center text-capitalize pt-2 pb-4 m-0">Create new account</h2>
                    
                    <label for="email" class="form-label mt-2">Email</label>
                    <input type="email" name="user_email" id="email" class="form-control" placeholder="Enter your email"
                    data-parsley-type="email" required />
                    
                    <label for="password" class="form-label mt-2">Password</label>
                    <input type="password" name="user_password" id="password" class="form-control" placeholder="Enter your password"
                    data-parsley-minlength="6" data-parsley-maxlenght="12" data-parsley-pattern="^[a-zA-Z0-9]+$" required />
                    
                    <input type="submit" value="Login" class="btn btn-primary d-block my-3 mx-auto">

                    <p class="my-0">You do not have account? <a href="<?php echo BASE_URL ?>/register.php" class="link-primary link-underline-opacity-25 link-underline-opacity-100-hover">Register now!</a></p>
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
            $("#login_form").parsley();
        });
    </script>
</body>
</html>