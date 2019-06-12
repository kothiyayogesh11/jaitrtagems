<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 30/01/2019
 * Time: 02:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Employee extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("employee_model", 'employee');
    }
    public function index(){
        $this->employee->alias = 'c';
		// Get All pets_list
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->employee->alias.".*";
        $searchCriteria["orderField"] = $this->employee->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->employee->searchCriteria=$searchCriteria;
        $rsData = $this->employee->employee_list();
		
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('employee/list',$rsListing);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		$data["skill_list"] = $this->employee->get_all_skill();
        if ($id != ""){
            $data["rsEdit"] = $this->employee->get_by_id('id', $id);
			$data["employee_skill"] = $this->employee->employee_skill($id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('employee/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		if($hid_id != "")
		$rsEdit = $this->employee->get_by_id('id', $hid_id);
		
		$skill = $this->input->post("skills");
		
		if(isset($_FILES['profile']['name']) && $_FILES['profile']['name'] != ''){
			$this->load->library('upload');
			$fname = 'user_log_'.$this->user_id.'_'.time();
			$config['upload_path']          = '../assets/partner/';
			$config['allowed_types']        = '*';
			$config['file_name']			= $fname;
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('profile')){
				$ferr = '<div class="msg_error">'.$this->upload->display_errors().'</div>';
				$this->session->set_userdata('sesErrorMessage', $ferr);
            	redirect('partner/form/'.$hid_id, 'location');
				
			}else{
				$fdata = $this->upload->data();
				$flist = 'assets/partner/'.$fdata['file_name'];
				compress($flist,$flist,50);
				$data['profile'] = $flist;
			}
		}
		
		$data["name"] = @$post["name"];
		$data["email"] = strtolower(@$post["email"]);
		if(!isset($rsEdit->password) || (isset($rsEdit->password) && $rsEdit->password != $post["password"])){
			$data["password"] = sha1($post["password"]);
		}else{
			$data["password"] = $post["password"];
		}
		$data["mobile"] = @$post["mobile"];
		$data["gender"] = @$post["gender"];
		
		$data["country"] = @$post["country"];
		$data["state"] = @$post["state"];
		$data["city"] = @$post["city"];
		
		$count = $this->employee->check_client_email($data["email"],$hid_id);
		if($count > 0){
            $this->page->setMessage('ALREADY_EXISTS');
            redirect('partner/form/'.$hid_id, 'location');
        }
		
		
        if($hid_id == ""){
			$data["registration_type"] = "admin";
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->employee->insert($data);
			$get_user_skill = array();
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $get_user_skill = $this->employee->employee_skill($hid_id);
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->employee->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		
		
			
		$user_skill = array();
		if(!empty($get_user_skill)){
			foreach($get_user_skill as $val){
				$user_skill[] = $val["skill_id"];
			}
		}
		
		$insArr = array();
		$i = 0;
		foreach($skill as $val){
			if($val != "" && !in_array($val,$user_skill)){
				$insArr[$i]["employee_id"] = $hid_id;
				$insArr[$i]["skill_id"] = $val;
				$insArr[$i]["insertDate"] = $this->datetime;
				$insArr[$i]["insertBy"] = $this->user_id;
				$insArr[$i]["insertIp"] = $this->ip;
				$i++;
			}
		}
		
		$del_skill = array_diff($user_skill,$skill);
		
		if(empty($insArr)){
			$ins = TRUE;
		}else{
			$ins = $this->employee->skill_insert_batch($insArr);
		}
		
		if(!empty($del_skill) && is_array($del_skill)){
			$del_skill = implode(",",$del_skill);
			$del = $this->employee->delete_multiple(" employee_id = $hid_id AND skill_id IN($del_skill) ");
		}

        redirect('employee', 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->employee->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('employee', 'location');
    }

	public function type_check_email(){
		$post = $this->input->post();
		if(isset($post["email"]) && !empty($post["email"])){
			$count = $this->employee->check_client_email(strtolower($post["email"]),@$post["id"]);
			if($count>0){
				$error = 1;
				$msg = "Email already exists, please use other email.";
			}else{
				$error = 0;
				$msg = "";
			}
		}else{
			$error = 1;
			$msg = "Email filed is empty please enter email.";
		}
		$array["error"] = $error;
		$array["message"] = $msg;
		$this->general->gererate_json($array);
	}
	
	function get_state(){
		$country = $this->input->post("country");
		$state = $this->input->post("state");
		if($country != ""){
			$state_data = $this->page->generateComboByTable("state_master","state_id","state_name",@$state,"WHERE country_id = ".@$country." AND status = 'ACTIVE'","Select State");
			$error = 0;
			$msg = "";
		}else{
			$error = 1;
			$msg = "There are no state added yet!";
			$state_data = "";
		}
		$array["error"] = $error;
		$array["message"] = $msg;
		$array["data"] = $state_data;
		$this->general->gererate_json($array);
	}
	
	function get_city(){
		$country = $this->input->post("country");
		$state = $this->input->post("state");
		$city = $this->input->post("city");
		if($country != ""){
			$state_data = $this->page->generateComboByTable("city_master","city_id","city_name",@$state,"WHERE country_id = ".@$country." AND state_id = ".$state." AND status = 'ACTIVE'","Select City");
			$error = 0;
			$msg = "";
		}else{
			$error = 1;
			$msg = "There are no state added yet!";
			$state_data = "";
		}
		$array["error"] = $error;
		$array["message"] = $msg;
		$array["data"] = $state_data;
		$this->general->gererate_json($array);
	}
}