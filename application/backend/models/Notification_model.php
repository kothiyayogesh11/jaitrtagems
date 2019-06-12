<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 04/01/2019
 * Time: 06:35 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends Data {
	var $tbl_client_master = "client_master";
	var $tbl_push_notification = "push_notification";
	var $tbl_push_notification_for = "push_notification_for";
	
    function __construct(){
        parent::__construct();
        $this->tbl = $this->tbl_push_notification;
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
	
	function get_all_user(){
		$this->db->select("id, name");
		$this->db->from($this->tbl_client_master);
		$this->db->order_by("name","ASC");
		$this->db->where("delete_flag = 0");
		$result = $this->db->get();
        $rsData    = $result->result_array();
        return $rsData;
	}
	
	function get_notification_user($id = NULL){
		$this->db->select("user_id, pushId");
		$this->db->from($this->tbl_push_notification_for);
		$this->db->where("pushId = $id AND delete_flag = 0");
		$result = $this->db->get();
        $rsData    = $result->result_array();
        return $rsData;
	}
	
	
	function add_user($data = array()){
		return $this->db->insert_batch($this->tbl_push_notification_for,$data);
	}
	
	function removeUser($id = NULL){
		return $this->db->delete($this->tbl_push_notification_for,array("pushId"=>$id));
	}
}