<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/04/2019
 * Time: 02:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banner extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("banner_model", 'banner', true);
    }
    public function index(){
        $this->banner->alias = 'c';
		// Get All pets_list
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->banner->alias.".*";
        $searchCriteria["orderField"] = $this->banner->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->banner->searchCriteria=$searchCriteria;
        $rsData = $this->banner->list_all();
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('banner/list',$rsListing);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		
        if ($id != ""){
            $data["rsEdit"] = $this->banner->get_by_id('id', $id);
			$data["rsMedia"] = $this->banner->get_media($id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('banner/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		$this->load->library('upload');
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
			$fname = 'user_log_'.$this->user_id.'_'.time();
			$config['upload_path']          = '../assets/img/';
			$config['allowed_types']        = '*';
			$config['file_name']			= $fname;
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('image')){
				$ferr = '<div class="msg_error">'.$this->upload->display_errors().'</div>';
				$this->page->setMessage('ERROR', strip_tags($ferr));
            	redirect('banner/form/'.$hid_id, 'location');
			}else{
				$fdata = $this->upload->data();
				$flist = 'assets/img/'.$fdata['file_name'];
				compress($flist,$flist,50);
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
					compress($flist,$flist,50);
					$media[$i]['file'] = $flist;
					$media[$i]['type'] = @$type[0];
				}	
			}	
		}
		
		
		$data["title"] 			= @$post["title"];
		$data["index"] 			= @$post["index"];
		$data["description"] 	= @$post["description"];
		$data["url"] 			= @$post["url"];
		
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->banner->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->banner->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		
		if(isset($media) && !empty($media)){
			$add_media_data = array();
			foreach($media as $key => $val){
				$val["slider_id"] = $hid_id;
				$val["insertDate"] = $this->datetime;
				$val["insertBy"] = $this->user_id;
				$val["insertIp"] = $this->ip;
				$add_media_data[] = $val;
			}
			$add = $this->banner->add_media($add_media_data);
		}
		
		if(isset($post["remove_media"]) && $post["remove_media"] != "")
		$rm = $this->banner->remove_media($post["remove_media"]);

        redirect('banner', 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->banner->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('banner', 'location');
    }
}