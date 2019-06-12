<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 29/12/2018
 * Time: 06:35 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Schedule_model extends Data {
	public $tbl_weekly_schedule = "weekly_schedule";
    function __construct(){
        parent::__construct();
        $this->tbl = $this->tbl_weekly_schedule;
		$this->alias = "p";
    }

    function schedule_list(){
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
	
	function check_pets_type_code($code = NULL, $id = NULL){
		$where = "1 = 1";
		if($code != "") $this->db->where(array("code"=>$code));
		if($id != "") $this->db->where("id != ".$id);
		$this->db->select("*");
		$this->db->from($this->tbl_pet_type);
		return $this->db->get()->num_rows();
	}
	
	function delete_by_id($id = NULL){
		return $this->db->where(array("id"=>$id))->delete($this->tbl);
	}
	
	function pets_breed_list(){
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
		$this->db->join($this->tbl_pet_type." pt",$this->alias.".pet_type = pt.id","LEFT");
		$this->db->order_by($orderField, $orderDir);
		$result = $this->db->get();
        $rsData = $result->result_array();
        return $rsData;
	}
	
	
	function check_pets_breed_code($code = NULL, $id = NULL){
		$where = "1 = 1";
		if($code != "") $this->db->where(array("code"=>$code));
		if($id != "") $this->db->where("id != ".$id);
		$this->db->select("*");
		$this->db->from($this->tbl_breed);
		return $this->db->get()->num_rows();
	}
	
	function pets_training_type_list(){
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
}