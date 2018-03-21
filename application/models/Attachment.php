<?php
class Attachment extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get($id) {
		$query = "SELECT *
				  FROM attachment
				  WHERE id = '$id'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getTaskAttachments($taskId) {
		$query = "SELECT *
				  FROM attachment
				  WHERE taskId = '$taskId'
				  ORDER BY createDate ASC";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function create($post, $file) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Gets comment info
		$data = array(
				        'taskId' 		=> $post->taskId,
				        'filename' 		=> $file['name'],
				        'file' 			=> file_get_contents($file['tmp_name']),
				        'type' 			=> $file['type'],
				        'size' 			=> $file['size'],
				        'authorId' 		=> $post->authorId,
				        'authorName'	=> $post->authorName,
				        'createDate' 	=> $createDate
		);
		$this->db->insert('attachment', $data);
		return $this->db->insert_id();
	}
		
}