<?php
include("includes/includedFiles.php");

if (!isset($_GET['id'])) {
	echo "<h1> Kein Genre gesetzt!<h1";
}
$id = $_GET['id'];

$genresQuery = mysqli_query($con, "SELECT * FROM genres WHERE id='$id'");
$genre = mysqli_fetch_array($genresQuery);
$genreName = $genre['name'];

?>
	<h1 class='pageHeadingBig'><?php echo $genreName; ?></h1>
<div class="gridViewContainer">
<?php
$prevArtist = "xxxxxxx";
$query = mysqli_query($con, "SELECT artists.name AS artist, artists.id AS artistId, albums.title AS album, albums.id AS albumId FROM albums JOIN artists JOIN genres ON albums.genre = artists.genre AND artists.genre = genres.id WHERE albums.genre = '$id' AND albums.artist = artists.id ORDER BY artists.name");
while ($row = mysqli_fetch_array($query)) {
	if ($row['artist'] != $prevArtist) {
     echo "</ul></div><div class='artistHeading'>
				<span role='link' tabindex='0' 
				onclick='openPage(\"artist.php?id={$row['artistId']}\")'>
					<div class='gridViewInfo2'>{$row['artist']}
					</div>
				</span><ul>";}
	echo "<li class='albumList'><span role='link' tabindex='0' onclick='openPage(\"album.php?id={$row['albumId']}\")'>
			<div class='albumItem'>{$row['album']}</div>
				</span></li>
			";
	$prevArtist = $row['artist'];
}
?>
</div>

