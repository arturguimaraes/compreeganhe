<?php
class userPayment extends CI_Model {

	public $fatherId;
	public $sonId;
	public $createDate;

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function getPayment($userId) {
		$query = "SELECT *
				  FROM userPayment
				  WHERE userId = '$userId'";		  
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;
	}

	public function updatePaymentReference($userId, $reference) {
		//Pega a hora atual
		$this->db->set('reference', $reference);
		$this->db->where('userId', $userId);
		return $this->db->update('userPayment');
	}

}