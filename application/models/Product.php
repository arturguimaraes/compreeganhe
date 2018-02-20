<?php
class Product extends CI_Model {

	public $id;
	public $name;
	public $description;
	public $value;
	public $image;
	public $createDate;
	public $updateDate;

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('date'));
	}

	public function getAll() {
		$query = "SELECT *
				  FROM product
				  ORDER BY createDate";		  
		$result = $this->db->query($query)->result();
		
		if (count($result) > 0)
			return $result;
		else
			return NULL;		
	}

	public function getById($id) {
		$query = "SELECT *
				  FROM product
				  WHERE id = '$id'";		  
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;		
	}
	
	public function create($name, $description, $value) {
		//Pega a hora atual
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Query de inserção SQL
		$query = "INSERT INTO product
				  (name, description, value, createDate)
				  VALUES 
				  ('$name', '$description', $value, '$createDate')";
		return $this->db->query($query);
	}

	public function update($id, $name, $description, $value) {
		//Pega a hora atual
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$query = "UPDATE product
				  SET name = '$name',
				  description = '$description',
				  value = '$value',
				  updateDate = '$updateDate'
				  WHERE id = '$id'";
		return $this->db->query($query);
	}

	public function delete($id) {
		$query = "DELETE FROM product
				  WHERE id = '$id'";
		return $this->db->query($query);
	}

}