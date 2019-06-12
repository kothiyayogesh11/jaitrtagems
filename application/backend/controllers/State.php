<?php
/**
 * Created by PhpStorm.
 * User: rakesh
 * Date: 9/21/2017
 * Time: 10:37 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("state_model", '', true);
    }
    public function index(){
        // Get All countries
        $searchCriteria = array();
        //$searchCriteria["selectField"] = "sm.*,cm.*";
        $searchCriteria["orderField"] = "insertdate";
        $searchCriteria["orderDir"] = "DESC";
        $this->state_model->searchCriteria=$searchCriteria;
        $rsStates = $this->state_model->getStateList();
        $rsListing['rsData']	=	$rsStates;

        // Load Views
        $this->load->view('state/list', $rsListing);
    }

    public function AddState(){
        $data["strAction"] = $this->page->getRequest("action");
        $data["strMessage"] = $this->page->getMessage();
        $data["id"] = $this->uri->segment(3);

        if ($data["id"] != ""){
            $data["rsEdit"] = $this->state_model->get_by_id('state_id', $data["id"]);
        } else {
            $data["strAction"] = "A";
        }
        $this->load->view('state/stateForm',$data);
    }

    public function SaveState() {
        $strAction = $this->input->post('action');
		$state_id		= 	$this->page->getRequest('hid_id');
        // Check User
        $searchCriteria = array();
        $searchCriteria["selectField"] = "sm.state_id";
        $searchCriteria["state_name"] = $this->page->getRequest('txt_state_name');
        if ($state_id != ""){
            $searchCriteria["not_id"] = $state_id;
        }
        $this->state_model->searchCriteria=$searchCriteria;
        $rsStateName = $this->state_model->getStateList();
        if(count($rsStateName) > 0){
            $this->page->setMessage('ALREADY_EXISTS');
            redirect('state/addState', 'location');
        }

        $arrHeader["state_name"]     	    =	$this->page->getRequest('txt_state_name');
        $arrHeader["state_code"]            =   $this->page->getRequest('txt_state_code');
        $arrHeader["status"]        		= 	$this->page->getRequest('slt_status');
        $arrHeader["country_id"]        	= 	$this->page->getRequest('slt_country');

        if ($state_id == ""){
            $arrHeader['insertby']			=	$this->user_id;
            $arrHeader['insertdate'] 		= 	$this->datetime;
            $arrHeader['updatedate'] 		= 	$this->datetime;
            $intCenterID = $this->state_model->insert($arrHeader);
            $this->page->setMessage('REC_ADD_MSG');
        } elseif ($state_id != ""){
            $arrHeader['updateby'] 		= 	$this->user_id;
            $arrHeader['updatedate'] 	=	$this->datetime;
            $this->state_model->update($arrHeader, array('state_id' => $state_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('state', 'location');
    }

    public function delete(){
        $arrCountryIds	=	$this->input->post('record');
        $strCountryIds	=	implode(",", $arrCountryIds);
        $strQuery = "DELETE FROM state_master WHERE state_id IN (". $strCountryIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        // redirect to listing screen
        redirect('state', 'location');
    }
}