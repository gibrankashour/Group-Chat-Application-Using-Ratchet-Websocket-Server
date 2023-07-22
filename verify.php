<?php 
    include 'core/init.php';
    if(isset($_SESSION["user_data"])) {
        $user_object->redirect('/chatroom.php');
    }
    $code = isset($_GET['code']) && $_GET['code'] != null ? $_GET['code'] : null;
    if($code == null) {
        $user_object->redirect('/register.php');
    }
    
    if($user_object->is_valid_email_verification_code($code)) {
        
        if($user_object->enable_user_account($code, 'Enable')) {
            $success_message = 'Your Email Successfully verify, now you can <a href="'.BASE_URL.'/index.php" class="alert-link">login</a>  into this chat Application';
        }else {
            $error_message = 'Something went wrong try again';
        }
    }else {
        $error_message = 'Something went wrong try again';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify</title>
    <link rel="stylesheet" href="vendor-front/bootstrap-5.3.0/bootstrap.css">
    <link rel="stylesheet" href="vendor-front/css/parsley.css">
</head>
<body class="bg-secondary">
    <div class="container py-5">
        <div class="row justify-content-center my-5">
            <div class="col-lg-5 col-md-7 col-sm-9 col-11">
                <div class="border rounded shadow py-3 px-3 bg-white">
                    <?php
                        if($success_message != null) {
                            echo success_message_without_close_btn($success_message);
                        }
                        if($error_message != null) {
                            echo error_message_without_close_btn($error_message);
                        }                    
                    ?>
                </div>
            </div>
        </div>        
    </div>
    <script src="vendor-front/js/jquery-3.7.0.min.js"></script>
    <script src="vendor-front/js/parsley.js"></script>
    <script src="vendor-front/bootstrap-5.3.0/bootstrap.bundle.js"></script>
</body>
</html>