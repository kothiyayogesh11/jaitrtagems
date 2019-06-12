<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Contact extends YK_Controller{
    function __construct(){
		parent::__construct();
		$this->load->model("home_model","home");
    }
	
	function index(){
		$this->load->view("contact");
	}
}