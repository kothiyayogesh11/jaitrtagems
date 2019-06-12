<?php
class Store_model extends Data{
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
	public $tbl_product_category = "product_category";
	public $tbl_product = "product";
	function __construct(){
        parent::__construct();
		$this->alias = "p";
		$this->tbl = $this->tbl_product;
	}
	
	
}