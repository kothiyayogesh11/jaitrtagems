<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/01/2019
 * Time: 06:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Client extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("client_model", 'clients', true);
    }
    public function index(){
        $this->clients->alias = 'c';
		// Get All pets_list
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->clients->alias.".*";
        $searchCriteria["orderField"] = $this->clients->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->clients->searchCriteria=$searchCriteria;
        $rsData = $this->clients->clients_list();
		
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('client/list',$rsListing);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		
        if ($id != ""){
            $data["rsEdit"] = $this->clients->get_by_id('id', $id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('client/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		if($hid_id != "")
		$rsEdit = $this->clients->get_by_id('id', $hid_id);
		
		
		if(isset($_FILES['profile']['name']) && $_FILES['profile']['name'] != ''){
			$this->load->library('upload');
			$fname = 'user_log_'.$this->user_id.'_'.time();
			$config['upload_path']          = '../assets/user/';
			$config['allowed_types']        = '*';
			$config['file_name']			= $fname;
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('profile')){
				$ferr = '<div class="msg_error">'.$this->upload->display_errors().'</div>';
				$this->session->set_userdata('sesErrorMessage', $ferr);
            	redirect('client/form/'.$hid_id, 'location');
				
			}else{
				$fdata = $this->upload->data();
				$flist = 'assets/user/'.$fdata['file_name'];
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
		
		$count = $this->clients->check_client_email($data["email"],$hid_id);
		if($count > 0){
            $this->page->setMessage('ALREADY_EXISTS');
            redirect('client/form/'.$hid_id, 'location');
        }
		
		
        if($hid_id == ""){
			$data["registration_type"] = "admin";
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $intCenterID = $this->clients->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->clients->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('client', 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->clients->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('client', 'location');
    }

	public function type_check_email(){
		$post = $this->input->post();
		if(isset($post["email"]) && !empty($post["email"])){
			$count = $this->clients->check_client_email(strtolower($post["email"]),@$post["id"]);
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