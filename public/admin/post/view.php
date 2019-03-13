<?php require_once('../../../private/initialize.php'); ?> <?php
$post_id = $_GET[ 'post_id' ] ?? '1'; // PHP > 7.0

$post = find_post_by_id( $post_id ); ?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Post View | MeetMe</title>
	<link href="../../css/toolkit.min.css" rel="stylesheet">
	<link href="../../css/styles.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<?php require_once('../../../private/shared/nav_admin.php'); ?>
		<h1>
			<?php echo h($post['first_name']) . " " . h($post['last_name']); ?>'s Post
		</h1>
		<p>
			<strong>On </strong><?php echo date("F j, Y g:i a", strtotime($post['datetime_posted'])); ?>
		</p>

		<p>
            <?php echo $post['content']; ?>
        </p>
        <p>
            <strong>Updated on </strong><?php echo date("F j, Y g:i a", strtotime($post['updated_on'])); ?>
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