<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/04/2019
 * Time: 02:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("News_model", 'news', true);
    }
    public function index(){
        $this->news->alias = 'c';
		// Get All pets_list
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->news->alias.".*";
        $searchCriteria["orderField"] = $this->news->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->news->searchCriteria=$searchCriteria;
        $rsData = $this->news->list_all();
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('news/list',$rsListing);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		
        if ($id != ""){
            $data["rsEdit"] 	= $this->news->get_by_id('id', $id);
			$data["rsMedia"] 	= $this->news->get_media($id);
			$data["rsNewsUrl"] 	= $this->news->get_news_url($id);
			$data["rsHyper"]	= $this->news->get_hyper_link($id);
        }else{
            $data["rsEdit"] = array();
        }

        $this->load->view('news/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		
		if(isset($_FILES['media']['name'][0]) && !empty($_FILES['media']['name'][0])){
			$this->load->library('upload');
			$len = count($_FILES['media']['name']);
			for($i = 0; $i < $len; $i++){
				$_FILES['medias'.$i]["name"] 		= $_FILES['media']['name'][$i];
				$_FILES['medias'.$i]["type"] 		= $_FILES['media']['type'][$i];
				$_FILES['medias'.$i]["tmp_name"] 	= $_FILES['media']['tmp_name'][$i];
				$_FILES['medias'.$i]["error"] 		= $_FILES['media']['error'][$i];
				$_FILES['medias'.$i]["size"] 		= $_FILES['media']['size'][$i];
				
				$fname = 'user_log_'.$i.'_'.$this->user_id.'_'.time();
				$config['upload_path']          = './assets/news/';
				$config['allowed_types']        = '*';
				$config['file_name']			= $fname;
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('medias'.$i)){
					$ferr = $this->upload->display_errors();
					$this->page->setMessage('ERROR', strip_tags($ferr));
				}else{
					$fdata = $this->upload->data();
					$type = explode("/",$fdata["file_type"]);
					$flist = 'assets/news/'.$fdata['file_name'];
					compress($flist,$flist,50);
					$media[$i]['file'] = $flist;
					$media[$i]['type'] = @$type[0];
				}	
			}	
		}
		
		
		$data["title"] 			= @$post["title"];
		$data["content"] 			= @$post["content"];
		$data["date"] 			= date("Y-m-d",strtotime(@$post["date"]));
		
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->news->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $data['updateby'] 	= $this->user_id;
            $data['updateDate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->news->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
		/* Media Process */
		if(isset($media) && !empty($media)){
			$add_media_data = array();
			foreach($media as $key => $val){
				$val["news_id"] = $hid_id;
				$add_media_data[] = $val;
			}
			$add = $this->news->add_media($add_media_data);
		}
		
		if(isset($post["remove_media"]) && $post["remove_media"] != "")
		$rm = $this->news->remove_media($post["remove_media"]);
		/* End */
		
		/* Insert Hyper Link */
		
		$remove_hyper_data = $this->input->post("remove_hyper_data");
		if(trim($remove_hyper_data)) $this->news->remove_hyper_link($remove_hyper_data);
		
		$title = $this->input->post("title_link");
		$hyper = $this->input->post("hyper");
		$insert_url = array();
		if(is_array($title) && !empty($title)){
			$i=0;
			foreach($title as $key => $val){
				if($val != ""){
					$insert_url[$i]["news_id"] = $hid_id;
					$insert_url[$i]["title"] = $val;
					$insert_url[$i]["url"] = isset($hyper[$key]) ? $hyper[$key] : "";
					$insert_url[$i]["insertIp"] = $this->input->ip_address();
					$insert_url[$i]["insertBy"] = $this->user_id;
					$insert_url[$i]["insertBy"] = date("Y-m-d H:i:s");
					$i++;	
				}
			}
		}
		if(isset($insert_url) && !empty($insert_url)){
			$addUrl = $this->news->add_hyper($insert_url);
		}
		
		$title_upd = $this->input->post("title_upd");
		$hyper_upd = $this->input->post("hyper_upd");
		if(is_array($title_upd) && !empty($title_upd)){
			$i=0;
			foreach($title_upd as $key => $val){
				if($val != ""){
					$hyper_data = array();
					$hyper_data["title"] = $val;
					$hyper_data["url"] = isset($hyper_upd[$key]) ? $hyper_upd[$key] : "";
					$hyper_data["updateDate"] = date('Y-m-d H:i:s');
					$hyper_data["updateBy"] = $this->user_id;
					$this->news->update_hyper_url($hyper_data,$key);
				}
			}
		}
		
		/* End */
		
		/* News URL */
		$remove_news_url = @$post["remove_news_url"];
		if(trim($remove_news_url)) $this->news->remove_news_link($remove_news_url);
		
		$news_url_edit = @$post["news_url_edit"];
		if(is_array($news_url_edit) && !empty($news_url_edit)){
			$i=0;
			foreach($news_url_edit as $key => $val){
				if($val != ""){
					$link_data = array();
					$link_data["url"] = $val;
					$link_data["updateDate"] = date('Y-m-d H:i:s');
					$link_data["updateBy"] = $this->user_id;
					$this->news->update_news_url($link_data,$key);
				}
			}
		}
		
		$news_urlArr = $post["news_url"];
		$news_url_ins = array();
		if(is_array($news_urlArr) && !empty($news_urlArr)){
			$i=0;
			foreach($news_urlArr as $val){
				if($val != ""){
					$news_url_ins[$i]["news_id"] = $hid_id;
					$news_url_ins[$i]["url"] = $val;
					$news_url_ins[$i]["insertDate"] = date("Y-m-d H:i:s");
					$news_url_ins[$i]["insertBy"] = $this->user_id;
					$news_url_ins[$i]["insertIP"] = $this->input->ip_address();
				$i++;
				}
			}
			if(!empty($news_url_ins)) $this->news->add_news_urls($news_url_ins);
		}
		
		
		/* End */
		
        redirect('news', 'location');
    }
	
	function getMedia(){
		$news_id = $this->input->post('id');
		if($news_id != ''){
			$data['NewsMedia'] = $this->news->get_media($news_id);
			if(!empty($data['NewsMedia'])){
				$res['error'] = 0;
				$res['view'] = $this->load->view('news/_rpc_media',$data,TRUE);
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
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "UPDATE ".$this->news->tbl." SET delete_flag = 1 WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('news', 'location');
    }
}