<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/08/2019
 * Time: 02:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Location extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("location_model", 'location', true);
    }
    public function index(){
        $this->location->alias = 'c';
		// Get All pets_list
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->location->alias.".*";
        $searchCriteria["orderField"] = $this->location->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->location->searchCriteria=$searchCriteria;
        $rsData = $this->location->list_all();
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('location/list',$rsListing);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		
        if ($id != ""){
            $data["rsEdit"] = $this->location->get_by_id('id', $id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('location/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		
		$data["lat"] 			= @$post["lat"];
		$data["long"] 			= @$post["long"];
		$data["address"] 		= @$post["address"];
		
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->location->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->location->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
        redirect('location', 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->location->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('location', 'location');
    }
}