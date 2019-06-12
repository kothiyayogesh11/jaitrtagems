<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 29/12/2018
 * Time: 06:35 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee_model extends Data {
	var $tbl_employee = "employee";
	var $tbl_pets_training_type = "pets_training_type";
	var $tbl_employee_skill = "employee_skill";
    function __construct(){
        parent::__construct();
        $this->tbl = $this->tbl_employee;
		$this->alias = "c";
    }

    function employee_list(){
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
		$this->db->order_by($orderField, $orderDir);
		$result = $this->db->get();
        $rsData    = $result->result_array();
        return $rsData;
    }
	
	function pets_type_list(){
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

        $orderField = $this->alias.".personaid";
        $orderDir = "ASC";

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
		$result = $this->db->get();
        $rsData = $result->result_array();
        return $rsData;
	}
	
	function check_client_email($email = NULL, $id = NULL){
		$where = "1 = 1";
		if($email != "") $this->db->where(array("email"=>$email));
		if($id != "") $this->db->where("id != ".$id);
		$this->db->select("*");
		$this->db->from($this->tbl);
		return $this->db->get()->num_rows();
	}
	
	function get_all_skill(){
		$this->db->select("id,type");
		$this->db->from($this->tbl_pets_training_type);
		$this->db->where(array("delete_flag"=>0));
		return $this->db->get()->result_array();
	}
	
	function employee_skill($id = NULL){
		$this->db->select("skill_id");
		$this->db->from($this->tbl_employee_skill);
		$this->db->where(array("delete_flag"=>0,"employee_id"=>$id));
		return $this->db->get()->result_array();
	}
	
	function delete_by_id($id = NULL){
		return $this->db->where(array("id"=>$id))->delete($this->tbl);
	}
	
	function delete_multiple($where){
		return $this->db->where($where)->delete($this->tbl_employee_skill);
	}
	
	function skill_insert_batch($data){
		return $this->db->insert_batch($this->tbl_employee_skill,$data);
	}
}