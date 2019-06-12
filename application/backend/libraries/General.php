<?php
defined('BASEPATH') || exit('No direct script access allowed');
/*
	Created By YK11
	Create Date : 29-07-18
	User For general
*/
class General {
    protected $CI;
    public function __construct(){
        $this->CI = & get_instance();
    }
	
    public function getRandomNumber($len = 15){
        $better_token = strtoupper(md5(uniqid(rand(), TRUE)));
        $better_token = substr($better_token, 1, $len);
        return $better_token;
    }

    public function getRandomString($len = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $random_string = '';
        for ($i = 0; $i < $len; $i++) $random_string .= $characters[rand(0, $characters_length - 1)];
        return $random_string;
    }

    public function truncateChars($str = '', $len = 25){
        if (trim($str) == '' || $len < 3) return $str;
        return strlen($str) > $len ? substr($str, 0, ($len - 3)) . "..." : $str;
    }

    public function ip(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_FORWARDED'];
        } else { // return remote address
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function getDateOnly($date = ''){
        if ($date != '0000-00-00' && $date != '0000-00-00 00:00:00' && trim($date) != '') {
            return date("Y-m-d", strtotime($date));
        } else {
            return '';
        }
    }

    public function getDayOnly($date = ''){
        if ($date != '0000-00-00' && $date != '0000-00-00 00:00:00' && trim($date) != '') {
            return date("l", strtotime($date));
        } else {
            return '';
        }
    }

    public function getTimeOnly($date = ''){
        if ($date != '0000-00-00' && $date != '0000-00-00 00:00:00' && trim($date) != '') {
            return date("h:i A", strtotime($date));
        } else {
            return '';
        }
    }

    public function isJson($string = ''){
        if (empty($string)) return FALSE;
        json_decode($string, TRUE);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function escape_str($str = ''){
        return $this->CI->db->escape($str);
    }

    public function escape_like_str($str = ''){
        return $this->CI->db->escape_like_str($str);
    }

    public function getTablePrimaryKey($table_name = ''){
        if ($table_name != "") {
            $tbl_fields = $this->CI->db->field_data($table_name);
            if (is_array($tbl_fields) && count($tbl_fields) > 0) {
                foreach ((array) $tbl_fields as $field) {
                    if ($field->primary_key) {
                        $pkkey = $field->name;
                        break;
                    }
                }
            }
        }
        return $pkkey;
    }

    public function CISendMail($to = '', $subject = '', $body = '', $from = '', $from_name = '', $cc = '', $bcc = '', $attach = array()){
        $success = FALSE;
        try {
            if (empty($to)) throw new Exception("Receiver email address is missing..!");
            if (empty($body) || trim($body) == "") throw new Exception("Email body content is missing..!");
            $this->_email_subject = $subject;
            $this->_email_content = $body;

            $this->CI->load->library('email');
            $this->CI->email->from($from, $from_name);
            $this->CI->email->reply_to($from, $from_name);
            $this->CI->email->to($to);
            if (!empty($cc)) $this->CI->email->cc($cc);
            if (!empty($bcc)) $this->CI->email->bcc($bcc);
            $this->CI->email->subject($subject);
            $this->CI->email->message($body);
            //attachment section
            if (is_array($attach) && count($attach) > 0){
	            foreach ($attach as $ak => $av) $this->CI->email->attach($av['filename'], $av['position'], $av['newname']);
			}
            $success = $this->CI->email->send();
            if (is_array($attach) && count($attach) > 0) $this->CI->email->clear(TRUE);
            if (!$success) throw new Exception($this->CI->email->print_debugger(array("subject")));
            $message = "Email send successfully..!";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $this->_notify_error = $message;
        }
        return $success;
    }
    
    public function getSingleColArray($data_arr = array(), $index = ""){
        $retArr = array();
        if (!is_array($data_arr) || count($data_arr) == 0 || $index == "") return $retArr;
        foreach ((array) $data_arr as $key => $val) $retArr[] = $val[$index];
        return $retArr;
    }
	
	function gererate_json($response = array(),$status = 200){
		$this->CI->output
        ->set_status_header($status)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}
	
	public function requestData($method = 'GET_POST', $id_arg = NULL){
        switch ($method) {
            case 'GET':
            case 'GET_id':
                $get_arr = is_array($this->CI->input->get(NULL, TRUE)) ? $this->CI->input->get(NULL, TRUE) : array();
                $request_arr = $get_arr;
                break;
            case 'POST':
            case 'POST_id':
                $post_arr = is_array($this->CI->input->post(NULL, TRUE)) ? $this->CI->input->post(NULL, TRUE) : array();
                $request_arr = $post_arr;
                break;
            case 'POST_GET':
            default :
                $get_arr = is_array($this->CI->input->get(NULL, TRUE)) ? $this->CI->input->get(NULL, TRUE) : array();
                $post_arr = is_array($this->CI->input->post(NULL, TRUE)) ? $this->CI->input->post(NULL, TRUE) : array();
                $request_arr = array_merge($get_arr, $post_arr);
                break;
        }
        if (in_array($method, array("GET_id", "POST_id", "PUT_id", "DELETE_id"))) {
            if ($id_arg != NULL && !isset($request_arr['id'])) {
                $request_arr['id'] = $id_arg;
            }
        }
        return $request_arr;
    }
	
	function getBlockUser($uid = NULL){
		$uid == '' ? $this->CI->session->userdata('USER_ID') : $uid;
		$buids = $this->CI->db->select(" (CASE WHEN ub.user_id = ".$uid." THEN ub.blocked_user ELSE ".$uid." END) as buser_id ")
				 ->from('cb_user_block ub')
				 ->where(" (ub.user_id = ".$uid." OR ub.blocked_user = ".$uid.") AND ub.delete_flag = 0 ")
				 ->get()->result_array();
		$buid = array();
		foreach($buids as $val)	$buid[] = $val['buser_id'];
		return $buid;
	}
}