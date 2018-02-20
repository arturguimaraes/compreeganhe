<?php
class Captcha extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('captcha');
	}

	public function create() {
		//Captcha config
		$options = array(
        				'img_path'      => 'assets/captcha/',
        				'img_url'       => 'assets/captcha/',
        				'expiration'    => 7200 //2 hours
					);
		//Creates captcha
		$captcha = create_captcha($options);
		//Captcha database insert info
		$data = array(
				        'captcha_time'  => $captcha['time'],
				        'ip_address'    => $this->input->ip_address(),
				        'word'          => $captcha['word']
					);
		//Database insert
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);
		return $captcha;
	}

	public function validate($captcha) {
		// First, delete old captchas in database
		$expiration = time() - 86400; // 1 day
		$this->db->where('captcha_time < ', $expiration)->delete('captcha');
		// Then, delete files in directory
		$files = scandir('assets/captcha');
		foreach($files as $file) {
			$number = intval(str_replace('.jpg','',$file));
			if($number > 0)
				if($number < $expiration)
					if(file_exists('assets/captcha' . $file)) 
						unlink('assets/captcha' . $file);
		};
		// Then see if a captcha exists:
		$sql = 'SELECT COUNT(*) AS count 
				FROM captcha 
				WHERE word = ? 
				AND ip_address = ? 
				AND captcha_time > ?';
		$binds = array($captcha, $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		//Captcha check
		if ($row->count == 0)
			return false;
		return true;
	}

}