<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends YK_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->model("login_model","login");
    }
    function text(){
        $this->load->view("login_multiple");
    }

    function index()
    {
        $post = $this->input->post();   
        if ($this->agent->is_referral()){
            $back_url = $this->agent->referrer();
        }else{
            $back_url = base_url("home");
        }
        $error = 0;
        if(!empty($post)){
            $email  = strtolower(trim(@$post["email"]));
            $pass   = trim(@$post["password"]);
            if($email == ""){
                $this->page->setMessage("ERROR","Email is empty!");
                $error = 1;
            }

            if($pass == ""){
                $this->page->setMessage("ERROR","Password is empty!");
                $error = 1;
            }

            if($error == 0){
                $where = "LOWER(email) = '" . $email . "' AND password = '".sha1($pass)."' AND delete_flag = 0";
                $select = "id as user_id, name as user_name, profile as user_profile, LOWER(email) as user_email,gender,mobile,city,state,country,registration_type,profile_id";
                $get_employee = $this->login->get_all($where, "id DESC", $select);

                if (!empty($get_employee) && isset($get_employee[0])) {
                    $get_employee = $get_employee[0];
                    $get_employee["user_type"] = "customer";
                    $this->session_setter($get_employee);
                    $back_url = base_url("account");
                } else {
                    $this->page->setMessage("ERROR", "Invalid email or password!");
                }
            }else{
				$this->page->setMessage("ERROR", "Invalid email or password!");
			}
        }else{
            $this->page->setMessage("ERROR","Username or password is empty!");
        }
        redirect($back_url);
    }

    function session_setter($arr = array()){
        return $this->session->set_userdata($arr);
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url("home#section-account"));
    }

    function check(){
        $post = $this->input->post(NULL, TRUE);
        
        $status = 1;
        $message = "";
        if(!empty($post)){
            $email  = trim(@$post["email"]);
            $pass   = trim(@$post["password"]);
            if($email == ""){
                $message = "Email is empty!";
                $status = 0;
            }
            
            if($pass == ""){
                $message = "Password is empty!";
                $status = 0;
            }

            if($status == 1){
                $where = "email = '" . $email . "' AND password = '" . sha1($pass) . "' AND delete_flag = 0";
                $select = "id as user_id, name as user_name, profile as user_profile, email as user_email,gender,mobile,city,state,country,registration_type,profile_id";
                $get_employee = $this->login->get_all($where, "id DESC", $select);
                if (!empty($get_employee) && isset($get_employee[0])) {
                    $status = 1;
                    $message = "";
                } else {
                    $message = "Invalid email or password";
                    $status = 0;
                }
            }else{
				$status = 0;
                $message = "";
			}
        }else{
            $status = 0;
            $message = "Provide login email or password to access your account";
        }
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
}