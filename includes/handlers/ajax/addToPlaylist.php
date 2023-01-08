<?php
include("../../config.php");

if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
	$playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];
	$idsArray = array();

	$orderQuery = mysqli_query($con, "SELECT IFNULL(MAX(playlistOrder), 0) playlistOrder FROM playlistSongs WHERE playlistId='$playlistId'");

	$row = mysqli_fetch_array($orderQuery);
	$order = $row['playlistOrder'] + 1;

	$songIdsQuery = mysqli_query($con, "SELECT songId FROM playlistSongs WHERE playlistId='$playlistId'");
	while ($id = mysqli_fetch_array($songIdsQuery)) {
		array_push($idsArray, $id['songId']);
	}
	if (!in_array($songId, $idsArray)) {
		$query = mysqli_query($con, "INSERT INTO playlistSongs VALUES(NULL, '$songId', '$playlistId', '$order')");
	}
} else {
	echo "Playlist Id oder Song Id fehlt!";
}
?>
	
