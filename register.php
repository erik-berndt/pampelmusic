<?php

ini_set('error_reporting', E_ALL);
ini_set( 'display_errors', 1 );

include('includes/config.php');

include("includes/classes/Constants.php");
include("includes/classes/Account.php");

$account = new Account($con);

include("includes/handlers/register-handler.php");	
include("includes/handlers/login-handler.php");	

function getInputValue($name) {
	if (isset($_POST[$name])) {
		echo $_POST[$name];
	}
}

?>



<html lang="de">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="assets/css/register.css" rel="stylesheet" type="text/css">
	<link href="assets/images/favicon/favicon.ico" rel="icon">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
	<title></title>
</head>
<body>
<?php
if (isset($_POST['registerButton'])) {
	echo '
	<script>
	$(document).ready(function () {
			$("#loginForm").hide();
			$("#registerForm").show();
		});
	</script>';
} else {
	echo '
	<script>
	$(document).ready(function () {
			$("#loginForm").show();
			$("#registerForm").hide();
		});
	</script>';
}
?>
	<div id="background">
		<div id="loginContainer">
			<div id="inputContainer">
				<form id="loginForm" action="register.php" method="POST">
					<h2>Melde dich an</h2>
					<p>
					<span class="errorMessage">
					<?php echo $account->getError(Constants::$check['loginFails']); ?>
					</span>
						<label for="loginUsername">Benutzername</label>
						<input id="loginUsername" name="loginUsername" type="text" 
								
							   placeholder="Benutzername" value="<?php getInputValue('loginUsername') ?>"required>
					</p>

					<p>
						<label for="password">Passwort</label>
						<input id="password" name="loginPassword" type="password" 
							   placeholder="Dein Passwort" required>
					</p>
					<button type="submit" name="loginButton">ANMELDEN</button>
					<div class="hasAccount">
						<span id="hideLogin">Noch nicht registriert?</span>
					</div>
				</form>



				<form id="registerForm" action="register.php" method="POST">
					<h2>Kostenloses Konto erstellen</h2>
					<p><span class="errorMessage">
						<?php 
						echo $account->getError(Constants::$check['uname']);
						echo $account->getError(Constants::$check['unTaken']); 
						?>
						</span>
						<label for="username">Benutzername</label>
						<input id="username" name="username" type="text" 
							   placeholder="z.B. hansiPampel" 
							   value="<?php getInputValue('username') ?>" required>
					</p>

					<p><span class="errorMessage">
						<?php echo $account->getError(Constants::$check['fname']); ?>
						</span>
						<label for="firstName">Vorname</label>
						<input id="firstName" name="firstName" type="text" 
							   placeholder="z.B. Hansi" 
							   value="<?php getInputValue('firstName') ?>" required>
					</p>

					<p><span class="errorMessage">
						<?php echo $account->getError(Constants::$check['lname']); ?>
						</span>
						<label for="lastName">Nachname</label>
						<input id="lastName" name="lastName" type="text" 
							   placeholder="z.B. Pampel" 
							   value="<?php getInputValue('lastName') ?>" required>
					</p>

					<p><span class="errorMessage">
						<?php 
						echo $account->getError(Constants::$check['email1']); 
						echo $account->getError(Constants::$check['email2']); 
						echo $account->getError(Constants::$check['emTaken']); 
						?>
						</span>
						<label for="email">Email</label>
						<input id="email" name="email" type="email" 
							   placeholder="z.B. h.pampel@web.de" 
							   value="<?php getInputValue('email') ?>" required>
					</p>

					<p>
						<label for="confirmEmail">Email nochmal</label>
						<input id"email2" name="email2" type="email" 
							   placeholder="nochmal" 
							   value="<?php getInputValue('email2') ?>" required>
					</p>

					<p><span class="errorMessage">
						<?php
						echo $account->getError(Constants::$check['pass1']); 
						echo $account->getError(Constants::$check['pass2']); 
						echo $account->getError(Constants::$check['pass3']); 
						?>
						</span>
						<label for="registerPassword">Passwort</label>
						<input id="registerPassword" name="password" type="password" 
							   placeholder="Dein Passwort" required>
					</p>

					<p>
						<label for="confirmPassword">Passwort nochmal</label>
						<input id="password2" name="password2" type="password" 
							   placeholder="nochmal" required>
					</p>

					<button type="submit" name="registerButton">REGISTRIEREN</button>
					<div class="hasAccount">
						<span id="hideRegister">Ich habe ein Konto</span>
					</div>
				</form>
			</div>
			<div id="loginText">
				<h1>Hör dir alles an!</h1>
				<h2>Coole Mucke, zack, sofort!</h2>
				<ul>
					<li>Entdecke neue Musik</li>
					<li>Mach dein Mixtape</li>
					<li>Bleib im Timing</li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>
