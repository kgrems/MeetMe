<nav class="navbar navbar-expand-lg navbar-dark bg-dark my-5">
			<a class="navbar-brand" href="<?php echo url_for('/admin/dashboard.php'); ?>">Home</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
		


			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="<?php echo url_for('/admin/person/new.php'); ?>">Create Person</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="<?php echo url_for('/admin/organization/new.php'); ?>">Create Organization</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="<?php echo url_for('/admin/logout.php'); ?>">Log Out</a>
					</li>
				</ul>
			</div>
		</nav>