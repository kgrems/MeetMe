<?php require_once('../../../private/initialize.php'); ?> <?php

require_admin_login();

$person_id = $_GET[ 'person_id' ] ?? '1'; // PHP > 7.0

$person = find_person_by_id( $person_id ); 
$post_set = find_posts_by_person($person_id);
$post_count = 0;
?>

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
		<h2>Posts</h2>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Datetime Posted</th>
					<th>Content</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php $post_count = mysqli_num_rows($post_set); ?>
				<?php 
				if($post_count > 0){
					while($post = mysqli_fetch_assoc($post_set)) { ?>
				<tr>
					<td>
						<?php echo h(date("F j, Y g:i a ", strtotime($post['datetime_posted']))); ?>
					</td>
					<td>
						<?php if(strlen($post['content']) > 50){ echo substr(h($post['content']), 0, 50) . "..."; }else{ echo $post['content']; } ?>
					</td>
					<td>
						<a href="../post/view.php?post_id=<?php echo h(u($post['post_id'])); ?>">View</a> <span class="pipe">|</span>
						<a href="../post/edit.php?post_id=<?php echo h(u($post['post_id'])); ?>">Edit</a> <span class="pipe">|</span>
						<a href="../post/delete.php?post_id=<?php echo h(u($post['post_id'])); ?>">Delete
			</td>
		</tr>
		<?php }
			}else{ echo "<tr><td></td><td></td><td></td></tr>"; } ?>
			
  <?php 
			mysqli_free_result($post_set);	
  ?>
  </tbody>
		</table>
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