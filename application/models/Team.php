<?php
class Team extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get($id) {
		$query = "SELECT *
				  FROM team
				  WHERE id = '$id'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getAll() {
		$companyId = $this->company->getCompanyIdByUsername($_SESSION['username']);
		$query = "SELECT *
				  FROM team
				  INNER JOIN companyTeam ON companyTeam.teamId = team.id
				  WHERE companyTeam.companyId = '$companyId'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function getUsers($teamId) {
		$query = "SELECT *, user.id as id
				  FROM user
				  INNER JOIN teamUser ON teamUser.userId = user.id
				  INNER JOIN profileCompany ON profileCompany.id = user.profileCompanyId
				  WHERE teamUser.teamId = '$teamId'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function userExists($teamId, $userId) {
		$query = "SELECT *
				  FROM teamUser
				  WHERE teamId = '$teamId'
				  AND userId = '$userId'";		  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return true;
		return false;		
	}

	public function create($companyId, $data) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Query de inserção SQL
		$query = "INSERT INTO team
				  (name, lider, description, createDate)
				  VALUES
				  ('$data->name', '$data->lider', '$data->description', '$createDate')";
		//Tenta inserir no banco
		if ($this->db->query($query)) {
			$teamId = $this->db->insert_id();
			$success1 = $this->createCompanyTeam($companyId, $teamId);
			$success2 = $this->createTeamUser($teamId, $data->lider);
			$success3 = true;
			foreach($data->users as $userId)
				if(!$this->userExists($teamId, $userId))
					if(!$this->createTeamUser($teamId, $userId))
						$success3 = false;
			if($success1 && $success2 && $success3)
				return $teamId;
		}
		//Erro
		return false;
	}

	public function createCompanyTeam($companyId, $teamId) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Query
		$query = "INSERT INTO companyTeam
				  (companyId, teamId, createDate)
				  VALUES
				  ('$companyId', '$teamId', '$createDate')";
		return $this->db->query($query);
	}

	public function createTeamUser($teamId, $userId) {
		if(!$this->userExists($teamId, $userId)) {
			//Gets time
			$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
			//Query
			$query = "INSERT INTO teamUser
					  (teamId, userId, createDate)
					  VALUES
					  ('$teamId', '$userId', '$createDate')";
			return $this->db->query($query);
		}
		return false;
	}

	public function createTaskTeam($taskId, $teamId) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Data
		$data = array(
		        		'taskId' 		=> $taskId,
		        		'teamId' 		=> $teamId,
		        		'createDate' 	=> $createDate
				);
		return $this->db->insert('taskTeam', $data);
	}

	public function updateTaskTeam($taskId, $teamId) {
		$this->deleteTaskTeam($taskId);
		return $this->createTaskTeam($taskId, $teamId);
	}

	public function deleteTaskTeam($taskId) {
		$query = "DELETE FROM taskTeam
				  WHERE taskId = '$taskId'";
		return $this->db->query($query);
	}

}