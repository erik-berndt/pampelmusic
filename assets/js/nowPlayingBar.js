$(document).ready(function() {
	var newPlaylist = <?php echo $jsonArray; ?>;
	audioElement = new Audio();
	setTrack(newPlaylist[0], newPlaylist, false);
	updateVolumeProgressBar(audioElement.audio);

	$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", 
	function(e) {
		e.preventDefault();
	});

	$(".playbackBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".playbackBar .progressBar").mousemove(function(e) {
		if (mouseDown == true) {
			timeFromOffset(e, this);
		}
	});
	$(".playbackBar .progressBar").mouseup(function(e) {
		timeFromOffset(e, this);
	});
	
	// Volume Bar
	
	$(".volumeBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".volumeBar .progressBar").mousemove(function(e) {
		if (mouseDown == true) {
			var percentage = e.offsetX / $(this).width();
			
			if (percentage >= 0 && percentage <= 1){
				audioElement.audio.volume = percentage;
			}
		}
	});
	$(".volumeBar .progressBar").mouseup(function(e) {
		var percentage = e.offsetX / $(this).width();
		
		if (percentage >= 0 && percentage <= 1){
			audioElement.audio.volume = percentage;
		}
	});
	
	
	$(document).mouseup(function() {
		mouseDown = false;
	});
});

function timeFromOffset(mouse, progressBar) {
	var percentage = mouse.offsetX / $(progressBar).width() * 100;
    var	seconds = audioElement.audio.duration * (percentage / 100);
	audioElement.setTime(seconds); 
}

function prevSong() {
	if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
		audioElement.setTime(0);
	} else {
		currentIndex--;
		setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
	} 
}

function nextSong() {
	if (repeat == true) {
		audioElement.setTime(0);
		playSong();
		return;
	}

	if (currentIndex == currentPlaylist.length - 1) {
		currentIndex = 0;
	} else {
		currentIndex++;
	}
	var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
	setTrack(trackToPlay, currentPlaylist, true);
}

function setMuted() {
	audioElement.audio.muted = !audioElement.audio.muted;
	var imageName = audioElement.audio.muted ? "volume-mute.png": "volume-low.png";
	$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}

function setShuffle() {
	shuffle = !shuffle;
	var imageName = shuffle ? "shuffle-active.png": "shuffle-ddd-btn.png";
	$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

	if (shuffle == true) {
		shuffleArray(shufflePlaylist);
		currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
	} else {
		currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
	}
}

function shuffleArray(a) {
	var j, x, i;
	for (i = a.length; i; i--) {
		j = Math.floor(Math.random() * i);
		x = a[i - 1];
		a[i - 1] = a[j];
		a[j] = x;
	}
}


function setRepeat() {
	repeat = !repeat;
	var imageName = repeat ? "repeat-active.png": "repeat-ddd-btn.png";
	$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
}

function setTrack(trackId, newPlaylist, play) {
	if (newPlaylist != currentPlaylist) {
		currentPlaylist = newPlaylist;
		shufflePlaylist = currentPlaylist.slice();
		shuffleArray(shufflePlaylist);
	}

	if (shuffle == true) {
		currentIndex = shufflePlaylist.indexOf(trackId);
	} else {
		currentIndex = currentPlaylist.indexOf(trackId);
	}
	
	pauseSong();

	$.post("includes/handlers/ajax/getSongJson.php", 
	{songId: trackId}, 
	function(data) {
		
		var track = JSON.parse(data);

		$(".trackName span").text(track.title);

		$.post("includes/handlers/ajax/getArtistJson.php",
		{artistId: track.artist}, 
		function(data) {
		
			var artist = JSON.parse(data);
			$(".trackInfo .artistName span").text(artist.name);
			$(".trackInfo .artistName span").attr("onclick", 
			"openPage('artist.php?id=" + artist.id + "')");
		});
		
		$.post("includes/handlers/ajax/getAlbumJson.php", 
		{albumId: track.album}, 
		function(data) {
			var album = JSON.parse(data);
			$(".albumLink img").attr("src", album.artworkPath);
			$(".albumLink img").attr("onclick", 
				"openPage('album.php?id=" + album.id + "')");
			$(".trackName span").attr("onclick", 
				"openPage('album.php?id=" + album.id + "')");
		});
		
		audioElement.setTrack(track);
		if(play) {
			playSong();
		}
	});

	if (play) {
		/* audioElement.play(); */
		playSong();
	}
}

function playSong() {
	if (audioElement.audio.currentTime == 0) {
		$.post("includes/handlers/ajax/updatePlays.php", 
		{songId: audioElement.currentlyPlaying.id});
	}
	$(".controlButton.play").hide();
	$(".controlButton.pause").show();
	audioElement.play();
}

function pauseSong() {
	$(".controlButton.play").show();
	$(".controlButton.pause").hide();
	audioElement.pause();
}


