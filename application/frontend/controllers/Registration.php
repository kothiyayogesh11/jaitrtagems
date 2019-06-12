<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Registration extends YK_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->model("registration_model","registration");
    }

    function email_check(){
        $user_type  = $this->input->post("user_type",true);
        $email      = $this->input->post("email",true);
        if($email == ""){
            $status = 0;
            $message = "Email is empty!";
        }else if($user_type == ""){
            $status = 0;
            $message = "Select user type to user our services";
        }else{
            $where = array("email"=>$email);
            if($user_type == "customer"){
                $this->registration->tbl = $this->registration->tbl_client_master;
                $count = $this->registration->count_by_where($where);
                if($count > 0){
                    $status = 0;
                    $message = "Email already exists in our system";
                }else{
                    $status = 1;
                    $message = "";
                }
            }else if($user_type == "partner"){
                $this->registration->tbl = $this->registration->tbl_partner;
                $count = $this->registration->count_by_where($where);
                if($count > 0){
                    $status = 0;
                    $message = "Email already exists in our system";
                }else{
                    $status = 1;
                    $message = "";
                }
            }else{
                $status = 0;
                $message = "Select user type to user our services";
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array("status"=>$status,"message"=>$message)));
    }

    function add(){
        $post = $this->input->post(NULL,true);
        $user_type = $post["login_type"];
        if(@$post["email"] == ""){
            $this->page->setMessage("ERROR","Email is empty","add_account");
            redirect("home#section-account");
        }elseif(!filter_var(@$post["email"],FILTER_VALIDATE_EMAIL)){
            $this->page->setMessage("ERROR","Provide us your valid email","add_account");
            redirect("home#section-account");
        }else{
            $data["name"]           = ucwords(@$post["user_name"]);
            $data["email"]          = $post["email"];
            $data["password"]       = sha1($post["password"]);
            $data["mobile"]         = $post["mobile"];

            if($user_type == "partner"){
                $data["business_name"]  = $post["business_name"];
                $this->registration->tbl = $this->registration->tbl_partner;
                $count = $this->registration->count_by_where(array("email"=>$data["email"]));
                if($count > 0){
                    $this->page->setMessage("ERROR","Email already exists","add_account");
                }else{
                    $add = $this->registration->insert($data);
                    if($add){
                        $this->page->setMessage("SUCCESS","Your account is added in our system, you can login with your email or passwrd as a $user_type","add_account");
                    }else{
                        $this->page->setMessage("ERROR","System failour! Please try again later","add_account");
                    }
                }
            }else if($user_type == "custmer"){
                
                $this->registration->tbl = $this->registration->tbl_client_master;
                $count = $this->registration->count_by_where(array("email"=>$data["email"]));
                if($count > 0){
                    $this->page->setMessage("ERROR","Email already exists","add_account");
                }else{
                    $add = $this->registration->insert($data);
                    if($add){
                        $this->page->setMessage("SUCCESS","Your account is added in our system, you can login with your email or passwrd as a $user_type","add_account");
                    }else{
                        $this->page->setMessage("ERROR","System failour! Please try again later","add_account");
                    }
                }
            }else{
                $this->page->setMessage("ERROR","Provide registration type so we can identify you as partner or employee","add_account");
            }
        }
        redirect("home#section-account");
    }
}