<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/04/2019
 * Time: 02:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("notification_model", 'notification');
    }
    public function index(){
        $this->notification->alias = 'c';
		// Get All pets_list
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->notification->alias.".*";
        $searchCriteria["orderField"] = $this->notification->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->notification->searchCriteria=$searchCriteria;
        $rsData = $this->notification->list_all();
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('notification/list',$rsListing);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		$data["user_list"] = $this->notification->get_all_user();
        if ($id != ""){
            $data["rsEdit"] 	= $this->notification->get_by_id('id', $id);
			$editUser = $this->notification->get_notification_user($id);
			$data["rsUsers"] = array();
			if(!empty($editUser)) foreach($editUser as $val) $data["rsUsers"][] = $val["user_id"];
        }else{
            $data["rsEdit"] = array();
        }

        $this->load->view('notification/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		
		$for = isset($post["for"]) && !empty($post["for"]) ? array_filter($post["for"]) : array();
		
		$data["title"] 			= @$post["title"];
		$data["content"] 			= @$post["content"];
		
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->notification->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $data['updateby'] 	= $this->user_id;
            $data['updateDate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->notification->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		
		/* Add User */
		$this->notification->removeUser($hid_id);
		if(isset($for) && !empty($for)){
			$add_user = array();
			$i=0;
			foreach($for as $val){
				if($val != ""){
					$add_user[$i]["pushId"] 	= $hid_id;
					$add_user[$i]["user_id"] 	= $val;
					$add_user[$i]['insertBy']	= $this->user_id;
					$add_user[$i]['insertDate'] = $this->datetime;
					$add_user[$i]["insertIp"] 	= $this->ip;
					$i++;
				}
			}
			$add = $this->notification->add_user($add_user);
		}
		
		/* End */
		
        redirect('notification', 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "UPDATE ".$this->notification->tbl." SET delete_flag = 1 WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('notification', 'location');
    }
	
	function get_user_list(){
		//$notification_id = $this->
	}
}