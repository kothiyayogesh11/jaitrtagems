<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/01/2019
 * Time: 06:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("dashboard_model", 'dashboard', true);
    }
    public function index(){
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('general/home',$rsListing);
    }
	
	public function count_user(){
		
		$from_date = date("Y-m-d",strtotime("-7 days"));
		$to_date = $this->datetime;
		$cnt = $this->dashboard->count_user();
		$cnt_7 	= $this->dashboard->count_by_date($from_date, $to_date);
		$array["error"] = 0;
		$array["week"] = "(".str_pad(number_format(intval($cnt_7)),2,"0",STR_PAD_LEFT)." users join with us in week)";
		$array["totol"] = str_pad(number_format(intval($cnt)),2,"0",STR_PAD_LEFT);
		$this->general->gererate_json($array);
	}
	
	public function count_pets(){
		$this->dashboard->tbl = $this->dashboard->tbl_pet_master;
		$from_date = date("Y-m-d",strtotime("-7 days"));
		$to_date = $this->datetime;
		$cnt = $this->dashboard->count_user();
		$cnt_7 	= $this->dashboard->count_by_date($from_date, $to_date);
		$array["error"] = 0;
		$array["week"] = "(".str_pad(number_format(intval($cnt_7)),2,"0",STR_PAD_LEFT)." pets added in week)";
		$array["totol"] = str_pad(number_format(intval($cnt)),2,"0",STR_PAD_LEFT);
		$this->general->gererate_json($array);
	}
	
	function count_pending_order(){
		$this->dashboard->tbl = $this->dashboard->tbl_available_slot;
		$from_date = date("Y-m-d",strtotime("-7 days"));
		$to_date = $this->datetime;
		$cnt = $this->dashboard->count_pending_order();
		$cnt_7 	= $this->dashboard->count_pending_order_by_date($from_date, $to_date);
		$array["error"] = 0;
		$array["week"] = "(".str_pad(number_format(intval($cnt_7)),2,"0",STR_PAD_LEFT)." order added in week)";
		$array["totol"] = str_pad(number_format(intval($cnt)),2,"0",STR_PAD_LEFT);
		$this->general->gererate_json($array);
	}
	
	function count_order(){
		$this->dashboard->tbl = $this->dashboard->tbl_available_slot;
		$from_date = date("Y-m-d",strtotime("-7 days"));
		$to_date = $this->datetime;
		$cnt = $this->dashboard->count_order();
		$cnt_7 	= $this->dashboard->count_order_by_date($from_date, $to_date);
		$array["error"] = 0;
		$array["week"] = "(".str_pad(number_format(intval($cnt_7)),2,"0",STR_PAD_LEFT)." order added in week)";
		$array["totol"] = str_pad(number_format(intval($cnt)),2,"0",STR_PAD_LEFT);
		$this->general->gererate_json($array);
	}
}