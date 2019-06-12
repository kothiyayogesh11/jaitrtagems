<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 29/12/2018
 * Time: 06:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Schedule extends YK_Controller{
	public $week;
    function __construct(){
        parent::__construct();
        $this->load->model("schedule_model", 'schedule', true);
    }
    public function index(){
        $this->schedule->alias = 'p';
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = "p.*";
        $searchCriteria["orderField"] = $this->schedule->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->schedule->searchCriteria=$searchCriteria;
        $rsData = $this->schedule->schedule_list();
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('schedule/list',$rsListing);
    }
	
	function get_week($week = 8){
		$this->week = str_pad($week,2,"0",STR_PAD_LEFT);
		$check_alreadyadd = $this->schedule->get_by_id('week', $this->week);
		if(!empty($check_alreadyadd)){
			$this->week = intval($this->week) + 1;
			$this->get_week($this->week);
		}
		$this->week = str_pad($this->week,2,"0",STR_PAD_LEFT);
		return $this->week;
	}
	
	function set_weekley(){
		$date = date("Y-m-d");
		$ts = strtotime($date);
		$year = date('o', $ts);
		$week = $this->week = date('W', $ts);
		$check_current = $this->schedule->get_by_id('week', $this->week);
		$weekDates = array();
		$k = 0;
		if(empty($check_current)){
			for($i = 0; $i <= 6; $i++) {
				$ts = strtotime(date("Y").'W'.$this->week.$i);
				$weekDates[$k]["schedule_date"] = date("Y-m-d", $ts);
				$weekDates[$k]["week"] 			= $this->week;
				$weekDates[$k]["insertDate"] 	= $this->datetime;
				$weekDates[$k]["insertBy"] 		= $this->user_id;
				$weekDates[$k]["insertIp"] 		= $this->ip;
				$k++;
			}
		}
		
		$date = date("Y-m-d",strtotime("+1 week"));
		$ts = strtotime($date);
		$year = date('o', $ts);
		$week = $this->week = date('W', $ts);
		$check_current = $this->schedule->get_by_id('week', $this->week);

		if(empty($check_current)){
			for($i = 0; $i <= 6; $i++) {
				$ts = strtotime(date("Y").'W'.$this->week.$i);
				$weekDates[$k]["schedule_date"] = date("Y-m-d", $ts);
				$weekDates[$k]["week"] 			= $this->week;
				$weekDates[$k]["insertDate"] 	= $this->datetime;
				$weekDates[$k]["insertBy"] 		= $this->user_id;
				$weekDates[$k]["insertIp"] 		= $this->ip;
				$k++;
			}
		}
		
		if(!empty($weekDates)){
			$ins = $this->schedule->insert_batch($weekDates);
		}
	}
	
	function get_weeks_date(){
		$weekDates = array();
		for($i = 0; $i <= 6; $i++) {
			$ts = strtotime(date("Y").'W'.$this->week.$i);
			$weekDates[] = date("Y-m-d", $ts);
		}
		return $weekDates;
	}
	
    public function form(){
		$data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		if($id != ""){
			$data["rsEdit"] = $this->schedule->get_by_id('id', $id);
			//pre($data);exit;
			$weekDates[] = $data["rsEdit"]->schedule_date;
			$week = $data["rsEdit"]->week;
		}else{
			
			$date = date("Y-m-d");
			$ts = strtotime($date);
			$year = date('o', $ts);
			$week = $this->week = date('W', $ts);
			$check_alreadyadd = $this->schedule->get_by_id('week', $this->week);
			if(!empty($check_alreadyadd)){
				$this->week = $this->get_week(intval($this->week));
			}
			
			$weekDates = array();
			for($i = 0; $i <= 6; $i++) {
				$ts = strtotime($year.'W'.$this->week.$i);
				$weekDates[] = date("Y-m-d", $ts);
			}
			$data["rsEdit"] = array();
		}
		
		
		$data["weekDates"] = $weekDates;
        $data["week"] = $this->week;
		
        $this->load->view('schedule/form',$data);
    }

    public function process(){
		$this->schedule->alias = 'p';
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		
		
		/* Validation */
		if(@$post["week"] == ""){
			$error = 1;
			$this->page->setMessage("ERROR","Week is empty");
		}else if(empty($post["date"])){
			$error = 1;
			$this->page->setMessage("ERROR","Schedule date is empty");
		}else{
			$error = 0;
		}
		if($error == 1) redirect("schedule");
		/* End */
		$week = $post["week"];
        if($hid_id == ""){
			$data = array();
			if(isset($post["fhh"]) && is_array($post["fhh"]) && !empty($post["fhh"])){
				$i = 0;
				foreach($post["fhh"] as $key => $val){
					$from_time = $to_time = "";
					if($val != ""){
						$fmm = @$post["fmm"][$key] == "" ? "00" : $post["fmm"][$key];
						$from_time = $val.":".$fmm.":00";
					}
					
					if(@$post["thh"][$key] != ""){
						$tmm = @$post["tmm"][$key] == "" ? "00" : $post["tmm"][$key];
						$to_time = $post["thh"][$key].":".$tmm.":00";
					}
					
					$data[$i]["schedule_date"] 	= date("Y-m-d",strtotime($post["date"][$key]));
					$data[$i]["from_time"] 		= $from_time == "" ? NULL : $from_time;
					$data[$i]["to_time"] 		= $to_time == "" ? NULL : $to_time;
					$data[$i]["week"] 			= $week;
					$data[$i]['insertBy']		= $this->user_id;
					$data[$i]['insertDate'] 	= $this->datetime;
					$data[$i]["insertIp"] 		= $this->ip;
					$i++;
				}
			}else{
				$this->page->setMessage("ERROR","Please select time to schedule");
				redirect("schedule");
			}
			
			if(empty($data)){
				$this->page->setMessage("ERROR","Provide proper schedule");
				redirect("schedule");
			}
			
            $intCenterID = $this->schedule->insert_batch($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
			
			$data = array();
			if(isset($post["fhh"]) && is_array($post["fhh"]) && !empty($post["fhh"])){
				$i = 0;
				foreach($post["fhh"] as $key => $val){
					$from_time = $to_time = "";
					if($val != ""){
						$fmm = @$post["fmm"][$key] == "" ? "00" : $post["fmm"][$key];
						$from_time = $val.":".$fmm.":00";
					}
					
					if(@$post["thh"][$key] != ""){
						$tmm = @$post["tmm"][$key] == "" ? "00" : $post["tmm"][$key];
						$to_time = $post["thh"][$key].":".$tmm.":00";
					}
					
					$data["schedule_date"] 	= date("Y-m-d",strtotime($post["date"][$key]));
					$data["from_time"] 		= $from_time == "" ? NULL : $from_time;
					$data["to_time"] 		= $to_time == "" ? NULL : $to_time;
					$data["week"] 			= $week;
					$data['updateby'] 	= $this->user_id;
					$data['updatedate'] = $this->datetime;
					$data['updateIp']	= $this->ip;
					$i++;
				}
			}else{
				$this->page->setMessage("ERROR","Please select time to schedule");
				redirect("schedule");
			}
			
			if(empty($data)){
				$this->page->setMessage("ERROR","Provide proper schedule");
				redirect("schedule");
			}
			
            $this->schedule->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
        redirect('schedule', 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->schedule->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('schedule', 'location');
    }
	
}