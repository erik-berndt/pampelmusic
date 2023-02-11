<?php

function sanitizeFormString($inputText, $uc = false) {

	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = str_replace("'", "''", $inputText);
	if ($uc == true) {
		$inputText = ucfirst(strtolower($inputText));
	}
	return $inputText;
}

if (isset($_POST['registerButton'])) {
	$username = sanitizeFormString($_POST['username']);
	$firstName = sanitizeFormString($_POST['firstName'], true);
	$lastName = sanitizeFormString($_POST['lastName'], true);
	$email = sanitizeFormString($_POST['email']);
	$email2 = sanitizeFormString($_POST['email2']);
	$password = sanitizeFormString($_POST['password']);
	$password2 = sanitizeFormString($_POST['password2']);

	$wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);
	
	if ($wasSuccessful) {
		$_SESSION['loggedIn'] = $username;
		header("Location: index.php");
	}
}

?>
