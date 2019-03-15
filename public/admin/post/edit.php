<?php

require_once( '../../../private/initialize.php' );

require_admin_login();

if ( !isset( $_GET[ 'post_id' ] ) ) {
	redirect_to( url_for( 'admin/dashboard.php' ) );
}
$post_id = $_GET[ 'post_id' ];

if ( is_post_request() ) {
	$post = [];
	$post['post_id'] = $post_id;
	$post[ 'person_id' ] = $_POST[ 'person_id' ] ?? '';
	$post[ 'content' ] = $_POST['content'] ?? '';

	$result = update_post( $post );
	if ( $result === true ) {
		redirect_to( url_for( 'admin/dashboard.php' ) );
	} else {
		$errors = $result;
	}

} else {
	$post = find_post_by_id( $post_id );

}
$person_set = find_all_persons();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- These meta tags come first. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Edit Post | MeetMe</title>

	<!-- Include the CSS -->
	<link href="../../css/toolkit.min.css" rel="stylesheet">
		<link href="../../css/styles.css" rel="stylesheet" type="text/css">

</head>

<body>
<div class="container">
	<?php require_once('../../../private/shared/nav_admin.php'); ?>
	<h1>Edit Post</h1>
	<form action="edit.php?post_id=<?php echo h(u($post_id)); ?>" method="post" class="form-horizontal my-5">
		<div class="form-group">
			<label for="person_id" class="col-sm-2 control-label">Person Posting</label>
			<div class="col-sm-10">
				<select name="person_id" id="person_id">
					<?php 
						while($person = mysqli_fetch_assoc($person_set)) {
							echo "<option value=\"" . $person['person_id'] . "\" ";
							if($post['person_id'] == $person['person_id']){echo " selected "; }
							echo ">" . h($person['first_name']) . " " . h($person['last_name']);
							echo "</option>";
						}
						mysqli_free_result($person_set);	
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="content" class="col-sm-2 control-label">Content</label>
			<div class="col-sm-10"><textarea name="content" id="content" class="form-control"><?php echo h($post['content']); ?></textarea></div>
			<div class="col-sm-10"><p class="help-block"><?php if(isset($errors['content'])){ display_error($errors['content']); } ?></p></div>
		</div>
		<div class="col-sm-10"><input type="submit" value="Update" class="btn btn-lg btn-success"> <input type="button" value="Cancel" class="btn btn-lg btn-danger" onclick="location.href='../dashboard.php';"></div>

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