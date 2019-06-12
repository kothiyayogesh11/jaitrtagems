<?php
/**
 * Created by YK11
 * User: Yogesh Kothiya
 * Date: 23/02/2019
 * Time: 06:35 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends Data {
    public $tbl_client_master 	= "client_master";
    public $tbl_partner 		= "partner";
    public $tbl_employee 		= "employee";
    function __construct(){
        parent::__construct();
        $this->tbl = $this->tbl_client_master;
        $this->alias = "o";
    }


}