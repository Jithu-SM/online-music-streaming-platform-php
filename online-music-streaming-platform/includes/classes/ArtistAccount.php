<?php
	class Account {

		private $con;
		private $errorArray;

		public function __construct($con) {
			$this->con = $con;
			$this->errorArray = array();
		}

		public function login($email, $pw) {

			$pw = ($pw);

			$query = mysqli_query($this->con, "SELECT * FROM artists WHERE email='$email' AND password='$pw'");

			if(mysqli_num_rows($query) == 1) {
				return true;
			}
			else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}

		}

		public function register($un, $em, $em2, $pw, $pw2) {
			$this->validateArtistname($un);
			$this->validateEmails($em, $em2);
			$this->validatePasswords($pw, $pw2);

			if(empty($this->errorArray) == true) {
				//Insert into db
				return $this->insertArtistDetails($un, $em, $pw);
			}
			else {
				return false;
			}

		}

		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		private function insertArtistDetails($un, $em, $pw) {
			$encryptedPw = ($pw);
			$profilePic = "assets/images/profile-pics/head_emerald.png";
			$date = date("Y-m-d");

			$result = mysqli_query($this->con, "INSERT INTO artists(name, email, password, date, profilePic) VALUES ('$un', '$em', '$encryptedPw', '$date', '$profilePic')");

			return $result;
		}

		private function validateArtistname($un) {

			if(strlen($un) > 100 || strlen($un) < 0) {
				array_push($this->errorArray, Constants::$artistnameCharacters);
				return;
			}

			$checkArtistnameQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE name='$un'");
			if(mysqli_num_rows($checkArtistnameQuery) != 0) {
				array_push($this->errorArray, Constants::$ArtistnameTaken);
				return;
			}

		}

		private function validateEmails($em, $em2) {
			if($em != $em2) {
				array_push($this->errorArray, Constants::$emailsDoNotMatch);
				return;
			}

			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}

			$checkEmailQuery = mysqli_query($this->con, "SELECT email FROM artists WHERE email='$em'");
			if(mysqli_num_rows($checkEmailQuery) != 0) {
				array_push($this->errorArray, Constants::$emailTaken);
				return;
			}

		}

		private function validatePasswords($pw, $pw2) {
			
			if($pw != $pw2) {
				array_push($this->errorArray, Constants::$passwordsDoNoMatch);
				return;
			}

			if(preg_match('/[^A-Za-z0-9]/', $pw)) {
				array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
				return;
			}

			if(strlen($pw) > 30 || strlen($pw) < 5) {
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
			}

		}


	}
?>