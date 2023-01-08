<?php
include("errors.php");
include("includes/config.php");
include("includes/classes/User.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Songs.php");


if (isset($_SESSION['loggedIn'])) {
	$userLoggedIn = new User($con, $_SESSION['loggedIn']);
	$username = $userLoggedIn->getUsername();
	echo "<script>userLoggedIn = '$username';</script>";

} else {
	header("Location: register.php");
}

?>

<html lang="de">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pampelmucke</title>
	<link href="assets/css/style.css" rel="stylesheet" type="text/css">
	<link href="assets/images/favicon/favicon.ico" rel="icon">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>
<body>
	<div id="mainContainer">
		<div id="topContainer">
            <?php include("includes/navBarContainer.php"); ?>
			<div id="mainViewContainer">
				<div id="mainContent">
