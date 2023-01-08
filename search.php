<?php
include("errors.php");
include("includes/includedFiles.php");

if (isset($_GET['term'])) { 
	$term = urldecode($_GET['term']);
} else {
	$term = "";
}

?>
<script src="assets/js/script.js"></script>
<div class="searchContainer">
	<h4>Suche nach Künstler Album oder Song</h4>
	<input type="text" class="searchInput" autofocus value="<?php echo $term; ?>" placeholder="Suchbegriff..." spellcheck="false">
</div>

<script>
/* $(".searchInput").focus(); */
$(function() {
	$(".searchInput").keyup(function() {
		clearTimeout(timer);
		timer = setTimeout(function() {
			var val = $(".searchInput").val();
			openPage("search.php?term=" + val);
		}, 2000);
	})
});
$(document).ready(function(){
        $(".searchInput").focus();
        var search = $(".searchInput").val();
        $(".searchInput").val('');
        $(".searchInput").val(search);
})


</script>

<?php 
if ($term == "") {
	exit();
}
?>

<div class="trackListContainer borderBottom">
	<h2>SONGS</h2>
	<ul class="tracklist">

<?php			

$songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%'");

if (mysqli_num_rows($songsQuery) == 0) {
	echo "<span class='noResults'>Keine Übereinstimmung mit '".$term."'</span>";
}


$i = 1;

$songIdArray = array();

while ($row =  mysqli_fetch_array($songsQuery)) {
	/* if($i > 15) { */
	/* 	break; */
	/* } */
	array_push($songIdArray, $row['id']);

	$albumSong = new Song($con, $row['id']);
	$albumArtist = $albumSong->getArtist();
	echo "<li class='tracklistRow'>

		<div class='trackCount'>
			<img class='play' src='assets/images/icons/play-white.png' 
			onclick='setTrack(\""
			.$albumSong->getId(). "\", tempPlaylist, true)'>
			<span class='trackNumber'>$i</span>
		</div>

		<div class='trackInfo'>
			<span class='trackName'>".$albumSong->getTitle()."</span>
			<span class='artistName'>".$albumArtist->getName()."</span>
		</div>

		<div class='trackOptions'>
			<input type='hidden' class='songId' value='"
			.$albumSong->getId()."'>
			<img class='optionsButton' src='assets/images/icons/options.png' 
			onclick='showOptionsMenu(this)'>
		</div>
 
		<div class='trackDuration'>
			<span class='duration'>".$albumSong->getDuration()."</span>
		</div>
		</li>";
	$i++;
}			

?>
		<script>var tempSongIds = '<?php echo json_encode($songIdArray) ?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>
	</ul>
</div>

<div class="artistContainer borderBottom">
<h2>KÜNSTLER</h2>

<?php

$artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '%$term%'");

if (mysqli_num_rows($artistsQuery) == 0) {
	echo "<span class='noResults'>Keine Übereinstimmung mit '".$term."'</span>";
}
while($row = mysqli_fetch_array($artistsQuery)) {
	$artistFound = new Artist($con, $row['id']);
	echo "<div class='searchResultRow'>
			<div class='artistName'>
				<span role='link' tabindex='0' onclick='openPage(\"artist.php?id="
				.$artistFound->getId()."\")'>"
				.$artistFound->getName()."</span>
			</div>
		  </div>";
}

?>
</div>

<div class="gridViewContainer">
	<h2>ALBUMS</h2>
<?php 

$albumsQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '%$term%'");

if (mysqli_num_rows($albumsQuery) == 0) {
	echo "<span class='noResults'>Keine Übereinstimmung mit '".$term."'</span>";
}
 
while ($row = mysqli_fetch_array($albumsQuery)) {
	echo "<div class='gridViewItem'>
			  <span role='link' tabindex='0' onclick='openPage(\"album.php?id=".$row['id']."\")'>
				  <img src=\"".$row['artworkPath']."\">
				  <div class='gridViewInfo'>".$row['title']."
				  </div>
			  </span>
		  </div>";
	}
?>

</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
