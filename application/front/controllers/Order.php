<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends YK_Controller{

    function __construct(){
        parent::__construct();
    }

    function index(){
        pre($this->input->post());

    }
}