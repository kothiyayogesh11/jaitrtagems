<?php 
class Dashboard_model extends Data{
	var $tbl_client_master = "client_master";
	var $tbl_pet_master = "pet_master";
	var $tbl_available_slot = "available_slot";
	
	function __construct(){
        parent::__construct();
		$this->tbl = $this->tbl_client_master;
    }
	
	function count_user(){
		return $this->db->get_where($this->tbl,array("delete_flag"=>0))->num_rows();
	}
	
	function count_by_date($from_date, $to_date){
		$where = "insertDate >= '".$from_date."' AND insertDate <= '".$to_date."' AND delete_flag = 0";
		return $this->db->get_where($this->tbl,$where)->num_rows();
	}
	
	function count_pending_order(){
		return $this->db->get_where($this->tbl,array("is_book"=>2,"delete_flag"=>0))->num_rows();
	}
	
	function count_pending_order_by_date($from_date, $to_date){
		$where = "is_book = 2 AND book_time >= '".$from_date."' AND book_time <= '".$to_date."' AND delete_flag = 0";
		return $this->db->get_where($this->tbl,$where)->num_rows();
	}
	
	function count_order(){
		return $this->db->get_where($this->tbl,array("is_book"=>1,"delete_flag"=>0))->num_rows();
	}
	
	function count_order_by_date($from_date, $to_date){
		$where = "is_book = 1 AND book_time >= '".$from_date."' AND book_time <= '".$to_date."' AND delete_flag = 0";
		return $this->db->get_where($this->tbl,$where)->num_rows();
	}
	
	
}
?>