<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/10/2019
 * Time: 02:29 PM
**/
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Slot extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("slot_model", 'slot', true);
    }
    public function index(){
        $this->slot->alias = 'c';
		// Get All pets_list
	   	$rsListing = array();
        $searchCriteria = array();
		$alias = isset($this->slot->alias) && $this->slot->alias != "" ? $this->slot->alias : "";
		
        $searchCriteria["selectField"] = "$alias.id, $alias.activity_id, $alias.date, $alias.from_time, $alias.to_time, $alias.is_book, $alias.book_by, $alias.book_time, $alias.delete_flag,b.title as activity_title";
        $searchCriteria["orderField"] = $this->slot->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->slot->searchCriteria=$searchCriteria;
        $rsData = $this->slot->list_all();
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('slot/list',$rsListing);
    }
	
	public function form(){
        $id = $this->uri->segment(3);
		$data["strAction"] = $this->page->getRequest("action");
		$data['activity_list'] = $this->slot->getActivityList();
	   
	   	if ($id != ""){
            $data["rsEdit"] = $this->slot->get_by_id('id', $id);
			$data["fromTime"] 	= explode(":",$data["rsEdit"]->from_time);
			$data["toTime"] 	= explode(":",$data["rsEdit"]->to_time);
        }else{
            $data["rsEdit"] = array();
        }
		//pre($data);exit;
        $this->load->view('slot/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		$data["activity_id"] 	= @$post["activity_id"];
		$data["date"] 			= @$post["date"];
		
		$data['from_time'] = @$post['fhours'].':'.@$post['fminutes'].':'.@$post['fseconds'];
		$data['to_time'] = @$post['thours'].':'.@$post['tminutes'].':'.@$post['tseconds'];
		
	   	$rsSlot = $this->slot->checkExists($data,$hid_id);
	   	if(count($rsSlot) > 0){
		  $this->page->setMessage('ALREADY_EXISTS');
		  redirect('slot', 'location');
	   	}
		
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->slot->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->slot->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
        redirect('slot', 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->slot->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('slot', 'location');
    }
}