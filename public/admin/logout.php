<?php
require_once('../../private/initialize.php');
unset($_SESSION['email']);
unset($_SESSION['person_id']);
unset($_SESSION['first_name']);
unset($_SESSION['last_name']);
unset($_SESSION['last_login']);
unset($_SESSION['is_admin']);
redirect_to(url_for('admin/index.php'));
?>