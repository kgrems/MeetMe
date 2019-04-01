<?php

function log_in_admin($admin){
    session_regenerate_id();
    $_SESSION['person_id'] = $admin['person_id'];
    $_SESSION['first_name'] = $admin['first_name'];
    $_SESSION['last_name'] = $admin['last_name'];
    $_SESSION['last_login'] = time();
    $_SESSION['email'] = $admin['email'];
    $_SESSION['profile_pic'] = $admin['profile_pic'];
    $_SESSION['is_admin'] = $admin['is_admin'];
    return true;
}

function log_in_person($person){
    session_regenerate_id();
    $_SESSION['person_id'] = $person['person_id'];
    $_SESSION['first_name'] = $person['first_name'];
    $_SESSION['last_name'] = $person['last_name'];
    $_SESSION['profile_pic'] = $person['profile_pic'];
    $_SESSION['last_login'] = time();
    $_SESSION['email'] = $person['email'];
    //in case an admin was logged in, doesn't log out, and then
    //  a regular user logs in "on top of" the admin.  Prevents non-admins
    //  from getting into admin pages.
    unset($_SESSION['is_admin']);
    return true;
}

function is_logged_in(){
    return isset($_SESSION['person_id']);
}

function is_admin_logged_in(){
    return (isset($_SESSION['person_id']) && isset($_SESSION['is_admin']));
}

function require_login(){
    if(!is_logged_in()){
        redirect_to(url_for('/index.php'));
    }else{

    }
}

function require_admin_login(){
    if(!is_admin_logged_in()){
        redirect_to(url_for('/admin/index.php'));
    }else{

    }
}
?>