<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 10/06/2019
 * Time: 02:29 AM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shop extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("product_model", 'product');
    }
    public function index(){
        $category = $this->product->category_list();
        $product =  $this->product->product_list();
        $data["category"] = $category;
        $data["product"] = $product;
        $this->load->view('shop',$data);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		
        if ($id != ""){
            $data["rsEdit"] = $this->activities->get_by_id('id', $id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('activities_category/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
			$this->load->library('upload');
			$fname = 'user_log_'.$this->user_id.'_'.time();
			$config['upload_path']          = '../assets/pets/';
			$config['allowed_types']        = '*';
			$config['file_name']			= $fname;
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('image')){
				$ferr = '<div class="msg_error">'.$this->upload->display_errors().'</div>';
				$this->session->set_userdata('sesErrorMessage', $ferr);
            	redirect('activities_category/form/'.$hid_id, 'location');
				
			}else{
				$fdata = $this->upload->data();
				$flist = 'assets/pets/'.$fdata['file_name'];
				compress($flist,$flist,50);
				$data['image'] = $flist;
			}
		}
		
		$data["title"] = @$post["title"];
		$data["index"] = @$post["index"];
		$data["description"] = @$post["description"];
		$data["is_activity"] = intval(@$post["is_activity"]);
		
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $intCenterID = $this->activities->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->activities->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('activities_category', 'location');
    }
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->activities->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('activities_category', 'location');
    }
}