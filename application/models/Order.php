<?php
class Order extends CI_Model {

	public $id;
	public $userId;
	public $status;
	public $total;
	public $createDate;
	public $transactionId;
	public $reference;
	public $payment;

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model(array('orderProduct','user'));
		$this->load->helper(array('date'));
		$this->load->library(array('util'));
	}
	
	public function get($id) {
		$query = "SELECT *
				  FROM `order`
				  WHERE id = '$id'";		  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;		
	}

	public function getAll($userId, $limit = 0) {
		//Inicia os filtros
		$dateFilter = $limitFilter =  "";
		//Verifica se há filtros de datas
		if (isset($_GET['submit']) && $_GET['submit'] == 'submit') {
			if (isset($_GET['dateStart']) && isset($_GET['dateEnd']) && $_GET['dateStart'] != "" && $_GET['dateEnd'] != "") {
				$dateStart = $this->util->dateStringToDate(urldecode($_GET['dateStart'])) . ' 00:00:00';
				$dateEnd = $this->util->dateStringToDate(urldecode($_GET['dateEnd']))  . ' 23:59:59';
				$dateFilter = " AND (createDate BETWEEN '$dateStart' AND '$dateEnd') ";
			}
		}
		//Verifica se há filtros de limite de registros
		if($limit != 0)
			$limitFilter = " LIMIT $limit ";

		$query = "SELECT *
				  FROM `order`
				  WHERE userId = '$userId' "
				  . $dateFilter . 
				  " ORDER BY createDate DESC "
				  . $limitFilter;
		$result = $this->db->query($query)->result();
		if (count($result) > 0) {
			foreach($result as $order)
				$order->productAmount = $this->orderProduct->getProductAmount($order->id);
			return $this->util->getOrderBackgroundColors($result);
		}
		else
			return array();		
	}
	
	public function getAllAbsolute() {
		//Inicia os filtros
		$referenceFilter = $limitFilter =  "";
		//Filtra por referencia
		if(isset($_GET['reference']))
			$referenceFilter = " WHERE reference = '" . $_GET['reference'] . "' ";
		//Verifica se há filtros de limite de registros
		if(isset($_GET['limit']) && $_GET['limit'] != "") {
			$limit = intval($_GET['limit']);
			$limitFilter = " LIMIT $limit ";
		}
		else
			$limitFilter = " LIMIT 100 ";
		//Query de pesquisa
		$query = "SELECT *
				  FROM `order` "
				  . $referenceFilter .
				  " ORDER BY updateDate DESC, createDate DESC"
				  . $limitFilter;
		//Executa a query
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $this->util->getOrderBackgroundColors($result);
		else
			return array();		
	}

	public function getByTransactionID($transactionId) {
		$query = "SELECT *
				  FROM `order`
				  WHERE transactionId = '$transactionId'";		  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;		
	}
	
	public function getByReference($reference) {
		$query = "SELECT *
				  FROM `order`
				  WHERE `order`.`reference` = '$reference'";		  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;		
	}
	
	public function getStatus($id) {
		$query = "SELECT *
				  FROM `order`
				  WHERE id = '$id'";		  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0]->status;
		else
			return NULL;	
	}
	
	public function getStatusByReference($reference) {
		$query = "SELECT *
				  FROM `order`
				  WHERE reference = '$reference'";		  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0]->status;
		else
			return NULL;		
	}

	public function create($order, $userId, $reference) {
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$total = 0;
		foreach ($order as $item)
			$total += $item->value;
		if(count($order) == 1)
			$description = $order[0]->name;
		else
			$description = "Multi Compra - Compre & Ganhe";

		$data = array(
						'userId'		=> $userId,
						'description'	=> $description,
						'status'		=> 'Enviado ao PagSeguro',
						'total'			=> $total,
						'reference'		=> $reference,
						'createDate'	=> $createDate,
						'updateDate'	=> $createDate
					);
				
		$result = $this->db->insert('order', $data);
		$insertedOrderId = $this->db->insert_id();

		if(count($order) == 1 && $order[0]->id == 1)
			$this->user->updatePaymentReference($userId, $reference);

		foreach ($order as $item)
			$this->orderProduct->create($insertedOrderId, $item->id);

		return $insertedOrderId;
	}
	
	public function updateOrder($data) {
		//Pega o horário atual
		$now =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Confere se os campos foram passados pelo PagSeguro
		$status = isset($data['StatusTransacao']) ? $data['StatusTransacao'] : "error";
		$transactionId = isset($data['TransacaoID']) ? $data['TransacaoID'] : "error";
		$reference = isset($data['Referencia']) ? $data['Referencia'] : "error";
		$payment = isset($data['TipoPagamento']) ? $data['TipoPagamento'] : "error";
		//Tenta buscar o pedido na tabela "Order" pela referência passada no início da compra
		$order = $this->getByReference($reference);
		//Se encontra o registro, atualiza aquele registro com os dados do PagSeguro
		if ($order != NULL) {
			$this->db->set('status', $status);
			$this->db->set('updateDate', $now);
			$this->db->set('transactionId', $transactionId);
			$this->db->set('payment', $payment);
			$this->db->where('id', $order->id);
			return $this->db->update('`order`');
		}
		//Se não encontra o registro, retorna nulo para a criação do log apenas
		return NULL;
	}
	
	public function updateStatus($id, $status) {
		//Pega o horário atual
		$now =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		if($id != NULL && $id != 0 && $status != NULL && $status != "") {
			$this->db->set('status', $status);
			$this->db->set('updateDate', $now);
			$this->db->where('id', $id);
			return $this->db->update('`order`');
		}
		return false;
	}

	public function updateTransactionIdCancelled($id) {
		//Pega o horário atual
		$now =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		if($id != NULL && $id != 0) {
			$this->db->set('transactionId', "Pedido cancelado");
			$this->db->set('updateDate', $now);
			$this->db->where('id', $id);
			return $this->db->update('`order`');
		}
		return false;
	}

	public function createLog($orderId, $reference, $transactionId, $oldStatus, $newStatus) {
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$data = array(
						'orderId'		=> $orderId,
						'reference'		=> $reference,
						'transactionId'	=> $transactionId,
						'createDate'	=> $createDate,
						'oldStatus'		=> $oldStatus,
						'newStatus'		=> $newStatus
					);
		return $this->db->insert('orderLog', $data);
	}

	public function getLog($orderId) {
		$query = "SELECT *
				  FROM orderLog
				  WHERE orderId = '$orderId'";		  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		else
			return array();;		
	}

}