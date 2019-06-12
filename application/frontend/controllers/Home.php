<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends YK_Controller{
    function __construct(){
		parent::__construct();
		$this->load->model("home_model","home");
    }
	
	function index(){
		$this->load->view("home");
	}
	function activity(){
		$activity_list = $this->order->get_activity();
		$data["activity_list"] = $activity_list;
		$this->load->view("customer_home",$data);
	}
	function get_activity_partner(){
		$post = $this->input->post();
		$activity_id = @$post["activity"];
		$data["activity_id"] = $activity_id;
		if($activity_id != ""){
			/* Get Activity Details */
			$data["activity"] = $this->activity_details($activity_id);
			
			/* Get Pets List */
			$data["pets_potion"] = $this->pets_dropdown();
			/* Get Available Partners */
			$data["partner_option"] = $this->partner_dropdown();
			/* Get Customer Payment Details */
			$data["payment_option"] = $this->custmer_payment_dropdown();
		}else{
		}
		$this->load->view("book_form",$data);
	}
	function custmer_payment_dropdown(){
		if(empty($this->user_id)){
			$this->response($this->err_msg['user_id_empty'],200);
		}else{
			$this->home->tbl = $this->home->tbl_user_payment_type;
			$where = "user_id = ".$this->user_id." AND delete_flag = 0";
			$order = "id DESC";
			$columns= "id as method_id, user_id, number as account_number, card_type, name_on_card";
			$get_methods = $this->home->get_all($where, $order, $columns);
			return $get_methods;
		}
	}
	function pets_dropdown(){
		$this->home->tbl = $this->home->tbl_pet_master;
		$where = array("client_id"=>$this->user_id,"delete_flag"=>0);
		$petsData = $this->home->get_all($where,"name DESC","id, client_id,	name, profile, pet_type, breed,	age, weight");
		return $petsData;
	}
	function partner_dropdown(){
		$post = $this->input->post();
		$activity_id = @$post["activity"];
		$this->home->tbl = $this->home->tbl_partner_services;
		$this->home->alias = "c";
		$where = " c.activity_id = ".$activity_id." AND c.partner_id = p.id AND  c.delete_flag = 0 AND p.delete_flag = 0";
		$order = "c.id DESC";
		$join = array(array("table"=>$this->home->tbl_partner." p","condition"=>"c.partner_id = p.id","type"=>"LEFT"));
		$get_slot = $this->home->get_all($where,$order,"p.name as partner_name, p.id as partner_id, p.email as email, p.profile as profile,p.lat, p.long",$join);	
		return $get_slot;
	}
	function get_available_slot(){
		$activity_id = $this->input->post("activity");
		$partner_id = $this->input->post("partner_id");
		$date = trim($this->input->post("date"));
		$date = $date == "" ? date("Y-m-d H:i:s") : date("Y-m-d H:i:s",strtotime($date));
		if($activity_id == ""){
			$res = array("Result"=>0,"Message"=>"Activity id is empty");
		}else if($partner_id == ""){
			$res = array("Result"=>0,"Message"=>"Partner id is empty");
		}else{	
			$this->home->tbl = $this->home->tbl_partner;
			$partner = (array)$this->home->get_by_id("id",$partner_id,array("delete_flag"=>0));
			if(empty($partner)){
				$res = array("Result"=>0,"Message"=>"Invalide partner id");
			}else if($partner["is_available"] == 0){
				$res = array("Result"=>0,"Message"=>"Partner is Unavailable at the movement");
			}else{
				$this->home->tbl = $this->home->tbl_partner_schedule;
				$parnter_schedule = (array)$this->home->get_by_id("partner_id",$partner_id,array("available_date"=>date("Y-m-d")));
				if(empty($parnter_schedule)){
					$res = array("Result"=>0,"Message"=>"Partner is Unavailable at the movement");
				}else{
					$this->home->tbl = $this->home->tbl_partner_services;
					$get_service = (array)$this->home->get_by_id("activity_id",$activity_id,array("partner_id"=>$partner_id));
					if(empty($get_service)){
						$res = array("Result"=>0,"Message"=>"This service is not provide by this partner");
					}else{
						$this->home->tbl = $this->home->tbl_available_slot;
						$where = array("partner_id"=>$partner_id,"date"=>date("Y-m-d",strtotime($date)),"is_book"=>0);
						$slot_data = $this->home->get_all($where,"from_time DESC","id as slot_id, date, from_time, to_time");
						if(!empty($slot_data)){
							$res["Result"] = 1;
							$res["data"] = "<option value=''>-- Select Slot --</option>";
							foreach($slot_data as $val){
								$time = date("h:i A",strtotime($val["from_time"]))." - ".date("h:i A",strtotime($val["to_time"]));
								$res["data"] .= "<option value='".$val["slot_id"]."'>".$time."</option>";
							}
						}else{
							$res["Result"] = 0;
							$res["Message"] = "No slots available at the movements.";
						}
					}
				}
			}
		}
		echo json_encode($res);
	}
	function activity_details($activity_id = NULL){
		if($activity_id != ""){
			$this->home->tbl = $this->home->tbl_activities;
			$select = "id as activity_id, title, description, image, address, lat, long, price,	price_type";
			$get_activity = $this->home->get_all(array("id"=>$activity_id,"delete_flag"=>0),"title DESC",$select);
			$data["activity"] = $get_activity;
			
			$this->home->tbl = $this->home->tbl_activities_media;
			$select = "id as media_id, banner_id as activity_id, file as media,	type";
			$get_activity = $this->home->get_all(array("banner_id"=>$activity_id,"delete_flag"=>0),"media_id DESC",$select);
			$data["activity_media"] = $get_activity;
			return $data;
		}
	}
}