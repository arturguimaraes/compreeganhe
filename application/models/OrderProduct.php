<?php
class OrderProduct extends CI_Model {

	public $orderId;
	public $productId;

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function getAll($orderId, $productId) {
		$query = "SELECT *
				  FROM `orderProduct`
				  WHERE orderId = '$orderId'
				  AND productId = '$productId'";		  
		$result = $this->db->query($query)->result();
		
		if (count($result) > 0)
			return $result;
		else
			return NULL;		
	}
	
	public function getProductId($orderId) { 
		$query = "SELECT *
				  FROM `orderProduct`
				  WHERE `orderProduct`.`orderId` = '$orderId'";		  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return intval($result[0]->productId);
		else
			return NULL;
	}

	public function getProductAmount($orderId) { 
		$query = "SELECT *
				  FROM `orderProduct`
				  WHERE orderId = '$orderId'";		  
		$result = $this->db->query($query)->result();
		
		if (count($result) > 0)
			return count($result);
		else
			return 0;
	}

	public function checkIfExists($orderId, $productId) {
		$query = "SELECT *
				  FROM orderProduct
				  WHERE orderId = '$orderId'
				  AND productId = '$productId'";		  
		$result = $this->db->query($query)->result();
		
		if (count($result) > 0)
			return true;
		else
			return false;		
	}

	public function create($orderId, $productId) {
		$data = array(
						'orderId'		=> $orderId,
						'productId'		=> $productId
					);
		
		if(!$this->checkIfExists($orderId, $productId)) {
			$result = $this->db->insert('orderProduct', $data);
			return $this->db->insert_id();
		}

		return 0;
	}

}