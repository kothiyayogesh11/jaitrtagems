<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 01/04/2019
 * Time: 02:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cardtype extends YK_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("cardtype_model", 'card');
    }
    public function index(){
        $this->card->alias = 'c';
		// Get All pets_list
		$rsListing = array();
        $searchCriteria = array();
        $searchCriteria["selectField"] = $this->card->alias.".*";
        $searchCriteria["orderField"] = $this->card->alias.".id";
        $searchCriteria["orderDir"] = "DESC";
        $this->card->searchCriteria=$searchCriteria;
        $rsData = $this->card->list_all();
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$rsListing['activeArr'] = $activeArr;
        $this->load->view('card/list',$rsListing);
    }
	
	public function form(){
        $data["strAction"] = $this->page->getRequest("action");
        $id = $this->uri->segment(3);
		
        if ($id != ""){
            $data["rsEdit"] 	= $this->card->get_by_id('id', $id);
        }else{
            $data["rsEdit"] = array();
        } 
        $this->load->view('card/form',$data);
    }
	
	public function process(){
		$hid_id = $this->page->getRequest('hid_id');
		$post = $this->input->post();
		$data["card_type"] 			= @$post["card_type"];
		
		$where = " card_type = '".$data['card_type']."' ";
		if($hid_id != "") $where .= " AND id NOT IN(".$hid_id.")";
		$check = $this->card->count_by_where($where);
		if($check > 0 ){
			$this->page->setMessage('ALREADY_EXISTS');
			redirect('cardtype', 'location');
		}
        if($hid_id == ""){
            $data['insertBy']	=	$this->user_id;
            $data['insertDate'] = 	$this->datetime;
			$data["insertIp"] 	= 	$this->ip;
            $hid_id = $this->card->insert($data);
            $this->page->setMessage('REC_ADD_MSG');
        }else{
            $data['updateby'] 	= $this->user_id;
            $data['updateDate'] = $this->datetime;
			$data['updateIp']	= $this->ip;
            $this->card->update($data, array('id' => $hid_id));
            $this->page->setMessage('REC_EDIT_MSG');
        }
        redirect('cardtype', 'location');
    }
	
	function check_name(){
		$card_id = $this->input->post("card_id");
		$card_name = $this->input->post("card_name");
		if($card_name != ""){
			$count = $this->card->count_exit($card_name,$card_id);
			if($count == 0){
				$res["error"] = 0;
			}else{
				$res["error"] = 1;
			}
		}else{
			$res["error"] = 1;
		}
		echo json_encode($res);
	}
	
	public function delete(){
        $arrIds	=	$this->input->post('record');
        $strIds	=	implode(",", $arrIds);
        $strQuery = "UPDATE ".$this->card->tbl." SET delete_flag = 1 WHERE id IN (". $strIds .")";
        $this->db->query($strQuery);
        $this->page->setMessage("DELETE_RECORD");
        redirect('cardtype', 'location');
    }
}