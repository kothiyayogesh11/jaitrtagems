<?php defined('BASEPATH') OR exit('No direct script access allowed');
class YK_Controller extends CI_Controller{
	var $datetime;
	var $user_id;
	var $ip;
	var $login_user;
    function __construct(){
        parent::__construct();
		$this->login_user = $this->session->all_userdata();
		$this->user_id = $this->session->userdata("user_id");
		$this->datetime = date("Y-m-d H:i:s");
		$this->ip = $this->input->ip_address();
    }

}