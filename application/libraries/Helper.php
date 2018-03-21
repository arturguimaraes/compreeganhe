<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {
		
	protected $CI;
	
	public function __construct() {
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
	}
	
	public function loadPage($data, $templates = true) {
		//Loads header
		if ($templates)
			$this->CI->load->view('templates/header', $data);
		//Loads page
		$this->CI->load->view('pages/' . $data['page']['url'], $data);
		//Loads footer
		if ($templates)
			$this->CI->load->view('templates/footer', $data);
	}
	
	public function loadErrorPage($data) {
		$data['page']['title'] = 'Página não encontrada';
		$data['heading'] = "Página não encontrada";
		$data['message'] = "A página desejada não foi encontrada.<br>Por favor, retorne à página inicial clicando <a href='" . base_url() . "'>aqui</a>.";
		$this->CI->load->view('templates/header', $data);
		$this->CI->load->view('errors/cli/error_general', $data);
		$this->CI->load->view('templates/footer', $data);
	}
	
	//Gets field from $_POST
	public function get($field) {
		if(isset($_POST[$field]) && $_POST[$field] != NULL)
			return $_POST[$field];
		if(isset($_GET[$field]) && $_GET[$field] != NULL)
			return $_GET[$field];
		return "";
	}

	//Gets field from $_POST OR a given value
	public function getOrValue($field, $givenValue = "") {
		if(isset($_POST[$field]) && $_POST[$field] != NULL && $_POST[$field] != "")
			return $_POST[$field];
		if(isset($_GET[$field]) && $_GET[$field] != NULL && $_GET[$field] != "")
			return $_GET[$field];
		return $givenValue;
	}
	
	//Converts array into object
	public function arrayToObject($array) {
		return (object) $array;
	}

	//Converts object into array
	public function objectToArray($object) {
		return (array) $object;
	}
	
	//Converte Datetime para data visível ao usuário
	public function dateTimeToString($dateTime) {
		$year = substr($dateTime, 0, 4);
		$month = substr($dateTime, 5, 2);
		$day = substr($dateTime, 8, 2);
		$time = substr($dateTime, -8, 5);
		return $day.'/'.$month.'/'.$year.' '.$time;
	}

	//Sends message to view
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

	//Sends system messages
	public function sendSystemMessage($message, $class) {
		if(isset($_SESSION['messages']) && $_SESSION['messages'] != NULL && count($_SESSION['messages']) > 0)
			array_push($_SESSION['messages'], array('message' => $message, 'class' => $class));
		else
			$_SESSION['messages'] = array(array('message' => $message, 'class' => $class));
	}

	//Gets system messages
	public function getSystemMessages() {
		if(isset($_SESSION['messages']) && $_SESSION['messages'] != NULL && count($_SESSION['messages']) > 0)
			$messages = $_SESSION['messages'];
		else
			$messages = array();
		$_SESSION['messages'] = array();
		return $messages;
	}

	//Sends e-mails
	public function sendEmail($to, $subject, $message, $user) {
		if($user != NULL && $user->emailNotification == 'sim') {
			$headers = 'From: no-reply@smallvisor.com' . "\r\n" .
					   'Reply-To: no-reply@smallvisor.com' . "\r\n" .
					   'Content-Type: text/html; charset=UTF-8' . "\r\n" .
					   'X-Mailer: PHP/' . phpversion();
			$signature = "<br><br>Atenciosamente,<br><br><a href='" . base_url() . "'>Equipe SmallVisor</a>.";
			$message .= $signature;
			return mail($to, $subject, $message, $headers);
		}
		else
			return true;
	}

	//Sends signup e-mail
	public function sendSignUpEmail($name, $username, $password, $email) {
		$subject = 'SmallVisor: Você se cadastrou no SmallVisor!';
		$message = "Parabéns <b>$name</b>!<br><br>" .
				   "Você realizou o cadastro no nosso sistema com os seguintes dados de acesso:<br><br>" . 
				   "<b>Usuário:</b> $username<br>" . 
				   "<b>Senha:</b> $password<br><br>" .
				   "Este e-mail é confidencial. Não repasse essa senha para terceiros.";
		$user = $this->CI->userBasic->getByUsername($username);
		return $this->sendEmail($email, $subject, $message, $user);
	}
	
	//Envia e-mail de mudança de senha
	public function sendChangePasswordEmail($user, $password) {
		$to = $user->email;
		$subject = 'SmallVisor: Você modificou sua senha.';
		$message = "Prezado <b>$user->name</b>,<br><br>" .
				   "Você realizou a mudança de senha no SmallVisor.<br>Seus novos dados de acesso:<br><br>" . 
				   "<b>Usuário:</b> $user->username<br>" . 
				   "<b>Nova Senha:</b> $password<br><br>" .
				   "Este e-mail é confidencial! Não repasse essa senha para terceiros.";
		return $this->sendEmail($to, $subject, $message, $user);
	}

	//Sends new task e-mail
	public function sendNewTaskEmail($user, $task) {
		$email 	 = $user->email;
		$subject = 'SmallVisor: Você tem uma nova tarefa!';
		$message = "Prezado <b>$user->name</b>,<br><br>" .
				   "Uma nova tarefa foi criada e atribuída à você:<br><br>" . 
				   "<b>Título:</b> $task->code: $task->title<br>" . 
				   "<b>Data de Entrega:</b> " . $this->dateTimeToString($task->deliverDate) . "<br><br>" .
				   "Para acessá-la e ver mais detalhes, clique <a href='" . base_url() . "/task?id=$task->id'>aqui</a>.";
		return $this->sendEmail($email, $subject, $message, $user);
	}

	//Sends new task e-mail
	public function sendAssignTaskEmail($user, $task) {
		$email 	 = $user->email;
		$subject = 'SmallVisor: Uma tarefa foi atribuída à você!';
		$message = "Prezado <b>$user->name</b>,<br><br>" .
				   "Uma tarefa foi atribuída para você:<br><br>" . 
				   "<b>Título:</b> $task->code: $task->title<br>" .
				   "<b>Status:</b> $task->status<br>" .
				   "<b>Progresso:</b> $task->progress %<br>" . 
				   "<b>Data de Entrega:</b> " . $this->dateTimeToString($task->deliverDate) . "<br><br>" .
				   "Para acessá-la e ver mais detalhes, clique <a href='" . base_url() . "/task?id=$task->id'>aqui</a>.";
		return $this->sendEmail($email, $subject, $message, $user);
	}
	
}