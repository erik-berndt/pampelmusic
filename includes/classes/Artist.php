<?php 

class Artist {
	private $con;
	private $id;
	private $name;
	private $genreId;
	private $genreName;
	
	public function __construct($con, $id) {
		$this->con = $con;
		$this->id = $id;

		$query = mysqli_query($this->con, "SELECT * FROM artists WHERE id='$this->id'");
		$artist = mysqli_fetch_array($query);
		$this->name = $artist['name'];
		$this->genreId = $artist['genre'];

		$genreQuery = mysqli_query($this->con, "SELECT * FROM genres WHERE id='$this->genreId'");
		$genre = mysqli_fetch_array($genreQuery);
		$this->genreName = $genre['name'];
	}

	public function getName() {
		return $this->name;
	}

	public function getId() {
		return $this->id;
	}

	public function getGenreId() {
		return $this->genreId;
	}

	public function getGenreName() {
		return $this->genreName;
	}

	public function getSongIds() {
		$query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist='$this->id'");
		$array = array();
		while($row = mysqli_fetch_array($query)) {
			array_push($array, $row['id']);
		}

		return $array;
	}
}

?>

