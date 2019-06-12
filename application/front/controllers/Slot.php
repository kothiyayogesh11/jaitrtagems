<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Slot extends YK_Controller{
  function __construct(){
		parent::__construct();
		checkAuth();
		$this->load->model("slot_model","slot");
  }
	
	function index(){
		$slot = $this->slot->get_pending_order_for_partner();
		$data["slot"] = $slot;
		pre($data["slot"]);
		$this->load->view("partner_slot",$data);
	}
}