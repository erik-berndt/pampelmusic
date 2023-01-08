<?php
include("../../config.php");

if (!isset($_POST['username'])) {
	echo "Username fehlt!";
	exit();
}

if (!isset($_POST['oldPassword']) || !isset($_POST['newPassword1'])  || !isset($_POST['newPassword2'])) {
	echo "Nicht alle Felder ausgefüllt!";
	exit();
}

if ($_POST['oldPassword'] == "" || $_POST['newPassword1'] == ""  || $_POST['newPassword2'] == "") {
	echo "Bitte alle Felder ausfüllen!";
	exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$oldMd5 = md5($oldPassword);

$passwordCheck = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$oldMd5'");

if (mysqli_num_rows($passwordCheck) != 1) {
	echo "Das alte Passwort war anders!";
	exit();
}

if ($newPassword1 != $newPassword2) {
	echo "Die neuen Eingaben stimmen nicht überein!";
	exit();
}

if (preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
	echo "Das Passwort darf nur Buchstaben und Zahlen enthalten!";
	exit();
}

if (strlen($newPassword1) < 8) {
	echo "Dein Passwort muss mindestens 8 Zeichen haben!";
	exit();
}

$newMd5 = md5($newPassword1);

$query = mysqli_query($con, "UPDATE users SET password='$newMd5' WHERE username='$username'");
echo "Neues Passwort erfolgreich erstellt!";

?>
