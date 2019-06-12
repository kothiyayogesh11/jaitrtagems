<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 11/06/2019
 * Time: 01:13 AM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class About extends YK_Controller{
    function __construct(){
        parent::__construct();
        //$this->load->model("product_model", 'product');
    }
    public function index(){
        $this->load->view('about');
    }
}