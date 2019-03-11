<?php require_once('../../private/initialize.php'); ?> 
<?php
$person_set = find_all_persons();
$organization_set = find_all_organizations();
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Dashboard | MeetMe</title>
	<link href="../css/toolkit.min.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<h1>Welcome</h1>
		<h2>Administrative Tools</h2>
		<h3>Users</h3>
		<a href="person_new.php">Create Person</a>
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
						<a href="person_view.php?person_id=<?php echo h(u($person['person_id'])); ?>">View</a> <span class="pipe">|</span>
						<a href="person_edit.php?person_id=<?php echo h(u($person['person_id'])); ?>">Edit</a> <span class="pipe">|</span>
						<a href="person_delete.php?person_id=<?php echo h(u($person['person_id'])); ?>">Delete</a>
			</td>
		</tr>
			
  <?php } ?>
  </tbody>
</table>
<h3>Organizations</h3>
<a href="organization_new.php">Create Organization</a>
						
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
										<?php echo h($organization['created_on']); ?>
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
<h2>User Tools</h2>
	<?php mysqli_free_result($person_set); ?>
	<?php mysqli_free_result($organization_set); ?>
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