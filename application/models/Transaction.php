<?php
class Transaction extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('date'));
		$this->load->model(array('order','orderProduct','network','tax','user'));
	}

	public function get($id) {
		$query = "SELECT *
				  FROM transaction
				  WHERE id = '$id'";
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;		
	}

	public function getAll($userId) {
		$query = "SELECT *
				  FROM transaction
				  WHERE userId = $userId";
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		else
			return array();		
	}
	
	public function getByUserId($userId) {
		$query = "SELECT *
				  FROM transaction
				  WHERE userId = '$userId'";
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		else
			return array();		
	}

	public function getByOrderId($orderId) {
		$query = "SELECT *
				  FROM transaction
				  WHERE orderId = '$orderId'";
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;		
	}

	public function existsByOrderId($orderId) {
		$query = "SELECT *
				  FROM transaction
				  WHERE orderId = '$orderId'";
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return true;
		else
			return false;
	}

	public function existsByGraduation($userId, $graduation) {
		$query = "SELECT *
				  FROM transaction
				  WHERE userId = '$userId'
				  AND action like '%$graduation%'";
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return true;
		else
			return false;
	}

	public function create($data) {
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$data = array(
						'orderId'		=> $data['orderId'],
						'userId'		=> $data['userId'],
						'value'			=> $data['value'],
						'action'		=> $data['action'],
						'createDate' 	=> $createDate
					);
		$result = $this->db->insert('transaction', $data);
		return $this->db->insert_id();
	}

	public function makeTransaction($order, $userId, $oldValue, $firstUserId, $level) {
		if($level < 4) {
			//Pega o indicador
			$father = $this->network->getFather($userId);
			//Se for compra de inscrição
			if($this->orderProduct->getProductId($order->id) == 1)
				$taxes = array('DIRETO PRIMEIRA','INDIRETO 1 PRIMEIRA', 'INDIRETO 2 PRIMEIRA', 'INDIRETO 3 PRIMEIRA');
			//Outras compras
			else
				$taxes = array('DIRETO OUTRAS','INDIRETO 1 OUTRAS', 'INDIRETO 2 OUTRAS', 'INDIRETO 3 OUTRAS');
			$taxesNames = array('DIRETO','INDIRETO 1', 'INDIRETO 2', 'INDIRETO 3');
			$tax = $this->tax->getByName($taxes[$level]);
			$newValue = $oldValue * ($tax->percentage/100);
			//Se a taxa é relativa
			if(boolval($tax->relative))
				 $transactionValue = $newValue;
			//Se é valor fixo
			else
				$transactionValue = $tax->value;
			if($father != NULL) {
				//Pega usuários
				$user = $this->user->getUserDataById($userId);
				$firstUser = $this->user->getUserDataById($firstUserId);
				//Verifica ganhos NÍVEL 2
				if($taxesNames[$level] == 'INDIRETO 1') {
					if($father->graduation == 'INICIANTE')
						return true;
				}
				//Verifica ganhos NÍVEL 3
				if($taxesNames[$level] == 'INDIRETO 2') {
					if($father->graduation == 'INICIANTE' || $father->graduation == 'BRONZE')
						return true;
				}
				//Verifica ganhos NÍVEL 4
				if($taxesNames[$level] == 'INDIRETO 3') {
					if($father->graduation == 'INICIANTE' || $father->graduation == 'BRONZE' || $father->graduation == 'PRATA')
						return true;
				}
				//$firstUser->names = explode(' ',trim($data['user']->name));
				$description = "$firstUser->name ($taxesNames[$level]): $order->description";
				$data = array(
								'orderId'		=> $order->id,
								'userId'		=> $father->id,
								'value'			=> $transactionValue,
								'action'		=> $description
							);
				$success = $this->create($data);
				if($success != NULL && $success != 0) {
					//Verifica ganhos DIAMANTE para recompra NÍVEL 2 e NÍVEL 3
					if($father->graduation == 'DIAMANTE') {
						if($taxes[$level] == 'INDIRETO 1 OUTRAS' || $taxes[$level] == 'INDIRETO 2 OUTRAS') {
							$data = array(
											'orderId'		=> 0,
											'userId'		=> $father->id,
											'value'			=> 0.5,
											'action'		=> "Bônus nível DIAMANTE: Recompra de $firstUser->name ($taxesNames[$level])"
							);
							$this->create($data);
							$this->user->updateBalance($father->id, 0.5);
						}
					}
					//Faz a transação no pai
					$this->makeTransaction($order, $father->id, $newValue, $firstUserId, $level+1);
					$this->user->updateBalance($father->id, $transactionValue);
					return true;
				}
			}
		}
		return false;
	}

	public function check($order) {
		//Se já este pedido já teve uma transação, não faz nada
		if($this->existsByOrderId($order->id))
			return false;
		//Se não acha o pedido, não faz nada
		if($order == NULL)
			return false;
		//Se o pedido não for aprovado, não faz nada
		if($order->status == 'Aprovado' || $order->status == 'Aprovada')
			return $this->makeTransaction($order, $order->userId, $order->total, $order->userId, 0);
		return false;
	}

}