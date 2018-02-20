<?php
class AdminModel extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library(array('session'));
	}
	
	public function login($username, $password) {
		$query = "SELECT *
				  FROM admin
				  WHERE username = '$username'
				  AND password = SHA('$password')";
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return true;
		else
			return false;
	}
	
	public function exists($username) {
		$query = "SELECT *
				  FROM admin
				  WHERE username = '$username'";
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return true;
		else
			return false;		
	}
	
	public function checkLogin() {
		if(isset($_SESSION['loggedInAdmin']))
			return $_SESSION['loggedInAdmin'];
		else
			return false;
	}
		
}