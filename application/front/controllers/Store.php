<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Store extends YK_Controller{
  function __construct(){
		parent::__construct();
		//checkAuth();
		$this->load->model("store_model","store");
  }
	
	function index(){		
		$select = "p.id as product_id, p.category_id as category_id, p.slug as slug, p.name as product_name, p.image as p_image, p.price, IF(CHAR_LENGTH(p.description) > 20, CONCAT(LEFT(p.description,20), '...'), p.description) as description, c.slug as cat_slug";
		$join = array(array(
			"table" => $this->store->tbl_product_category . " c",
			"condition" => "c.id = p.category_id",
			"type" => "LEFT"
		));
		$product = $this->store->get_all(array("p.delete_flag"=>0),"p.index ASC",$select, $join);
		if(!empty($product))
		foreach($product as $val){
			$data["product"][$val["product_id"]] = $val;
			$category_product[$val["category_id"]][$val["product_id"]] = $val;
		}
		
		$category = $this->store->tbl = $this->store->tbl_product_category;
		$select = "id as categry_id, slug as cat_slug, name as category_name, image, description as description";
		$category = $this->store->get_all(array("delete_flag"=>0), "index ASC", $select);
		if(!empty($category))
		foreach($category as $val){
			$val["product"] = isset($category_product[$val["categry_id"]]) ? $category_product[$val["categry_id"]] : array();
			$data["category"][$val["categry_id"]] = $val;
		}
		$this->load->view("store",$data);
	}
}