<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get($id) {
		$query = "SELECT *
				  FROM notification
				  WHERE id = '$id'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getAll() {
		$user = $this->user->getByUsername($_SESSION['username']);
		$query = "SELECT *
				  FROM notification
				  WHERE userId = '$user->id'
				  ORDER BY createDate DESC";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function create($userId, $type, $description, $link) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Insert Data
		$data = array(
				'userId' 		=> $userId,
				'type' 			=> $type,
				'description' 	=> $description,
				'link'			=> $link,
				'createDate'	=> $createDate
		);
		//Tries to insert
		return $this->db->insert('notification', $data);
	}
	
	public function deleteAll() {
		$user = $this->getUserByUsername($_SESSION['username']);
		$query = "DELETE 
				  FROM notification
				  WHERE userId = '$user->id'";		  			  
		return $this->db->query($query);
	}
	
	public function getUserByUsername($username) {
		$query = "SELECT *
				  FROM user
				  WHERE username = '$username'";		  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}
		
}