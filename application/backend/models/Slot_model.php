<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 04/01/2019
 * Time: 06:35 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Slot_model extends Data {
	var $tbl_client_master = "client_master";
	var $tbl_slider_home = "slider_home";
	var $tbl_slider_media = "slider_media";
	var $tbl_available_slot = "available_slot";
	var $tbl_activities = "activities";
	//var $tbl_banner = 'banner';
	
    function __construct(){
        parent::__construct();
        $this->tbl = $this->tbl_available_slot;
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
		$this->db->join($this->tbl_activities." b",$this->alias.".activity_id = b.id","LEFT");
		$this->db->order_by($orderField, $orderDir);
		$result = $this->db->get();
        $rsData    = $result->result_array();
        return $rsData;
    }
	
	
	function getActivityList(){
		return $this->db->get_where($this->tbl_activities,array("delete_flag"=>0))->result_array();			
	}
	
	function delete_by_id($id = NULL){
		return $this->db->where(array("id"=>$id))->delete($this->tbl);
	}
	
	function checkExists($data = array(),$hid_id = NULL){
		$where = 'activity_id = '.$data['activity_id'].' AND date = "'.$data['date'].'" AND from_time = "'.$data['from_time'].'" AND to_time = "'.$data['to_time'].'"';
		if($hid_id != ""){
			$where .= ' AND id NOT IN ('.$hid_id.')';
		}
		return $this->db->from($this->tbl)->where($where)->get()->result_array();
	}
}