<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 04/01/2019
 * Time: 06:35 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News_model extends Data {
	var $tbl_news = "news";
	var $tbl_news_media = "news_media";
	var $tbl_hyper_link = "hyper_link";
	var $tbl_news_url = "news_url";
	
    function __construct(){
        parent::__construct();
        $this->tbl = $this->tbl_news;
		$this->alias = "c";
    }

    function list_all(){
        $searchCriteria = array();
        $searchCriteria = $this->searchCriteria;

        $selectField = $this->alias.".*";
        if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != ""){
            $selectField = 	$searchCriteria['selectField'];
        }

        $whereClaue = " 1=1 AND delete_flag = 0 ";

        if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != ""){
            $whereClaue .= 	" AND ".$this->alias.".id !=".$searchCriteria['not_id']." ";
        }

        $orderField = $this->alias.".id";
        $orderDir = " ASC";

        // Set Order Field
        if(isset($searchCriteria['orderField']) && $searchCriteria['orderField'] != ""){
            $orderField = $searchCriteria['orderField'];
        }

        // Set Order Field
        if(isset($searchCriteria['orderDir']) && $searchCriteria['orderDir'] != ""){
            $orderDir = $searchCriteria['orderDir'];
        }
		
		$this->db->select($selectField);
		$this->db->from($this->tbl.' '.$this->alias);
		$this->db->order_by($orderField, $orderDir);
		$this->db->where($whereClaue);
		$result = $this->db->get();
        $rsData    = $result->result_array();
        return $rsData;
    }
	
	function get_media($id = NULL){
		return $this->db->get_where($this->tbl_news_media,array("news_id"=>$id,"delete_flag"=>0))->result_array();
	}
	
	function media_list(){
		$this->db->select($selectField);
		$this->db->from($this->tbl.' '.$this->alias);
		$this->db->order_by($orderField, $orderDir);
		$result = $this->db->get();
        $rsData = $result->result_array();
        return $rsData;
	}
	
	function delete_by_id($id = NULL){
		return $this->db->where(array("id"=>$id))->delete($this->tbl);
	}
	
	function add_media($data = array()){
		return $this->db->insert_batch($this->tbl_news_media,$data);
	}
	
	function remove_media($id = NULL){
		if($id == "") return false;
		return $this->db->set(array("delete_flag"=>1))->where(array("id"=>$id))->update($this->tbl_news_media);
	}
	
	function add_hyper($data){
		return $this->db->insert_batch($this->tbl_hyper_link,$data);
	}
	
	function remove_hyper_link($id = NULL){
		if($id == "") return FALSE;
		return $this->db->delete($this->tbl_hyper_link,"id IN(".$id.")");
	}
	
	function add_news_urls($data = array()){
		return $this->db->insert_batch($this->tbl_news_url,$data);
	}
	
	function get_news_url($id = NULL){
		return $this->db->get_where($this->tbl_news_url,array("news_id"=>$id,"delete_flag"=>0))->result_array();
	}
	
	function get_hyper_link($id = NULL){
		return $this->db->get_where($this->tbl_hyper_link,array("news_id"=>$id,"delete_flag"=>0))->result_array();
	}
	
	function remove_news_link($id = NULL){
		if($id == "") return false;
		return $this->db->delete($this->tbl_news_url,"id IN(".$id.")");
	}
	
	function update_hyper_url($data = array(), $id = NULL){
		return $this->db->set($data)->where(array("id"=>$id))->update($this->tbl_hyper_link);
	}
	
	function update_news_url($data = array(), $id = NULL){
		return $this->db->set($data)->where(array("id"=>$id))->update($this->tbl_news_url);
	}
}