<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EmailEngine {

	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
        $this->ci->load->library('email');
	}

	function send($data)
	{
		$this->ci->email->from('noreply@takaki.me','Sistema SYSCOMPP');
		$this->ci->email->to($data['email']);

		$this->ci->email->subject($data['subject']);
		$this->ci->email->message($this->ci->load->view($data['view'], $data['data'], TRUE));

		if($this->ci->email->send()) return true;

		return false;
	}
}