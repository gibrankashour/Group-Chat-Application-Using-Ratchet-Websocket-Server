<?php 
    include 'core/init.php';
    require 'core/classes/SendEmail.php';

    if(isset($_SESSION["user_data"])) {
        $user_object->redirect('/chatroom.php');
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // set values;
        $user_object->setUserName($_POST['user_name']);
        $user_object->setUserEmail($_POST['user_email']);
        $user_object->setUserPassword($_POST['user_password']);        
        $user_object->setUserStatus('Disabled');
        $user_object->setUserCreatedOn(date('Y-m-d H:i:s'));
        $user_object->setUserVerificationCode(md5(uniqid()));
        // verify values And save;
        $user_data = $user_object->get_user_data_by_email();
        if(is_array($user_data) && count($user_data) > 0) {
            $error_message = 'This Email Already Register';
        }else {
            // وضعت كود صورة البرفايل هنا حتى لا يتم تشكيل الصورة قبل التحقق من أن الأيميل غير مكرر
            $user_object->setUserProfile($user_object->make_avatar(strtoupper($_POST['user_name'][0])));
            if($user_object->save_data()) {
                $success_message = 'Registeration Completed';

                $subject = 'Registration Verification for Group Chat Application';
                $body = '
                        <p>Thank you for registering for Group Chat Application.</p>
                            <p>This is a verification email, please click the link to verify your email address.</p>
                            <p><a href="http://localhost/chat_application/verify.php?code='.$user_object->getUserVerificationCode().'">Click to Verify</a></p>
                            <p>Thank you...</p>
                        ';
                $mail = new SendEmail($_POST['user_email'], $_POST['user_name'], $subject, $body);
                if($mail->send()) {
                    $success_message = 'Verification Email sent to <strong>' . $user_object->getUserEmail() . '</strong>, so before login first verify your email';
                }else {
                    $error_message = 'Verification Email has not been sent, try again!';
                }
            }else {
                $error_message = 'Something went wrong try again';
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="vendor-front/bootstrap-5.3.0/bootstrap.css">
    <link rel="stylesheet" href="vendor-front/css/parsley.css">
    <link rel="stylesheet" href="vendor-front/css/style.css">
</head>
<body class="bg-success">
    <div class="container py-5">
        <div class="row justify-content-center my-5">
            <div class="col-lg-5 col-md-7 col-sm-9 col-11">
                <form action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method="post" class="border rounded shadow py-3 px-3 bg-white" id="register_form">
                    <h2 class="text-center text-capitalize pt-2 pb-4 m-0">Create new account</h2>
                    <label for="name" class="form-label ">Name</label>
                    <input type="text" name="user_name" id="name" class="form-control" placeholder="Enter your name"
                    data-parsley-pattern="/^[a-zA-Z\s]+$/" required />
                    
                    <label for="email" class="form-label mt-2">Email</label>
                    <input type="email" name="user_email" id="email" class="form-control" placeholder="Enter your email"
                    data-parsley-type="email" required />
                    
                    <label for="password" class="form-label mt-2">Password</label>
                    <input type="password" name="user_password" id="password" class="form-control" placeholder="Enter your password"
                    data-parsley-minlength="6" data-parsley-maxlenght="12" data-parsley-pattern="^[a-zA-Z0-9]+$" required />
                    
                    <input type="submit" value="Register" class="btn btn-success d-block my-3 mx-auto">

                    <p class="my-0">You already have account? <a href="<?php echo BASE_URL ?>/index.php" class="link-primary link-underline-opacity-25 link-underline-opacity-100-hover">Login now!</a></p>
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
            $("#register_form").parsley();
        });
    </script>
</body>
</html>