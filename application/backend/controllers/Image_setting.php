<?php
/**
 * Created by PhpStorm.
 * User: rakesh
 * Date: 28/12/2017
 * Time: 12:54 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Image_setting extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("image_setting_model", '', true);
    }

	function index(){
		$data['imageList'] = $this->image_setting_model->getAllSettingImage(1);
		$this->load->view('image_setting/list',$data);
	}
	
	function add(){
		$data['cateList'] = $this->image_setting_model->cateList();
		$this->load->view('image_setting/imageSettingForm',$data);
	}
	
	function edit(){
		$id = $this->input->get('id');
		$data['imageData'] = $this->image_setting_model->getImage($id);
		$data['cateList'] = $this->image_setting_model->cateList();
		$data['id'] = $id;
		$this->load->view('image_setting/imageSettingForm',$data);
	}
	
	function saveImageSetting(){
		$id = $this->input->post('hid_id');
		$insData['title'] = $this->input->post('title');
		$insData['category_id'] = $this->input->post('category');
		
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
			$config['upload_path']          = '../upload/';
			$config['allowed_types']        = '*';
			$config['encrypt_name'] = TRUE;
			$config['max_size']             = 5000;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('image')){
				echo $this->upload->display_errors();
				exit;
			}else{
				 $files = $this->upload->data();
                 $insData['file'] = $files['file_name'];
			}
		}
		
		if($id == ''){
			$insData['type'] = 1;
			$insData['insertBy'] = $this->session->userdata('sess_intUserId');
			$insData['insertDate'] = date('Y-m-d H:i:s');
			$res = $this->image_setting_model->addImage($insData) ? $this->Page->setMessage('REC_ADD_MSG') : '';
		}else{
			$insData['updateBy'] = $this->session->userdata('sess_intUserId');
			$insData['updateDate'] = date('Y-m-d H:i:s');
			$res = $this->image_setting_model->saveImage($insData,$id) ? $this->Page->setMessage('REC_EDIT_MSG') : '';
		}
		redirect('c=image_setting', 'location');
	}
	
	function category(){
		$data['cateList'] = $this->image_setting_model->cateList();
		$this->load->view('image_setting/category_list',$data);
	}
	
	function delete_image(){
		$ids = implode(',',$this->input->post('chk_lst_list1'));
		$res = $ids != '' ? $this->image_setting_model->image_delete($ids) : FALSE;
		$res ? $this->Page->setMessage("DELETE_RECORD") : $this->Page->setMessage('ERROR_ADDED');
		redirect('c=image_setting', 'location');
	}
	
	function category_add(){
		$id = $this->input->get_post('id') != '' ? $this->input->get_post('id') : NULL;
		$data['id'] = $id;
		$data['cateList'] = $id != NULL ? $this->image_setting_model->cateList($id) :  array();
		$this->load->view('image_setting/CategoryForm',$data);
	}
	
	function saveImageCategory(){
		$data['title'] = $this->input->post('title');
		$data['sort_order'] = $this->input->post('order');
		$id = $this->input->post('hid_id');
		if($id != ''){
			$insData['updateBy'] = $this->session->userdata('sess_intUserId');
			$insData['updateDate'] = date('Y-m-d H:i:s');
		}else{
			$insData['insertBy'] = $this->session->userdata('sess_intUserId');
			$insData['insertDate'] = date('Y-m-d H:i:s');
		}
		$res = $this->image_setting_model->saveImageCategory($data,$id);
		if($res){
			if($id == '') $this->Page->setMessage('REC_ADD_MSG');
			else $this->Page->setMessage('REC_EDIT_MSG');
		}else{
			$this->Page->setMessage('ERROR_ADDED');
		}
		redirect('c=image_setting&m=category', 'location');
	}
	
	function category_delete(){
		$ids = implode(',',$this->input->post('chk_lst_list1'));
		$res = $ids != '' ? $this->image_setting_model->cate_delete($ids) : FALSE;
		$res ? $this->Page->setMessage("DELETE_RECORD") : $this->Page->setMessage('ERROR_ADDED');
		redirect('c=image_setting&m=category', 'location');
	}
	
	function home_image(){
		$data['imageList'] = $this->image_setting_model->getAllSettingImage(2);
		$this->load->view('image_setting/home_image_list',$data);
	}
	
	function addHomeImage(){
		$this->load->view('image_setting/imageHomeForm');
	}
	
	function editHomeImage(){
		$id = $this->input->get('id');
		$data['imageData'] = $this->image_setting_model->getImage($id);
		$data['id'] = $id;
		$this->load->view('image_setting/imageHomeForm',$data);
	}
	
	function saveHomeImageSetting(){
		$id = $this->input->post('hid_id');
		$insData['title'] = $this->input->post('title');
		$insData['category_id'] = $this->input->post('category');
		
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
			$config['upload_path']          = '../upload/';
			$config['allowed_types']        = '*';
			$config['encrypt_name'] = TRUE;
			$config['max_size']             = 5000;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('image')){
				echo $this->upload->display_errors();
				exit;
			}else{
				 $files = $this->upload->data();
                 $insData['file'] = $files['file_name'];
			}
		}
		
		if($id == ''){
			$insData['type'] = 2;
			$insData['insertBy'] = $this->session->userdata('sess_intUserId');
			$insData['insertDate'] = date('Y-m-d H:i:s');
			$res = $this->image_setting_model->addImage($insData) ? $this->Page->setMessage('REC_ADD_MSG') : '';
		}else{
			$insData['updateBy'] = $this->session->userdata('sess_intUserId');
			$insData['updateDate'] = date('Y-m-d H:i:s');
			$res = $this->image_setting_model->saveImage($insData,$id) ? $this->Page->setMessage('REC_EDIT_MSG') : '';
		}
		redirect('c=image_setting&m=home_image', 'location');
	}
}
?>