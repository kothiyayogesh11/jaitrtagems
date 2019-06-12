<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/04/2019
 * Time: 02:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Splash_slider extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("splash_slider_model", 'banner');
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
        $this->load->view('splash_banner/list',$rsListing);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		
        if ($id != ""){
            $data["rsEdit"] = $this->banner->get_by_id('id', $id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('splash_banner/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		$this->load->library('upload');
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
			$fname = 'user_log_'.$this->user_id.'_'.time();
			$config['upload_path']          = './assets/pets/';
			$config['allowed_types']        = '*';
			$config['file_name']			= $fname;
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('image')){
				$ferr = '<div class="msg_error">'.$this->upload->display_errors().'</div>';
				$this->page->setMessage('ERROR', strip_tags($ferr));
            	redirect('splash_banner/form/'.$hid_id, 'location');
			}else{
				$fdata = $this->upload->data();
				$flist = 'assets/pets/'.$fdata['file_name'];
				compress($flist,$flist,50);
				$data['file'] = $flist;
			}
		}
		
		
		$data["title"] 			= @$post["title"];
		$data["index"] 			= @$post["index"];
		$data["type"] 			= @$post["type"];
		
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
		
        redirect('splash_slider', 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->banner->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('splash_slider', 'location');
    }
}