<?php 
include("includes/includedFiles.php");
?>

<h1 class="pageHeadingBig">Das könnte Dir auch gefallen:</h1>
<div class="gridViewContainer">


<?php 

	$genresQuery = mysqli_query($con, "SELECT * FROM genres");
	while ($row = mysqli_fetch_array($genresQuery)) {
		echo "<div class='gridViewItem'>
				  <span role='link' tabindex='0' onclick='openPage(\"genre.php?id={$row['id']}\")'>
				  <img src=\"{$row['imagePath']}\">
				  <div class='gridViewInfo'>
				  <h1>{$row['name']}</h1>
				  </div>
			  </div>";
	}
?>

</div>
