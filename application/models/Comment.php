<?php
class Comment extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get($id) {
		$query = "SELECT *
				  FROM comment
				  WHERE id = '$id'";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) == 1)
			return $result[0];
		return NULL;
	}

	public function getTaskComments($taskId) {
		$query = "SELECT *
				  FROM comment
				  WHERE taskId = '$taskId'
				  ORDER BY createDate ASC";		  			  
		$result = $this->db->query($query)->result();
		if (count($result) > 0)
			return $result;
		return array();
	}

	public function create($post) {
		//Gets time
		$createDate =  mdate('%Y-%m-%d %H:%i:%s', now('America/Sao_Paulo'));
		//Gets comment info
		$data = array(
				        'taskId' 		=> $post->taskId,
				        'comment' 		=> $post->comment,
				        'authorId' 		=> $post->authorId,
				        'authorName'	=> $post->authorName,
				        'createDate' 	=> $createDate
		);
		$this->db->insert('comment', $data);
		return $this->db->insert_id();
	}
		
}