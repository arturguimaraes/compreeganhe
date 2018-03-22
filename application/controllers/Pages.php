<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//Load helpers, models and libraries
		$this->load->helper(array('url', 'form', 'date'));
		$this->load->model(array('user', 'network', 'product', 'order', 'orderProduct', 'transaction', 'tax', 'captcha', 'message'));	
		$this->load->library(array('helper','login', 'export', 'util'));
	}

	//Pega informações do usuário logado
	public function getUserData() {
		//Pega os dados do usuário
		$user = $this->user->getUserData();
		//Pega o primeiro nome do usuário
		$user->names = explode(' ',trim($user->name));
		//Pega a cor da graduação do usuário
		$user->color = $this->util->getGraduationColor($user->graduation);
		//Verifica mensagens
		$user->unreadMessagesCount = $this->message->countUnread($user->id);
		$user->unreadMessages = $user->unreadMessagesCount > 0 ? "<span class=\"unread-messages\">$user->unreadMessagesCount</span>" : "";
		return $user;
	}
	
	//Carrega as páginas com verificação de pagamento e login
	public function load($page = 'home') {
		//Inicia o array de dados da página
		$data = array();
		//Verifica se o usuário está logado e pagou
		if($page != 'home') {
			//Pega os dados do usuário logado
			$data['user'] = $this->getUserData();
			if($page == 'product' || $page == 'purchase') {
				if(!$this->login->checkLogin())
					return;
			}
			//Outras páginas
			else {
				if(!$this->login->checkLoginAndPayment($data))
					return;
			}
		}
		//Seleciona página
		switch($page) {
			case 'home':
				$data = $this->home($data);
				break;
			case 'myaccount':
				$data = $this->myaccount($data);
				break;
			case 'myinfo':
				$data = $this->myinfo($data);
				break;
			case 'mynetwork':
				$data = $this->mynetwork($data);
				break;
			case 'myorders':
				$data = $this->myorders($data);
				break;
			case 'order':
				$data = $this->order($data);
				break;
			case 'mybudget':
				$data = $this->mybudget($data);
				break;
			case 'mynetworksbudget':
				$data = $this->mynetworksbudget($data);
				break;
			case 'shop':
				$data = $this->shop($data);
				break;	
			case 'product':
				$data = $this->product($data);
				break;		
			case 'cart':
				$data = $this->cart($data);
				break;			
			case 'purchase':
				$data = $this->purchase($data);
				break;				
			case 'buy':
				$data = $this->buy($data);
				break;						
			case 'message':
				$data = $this->message($data);
				break;					
			case 'messages':
				$data = $this->messages($data);
				break;					
			case 'sendMessage':
				$data = $this->sendMessage($data);
				break;
			case 'rank':
				$data = $this->rank($data);
				break;			
			case 'password':
				$data = $this->password($data);
				break;		
			case 'withdraw':
				$data = $this->withdraw($data);
				break;
			default:
				$this->helper->loadErrorPage();
				return;
				break;
		}
		//Carrega a página
		$this->helper->loadPage($data);
	}
	
	//Página de Erro
	public function error() {
		//Carrega a página de erro
		$this->helper->loadErrorPage();
	}
	
	//Página Inicial
	public function home($data)	{
		//Informações da Página
		$data['page']['title'] = 'Compre e Ganhe';
		$data['page']['url'] = 'home';
		$data['contactEmail'] = false;
		//Envia E-mail
		if(isset($_POST['submit']))
			$this->helper->sendContactEmail($data, $_POST);
		//Carrega imagens
		$data['carrousel'] = array('url' => '/assets/img/home/home_carrousel_', 'count' => 6, 'extension' => '.jpg');
		$data['images'] = array('url' => '/assets/img/info/info_carrousel_', 'count' => 6, 'extension' => '.jpg');
		return $data;
	}
	
	//Minha Conta
	public function myaccount($data) {
		//Informações da Página
		$data['page']['title'] = 'Minha Conta';
		$data['page']['url'] = 'myaccount';
		//Verifica updates de graduação na rede
		if($this->network->checkUpdate($data['user'])) {
			//Atualiza os dados do usuário logado
			$data['user'] = $this->getUserData();
		}
		return $data;
	}

	//Página de Dados do Usuário
	public function myinfo($data) {
		//Informações da Página
		$data['page']['title'] = 'Meus Dados Cadastrais';
		$data['page']['url'] = 'myinfo';
		//Form submit
		if(isset($_POST['submit'])) {
			if($this->user->update($data['user']->username, $this->util->arrayToObject($_POST))) {
				//Recarrega os dados do usuário logado
				$data['user'] = $this->getUserData();
				$data = $this->helper->sendMessage($data, 'submit', NULL, true, 'Dados alterados com sucesso.');
			}
			else
				$data = $this->helper->sendMessage($data, 'submit', NULL, false, 'Não foi possível alterar os dados.');
		}
		return $data;
	}
	
	//Formulário de Cadastro
	public function signup($code = NULL)	{
		//Verifica se o usuário está logado. Usuários logados NÃO podem acessar esta página
		if($this->user->checkLogin()) {
			redirect('/myaccount');
			return;
		}
		//Verifica se o código do usuário que convidou estão referenciados na URL
		if($code == NULL) {
			if(!isset($_GET['id']) || $_GET['id'] == NULL) {
				redirect('/');
				return;
			}
		}
		else {
			redirect("/signup?id=$code");
			return;
		}
		//Informações da Página
		$data['page']['title'] = 'Cadastrar';
		$data['page']['url'] = 'signup';
		//Verifica se o código existe
		$data['codeExists'] = false;
		$userWithCode = $this->user->getCode($_GET['id']);
		//Se o código existe
		if($userWithCode != NULL) {
			$data['codeExists'] = true;
			$data['user'] = $this->user->getUserDataById($userWithCode->id);
		}
		//Se o código existe
		if($data['codeExists'] && isset($_POST['submit'])) {
			//Gera senha aleatória
			$_POST['password'] = '1234';//$this->util->geraSenha(15, true, true, true);
			//Converte POST para objeto
			$post = $this->util->arrayToObject($_POST);
			//Tenta criar usuário
			$userCreated = $this->user->create($data['user']->id, $post);
			//Sucesso ao criar usuário
			if($userCreated != NULL) {
				//Verifica se atualiza graduação de pais
				$this->network->checkUpdate($userCreated);
				//Inicia sessão
				session_start();
				$_SESSION = array('loggedIn'	=> true,
								  'username'	=> $userCreated->username,
								  'date/time'	=> mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo')));
				$encodedPassword = urlencode($post->password);
				//Redireciona para o login
				redirect("login?username=$userCreated->username&password=$encodedPassword");
				return;
			}
			//Erro ao criar no banco de dados
			else {
				$data = $this->helper->sendMessage($data, 'submit', NULL, false, 'Não foi possível cadastrar o usuário. Tente novamente.');
				//var_dump($_POST);
			}
		}
		//Carrega a página		
		$this->helper->loadPage($data);
		
	}
	
	//Minha Rede
	public function mynetwork($data) {
		//Informações da Página
		$data['page']['title'] = 'Minha Rede';
		$data['page']['url'] = 'mynetwork';
		//Adiciona as informações do próprio usuário no array da rede
		$node = array('user' => $data['user'], 'level' => 'Dono', 'children' => $this->network->getSons($data['user']->id));
		//Pega todos os usuários da rede do usuário logado
		$data['network'] = $this->util->orderArray($this->util->treeToArray(array(), $node));
		//Acha as cores de acordo com a graduação de cada usuário
		foreach($data['network'] as $user)
			$user['user']->color = $this->util->getGraduationColor($user['user']->graduation);
		return $data;
	}

	//Meus Pedidos
	public function myorders($data) {
		//Informações da Página
		$data['page']['title'] = 'Meus Pedidos';
		$data['page']['url'] = 'myorders';
		//Se for filtrado
		if(isset($_POST['filter'])) {
			/*$orderFilter = isset($_GET['order']) && $_GET['order'] != "" ? "&order=" . $_GET['order'] : "";
    		$dateStartFilter = isset($_GET['dateStart']) && $_GET['dateStart'] != "" ? "&dateStart=" . urlencode($_GET['dateStart']) : "";
    		$dateEndFilter = isset($_GET['dateEnd']) && $_GET['dateEnd'] != "" ? "&dateEnd=" . urlencode($_GET['dateEnd']) : "";
    		$dateSubmitFilter = isset($_GET['submit']) && $_GET['submit'] == "submit" ? "&submit=" . $_GET['submit'] : "";
    		redirect("/export?content=myorders" . $orderFilter . $dateStartFilter . $dateEndFilter . $dateSubmitFilter);*/
    		$statusFilter1 = isset($_GET['aprovado']) ? "&aprovado=on" : "";
    		$statusFilter2 = isset($_GET['cancelado']) ? "&cancelado=on" : "";
    		$statusFilter3 = isset($_GET['aguardando']) ? "&aguardando=on" : "";
    		$statusFilter4 = isset($_GET['enviado']) ? "&enviado=on" : "";
    		redirect("/export?content=myorders" . $statusFilter1 . $statusFilter2 . $statusFilter3 . $statusFilter4); 
		}
		//Pega o extrato do usuário logado
		$data['orders'] = $this->util->orderOrderArray($this->order->getAll($data['user']->id));
		return $data;
	}

	//Detalhe do pedido
	public function order($data) {
		//Se o ID não for passado como parâmetro
		if(!isset($_GET['id'])) {
			redirect("/myorders");
			$data['page']['title'] = 'Meus Pedidos';
			$data['page']['url'] = 'myorders';
			return $data;
		}
		//Pega os dados do pedido
		$data['order'] = $this->order->get($_GET['id']);
		//Se encontrar o pedido
		if($data['order'] != NULL) {
			//Informações da Página
			$data['page']['title'] = 'Detalhamento do Pedido';
			$data['page']['url'] = 'order';
			//Atualiza cor do pedido
			$data['order'] = $this->util->getOrderBackgroundColor($data['order']);
			$data['logs'] = $this->order->getLog($_GET['id']);
		}
		//Pedido não encontrado
		else{
			//Informações da Página
			$data['page']['title'] = 'Pedido Não Encontrado';
			$data['page']['url'] = 'order';
		}
		return $data;
	}
	
	//Meu Extrato
	public function mybudget($data) {
		//Informações da Página
		$data['page']['title'] = 'Meu Extrato';
		$data['page']['url'] = 'mybudget';
		//Se for filtrado
		if(isset($_POST['filter'])) {
			$dateStartFilter = isset($_GET['dateStart']) && $_GET['dateStart'] != "" ? "&dateStart=" . urlencode($_GET['dateStart']) : "";
    		$dateEndFilter = isset($_GET['dateEnd']) && $_GET['dateEnd'] != "" ? "&dateEnd=" . urlencode($_GET['dateEnd']) : "";
    		$typeFilter1 = isset($_GET['direta']) ? "&direta=on" : "";
    		$typeFilter2 = isset($_GET['indireta']) ? "&indireta=on" : "";
    		$typeFilter3 = isset($_GET['graduacao']) ? "&graduacao=on" : "";
    		redirect("/export?content=mybudget" . $dateStartFilter . $dateEndFilter . $typeFilter1 . $typeFilter2 . $typeFilter3); 
		}
		//Pega o extrato do usuário logado
		$data['transactions'] = $this->util->orderTransactionArray($this->transaction->getAll($data['user']->id));
		//Calcula o total
		$data['total'] = 0;
		foreach($data['transactions'] as $transaction)
			$data['total'] += $transaction->value;
		return $data;
	}

	//Extrado da Minha Rede
	public function mynetworksbudget($data) {
		//Informações da Página
		$data['page']['title'] = 'Minha Rede';
		$data['page']['url'] = 'mynetworksbudget';
		//Pega os filhos do usuário
		$node = array('user' => $data['user'], 'level' => 'Dono', 'children' => $this->network->getSons($data['user']->id));
		//Monta o array de filhos
		$childrenArray = $this->util->treeToArray(array(), $node);
		//Adiciona os filhos ao array do extrato
		$data['network'] = array();
		foreach($childrenArray as $child) {
			$transactions = $this->transaction->getAll($child['user']->id);
			array_push($data['network'], array("user" => $child, "transactions" => $transactions));
		}
		return $data;
	}

	//Página de listagem de produtos	
	public function shop($data) {
		//Informações da Página
		$data['page']['title'] = 'Catálogo de Itens';
		$data['page']['url'] = 'shop';
		//Pega todos os produtos
		$data['products'] = $this->product->getAll();
		//Exclui o item de cadastro
		foreach ($data['products'] as $key => $product)
			if($product->id == '1')
				unset($data['products'][$key]);
		return $data;
	}
	
	//Página de informação do produto
	public function product($data) {
		//Informações da Página
		$data['page']['title'] = 'Produto Não Encontrado';
		$data['page']['url'] = 'product';
		//Se a ID do produto é fornecida
		if(isset($_GET['id'])) {
			$data['product'] = $this->product->getById($_GET['id']);
			//Comprar item
			if(isset($_GET['buy']) && $_GET['buy']) {
				if(!isset($_SESSION['shoppingCart']))
					$_SESSION['shoppingCart'] = array();
				array_push($_SESSION['shoppingCart'], $data['product']);
				//Caso seja uma compra normal
				if($data['product']->id != 1) {
					redirect('/cart');
				}
				//Caso seja o pagamento da inscrição
				else {
					$_SESSION['shoppingCart'] = array($data['product']);
					redirect('/confirm');
				}
				return;
			}
			//Se o produto é NULO
			if ($data['product'] !=NULL)
				$data['page']['title'] = $data['product']->name;
		}
		return $data;
	}
	
	//Página do carrinho
	public function cart($data) {
		//Informações da Página
		$data['page']['title'] = 'Carrinho';
		$data['page']['url'] = 'cart';
		$data['total'] = 0;
		//Pega o extrato do usuário logado
		$data['orders'] = $this->util->orderOrderArray($this->order->getAll($data['user']->id, 5));
		return $data;
	}
	
	//Esvazia carrinho
	public function emptyCart() {
		if(!$this->login->checkLogin())
			return;
		//Esvazia o carrinho
		$_SESSION['shoppingCart'] = array();
		redirect('/cart');
	}
	
	//Página de confirmação de compra (pedido criado na tabela 'Order')
	public function confirm() {
		//Verifica se o usuário está logado
		if(!$this->login->checkLogin())
			return;
		//Informações da Página
		$data['page']['title'] = 'Pedido Realizado - Status: Enviado ao PagSeguro';
		$data['page']['url'] = 'confirm';
		//Pega os dados do usuário
		$data['user'] = $this->getUserData();
		//Calcula o total
		$total = 0;
		foreach($_SESSION['shoppingCart'] as $item) {
			$total += $item->value;
			//Caso seja inscrição, sinaliza para o navbar
			if($item->id == 1)
				$data['page']['lockedNav'] = true;
		}
		//Gera referencia
		$data['reference'] = 'CG-' . date('dmYHis') . mt_rand();
		$data['status'] = 'Enviado ao PagSeguro';
		//Insere o pedido no banco
		$data['insertedOrderId'] = $this->order->create($_SESSION['shoppingCart'], $data['user']->id, $data['reference']);
		//Se o pedido é inserido com sucesso
		if ($data['insertedOrderId'] != NULL) {
			$data['total'] = $total;
			$description = $data['reference'] . ' registrada com status "' . $data['status'] . '".';
			$this->order->createLog($data['insertedOrderId'], $data['reference'], NULL, "Pedido Registrado", $data['status']);
			//Carrega a página
			$this->helper->loadPage($data);
		}
		else {
			redirect("emptyCart");
		}
	}
	
	//Página de finalização da compra
	public function buy($data) {
		//Informações da Página
		$data['page']['title'] = 'Finalizar Compra';
		$data['page']['url'] = 'buy';
		//Calcula o total
		$total = 0;
		foreach($_SESSION['shoppingCart'] as $item)
			$total += $item->value;
		$data['total'] = $total;
		return $data;
	}
	
	//Página da mensagem
	public function message($data) {
		//Se ID não encontrada, retorna
		if(!isset($_GET['id'])) redirect('messages');
		//Pega a mensagem do usuário
		$data['message'] = $this->message->get($_GET['id']);
		//Se mensagem não encontrada, retorna
		if($data['message'] == NULL) redirect('messages');
		//Informações da Página
		$data['page']['title'] = 'Mensagem de ' . $data['message']->name;
		$data['page']['url'] = 'message';
		$data['permission'] = $data['message']->to == $data['user']->id;
		if(!$data['permission'])
			$data['userTo'] = $this->user->getUserDataById($data['message']->to);
		else
			//Marca a mensagem como lida
			$this->message->markRead($data['message']->messageId);
		return $data;
	}
	
	//Página de mensagens
	public function messages($data) {
		//Informações da Página
		$data['page']['url'] = 'messages';
		if(!isset($_GET['sent'])) {
			$data['sent'] = false;
			//Informações da Página
			$data['page']['title'] = 'Mensagens' . ($data['user']->unreadMessagesCount > 0 ? (" (" . $data['user']->unreadMessagesCount . ")") : "");
			//Pega todas as mensagens do usuário
			$data['messages'] = $this->message->getAll($data['user']->id);
		}
		else {
			$data['sent'] = $_GET['sent'];
			//Informações da Página
			$data['page']['title'] = 'Mensagens Enviadas';
			//Pega todas as mensagens do usuário
			$data['messages'] = $this->message->getAllSent($data['user']->id);
		}
		return $data;
	}
	
	//Enviar mensagem
	public function sendMessage($data) {
		//Informações da Página
		$data['page']['title'] = 'Enviar Mensagem';
		$data['page']['url'] = 'sendMessage';
		if(isset($_POST['submit'])) {
			$post = $this->util->arrayToObject($_POST);
			if($this->message->create($data['user']->id, $post->to, $post->message))
				$data['page']['url'] = 'messageConfirm';
			else
				$data = $this->helper->sendMessage($data, 'message', NULL, false, 'Não foi possível enviar a mensage. Tente novamente.');
		}
		if(!isset($_GET['id']) || $_GET['id'] == "" || $_GET['id'] == 0)
			$data['direct'] = false;
		else {
			$data['userTo'] = $this->user->getUserDataById($_GET['id']);
			if($data['userTo'] == NULL) redirect('messages');
			else
				$data['direct'] = true;
		}
		if(!$data['direct']) {
			//Adiciona as informações do próprio usuário no array da rede
			$node = array('user' => $data['user'], 'level' => 'Dono', 'children' => $this->network->getSons($data['user']->id));
			//Pega todos os usuários da rede do usuário logado
			$network = $this->util->treeToArray(array(), $node);
			//Pega o pai do usuário
			$father = $this->network->getFather($data['user']->id);
			if($father != NULL) {
				array_push($network, array('user' => $father));
				//Pega o avô do usuário
				$grandFather = $this->network->getFather($father->id);
				if($grandFather != NULL)
					array_push($network, array('user' => $grandFather));
			}
			//Organiza a rede por nome
			$data['network'] = $this->util->orderOrderArrayByName($network);
			//Salva ID do dono da rede
			$data['onwner'] = $data['user']->id;
		}
		return $data;
	}
	
	//Apagar mensagem
	public function deleteMessage() {
		if(!$this->login->checkLoginAndPayment(array()))
			redirect('messages');
		//Se ID não encontrada, retorna
		if(!isset($_GET['id']))
			redirect('messages');
		//Apaga a mensagem do usuário
		$this->message->delete($_GET['id'], $this->user->getUserData()->id);
		redirect('messages');
	}
	
	//Apagar todas as mensagens
	public function deleteAllMessages() {
		if(!$this->login->checkLoginAndPayment(array()))
			redirect('messages');
		//Apaga a mensagem do usuário
		$this->message->deleteAll($this->user->getUserData()->id);
		redirect('messages');
	}

	//Página da graduação
	public function rank($data) {
		//Informações da Página
		$data['page']['title'] = 'Graduação';
		$data['page']['url'] = 'rank';
		$data['user']->countAll 		= $this->network->countLevel($this->network->getSons($data['user']->id));
		$data['user']->countPaid 		= $this->network->countLevel($this->network->getSonsPaid($data['user']->id));
		$data['user']->countNotPaid 	= $this->network->countLevel($this->network->getSonsNotPaid($data['user']->id));
		$data['user']->countBegginners 	= $this->network->countLevel($this->network->getSonsGraduation($data['user']->id, 'INICIANTE'));
		$data['user']->countBronze 		= $this->network->countLevel($this->network->getSonsGraduation($data['user']->id, 'BRONZE'));
		$data['user']->countSilver 		= $this->network->countLevel($this->network->getSonsGraduation($data['user']->id, 'PRATA'));
		$data['user']->countGold 		= $this->network->countLevel($this->network->getSonsGraduation($data['user']->id, 'OURO'));
		$data['user']->countDiamond		= $this->network->countLevel($this->network->getSonsGraduation($data['user']->id, 'DIAMANTE'));
		return $data;
	}

	//Página da mudança de senha
	public function password($data) {
		//Informações da Página
		$data['page']['title'] = 'Mudar a Senha';
		$data['page']['url'] = 'password';
		if(isset($_POST['submit'])) {
			//Password is the same
			if ($_POST['oldPassword'] == $_POST['newPassword'])
				$data = $this->helper->sendMessage($data, 'password', NULL, false, 'A nova senha não pode ser igual à atual.');
			//Password not match
			else if ($_POST['newPassword'] != $_POST['newPasswordRepeat'])
				$data = $this->helper->sendMessage($data, 'password', NULL, false, 'A senha e repetição de senha devem ser idênticas.');
			//Password incorrect
			else if (!$this->user->login($_SESSION['username'], $_POST['oldPassword']))
				$data = $this->helper->sendMessage($data, 'password', NULL, false, 'Senha atual está incorreta.');
			//Success
			else {
				if($this->user->updatePassword($_SESSION['username'], $_POST['newPassword'])) {
					$data = $this->helper->sendMessage($data, 'password', NULL, true, 'Sua senha foi trocada com sucesso!');	
					$this->helper->sendChangePasswordEmail($data['user'], $_POST['newPassword']);
				}
				else
					$data = $this->helper->sendMessage($data, 'password', NULL, false, 'Ocorreu um erro. Tente novamente.');
			}
		}
		return $data;
	}

	//Página e saque
	public function withdraw($data) {
		//Informações da Página
		$data['page']['title'] = 'Saque';
		$data['page']['url'] = 'withdraw';
		return $data;
	}
	
	//Export Function
	public function export() {
		$this->export->export();
	}
	
	//Retorno do PagSeguro (POST)
	/************* PARÂMETROS ************
	PagSeguro 		-> Compre & Ganhe
	StatusTransacao -> order.status
	TransacaoID 	-> order.transactionId
	Referencia		-> order.reference
	TipoPagamento	-> order.payment
	*************************************/
	public function updateOrder() {
		$response = array("response" => array(),
						  "errors" => array());
		//Atualiza a tabela
		if(isset($_POST['TransacaoID']) && $_POST['TransacaoID'] != "") {
			$oldStatus = isset($_POST['Referencia']) ? $this->order->getStatusByReference($_POST['Referencia']) : "";
			//Pedido atualizado com sucesso
			if($this->order->updateOrder($_POST)) {
				$data['order'] = isset($_POST['Referencia']) ? $this->order->getByReference($_POST['Referencia']) : NULL;
				$reference = isset($_POST['Referencia']) ? $_POST['Referencia'] : 'REF000000000000';
				//Success
				if($data['order'] != NULL) {
					//Pega novo status
					$newStatus = $_POST['StatusTransacao'];
					//Verifica se precisa atualizar o status de pagamento do usuário e graduação da rede
					if($this->orderProduct->getProductId($data['order']->id) == 1 && ($newStatus == 'Aprovado' || $newStatus == 'Aprovada')) {
						$this->user->updatePaymentDate($data['order']->userId);
						$this->network->checkUpdateById($data['order']->userId);
					}
					//Cria descrição para as transações
					$description = $reference . ' mudou de  "' . $oldStatus  . '" para  "' . $newStatus . '".';
					//Registra no log do pedido
					$this->order->createLog($data['order']->id, $reference, $_POST['TransacaoID'], $oldStatus, $newStatus);
					//Verifica se faz transações
					if($this->transaction->check($data['order'])) {
						array_push($response['response'],
								   array("message"		=> $description,
								   		 "reference"	=> $reference,
								   		 "oldStatus"	=> $oldStatus,
								   		 "newStatus"	=> $newStatus,
								   		 "order"		=> $data['order']));
					}
					//Não conseguiu fazer transação
					else {
						array_push($response['errors'],array("A transacao nao foi feita."));
					}
					//Se foi escolhido o método de pagamento com o saldo
					if(isset($_POST['return']) && $_POST['return'] == "true") {
						//Atualiza saldo do usuário
						$this->user->updateBalance($data['order']->userId, ($data['order']->total)*-1);
						$transactionData = array("orderId" 	=> $data['order']->id,
												 "userId" 	=> $data['order']->userId,
												 "value" 	=> ($data['order']->total)*-1,
												 "action" 	=> "Compra utilizando saldo"
												);
						$this->transaction->create($transactionData);
					}
				}
				//Não encontra pedido
				else {
					$this->order->createLog(0, $reference, $_POST['TransacaoID'], $oldStatus, $newStatus);
					array_push($response['errors'],array("Pedido nao encontrado no banco de dados."));
				}
			}
			//Error
			else
				array_push($response['errors'],array("Falha ao atualizar o pedido no banco de dados."));	
		}
		//Error
		else
			array_push($response['errors'],array("Campo 'TransacaoID' nao passado na requisicao."));
		//Se foi escolhido o método de pagamento com o saldo
		if(isset($_POST['return']) && $_POST['return'] == "true")
			if($data['order'] != NULL)
				redirect("/purchase?reference=" . $data['order']->reference);
		//Se veio do PagSeguro
		else 
			echo json_encode($response);
	}
	
	//Retorno do PagSeguro
	//Parâmetro: transaction_id
	public function purchase() {
		if(isset($_GET['transaction_id'])) {
			//Espera 2 segundos para receber a transação do PagSeguro
			sleep(2);
			//Esvazia o carrinho
			$_SESSION['shoppingCart'] = array();
			//Busca o pedido no sistema
			$order = $this->order->getByTransactionID($_GET['transaction_id']);
			if($order != NULL) {
				redirect("/order?id=$order->id");
				return;
			}
		}
		else if(isset($_GET['reference'])) {
			//Esvazia o carrinho
			$_SESSION['shoppingCart'] = array();
			//Busca o pedido no sistema
			$order = $this->order->getByReference($_GET['reference']);
			if($order != NULL) {
				redirect("/order?id=$order->id");
				return;
			}
		}
		redirect('/myaccount');
	}
	
	//LOGIN PAGE
	public function login() {			
		//Informações da Página
		$data['page']['title'] = 'Compre & Ganhe - Entrar';
		$data['page']['url'] = 'login';
		if(isset($_POST['submit'])) {
			//Captcha validation
			if(!$this->captcha->validate($_POST['captcha']))
				$data = $this->helper->sendMessage($data, 'captcha', NULL, false, 'Você deve digitar a palavra exatamente como está na imagem.');
			//Username incorrect
			else if(!$this->user->existsByUsername($_POST['username']))
				$data = $this->helper->sendMessage($data, 'login', NULL, false, 'Usuário inexistente.');
			//Password incorrect
			else if (!$this->user->login($_POST['username'], $_POST['password']))
				$data = $this->helper->sendMessage($data, 'login', NULL, false, 'Senha incorreta.');
			//Success
			else  {
				if(isset($_SESSION)) {
					$_SESSION['loggedIn'] = true;
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['date/time'] = mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
				}
				else {
					$_SESSION = array('loggedIn'	=> true,
								  'username'	=> $_POST['username'],
								  'date/time'	=> mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo')));	
				}
				$username = $_POST['username'];
				$password = urlencode($_POST['password']);
				redirect("login?username=$username&password=$password");
				return;
			}
		}
		//Erro de login duplo
		if(isset($_GET['username']) && isset($_GET['password'])) {
			//Username check and password
			if($this->user->existsByUsername($_GET['username']) && $this->user->login($_GET['username'], urldecode($_GET['password']))) {
				if(isset($_SESSION)) {
					$_SESSION['loggedIn'] = true;
					$_SESSION['username'] = $_GET['username'];
					$_SESSION['date/time'] = mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
				}
				else {
					$_SESSION = array('loggedIn'	=> true,
								  'username'	=> $_GET['username'],
								  'date/time'	=> mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo')));	
				}
				redirect('myaccount');
				return;
			}
		}
		//Stores captcha info in page
		$data['captcha'] = $this->captcha->create();
		//Carrega a página
		$this->helper->loadPage($data);
	}
	
	//LOGOUT FUNCTION
	public function logout() {
		if(isset($_COOKIE[session_name()]))
			setcookie(session_name(), '', time()-300, '/');
		session_destroy();
		redirect(base_url());
		return;
	}
	
}