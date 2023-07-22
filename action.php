<?php 
include 'core/init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST["action"]) && !empty($_POST["action"])?$_POST["action"]:null;
    if($action != null) {
        switch ($action) {
            case "groupMessages"    : groupMessages(); break;
            case "createGroup"    : createGroup(); break;
            case "saveMessage"    : saveMessage(); break;
        }
    }else{
        $user_object->redirect('/index.php');
    }
}else{
    $user_object->redirect('/index.php');
}
function groupMessages() {
    global $user_object;
    $group_id = $_POST['group_id'];
    $messages = $user_object->get_group_messages($group_id);
    echo json_encode($messages);
}
function createGroup() {
    global $user_object;
    $group_name = $_POST['group_name'];
    $group_description = $_POST['group_description'];
    $group_members = $_POST['group_members'];
    $group_id = $user_object->create_group($group_name, $group_description, $group_members);    
    echo $group_id;    
}
function saveMessage() {
    global $user_object;
    $group_id = $_POST['group_id'];
    $user_id = $_POST['user_id'];
    $message = $_POST['message'];
    if($user_object->save_message($message, $user_id, $group_id)) {
        echo 'saved';
    }else {
        echo 'not-saved';
    }
}
?>