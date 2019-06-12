<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 26/02/2019
 * Time: 02:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("product_model", 'product', true);
    }
    public function category(){
        $this->product->alias = 'c';
        // Get All pets_list
        $rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->product->alias.".*";
        $searchCriteria["orderField"] = $this->product->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->product->searchCriteria=$searchCriteria;
        $rsData = $this->product->category_list();

        $rsListing['rsData']	=	$rsData;
        $activeArr[1] = "De-Active";
        $activeArr[0] = "Active";
        $rsListing['activeArr'] = $activeArr;
        $this->load->view('product/category_list',$rsListing);
    }

    public function category_form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
        if ($id != ""){
            $this->product->tbl = $this->product->tbl_product_category;
            $data["rsEdit"] = $this->product->get_by_id('id', $id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('product/category_form',$data);
    }

    public function category_process(){
        $hid_id = trim($this->page->getRequest('hid_id'));
        $post = $this->input->post();
        $this->product->tbl = $this->product->tbl_product_category;
        /*pre($_FILES);
        pre($post);
        exit;*/


        $data["name"] 			        = @$post["name"];
        $data["slug"] 			        = trim(@$post["slug"]);
        $data["index"] 			        = @$post["index"];
        $data["description"] 			= @$post["description"];

        /* Check slug unique */

            $slug_where = " slug = '".$data["slug"]."'";
            if($hid_id != "") $slug_where .= " AND id NOT IN(".$hid_id.")";

            $slug_count = $this->product->count_where($slug_where);
            if($slug_count > 0){
                $this->page->setMessage('ERROR', "Unique name already exists");
                redirect(base_url("product/category_form"));
            }

        /* End */

        /* Upload file */
        $this->load->library('upload');
        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
            $fname = 'user_log_'.$this->user_id.'_'.time();
            $config['upload_path']          = '../assets/public/product/';
            $config['allowed_types']        = '*';
            $config['file_name']			= $fname;
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('image')){
                $ferr = '<div class="msg_error">'.$this->upload->display_errors().'</div>';
                $this->page->setMessage('ERROR', strip_tags($ferr));
                redirect('product/category_form/'.$hid_id, 'location');
            }else{
                $fdata = $this->upload->data();
                $flist = 'assets/public/product/'.$fdata['file_name'];
                //compress($flist,$flist,50);
                $data['image'] = $flist;
            }
        }
        /* End */



        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
            $data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->product->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
            $data['updateIp']	= $this->ip;
            $this->product->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        redirect('product/category', 'location');
    }

    public function category_delete(){
        $this->product->tbl = $this->product->tbl_product_category;
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->product->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('product/category', 'location');
    }

    function index(){
        $this->product->alias = 'c';
        // Get All pets_list
        $rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->product->alias.".*, pc.name as category_name";
        $searchCriteria["orderField"] = $this->product->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->product->searchCriteria=$searchCriteria;
        $rsData = $this->product->product_list();
        $rsListing['rsData']	=	$rsData;
        $activeArr[1] = "De-Active";
        $activeArr[0] = "Active";
        $rsListing['activeArr'] = $activeArr;
        $this->load->view('product/list',$rsListing);
    }

    public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
        if ($id != ""){
            $data["rsEdit"] = $this->product->get_by_id('id', $id);
            $data["rsMedia"] = $this->product->get_media($id);
        }else{
            $data["rsEdit"] = array();
        }
        $this->load->view('product/form',$data);
    }

    public function process(){
        $hid_id = $this->page->getRequest('hid_id');
        $post = $this->input->post();
        $data["name"] 			= @$post["name"];
        $data["index"] 			= @$post["index"];
        $data["price"] 			= floatval(@$post["price"]);
        $data["category_id"]    = @$post["category_id"];
        $data["slug"]           = @$post["slug"];
        $data["description"] 	= @$post["description"];

        /* Check slug unique */

        $slug_where = " slug = '".$data["slug"]."'";
        if($hid_id != "") $slug_where .= " AND id NOT IN(".$hid_id.")";

        $slug_count = $this->product->count_where($slug_where);
        if($slug_count > 0){
            $this->page->setMessage('ERROR', "Unique name already exists");
            redirect(base_url("product/form"));
        }

        /* End */

        $this->load->library('upload');
        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
            $fname = 'user_log_'.$this->user_id.'_'.time();
            $config['upload_path']          = '../assets/public/product';
            $config['allowed_types']        = '*';
            $config['file_name']			= $fname;
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('image')){
                $ferr = '<div class="msg_error">'.$this->upload->display_errors().'</div>';
                $this->page->setMessage('ERROR', strip_tags($ferr));
                redirect('product/form/'.$hid_id, 'location');
            }else{
                $fdata = $this->upload->data();
                $flist = 'assets/public/product/'.$fdata['file_name'];
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
                $config['upload_path']          = '../assets/public/product/';
                $config['allowed_types']        = '*';
                $config['file_name']			= $fname;
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('medias'.$i)){
                    $ferr = $this->upload->display_errors();
                    $this->page->setMessage('ERROR', strip_tags($ferr));
                }else{
                    $fdata = $this->upload->data();
                    $type = explode("/",$fdata["file_type"]);
                    $flist = 'assets/public/product/'.$fdata['file_name'];
                    //compress($flist,$flist,50);
                    $media[$i]['file'] = $flist;
                    $media[$i]['type'] = @$type[0];
                }
            }
        }

        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
            $data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->product->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $data['updateby'] 	= $this->user_id;
            $data['updatedate'] = $this->datetime;
            $data['updateIp']	= $this->ip;
            $this->product->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }

        if(isset($media) && !empty($media)){
            $add_media_data = array();
            foreach($media as $key => $val){
                $val["product_id"] = $hid_id;
                $val["insertDate"] = $this->datetime;
                $val["insertBy"] = $this->user_id;
                $val["insertIp"] = $this->ip;
                $add_media_data[] = $val;
            }
            $add = $this->product->add_media($add_media_data);
        }

        if(isset($post["remove_media"]) && $post["remove_media"] != "")
            $rm = $this->product->remove_media($post["remove_media"]);

        redirect('product', 'location');
    }

    public function delete(){
        $this->product->tbl = $this->product->tbl_product;
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "DELETE FROM ".$this->product->tbl." WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('product', 'location');
    }
}