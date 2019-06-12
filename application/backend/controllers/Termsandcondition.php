<?php
class Termsandcondition extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('terms_condition_model','terms_model');
	}
	
	function booking(){
		$data['terms_data'] = $this->terms_model->getBookingTerms();
		$this->load->view('termscondition/booking',$data);
	}
	
	function update_booking_terms(){
		$id = $this->input->post('id');
		$terms_text = $this->input->post('val_text');
		if($id != ''){
			$res = $this->terms_model->change_booking_terms($terms_text, $id);
		}else{
			$res = $this->terms_model->add_booking_terms($terms_text);
			$id = $this->db->insert_id();
		}
		$msg = $res ? array('error'>0,'message'=>'Booking terms has been saved successfully..') : array('error'>1,'message'=>'Failed to save Booking Terms..');
		$msg['id'] = $id;
		echo json_encode($msg);
	}
	
}
?>