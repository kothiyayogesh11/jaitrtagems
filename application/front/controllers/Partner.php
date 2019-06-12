<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Partner extends YK_Controller{
	function __construct(){
		parent::__construct();
		checkAuth();
		$this->load->model("partner_model","partner");
    }
    
    function get_activity_details_by_id(){
        $activty_id = $this->input->post("activity_id",true);
        $data = array();
        $status = 0;
        $message = "Failed";
        if($activty_id != ""){
            $activity_details = $this->partner->service_activity($activty_id, $this->user_id);
            /* pre($this->db->last_query());
            exit; */
            if(!empty($activity_details) && isset($activity_details[0])){
                $media = $this->partner->getActivityMedia($activty_id);
                $data["activity"] = $activity_details[0];
                $data["media"] = $media;
                $status = 1;
                $message = "Success!";
            }else{
                $data = array();
                $status = 0;
                $message = "Service is not link to account, Add service first";
            }
        }
        echo json_encode(array("result"=>$status,"message"=>$message,"data"=>$data));
    }
    
}