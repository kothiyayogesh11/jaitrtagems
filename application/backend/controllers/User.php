<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends YK_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model("user_model",'',true);
	}
	
	public function index(){
		$this->user_model->tbl="user_master";
		$arrWhere	=	array();
		// Get All Users
		$searchCriteria = array();
		$searchCriteria["selectField"] = "um.*";
		$searchCriteria["orderField"] = "insertdate";
		$searchCriteria["orderDir"] = "DESC";
		$this->user_model->searchCriteria=$searchCriteria;
		$rsUsers = $this->user_model->getUsers();
		$rsListing['rsData']	=	$rsUsers;
		// Load Views
		$this->load->view('user/list', $rsListing);
	}

	public function AddUser(){
		$this->user_model->tbl="user_master";
		$data["strAction"] 		= $this->page->getRequest("action");
        $data["strMessage"] 	= $this->page->getMessage();
        $data["id"] = $this->uri->segment(3);

        if($data["id"]!=""){
		   	$data["rsEdit"] 	= $this->user_model->get_by_id('user_id', $data["id"]);
        }else{
            $data["strAction"] 	= "A";
        }
		$this->load->view('user/userForm',$data);
	}

	public function SaveUser(){
		$this->user_model->tbl = "user_master";
		$strAction = $this->input->post('action');
		$hid_id = $this->page->getRequest('hid_id');
		// Check User
		$searchCriteria = array();
		$searchCriteria["selectField"] = "um.user_id";
		$searchCriteria["userName"] = $this->page->getRequest('txt_user_name');
		if ($strAction == 'E'){
            $searchCriteria["not_id"] = $hid_id;
		}
		$this->user_model->searchCriteria=$searchCriteria;
		$rsUsers = $this->user_model->getUsers();
		if(count($rsUsers) > 0){
			$this->page->setMessage('ALREADY_EXISTS');
			redirect('user/addUser', 'location');
		}
		$arrHeader["user_type"]				=   $this->page->getRequest('slt_user_type');
		$arrHeader["user_full_name"]     	=	$this->page->getRequest('txt_user_full_name');
        $arrHeader["user_name"]     		=	$this->page->getRequest('txt_user_name');
        $arrHeader["user_email"]       		=   $this->page->getRequest('txt_user_email');
        $arrHeader["user_phone"]        	=   $this->page->getRequest('txt_user_phone');
        $arrHeader["parent_user_id"]        =   $this->page->getRequest('slt_parent_user_hidden');
		
		if($this->page->getRequest('txt_user_password') != ""){		
			$arrHeader["user_password"]     =  md5($this->page->getRequest('txt_user_password'));		
		}
		
        $arrHeader["status"]        		= 	$this->page->getRequest('slt_status');
		
		if($hid_id == ""){
			$arrHeader['insertby']			=	$this->page->getSession("intUserId");
			$arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->user_model->insert($arrHeader);
			$this->page->setMessage('REC_ADD_MSG');
        }
		elseif ($hid_id != "")
		{
            $user_id						= 	$hid_id;
            $arrHeader['updateby'] 			= 	$this->page->getSession("intUserId");
            $arrHeader['updatedate'] 		=	date('Y-m-d H:i:s');
			
            $this->user_model->update($arrHeader, array('user_id' => $user_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('user', 'location');
	}
	
	public function delete()
	{
		$this->user_model->tbl="user_master";
		$arrUserIds	=	$this->input->post('chk_lst_list1');
		$strUserIds	=	implode(",", $arrUserIds);
		$strQuery = "DELETE FROM user_master WHERE user_id IN (". $strUserIds .")";
		$this->db->query($strQuery);
		$this->page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('user', 'location');
	}
	
	##User Type List
	public function userTypesList(){
		$arrWhere	=	array();
		// Get All User Types
		$rsUserTypes = $this->user_model->getUserTypes();
		$rsListing['rsData']	=	$rsUserTypes;
		// Load Views
		$this->load->view('user/userTypesList', $rsListing);	
	}
	
	public function addUserTypes()
	{
		$this->user_model->tbl="user_types";
		$data["strAction"] = $this->page->getRequest("action");
        $data["strMessage"] = $this->page->getMessage();
        $data["id"] = $this->uri->segment(3);
        if ($data["id"] != ""){
		   $data["rsEdit"] = $this->user_model->get_by_id('u_typ_id', $data["id"]);
        } else {
            $data["strAction"] = "A";
        }
		$this->load->view('user/userTypesForm',$data);
	}
	
	public function saveUserTypes(){
		$this->user_model->tbl="user_types";
		$strAction = $this->input->post('action');
		$hid_id = $this->page->getRequest('hid_id');
		// Check User
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "u_typ_id";
		$searchCriteria["userTypesName"] = $this->page->getRequest('txt_u_typ_name');
		if ($hid_id != ""){
            $searchCriteria["not_id"] = $hid_id;
		}
		$this->user_model->searchCriteria=$searchCriteria;
		$rsUserTypes = $this->user_model->getUserTypes();
		if(count($rsUserTypes) > 0){
			$this->page->setMessage('ALREADY_EXISTS');
			redirect('user/addUserTypes', 'location');
		}
		$arrHeader["u_typ_name"]				=   $this->page->getRequest('txt_u_typ_name');
		$arrHeader["u_typ_code"]     	=	$this->page->getRequest('txt_u_typ_code');
        $arrHeader["u_typ_desc"]     	=	$this->page->getRequest('txt_u_typ_desc');
        $arrHeader["status"]        			= 	$this->page->getRequest('slt_status');
		
		if ($hid_id == ""){
            $arrHeader['insertby']		=	$this->page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			$intCenterID = $this->user_model->insert($arrHeader);
			$intCenterID;
			$this->page->setMessage('REC_ADD_MSG');
        }elseif ($hid_id != ""){
            $u_typ_id				= 	$hid_id;
            $arrHeader['updateby'] 		= 	$this->page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->user_model->update($arrHeader, array('u_typ_id' => $u_typ_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('user/userTypesList', 'location');
	}
	
	public function deleteUserTypes()
	{
		$arrUserTypesIds	=	$this->input->post('record');
		$strUserTypesIds	=	implode(",", $arrUserTypesIds);
		$strQuery = "DELETE FROM user_types WHERE u_typ_id IN (". $strUserTypesIds .")";
		$this->db->query($strQuery);
		$this->page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('user/userTypesList', 'location');
	}
	
	function checkEmailAndUsername(){
        $field = $this->page->getRequest("field");
        if ($field == 'txt_user_email'){
            $dbField = 'user_email';
            $returnValue = 'emailExists';
        }
        else if ($field == 'txt_user_name'){
            $dbField = 'user_name';
            $returnValue = 'userExists';
        }
        $fieldVal = $this->page->getRequest("fieldVal");

        if ($this->page->getRequest('id') && $this->page->getRequest('id') != 'null'){
            $query = $this->db->get_where('user_master', array('user_id' => $this->page->getRequest('id')));
            $row = $query->row();
            if ($row->$dbField !== $fieldVal){
                $query1 = $this->db->get_where('user_master', array($dbField => trim($fieldVal)));
                if ($query1->num_rows() > 0) {
                    echo $returnValue;
                }
            }
        }
        else {
            $query = $this->db->get_where('user_master', array($dbField => trim($fieldVal)));
            if ($query->num_rows() > 0) {
                echo $returnValue;
            }
        }
    }
	
	function active_welcome_mail(){
		$data['userList'] = $this->user_model->getFailedWelcomeMail();
		$this->load->view('user/welcome_mail_list',$data);
	}
	
	function activeFauledMailCustomer(){
		$id = $this->input->post('id');
		if($id != ''){
			$res = $this->user_model->activeFauledMailCustomer($id);
			$msg = $res ? array('error'=>0) : array('error'=>1);
		}else{
			$msg = array('error'=>1);
		}
		echo json_encode($msg);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */