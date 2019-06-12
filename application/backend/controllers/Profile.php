<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/01/2019
 * Time: 06:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("profile_model", 'profile', true);
    }
    public function index(){
        $this->profile->alias = 'c';
		// Get All pets_list
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->profile->alias.".*";
        $searchCriteria["orderField"] = $this->profile->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->profile->searchCriteria=$searchCriteria;
        $rsData = $this->admin->profile();
		pre($rsData);exit;
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('profile/list',$rsListing);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		
        if ($id != ""){
            $data["rsEdit"] = $this->profile->get_by_id('user_id', $id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('profile/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		if($hid_id != "")
		$rsEdit = $this->profile->get_by_id('user_id', $hid_id);
		
		if(isset($_FILES['profile']['name']) && $_FILES['profile']['name'] != ''){
			$this->load->library('upload');
			$fname = 'user_log_'.$this->user_id.'_'.time();
			$config['upload_path']          = './assets/user/';
			$config['allowed_types']        = '*';
			$config['file_name']			= $fname;
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('profile')){
				$ferr = '<div class="msg_error">'.$this->upload->display_errors().'</div>';
				$this->session->set_userdata('sesErrorMessage', $ferr);
            	redirect('profile/form/'.$hid_id, 'location');
				
			}else{
				$fdata = $this->upload->data();
				$flist = 'assets/user/'.$fdata['file_name'];
				compress($flist,$flist,50);
				$data['user_image'] = $flist;
			}
		}
		
		$data["user_name"] = @$post["name"];
		$data["user_full_name"] = @$post["user_full_name"];
		$data["user_email"] = strtolower(@$post["email"]);
		if(!isset($rsEdit->user_password) || (isset($rsEdit->user_password) && $rsEdit->user_password != @$post["password"])){
			$data["user_password"] = sha1($post["password"]);
		}else{
			$data["user_password"] = $post["password"];
		}
		$data["user_phone"] = @$post["mobile"];
		$data["gender"] = @$post["gender"];
		if(isset($post["user_type"])){
			$data["user_type"] = $post["user_type"];
		}
		
		$count = $this->profile->check_client_email($data["user_email"],$hid_id);
		if($count > 0){
            $this->page->setMessage('ALREADY_EXISTS');
            redirect('profile/form/'.$hid_id, 'location');
        }
		
        if($hid_id == ""){
			$data["registration_type"] = "admin";
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
            $intCenterID = $this->profile->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
            $this->profile->update($data, array('user_id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('profile/form/'.$this->user_id, 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->profile->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('client', 'location');
    }

	public function type_check_email(){
		$post = $this->input->post();
		if(isset($post["email"]) && !empty($post["email"])){
			$count = $this->profile->check_client_email(strtolower($post["email"]),@$post["id"]);
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
	
	function welcome(){
		$data["title"] = "Welcome back, Admin!";
		$data["text"] = "You have 4 new notifications. Please check your inbox.";
		$data["image"] = file_check(@$this->admin_data->user_image);
		$this->general->gererate_json($data);
	}
}