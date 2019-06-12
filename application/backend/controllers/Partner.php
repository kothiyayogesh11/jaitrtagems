<?php

/**

 * Created by YK11

 * User: Yogesh Kothiya

 * Date: 30/01/2019

 * Time: 02:29 PM

 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partner extends YK_Controller{

    function __construct(){

        parent::__construct();

        $this->load->model("partner_model", 'partner');

    }

    public function index(){

        $this->partner->alias = 'c';

		// Get All pets_list

		$rsListing = array();

        $searchCriteria = array();

        $searchCriteria["selectField"] = $this->partner->alias.".*";

        $searchCriteria["orderField"] = $this->partner->alias.".id";

        $searchCriteria["orderDir"] = "DESC";

        $this->partner->searchCriteria=$searchCriteria;

        $rsData = $this->partner->partner_list();

		

        $rsListing['rsData']	=	$rsData;

		$activeArr[1] = "De-Active";

		$activeArr[0] = "Active";

		$rsListing['activeArr'] = $activeArr;

        $this->load->view('partner/list',$rsListing);

    }
    
	public function services(){
		$partner_id = $this->uri->segment('3');
		$this->partner->alias = 's';
		$rsListing = array();
		   $searchCriteria = array();
	
		   $searchCriteria["selectField"] = "s.*,(select title from activities where id = s.activity_id) as activity_name,(select image from activities where id = s.activity_id) as activity_image";
	
		   $searchCriteria["orderField"] = $this->partner->alias.".id";
	
		   $searchCriteria["orderDir"] = "DESC";
	
		   $this->partner->searchCriteria=$searchCriteria;
	
		   $rsData = $this->partner->partner_service_list($partner_id);
		  
		   $rsListing['rsData']	=	$rsData;
		   $rsListing['partner_id'] = $partner_id;
	
	
		   $this->load->view('partner/activity_list',$rsListing);

	}

	

	public function form(){

        $data["strAction"] = $this->page->getRequest("action");

        $id = $this->uri->segment(3);

		

        if ($id != ""){

            $data["rsEdit"] = $this->partner->get_by_id('id', $id);

        }else{

            $data["rsEdit"] = array();

        }

        $this->load->view('partner/form',$data);

    }

	public function serviceform(){
		$data["strAction"] = $this->page->getRequest("action");
		 $partner_id = $this->uri->segment(3);
		 $service_id = $this->uri->segment(4);
		 $data['partner_id'] = $partner_id;
		 
		   if ($service_id != ""){
			  $data["rsEdit"] = $this->partner->get_partner_service($service_id);
		   }else{			  
			  $data["rsEdit"] = array();
		   }
	
		   $this->load->view('partner/activity_form',$data);
		
	}
	

	public function process(){

		$hid_id = $this->page->getRequest('hid_id');

		$post = $this->input->post();

		if($hid_id != "")

		$rsEdit = $this->partner->get_by_id('id', $hid_id);

		

		

		if(isset($_FILES['profile']['name']) && $_FILES['profile']['name'] != ''){

			$this->load->library('upload');

			$fname = 'user_log_'.$this->user_id.'_'.time();

			$config['upload_path']          = './assets/partner/';

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

		

		$data["business_name"] = @$post["business_name"];

		$data["training_type"] = @$post["training_type"];

		

		$data["country"] = @$post["country"];

		$data["state"] = @$post["state"];

		$data["city"] = @$post["city"];

		

		$count = $this->partner->check_client_email($data["email"],$hid_id);

		if($count > 0){

            $this->page->setMessage('ALREADY_EXISTS');

            redirect('partner/form/'.$hid_id, 'location');

        }

		

		

        if($hid_id == ""){

			$data["registration_type"] = "admin";

            $data['insertBy']	=	$this->user_id;

            $data['insertDate'] = 	$this->datetime;

			$data["insertIp"] 	= 	$this->ip;

            $intCenterID = $this->partner->insert($data);

            $this->page->setMessage('REC_ADD_MSG');

        }else{

            

            $data['updateby'] 	= $this->user_id;

            $data['updatedate'] = $this->datetime;

			$data['updateIp']	= $this->ip;

            $this->partner->update($data, array('id' => $hid_id));

            $this->page->setMessage('REC_EDIT_MSG');

        }



        redirect('partner', 'location');

    }

    

	

	public function delete(){

        $arrIds	=	$this->input->post('record');

        $strIds	=	implode(",", $arrIds);

        $strQuery = "DELETE FROM ".$this->partner->tbl." WHERE id IN (". $strIds .")";

        $this->db->query($strQuery);

        $this->page->setMessage("DELETE_RECORD");

        redirect('partner', 'location');

    }

	function getMedia(){

		$news_id = $this->input->post('id');
		
		$partner_id = $this->input->post('partner_id');
		$banner_id = $this->input->post('activity_id');
	
		if($banner_id != '' && $partner_id != ''){

			$data['NewsMedia'] = $this->partner->get_media($banner_id,$partner_id);

			if(!empty($data['NewsMedia'])){

				$res['error'] = 0;

				$res['view'] = $this->load->view('partner/_rpc_media',$data,TRUE);

			}else{

				$res['error'] = 1;

				$res['msg'] = 'No media found';

			}

		}else{

			$res['error'] = 1;

			$res['msg'] = 'Media id is empty ';

		}

		$this->general->gererate_json($res);

	}



	public function type_check_email(){

		$post = $this->input->post();

		if(isset($post["email"]) && !empty($post["email"])){

			$count = $this->partner->check_client_email(strtolower($post["email"]),@$post["id"]);

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