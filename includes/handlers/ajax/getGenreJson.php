<?php

include("../../config.php");

if (isset($_POST['genreId'])) {
	$genreId = $_POST['genreId'];
	$query = mysqli_query($con, "SELECT * FROM genres WHERE id='$genreId'");
	$resultArray = mysqli_fetch_array($query);
	echo json_encode($resultArray);
}
?>

