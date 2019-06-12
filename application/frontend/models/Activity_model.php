<?php
class Activity_model extends Data{
	public $tbl_banner = 'banner';
	public $tbl_banner_category = 'banner_category';
	public $tbl_banner_media = "banner_media";
	public $tbl_available_slot = "available_slot";
	public $tbl_order_master = "order_master";
	public $tbl_activities_media = "activities_media";
	public $tbl_partner = "partner";
	public $tbl_activities = "activities";
	public $tbl_partner_services = "partner_services";
	public $tbl_partner_schedule = "partner_schedule";
	function __construct(){
        parent::__construct();
		$this->alias = "c";
		$this->tbl = $this->tbl_activities;
	}
	
	function get_list(){
		$this->db->select("b.id as activity_id, b.title as name, b.address as address, b.lat as lat, b.long as long, b.price as price, b.price_type rate_on, b.description as description, b.image as image, b.index as index" );
		$this->db->from($this->tbl_activities." b");
		$this->db->join($this->tbl_banner_category." bc","b.category_id = bc.id","LEFT");
		$this->db->where(array("b.delete_flag"=>0));
		$this->db->order_by("b.index","ASC");
		return $this->db->get()->result_array();
	}
	
	function get_activity($banner_id = NULL){
		$this->db->select("b.id as activity_id,  b.title as name, b.image as image, b.address as address, b.lat as lat, b.long as long, b.price as price, b.price_type rate_on, b.description as description,  b.index as index" );
		$this->db->from($this->tbl_activities." b");
		//$this->db->join($this->tbl_banner_category." bc","b.category_id = bc.id","LEFT");
		if($banner_id != NULL && $banner_id != ""){
			$this->db->where(array("b.id"=>$banner_id));
		}
		$this->db->where(array("b.delete_flag"=>0));
		$this->db->order_by("b.index","ASC");
		return $this->db->get()->result_array();
	}
	
	function get_category_banner(){
		$this->db->select("b.id as activity_id, b.category_id as category_id, b.address as address, b.title as title, b.description as description, b.image as image, b.index as index" );
		$this->db->from($this->tbl_activities." b");
		$this->db->join($this->tbl_banner_category." bc","b.category_id = bc.id","LEFT");
		$this->db->where(array("b.delete_flag"=>0));
		$this->db->order_by("b.index","ASC");
		return $this->db->get()->result_array();
	}
	
	function get_all_activity_media(){
		$this->db->select("id, banner_id as activity_id, file as image, type");
		$this->db->from($this->tbl_activities_media);
		$this->db->where(array("delete_flag"=>0));
		return $this->db->get()->result_array();
	}
	
	function get_all_media(){
		$this->db->select("id, banner_id as activity_id, file as image, type");
		$this->db->from($this->tbl_activities_media);
		$this->db->where(array("delete_flag"=>0));
		return $this->db->get()->result_array();
	}
	
	function get_category(){
		$this->db->select("id as category_id, title, description, image, index, is_activity");
		$this->db->from($this->tbl_banner_category);
		$this->db->where(array("delete_flag"=>0));
		$this->db->order_by("index","ASC");
		return $this->db->get()->result_array();
	}
	
	function get_available_slot($activity_id = NULL,$date=NULL){
		$select = "*";
		$this->db->select($select);
		$this->db->from($this->tbl_available_slot);
		$this->db->where("activity_id = ".$activity_id." AND CONCAT(date,' ',from_time) >= '".$date."' AND is_book = 0 AND delete_flag = 0");
		$this->db->group_by("date");
		return $this->db->get()->result_array();
	}
	
	function get_available_slot_time($date = NULL,$activity_id=NULL){
		$select = "id as slot_id, activity_id, date, from_time, to_time";
		$this->db->select($select);
		$this->db->from($this->tbl_available_slot);
		$this->db->where("activity_id = $activity_id AND date = '".$date."' AND is_book = 0 AND delete_flag = 0");
		$this->db->group_by("date");
		return $this->db->get()->result_array();
	}
	
	function get_book_slot(){
		$select = "*";
		$this->db->select($select);
		$this->db->from($this->tbl_available_slot);
		$this->db->where("date >= '".date("Y-m-d")."' AND is_book = 0 AND delete_flag = 0");
		$this->db->group_by("date");
		return $this->db->get()->result_array();
	}
	
	function check_slot_availibility($id = NULL){
		return $this->db->get_where($this->tbl_available_slot,array("id"=>$id,"is_book"=>0,"delete_flag"=>0))->num_rows();
	}
	
	function update_order_status($data = array(), $id = NULL){
		return $this->db->set($data)->where(array("id"=>$id,"delete_flag"=>0))->update($this->tbl_available_slot);
	}
	function check_order_availibility($orderid = ''){
		return $this->db->get_where($this->tbl_order_master,array("id"=>$orderid,"delete_flag"=>0))->num_rows();
	}
	
	function checkUser($userid = ''){
		return $this->db->get_where($this->tbl_partner,array("id"=>$userid,"delete_flag"=>0))->num_rows();
	}
	function checkActivity($actitvityid = ''){
		return $this->db->get_where($this->tbl_activities,array("id"=>$actitvityid,"delete_flag"=>0))->num_rows();
	}
	function checkSlot($slotid = '',$orderid = ''){
		/*return $this->db->select('s.*')
					 ->from($this->tbl_available_slot .' s')
					 ->join($this->tbl_order_master .' o','o.slot_id = s.id','left')
					 ->where('s.id = "'.$slotid.'" AND o.id = "'.$orderid.'" AND o.slot_id != "'.$slotid.'" AND o.delete_flag = 0 AND s.delete_flag = 0 AND s.is_book = 0')->get()->num_rows();*/
		return $this->db->get_where($this->tbl_order_master,array("id"=>$orderid,"slot_id"=>$slotid,"delete_flag"=>0))->num_rows();
		//return $this->db->get_where($this->tbl_available_slot,array("id"=>$slotid,"","delete_flag"=>0))->num_rows();
	}
	function checkBook($slot_id = ''){
		return $this->db->get_where($this->tbl_available_slot,array("id"=>$slot_id,"is_book"=>0,"delete_flag"=>0))->num_rows();
	}
	function book($data = array()){
		return $this->db->insert($this->tbl_order_master,$data);
	}
	function update_book($data,$orderid){
		return $this->db->set($data)->where('id = "'.$orderid.'"')->update($this->tbl_order_master);	
	}
	
	function get_user_order($date = NULL){
		$select = "o.id as order_id, o.status as order_status, o.activity_id as activity_id, o.slot_id as slot_id, ac.title as activity_name, o.date as order_date, as.date as activity_date, as.from_time, as.to_time";
		$this->db->select($select);
		$this->db->from($this->tbl_order_master." o");
		$this->db->join($this->tbl_available_slot." as","o.slot_id = as.id","LEFT");
		$this->db->join($this->tbl_activities." ac","o.activity_id = ac.id","LEFT");
		$this->db->where(" o.user_id = ".$this->user_id." AND o.user_id = as.book_by AND o.status = 'success' AND o.delete_flag = 0");
		if($date != '') $this->db->where("DATE(o.date) = '$date'");
		return $this->db->get()->result_array();
	}
	
	
}