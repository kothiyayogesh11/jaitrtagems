<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 04/01/2019
 * Time: 06:35 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Activities_model extends Data {
	var $tbl_client_master = "client_master";
	var $tbl_banner_category = "banner_category";
	var $tbl_activities_media = "activities_media";
	//var $tbl_banner = "banner";
	var $tbl_activities = "activities";
    function __construct(){
        parent::__construct();
        $this->tbl = $this->tbl_activities;
		$this->alias = "c";
    }

    function list_all(){
        $searchCriteria = array();
        $searchCriteria = $this->searchCriteria;

        $selectField = $this->alias.".*";
        if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != ""){
            $selectField = 	$searchCriteria['selectField'];
        }

        $whereClaue = "WHERE 1=1 ";

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
		$this->db->join($this->tbl_banner_category." bm",$this->alias.".category_id = bm.id","LEFT");
		$this->db->order_by($orderField, $orderDir);
		$result = $this->db->get();
        $rsData    = $result->result_array();
        return $rsData;
    }
	
	function get_media($id = NULL){
		return $this->db->get_where($this->tbl_activities_media,array("banner_id"=>$id))->result_array();
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
		return $this->db->insert_batch($this->tbl_activities_media,$data);
	}
	
	function remove_media($id = NULL){
		if($id == "") return false;
		return $this->db->where(array("id"=>$id))->delete($this->tbl_activities_media);
	}
	
	function all_category(){
		$this->db->select("id,title,is_activity");
		$this->db->from($this->tbl_banner_category);
		$this->db->order_by("index","ASC");
		$result = $this->db->get();
        $rsData = $result->result_array();
        return $rsData;
	}
}