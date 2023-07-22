<?php
    session_start();

    // Constants
    define('BASE_URL', 'http://localhost/chat_application');
    define('IMAGES', 'http://localhost/chat_application/images');

    // classes
    require 'classes/Database_connection.php';
    require 'classes/ChatUser.php';
    // other files
    include 'functions.php';

    
    // variables
    $error_message = '';
    $success_message = '';

    $user_object = new ChatUser;
    // var_dump($user_object->connect);
?>