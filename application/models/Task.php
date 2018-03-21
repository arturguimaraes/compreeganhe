<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get($id) {
		$query = "SELECT *
				  FROM task
				  WHERE id = '$id'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}
	
	public function getAll($deleted = false) {
		$deletedFilter = " WHERE task.deleted = 0 ";
		if($deleted)
			$deletedFilter = " WHERE task.deleted = 1 ";
		$query = "SELECT *
				  FROM task $deletedFilter";  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function getUserTasks() {
		//Load models
		$this->load->model('user');
		$user = $this->user->getByUsername($_SESSION['username']);
		$query = "SELECT *
				  FROM task
				  WHERE responsibleUserId = '$user->id'
				  AND deleted = 0
				  ORDER BY deliverDate ASC";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function getUserTasksByUserId($userId) {
		$query = "SELECT *
				  FROM task
				  WHERE responsibleUserId = '$userId'
				  AND deleted = 0
				  ORDER BY deliverDate ASC";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function getProjectTasks($projectId, $deleted = false) {
		$deletedFilter = " AND task.deleted = 0 ";
		if($deleted)
			$deletedFilter = " AND task.deleted = 1 ";
		$query = "SELECT *
				  FROM task
				  INNER JOIN projectTask ON projectTask.taskId = task.id
				  WHERE projectTask.projectId = '$projectId' $deletedFilter";
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function getTaskGroup($taskId) {
		$query = "SELECT *
				  FROM taskGroup
				  INNER JOIN taskGroupTask ON taskGroupTask.taskGroupId = taskGroup.id
				  WHERE taskGroupTask.taskId = '$taskId'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getProject($taskId) {
		$query = "SELECT *
				  FROM project
				  INNER JOIN projectTask ON projectTask.projectId = project.id
				  WHERE projectTask.taskId = '$taskId'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getLogs($taskId) {
		$query = "SELECT *
				  FROM taskLog
				  WHERE taskId = '$taskId'
				  ORDER BY createDate DESC";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function checkUserCanViewTasks($user, $tasks) {
		//Se usuário é do perfil ADMINISTRADOR(1), e não dos perfis EDITOR(2), USUÁRIO (3) ou CLIENTE(4)
		$permitted = $user->profileCompany->id == 1;
		//Varre o array de tarefas, deletando
		foreach($tasks as $taskKey => $task)
			if(!$permitted && $task->responsibleUserId != $user->id)
				 unset($tasks[$taskKey]);
		return $tasks;
	}

	public function create($projectId, $projectCode, $responsibleUser, $data, $taskGroup) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Gets projects's task count
		$tasksCount = count($this->getProjectTasks($projectId));
		//Gets project number
		if ($tasksCount < 9)
			$tasksNumber = '000' . ($tasksCount+1);
		else if ($tasksCount < 99)
			$tasksNumber = '00' . ($tasksCount+1);
		else if ($tasksCount < 999)
			$tasksNumber = '0' . ($tasksCount+1);
		else 
			$tasksNumber = ($tasksCount+1);
		//Removes ' from strings
		$data->title = str_replace("'","", $data->title);
		$data->description = str_replace("'","", $data->description);
		//Gets project's code
		$code = $projectCode . '-' . $tasksNumber;
		//Query de inserção SQL
		$query = "INSERT INTO task
				  (code, title, description, responsibleUserId, createDate, deliverDate, done, status, progress, deleted)
				  VALUES 
				  ('$code', '$data->title', '$data->description', '$responsibleUser->id', '$createDate', '$data->deliverDate', 0, 'Atribuída', 0, 0)";
		//Tenta inserir no banco
		if ($this->db->query($query)) {
			$taskId = $this->db->insert_id();
			$deliverDate = $this->string->dateTimeFormToString($data->deliverDate, true);
			$date = $deliverDate['date'];
			$time = $deliverDate['time'];
			$success1 = $this->createProjectTask($projectId, $taskId);
			//If its assign to user
			if(!isset($data->teamId)) {
				$logText = "a $responsibleUser->name ($responsibleUser->username) com data de entrega em $date às $time.";
				$success7 = true;
			}
			//If its assign to team
			else {
				//Load models
				$this->load->model('team');
				//Gets team and user
				$team = $this->team->get($data->teamId);
				if ($team != NULL) 
					$logText = "à equipe $team->name com data de entrega em $date às $time.";
				else  
					$logText = "à uma equipe com data de entrega em $date às $time.";
				$success7 = true;//$this->team->createTaskTeam($taskId, $data->teamId);
			}
			//Gets creator user's info
			$userCreator = $this->userBasic->getCurrentUser();
			$success2 = $this->createLog($taskId, "$userCreator->name criou a tarefa e a atribuiu $logText");
			$this->helper->sendNewTaskEmail($responsibleUser, $this->get($taskId));
			//Load models
			$this->load->model('notification');
			//Creates notification
			$success3 = $this->notification->create($responsibleUser->id, "pencil", "Nova tarefa", "task?id=$taskId");
			
			//If belongs to task group, creates task group log
			$success4 = $success5 = true;
			if($taskGroup != NULL) {
				//Load models
				$this->load->model('taskGroup');	
				$success4 = $this->taskGroup->createTaskGroupTask($taskGroup->id, $taskId);
				$success5 = $this->taskGroup->createLog($taskGroup->id, "$userCreator->name criou a tarefa \"$code: $data->title\" e a atribuiu $logText");
			}
			//Load models
			$this->load->model('project');
			$success6 = $this->project->createLog($projectId, "$userCreator->name criou a tarefa \"$code: $data->title\" e a atribuiu $logText");
			if($success1 && $success2 && $success3 && $success4 && $success5 && $success6 && $success7)
				return $taskId;
		}
		//Erro
		return false;
	}

	public function createProjectTask($projectId, $taskId) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Query
		$query = "INSERT INTO projectTask
				  (projectId, taskId, createDate)
				  VALUES
				  ('$projectId', '$taskId', '$createDate')";
		return $this->db->query($query);
	}
	
	public function createLog($taskId, $changeDescription) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Query
		$query = "INSERT INTO taskLog
				  (taskId, createDate, changeDescription)
				  VALUES
				  ('$taskId', '$createDate', '$changeDescription')";
		return $this->db->query($query);
	}

	public function update($task, $data) {
		if ($task == NULL) return false;
		//Verifies if changed
		$doneChanged = $task->done != $data->done;
		$descriptionChanged = $task->description != $data->description;
		$statusChanged = $task->status != $data->status;
		$progressChanged = $task->progress != $data->progress;
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Removes ' from strings
		$data->description = str_replace("'","", $data->description);
		//Tries to update
		$this->db->set('done', $data->done);
		if($doneChanged && $data->done == '1')
			$this->db->set('finishDate', $updateDate);
		if($doneChanged && $data->done == '0')
			$this->db->set('finishDate', NULL);
		$this->db->set('description', $data->description);
		$this->db->set('status', $data->status);
		$this->db->set('progress', $data->progress);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $task->id);
		$success1 = $this->db->update('task');
		//Load models
		$this->load->model(array('taskGroup','userBasic'));
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Creates log
		$success2 = $success3 = $success4 = $success5 = $success6 = $success7 = $success8 = true;
		if($descriptionChanged) {
			$success7 = $this->createLog($task->id, "$userCreator->name atualizou a descrição da tarefa.");
			if($data->taskGroupId != 0)
				$success8 = $this->taskGroup->createLog($data->taskGroupId, "$userCreator->name atualizou a descrição da tarefa \"$task->code: $task->title\".");
		}
		if($statusChanged || $progressChanged) {
			$success2 = $this->createLog($task->id, "$userCreator->name atualizou a tarefa com status \"$data->status\" e progresso em $data->progress%.");
			if($data->taskGroupId != 0)
				$success5 = $this->taskGroup->createLog($data->taskGroupId, "$userCreator->name atualizou a tarefa \"$task->code: $task->title\" com status \"$data->status\" e progresso em $data->progress%.");
		}
		if($doneChanged) {
			//Load models
			$this->load->model(array('project'));
			$marcou = $data->done == '1' ? 'marcou' : 'desmarcou';
			$success3 = $this->createLog($task->id, "$userCreator->name $marcou a tarefa como completa.");
			if($data->done == '1') {
				$success4 = $this->project->createLog($data->projectId, "$userCreator->name marcou a tarefa \"$task->code: $task->title\" como completa.");
				if($data->taskGroupId != 0)
					$success6 = $this->taskGroup->createLog($data->taskGroupId, "$userCreator->name marcou a tarefa \"$task->code: $task->title\" como completa.");
			}
		}
		return $success1 && $success2 && $success3 && $success4 && $success5 && $success6 && $success7 && $success8;
	}

	public function updateComplete($task, $data) {
		if ($task == NULL) return false;
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Tries to update
		$this->db->set('done', $data->done);
		$this->db->set('status', 'Completa');
		$this->db->set('progress', 100);
		$this->db->set('finishDate', $updateDate);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $task->id);
		$success1 = $this->db->update('task');
		//Load models
		$this->load->model(array('project','userBasic'));
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Verify if marked as done
		$marcou = $data->done == '1' ? 'marcou' : 'desmarcou';
		//Creates log
		$success2 = $this->createLog($task->id, "$userCreator->name $marcou a tarefa como completa.");
		$success3 = true;
		if($data->done == '1')
			$success3 = $this->project->createLog($data->projectId, "$userCreator->name marcou a tarefa \"$task->code: $task->title\" como completa.");
		return $success1 && $success2 && $success3;
	}


	public function assign($task, $data) {
		if ($task == NULL) return false;
		//Load models
		$this->load->model('user');
		//If its assign to user
		if($data->changeType == "user") {
			//Gets user
			$user = $this->user->get($data->responsibleUserId);
			if ($user == NULL) return false;
			$this->db->set('responsibleUserId', $data->responsibleUserId);
			$logText = "a $user->name ($user->username).";
			$success6 = true;
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
			$this->db->set('responsibleUserId', $data->lider);
			$logText = "à equipe $team->name.";
			$success6 = true;//$this->team->updateTaskTeam($task->id, $data->teamId);
		}
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Tries to update
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $task->id);
		//Tries to update
		$success1 = $this->db->update('task');
		//Load models
		$this->load->model(array('userBasic', 'notification'));
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Creates Log
		$success2 = $this->createLog($task->id, "$userCreator->name atribuiu a tarefa $logText");
		$this->helper->sendAssignTaskEmail($user, $task);
		//Load models
		$this->load->model('notification');
		//Creates notification
		$success3 = $this->notification->create($user->id, "pencil", "Tarefa atribuída", "task?id=$task->id");
		//Load models
		$this->load->model('project');
		//Creates project log
		$success4 = $this->project->createLog($data->projectId, "$userCreator->name atribuiu a tarefa \"$task->code: $task->title\" $logText");
		//If belongs to task group, creates task group log
		$success5 = true;
		if($data->taskGroupId != 0) {
			//Load models
			$this->load->model('taskGroup');
			$success5 = $this->taskGroup->createLog($data->taskGroupId, "$userCreator->name atribuiu a tarefa \"$task->code: $task->title\" $logText");
		}
		return $success1 && $success2 && $success3 && $success4 && $success5 && $success6;
	}

	public function changeDeliverTask($task, $data) {
		if ($task == NULL) return false;
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Tries to update
		$this->db->set('deliverDate', $data->deliverDate);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $task->id);
		$deliverDate = $this->string->dateTimeFormToString($data->deliverDate, true);
		$date = $deliverDate['date'];
		$time = $deliverDate['time'];
		$success1 = $this->db->update('task');
		$logText = "para $date às $time.";
		//Load models
		$this->load->model('userBasic');
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		$success2 = $this->createLog($task->id, "$userCreator->name alterou a data de entrega da tarefa $logText");
		//Load models
		$this->load->model('project');
		$success3 = $this->project->createLog($data->projectId, "$userCreator->name alterou a data de entrega da tarefa \"$task->code: $task->title\" $logText");
		if($data->taskGroupId != 0) {
			//Load models
			$this->load->model('taskGroup');
			$success4 = $this->taskGroup->createLog($data->taskGroupId, "$userCreator->name alterou a data de entrega da tarefa \"$task->code: $task->title\" $logText");
		}
		else
			$success4 = true;
		return $success1 && $success2 && $success3 && $success4;
	}
	
	public function delete($task, $data) {
		if ($task == NULL) return false;
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Tries to update
		$this->db->set('deleted', 1);
		$this->db->where('id', $task->id);
		//Tries to update
		$success1 = $this->db->update('task');
		//Load models
		$this->load->model('userBasic');
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Creates Log
		$success2 = $this->createLog($task->id, "$userCreator->name arquivou a tarefa.");
		//Load models
		$this->load->model('project');
		//Creates project log
		$success3 = $this->project->createLog($data->projectId, "$userCreator->name arquivou a tarefa \"$task->code: $task->title\".");
		//If belongs to task group, creates task group log
		$success4 = true;
		if($data->taskGroupId != 0) {
			//Load models
			$this->load->model('taskGroup');
			$success4 = $this->taskGroup->createLog($data->taskGroupId, "$userCreator->name arquivou a tarefa \"$task->code: $task->title\".");
		}
		return $success1 && $success2 && $success3 && $success4;
	}

	public function permanentDelete($task, $data) {
		if ($task == NULL) return false;
		//Tries to delete
		$this->db->where('id', $task->id);
		$success1 = $this->db->delete('task');
		//Load models
		$this->load->model('userBasic');
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Load models
		$this->load->model('project');
		//Creates project log
		$success2 = $this->project->createLog($data->projectId, "$userCreator->name excluiu a tarefa \"$task->code: $task->title\".");
		//If belongs to task group, creates task group log
		$success3 = true;
		if($data->taskGroupId != 0) {
			//Load models
			$this->load->model('taskGroup');
			$success3 = $this->taskGroup->createLog($data->taskGroupId, "$userCreator->name excluiu a tarefa \"$task->code: $task->title\".");
		}
		return $success1 && $success2 && $success3;
	}
	
	public function recover($task, $data) {
		if ($task == NULL) return false;
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Tries to update
		$this->db->set('deleted', 0);
		$this->db->where('id', $task->id);
		//Tries to update
		$success1 = $this->db->update('task');
		//Load models
		$this->load->model('userBasic');
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Creates Log
		$success2 = $this->createLog($task->id, "$userCreator->name recuperou a tarefa.");
		//Load models
		$this->load->model('project');
		//Creates project log
		$success3 = $this->project->createLog($data->projectId, "$userCreator->name recuperou a tarefa \"$task->code: $task->title\".");
		//If belongs to task group, creates task group log
		$success4 = true;
		if($data->taskGroupId != 0) {
			//Load models
			$this->load->model('taskGroup');
			$success4 = $this->taskGroup->createLog($data->taskGroupId, "$userCreator->name recuperou a tarefa \"$task->code: $task->title\".");
		}
		return $success1 && $success2 && $success3 && $success4;
	}

	public function editTaskName($task, $data) {
		if ($task == NULL) return false;
		//Gets time
		$updateDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Removes ' from strings
		$data->edit = str_replace("'","", $data->edit);
		//Tries to update
		$this->db->set('title', $data->edit);
		$this->db->set('updateDate', $updateDate);
		$this->db->where('id', $task->id);
		$success1 = $this->db->update('task');
		//Loads model
		$this->load->model("userBasic");
		//Gets creator user's info
		$userCreator = $this->userBasic->getCurrentUser();
		//Creates log
		$success2 = $this->createLog($task->id, "$userCreator->name alterou o nome da tarefa para \"$data->edit\"");
		return $success1 && $success2;
	}
		
}