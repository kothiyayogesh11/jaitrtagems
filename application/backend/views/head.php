<?php
set_time_limit(0);
$this->output->set_header("HTTP/1.0 200 OK");
$this->output->set_header("HTTP/1.1 200 OK");
$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache");

// Check User Login in Session
if($this->page->getSession("intUserId") == ''){
	redirect('login', 'location');
}else{
	$c = $this->page->getRequest("c");
	$m = $this->page->getRequest("m");

	
	/*if(strtolower($c) != strtolower($this->page->getSession("strUserType")))
	{
		show_404();
	}*/
	

	$intUserId		=	$this->page->getSession("intUserId");	
	
	// Set UserSearch
    /*
	if($this->page->getSession("UserSearchSet") == '')
	{
		$arrUserSearch	=	$this->Module->getUserSearch($intUserId);
		
		if(count($arrUserSearch)>0)
		{
			$arrUserSearch = unserialize($arrUserSearch[0]['params']);
		
			foreach($arrUserSearch as $Key	=> $Value)
			{
				$this->page->setSession($Key,$Value);
			}
		}	
		
		$this->page->setSession("UserSearchSet",1);
	}
    */
}

?>