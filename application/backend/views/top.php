<?php 
$this->load->view('head');
$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
$this->output->set_header('Pragma: no-cache');
$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$strProfilePath	=	$this->page->getSetting("PROFILE_IMAGE_PATH");
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Pet Admin | <?php echo ucwords($this->router->fetch_class()); ?></title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,300,700" rel="stylesheet" id="fontFamilySrc" />
	<link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/bootstrap/bootstrap-4.1.1/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/font-awesome/5.1/css/all.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/ionicons/css/ionicons.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/animate.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/style.min.css'); ?>" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <?php
	echo isset($css) ? $css : "";
	?>
    <!--
    <link href="<?php echo base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/gritter/css/jquery.gritter.css'); ?>" rel="stylesheet" />	-->
	<!-- ================== END PAGE LEVEL CSS STYLE ================== -->
    
	<!-- ================== BEGIN BASE JS ================== -->
    <script>var BASE_URL = "<?php echo base_url(); ?>";</script>
	<script src="<?php echo base_url('assets/plugins/pace/pace.min.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!--[if lt IE 9]>
	    <script src="<?php echo base_url('assets/crossbrowserjs/excanvas.min.js'); ?>"></script>
	<![endif]-->
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="page-loader fade in"><span class="spinner">Loading...</span></div>
	<!-- end #page-loader -->

	<!-- begin #page-container -->
	<div id="page-container" class="fade page-container page-header-fixed page-sidebar-fixed page-with-two-sidebar page-with-footer">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="index-2.html" class="navbar-brand"><img src="<?php echo base_url('assets/img/logo.png'); ?>" class="logo" alt="" /> Pet Admin</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				<!-- begin navbar-right -->
				<ul class="nav navbar-nav navbar-right">
					<li>
						<form class="navbar-form form-input-flat">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Enter keyword..." />
								<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
							</div>
						</form>
					</li>
					<li class="dropdown">
						<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle has-notify" data-click="toggle-notify">
							<i class="fa fa-bell"></i>
						</a>
						<ul class="dropdown-menu dropdown-notification pull-right">
                            <li class="dropdown-header">Notifications (5)</li>
                            <li class="notification-item">
                                <a href="javascript:;">
                                    <div class="media"><i class="fa fa-exclamation-triangle"></i></div>
                                    <div class="message">
                                        <h6 class="title">Server Error Reports</h6>
                                        <div class="time">3 minutes ago</div>
                                    </div>
                                    <div class="option" data-toggle="tooltip" data-title="Mark as Read" data-click="set-message-status" data-status="unread" data-container="body">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-item">
                                <a href="javascript:;">
                                    <div class="media"><img src="<?php echo base_url('assets/img/user_1.jpg'); ?>" alt="" /></div>
                                    <div class="message">
                                        <h6 class="title">Solvia Smith</h6>
                                        <p class="desc">Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                                        <div class="time">25 minutes ago</div>
                                    </div>
                                    <div class="option read" data-toggle="tooltip" data-title="Mark as Unread" data-click="set-message-status" data-status="read" data-container="body">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-item">
                                <a href="javascript:;">
                                    <div class="media"><img src="<?php echo base_url('assets/img/user_2.jpg'); ?>" alt="" /></div>
                                    <div class="message">
                                        <h6 class="title">Olivia</h6>
                                        <p class="desc">Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                                        <div class="time">35 minutes ago</div>
                                    </div>
                                    <div class="option read" data-toggle="tooltip" data-title="Mark as Unread" data-click="set-message-status" data-status="read" data-container="body">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-item">
                                <a href="javascript:;">
                                    <div class="media"><i class="fa fa-user-plus media-object"></i></div>
                                    <div class="message">
                                        <h6 class="title"> New User Registered</h6>
                                        <div class="time">1 hour ago</div>
                                    </div>
                                    <div class="option read" data-toggle="tooltip" data-title="Mark as Unread" data-click="set-message-status" data-status="read" data-container="body">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-item">
                                <a href="javascript:;">
                                    <div class="media bg-success"><i class="fa fa-credit-card"></i></div>
                                    <div class="message">
                                        <h6 class="title"> New Item Sold</h6>
                                        <div class="time">2 hour ago</div>
                                    </div>
                                    <div class="option read" data-toggle="tooltip" data-title="Mark as Read" data-click="set-message-status" data-status="read" data-container="body">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-footer text-center">
                                <a href="javascript:;">View more</a>
                            </li>
						</ul>
					</li>
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<span class="image"><img src="<?php echo file_check(@$this->admin_data->user_image); ?>" alt="" /></span>
							<span class="hidden-xs"><?php echo ucwords(@$this->admin_data->user_full_name); ?></span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu pull-right">
							<li><a href="<?php echo base_url("profile/form/".$this->user_id) ?>">Edit Profile</a></li>
							<!--<li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li>
							<li><a href="javascript:;">Calendar</a></li>-->
							<li><a href="javascript:;">Setting</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url('login/logout'); ?>">Log Out</a></li>
						</ul>
					</li>
					<!--<li>
						<a href="javascript:;" data-click="right-sidebar-toggled">
							<i class="fa fa-align-left"></i>
						</a>
					</li>-->
				</ul>
				<!-- end navbar-right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
        <?php $this->load->view('left'); ?>