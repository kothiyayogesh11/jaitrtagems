<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 04/01/2019
 * Time: 06:35 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends Data {
    public $tbl_client_master = "client_master";
    public $tbl_product_category = "product_category";
    public $tbl_product = "product";
    public $tbl_product_media = "product_media";
    function __construct(){
        parent::__construct();
        $this->tbl = $this->tbl_product;
        $this->alias = "c";
    }

    function category_list(){
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
        $this->db->from($this->tbl_product_category.' '.$this->alias);
        $this->db->order_by($orderField, $orderDir);
        $result = $this->db->get();
        $rsData    = $result->result_array();
        return $rsData;
    }


    function product_list(){
        $al = $this->alias;
        $searchCriteria = array();
        $searchCriteria = $this->searchCriteria;

        $selectField = $al.".*";
        if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != ""){
            $selectField = 	$searchCriteria['selectField'];
        }

        $whereClaue = "WHERE 1=1 AND ".$al.".delete_flag = 0";

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
        $this->db->from($this->tbl.' '.$al);
        $this->db->join($this->tbl_product_category." pc",$al.".category_id = pc.id","LEFT");
        $this->db->order_by($orderField, $orderDir);
        $result = $this->db->get();
        $rsData    = $result->result_array();
        return $rsData;
    }

    function get_media($id = NULL){
        return $this->db->get_where($this->tbl_product_media,array("product_id"=>$id))->result_array();
    }

    function add_media($data = array()){
        return $this->db->insert_batch($this->tbl_product_media,$data);
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

    function remove_media($id = NULL){
        if($id == "") return false;
        return $this->db->where("id IN ($id)")->delete($this->tbl_product_media);
    }
}