<div id="navBarContainer">
	<nav class="navBar">
		<span role="link" tabindex="0" onclick="openPage('index.php')" class="logo" title="neue Vorschläge">
 			<img src="assets/images/icons/logo.png" alt="">
		</span>
		<div class="group">
			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('search.php')" class="navItemLink">Suche
					<img src="assets/images/icons/search.png" alt="Suche" class="controlButton icon">
				</span>
			</div>
		</div>
		<div class="group">
			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Genres</span>
			</div>
			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Meine Musik</span>
			</div>
			<div class="navItem">
			<span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink">
				<img src="<?php echo $userLoggedIn->getProfilePic(); ?>">
				<?php echo $userLoggedIn->getUsername(); ?></span>
			</div>
		</div>
	</nav>
</div>
