<?php
class User extends CI_Model {

	public $id;
	public $username;
	public $password;
	public $name;
	public $email;
	public $cpf;
	public $rg;
	public $dob;
	public $cep;
	public $logradouro;
	public $numero;
	public $complemento;
	public $bairro;
	public $cidade;
	public $estado;
	public $telefone;
	public $estadoCivil;
	public $motherName;
	public $fatherName;
	public $createDate;
	public $updateDate;

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library(array('session', 'util', 'helper'));
		$this->load->model(array('network'));
	}

	public function getUserDataById($id) {
		$query = "SELECT *
				  FROM user
				  WHERE id = '$id'
				  LIMIT 1";
		$result = $this->db->query($query)->result();
		if(count($result) == 1) 
			return $result[0];
		return NULL;
	}

	public function getAll() {
		//Inicia os filtros
		$usernameFilter = $limitFilter =  "";
		//Filtra por usuario
		if(isset($_GET['username']))
			$usernameFilter = " WHERE username = '" . $_GET['username'] . "' ";
		//Verifica se há filtros de limite de registros
		if(isset($_GET['limit']) && $_GET['limit'] != "") {
			$limit = intval($_GET['limit']);
			$limitFilter = " LIMIT $limit ";
		}
		else
			$limitFilter = " LIMIT 100 ";
		$query = "SELECT *, user.createDate as createDate, userPayment.createDate as userPaymentDate
				  FROM user
				  LEFT JOIN userPayment ON userPayment.userId = user.id "
				  . $usernameFilter .
				  " ORDER BY user.createDate "
				  . $limitFilter;
		$result = $this->db->query($query)->result();
		if(count($result) > 0) 
			return $result;
		return array();
	}

	public function getUserByEmail($email) {
		$query = "SELECT *
				  FROM user
				  WHERE email = '$email'
				  LIMIT 1";
		$result = $this->db->query($query)->result();
		if(count($result) == 1) 
			return $result[0];
		return NULL;
	}

	public function getUserByCEP($cep) {
		$query = "SELECT *
				  FROM user
				  WHERE cep = '$cep'
				  LIMIT 1";
		$result = $this->db->query($query)->result();
		if(count($result) == 1) 
			return $result[0];
		return NULL;
	}

	public function getUserData() {
		if($this->checkLogin()) {
			$username = $this->session->username;
			$query = "SELECT *, user.createDate as createDate, userPayment.createDate as userPaymentDate
					  FROM user
					  LEFT JOIN userPayment ON userPayment.userId = user.id
					  WHERE username = '$username'
					  LIMIT 1";
			$result = $this->db->query($query)->result();
			if(count($result) == 1) 
				return $result[0];
		}
		return NULL;
	}

	public function get($user, $info) {
		if ($user != NULL && isset($user->$info))
			return $user->$info;
		return "";
	}

	public function getFromPost($info) {
		if(isset($_POST) && isset($_POST[$info]))
			return $_POST[$info];
		return "";
	}

	public function getUsername() {
		if($this->checkLogin())
			return $this->session->username;
		else
			return NULL;
	}

	public function getCode($code) {
		$query = "SELECT id, username, code
				  FROM user
				  WHERE code = '$code'";		  
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;	
	}

	public function getBalance($id) {
		$query = "SELECT *
				  FROM user
				  WHERE id = '$id'";		  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0]->balance;
		else
			return 0;	
	}
	
	public function existsByUsername($username) {
		$query = "SELECT *
				  FROM user
				  WHERE username = '$username'";
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return true;
		else
			return false;		
	}
	
	public function existsByUserId($id) {
		$query = "SELECT *
				  FROM user
				  WHERE id = '$id'";		  
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return true;
		else
			return false;		
	}
	
	public function login($username, $password) {
		$query = "SELECT *
				  FROM user
				  WHERE username = '$username'
				  AND password = SHA('$password')";
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return true;
		else
			return false;
	}
	
	public function checkPayment($userId) {
		$query = "SELECT *
				  FROM userPayment
				  WHERE userId = $userId";
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return true;
		else
			return false;		
	}

	public function checkFirstTime($userId) {
		$query = "SELECT firstTime
				  FROM userPayment
				  WHERE userId = $userId";
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return $result[0]->firstTime;
		else
			return false;		
	}
	
	public function checkPaymentCleared($userId) {
		$query = "SELECT *
				  FROM `order`, userPayment
				  WHERE `order`.reference = userPayment.reference
				  AND userPayment.userId = $userId
				  LIMIT 1";
		$result = $this->db->query($query)->result();
		
		if (count($result) > 0)
			return $result[0];
		else
			return NULL;		
	}
	
	public function checkLogin() {
		if(isset($_SESSION['loggedIn']))
			return $_SESSION['loggedIn'];
		else
			return false;
	}

	public function create($fatherId, $data) {
		//Pega a hora atual
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Cria o usuário baseado no CPF
		$username = substr($data->cpf, 0, 3);
		//Gera senha aleatória (feita na na controller por causa do e-mail de cadastro)
		//$password = $this->util->geraSenha(15, true, true, true);
		//Converte a data para o formato correto
		$data->dob = $this->dateStringToDate($data->dob);
		//Query de inserção SQL
		$query = "INSERT INTO user
				  (username, password, name, email, cpf,
				  rg, dob, cep, logradouro, numero, 
				  complemento, bairro, cidade, estado,
				  telefone, estadoCivil, motherName,
				  fatherName, createDate, balance, graduation)
				  VALUES 
				  ('$username', SHA1('$data->password'), 
				  '$data->name', '$data->email', '$data->cpf', '$data->rg',
				  '$data->dob', '$data->cep', '$data->logradouro',
				  '$data->numero', '$data->complemento', '$data->bairro',
				  '$data->cidade', '$data->estado', '$data->telefone',
				  '$data->estadoCivil', '$data->motherName', '$data->fatherName',
				  '$createDate', 0, 'INICIANTE')";
		
		if ($this->db->query($query)) {
			$newId = $this->db->insert_id();
			$success = $this->network->create($fatherId, $newId);
			if($success) {
				$newUsername = $this->updateUsername($newId, $username);
				$this->helper->sendSignUpEmail($data->name, $newUsername, $password, $data->email);
				return $this->getUserDataById($newId);
			}
		}

		return false;
	}

	public function update($username, $data) {
		//Pega a hora atual
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		
		//Verifica se existe o usuário
		if($this->existsByUsername($username)) {
			$formattedDOB = $this->dateStringToDate($data->dob);
			$query = "UPDATE user
					  SET name = '$data->name',
					  email = '$data->email',
					  cpf = '$data->cpf',
					  rg = '$data->rg',
					  dob = CAST('$formattedDOB' AS DATE),
					  cep = '$data->cep',
					  logradouro = '$data->logradouro',
					  numero = '$data->numero',
					  complemento = '$data->complemento',
					  bairro = '$data->bairro',
					  cidade = '$data->cidade',
					  estado = '$data->estado',
					  telefone = '$data->telefone',
					  estadoCivil = '$data->estadoCivil',
					  motherName = '$data->motherName',
					  fatherName = '$data->fatherName',
					  updateDate = '$updateDate'
					  WHERE username = '$username'";
			
			return $this->db->query($query);
		}
		return false;
	}

	public function updateUsername($id, $username) {
		if ($id < 10)
			$newUserName = $username . '000' . $id;
		else if ($id < 100)
			$newUserName = $username . '00' . $id;
		else if ($id < 1000)
			$newUserName = $username . '0' . $id;
		else 
			$newUserName = $username . $id;
		
		$query = "UPDATE user
				  SET username = '$newUserName',
				  code = '$newUserName'
				  WHERE id = '$id'";
		$this->db->query($query);
		return $newUserName;
	}
	
	public function updatePaymentReference($userId, $reference) {
		//Pega a hora atual
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		
		if(!$this->checkPayment($userId)) {
			$this->db->set('userId', $userId);			
			$this->db->set('reference', $reference);
			$updatedUserPaymentId = $this->db->insert('userPayment');
		}
		else {
			$this->db->set('reference', $reference);
			$this->db->where('userId', $userId);
			$updatedUserPaymentId = $this->db->update('userPayment');
		}
		return $updatedUserPaymentId;
	}

	public function updatePaymentDate($userId) {
		//Pega a hora atual
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$this->db->set('createDate', $createDate);
		$this->db->where('userId', $userId);
		return $this->db->update('userPayment');
	}

	public function updateFirstTime($userId) {
		//Pega a hora atual
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$updatedUserPaymentId = NULL;

		if($this->checkPayment($userId)) {
			$this->db->set('firstTime', 0);
			$this->db->set('createDate', $createDate);
			$this->db->where('userId', $userId);
			$updatedUserPaymentId = $this->db->update('userPayment');
		}

		return $updatedUserPaymentId;
	}

	public function updateBalance($id, $value) {
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$oldBalance = $this->getBalance($id);
		$newBalance = $oldBalance + $value;
		$query = "UPDATE user
				  SET balance = $newBalance,
				  updateDate = '$updateDate'
				  WHERE id = '$id'";
		return $this->db->query($query);
	}

	public function updateGraduation($id, $graduation) {
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$query = "UPDATE user
				  SET graduation = '$graduation',
				  updateDate = '$updateDate'
				  WHERE id = '$id'";
		return $this->db->query($query);
	}

	public function updatePassword($username, $password) {
		//Pega a hora atual
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Verifica se existe o usuário
		if($this->existsByUsername($username)) {
			$query = "UPDATE user
					  SET password = SHA1('$password'),
					  updateDate = '$updateDate'
					  WHERE username = '$username'";
			return $this->db->query($query);
		}
		return false;
	}
	
	public function updateCode($id, $code) {
		//Pega a hora atual
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		
		//Pega o código no banco
		//$codeBD = $this->getCode($id);

		//Não tem códigos cadastrados
		if ($code != NULL && $code != "") {
			if($this->existsByUserId($id)) {
				$query = "UPDATE user
					  	  SET code = '$code',
					  	  updateDate = '$updateDate',
					  	  lastGeneratedCodeDate = '$updateDate'
					  	  WHERE id = '$id'";
				return $this->db->query($query);
			}
		}

		return false;
	}

	public function dateStringToDate($dateString) {
		return substr($dateString, -4) . '-' . substr($dateString, -7, 2) . '-' . substr($dateString, -10, 2);
	}
	
	public function dateToDateString($date) {
		return substr($date, -2) . '/' . substr($date, -5, 2) . '/' . substr($date, 0, 4);
	}
	
	public function getAreaCode($phone) {
		return substr($phone, 1, 2);
	}
	
	public function getPureNumber($phone) {
		return str_replace(" ", "", substr($phone, 5));
	}
	
	public function getPureCPF($cpf) {
		return str_replace("-", "", str_replace(".", "", $cpf));
	}
		
}