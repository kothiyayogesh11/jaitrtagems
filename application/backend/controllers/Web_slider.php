<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/04/2019
 * Time: 02:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Web_slider extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("web_slider_model", 'web_slider', true);
    }
    public function index(){
        $this->web_slider->alias = 'c';
        // Get All pets_list
        $rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->web_slider->alias.".*";
        $searchCriteria["orderField"] = $this->web_slider->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->web_slider->searchCriteria=$searchCriteria;
        $rsData = $this->web_slider->list_all();
        $rsListing['rsData']	=	$rsData;
        $activeArr[1] = "De-Active";
        $activeArr[0] = "Active";
        $rsListing['activeArr'] = $activeArr;
        $this->load->view('web_slider/list',$rsListing);
    }

    public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);

        if ($id != ""){
            $data["rsEdit"] = $this->web_slider->get_by_id('id', $id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('web_slider/form',$data);
    }

    public function process(){
        $hid_id = $this->page->getRequest('hid_id');
        $post = $this->input->post();
        $this->load->library('upload');
        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
            $fname = 'user_log_'.$this->user_id.'_'.time();
            $config['upload_path']          = './assets/banner/';
            $config['allowed_types']        = '*';
            $config['file_name']			= $fname;
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('image')){
                $ferr = '<div class="msg_error">'.$this->upload->display_errors().'</div>';
                $this->page->setMessage('ERROR', strip_tags($ferr));
                redirect('web_slider/form/'.$hid_id, 'location');
            }else{
                $fdata = $this->upload->data();
                $flist = 'assets/banner/'.$fdata['file_name'];
                //compress($flist,$flist,50);
                $data['image'] = $flist;
            }
        }

        $data["title"] 			= @$post["title"];
        $data["index"] 			= @$post["index"];
        $data["tag_line"] 		= @$post["tag_line"];
        $data["link"] 			= @$post["link"];

        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
            $data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->web_slider->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
            $data['updateIp']	= $this->ip;
            $this->web_slider->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('web_slider', 'location');
    }

    public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->banner->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('web_slider', 'location');
    }
}