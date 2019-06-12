<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends YK_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('forgot_password_model','password');
    }
	
	function view(){
		$otp = $this->uri->segment(3);
		$data['otp'] = $otp;
		$data['user'] = $this->password->getUserByOtp($data['otp'],1);
		$data['msg'] = empty($data['user']) ? get_message('No user found!',1) : '';
		$data["u_type"] = 1;
		$this->load->view('api_view/forgot_password',$data);
	}
	
	function view_employee(){
		$otp = $this->uri->segment(3);
		$data['otp'] = $otp;
		$data['user'] = $this->password->getUserByOtp($data['otp'],2);
		$data['msg'] = empty($data['user']) ? get_message('No user found!',1) : '';
		$data["u_type"] = 2;
		$this->load->view('api_view/forgot_password',$data);
	}
	
	function view_partner(){
		$otp = $this->uri->segment(3);
		$data['otp'] = $otp;
		$data['user'] = $this->password->getUserByOtp($data['otp'],3);
		$data['msg'] = empty($data['user']) ? get_message('No user found!',1) : '';
		$data["u_type"] = 3;
		$this->load->view('api_view/forgot_password',$data);
	}
	
	function process(){
		$otp = trim($this->input->post('otp'));
		$pass = sha1(trim($this->input->post('password')));
		$cpass = sha1(trim($this->input->post('cpassword')));
		$u_type = $this->input->post("u_type") == "" ? 1 : $this->input->post("u_type");
		$data = array();
		if($otp == ''){
			$data['msg'] = get_message('link expired, try again',1);
		}else if($cpass == '' || $pass == ''){
			$data['msg'] = get_message('enter both are same',1);
		}else if($pass != $cpass){
			$data['msg'] = get_message('enter both are same',1);
		}else{
			$user = $this->password->getUserByOtp($otp,$u_type);
			if(!empty($user)){
				$this->user_id = @$user[0]['uid'];
				$res = $this->password->change(array('password'=>$pass),$u_type);
				if($res){
					$this->password->removeOtp($otp,$u_type);
					$data['msg'] = get_message('Your password has been changed successfully',0);
				}else{
					$data['msg'] = get_message('Failed to change password',1);
				}
			}else{
				$data['msg'] = get_message('link expired, try again',1);
			}
		}
		$this->load->view('api_view/forgot_password',$data);
	}
	
}