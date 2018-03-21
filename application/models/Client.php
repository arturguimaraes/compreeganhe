<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get($id) {
		$query = "SELECT *
				  FROM client
				  WHERE id = '$id'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getInfo($id) {
		return $this->get($id);
	}
	
	public function getAll() {
		//Load models
		$this->load->model(array('company'));
		$companyId = $this->company->getCompanyIdByUsername($_SESSION['username']);
		$query = "SELECT *
				  FROM client
				  INNER JOIN clientCompany ON clientCompany.clientId = client.id
				  WHERE clientCompany.companyId = '$companyId'
				  ORDER BY client.code ASC";		  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		else
			return array();
	}
	
	public function getCode($id) {
		$query = "SELECT code
				  FROM client
				  WHERE id = '$id'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0]->code;
		return NULL;
	}

	public function getClientByProjectId($projectId) {
		$query = "SELECT *
				  FROM client
				  INNER JOIN projectClient ON projectClient.clientId = client.id
				  WHERE projectClient.projectId = '$projectId'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}
	
	public function countProjects($clientId) {
		$query = "SELECT COUNT(project.id) as count
				  FROM project
				  INNER JOIN projectClient ON projectClient.projectId = project.id
				  WHERE projectClient.clientId = '$clientId'";		 
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result[0]->count;
		return 0;
	}
	
	public function create($userId, $data) {
		//Pega a hora atual
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Cria o cliente baseado no CPF
		$code = strtoupper(substr($data->name, 0, 3));
		//Confere até achar um código unico
		$i = 3;
		while($this->codeExists($code)) {
			$code = $this->string->uniqueCode($code, $data->name, $i++);
		}
		//Tira o '#' para funcionar a lógica
		$color = substr($data->color, 1, 6);
		//Confere até achar uma cor única
		/*$i = 0;while($this->colorExists($color, $userId)) {$color = $this->string->uniqueColor($color, $i++);}*/
		//Concatena os endereços
		$address1 = $this->string->getFormattedAddress(1, $data);
		$address2 = $this->string->getFormattedAddress(2, $data);
		//Gets fiscalAddress
		$isFiscalAddress = isset($data->isFiscalAddress) && $data->isFiscalAddress == 'on' ? 1 : 0;
		//Removes ' from strings
		$data->name = str_replace("'","", $data->name);
		$data->razaoSocial = str_replace("'","", $data->razaoSocial);
		//Query de inserção SQL
		$query = "INSERT INTO client
				  (code, name, razaoSocial, cnpj, inscricaoEstadual,
				  inscricaoMunicipal, address, isFiscalAddress, fiscalAddress, website,
				  phone, contact1, contact1Email, contact1Phone, contact2,
				  contact2Email, contact2Phone, color, createDate)
				  VALUES 
				  ('$code', '$data->name', '$data->razaoSocial', '$data->cnpj', 
				  '$data->inscricaoEstadual', '$data->inscricaoMunicipal', '$address1', 
				  '$isFiscalAddress', '$address2', '$data->website', '$data->phone', '$data->contact1Name',
				  '$data->contact1Email', '$data->contact1Phone', '$data->contact2Name',
				  '$data->contact2Email', '$data->contact2Phone', '$color', '$createDate')";
		//Tenta inserir no banco
		if ($this->db->query($query)) {
			$clientId = $this->db->insert_id();
			$success = $this->createClientCompany($userId, $clientId);
			if($success)
				return $clientId;
		}
		//Erro
		return false;
	}

	public function createClientCompany($userId, $clientId) {
		//Load models
		$this->load->model(array('company'));
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Gets company ID
		$companyId = $this->company->getCompanyIdByUserID($userId);
		if($companyId != NULL) {
			$query = "INSERT INTO clientCompany
					  (clientId, companyId, createDate)
					  VALUES
					  ('$clientId', '$companyId', '$createDate')";
			if ($this->db->query($query))
				return true;
		}
		return false;
	}
	
	public function updateAddress($clientId, $data) {
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Concatena os endereços
		$address1 = $this->string->getFormattedAddress(1, $data);
		$address2 = $this->string->getFormattedAddress(2, $data);
		//Gets fiscalAddress
		$isFiscalAddress = isset($data->isFiscalAddress) && $data->isFiscalAddress == 'on' ? 1 : 0;
		//Tries to update
		$this->db->set('address', $address1);
		$this->db->set('isFiscalAddress', $isFiscalAddress);
		$this->db->set('fiscalAddress', $address2);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $clientId);
		return $this->db->update('client');
	}

	public function codeExists($code) {
		$query = "SELECT *
				  FROM client
				  WHERE code = '$code'";		  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return true;
		return false;		
	}

	public function colorExists($color, $userId) {
		$query = "SELECT *
				  FROM client
				  INNER JOIN userCompany ON userCompany.userId = '$userId'
				  INNER JOIN clientCompany ON clientCompany.companyId = userCompany.companyId
				  WHERE client.color = '$color'";		  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return true;
		return false;		
	}

	public function delete($client) {
		//Deletes all tasks
		$query = "DELETE
				  FROM task
				  WHERE id IN (SELECT projectTask.taskId
				  			   FROM projectTask
				  			   INNER JOIN project ON project.id = projectTask.projectId
				  			   INNER JOIN projectClient ON projectClient.projectId = project.id
				  			   WHERE projectClient.clientId = '$client->id')";
		$success1 = $this->db->query($query);
		//Delets all task groups
		$query = "DELETE
				  FROM taskGroup
				  WHERE id IN (SELECT projectTaskGroup.taskGroupId
				  			   FROM projectTaskGroup
				  			   INNER JOIN project ON project.id = projectTaskGroup.projectId
				  			   INNER JOIN projectClient ON projectClient.projectId = project.id
				  			   WHERE projectClient.clientId = '$client->id')";
		$success2 = $this->db->query($query);
		//Delets all project
		$query = "DELETE
				  FROM project
				  WHERE id IN (SELECT projectClient.projectId
				  			   FROM projectClient
				  			   WHERE projectClient.clientId = '$client->id')";
		$success3 = $this->db->query($query);
		//Delets the client
		$query = "DELETE
				  FROM client
				  WHERE id = '$client->id'";
		$success4 = $this->db->query($query);
		return $success1 && $success2 && $success3 && $success4;
	}
		
}