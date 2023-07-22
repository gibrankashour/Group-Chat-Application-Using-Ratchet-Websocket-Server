<?php 

// success functions

function auto_deleted_success_message($message) {
    unset($_SESSION['success_message']);
    return '<div class="fixed-alert my-2 alert alert-success alert-dismissible fade show" role="alert">
                '.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';   
}

function success_message($message) {
    return '<div class="my-2 alert alert-success alert-dismissible fade show" role="alert">
                '.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}
function success_message_without_close_btn($message) {
    return '<div class="my-2 alert alert-success alert-dismissible fade show" role="alert">
                '.$message.'
            </div>';
}

// error functions

function error_message($message) {
    return '<div class="my-2 alert alert-danger alert-dismissible fade show" role="alert">
                '.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}
function error_message_without_close_btn($message) {
    return '<div class="my-2 alert alert-danger alert-dismissible fade show" role="alert">
                '.$message.'
            </div>';
}
?>