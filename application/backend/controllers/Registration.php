<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

	var $datetime;

	var $user_id;

	public function __construct() {

        parent::__construct();

		$this->datetime = date('Y-m-d H:i:s');
		$this->ip = $this->input->ip_address();
		$this->load->model('registration_model');

    }

	function process(){
		$data['firstname'] = $this->input->post('fname');
		$data['lastname'] = $this->input->post('lname');
		$data['email'] = $this->input->post('email_admin_signup');
		$data['password'] = trim(sha1($this->input->post('pass')));
		$data['role'] = 10;
		$data['is_admin'] = 1;
		$data['insertDate'] = $this->datetime;
		$data['insertIp'] = $this->ip;
		$data['unique_name'] = trim(strtolower($data['firstname']).''.$data['lastname']);
		$res = $this->registration_model->signup($data);	
		if($res){
			$msg = get_message('Registration successfully, Login in it.',0);
			$this->session->set_flashdata('message',$msg);
			redirect('login');	
		}else{
			$msg = get_message('Registration Failed.',1);
			$this->session->set_flashdata('message',$msg);
			redirect('login');	
		}
	}
	
	function check_email(){
		$email = $this->input->post('email');
		$CountEmail = count($this->registration_model->checkEmailInUse($email));
		if($CountEmail == 0){
			$msg['error'] = 0;
		}else{
			$msg['error'] = 1;
		}
		echo json_encode($msg);
	
	}
	function check_unique_code(){
		$uniqueName = $this->input->post('uniqueName');
		$CountName = count($this->registration_model->checkUniqueName($uniqueName));
		if($CountName == 0){
			$msg['error'] = 0;
		}else{
			$msg['error'] = 1;
		}
		echo json_encode($msg);
	}

	

	

}

