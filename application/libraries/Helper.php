<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {

	protected $CI;

	public function __construct() {
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
	}
	
	//Loads pages with templates
	public function loadPage($data) {
		//Loads header
		$this->CI->load->view('templates/header', $data);

		//Loads navbar
		if($data['page']['url'] != 'home' && $data['page']['url'] != 'login')
			$this->CI->load->view('templates/navbar', $data);	
		
		//Loads page
		$this->CI->load->view('pages/' . $data['page']['url'], $data);
		$this->CI->load->view('templates/footer', $data);
	}

	//Loads error page
	public function loadErrorPage($data = NULL) {
		if($data = NULL)
			$data = array();
		$data['page']['title'] = 'Página não encontrada';
		$data['heading'] = "Página não encontrada";
		$data['message'] = "A página desejada não foi encontrada.<br>Por favor, retorne à página inicial clicando <a href='" . base_url() . "myaccount'>aqui</a>.";
		$this->CI->load->view('templates/header', $data);
		//$this->CI->load->view('templates/navbar', $data);
		$this->CI->load->view('errors/cli/error_general', $data);
		$this->CI->load->view('templates/footer', $data);
	}
	
	//Loads database error page
	public function loadDatabaseErrorPage($data = NULL) {
		if($data = NULL)
			$data = array();
		$data['page']['title'] = 'Erro';
		$this->CI->load->view('templates/header', $data);
		//$this->CI->load->view('templates/navbar', $data);
		$this->CI->load->view('errors/cli/error_database', $data);
		$this->CI->load->view('templates/footer', $data);
	}

	//Envia mensagem para a página
	public function sendMessage($data, $id, $label, $success, $customizedMessage = NULL) {
		$messageClass = $success ? 'text-green' : 'text-red';
		if ($customizedMessage == NULL)
			$message = $success ? $label . ' atualizado!' : '*' . $label . ' é necessário.';
		else
			$message = $customizedMessage;		
		$data['messages'][$id] = array('message' 		=> $message,
									   'messageClass'	=> $messageClass);		   
		return $data;
	}

	//Função básica de envio de e-mails
	public function sendEmail($to, $subject, $message) {
		$headers = 'From: no-reply@compreeganhe.net' . "\r\n" .
				   'Reply-To: no-reply@compreeganhe.net' . "\r\n" .
				   'Content-Type: text/html; charset=UTF-8' . "\r\n" .
				   'X-Mailer: PHP/' . phpversion();
		return mail($to, $subject, $message, $headers);
	}

	//Envia e-mail de contato da página HOME
	public function sendContactEmail($data, $post) {
		$to      = 'josimarsigt@gmail.com';
		//$to      = 'arturguimaraes92@hotmail.com'; //Teste
		$subject = 'CONTATO - COMPRE & GANHE: Usuário deseja entrar para rede!';
		$message = "<b>" . $post['nome'] . "</b> entrou em contato pelo site do Compre & Ganhe.<br><br>" .
				   "Favor retornar com o representante mais próximo.<br><br><br>" . 
				   "<b>Nome:</b> " . $post['nome'] . "<br>" . 
				   "<b>E-mail:</b> " . $post['email'] . "<br>" . 
				   "<b>Whatsapp:</b> " . $post['telefone'] . "<br><br>" .
				   "Atenciosamente,<br><br><a href='http://www.compreeganhe.net'>Compre & Ganhe</a>";
		$data['contactEmail'] = $this->sendEmail($to, $subject, $message);
	}
	
	//Envia e-mail de confirmação de cadastro
	public function sendSignUpEmail($name, $username, $password, $email) {
		$to = $email;
		$subject = 'CADASTRO - COMPRE & GANHE: Você se cadastrou no Compre & Ganhe! Finalize sua inscrição!';
		$message = "Parabéns <b>" . $name . "</b>!<br><br>" .
				   "Você realizou o cadastro no nosso sistema.<br>Seus dados:<br><br><br>" . 
				   "<b>Usuário:</b> " . $username . "<br>" . 
				   "<b>Senha:</b> " . $password . "<br><br><br>" .
				   "Este e-mail é confidencial! Não repasse essa senha para terceiros.<br><br>" .
				   'Agora falta apenas realizar o pagamento da sua inscrição, clicando <a href="http://www.compreeganhe.net/product?id=1">aqui</a>.<br><br>' .
				   "Não perca tempo! Finalize sua inscrição em breve para poder usufruir dos lucros montando sua própria rede!<br><br><br>" . 
				   "Atenciosamente,<br><br><a href='http://www.compreeganhe.net'>Compre & Ganhe</a>";
		return $this->sendEmail($to, $subject, $message);
	}

	//Envia e-mail de mudança de senha
	public function sendChangePasswordEmail($user, $password) {
		$to = $user->email;
		$subject = 'SENHA - COMPRE & GANHE: Você modificou sua senha.';
		$message = "Prezado <b>$user->name</b>,<br><br>" .
				   "Você realizou a mudança de senha no Compre & Ganhe.<br>Seus dados:<br><br><br>" . 
				   "<b>Usuário:</b> $user->username<br>" . 
				   "<b>Nova Senha:</b> $password<br><br><br>" .
				   "Este e-mail é confidencial! Não repasse essa senha para terceiros.<br><br>" .
				   "Atenciosamente,<br><br><a href='http://www.compreeganhe.net'>Compre & Ganhe</a>";
		return $this->sendEmail($to, $subject, $message);
	}

	//Envia e-mail de graduação
	public function sendGraduationEmail($user, $graduation) {
		$to = $user->email;
		$subject = "GRADUAÇÃO - COMPRE & GANHE: Você foi promovido ao nível $graduation!";
		$message = "Parabéns!<br><br>" .
				   "Você foi promovido ao nível <b>$graduation</b>!<br>" .
				   "Acesse seu <a href='http://www.compreeganhe.net/mybudget'>extrato</a> para conferir o bônus.<br>" . 
				   "Não perca tempo! Continue indicando mais pessoas e fortalecendo sua rede para crescer mais e alcançar outras bonificações!<br><br>" . 
				   "Atenciosamente,<br><br><a href='http://www.compreeganhe.net'>Compre & Ganhe</a>";
		return $this->sendEmail($to, $subject, $message);
	}

}