<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TaskGroup extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get($id) {
		$query = "SELECT *
				  FROM taskGroup
				  WHERE id = '$id'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getTasks($taskGroupId) {
		$query = "SELECT *
				  FROM task
				  INNER JOIN taskGroupTask ON taskGroupTask.taskId = task.id
				  WHERE taskGroupTask.taskGroupId = '$taskGroupId'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function getProjectTaskGroups($projectId) {
		$query = "SELECT *
				  FROM taskGroup
				  INNER JOIN projectTaskGroup ON projectTaskGroup.taskGroupId = taskGroup.id
				  WHERE projectTaskGroup.projectId = '$projectId'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function getLogs($taskGroupId) {
		$query = "SELECT *
				  FROM taskGroupLog
				  WHERE taskGroupId = '$taskGroupId'
				  ORDER BY createDate DESC";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function create($projectId, $user, $data) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Removes ' from strings
		$data->name = str_replace("'","", $data->name);
		$data->description = str_replace("'","", $data->description);
		//Query de inserção SQL
		$query = "INSERT INTO taskGroup
				  (userId, name, description, createDate)
				  VALUES 
				  ('$data->userId', '$data->name', '$data->description', '$createDate')";
		//Tenta inserir no banco
		if ($this->db->query($query)) {
			//Load models
			$this->load->model(array('project','notification'));
			$taskGroupId = $this->db->insert_id();
			$success1 = $this->createProjectTaskGroup($projectId, $taskGroupId);
			//Gets creator user's info
			$userCreator = $this->userBasic->getCurrentUser();
			//Creates log
			$success2 = $this->createLog($taskGroupId, "$userCreator->name criou o grupo de tarefas e o atribuiu a $user->name ($user->username).");
			//Creates notification
			$success3 = $this->notification->create($data->userId, "pencil", "Novo Grupo de Tarefas", "taskGroup?id=$taskGroupId");
			//Creates log project
			$success4 = $this->project->createLog($projectId, "$userCreator->name criou o grupo de tarefas \"$data->name\" e o atribuiu a $user->name ($user->username).");
			if($success1 && $success2 && $success3 && $success4)
				return $taskGroupId;
		}
		//Erro
		return false;
	}

	public function createProjectTaskGroup($projectId, $taskGroupId) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Query
		$query = "INSERT INTO projectTaskGroup
				  (projectId, taskGroupId, createDate)
				  VALUES
				  ('$projectId', '$taskGroupId', '$createDate')";
		return $this->db->query($query);
	}

	public function createTaskGroupTask($taskGroupId, $taskId) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Query
		$query = "INSERT INTO taskGroupTask
				  (taskGroupId, taskId, createDate)
				  VALUES
				  ('$taskGroupId', '$taskId', '$createDate')";
		return $this->db->query($query);
	}
	
	public function createLog($taskGroupId, $changeDescription) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Query
		$query = "INSERT INTO taskGroupLog
				  (taskGroupId, createDate, changeDescription)
				  VALUES
				  ('$taskGroupId', '$createDate', '$changeDescription')";
		return $this->db->query($query);
	}

	public function assign($taskGroup, $data) {
		if ($taskGroup == NULL) return false;
		$tasks = $this->getTasks($taskGroup->id);
		if (count($tasks) == 0) return false;
		//Load models
		$this->load->model('user');
		//If its assign to user
		if($data->changeType == "user") {
			//Gets user
			$user = $this->user->get($data->responsibleUserId);
			if ($user == NULL) return false;
			$logText = "a $user->name ($user->username).";
		}
		//If its assign to team
		else {
			//Load models
			$this->load->model('team');
			//Gets team and user
			$team = $this->team->get($data->teamId);
			if ($team == NULL) return false;
			$user = $this->user->get($data->lider);
			if ($user == NULL) return false;
			$logText = "à equipe $team->name.";
		}
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$success1 = $success2 = $success3 = $success4 = $success5 = true;
		//Load models
		$this->load->model(array('task','project','notification','userBasic'));
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		foreach ($tasks as $task) {
			if($task->responsibleUserId != $user->id) {
				//Tries to update
				$this->db->set('responsibleUserId', $user->id);
				$this->db->set('updateDate', $updateDate);
				$this->db->where('id', $task->id);
				//Tries to update
				if(!$this->db->update('task')) {
					$success1 = false;
					break;
				}
				//Creates Log
				if(!$this->task->createLog($task->id, "$userCreator->name atribuiu a tarefa $logText")) {
					$success2 = false;
					break;
				}
				$this->helper->sendAssignTaskEmail($user, $task);
				//Creates notification
				if(!$this->notification->create($user->id, "pencil", "Tarefa atribuída", "task?id=$task->id")) {
					$success3 = false;
					break;
				}
				//Creates project log
				if(!$this->project->createLog($data->projectId, "$userCreator->name atribuiu a tarefa \"$task->code: $task->title\" $logText")) {
					$success4 = false;
					break;
				}
				//Creates task group log
				if(!$this->createLog($taskGroup->id, "$userCreator->name atribuiu a tarefa \"$task->code: $task->title\" $logText")) {
					$success5 = false;
					break;
				}
			}
		}

		$this->db->set('userId', $user->id);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $taskGroup->id);
		//Tries to update
		$success6 = $this->db->update('taskGroup');
		//Creates log
		$success7 = $this->createLog($taskGroup->id, "$userCreator->name atribuiu o grupo de tarefas $logText");
		//Creates notification
		$success8 = $this->notification->create($user->id, "pencil", "Grupo de Tarefas Atribuído", "taskGroup?id=$taskGroup->id");
		//Creates project log
		$success9 = $this->project->createLog($data->projectId, "$userCreator->name atribuiu o grupo de tarefas \"$taskGroup->name\" $logText");
		return $success1 && $success2 && $success3 && $success4 && $success5 && $success6 && $success7 && $success8 && $success9;
	}

	public function editTaskGroupName($taskGroup, $data) {
		if ($taskGroup == NULL) return false;
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Removes ' from strings
		$data->edit = str_replace("'","", $data->edit);
		//Tries to update
		$this->db->set('name', $data->edit);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $taskGroup->id);
		$success1 = $this->db->update('taskGroup');
		//Loads model
		$this->load->model("userBasic");
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Creates log
		$success2 = $this->createLog($taskGroup->id, "$userCreator->name alterou o nome do grupo de tarefas para \"$data->edit\"");
		return $success1 && $success2;
	}
		
}