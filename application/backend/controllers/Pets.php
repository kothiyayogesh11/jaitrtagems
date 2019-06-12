<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 29/12/2018
 * Time: 06:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pets extends YK_Controller{
	
    function __construct(){
        parent::__construct();
        $this->load->model("pets_model", 'pets', true);
    }
    public function index(){
        $this->pets->alias = 'p';
		// Get All pets_list
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = "p.id as id ,p.client_id as client_id, p.name as pet_name, p.profile as pet_image, p.pet_type as pet_code, p.breed as breed_id, p.age as age, p.weight as weight, p.delete_flag as delete_flag, pt.name as type_name, cm.name as client_name, cm.profile as client_image";
        $searchCriteria["orderField"] = $this->pets->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->pets->searchCriteria=$searchCriteria;
        $rsData = $this->pets->pets_list();
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('pets/list',$rsListing);
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->pets->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('pets', 'location');
    }
	
	function type(){
		$this->pets->tbl = $this->pets->tbl_pet_type;
		$this->pets->alias = 'pt';
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] 	= $this->pets->alias.".*";
        $searchCriteria["orderField"] 	= $this->pets->alias.".id";
        $searchCriteria["orderDir"] 	= "DESC";
        $this->pets->searchCriteria=$searchCriteria;
        $rsData = $this->pets->pets_type_list();
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $rsListing['rsData']	=	$rsData;
        $this->load->view('pets/type_list',$rsListing);
	}
	
	

    public function form_type(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->page->getRequest("id");
		
        if ($id != ""){
            $data["rsEdit"] = $this->pets->get_by_id('city_id', $id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('pets/form_type',$data);
    }

    public function type_process(){
		$this->pets->tbl = $this->pets->tbl_pet_type;
		$this->pets->alias = 'pt';
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		
		$data["name"] = @$post["name"];
		$data["code"] = strtolower(@$post["code"]);
		
		$count = $this->pets->check_pets_type_code($post["code"],$hid_id);
		if($count > 0){
            $this->page->setMessage('ALREADY_EXISTS');
            redirect('pets/form_type/'.$hid_id, 'location');
        }
		
		
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $intCenterID = $this->pets->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->pets->update($arrHeader, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('pets/type', 'location');
    }
	
	public function delete_type_by_id(){
		$this->pets->tbl = $this->pets->tbl_pet_type;
		$id = $this->input->post("id");
		if($id != ""){
			$del = $this->pets->delete_by_id($id);
			if($del){
				$error = 0;
				$msg = "Success!";
			}else{
				$error = 1;
				$msg = "Failed to remove data!";
			}
		}else{
			$error = 1;
			$msg = "Id is empty.";
		}
		
		$array["error"] = $error;
		$array["message"] = $msg;
		$this->general->gererate_json($array);
	}

    public function delete_type(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->pets->tbl_pet_type." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('pets/type', 'location');
    }

	public function type_check_code(){
		$post = $this->input->post();
		if(isset($post["code"]) && !empty($post["code"])){
			$count = $this->pets->check_pets_type_code(strtolower($post["code"]),@$post["id"]);
			if($count>0){
				$error = 1;
				$msg = "Code already exists, please use other code.";
			}else{
				$error = 0;
				$msg = "";
			}
		}else{
			$error = 1;
			$msg = "Code filed is empty please enter code.";
		}
		$array["error"] = $error;
		$array["message"] = $msg;
		$this->general->gererate_json($array);
	}
	
	function breed(){
		$this->pets->tbl = $this->pets->tbl_breed;
		$this->pets->alias = 'b';
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] 	= $this->pets->alias.".*,pt.name as type_name";
        $searchCriteria["orderField"] 	= $this->pets->alias.".id";
        $searchCriteria["orderDir"] 	= "DESC";
        $this->pets->searchCriteria=$searchCriteria;
        $rsData = $this->pets->pets_breed_list();
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $rsListing['rsData']	=	$rsData;
        $this->load->view('pets/breed_list',$rsListing);
	}
	
	

    public function form_breed(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		
        if ($id != ""){
			$this->pets->tbl = $this->pets->tbl_breed;
            $data["rsEdit"] = $this->pets->get_by_id('id', $id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('pets/form_breed',$data);
    }

    public function breed_process(){
		$this->pets->tbl = $this->pets->tbl_breed;
		$this->pets->alias = 'pt';
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();

		$data["name"] = @$post["name"];
		$data["code"] = strtolower(@$post["code"]);
		$data["pet_type"] = @$post["pet_type"];
		
		$count = $this->pets->check_pets_breed_code($post["code"],$hid_id);
		if($count > 0){
            $this->page->setMessage('ALREADY_EXISTS');
            redirect('pets/form_breed/'.$hid_id, 'location');
        }
		
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $intCenterID = $this->pets->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->pets->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('pets/breed', 'location');
    }
	
	function breed_check_code(){
		$post = $this->input->post();
		if(isset($post["code"]) && !empty($post["code"])){
			$count = $this->pets->check_pets_breed_code(strtolower($post["code"]),@$post["id"]);
			if($count>0){
				$error = 1;
				$msg = "Code already exists, please use other code.";
			}else{
				$error = 0;
				$msg = "";
			}
		}else{
			$error = 1;
			$msg = "Code filed is empty please enter code.";
		}
		$array["error"] = $error;
		$array["message"] = $msg;
		$this->general->gererate_json($array);
	}
	
	public function delete_breed_by_id(){
		$this->pets->tbl = $this->pets->tbl_breed;
		$id = $this->input->post("id");
		if($id != ""){
			$del = $this->pets->delete_by_id($id);
			if($del){
				$error = 0;
				$msg = "Success!";
			}else{
				$error = 1;
				$msg = "Failed to remove data!";
			}
		}else{
			$error = 1;
			$msg = "Id is empty.";
		}
		
		$array["error"] = $error;
		$array["message"] = $msg;
		$this->general->gererate_json($array);
	}
	
	function training_type(){
		$this->pets->tbl = $this->pets->tbl_pets_training_type;
		$this->pets->alias = $alias = 'b';
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] 	= "$alias.id, $alias.type, $alias.delete_flag ";
        $searchCriteria["orderField"] 	= $this->pets->alias.".id";
        $searchCriteria["orderDir"] 	= "DESC";
        $this->pets->searchCriteria=$searchCriteria;
        $rsData = $this->pets->pets_training_type_list();
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $rsListing['rsData']	=	$rsData;
        $this->load->view('pets/training_type_list',$rsListing);
	}
	
	public function form_training_type(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		
        if ($id != ""){
			$this->pets->tbl = $this->pets->tbl_pets_training_type;
            $data["rsEdit"] = $this->pets->get_by_id('id', $id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('pets/form_training_type',$data);
    }
	
	public function training_type_process(){
		$this->pets->tbl = $this->pets->tbl_pets_training_type;
		$this->pets->alias = 'pt';
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();

		$data["type"] = @$post["type"];
		
		
		
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $intCenterID = $this->pets->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->pets->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('pets/training_type', 'location');
    }
	
	public function training_type_delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->pets->tbl_pets_training_type." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('pets/training_type', 'location');
    }
}