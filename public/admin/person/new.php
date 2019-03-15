<?php

require_once( '../../../private/initialize.php' );
require_admin_login();

if ( is_post_request() ) {

	// Handle form values sent by new.php
	$person = [];
	$person[ 'first_name' ] = $_POST[ 'first_name' ] ?? '';
	$person[ 'last_name' ] = $_POST[ 'last_name' ] ?? '';
	$person[ 'email' ] = $_POST[ 'email' ] ?? '';
	$person[ 'password' ] = $_POST[ 'password' ] ?? '';
	$person[ 'is_admin' ] = (int) $_POST['is_admin'] ?? '';
	$person[ 'is_premium' ] = (int) $_POST['is_premium'] ?? '';
	$person[ 'created_on' ] = date( "Y-m-d H:i:s");
	$person[ 'updated_on' ] = date( "Y-m-d H:i:s");
	$person[ 'birth_date'] = date("Y-m-d", strtotime($_POST['birth_date'])) ?? '';
	$person[ 'profile_pic' ] = '';
	$person['biography'] = $_POST['biography'] ?? '';

	$result = insert_person( $person );
	if ( $result === true ) {
		$new_id = mysqli_insert_id( $db );
		redirect_to( url_for( 'admin/dashboard.php' ) );
	} else {
		$errors = $result;
	}

} else {

	$person = [];
	$person[ 'first_name' ] = '';
	$person[ 'last_name' ] = '';
	$person[ 'email' ] = '';
	$person[ 'password' ] = '';
	$person[ 'is_admin' ] = '';
	$person[ 'is_premium' ] = '';
	$person[ 'created_on' ] = '';
	$person[ 'updated_on' ] = '';
	$person[ 'profile_pic' ] = '';
	$person[ 'birth_date' ] = '';
	$person['biography'] = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- These meta tags come first. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>New Person | MeetMe</title>

	<!-- Include the CSS -->
	<link href="../../css/toolkit.min.css" rel="stylesheet">
		<link href="../../css/styles.css" rel="stylesheet" type="text/css">

</head>

<body>
<div class="container">
	<?php require_once('../../../private/shared/nav_admin.php'); ?>
	<h1>Create Person</h1>
	<form action="new.php" method="post" class="form-horizontal my-5">
		<div class="form-group">
			<label for="first_name" class="col-sm-2 control-label">First Name</label>
			<div class="col-sm-10"><input name="first_name" type="text" id="first_name" value="<?php echo h($person['first_name']); ?>" class="form-control"></div>
			<div class="col-sm-10"><p class="help-block"><?php if(isset($errors['first_name'])){ display_error($errors['first_name']); } ?></p></div>
		</div>
		<div class="form-group">
			<label for="last_name" class="col-sm-2 control-label">Last Name</label>
			<div class="col-sm-10"><input name="last_name" type="text" id="last_name" value="<?php echo h($person['last_name']); ?>" class="form-control"></div>
			<div class="col-sm-10"><p class="help-block"><?php if(isset($errors['last_name'])){ display_error($errors['last_name']); } ?></p></div>
		</div>
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10"><input name="email" type="text" id="email" value="<?php echo h($person['email']); ?>" class="form-control"></div>
			<div class="col-sm-10"><p class="help-block"><?php if(isset($errors['email'])){ display_error($errors['email']); } ?></p></div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10"><input name="password" type="password" id="password" value="<?php echo h($person['password']); ?>" class="form-control"></div>
			<div class="col-sm-10"><p class="help-block"><?php if(isset($errors['password'])){ display_error($errors['password']); } ?></p></div>
		</div>

		<div class="form-group">
			<label for="birth_date" class="col-sm-2 control-label">Birth Date</label>
			<div class="col-sm-10"><input name="birth_date" id="birth_date" type="date" class="form-control"></div>
			<div class="col-sm-10"><p class="help-block"><?php if(isset($errors['birth_date'])){ display_error($errors['birth_date']); } ?></p></div>
		</div>
		<div class="form-group">
			<label for="biography" class="col-sm-2 control-label">Biography</label>
			<div class="col-sm-10"><textarea name="biography" id="biography" class="form-control"><?php echo h($person['biography']); ?></textarea></div>
		</div>
		<div class="form-group">
			<div class="checkbox my-5 col-sm-10">
				<input type="hidden" name="is_premium" value="0" >
				<input name="is_premium" id="is_premium" type="checkbox" value="1" <?php if($person['is_premium'] == "1") { echo " checked"; } ?>> Is Premium 
				<input type="hidden" name="is_admin" value="0" />
				<input type="checkbox" value="1" name="is_admin" id="is_admin" <?php if($person['is_admin'] == "1") { echo " checked"; } ?>> Is Admin
			</div>
		</div>
		<div class="col-sm-10"><input type="submit" value="Create" class="btn btn-lg btn-success"> <input type="button" value="Cancel" class="btn btn-lg btn-danger" onclick="location.href='../dashboard.php';"></div>

	</form>
</div>
	<!-- Include jQuery (required) and the JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	 <script src="../../js/jquery.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/chart.js"></script>
    <script src="../../js/toolkit.js"></script>
    <script src="../../js/application.js"></script>

</body>

</html>