<?php

require_once('../../../private/initialize.php');

if(!isset($_GET['person_id'])) {
  redirect_to(url_for('admin/dashboard.php'));
}
$person_id = $_GET['person_id'];

$result = delete_person($person_id);
redirect_to(url_for('admin/dashboard.php'));
?>