<?php require_once('../../private/initialize.php'); ?> 
<?php
require_admin_login();

$person_set = find_all_persons();
$organization_set = find_all_organizations();
$post_set = find_all_posts();
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Dashboard | MeetMe</title>
	<link href="../css/toolkit.min.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container">
		<?php require_once('../../private/shared/nav_admin.php'); ?>

		<h1>Welcome <?php echo $_SESSION['first_name'] ?? ''; ?> <?php echo $_SESSION['last_name'] ?? ''; ?></h1>
		<h2>CRUD Tools</h2>
		<h3>Users</h3>
		<a href="person/new.php">Create Person</a>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php while($person = mysqli_fetch_assoc($person_set)) { ?>
				<tr>
					<td>
						<?php echo h($person['first_name']); ?>
					</td>
					<td>
						<?php echo h($person['last_name']); ?>
					</td>
					<td>
						<?php echo h($person['email']); ?>
					</td>
					<td>
						<a href="person/view.php?person_id=<?php echo h(u($person['person_id'])); ?>">View</a> <span class="pipe">|</span>
						<a href="person/edit.php?person_id=<?php echo h(u($person['person_id'])); ?>">Edit</a> <span class="pipe">|</span>
						<a href="person/delete.php?person_id=<?php echo h(u($person['person_id'])); ?>">Delete</a>
					</td>
				</tr>

				<?php } ?>
			</tbody>
		</table>
		<h3>Organizations</h3>
		<a href="#">Create Organization</a>

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Created</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php while($organization = mysqli_fetch_assoc($organization_set)) { ?>
				<tr>
					<td>
						<?php echo h($organization['name']); ?>
					</td>
					<td>
						<?php echo h(date("F j, Y g:i a ", strtotime($organization['created_on']))); ?>
					</td>
					<td>
						<a href="organization_view.php?person_id=<?php echo h(u($organization['organization_id'])); ?>">View</a> <span class="pipe">|</span>
						<a href="organization_edit.php?person_id=<?php echo h(u($organization['organization_id'])); ?>">Edit</a> <span class="pipe">|</span>
						<a href="organization_delete.php?person_id=<?php echo h(u($organization['organization_id'])); ?>">Delete
			</td>
		</tr>
			
  <?php } ?>
  </tbody>
</table>
<h3>Posts</h3>
		<a href="post/new.php">Create Post</a>

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Author</th>
					<th>Datetime Posted</th>
					<th>Content</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php while($post = mysqli_fetch_assoc($post_set)) { ?>
				<tr>
					<td>
						<a href="person/view.php?person_id=<?php echo h(u($post['person_id'])); ?>"><?php echo h($post['first_name']) . " " . h($post['last_name']); ?></a>
					</td>
					<td>
						<?php echo h(date("F j, Y g:i a ", strtotime($post['datetime_posted']))); ?>
					</td>
					<td>
						<?php if(strlen($post['content']) > 50){ echo substr(h($post['content']), 0, 50) . "..."; }else{ echo $post['content']; } ?>
					</td>
					<td>
						<a href="post/view.php?post_id=<?php echo h(u($post['post_id'])); ?>">View</a> <span class="pipe">|</span>
						<a href="post/edit.php?post_id=<?php echo h(u($post['post_id'])); ?>">Edit</a> <span class="pipe">|</span>
						<a href="post/delete.php?post_id=<?php echo h(u($post['post_id'])); ?>">Delete
			</td>
		</tr>
			
  <?php } ?>
  </tbody>
</table>
<h2>Analytics</h2>
	<?php mysqli_free_result($person_set); ?>
	<?php mysqli_free_result($organization_set); ?>
	<?php mysqli_free_result($post_set); ?>
	</div>
		<!-- Include jQuery (required) and the JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	 <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/chart.js"></script>
    <script src="../js/toolkit.js"></script>
    <script src="../js/application.js"></script>
</body>

</html>