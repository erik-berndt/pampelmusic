<?php

class Account {

	private $con;
	private $errorArray;

	public function __construct($con) {

		$this->con = $con; 
		$this->errorArray = array();
	}

	public function login($un, $pw) {
		$pw = md5($pw);
		
		$query = mysqli_query($this->con, 
			"SELECT * FROM users WHERE username='$un' AND password='$pw'");
		
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {
			array_push($this->errorArray, Constants::$check['loginFails']);
			return false;
		}
	}
		 
	public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {

		$this->validateUsername($un);
		$this->validateFirstName($fn);
		$this->validateLastName($ln);
		$this->validateEmails($em, $em2);
		$this->validatePasswords($pw, $pw2);

		if (empty($this->errorArray)) {
			return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
		} else {
			return false;
		}
	}

	public function getError($error) {

		if (!in_array($error, $this->errorArray)) {
			$error = "";
		}
		return "<span class='errorMessage'>$error</span>";
	}

	private function insertUserDetails($un, $fn, $ln, $em, $pw) {

		$encryptedPassword = md5($pw);
		$profilePic = "assets/images/profile-pics/dummy.png";
		$date = date("Y-m-d");
		$result = mysqli_query($this->con, 
			"INSERT INTO users VALUES (NULL, '$un', '$fn', '$ln', '$em', 
							'$encryptedPassword', '$date', '$profilePic')");
		return $result;
	}

	private function validateUsername($un) {

		if (strlen($un) > 25 || strlen($un) < 5) {
			array_push($this->errorArray, Constants::$check['uname']);
			return;
		}
		$checkUsernameQuery = mysqli_query($this->con, 
			"SELECT username FROM users WHERE username='$un'");
		
		if (mysqli_num_rows($checkUsernameQuery) != 0) {
			array_push($this->errorArray, Constants::$check['unTaken']);
			return;
		}
	}

	private function validateFirstName($fn) {

		if (strlen($fn) > 25 || strlen($fn) < 2) {
			array_push($this->errorArray, Constants::$check['fname']);
			return;
		}
	}

	private function validateLastName($ln) {

		if (strlen($ln) > 25 || strlen($ln) < 2) {
			array_push($this->errorArray, Constants::$check['lname']);
			return;
		}
	}

	private function validateEmails($em, $em2) {

		if ($em != $em2) {
			array_push($this->errorArray, Constants::$check['email1']);
			return;
		}
		if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
			array_push($this->errorArray, Constants::$check['email2']);
			return;
		}
		$checkEmailQuery = mysqli_query($this->con, 
			"SELECT email FROM users WHERE email='$em'");

		if (mysqli_num_rows($checkEmailQuery) != 0) {
			array_push($this->errorArray, Constants::$check['emTaken']);
			return;
		}
	}

	private function validatePasswords($pw, $pw2) {

		if ($pw != $pw2) {
			array_push($this->errorArray, Constants::$check['pass1']);
			return;
		}
		if (preg_match('/[^A-Za-z0-9]/', $pw)) {
			array_push($this->errorArray, Constants::$check['pass2']);
			return;
		}
		if (strlen($pw) > 25 || strlen($pw) < 8) {
			array_push($this->errorArray, Constants::$check['pass3']);
			return;
		}
	}
}
?>
