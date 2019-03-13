<?php
require_once('../../private/initialize.php');

$errors = [];
$email = '';
$password = '';

if(is_post_request()){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if(is_blank($email)){
        $errors['email'] = "Email cannot be blank.";
    }
    if(is_blank($password)){
        $errors['password'] = "Password cannot be blank.";
    }

    if(empty($errors)){
        $admin = find_admin_by_email($email);
        if($admin){
            if(password_verify($password, $admin['password'])){
                //person email found and password match
                log_in_admin($admin);

                redirect_to(url_for('admin/dashboard.php'));
            }else{
                //person email found, but password no match
                $errors['login'] = "Log in was unsuccessful.";
            }
        }else{
            //no person email address found
            $errors['login'] = "Log in was unsuccessful.";
        }
    }
}
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Admin Log In | MeetMe</title>
		<link href="../css/toolkit.min.css" rel="stylesheet">
</head>

<body>
<div class="container">
	<h1>Admin Log In</h1>
    <form action="index.php" method="post" class="form-horizontal my-5">
        <div class="form-group">
            <div class="col-sm-10"><p class="help-block"><?php if(isset($errors['login'])){ display_error($errors['login']); } ?></p></div>
        </div>
        <div class="form-group">
			<label for="email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10"><input name="email" type="text" id="email" class="form-control" value="<?php echo h($email); ?>"></div>
            <div class="col-sm-10"><p class="help-block"><?php if(isset($errors['email'])){ display_error($errors['email']); } ?></p></div>
        </div>
		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10"><input name="password" type="password" id="password" class="form-control" ></div>
            <div class="col-sm-10"><p class="help-block"><?php if(isset($errors['password'])){ display_error($errors['password']); } ?></p></div>
        </div>
		<div class="col-sm-10"><input type="submit" value="Log In" class="btn btn-lg btn-success"></div>

	</form>

	<!-- Include jQuery (required) and the JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	 <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/chart.js"></script>
    <script src="../js/toolkit.js"></script>
    <script src="../js/application.js"></script>
</div>
	
</body>

</html>