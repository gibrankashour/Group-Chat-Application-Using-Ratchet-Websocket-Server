<?php 
    include 'core/init.php';
    if($user_object->is_logged_in()) {
        $user_object->logout();
    }else {
        $user_object->redirect('/index.php');
    }
?>