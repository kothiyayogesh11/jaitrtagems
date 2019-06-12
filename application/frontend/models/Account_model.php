<?php

class Account_model extends Data{

	public $tbl_available_slot = "available_slot";

	public $tbl_order_master = "order_master";

	public $tbl_activities_media = "activities_media";

	public $tbl_partner = "partner";

	public $tbl_client = "client_master";

	public $tbl_activities = "activities";

	public $tbl_partner_services = "partner_services";

	public $tbl_partner_schedule = "partner_schedule";

	public $tbl_city_master = "city_master";

	public $tbl_state_master = "state_master";

	public $tbl_client_payment_type = "user_payment_type";

	public $tbl_pet_master = "pet_master";

	public $tbl_pet_type = "pet_type";

	public $tbl_breed = "breed";

	function __construct(){

        parent::__construct();

		$this->alias = "c";

		$this->tbl = $this->tbl_activities;

	}

	function getPartnerActivity(){

		$this->db->select("ps.id as subservicesid ,ps.activity_id as activity_id, ps.partner_id as partner_id, ps.price as price, ps.description as description, act.title as name, act.image");

		$this->db->from($this->tbl_partner_services." ps");

		$this->db->join($this->tbl_activities." act","act.id = ps.activity_id","LEFT");

		$this->db->where(array("ps.partner_id"=>$this->user_id,"ps.delete_flag"=>0,"act.delete_flag"=>0));

		return $this->db->order_by("act.title","ASC")->get()->result_array();

	}

	function service_activity($activity_id = NULL, $partner_id = NULL){

		$this->account->tbl = $this->account->tbl_partner_services;

		$sel = " c.id as service_id, c.price as price, c.description, a.image as activity_image, a.description activity_description, a.title as activity_title, p.business_name, p.name as partner_name, CONCAT(ct.city_name,', ',st.state_code) as city_state,p.address as address,COALESCE((select ROUND(avg(rating)) from ".$this->tbl_order_master." where partner_id = ".$partner_id.") , '0')as partner_rating";

		$where = "c.partner_id = ".$partner_id." AND c.activity_id = ".$activity_id." AND c.delete_flag = 0 AND p.id = ".$partner_id." AND p.is_available = 1 AND p.delete_flag = 0 AND a.id = ".$activity_id." AND a.delete_flag = 0";

		$this->db->select($sel);

		$this->db->from($this->tbl." ".$this->alias);

		$this->db->join($this->account->tbl_partner." p","c.partner_id = p.id","LEFT");

		$this->db->join($this->account->tbl_activities." a"," c.activity_id = a.id","LEFT");

		$this->db->join($this->account->tbl_city_master." ct"," p.city = ct.city_id","LEFT");

		$this->db->join($this->account->tbl_state_master." st"," st.state_id = ct.state_id","LEFT");

		$this->db->where($where);

		$this->db->order_by("c.id","DESC");

		$this->db->limit(1);

		return $this->db->get()->result_array();

	}

	function getActivityMedia($activity_id = NULL, $partner_id = NULL){

		$this->db->select("banner_id as media_id, partner_id, file as media, type");

		$this->db->from($this->tbl_activities_media);

		$this->db->where(array("banner_id" => $activity_id,"partner_id"=>$partner_id));

		return $this->db->get()->result_array();

	}

	function getPartnerActivityMedia(){

		$this->db->select("banner_id as activity_id, partner_id, file as media, type");

		$this->db->from($this->tbl_activities_media);

		$this->db->where(array("partner_id"=>$this->user_id));

		return $this->db->get()->result_array();

	}

	function customerPaymentMethods(){

		$this->tbl = $this->tbl_client_payment_type;

		return $this->get_all(array("user_id"=>$this->user_id,"delete_flag"=>0),"name ASC","*");

	}

	

	function getPets(){

		$this->db->select("name, profile, id as pets_id");

		$this->db->from($this->tbl_pet_master);

		$this->db->where(array("client_id"=>$this->user_id,"delete_flag"=>0));

		return $this->db->order_by("name","DESC")->get()->result_array();

	}

	function getCustomerPendingOrder(){

		

		//$this->tbl = $this->tbl_available_slot;

		$al = $this->alias;

		$select = $al.".id as order_id,act.id as activity_id,av.date as activity_date,av.from_time as activity_from_time,av.to_time as  activity_to_time,av.date as order_date, CONCAT(av.`date`,' ',av.from_time) as order_start_date, CONCAT(av.`date`,' ',av.to_time) as order_end_date, av.book_time as book_time, av.book_by as user_id, act.title as order_title, act.description as description, act.image as activity_image,(select price from ".$this->tbl_partner_services." where partner_id = c.partner_id AND activity_id = act.id and delete_flag = 0) as order_price, c.partner_id as partner_id, act.price_type as price_type,".$al.".payment_status as payment_status";

		$where = "av.book_by = ".$this->user_id." AND av.is_book != 1 AND av.delete_flag = 0 AND av.date >= '".date('Y-m-d')."'";

		$this->db->select($select);

		$this->db->from($this->tbl_order_master." ".$al);

		$this->db->join($this->tbl_available_slot." av",$al.".slot_id = av.id AND av.delete_flag = 0","LEFT");

		$this->db->join($this->tbl_activities." act",$al.".activity_id = act.id","LEFT");

		

		$this->db->join($this->tbl_client." cl","av.book_by = cl.id","LEFT");

		$this->db->where($where);

		$this->db->order_by($al.".id","DESC");

		return $this->db->get()->result_array();

	}

	function getCustomerPendingOrderForm($order=NULL){

		$al = $this->alias;

		$select = $al.".id as order_id,act.id as activity_id, $al.pet_id as pet_id, $al.location as address, $al.lat as lat,$al.long as long, av.date as activity_date,av.from_time as activity_from_time,av.to_time as  activity_to_time,av.date as order_date, CONCAT(av.`date`,' ',av.from_time) as order_start_date, CONCAT(av.`date`,' ',av.to_time) as order_end_date, av.book_time as book_time, $al.service_type as service_type, av.book_by as user_id, act.title as order_title, act.description as description, act.image as activity_image,(select price from ".$this->tbl_partner_services." where partner_id = c.partner_id AND activity_id = act.id and delete_flag = 0) as order_price, c.partner_id as partner_id, act.price_type as price_type,".$al.".payment_status as payment_status, $al.payment_method as payment_id";

		$where = $al.".id = ".$order." AND av.book_by = ".$this->user_id." AND av.is_book != 1 AND av.delete_flag = 0 AND av.date >= '".date('Y-m-d')."'";

		$this->db->select($select);

		$this->db->from($this->tbl_order_master." ".$al);

		$this->db->join($this->tbl_available_slot." av",$al.".slot_id = av.id AND av.delete_flag = 0","LEFT");

		$this->db->join($this->tbl_activities." act",$al.".activity_id = act.id","LEFT");

		

		$this->db->join($this->tbl_client." cl","av.book_by = cl.id","LEFT");

		$this->db->where($where);

		$this->db->order_by($al.".id","DESC");

		return $this->db->get()->result_array();

	}

	function getPetsType(){

		$this->db->select("id as type_id, name as pets_name, code");

		$this->db->from($this->tbl_pet_type);

		$this->db->where(array("delete_flag"=>0));

		return $this->db->order_by("name","ASC")->get()->result_array();

	}

	function getBreedType($pets_type = NULL){

		$this->db->select("id as breed_id, pet_type, name, code");

		$this->db->from($this->tbl_breed);

		$this->db->where(array("pet_type"=>$pets_type,"delete_flag"=>0));

		return $this->db->order_by("name","ASC")->get()->result_array();

	}

	function get_availability(){

		$this->db->select("is_available, from_time, to_time");

		$this->db->from($this->tbl_partner);

		$this->db->where(array("id"=>$this->user_id,"delete_flag"=>0));

		return $this->db->get()->result_array();

	}

	function getPartnerScheduleByDate($date = NULL){

		$this->db->select("partner_id, available, available_date");

		$this->db->from($this->tbl_partner_schedule);

		$this->db->where(array("partner_id"=>$this->user_id,"DATE(available_date)"=>$date,"delete_flag"=>0));

		$this->db->limit(1);

		return $this->db->order_by("DATE(available_date)","DESC")->get()->result_array();

	}

	function getAllActivity(){

		$this->db->select("id, title, image");

		$this->db->from($this->tbl_activities." a");

		$this->db->where(array("delete_flag"=>0));

		return $this->db->order_by("title","DESC")->get()->result_array();

	}

	function getUnaddedService(){

		/*$this->db->select("id, title, image");

		$this->db->from($this->tbl_activities." a");

		$this->db->where(" id NOT IN(SELECT activity_id FROM $this->tbl_partner_services WHERE partner_id = $this->user_id AND delete_flag = 0) AND delete_flag = 0 ");

		return $this->db->order_by("title","DESC")->get()->result_array();*/

		

		$this->db->select("id, title, image");

		$this->db->from($this->tbl_activities." a");

		$this->db->where(" delete_flag = 0");

		return $this->db->order_by("title","DESC")->get()->result_array();

	}

	

	function get_partner_details($partner_id){

		return $this->db->select('*,(select title from '.$this->tbl_activities.' where id = activity_id AND delete_flag = 0) as activity_name')->from($this->tbl_partner_services)->where('delete_flag = 0 AND partner_id = "'.$partner_id.'"')->group_by('activity_id')->get()->result_array();

	}

	function update_customer_profile($data = array()){
		return $this->db->set($data)->where('delete_flag = 0 AND id = "'.$this->user_id.'"')->update($this->tbl_client);
	}
	
	function update_partner_profile($data = array()){
		return $this->db->set($data)->where('delete_flag = 0 AND id = "'.$this->user_id.'"')->update($this->tbl_partner);
	}
}