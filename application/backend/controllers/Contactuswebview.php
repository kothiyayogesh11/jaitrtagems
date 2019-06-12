<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 17/02/2019
 * Time: 01:40 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contactuswebview extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    public function index(){
		$this->load->view("api/contactuswebview");
    }
}