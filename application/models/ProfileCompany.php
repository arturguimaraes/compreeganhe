<?php
class ProfileCompany extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}	
	
	public function get($id) {
		$query = "SELECT *
				  FROM profileCompany
				  WHERE id = '$id'";		  
				  
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return $result[0];
		return NULL;		
	}

	public function getAll() {
		$query = "SELECT *
				  FROM profileCompany";		  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}
		
}