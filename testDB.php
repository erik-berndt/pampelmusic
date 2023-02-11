<?php
ini_set('error_reporting', E_ALL);
ini_set( 'display_errors', 1 );
ob_start();
session_start();

$timezone = date_default_timezone_set("Europe/Berlin");

$conn = mysqli_connect("localhost", "root", "", "slotify");

if (mysqli_connect_errno()) {
	echo "Verbindung konnte nicht hergestellt werden: " . mysqli_connect_errno();
}

$query = mysqli_query($conn, "SELECT artists.name AS artist, artists.id AS artistId, albums.title AS album, albums.id AS albumId FROM albums JOIN artists JOIN genres ON albums.genre = artists.genre AND artists.genre = genres.id WHERE albums.genre = '22' AND albums.artist = artists.id");


?>

<pre>

<?php 
$prevArtist = "verena";
while($row = mysqli_fetch_array($query)) {
	if ($row['artist'] != $prevArtist) {
		echo "<h1>{$row['artist']}</h1>";
	}
	echo "<h5>{$row['album']}</h5>";
	$prevArtist = $row['artist'];
}

?>
</pre>
