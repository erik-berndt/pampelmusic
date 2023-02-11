<?php
ini_set('error_reporting', E_ALL);
ini_set( 'display_errors', 1 );
include("includes/includedFiles.php");
?>

<div class="userDetails">
	<div class="container borderBottom">
		<h2>EMAIL</h2>
		<input type="text" class="email" name="email" 
		placeholder="Email Adresse" value="<?php echo $userLoggedIn->getEmail(); ?>">
		<span class="message"></span>
		<button class="button" onclick="updateEmail('email')">SAVE</button>
	</div>
	<div class="container">
		<h2>PASSWORT</h2>
		<input type="password" class="oldPassword" name="oldPassword" 
		placeholder="Aktuelles Passwort" >
		<input type="password" class="newPassword1" name="newPassword1" 
		placeholder="Neues Passwort" >
		<input type="password" class="newPassword2" name="newPassword2" 
		placeholder="Neues Passwort wiederholen" >
		<span class="message"></span>
		<button class="button" onclick="updatePassword('oldPassword', 'newPassword1', 'newPassword2')">SAVE</button>
	</div>
</div>
