<?php

/**

 * Created by YK11

 * User: Yogesh Kothiya

 * Date: 29/12/2018

 * Time: 06:35 PM

 */

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Partner_model extends Data {

	var $tbl_partner = "partner";

	var $tbl_pets_training_type = "pets_training_type";
	
	var $tbl_partner_services = 'partner_services';
	
	var $tbl_activities = 'activities';
	
	var $tbl_activities_media = 'activities_media';

    function __construct(){

        parent::__construct();

        $this->tbl = $this->tbl_partner;

		$this->alias = "c";

    }



    function partner_list(){

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
    
    function partner_service_list($partner_id){
	   
	   $searchCriteria = array();

        $searchCriteria = $this->searchCriteria;



        $selectField = $this->alias.".*,(select title from ".$this->tbl_activities." where id = ".$this->alias.".activity_id) as activity_name,(select image from ".$this->tbl_activities." where id = ".$this->alias.".activity_id) as activity_image";

        if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != ""){

            $selectField = 	$searchCriteria['selectField'];

        }



        $whereClaue = " 1=1 AND ".$this->alias.".delete_flag = 0 AND ".$this->alias.".partner_id = '".$partner_id."'";



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

		$this->db->from($this->tbl_partner_services.' '.$this->alias);
	
		$this->db->where($whereClaue);

		$this->db->order_by($orderField, $orderDir);

		$result = $this->db->get();

        $rsData    = $result->result_array();

        return $rsData;
    }

	function get_partner_service($service_id = ''){
		$rsReturn =  $this->db->select('*')->from($this->tbl_partner_services)->where('id = "'.$service_id.'" AND delete_flag = 0')->get()->result();
		return  isset($rsReturn[0]) ? $rsReturn[0] : NULL;
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

	

	function delete_by_id($id = NULL){

		return $this->db->where(array("id"=>$id))->delete($this->tbl);

	}
	
	function get_media($banner_id ,$partner_id){
		return $this->db->select('*')->from($this->tbl_activities_media)->where('delete_flag = 0 AND banner_id = "'.$banner_id.'" AND partner_id = "'.$partner_id.'"')->get()->result_array();
	}

}