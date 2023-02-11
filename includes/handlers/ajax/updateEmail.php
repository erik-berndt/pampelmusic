<?php
include("../../config.php");

if (!isset($_POST['username'])) {
	echo "Kein Username!";
	exit();
}
if (isset($_POST['email']) && $_POST['email'] != "") {
	$username = $_POST['username'];
	$email = $_POST['email'];
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "Email ist ungültig!";
		exit();
	}
	$emailCheck = mysqli_query($con, "SELECT email FROM users WHERE email='$email' AND username !='$username'");
	if (mysqli_num_rows($emailCheck) > 0) {
		echo "Email wird schon verwendet!";
		exit();
	}
	$updateQuery = mysqli_query($con, "UPDATE users SET email='$email' WHERE username='$username'");
	echo "Email erfolgreich geändert!";

} else {
	echo "Du musst eine Email-Adresse angeben!";
}

?>
