<?php defined('BASEPATH') OR exit('No direct script access allowed');
class YK_Controller extends CI_Controller{
	var $datetime;
	var $user_id;
	var $ip;
	var $error_msg;
	var $panel_view;
	var $admin_data;
    function __construct(){
		parent::__construct();
		$this->user_id 		= $this->page->getSession("intUserId");
		$this->admin_data 	= $this->page->get_admin_data();
		$this->datetime 	= date("Y-m-d H:i:s");
		$this->ip 			= $this->general->ip();
		$this->error_msg 	= $this->page->getMessage();
		$this->panel_view 	= $this->get_panel_view();
    }
	
	public function get_panel_view(){
		$c = strtolower($this->router->fetch_class());
		$m = strtolower($this->router->fetch_method());
		$user_type = $this->page->getSession("strUserType");
		$panel_ids = array();
		$modules = array();
		$access_data = array();
		
		/* Get All Panel List */
		$get_panel_data = $this->page->get_panel();
		if(!empty($get_panel_data) && is_array($get_panel_data))
		foreach($get_panel_data as $pval) $panel_ids[] = $pval["panel_id"];
		/* End */
		
		/* Get All Module By Panel */
		$get_module_data = $this->page->get_module($panel_ids,$user_type);
		if(!empty($get_module_data) && is_array($get_module_data))
		foreach($get_module_data as $mval) $modules[$mval["panel_id"]][] = $mval;
		/* End */
		
		/* Proccess For Panel */
		foreach($get_panel_data as $pval){
			if(isset($modules[$pval["panel_id"]]) && !empty($modules[$pval["panel_id"]])){
				foreach($modules[$pval["panel_id"]] as $key => $mval){
					$murl = $mval["module_url"];
					$urlArr = array();
					$urlArr = explode("/",$murl);
					if(!empty($urlArr) && count($urlArr) == 1)
					$urlArr[1] = "index";
					
					$urlStr = implode("/",$urlArr);
					if(strtolower($urlStr) == $c."/".$m){
						$pval["expand"] = 1;
						$modules[$pval["panel_id"]][$key]["expand"] = 1;
					}
				}
				$pval["modules"] = $modules[$pval["panel_id"]];
				$access_data[$pval["seq"]][] = $pval;
			}
		}
		ksort($access_data);
		/* End */
		return $access_data;
	}
}