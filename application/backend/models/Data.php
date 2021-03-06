<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Data extends CI_Model {	
    var $tbl;
    var $limit;
	var $alias;
    public $searchCriteria;
	function __construct(){
        parent::__construct();
        $this->limit = $this->page->getSetting("PAGING_RECORD_COUNT");
	}
	
    function count_all()
    {
        return $this->db->count_all($this->tbl);
    }

    function count_where($where = NULL)
    {
	    return $this->db->get_where($this->tbl,$where)->num_rows();
    }
    
    function get_multiple($where="", $columns="", $order="", $limit = 0, $offset = 0)
    {
		if($columns != '')
			$this->db->select($columns);
		
        if($where != '')
            $this->db->where($where);
        
        if($order != '')
            $this->db->order_by($order);
        
        if($limit == 0)
            $limit = $this->limit;
        
        return $this->db->get($this->tbl, $limit, $offset)->result_array();
    }
	
	function get_all($where="", $order="", $limit = 0, $offset = 0, $columns="" )
    {
		if($columns != '')
			$this->db->select($columns);
		
        if($where != '')
            $this->db->where($where);
        
        if($order != '')
            $this->db->order_by($order);
        
        if($limit == 0)
            $limit = $this->limit;
        
        return $this->db->get($this->tbl, $limit, $offset)->result();
    }
 
    function get_by_id($colname, $value)
    {
        $this->db->where($colname, $value);
        $rsReturn = $this->db->get($this->tbl)->result();
        return  isset($rsReturn[0]) ? $rsReturn[0] : NULL;
    }
    
    function insert($record)
    { 
		$this->db->insert($this->tbl, $record);
        return $this->db->insert_id();
    }
    
    function update($record, $arrWhere)
    {	//$this->db->where($where);
		$this->db->update($this->tbl, $record, $arrWhere);
    }
	
	function insert_batch($record){ 
		return $this->db->insert_batch($this->tbl, $record);
    }
    
    function delete($id)
    {   
		$this->db->where('id', $id);
        $this->db->delete($this->tbl);
    }
	
	function count_by_where($where){
		return $this->db->get_where($this->tbl,$where)->num_rows();
	}
}


/* End of file city.php */
/* Location: ./application/models/internmodel.php */