<?php
function log_in_admin($admin){
    session_regenerate_id();
    $_SESSION['person_id'] = $admin['person_id'];
    $_SESSION['first_name'] = $admin['first_name'];
    $_SESSION['last_name'] = $admin['last_name'];
    $_SESSION['last_login'] = time();
    $_SESSION['email'] = $admin['email'];
    return true;
}

function log_in_person($person){
    session_regenerate_id();
    $_SESSION['person_id'] = $person['person_id'];
    $_SESSION['first_name'] = $person['first_name'];
    $_SESSION['last_name'] = $person['last_name'];
    $_SESSION['last_login'] = time();
    $_SESSION['email'] = $person['email'];
    return true;
}
?>