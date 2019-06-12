<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends YK_Controller{
  function __construct(){
		parent::__construct();
		checkAuth();
		$this->load->model("profile_model","profile");
  }
	
	function index(){
		if($this->user_type == "customer"){
			$profile_data = $this->profile->customerProfile();
			echo "Under working...";
			exit;
			$this->load->view("profile_customer");
		}elseif($this->user_type == "partner"){
			$this->profile->tbl = $this->profile->tbl_partner;
			$profile_data = $this->profile->partnerProfile();
			$data["profile_data"] = isset($profile_data[0]) ? $profile_data[0] : array();
			
			$this->profile->tbl = $this->profile->tbl_partner_services;
			$join[] = array("table" => $this->profile->tbl_activities." a","condition" => "c.activity_id = a.id","type" => "LEFT");
			$where = array("c.partner_id"=>$this->user_id,"c.delete_flag"=>0,"a.delete_flag"=>0);
			$sel = "a.title as name, c.activity_id as activity_id, a.image as image";
			$activity = $this->profile->get_all($where,"a.title ASC",$sel,$join);
			$data["activity"] = $activity;
			$this->load->view("profile_partner",$data);
		}else{

		}
	}


	function customer_profile(){
		$user_data = $this->profile->customerProfile();
		if(!empty($user_data)){
			$user_data = isset($user_data[0]) ? $user_data[0] : array();
			foreach($user_data as $key => $val) $user_data[$key] = $val == "" || $val == NULL ? "" : $val;
			$data["Result"] = 1;
			$data["Message"] = "Success";
			$data["user_data"] = $user_data;
			$data["pets_data"] = $this->profile->get_customer_pets();
		}else{
			$data["Result"] = 1;
			$data["Message"] = "No user found";
		}
		echo json_encode($data);
	}
	
}