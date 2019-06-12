<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends YK_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model("setting_model",'',true);
		$this->load->model("user_model",'',true);
	}
	
	public function panel_list(){
		$arrWhere	=	array();
		// Get All Vendors
		$orderBy = " insertdate DESC";
		$rsPanels = $this->setting_model->getPanel('',$orderBy);
		$rsListing['rsData']	=	$rsPanels;
		// Load Views
		$this->load->view('panel/list', $rsListing);	
	}
	
	public function AddPanel(){
		$this->setting_model->tbl="panel_master";
		$data["strAction"] = $this->page->getRequest("action");
        $data["strMessage"] = $this->page->getMessage();
        $data["id"] = $this->uri->segment(3);

        if ($data["id"] != ""){
		   $data["rsEdit"] = $this->setting_model->get_by_id('panel_id', $data["id"]);
        } else {
            $data = array();
        }
		$this->load->view('panel/panelForm',$data);
	}
	
	public function SavePanel(){
		$panel_id				= 	$this->page->getRequest('hid_id');
		$this->setting_model->tbl="panel_master";
		$arrHeader["panel_name"]   	=	$this->page->getRequest('txt_panel_name');
        $arrHeader["seq"]     		=	$this->page->getRequest('txt_seq');
        $arrHeader["img_url"]       =   $this->page->getRequest('txt_img_url');
		$arrHeader["status"]        = 	$this->page->getRequest('slt_status');
		if ($panel_id == ""){
            $arrHeader['insertby']		=	$this->user_id;
            $arrHeader['insertdate'] 	= 	$this->datetime;
			$intCenterID = $this->setting_model->insert($arrHeader);
			$this->page->setMessage('REC_ADD_MSG');
        }elseif ($panel_id != ""){
            $arrHeader['updateby'] 		= 	$this->user_id;
            $arrHeader['updatedate'] 	=	$this->datetime;
            $this->setting_model->update($arrHeader, array('panel_id' => $panel_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('setting/panel_list', 'location');
	}
	
	public function deletePanel(){
		$arrPanelIds	=	$this->input->post('record');
		$strPanelIds	=	implode(",", $arrPanelIds);
		$strQuery = "DELETE FROM panel_master WHERE panel_id IN (". $strPanelIds .")";
		$this->db->query($strQuery);
		$this->page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('setting/panel_list', 'location');
	}
	
	
	public function module_list(){
		$arrWhere	=	array();
		$searchCriteria = array(); 
		$strAction = $this->input->post('action');
		$panel_id =   $this->page->getRequest('slt_panel');
		if($panel_id!=0 && $panel_id!=""){
			$searchCriteria["panelId"] = $panel_id;
		}
			
		// Get All modules
		$orderBy = " mm.insertdate DESC";
		$this->setting_model->searchCriteria=$searchCriteria;
		$rsModules = $this->setting_model->getModule('',$orderBy);
		$rsListing['panel_id']	=	$panel_id;
		$rsListing['rsData']	=	$rsModules;
		// Load Views
		$this->load->view('module/list', $rsListing);	
	}
	
	public function AddModule()
	{
		$this->setting_model->tbl="module_master";
		$data["strAction"] = $this->page->getRequest("action");
        $data["strMessage"] = $this->page->getMessage();
        $data["id"] = $this->uri->segment(3);

        if ($data["id"] != ""){
		   $data["rsEdit"] = $this->setting_model->get_by_id('module_id', $data["id"]);	     
        }else{
            $data["strAction"] = "A";
        }
		$this->load->view('module/moduleForm',$data);
	}
	
	public function SaveModule(){
		$module_id					= 	$this->page->getRequest('hid_id');
		$this->setting_model->tbl	="module_master";
		$arrHeader["panel_id"]   	=	$this->page->getRequest('slt_panel_id');
        $arrHeader["module_name"]   =	$this->page->getRequest('txt_module_name');
        $arrHeader["module_url"]    =   $this->page->getRequest('txt_module_url');
		$arrHeader["seq"]        	=   $this->page->getRequest('txt_seq');
		$arrHeader["status"]        = 	$this->page->getRequest('slt_status');
		if ($module_id == ""){
            $arrHeader['insertby']	=	$this->user_id;
            $arrHeader['insertdate']= 	$this->datetime;
            $arrHeader['updatedate']= 	$this->datetime;
			
			$intCenterID = $this->setting_model->insert($arrHeader);
			$this->page->setMessage('REC_ADD_MSG');
        }elseif ($module_id != ""){   
            $arrHeader['updateby'] 	= 	$this->user_id;
            $arrHeader['updatedate']= 	$this->datetime;
            $this->setting_model->update($arrHeader, array('module_id' => $module_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		redirect('setting/module_list', 'location');
	}
	
	public function deleteModule()
	{
		$arrPanelIds	=	$this->input->post('record');
		$strPanelIds	=	implode(",", $arrPanelIds);
		$strQuery = "DELETE FROM module_master WHERE module_id IN (". $strPanelIds .")";
		$this->db->query($strQuery);
		$this->page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('setting/module_list', 'location');
	}
	
	
	// open form (module usertype mapping)
	public function frmAssignModule()
	{
		$data['rsData'] = $this->user_model->getUserTypes();
		$this->load->view('module/assignModuleForm',$data);
	}
	
	// save user-status mapping info
	public function assignModule()
	{
		$this->setting_model->tbl="map_usertype_module";
		$utype_id = $this->page->getRequest("slt_utype");
		$module_id = $this->page->getRequest("slt_module");
		
		// Check Entry
		$searchCriteria = array(); 
		//$searchCriteria["selectField"] = "map.id";
		$searchCriteria["utypeId"] = $utype_id;
		$searchCriteria["moduleId"] = $module_id;
		$this->setting_model->searchCriteria=$searchCriteria;
		$rsRecord = $this->setting_model->getAssignModuleDetail();
		if(count($rsRecord) > 0)
		{
			$this->page->setMessage('ALREADY_MAPPED');
			redirect('setting/frmAssignModule', 'location');
		}
		else
		{
			$arrRecord = array();
			$arrRecord["utype_id"] = $utype_id;
			$arrRecord["module_id"] = $module_id;
			$arrRecord['insertby']		=	$this->page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_usertype_module", $arrRecord);
			if($this->db->insert_id() > 0)
			{
				$this->page->setMessage('REC_MAP_MSG');
				redirect('setting/frmAssignModule', 'location');
			}
		}
	}
	
	public function comboList(){
		$arrWhere	=	array();
		$searchCriteria = array(); 
		$strAction = $this->input->post('action');
		$combo_case =   $this->page->getRequest('slt_combo_case');
		if($combo_case!=""){
			$searchCriteria["combo_case"] = $combo_case;
		}
		
		// Get All combo
		$this->setting_model->searchCriteria=$searchCriteria;
		$rsCombos = $this->setting_model->getCombo();
		$rsListing['rsData']	=	$rsCombos;
		$rsListing['combo_case']	=	$combo_case;
		
		// Load Views
		$this->load->view('combo/list', $rsListing);	
	}
	
	public function AddCombo(){
		$this->setting_model->tbl="combo_master";
		$data["strAction"] = $this->page->getRequest("action");
        $data["strMessage"] = $this->page->getMessage();
        $data["id"] = $this->uri->segment(3);

        if ($data["id"] != ""){
		   $data["rsEdit"] = $this->setting_model->get_by_id('combo_id', $data["id"]);
        }else{
            $data["strAction"] = "A";
        }
		$this->load->view('combo/comboForm',$data);
	}
	
	public function SaveCombo(){
		$this->setting_model->tbl="combo_master";
		$strAction 	= $this->input->post('action');
		$combo_id 	= $this->page->getRequest('hid_id');
		// Check Company
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "combo_id";
		$searchCriteria["combo_case"] = $this->page->getRequest('txt_combo_case');
		$searchCriteria["combo_key"] = $this->page->getRequest('txt_combo_key');
		if ($combo_id != ""){
            $searchCriteria["not_id"] = $combo_id;
		}
		
		$this->setting_model->searchCriteria=$searchCriteria;
		$rsCombo = $this->setting_model->getCombo();
		if(count($rsCombo) > 0){
			$this->page->setMessage('ALREADY_EXISTS');
			redirect('setting/AddCombo', 'location');
		}
		
		$arrHeader["combo_case"]   	=	$this->page->getRequest('txt_combo_case');
		$arrHeader["combo_key"]   	=	$this->page->getRequest('txt_combo_key');
        $arrHeader["combo_value"]   =	$this->page->getRequest('txt_combo_value');
        $arrHeader["seq"]        	=   $this->page->getRequest('txt_seq');
		$arrHeader["status"]        = 	$this->page->getRequest('slt_status');
		
		if ($combo_id == ""){
            $arrHeader['insertby']		=	$this->page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			$intCenterID = $this->setting_model->insert($arrHeader);
			$this->page->setMessage('REC_ADD_MSG');
        }elseif ($combo_id != ""){
            $arrHeader['updateby'] 		= 	$this->page->getSession("intUserId");
            $arrHeader['updatedate'] 	=	date('Y-m-d H:i:s');
            $this->setting_model->update($arrHeader, array('combo_id' => $combo_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('setting/comboList', 'location');
	}
	
	public function deleteCombo(){
		$arrComboIds	=	$this->input->post('record');
		$strComboIds	=	implode(",", $arrComboIds);
		$strQuery = "DELETE FROM combo_master WHERE combo_id IN (". $strComboIds .")";
		$this->db->query($strQuery);
		$this->page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('setting/comboList', 'location');
	}
	
	public function setting_list()
	{
		$this->setting_model->tbl="settings";
		$arrWhere	=	array();
		
		// Get All Categories
		$searchCriteria	=	array();
		$this->setting_model->searchCriteria = $searchCriteria;
		$rsSetting = $this->setting_model->getSetting();
		$rsListing['rsSetting']	=	$rsSetting;
		
		// Load Views
		$this->load->view('setting/setting_list', $rsListing);	
	}
	
	public function AddSetting()
	{
		$this->setting_model->tbl="settings";
		$data["strAction"] = $this->page->getRequest("action");
        $data["strMessage"] = $this->page->getMessage();
        $data["id"] = $this->page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->setting_model->get_by_id('setting_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('setting/settingForm',$data);
	}
	
	public function SaveSetting()
	{		
		$this->setting_model->tbl="settings";
		$strAction = $this->input->post('action');
		$setting_id	   = $this->page->getRequest('setting_id');
		
		
		// Check Duplicate entry
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "setting_id";
		$searchCriteria["var_key"] = $this->page->getRequest('txt_var_key');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $setting_id;
		}
		$this->setting_model->searchCriteria=$searchCriteria;
		$rsSetting = $this->setting_model->getSetting();
		if(count($rsSetting) > 0)
		{
			$this->page->setMessage('ALREADY_EXISTS');
			redirect('setting/AddSetting', 'location');
		}
		
        $arrHeader["var_key"]     	=	$this->page->getRequest('txt_var_key');
        $arrHeader["var_value"]        =   $this->page->getRequest('txt_var_value');
		$arrHeader["description"]        	= 	$this->page->getRequest('txt_description');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->setting_model->insert($arrHeader);
			$this->page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $arrHeader['updateby'] 		= 	$this->page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->setting_model->update($arrHeader, array('setting_id' => $cat_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('setting/setting_list', 'location');
	}
	
	public function deleteSetting()
	{
		$arrSettingIds	=	$this->input->post('chk_lst_list1');
		$strSettingIds	=	implode(",", $arrSettingIds);
		$strQuery = "DELETE FROM settings WHERE setting_id IN (". $strSettingIds .")";
		$this->db->query($strQuery);
		$this->page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('setting/setting_list', 'location');
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */