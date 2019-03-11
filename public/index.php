<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Log In | MeetMe</title>
		<link href="css/toolkit.min.css" rel="stylesheet">
</head>

<body>
<div class="container">
	<h1>Log In</h1>
	<form action="login.php" method="post" class="form-horizontal my-5">
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10"><input name="email" type="text" id="email" class="form-control"></div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10"><input name="password" type="text" id="password" class="form-control"></div>
		</div>
		<div class="col-sm-10"><input type="submit" value="Log In" class="btn btn-lg btn-success"> <a href="signup.php">Register</a></div>

	</form>

	<!-- Include jQuery (required) and the JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	 <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/toolkit.js"></script>
    <script src="js/application.js"></script>
</div>
	
</body>

</html>