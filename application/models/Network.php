<?php
class Network extends CI_Model {

	public $fatherId;
	public $sonId;
	public $createDate;

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model(array('userPayment','transaction','user'));
		$this->load->library(array('helper'));
	}

	public function getFather($sonId) {
		$children = array();
		$query = "SELECT *, user.createDate as createDate, network.createDate as relationDate
				  FROM network
				  INNER JOIN user ON network.fatherId = user.id
				  WHERE network.sonId = '$sonId'";
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;
	}

	public function getSons($userId, $iterationLevel = 0) {
		$children = array();
		$query = "SELECT *, user.createDate as createDate, userPayment.createDate as userPaymentDate
				  FROM network
				  INNER JOIN user ON network.sonId = user.id
				  LEFT JOIN userPayment ON userPayment.userId = user.id
				  WHERE network.fatherId = '$userId'";
	  
		$result = $this->db->query($query)->result();

		if (count($result) > 0) {
			foreach($result as $son) {
				$level = $iterationLevel == 0 ? 'Direto' : 'Indireto ' . $iterationLevel;
				array_push($children, array(
												'user' => $son, 
												'level' => $level, 
												'children' => $this->getSons($son->id, $iterationLevel+1)
											));
			}
		}
		return $children;		
	}

	public function getSonsPaid($userId, $iterationLevel = 0) {
		$children = array();
		$query = "SELECT *, user.createDate as createDate, userPayment.createDate as userPaymentDate
				  FROM network
				  INNER JOIN user ON network.sonId = user.id
				  LEFT JOIN userPayment ON userPayment.userId = user.id
				  WHERE network.fatherId = '$userId'
				  AND userPayment.createDate IS NOT NULL";
	  
		$result = $this->db->query($query)->result();

		if (count($result) > 0) {
			foreach($result as $son) {
				$level = $iterationLevel == 0 ? 'Direto' : 'Indireto ' . $iterationLevel;
				array_push($children, array(
												'user' => $son, 
												'level' => $level, 
												'children' => $this->getSonsPaid($son->id, $iterationLevel+1)
											));
			}
		}
		return $children;		
	}

	public function getSonsNotPaid($userId, $iterationLevel = 0) {
		$children = array();
		$query = "SELECT *, user.createDate as createDate, userPayment.createDate as userPaymentDate
				  FROM network
				  INNER JOIN user ON network.sonId = user.id
				  LEFT JOIN userPayment ON userPayment.userId = user.id
				  WHERE network.fatherId = '$userId'
				  AND userPayment.createDate IS NULL";
	  
		$result = $this->db->query($query)->result();

		if (count($result) > 0) {
			foreach($result as $son) {
				$level = $iterationLevel == 0 ? 'Direto' : 'Indireto ' . $iterationLevel;
				array_push($children, array(
												'user' => $son, 
												'level' => $level, 
												'children' => $this->getSonsNotPaid($son->id, $iterationLevel+1)
											));
			}
		}
		return $children;		
	}

	public function getSonsGraduation($userId, $graduation, $iterationLevel = 0) {
		$children = array();
		$query = "SELECT *, user.createDate as createDate, userPayment.createDate as userPaymentDate
				  FROM network
				  INNER JOIN user ON network.sonId = user.id
				  LEFT JOIN userPayment ON userPayment.userId = user.id
				  WHERE network.fatherId = '$userId'
				  AND userPayment.createDate IS NOT NULL
				  AND user.graduation = '$graduation'";
	  
		$result = $this->db->query($query)->result();

		if (count($result) > 0) {
			foreach($result as $son) {
				$level = $iterationLevel == 0 ? 'Direto' : 'Indireto ' . $iterationLevel;
				array_push($children, array(
												'user' => $son, 
												'level' => $level, 
												'children' => $this->getSonsGraduation($son->id, $graduation, $iterationLevel+1)
											));
			}
		}
		return $children;		
	}

	public function create($fatherId, $sonId) {
		//Pega a hora atual
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$query = "INSERT INTO network (fatherId, sonId, createDate)
				  VALUES  ('$fatherId', '$sonId', '$createDate')";
		return $this->db->query($query);
	}
	
	public function buildTree($elements, $parentId = 0) {
		$branch = array();
	
		foreach ($elements as $element) {
			if ($element['parent_id'] == $parentId) {
				$children = buildTree($elements, $element['id']);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}
	
		return $branch;
	}

	public function addUserPayment($user) {
		$userPayment = $this->userPayment->getPayment($user->id);
		if($userPayment != NULL) {
			$user->userPaymentDate = $userPayment->createDate;
			$user->paymentReference = $userPayment->reference;
			$user->firstTime = $userPayment->firstTime;
		}
		else {
			$user->userPaymentDate = NULL;
			$user->paymentReference = NULL;
			$user->firstTime = NULL;
		}

		return $user;
	}

	public function countLevel($array) {
		$count = array('DIRETO' 	=> 0,
					   'INDIRETO 1'	=> 0,
					   'INDIRETO 2' => 0,
					   'INDIRETO 3' => 0);
		//Conta indicados do tipo 'DIRETO'
		$countSons = 0;
		foreach($array as $firstLevelSon)
			if($firstLevelSon['level'] == 'Direto')
				$countSons++;
		$count['DIRETO'] = $countSons;
		//Conta indicados do tipo 'INDIRETO 1'
		$countSons = 0;
		foreach($array as $firstLevelSon) {
			foreach($firstLevelSon['children'] as $secondLevelSon) {
				if($secondLevelSon['level'] == 'Indireto 1') {
					$countSons++;
				}
			}
		}
		$count['INDIRETO 1'] = $countSons;
		//Conta indicados do tipo 'INDIRETO 2'
		$countSons = 0;
		foreach($array as $firstLevelSon) {
			foreach($firstLevelSon['children'] as $secondLevelSon) {
				foreach($secondLevelSon['children'] as $thirdLevelSon) {
					if($thirdLevelSon['level'] == 'Indireto 2') {
						$countSons++;
					}
				}
			}
		}
		$count['INDIRETO 2'] = $countSons;
		//Conta indicados do tipo 'INDIRETO 3'
		$countSons = 0;
		foreach($array as $firstLevelSon) {
			foreach($firstLevelSon['children'] as $secondLevelSon) {
				foreach($secondLevelSon['children'] as $thirdLevelSon) {
					foreach($thirdLevelSon['children'] as $fourthLevelSon) {
						if($fourthLevelSon['level'] == 'Indireto 3') {
							$countSons++;
						}
					}
				}
			}
		}
		$count['INDIRETO 3'] = $countSons;
		return $count;
	}

	public function checkUpdateById($userId) {
		$this->checkUpdate($this->user->getUserDataById($userId));
	}

	public function checkUpdate($user) {
		//Pega usuários ATIVOS na rede
		$sons = $this->getSonsPaid($user->id);
		//Graduação INICIANTE > BRONZE
		if(count($sons) >= 5 && $user->graduation == 'INICIANTE' && !$this->transaction->existsByGraduation($user->id, 'BRONZE')) {
			$this->user->updateGraduation($user->id, 'BRONZE');
			$data = array(
							'orderId'		=> 0,
							'userId'		=> $user->id,
							'value'			=> 0,
							'action'		=> 'Graduação: Você foi graduado ao nível BRONZE!'
						);
			$this->transaction->create($data);
			$this->user->updateBalance($user->id, 0);
			$this->helper->sendGraduationEmail($user,'BRONZE');
			return true;
		}
		//Graduação BRONZE > PRATA
		if(count($sons) >= 5 && $user->graduation == 'BRONZE' && !$this->transaction->existsByGraduation($user->id, 'PRATA')) {
			$count = 0;
			foreach($sons as $son)
				if($son['user']->graduation == 'BRONZE' || $son['user']->graduation == 'PRATA' || $son['user']->graduation == 'OURO' || $son['user']->graduation == 'DIAMANTE')
					$count++;
			if($count >= 5) {
				$this->user->updateGraduation($user->id, 'PRATA');
				$data = array(
								'orderId'		=> 0,
								'userId'		=> $user->id,
								'value'			=> 100,
								'action'		=> 'Graduação: Você foi graduado ao nível PRATA!'
							);
				$this->transaction->create($data);
				$this->user->updateBalance($user->id, 100);
				$this->helper->sendGraduationEmail($user,'PRATA');
				return true;
			}
		}
		//Graduação PRATA > OURO
		if(count($sons) >= 10 && $user->graduation == 'PRATA' && !$this->transaction->existsByGraduation($user->id, 'OURO')) {
			$count = 0;
			foreach($sons as $son)
				if($son['user']->graduation == 'PRATA' || $son['user']->graduation == 'OURO' || $son['user']->graduation == 'DIAMANTE')
					$count++;
			if($count >= 10) {
				$this->user->updateGraduation($user->id, 'OURO');
				$data = array(
								'orderId'		=> 0,
								'userId'		=> $user->id,
								'value'			=> 300,
								'action'		=> 'Graduação: Você foi graduado ao nível OURO!'
							);
				$this->transaction->create($data);
				$this->user->updateBalance($user->id, 300);
				$this->helper->sendGraduationEmail($user,'OURO');
				return true;
			}
		}
		//Graduação OURO > DIAMANTE
		if(count($sons) >= 10 && $user->graduation == 'OURO' && !$this->transaction->existsByGraduation($user->id, 'DIAMANTE')) {
			$count = 0;
			foreach($sons as $son)
				if($son['user']->graduation == 'OURO' || $son['user']->graduation == 'DIAMANTE')
					$count++;
			if($count >= 10) {
				$this->user->updateGraduation($user->id, 'DIAMANTE');
				$data = array(
								'orderId'		=> 0,
								'userId'		=> $user->id,
								'value'			=> 600,
								'action'		=> 'Graduação: Você foi graduado ao nível máximo de DIAMANTE!'
							);
				$this->transaction->create($data);
				$this->user->updateBalance($user->id, 600);
				$this->helper->sendGraduationEmail($user,'DIAMANTE');
				return true;
			}
		}
		//Verifica atualização dos pais
		$father = $this->getFather($user->id);
		if($father != NULL)
			$this->checkUpdate($father);
		return false;
	}

}