<?php
class Forgot_password_model extends CI_Model{
	var $tbl_user = 'client_master';
	var $tbl_shift = "ard_shift";
	var $tbl_role = "ard_role";
	var $tbl_check_in = "ard_check_in";
	var $tbl_user_present = "ard_user_present";
	var $tbl_absences = "ard_absences";
	var $tbl_absences_reason = "ard_absences_reason";
	var $tbl_leave_type = "ard_leave_type";	
	var $tbl_user_otp = "user_otp"; 
	var $tbl_employee = "employee";
	var $tbl_partner = "partner";
	
	function getUserByOtp($otp,$type=1){
		$tbl_array[1] = $this->tbl_user;
		$tbl_array[2] = $this->tbl_employee;
		$tbl_array[3] = $this->tbl_partner;
		$select = "uo.insertDate as issue_date, u.name as uname, u.id as uid, u.profile as user_profile";
		$this->db->select($select);
		$this->db->from($this->tbl_user_otp.' uo');
		$this->db->join(@$tbl_array[$type].' u','u.id = uo.user_id','left');
		$this->db->where(array('uo.type'=>1,'uo.otp'=>$otp,'uo.delete_flag'=>0,"uo.u_type"=>$type));
		return $this->db->get()->result_array();
	}
	
	function change($data = array(),$type = 1){
		$tbl_array[1] = $this->tbl_user;
		$tbl_array[2] = $this->tbl_employee;
		$tbl_array[3] = $this->tbl_partner;
		return $this->db->set($data)->where(array('id'=>$this->user_id))->update(@$tbl_array[$type]);
	}
	
	function removeOtp($otp,$type=1){
		return $this->db->delete($this->tbl_user_otp,array('otp'=>$otp,"u_type"=>$type));
	}
}