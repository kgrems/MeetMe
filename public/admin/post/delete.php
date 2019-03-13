<?php

require_once('../../../private/initialize.php');

if(!isset($_GET['post_id'])) {
  redirect_to(url_for('admin/dashboard.php'));
}
$post_id = $_GET['post_id'];

$result = delete_post($post_id);
redirect_to(url_for('admin/dashboard.php'));
?>