<?php
	
	class User {

		private $con;
		private $username;

		public function __construct($con, $username) {
			$this->con = $con;
			$this->username = $username;
		}

		public function getUsername() {
			return $this->username;
		}
		public function getEmail() {
			$query = mysqli_query($this->con, "SELECT email FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['email'];
		}

		public function getFirstAndLastName() {
			$query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name' FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['name'];
		}
	}


	class ArtistProfile {

		private $con;
		private $email;

		public function __construct($con, $email) {
			$this->con = $con;
			$this->email = $email;
		}

		public function getEmail() {
			return $this->email;
		}
		public function getArtistname() {
			$query = mysqli_query($this->con, "SELECT name FROM artists WHERE email='$this->email'");
			$row = mysqli_fetch_array($query);
			return $row['name'];
		}
		public function getArtistid() {
			$query = mysqli_query($this->con, "SELECT id FROM artists WHERE email='$this->email'");
			$row = mysqli_fetch_array($query);
			return $row['id'];
		}
		
		
	}

?>