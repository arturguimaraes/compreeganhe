<?php
class Message extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('date'));
	}
	
	public function get($id) {
		$query = "SELECT *, message.id as messageId
				  FROM message
				  INNER JOIN user ON user.id = message.from
				  WHERE message.id = '$id'";		  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		else
			return NULL;		
	}

	public function getAll($userId) {
		$query = "SELECT *, message.id as messageId, message.createDate as createDate
				  FROM message
				  INNER JOIN user ON user.id = message.from
				  WHERE message.to = '$userId'
				  AND deleted = 0
				  ORDER BY message.createDate DESC";
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();		
	}
	
	public function getAllSent($userId) {
		$query = "SELECT *, message.id as messageId, message.createDate as createDate
				  FROM message
				  INNER JOIN user ON user.id = message.to
				  WHERE message.from = '$userId'
				  ORDER BY message.createDate DESC";
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();		
	}
	
	public function countUnread($userId) {
		$query = "SELECT COUNT(id) as unread
				  FROM message
				  WHERE message.to = '$userId'
				  AND message.read = '0'
				  AND deleted = 0";
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return intval($result[0]->unread);
		return 0;		
	}

	public function create($from, $to, $message) {
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		$data = array(
        				'from' 			=> $from,
        				'to'   			=> $to,
        				'message' 		=> $message,
						'read'			=> 0,
						'deleted'		=> 0,
						'createDate'	=> $createDate
		);
		$this->db->insert('message', $data);
		return $this->db->insert_id();
	}

	public function markRead($id) {
		if($id != NULL && $id != 0) {
			$this->db->set('read', 1);
			$this->db->where('id', $id);
			return $this->db->update('message');
		}
		return false;
	}
	
	public function delete($id, $userId) {
		$query = "UPDATE message
				  SET message.deleted = '1', message.read = '1'
				  WHERE id = '$id'
				  AND message.to = '$userId'";
		return $this->db->query($query);
	}
	
	public function deleteAll($userId) {
		$query = "UPDATE message
				  SET message.deleted = '1', message.read = '1'
				  WHERE message.to = '$userId'";
		return $this->db->query($query);
	}
	
	/*public function delete($id, $userId) {
		$query = "DELETE FROM message
				  WHERE id = '$id'
				  AND message.to = '$userId'";
		return $this->db->query($query);
	}
	
	public function deleteAll($userId) {
		$query = "DELETE FROM message
				  WHERE message.to = '$userId'";
		return $this->db->query($query);
	}*/

}