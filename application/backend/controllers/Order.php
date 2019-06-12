<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 21/02/2019
 * Time: 03:29 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order extends YK_Controller{
	public $week;
    function __construct(){
        parent::__construct();
        $this->load->model("order_model", 'order');
    }
	
    public function index(){
        $al = $this->order->alias = 'o';
		$rsListing = array();
        $searchCriteria = array();
        $rsData = $this->order->order_list();
        //pre($rsData);exit;
        $rsListing['rsData']	=	$rsData;
		$activeArr[1] = "De-Active";
		$activeArr[0] = "Active";
		$orderStatusLabel["pending"] = "btn btn-primary btn-rounded";
		$orderStatusLabel["success"] = "btn btn-lime btn-rounded";
		$orderStatusLabel["failed"] = "btn btn-danger btn-rounded";
		$rsListing['activeArr'] = $activeArr;
		$rsListing['orderStatusLabel'] = $orderStatusLabel;
        $this->load->view('order/list',$rsListing);
    }
	
}