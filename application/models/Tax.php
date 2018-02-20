<?php
class Tax extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('date'));
	}

	public function get($id) {
		$query = "SELECT *
				  FROM tax
				  WHERE id = '$id'";
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;		
	}

	public function getByName($name) {
		$query = "SELECT *
				  FROM tax
				  WHERE name = '$name'";
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;		
	}

	public function getAll() {
		$query = "SELECT *
				  FROM tax";
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		else
			return array();		
	}
	
	public function update($id, $percentage, $value, $relative) {
		//Pega a hora atual
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$query = "UPDATE tax
				  SET percentage = '$percentage',
				  value = '$value',
				  relative = '$relative',
				  updateDate = '$updateDate'
				  WHERE id = '$id'";
		return $this->db->query($query);
	}

}