<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/04/2019
 * Time: 02:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Activities extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("activities_model", 'activities', true);
    }
    public function index(){
        $this->activities->alias = 'c';
		// Get All pets_list
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->activities->alias.".*,bm.title as category_title";
        $searchCriteria["orderField"] = $this->activities->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->activities->searchCriteria=$searchCriteria;
        $rsData = $this->activities->list_all();
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('activities/list',$rsListing);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		$data["all_category"] = $this->activities->all_category();
        if ($id != ""){
            $data["rsEdit"] = $this->activities->get_by_id('id', $id);
			$data["rsMedia"] = $this->activities->get_media($id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('activities/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		$this->load->library('upload');
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
			
			$fname = 'user_log_'.$this->user_id.'_'.time();
			$config['upload_path']          = '../assets/pets/';
			$config['allowed_types']        = '*';
			$config['file_name']			= $fname;
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('image')){
				$ferr = '<div class="msg_error">'.$this->upload->display_errors().'</div>';
				$this->page->setMessage('ERROR', strip_tags($ferr));
            	redirect('activities/form/'.$hid_id, 'location');
				
			}else{
				$fdata = $this->upload->data();
				$flist = 'assets/pets/'.$fdata['file_name'];
				//compress($flist,$flist,50);
				$data['image'] = $flist;
			}
		}
		
		
		if(isset($_FILES['media']['name'][0]) && !empty($_FILES['media']['name'][0])){
			$len = count($_FILES['media']['name']);
			for($i = 0; $i < $len; $i++){
				$_FILES['medias'.$i]["name"] 		= $_FILES['media']['name'][$i];
				$_FILES['medias'.$i]["type"] 		= $_FILES['media']['type'][$i];
				$_FILES['medias'.$i]["tmp_name"] 	= $_FILES['media']['tmp_name'][$i];
				$_FILES['medias'.$i]["error"] 		= $_FILES['media']['error'][$i];
				$_FILES['medias'.$i]["size"] 		= $_FILES['media']['size'][$i];
				
				$fname = 'user_log_'.$i.'_'.$this->user_id.'_'.time();
				$config['upload_path']          = '../assets/pets/';
				$config['allowed_types']        = '*';
				$config['file_name']			= $fname;
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('medias'.$i)){
					$ferr = $this->upload->display_errors();
					$this->page->setMessage('ERROR', strip_tags($ferr));
				}else{
					$fdata = $this->upload->data();
					$type = explode("/",$fdata["file_type"]);
					$flist = 'assets/pets/'.$fdata['file_name'];
					//compress($flist,$flist,50);
					$media[$i]['file'] = $flist;
					$media[$i]['type'] = @$type[0];
				}	
			}	
		}
		
		$data["category_id"] 	= @$post["category_id"];
		$data["title"] 			= @$post["title"];
		$data["index"] 			= @$post["index"];
		$data["description"] 	= @$post["description"];
		$data["lat"] 			= @$post["lat"];
		$data["long"] 			= @$post["long"];
		$data["price"] 			= @$post["price"];
		if($data["price"] != "") $data["price"] = floatval(str_replace(array("@","#","$","%","^","&","*","(",")","_","-","+","=",",","'",'"'),'',$data["price"]));
		$data["price_type"] 	= @$post["price_type"];
		$data["address"] 		= @$post["address"];
		
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->activities->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->activities->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		
		if(isset($media) && !empty($media)){
			$add_media_data = array();
			foreach($media as $key => $val){
				$val["banner_id"] = $hid_id;
				$val["insertDate"] = $this->datetime;
				$val["insertBy"] = $this->user_id;
				$val["insertIp"] = $this->ip;
				$add_media_data[] = $val;
			}
			$add = $this->activities->add_media($add_media_data);
		}
		
		if(isset($post["remove_media"]) && $post["remove_media"] != "")
		$rm = $this->activities->remove_media($post["remove_media"]);

        redirect('activities', 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->activities->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('activities', 'location');
    }
}