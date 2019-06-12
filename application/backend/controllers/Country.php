<?php
/**
 * Created by YK11.
 * User: Yogesh Kothiya
 * Date: 06/01/2018
 * Time: 10:37 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("country_model", '', true);
    }
    public function index(){
        // Get All countries
        $searchCriteria = array();
        $searchCriteria["selectField"] = "cm.*";
        $searchCriteria["orderField"] = "insertdate";
        $searchCriteria["orderDir"] = "DESC";
        $this->country_model->searchCriteria=$searchCriteria;
        $rsCountries = $this->country_model->getCountryList();
        $rsListing['rsData']	=	$rsCountries;

        // Load Views
        $this->load->view('country/list', $rsListing);
    }

    public function AddCountry(){
        $data["strAction"] = $this->page->getRequest("action");
        $data["strMessage"] = $this->page->getMessage();
        $data["id"] = $this->uri->segment(3);

        if ($data["id"] != ""){
            $data["rsEdit"] = $this->country_model->get_by_id('country_id', $data["id"]);
        }else{
            $data["strAction"] = "A";
        }
        $this->load->view('country/countryForm',$data);
    }

    public function SaveCountry(){
		
        $strAction = $this->input->post('action');
		$country_id				= 	$this->page->getRequest('hid_id');
        // Check User
        $searchCriteria = array();
        $searchCriteria["selectField"] = "cm.country_id";
        $searchCriteria["country_name"] = $this->page->getRequest('txt_country_name');
        if ($country_id != ""){
            $searchCriteria["not_id"] = $country_id;
        }
        $this->country_model->searchCriteria=$searchCriteria;
        $rsCountryName = $this->country_model->getCountryList();
        if(count($rsCountryName) > 0){
            $this->page->setMessage('ALREADY_EXISTS');
            redirect('country/addCountry', 'location');
        }

        $arrHeader["country_name"]     	=	$this->page->getRequest('txt_country_name');
        $arrHeader["country_code"]     	=	$this->page->getRequest('txt_country_code');
        $arrHeader["status"]        	= 	$this->page->getRequest('slt_status');

        if ($country_id == ""){
            $arrHeader['insertby']		=	$this->user_id;
            $arrHeader['insertdate'] 	= 	$this->datetime;
            $arrHeader['updatedate'] 	= 	$this->datetime;

            $intCenterID = $this->country_model->insert($arrHeader);
            $this->page->setMessage('REC_ADD_MSG');
        }elseif ($country_id != ""){
            $arrHeader['updateby'] 		= 	$this->user_id;
            $arrHeader['updatedate'] 	=	$this->datetime;
            $this->country_model->update($arrHeader, array('country_id' => $country_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('country', 'location');
    }

    public function delete()
    {
        $arrCountryIds	=	$this->input->post('record');
        $strCountryIds	=	implode(",", $arrCountryIds);
        $strQuery = "DELETE FROM country_master WHERE country_id IN (". $strCountryIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        // redirect to listing screen
        redirect('country', 'location');
    }
}