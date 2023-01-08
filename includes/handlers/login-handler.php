<?php

function apostropheTransformer($inputText) {
	$inputText = str_replace("'", "''", $inputText);
	return $inputText;
}

if (isset($_POST['loginButton'])) {
	$username = apostropheTransformer($_POST['loginUsername']);
	$password = $_POST['loginPassword'];
	$wasSuccessful = $account->login($username, $password);

	if ($wasSuccessful) {
		$_SESSION['loggedIn'] = $_POST['loginUsername'];
		header("Location: index.php");
	}
}

?>
