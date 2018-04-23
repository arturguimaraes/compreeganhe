<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login {

	protected $CI;

	public function __construct() {
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
		$this->CI->load->model(array('user','order'));	
		$this->CI->load->library(array('helper'));
	}	
	
	//Checks login and payment
	public function checkLoginAndPayment($data) {
		//Verifica se o usuário está logado
		if(!$this->CI->user->checkLogin()) {
			redirect('/login');
			return false;
		}
		
		//Coleta os dados do usuário
		$user = $this->CI->user->getUserData();
		
		//Verifica se o usuário fez o pedido do pagamento
		if(!$this->CI->user->checkPayment($user->id)) {
			$this->notAllowed($data);
			return false;
		}
		
		//Verifica se há pedidos na base
		$orders = $this->CI->order->getAll($user->id);
		//Se tiver pedidos duplicados
		if(count($orders) > 1) {
			foreach($orders as $orderDup) {
				if(strpos($orderDup->description, "Inscrição") !== false && $orderDup->transactionId == NULL && $orderDup->status == "Enviado ao PagSeguro") {
					$this->CI->order->updateStatus($orderDup->id,"Cancelado");
					$this->CI->order->updateTransactionIdCancelled($orderDup->id);
				}
			}
		}

		//Pega pedido na base
		$order = $this->CI->user->checkPaymentCleared($user->id);
		//Não encontrou o pedido
		if($order == NULL) {
			$this->notAllowed($data);
			return false;
		}

		//Se o pedido tiver sido cancelado
		if($order->status == 'Cancelado' && $order->status != 'Cancelada') {
			$this->paymentCanceled($data, $order);
			return false;
		}
		

		//var_dump($order);

		//Se o pedido não tiver sido aprovado ainda
		if($order->status != 'Aprovado' && $order->status != 'Aprovada') {
			$this->paymentNotCleared($data, $order);
			return false;
		}

		//Verifica se é a primeira vez do usuário desde que seu pagamento foi aprovado
		if($this->CI->user->checkFirstTime($user->id)) {
			$this->firstTime($data, $user->id);
			return false;
		}
		
		return true;
	}
	
	//Checks login only
	public function checkLogin() {
		//Verifica se o usuário está logado
		if(!$this->CI->user->checkLogin()) {
			redirect('/login');
			return false;
		}
		return true;
	}
	
	//Usuário não fez pedido de pagamento ainda
	public function notAllowed($data) {
		//Verifica se o usuário está logado
		if(!$this->CI->user->checkLogin()) {
			redirect('/login');
			return;
		}		
		//Page info
		$data['page']['title'] = 'Finalize Sua Inscrição';
		$data['page']['url'] = 'notAllowed';
		$data['page']['lockedNav'] = true;
		$this->CI->helper->loadPage($data);
	}

	//Pagamento cancelado
	public function paymentCanceled($data, $order = NULL) {
		//Verifica se o usuário está logado
		if(!$this->CI->user->checkLogin()) {
			//$this->login();
			redirect('/login');
			return;
		}		
		//Page Info
		$data['page']['title'] = 'Pagamento Cancelado';
		$data['page']['url'] = 'paymentCanceled';
		$data['page']['lockedNav'] = true;
		$data['order'] = $order;
		$this->CI->helper->loadPage($data);
	}
	
	//Pagamento não autorizado ainda
	public function paymentNotCleared($data, $order = NULL) {
		//Verifica se o usuário está logado
		if(!$this->CI->user->checkLogin()) {
			//$this->login();
			redirect('/login');
			return;
		}		
		//Page Info
		$data['page']['title'] = 'Pagamento Não Autorizado';
		$data['page']['url'] = 'paymentNotCleared';
		$data['page']['lockedNav'] = true;
		$data['order'] = $order;
		$this->CI->helper->loadPage($data);
	}

	//After payment cleared, user's first time log in
	public function firstTime($data, $userId) {
		//Verifica se o usuário está logado
		if(!$this->CI->user->checkLogin()) {
			//$this->login();
			redirect('/login');
			return;
		}
		
		//Page Info
		$data['page']['title'] = 'Pagamento Aprovado';
		$data['page']['url'] = 'firstTime';
		$this->CI->user->updateFirstTime($userId);
		$this->CI->helper->loadPage($data);
	}
		
}