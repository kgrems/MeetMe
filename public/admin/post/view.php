<?php require_once('../../../private/initialize.php'); ?> <?php
$person_id = $_GET[ 'person_id' ] ?? '1'; // PHP > 7.0

$person = find_person_by_id( $person_id ); ?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Person View | MeetMe</title>
	<link href="../../css/toolkit.min.css" rel="stylesheet">
	<link href="../../css/styles.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<?php require_once('../../../private/shared/nav_admin.php'); ?>
		<h1>
			<?php echo h($person['first_name']) . " " . h($person['last_name']); ?>
		</h1>
		<p>
			<?php echo h($person['email']); ?>
		</p>
		<p>
			<strong>Is premium:</strong> <?php if($person['is_premium'] == '1'){ echo 'Yes'; }else{ echo 'No'; }?><br>
			<strong>Is admin:</strong> <?php if($person['is_admin'] == '1'){ echo 'Yes'; }else{ echo 'No'; }?>

		</p>
		<p><strong>Birth date:</strong>
			<?php echo date("F j, Y ", strtotime($person['birth_date'])); ?>
		</p>
		<p><strong>Created on:</strong>
			<?php echo date("g:i a F j, Y ", strtotime($person['created_on'])); ?>
		</p>
		<p>
			<strong>Last update on:</strong> <?php echo date("g:i a F j, Y ", strtotime($person['updated_on'])); ?>
		</p>
		<p>
			<strong>Biography:</strong><br> <?php echo h($person['biography']); ?>
		</p>
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