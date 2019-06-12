<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Account extends YK_Controller{
	function __construct(){
		parent::__construct();
		checkAuth();
		$this->load->model("account_model","account");
	}
	
	function index(){
		//if($this->user_type == "customer"){
		$activity = $this->account->get_all(array("delete_flag"=>0),"title DESC","*");
		$data["activity"] = $activity;
		$getPaymentMethod = $this->account->customerPaymentMethods($this->user_id);
		$getPets = $this->account->getPets();
		$pest_dd[""] = "Select Pet";
		if(!empty($getPets)) foreach($getPets as $val) $pest_dd[$val["pets_id"]] = ucwords($val["name"]);
		$data["pets_list"] = $pest_dd;
		$payment_list = array();
		if(!empty($getPaymentMethod)) foreach($getPaymentMethod as $val) $payment_list[$val['id']] = ucwords($val["name_on_card"]);
		$data["payment_list"] = $payment_list;
		
		$activity_dd[""] = "Select Activity";
		foreach($activity as $val){
			$activity_dd[$val["id"]] = ucwords($val["title"]);
		}

		$data["activity_dd"] = $activity_dd;

		$pets_type = $this->account->getPetsType();
		$pets_type_dd[""] = "Select Type";
		foreach($pets_type as $val) $pets_type_dd[$val["type_id"]] = ucwords($val["pets_name"]);
		$data["pets_type"] = $pets_type_dd;
		$this->load->view("account_page",$data);
		/* }elseif($this->user_type == "partner"){
			
			$data = array();
			$availibility = $this->account->get_availability();
			if(isset($availibility[0])){
				$availibility = $availibility[0];
			}else{
				$availibility = array();
			}
			$data["partner_availability"] = $availibility;
			$schedule = $this->get_partner_schedule(TRUE);
			
			$activity = $this->account->getPartnerActivity();
			
			$media = $this->account->getPartnerActivityMedia();
			
			$mdata = array();
			foreach($media as $val){
				$mdata[$val["activity_id"]][] = $val;
			}
			
			foreach($activity as $key => $val){
				$activity[$key]["media"] = isset($mdata[$val["activity_id"]]) ? $mdata[$val["activity_id"]] : array();
			}
			$data["activity"] = $activity;
			
			$data["all_activity"] = $this->account->getAllActivity();
			$data["partner_schedule"] = isset($schedule[0]) ? $schedule[0] : array();
			$this->load->view("account_partner",$data);
		}else if($this->user_type == "employee"){

		}else{

		} */
	}

	function get_partner_schedule($flag=FALSE){
		$date = $this->input->post("date",true) == "" ? date("Y-m-d") : $this->input->post("date",true);
		$data = $this->account->getPartnerScheduleByDate($date);
		return $data;
	}

	function search_partner(){
		$activity_id = $this->input->post("activity_id",true);
		$partner_name = strtolower($this->input->post("partner_name",true));
		$data = array();
		if($activity_id == ""){
			$status = 0;
			$message = "Please select activity";
		}else{
			$select = "*";
			$this->account->tbl = $this->account->tbl_partner_services;
			$getPartnerByActivity = $this->account->get_all(array("activity_id"=>$activity_id,"delete_flag"=>0),"id DESC","partner_id as partner_id");
			$partner_id = array();
			if(!empty($getPartnerByActivity)){
				foreach($getPartnerByActivity as $val) $partner_id[] = $val["partner_id"];
			}
			if(!empty($partner_id)){
				$select = "";
				$this->account->tbl = $this->account->tbl_partner;
				$like = "";
				if($partner_name != "")	$like = " AND (LOWER(c.business_name) LIKE '$partner_name%' OR LOWER(c.name) LIKE '$partner_name%') ";
				$where = " c.id IN(".implode(",",$partner_id).") $like AND c.is_available = 1 AND c.delete_flag = 0";
				$sel = "c.id as partner_id, c.name as partner_name, c.profile as partner_profile, c.business_name as business_name, cm.city_name as city_name, cm.city_code as city_code";
				$join[] = array("table" => $this->account->tbl_city_master." cm","condition" => " c.city = cm.city_id","type" => "LEFT");
				
				$getPartner = $this->account->get_all($where,"business_name ASC",$sel,$join);
				if($getPartner){
					$html = $this->load->view("partner/partner_service",array("partner"=>$getPartner),TRUE);
					$status = 1;
					$message = "Success";
					$data = $html;
				}else{
					$status = 1;
					$message = "Success";
					$data = "";
				}
			}else{
				$status = 0;
				$message = "Partner name is emptys";
				$data = "";
			}
		}
		echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$data));
	}
	function activity_details(){
		$partner_id = $this->input->post("partner_id",true);
		$activity_id = $this->input->post("activity_id",true);
		if($partner_id != "" && $activity_id != ""){
			$getPartner = $this->account->service_activity($activity_id, $partner_id);
			if(!empty($getPartner) && isset($getPartner[0])){
				$data["partner"] = $getPartner[0];
				$data["media"] = $this->account->getActivityMedia($activity_id,$partner_id);
				
				$html = $this->load->view("partner/service_details", $data,TRUE);
				$status = 1;
				$message = "Success!";
			}else{
				$status = 0;
				$message = "Something went wrong!";
				$data = "";
			}
		}else{
			$status = 0;
			$message = "Something went wrong!";
			$data = "";
		}
		echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$html));
	}
	function booking_form(){
		$activity_id = $this->input->post("activity_id",TRUE);
		$partner_id = $this->input->post("partner_id",TRUE);
		if($activity_id != "" && $partner_id != "" && $this->user_id != ""){
			$getPaymentMethod = $this->account->customerPaymentMethods($this->user_id);
			//$getPartnerDates = $this->account->getParterAvailableDates($this->user_id);
			$getPets = $this->account->getPets();
			$pest_dd[""] = "Select Pet";
			if(!empty($getPets)) foreach($getPets as $val) $pest_dd[$val["pets_id"]] = ucwords($val["name"]);
			$data["pets_list"] = $pest_dd;
			$payment_list = array();
			if(!empty($getPaymentMethod)) foreach($getPaymentMethod as $val) $payment_list[$val['id']] = ucwords($val["name_on_card"]);
			$data["payment_list"] = $payment_list;
			$html = $this->load->view("partner/book_form",$data,TRUE);
			$res["status"] = 1;
			$res["message"] = "Success!";
			$res["data"] = $html;
		}else{
			$res["status"] = 0;
			$res["message"] = "Success!";
			$res["data"] = $html;
		}
		echo json_encode($res);
	}

	function get_open_order(){
		$getPndingrder = $this->account->getCustomerPendingOrder();
		$data["pending_order"] = $getPndingrder;
		
		if(!empty($getPndingrder)){
			$html = $this->load->view("customer/pending_order",$data,TRUE);
			$res["status"] = 1;
			$res["message"] = "Success!";
			$res["data"] = $html;
		}else{
			$res["status"] = 0;
			$res["message"] = "Failed!";
			$res["data"] = "";
		}
		echo json_encode($res);
	}

	function get_pending_order_form(){
		$order_id = $this->input->post("order_id",true);
		$html = '';
		if($order_id != ""){
			$getPndingrder = $this->account->getCustomerPendingOrderForm($order_id);
			
			
			if(!empty($getPndingrder) && isset($getPndingrder[0])){
				$data["pending_order"] = $getPndingrder[0];
				$getPets = $this->account->getPets();
				$pest_dd[""] = "Select Pet";
				if(!empty($getPets)) foreach($getPets as $val) $pest_dd[$val["pets_id"]] = ucwords($val["name"]);
				$data["pets_list"] = $pest_dd;

				$getPaymentMethod = $this->account->customerPaymentMethods($this->user_id);
				$payment_list = array();
				if(!empty($getPaymentMethod)) foreach($getPaymentMethod as $val) $payment_list[$val['id']] = ucwords($val["name_on_card"]);
				$data["payment_list"] = $payment_list;
				$html = $this->load->view("customer/pending_order_form",$data,TRUE);
				$res["lat"] = @$data["pending_order"]["lat"];
				$res["long"] = @$data["pending_order"]["long"];
				$res["status"] = 1;
				$res["message"] = "Success!";
				$res["data"] = $html;
			}else{
				$res["status"] = 0;
				$res["message"] = "Success!";
				$res["data"] = $html;
			}
		}else{
			$res["status"] = 0;
			$res["message"] = "Success!";
			$res["data"] = $html;
		}
		echo json_encode($res);
	}

	function get_breed(){
		$pets_type = $this->input->post("pets_type");
		$html = '<option value="">Select Type</option>';
		if($pets_type != ""){
			$breed_data = $this->account->getBreedType($pets_type);
			if(!empty($breed_data)){
				foreach($breed_data as $val) $html .= '<option value="'.$val["breed_id"].'">'.$val["name"].'</option>';
				$status = 1;
				$message = "Success";
				$data = $html;
			}else{
				$status = 0;
				$message = "Failed";
				$data = "";
			}
		}else{
			$status = 0;
			$message = "Failed";
			$data = "";
		}
		echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$data));
	}

	function get_schedule(){
		$date = $this->input->post("date",true);
		if($date != ""){
			$date = date("Y-m-d",strtotime($date));
			$schedule = $this->get_partner_schedule();
			$availibility = $this->account->get_availability();
			if(isset($availibility[0])){
				$availibility = $availibility[0];
				$availibility["from_time"] = @$availibility["from_time"] != "" ? date("h:i A",strtotime($availibility["from_time"])) : "";
				$availibility["to_time"] = @$availibility["to_time"] != "" ? date("h:i A",strtotime($availibility["to_time"])) : "";
			}else{
				$availibility = array();
			}
			$data["partner_availability"] = $availibility;
			$schedule = $this->get_partner_schedule(TRUE);
			
			$data["partner_schedule"] = isset($schedule[0]) ? $schedule[0] : array();
			$status = 1;
			$message = "Success";
		}else{
			$data = array();
			$status = 1;
			$message = "Success";
		}
		echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$data));
	}

	function update_service(){
		$this->user_id;
	}

	function get_unadded_service(){
		if($this->user_id != ""){
			$service = $this->account->getUnaddedService();
			
			if(!empty($service)){
				$result = 1;
				$message = "Success!";
				$html = '<option value="">Select Service</option>';
				foreach($service as $val){
					$html .= '<option value="'.$val["id"].'">'.ucwords($val["title"]).'</option>';
				}
				$data = $html;
			}else{
				$message = 'All Service updated!';
				$result = 0;
				$data = "<option value=''>All Service updated</option>";
			}
		}else{
			$data = "";
			$message = "Failed!";
			$result = 0;
		}
		echo json_encode(array("result"=>$result,"message"=>$message,"data"=>$data));
	}
}