<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 04/01/2019
 * Time: 06:35 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cardtype_model extends Data {
	var $tbl_news = "news";
	var $tbl_news_media = "news_media";
	var $tbl_hyper_link = "hyper_link";
	var $tbl_news_url = "news_url";
	var $tbl_card_type = "card_type";
	
    function __construct(){
        parent::__construct();
        $this->tbl = $this->tbl_card_type;
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
	
	function count_exit($name = NULL,$id = NULL){
		$where["LOWER(card_type)"] = strtolower($name);
		if($id != "")
		$where["id"] = $id;
		return $this->db->get_where($this->tbl,$where)->num_rows();
	}
}