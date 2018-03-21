<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}	
	
	public function get($id) {
		$query = "SELECT *
				  FROM company
				  WHERE id = '$id'";		  
				  
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return $result[0];
	}
	
	public function getByUserID($userId) {
		$query = "SELECT *
				  FROM company
				  INNER JOIN userCompany ON userCompany.companyId = company.id
				  WHERE userCompany.userId = '$userId'";
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getCompanyIdByUserID($userId) {
		$query = "SELECT companyId
				  FROM userCompany
				  WHERE userId = '$userId'";		  			  
		$result = $this->db->query($query)->result();
		if(count($result) == 1)
			return $result[0]->companyId;
		return NULL;
	}

	public function getCompanyIdByUsername($username) {
		$query = "SELECT userCompany.companyId as companyId
				  FROM userCompany
				  INNER JOIN user ON user.id = userCompany.userId
				  WHERE user.username = '$username'";		  			  
		$result = $this->db->query($query)->result();
		if(count($result) == 1)
			return $result[0]->companyId;
		return NULL;
	}

	public function getCompanyNameByUserID($userId) {
		$query = "SELECT company.name as name
				  FROM userCompany
				  INNER JOIN company ON company.id = userCompany.companyId
				  WHERE userCompany.userId = '$userId'";		  			  
		$result = $this->db->query($query)->result();
		if(count($result) == 1)
			return $result[0]->name;
		return NULL;
	}

	public function existsByCNPJ($cnpj) {
		$query = "SELECT *
				  FROM company
				  WHERE cnpj = '$cnpj'";		  		  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return true;
		return false;
	}

	public function create($data) {
		//Pega a hora atual
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Concatena os endereços
		$address1 = $this->string->getFormattedAddress(1, $data);
		$address2 = $this->string->getFormattedAddress(2, $data);
		//Gets fiscalAddress
		$isFiscalAddress = isset($data->isFiscalAddress) && $data->isFiscalAddress == 'on' ? 1 : 0;
		//Query de inserção SQL
		$query = "INSERT INTO company
				  (name, razaoSocial, cnpj, inscricaoEstadual,
				  inscricaoMunicipal, address, isFiscalAddress, fiscalAddress, website,
				  phone, createDate)
				  VALUES 
				  ('$data->name', '$data->razaoSocial', '$data->cnpj', 
				  '$data->inscricaoEstadual', '$data->inscricaoMunicipal', '$address1', 
				  '$isFiscalAddress', '$address2', '$data->website', '$data->phone', '$createDate')";
		//Tenta inserir no banco
		if ($this->db->query($query))
			return $this->db->insert_id();
		//Erro
		return false;
	}

	public function createUserCompany($userId, $companyId) {
		$query = "INSERT INTO userCompany
				  (userId, companyId)
				  VALUES 
				  ('$userId', '$companyId')";
		//Tenta inserir no banco
		return $this->db->query($query);
	}

	public function updateInfo($companyId, $data) {
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Tries to update
		$this->db->set('name', $data->name);
		$this->db->set('razaoSocial', $data->razaoSocial);
		$this->db->set('cnpj', $data->cnpj);
		$this->db->set('inscricaoEstadual', $data->inscricaoEstadual);
		$this->db->set('inscricaoMunicipal', $data->inscricaoMunicipal);
		$this->db->set('website', $data->website);
		$this->db->set('phone', $data->phone);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $companyId);
		return $this->db->update('company');
	}

	public function updateAddress($companyId, $data) {
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
		$this->db->where('id', $companyId);
		return $this->db->update('company');
	}

	public function updateAdmin($companyId, $userId) {
		//Pega a hora atual
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$this->db->set('userId', $userId);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $companyId);
		return $this->db->update('company');
	}
		
}