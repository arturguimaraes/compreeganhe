<?php
class UserBasic extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function getUser($id) {
		$query = "SELECT *
				  FROM user
				  WHERE id = '$id'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}
	
	public function getByUsername($username) {
		$query = "SELECT *
				  FROM user
				  WHERE username = '$username'";		  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getCurrentUser() {
		return $this->getByUsername($_SESSION['username']);
	}
	
	public function getName($id) {
		$query = "SELECT name
				  FROM user
				  WHERE id = '$id'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0]->name;
		return NULL;
	}
	
	public function getProfile($id) {
		$query = "SELECT *
				  FROM profile
				  WHERE id = '$id'";		  
				  
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return $result[0];
		return NULL;		
	}
	
	public function getProfileCompany($id) {
		$query = "SELECT *
				  FROM profileCompany
				  WHERE id = '$id'";		  
				  
		$result = $this->db->query($query)->result();
		
		if (count($result) == 1)
			return $result[0];
		return NULL;		
	}
	
	public function getCompanyId() {
		$username = $_SESSION['username'];
		$query = "SELECT userCompany.companyId as companyId
				  FROM userCompany
				  INNER JOIN user ON user.id = userCompany.userId
				  WHERE user.username = '$username'";		  			  
		$result = $this->db->query($query)->result();
		if(count($result) == 1)
			return $result[0]->companyId;
		return NULL;
	}

	public function getUserTasksByUserId($userId) {
		$query = "SELECT *
				  FROM task
				  WHERE responsibleUserId = '$userId'
				  ORDER BY deliverDate ASC";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}
	
	public function getUserTasks($user) {
		return $this->getUserTasksByUserId($user->id);
	}
	
	public function getProjectTasks($projectId) {
		$query = "SELECT *
				  FROM task
				  INNER JOIN projectTask ON projectTask.taskId = task.id
				  WHERE projectTask.projectId = '$projectId'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}
	
	public function getAllClients() {
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
	
	public function getNotifications($user) {
		$query = "SELECT *
				  FROM notification
				  WHERE userId = '$user->id'
				  ORDER BY createDate DESC";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}
	
	public function checkLogin() {
		if(isset($_SESSION['loggedIn']))
			return $_SESSION['loggedIn'];
		else
			return false;
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
		
}