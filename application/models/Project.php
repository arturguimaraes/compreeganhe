<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Project extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get($id) {
		$query = "SELECT *
				  FROM project
				  WHERE id = '$id'";		  			 
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}
	
	public function getClientProjects($clientId) {
		$query = "SELECT *
				  FROM project
				  INNER JOIN projectClient ON projectClient.projectId = project.id
				  WHERE projectClient.clientId = '$clientId'";		 
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function getProjectByTaskGroupId($taskGroupId) {
		$query = "SELECT *
				  FROM project
				  INNER JOIN projectTaskGroup ON projectTaskGroup.projectId = project.id
				  WHERE projectTaskGroup.taskGroupId = '$taskGroupId'";		  			 
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}
	
	public function getProjectByTaskId($taskId) {
		$query = "SELECT *
				  FROM project
				  INNER JOIN projectTask ON projectTask.projectId = project.id
				  WHERE projectTask.taskId = '$taskId'";		  			 
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getLogs($projectId) {
		$query = "SELECT *
				  FROM projectLog
				  WHERE projectId = '$projectId'
				  ORDER BY createDate DESC";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}
	
	public function create($userId, $data) {
		//Load models
		$this->load->model('client');
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Gets time formatted
		$formattedDate =  mdate('%m-%y', now('America/Sao_Paulo'));
		//Gets client code
		$clientCode = $this->client->getCode($data->client);
		//Gets client's projects count
		$projetosCount = count($this->getClientProjects($data->client));
		//Removes ' from strings
		$data->title = str_replace("'","", $data->title);
		$data->briefing = str_replace("'","", $data->briefing);
		//Gets project number
		if ($projetosCount < 9)
			$projectNumber = '000' . ($projetosCount+1);
		else if ($projetosCount < 99)
			$projectNumber = '00' . ($projetosCount+1);
		else if ($projetosCount < 999)
			$projectNumber = '0' . ($projetosCount+1);
		else
			$projectNumber = ($projetosCount+1);
		//Gets project's code
		$code = $clientCode . '-' . $formattedDate . '-' . $projectNumber;
		//Query de inserção SQL
		$query = "INSERT INTO project
				  (code, adminUserId, title, briefing, status, createDate, deliverDate)
				  VALUES
				  ('$code', '$userId', '$data->title', '$data->briefing', 'Planejamento', '$createDate', '$data->deliverDate')";
		//Tenta inserir no banco
		if ($this->db->query($query)) {
			$projectId = $this->db->insert_id();
			$deliverDate = $this->string->dateTimeFormToString($data->deliverDate, true);
			$date = $deliverDate['date'];
			$time = $deliverDate['time'];
			$success1 = $this->createProjectClient($projectId, $data->client);
			//Gets creator user's info
			$userCreator = $this->userBasic->getCurrentUser();
			$client = $this->client->get($data->client);
			//Create log
			$success2 = $this->createLog($projectId, "$userCreator->name criou um projeto para $client->name com data de entrega em $date às $time.");
			if($success1 && $success2)
				return $projectId;
		}
		//Erro
		return false;
	}
	
	public function createProjectClient($projectId, $clientId) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Query
		$query = "INSERT INTO projectClient
				  (projectId, clientId, createDate)
				  VALUES
				  ('$projectId', '$clientId', '$createDate')";
		return $this->db->query($query);
	}

	public function createLog($projectId, $changeDescription) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Query
		$query = "INSERT INTO projectLog
				  (projectId, createDate, changeDescription)
				  VALUES
				  ('$projectId', '$createDate', '$changeDescription')";
		return $this->db->query($query);
	}

	public function update($project, $data) {
		if ($project == NULL) return false;
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Tries to update
		$this->db->set('status', $data->status);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $project->id);
		$success1 = $this->db->update('project');
		//Loads model
		$this->load->model("userBasic");
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Creates log
		$success2 = $this->createLog($project->id, "$userCreator->name atualizou o status do projeto para \"$data->status\".");
		return $success1 && $success2;
	}

	public function changeDeliverDate($project, $data) {
		if ($project == NULL) return false;
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Tries to update
		$this->db->set('deliverDate', $data->deliverDate);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $project->id);
		$deliverDate = $this->string->dateTimeFormToString($data->deliverDate, true);
		$date = $deliverDate['date'];
		$time = $deliverDate['time'];
		$success1 = $this->db->update('project');
		//Loads model
		$this->load->model("userBasic");
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Creates log
		$success2 = $this->createLog($project->id, "$userCreator->name alterou a data de entrega do projeto para $date às $time.");
		return $success1 && $success2;
	}

	public function editProjectName($project, $data) {
		if ($project == NULL) return false;
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Tries to update
		//Removes ' from strings
		$data->edit = str_replace("'","", $data->edit);
		$this->db->set('title', $data->edit);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $project->id);
		$success1 = $this->db->update('project');
		//Loads model
		$this->load->model("userBasic");
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Creates log
		$success2 = $this->createLog($project->id, "$userCreator->name alterou o título do projeto para \"$data->edit\"");
		return $success1 && $success2;
	}
		
}