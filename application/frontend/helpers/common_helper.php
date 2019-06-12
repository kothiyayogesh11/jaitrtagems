<?php
if(!function_exists('multi_implode')){
	function multi_implode($array, $glue = ',') {
		$ret = '';
		foreach ($array as $item) {
			if (is_array($item)) {
				$ret .= multi_implode($item, $glue) . $glue;
			} else {
				$ret .= $item . $glue;
			}
		}
		$ret = substr($ret, 0, 0-strlen($glue));
		return rtrim($ret,',');
	}
}
	
if(!function_exists('compress')){
	function compress($source, $destination, $quality) {
		$info = getimagesize($source);
		
		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);
		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);
		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);
		imagejpeg($image, $destination, $quality);
		return $destination;
	}
}	

if(!function_exists('file_check')){
	function file_check($file = NULL,$type='dp'){
		
		
		//$file_headers = @get_headers($cfile);
		if($file != '' && file_exists($file) ) {
			return base_url($file);
		}else{
			$file_temp = "assets/profile.jpg";
			if($type == 'dp'){
				return base_url($file_temp);
			}else if($type == "pets"){
				return base_url("assets/pets.png");
			}else{
				return base_url($file_temp);
			}
		}
	}
}
	
if(!function_exists('time_strips')){
	function time_strips($start = NULL, $end = NULL){
		$start = $start != NULL || $start != '' ? $start : date('Y-m-d H:i:s');
		$end = $end != NULL || $end != '' ? $end : date('Y-m-d H:i:s');
		$startd 	= new DateTime($start);
		$end		= new DateTime($end);
		$interval 	= $startd->diff($end);
		$year 		= $interval->format('%y');
		$month 		= $interval->format('%m');
		$day 		= $interval->format('%d');
		$hour		= $interval->format('%h');
		$min		= $interval->format('%i');
		$sec		= $interval->format("%s");
		$chours 	= $day * 24;	
		//return $chours + $hour.':'.$min.':'.$sec;
		$total_time = timeToSeconds($hour + $chours.':'.$min.':'.$sec);			
		if($total_time <= 60){
			$rs = ' just now';
		}else if($total_time > 60 && $total_time <= 120){
			$rs = '1 minutes ago';
		}else if($total_time > 120 && $total_time <= 3599){
			$rs = $min.' minutes ago';
		}else if($total_time >= 3600 && $total_time <= 7199){
			$rs = $hour.' hour ago';
		}else if($total_time >= 7200 && $total_time <= 21600 && $month < 0){
			$rs = $hour.' hours ago';
		}else if(($hour >= 1 &&  $hour <= 24) && $day < 1 && $month < 1){
			$rs = $hour.' hours ago';
		}else if($hour > 10 && $day > 1 && $month < 1){
			$rs = ' '.date('D d-M h:i A',strtotime($start));
		}else if($day >= 1 && $day <= 7 && $month < 1){
			$rs = ' '.date('D d-M h:i A',strtotime($start));
		}else if($month < 12 && $year < 1){
			$rs = ' '.date('D d-M h:i A',strtotime($start));
		}else{
			$rs = ' '.date('d-M-Y h:i A',strtotime($start));
		}
		return ' '.$rs;
	}
}
	
if(!function_exists('timeToSeconds')){
	function timeToSeconds($time)
	{
		 $timeExploded = explode(':', $time);
		 if (isset($timeExploded[2])) {
			 return $timeExploded[0] * 3600 + $timeExploded[1] * 60 + $timeExploded[2];
		 }
		 return $timeExploded[0] * 3600 + $timeExploded[1] * 60;
	}
}
	
if(!function_exists('idExists')){
	function idExists($val='', $key = NULL, $haystack=array()){
		foreach ($haystack as $item) {
			if ($item[$key]==$val)	return TRUE;
		}
		return FALSE;
	}
}

if(!function_exists('time_count')){
	function time_count($start,$end){
		$start 	= new DateTime($start);
		$end		= new DateTime($end);
		$interval 	= $start->diff($end);	
		$year 		= $interval->format('%y');
		$month 		= $interval->format('%m');
		$day 		= $interval->format('%d');
		$hour		= $interval->format('%h');
		$min		= $interval->format('%i');
		$sec		= $interval->format("%s");
		$chours 	= $day * 24;	
		return timeToSeconds($hour + $chours.':'.$min.':'.$sec);
	}
}
if(!function_exists('ext_getter')){
	function ext_getter($file = NULL){
		return ($file != '' && $file != NULL) ? pathinfo($file, PATHINFO_EXTENSION) : NULL;
	}
}

if(!function_exists('pre')){
	function pre($array = NULL, $dump = NULL){
		if(is_array($array) || gettype($array) == 'object'){
			echo "<pre>";
			print_r($array);
			echo "</pre>";
		}else if($dump != TRUE){
			echo $array;	
		}	
		if($dump == TRUE){
			echo '<pre>';
			var_dump($array);
			echo '</pre>';
		}
	}
}
if(!function_exists('unique_digit')){
	function unique_digit($len = 5,$table = 'cb_active_account', $field = 'otp'){
		$ci =& get_instance();
		$ci->load->helper('string');
		$dig = random_string('numeric',$len);
		if($dig != ''){
			$cnt = $ci->db->get_where($table,$field.' = '.$dig)->num_rows();
			if($cnt > 0){
				unique_digit($len, $table, $field);
			}else{
				return $dig;
			}
		}else{
			unique_digit($len,$table,$field);
		}
		return $dig;
	}
}
if(!function_exists('time_day')){
	function time_day($start,$end){
		$start 	= new DateTime($start);
		$end		= new DateTime($end);
		$interval 	= $start->diff($end);	
		$year 		= $interval->format('%y');
		$month 		= $interval->format('%m');
		$day 		= $interval->format('%d');
		$hour		= $interval->format('%h');
		$min		= $interval->format('%i');
		$sec		= $interval->format("%s");
		$chours 	= $day * 24;
		$cday 		= ($month * 30) * 24;
		$total = $chours + $cday + $hour;
		return $total;	
	}
}
if(!function_exists('date_compare')){
	function date_compare($a, $b){
		$t1 = strtotime($a['dtime']);
		$t2 = strtotime($b['dtime']);
		return $t1 - $t2;
	}   
}

if(!function_exists('str_lim')){
	function str_lim($str = '',$len = 25){
		if(trim($str) != '' && strlen(trim($str)) > $len)
		return substr(trim($str),0,$len).'...';
		else return trim($str);
	}
}

if(!function_exists('encoded_id')){
	function encoded_id($id = NULL){
		return is_int($id) ? ($id * 2222) / 22 : NULL;
	}
}
if(!function_exists('decoded_id')){
	function decoded_id($id = NULL){
		return is_int($id) != '' ? ($id / 2222) * 22 : NULL;
	}
}
if(!function_exists('check_ajax_request')){
	function check_ajax_request(){
		$ci =& get_instance();
		return $ci->input->is_ajax_request();
	}
}
if(!function_exists('string_to_url')){
	function string_to_url($str = NULL){
		return preg_replace('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i','<a href="$0" target="_blank" title="$0">$0</a>', $str);
	}
}
if(!function_exists('day_count')){
function day_count($start,$end){
	$start 	= new DateTime($start);
	$end		= new DateTime($end);
	$interval 	= $start->diff($end);	
	$year 		= $interval->format('%y');
	$month 		= $interval->format('%m');
	$day 		= $interval->format('%d');
	$day = ($month * 30) + ($year * 365) + $day;
	return $day;
}
}
if(!function_exists('numOfTimeline')){
	function numOfTimeline(){
		return 5;
	}
}

if(!function_exists('get_message')){
	function get_message($message, $type=0) {
		if($type == 1){
			$msg = '<div class="alert alert-danger fade in alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'.$message.'</div>';
		}else{
			$msg = '<div class="alert alert-success fade in alert-dismissable" style="margin-top:10px;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <strong>'.$message.'</strong></div>';
		}
		return $msg;
	}
}

if(!function_exists('getAlerts')){
	function getAlerts(){
		$ci =& get_instance();
		$uid = $ci->session->userdata('id');
		if(!empty($uid)){
			$ci->load->model('notification_model');
			return $data = $ci->notification_model->getAdminNotification();
		}
	}
}

?>