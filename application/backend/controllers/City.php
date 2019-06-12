<?php
/**
 * Created by PhpStorm.
 * User: rakesh
 * Date: 9/21/2017
 * Time: 10:37 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class city extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("city_model", '', true);
    }
    public function index(){
        // Get All countries
        $searchCriteria = array();
        //$searchCriteria["selectField"] = "sm.*,cm.*";
        $searchCriteria["orderField"] = "insertdate";
        $searchCriteria["orderDir"] = "DESC";
        $this->city_model->searchCriteria=$searchCriteria;
        $rsCities = $this->city_model->getCityList();
        $rsListing['rsData']	=	$rsCities;

        // Load Views
        $this->load->view('city/list', $rsListing);
    }

    public function AddCity(){
        $data["strAction"] = $this->page->getRequest("action");
        $data["strMessage"] = $this->page->getMessage();
        $data["id"] = $this->uri->segment(3);

        if ($data["id"] != ""){
            $data["rsEdit"] = $this->city_model->get_by_id('city_id', $data["id"]);
        } else{
            $data["strAction"] = "A";
        }
        $this->load->view('city/cityForm',$data);
    }

    public function SaveCity()
    {
        $strAction 	= $this->input->post('action');
		$city_id	= $this->page->getRequest('hid_id');
        // Check User
        $searchCriteria = array();
        $searchCriteria["selectField"] = "ctm.city_id";
        $searchCriteria["city_name"] = $this->page->getRequest('txt_city_name');
        if ($city_id != "") {
            $searchCriteria["not_id"] = $city_id;
        }
        $this->city_model->searchCriteria=$searchCriteria;
        $rsCityName = $this->city_model->getCityList();
        if(count($rsCityName) > 0){
            $this->page->setMessage('ALREADY_EXISTS');
            redirect('city/addCity', 'location');
        }

        $arrHeader["city_name"]     	    =	$this->page->getRequest('txt_city_name');
        $arrHeader["status"]        		= 	$this->page->getRequest('slt_status');
        $arrHeader["country_id"]        	= 	$this->page->getRequest('slt_country');
        $arrHeader["state_id"]        	    = 	$this->page->getRequest('slt_state');
        $arrHeader["city_code"]        	    = 	$this->page->getRequest('txt_city_code');

        if ($city_id == ""){
            $arrHeader['insertby']			=	$this->user_id;
            $arrHeader['insertdate'] 		= 	$this->datetime;
            $arrHeader['updatedate'] 		= 	$this->datetime;

            $intCenterID = $this->city_model->insert($arrHeader);
            $this->page->setMessage('REC_ADD_MSG');
        }elseif ($city_id != ''){
            $arrHeader['updateby'] 		= 	$this->user_id;
            $arrHeader['updatedate'] 	=	$this->datetime;
            $this->city_model->update($arrHeader, array('city_id' => $city_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('city', 'location');
    }

    public function delete()
    {
        $arrCountryIds	=	$this->input->post('record');
        $strCountryIds	=	implode(",", $arrCountryIds);
        $strQuery = "DELETE FROM city_master WHERE city_id IN (". $strCountryIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        // redirect to listing screen
        redirect('city', 'location');
    }

    public function getStates(){
        $fieldVal = $this->page->getRequest("fieldVal");
        if (isset($fieldVal) && $fieldVal != null){
            $query = $this->db->get_where('state_master', array('country_id' => $fieldVal));
                if ($query->num_rows() > 0) {
                    $retstr = '';
                    $retstr .="<option value='' selected>Select State</option>";
                    $selectedArr = array();
                    foreach ($query->result_array() as $row) {
                        if ($this->page->getRequest("state_id") != null && is_numeric($this->page->getRequest("state_id"))) {
                            $selectedArr = explode(" ", $this->page->getRequest("state_id"));
                            $Val = $row["state_id"];
                        }
                        if (count($selectedArr) > 0 && in_array($Val, $selectedArr))
                            $sel = "selected";
                        else
                            $sel = "";

                        $retstr .= "<option value='$row[state_id]' $sel>$row[state_name]</option>";
                    }
                    echo $retstr;
                }
        }
     }

    public function getCities(){
        $fieldVal = $this->page->getRequest("fieldVal");
        if (isset($fieldVal) && $fieldVal != null){
            $query = $this->db->get_where('city_master', array('state_id' => $fieldVal));
            if ($query->num_rows() > 0) {
                $retstr = '';
                $retstr .="<option value='' selected>Select City</option>";
                $selectedArr = array();
                foreach ($query->result_array() as $row) {
                    if ($this->page->getRequest("city_id") != null && is_numeric($this->page->getRequest("city_id"))) {
                        $selectedArr = explode(" ", $this->page->getRequest("city_id"));
                        $Val = $row["city_id"];
                    }
                    if (count($selectedArr) > 0 && in_array($Val, $selectedArr))
                        $sel = "selected";
                    else
                        $sel = "";

                    $retstr .= "<option value='$row[city_id]' $sel>$row[city_name]</option>";
                }
                echo $retstr;
            }
        }
    }
}
