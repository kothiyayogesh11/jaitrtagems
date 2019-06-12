<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Activity extends YK_Controller{
  function __construct(){
		parent::__construct();
		$this->load->model("activity_model","activity");
  }
	
	function book(){
		$activity_id = trim($this->input->post("activity"));
		$slot_id = trim($this->input->post("slot"));
		$partner_id = trim($this->input->post("partner"));
		$payment_method = trim($this->input->post("payment_method"));
		$location = trim($this->input->post("location"));
		$pet_id = trim($this->input->post("pets"));
		$already_book = $this->activity->check_slot_availibility($slot_id);	
		if($already_book > 0){
			$status["is_book"] = 2;
			$status["activity_id"] = $activity_id;
			$status["book_time"] = date("Y-m-d H:i:s");
			$status["book_by"] = $this->user_id;
			$status["updateDate"] = $this->datetime;
			$status["updateBy"] = $this->user_id;
			$status["updateIp"] = $this->ip;
			$upd_temp_status = $this->activity->update_order_status($status, $slot_id);
			$affected_rows = $this->db->affected_rows();
			if($affected_rows > 0){
				$data["activity_id"] 	= $activity_id;
				$data["slot_id"] 		= $slot_id;
				$data["pet_id"] 		= $pet_id;
				$data["location"] 		= $location;
				$data["status"] 		= "pending";
				$data["payment_method"] = $payment_method;
				$data["user_id"] 		= $this->user_id;
				$data["partner_id"] 	= $partner_id;
				$data["insertDate"] 	= $this->datetime;
				$data["insertBy"] 		= $this->user_id;
				$data["insertIp"] 		= $this->ip;
				$add = $this->activity->book($data);
				if($add){
					$res['Result'] = 1;
					$res['Message'] = 'Success!';
				}else{
					$res['Result'] = 0;
					$res['Message'] = 'Failed!';
				}
			}else{
				$res['Result'] = 0;
				$res['Message'] = 'Something went wrong!';
			}
		}else{
			$res['Result'] = 0;
			$res['Message'] = 'Already book!';
		}
		$this->general->gererate_json($res,200);
	}
}