<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	<div class="container">
		<a class="navbar-brand" href="index.php">
			<img src="ComponentFE/images/logo_honda.png" alt="Honda Motor By POS Synergy">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="oi oi-menu"></span> Menu
		</button>

		<div class="collapse navbar-collapse" id="ftco-nav">
			<?php $page = $_SERVER['PHP_SELF']; ?>
			
			<ul class="navbar-nav ml-auto">
				<li class="nav-item <?php if (strpos($page, 'index') !== false) { echo 'active'; } ?>"><a href="index.php" class="nav-link">Home</a></li>
				<li class="nav-item <?php if (strpos($page, 'login') !== false) { echo 'active'; } ?>"><a href="login.php" class="nav-link">Member</a></li>
				<li class="nav-item <?php if (strpos($page, 'about') !== false) { echo 'active'; } ?>"><a href="about.php" class="nav-link">About Us</a></li>
			</ul>
		</div>
	</div>
</nav>