<?php

function is_valid_user($username, $password) {
    if ($username === '3540' && $password === 'secret') {
        return true;
    }
    return false;
}

if (empty($_POST['page'])) {
    $display_modal_window = 'none';
    include('view_startpage.php');
    exit();
}else if ($_POST['page'] === 'StartPage') {

    if ($_POST['command'] === 'SignIn') {

        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!is_valid_user($username, $password)) {

            // Invalid login
            $error_msg_username = '* Wrong username or ';
            $error_msg_password = '* Wrong password';
            $display_modal_window = 'signin';

            include('view_startpage.php');
            exit();
        }
        else {
            // Valid login
            include('view_mainpage.php');
            exit();
        }
    }
}else if ($_POST['page'] === 'MainPage') {

    if ($_POST['command'] === 'SignOut') {

        $display_modal_window = 'none';
        include('view_startpage.php');
        exit();
    }
}
?>