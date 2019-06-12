<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 29/12/2018
 * Time: 06:35 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order_model extends Data {
	public $tbl_client_master 	= "client_master";
	public $tbl_available_slot 	= "available_slot";
	public $tbl_partner 		= "partner";
	public $tbl_employee 		= "employee";
	public $tbl_order_master 	= "order_master";
	public $tbl_weekly_schedule = "weekly_schedule";
	public $tbl_activities 		= "activities";
    function __construct(){
        parent::__construct();
        $this->tbl = $this->tbl_order_master;
		$this->alias = "o";
    }
	
	function get_activity(){
		$this->db->select("b.id as activity_id, b.title as name, b.address as address, b.lat as lat, b.long as long, b.price as price, b.price_type rate_on, b.description as description, b.image as image, b.index as index" );
		$this->db->from($this->tbl_activities." b");
		$this->db->where(array("b.delete_flag"=>0));
		$this->db->order_by("b.index","ASC");
		return $this->db->get()->result_array();
	}
	
	
	function open_slot(){
		
		//$select = "o.";
		
		
	}
	

    function order_list(){
        $searchCriteria = array();
        $searchCriteria = $this->searchCriteria;
		$al = $this->alias;
        $selectField = $al.".id as order_id, ".$al.".user_id as customer_id, ".$al.".partner_id as partner_id, ".$al.".employee_id as employee_id, ".$al.".activity_id as activity_id, ".$al.".pet_id as pet_id, ".$al.".location as location_id, ".$al.".slot_id as slot_id, ".$al.".payment_method as payment_method, ".$al.".status as order_status, ".$al.".partner_status as partner_status, ".$al.".employee_status as employee_status, ".$al.".date as order_date, ".$al.".delete_flag as delete_flag, av.date as slot_date, CONCAT(av.date,' ',av.from_time) as from_order_time, CONCAT(av.date,' ',av.to_time) as to_order_time, av.book_by as slot_customer_id, av.is_book as is_book, av.book_time as costomer_order_time, avs.title as activity_name, avs.description as activity_description, avs.image as activity_image, avs.address as activity_address, avs.lat as activity_lat, avs.long as activity_long, avs.price as activity_price, avs.price_type as activity_price_type, cu.name as customer_name, cu.profile as customer_profile, cu.mobile as customer_mobile, cu.email as customer_email, pr.name as partner_name, pr.profile as partner_profile, pr.mobile as partner_mobile, pr.email as partner_email, pr.business_name as partner_business_name, em.name as employee_name, em.profile as employee_profile, em.mobile as employee_mobile, em.email as employee_email";
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
		$this->db->join($this->tbl_available_slot." av",$this->alias.".slot_id = av.id","LEFT");
		$this->db->join($this->tbl_activities." avs",$this->alias.".activity_id = avs.id","LEFT");
		$this->db->join($this->tbl_client_master." cu",$this->alias.".user_id = cu.id","LEFT");
		$this->db->join($this->tbl_partner." pr",$this->alias.".partner_id = pr.id","LEFT");
		$this->db->join($this->tbl_employee." em",$this->alias.".employee_id = em.id","LEFT");
		$this->db->order_by($orderField, $orderDir);
		$result 	= $this->db->get();
        $rsData    	= $result->result_array();
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