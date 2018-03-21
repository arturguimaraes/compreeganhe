<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array('product','tax','adminModel','order','transaction','orderProduct','user','message'));
		$this->load->helper(array('url'));
		$this->load->library(array('helper','util'));
	}

	public function load($page = 'admin', $data) {
		$this->load->view('templates/adminHeader', $data);
		$this->load->view('admin/' . $page, $data);
		$this->load->view('templates/adminFooter', $data);
	}

	public function index()	{
		//Verificar Login
		if(!$this->adminModel->checkLogin()) {
			redirect('adminLogin');
			return;
		}
		//Informações da página
		$data['page']['title'] = "Compre & Ganhe - Administração - Carrossel";
		$data['carrousel'] = array('url' => 'assets/img/home/home_carrousel_',
											'count' => 6,
											'extension' => '.jpg');
		for($i=1; $i <= $data['carrousel']['count']; $i++) {
			if(isset($_POST["sendImageCarousel$i"])) {
				$postdata = file_get_contents($_FILES["imageCarousel$i"]['tmp_name']);
				if (isset($postdata) && strlen($postdata)>0) {
					$target = $data['carrousel']['url'] . $i . $data['carrousel']['extension'];
					$handle = fopen($target, "w+");
					fwrite($handle, $postdata);
					fclose($handle);
					redirect('/admin');
				}
			}
		}			
		$this->load('admin', $data);
	}
	
	public function sobre()	{
		//Verificar Login
		if(!$this->adminModel->checkLogin()) {
			redirect('adminLogin');
			return;
		}
		//Informações da página
		$data['page']['title'] = "Compre & Ganhe - Administração - Como Funciona?";
		$data['images'] = array('url' => 'assets/img/info/info_carrousel_',
										 'count' => 6,
										 'extension' => '.jpg');
		for($i=1; $i <= $data['images']['count']; $i++) {
			if(isset($_POST["sendImageSobre$i"])) {
				$postdata = file_get_contents($_FILES["imageSobre$i"]['tmp_name']);
				if (isset($postdata) && strlen($postdata)>0) {
					$target = $data['images']['url'] . $i . $data['images']['extension'];
					$handle = fopen($target, "w+");
					fwrite($handle, $postdata);
					fclose($handle);
					redirect('/adminSobre');
				}
			}
		}
		$this->load('about', $data);
	}
	
	public function taxas()	{
		//Verificar Login
		if(!$this->adminModel->checkLogin()) {
			redirect('adminLogin');
			return;
		}		
		//Informações da página
		$data['page']['title'] = "Compre & Ganhe - Administração - Taxas";
		$data['taxes'] = $this->tax->getAll();
		foreach($data['taxes'] as $tax) {
			$tax->percentage = number_format($tax->percentage, 0);
			$value = number_format($tax->value, 2, '.', '');
			$tax->cents = substr($value, -2);
			$tax->value = floor($value);
			//Verifica se foi alterado
			if(isset($_POST['submit' . $tax->id])) {
				$this->tax->update($tax->id,
								   $_POST['percentage' . $tax->id],
								   $_POST['value' . $tax->id] . '.' . $_POST['cents' . $tax->id],
								   isset($_POST['relative' . $tax->id]));
				redirect('adminTaxas');
				return;
			}
		}
		$this->load('taxes', $data);
	}
	
	public function precos()	{
		//Verificar Login
		if(!$this->adminModel->checkLogin()) {
			redirect('adminLogin');
			return;
		}		
		//Informações da página
		$data['page']['title'] = "Compre & Ganhe - Administração - Preços";
		$data['products'] = $this->product->getAll();
		foreach($data['products'] as $product) {
			$value = number_format($product->value, 2, '.', '');
			$product->cents = substr($value, -2);
			$product->value = floor($value);
		}
		$change = false;
		//Verifica se os produtos foram alterados
		foreach($data['products'] as $product) {
			if(isset($_POST['sendProductValue' . $product->id])) {
				$this->product->update($product->id,
									   $_POST['productName' . $product->id],
									   $_POST['productDescription' . $product->id],
									   $_POST['productValue' . $product->id] . '.' . $_POST['productCents' . $product->id]);
				redirect('adminPrecos');
				return;
			}
			if(isset($_POST['removeProduct' . $product->id])) {
				$this->product->delete($product->id);
				redirect('adminPrecos');
				return;
			}
		}
		$this->load('prices', $data);
	}

	public function add()	{
		//Verificar Login
		if(!$this->adminModel->checkLogin()) {
			redirect('adminLogin');
			return;
		}		
		//Informações da página
		$data['page']['title'] = "Compre & Ganhe - Administração - Adicionar Produto";
		if(isset($_POST['submit'])) {
			$this->product->create($_POST['name'],$_POST['description'],$_POST['value'] . '.' . $_POST['cents']);
			redirect('/adminTaxas');
			return;
		}
		$this->load('add', $data);
	}
	

	//Função de updade de pedidos
	public function orders()	{
		//Verificar Login
		if(!$this->adminModel->checkLogin()) {
			redirect('adminLogin');
			return;
		}
		//Atualiza status
		if(isset($_GET['id']) && isset($_GET['status'])) {
			$order = $this->order->get($_GET['id']);
			if($order != NULL) {
				$oldStatus = $this->order->getStatus($order->id);
				$newStatus = $_GET['status'];
				//Muda o status na tabela 'order'
				$this->order->updateStatus($order->id, $newStatus);
				//Cria um log da mudança
				$this->order->createLog($order->id, $order->reference, $order->transactionId, $oldStatus, $newStatus);
				$order->status = $newStatus;
				//Verifica se precisa atualizar o status de pagamento do usuário e graduação da rede
				if($this->orderProduct->getProductId($order->id) == 1 && ($newStatus == 'Aprovado' || $newStatus == 'Aprovada')) {
					$this->user->updatePaymentDate($order->userId);
					$this->network->checkUpdateById($data['order']->userId);
				}
				//Verifica se é necessária uma transação para a mudança
				$this->transaction->check($order);
				redirect('adminOrders?limit=100');
				return;
			}
		}
		//Informações da página
		$data['page']['title'] = "Compre & Ganhe - Administração - Gerenciar Pedidos";
		//Pega todos os pedidos do banco
		$data['orders'] = $this->order->getAllAbsolute();
		//Pega os usuários de cada pedido
		foreach($data['orders'] as $order)
			$order->user = $this->user->getUserDataById($order->userId);
		$this->load('orders', $data);
	}

	//Função de updade de usuários
	public function users()	{
		//Verificar Login
		if(!$this->adminModel->checkLogin()) {
			redirect('adminLogin');
			return;
		}
		//Atualiza Graduação
		if(isset($_GET['id']) && isset($_GET['graduation'])) {
			$user = $this->user->getUserDataById($_GET['id']);
			if($user != NULL) {
				$graduation = $_GET['graduation'];
				//Muda a graduação
				$this->user->updateGraduation($user->id, $graduation);
				//Verifica se precisa atualizar o status de pagamento do usuário e graduação da rede
				$this->network->checkUpdateById($user->id);
				redirect('adminUsers?limit=100');
				return;
			}
		}
		//Informações da página
		$data['page']['title'] = "Compre & Ganhe - Administração - Gerenciar Usuários";
		//Pega todos os pedidos do banco
		$data['users'] = $this->user->getAll();
		foreach($data['users'] as $user) {
			$user->color = $this->util->getGraduationColor($user->graduation);
			$user->father = $this->network->getFather($user->id) != NULL ? $this->network->getFather($user->id)->username : "";
			$user->firstName = explode(' ',trim($user->name))[0];
		}
		$this->load('users', $data);
	}

	//Função de envio de mensagem de usuários
	public function messages()	{
		//Verificar Login
		if(!$this->adminModel->checkLogin()) {
			redirect('adminLogin');
			return;
		}
		//Informações da página
		$data['page']['title'] = "Compre & Ganhe - Administração - Enviar Mensagens aos Usuários";
		//Envia mensagem
		if(isset($_POST['submit'])) {
			if($this->message->sendToAll($_POST['message']))
				$data = $this->helper->sendMessage($data, 'message', NULL, true, 'Mensagem enviada com sucesso.');
			else
				$data = $this->helper->sendMessage($data, 'message', NULL, false, 'Erro ao enviar mensagem.');
		}
		$this->load('messages', $data);
	}
	
	public function login() {			
		//Informações da Página
		$data['page']['title'] = 'Compre & Ganhe - Administração - Entrar';
		if(isset($_POST['submit'])) {
			//Username incorrect
			if(!$this->adminModel->exists($_POST['username']))
				$data = $this->helper->sendMessage($data, 'login', NULL, false, 'Usuário inexistente.');
			//Password incorrect
			else if (!$this->adminModel->login($_POST['username'], $_POST['password']))
				$data = $this->helper->sendMessage($data, 'login', NULL, false, 'Senha incorreta.');
			//Success
			else  {
				if(isset($_SESSION)) {
					$_SESSION['loggedInAdmin'] = true;
					$_SESSION['usernameAdmin'] = $_POST['username'];
					$_SESSION['dateTimeAdmin'] = mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
				}
				else {
					$_SESSION = array('loggedInAdmin'	=> true,
								  'usernameAdmin'	=> $_POST['username'],
								  'dateTimeAdmin'	=> mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo')));	
				}
				$username = $_POST['username'];
				$password = $_POST['password'];
				redirect("adminLogin?username=$username&password=$password");
				return;
			}
		}
		//Erro de login duplo
		if(isset($_GET['username']) && isset($_GET['password'])) {
			//Username incorrect
			if(!$this->adminModel->exists($_GET['username']))
				$data = $this->helper->sendMessage($data, 'login', NULL, false, 'Usuário inexistente.');
			//Password incorrect
			else if (!$this->adminModel->login($_GET['username'], $_GET['password']))
				$data = $this->helper->sendMessage($data, 'login', NULL, false, 'Senha incorreta.');
			//Success
			else  {
				if(isset($_SESSION)) {
					$_SESSION['loggedInAdmin'] = true;
					$_SESSION['usernameAdmin'] = $_GET['username'];
					$_SESSION['dateTimeAdmin'] = mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
				}
				else {
					$_SESSION = array('loggedInAdmin'	=> true,
								  'usernameAdmin'	=> $_GET['username'],
								  'dateTimeAdmin'	=> mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo')));	
				}
				redirect('admin');
				return;
			}
		}
		//Carrega a página
		$this->load('login', $data);
	}

}