<!DOCTYPE html>
<html lang="zxx"><head>
	<title>Pets Concierge :: <?php echo ucwords($this->router->class); ?></title>
	<!--/tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Pets web" />
	<script>
		addEventListener("load", function () {setTimeout(hideURLbar, 0);}, false);
		function hideURLbar() {	window.scrollTo(0, 1);}
	</script>
	<link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" media="all" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
	<!--pop-up-box-->
	<link href="<?php echo base_url('assets/css/popuo-box.css'); ?>" rel="stylesheet" type="text/css" media="all" />
	<!--//pop-up-box-->
	<!-- price range -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>">
	<!-- fonts -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
	<?php echo isset($header_assets) && !empty($header_assets) ? $header_assets : ""; ?>
    <script> var base_url = '<?php echo base_url(); ?>';</script>
</head>

<body>
	<!-- top-header -->
	<div class="header-most-top">
		<p>How May We Assist Today?</p>
	</div>
	<!-- //top-header -->
	<!-- header-bot-->
	<div class="header-bot">
		<div class="header-bot_inner_wthreeinfo_header_mid">
			<!-- header-bot-->
			<div class="col-md-3 logo_agile">
				<h1><a href="<?php echo base_url(); ?>"><img class="site-logo" src="<?php echo base_url('assets/images/pc_logo2.png'); ?>" alt=" "></a></h1>
			</div>
			<!-- header-bot -->
			<div class="col-md-8 header">
				<!-- header lists -->
				<ul>
					<li>
						<a class="play-icon popup-with-zoom-anim" href="#small-dialog1">
							<span class="fa fa-map-marker" aria-hidden="true"></span> Shop Locator</a>
					</li>
					<li>
						<a href="#" data-toggle="modal"><!-- data-target="#myModal1"-->
							<span class="fa fa-truck" aria-hidden="true"></span>Track Order</a>
					</li>
					<li>
						<span class="fa fa-phone" aria-hidden="true"></span> 001 234 5678
					</li>
					<li>
                    <?php
                        if($this->user_id != "") {
                            echo '<span class="fa fa-user-circle-o" aria-hidden="true"></span> '.$this->login_user["user_name"];
                        }else{
                            echo '<a href="#" data-toggle="modal" data-target="#myModal1"><span class="fa fa-unlock-alt" aria-hidden="true"></span> Sign In </a>';
                        }
                    ?>
					</li>
					<li>
                        <?php
                        if($this->user_id == "") {
                            echo '<a href="#" data-toggle="modal" data-target="#myModal2">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span> Sign Up </a>';
                        }else{
                            echo '<a href="'.base_url("login/logout").'"><span class="fa fa-sign-out" aria-hidden="true"></span> Log out</a>';
                        }
						?>
					</li>
				</ul>
				<!-- //header lists -->
				<!-- search -->
				<div class="agileits_search">
					<form action="#" method="post">
						<input name="Search" type="search" placeholder="How can we help you today?" required>
						<button type="submit" class="btn btn-default" aria-label="Left Align">
							<span class="fa fa-search" aria-hidden="true"> </span>
						</button>
					</form>
				</div>
				<!-- //search -->
				<!-- cart details -->
				<div class="top_nav_right">
					<div class="wthreecartaits wthreecartaits2 cart cart box_1">
						<form action="<?php echo base_url("order"); ?>" method="post" class="last">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="display" value="1">
							<button class="w3view-cart" type="submit" name="submit" value="">
								<i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
							</button>
						</form>
					</div>
				</div>
				<!-- //cart details -->
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<!-- shop locator (popup) -->
	<!-- Button trigger modal(shop-locator) -->
	<div id="small-dialog1" class="mfp-hide">
		<div class="select-city">
			<h3>Please Select Your Location</h3>
			<select class="list_of_cities">
				<optgroup label="California">
					<option>Los Angeles</option>
					<option>San Diego</option>
					<option>San Jose</option>
					<option>San Francisco</option>
					<option>Fresno</option>
				</optgroup>
				<optgroup label="Connecticut">
					<option>Bridgeport</option>
					<option>New Haven</option>
					<option>Hartford</option>
					<option>Stamford</option>
					<option>Waterbury</option>
				</optgroup>
				<optgroup label="Delaware">
					<option>Wilmington</option>
					<option>Dover</option>
					<option>Newark</option>
					<option>Bear</option>
					<option>Middletown</option>
				</optgroup>
			</select>
			<div class="clearfix"></div>
		</div>
	</div>
	<!-- //shop locator (popup) -->
	<!-- signin Model -->
	<!-- Modal1 -->
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body modal-body-sub_agile">
					<div class="main-mailposi">
						<span class="fa fa-envelope-o" aria-hidden="true"></span>
					</div>
					<div class="modal_body_left modal_body_left1">
						<h3 class="agileinfo_sign">Sign In </h3>
						<p>
							Sign In now, Let's start your Grocery Shopping. Don't have an account?
							<a href="#" data-toggle="modal" data-target="#myModal2">Sign Up Now</a>
						</p>
						<form action="<?php echo base_url("login"); ?>" id="pets-login" method="post">
							<div class="styled-input agile-styled-input-top">
								<input type="text" placeholder="User Name" class="required" name="email">
							</div>
							<div class="styled-input">
								<input type="password" placeholder="Password" class="required" name="password">
							</div>
                            <div class="styled-input">
                                <label>
                                    <input type="radio" value="customer" name="login_type" checked="checked"> Customer
                                </label>
                                <label>
                                     <input type="radio" value="partner" name="login_type" > Partner
                                </label>
                            </div>
							<input type="submit" value="Sign In">
						</form>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- //Modal content-->
		</div>
	</div>
	<!-- //Modal1 -->
	<!-- //signin Model -->
	<!-- signup Model -->
	<!-- Modal2 -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body modal-body-sub_agile">
					<div class="main-mailposi">
						<span class="fa fa-envelope-o" aria-hidden="true"></span>
					</div>
					<div class="modal_body_left modal_body_left1">
						<h3 class="agileinfo_sign">Sign Up</h3>
						<p>
							Come join the Grocery Shoppy! Let's set up your Account.
						</p>
						<form action="#" method="post">
							<div class="styled-input agile-styled-input-top">
								<input type="text" placeholder="Name" name="Name" required>
							</div>
							<div class="styled-input">
								<input type="email" placeholder="E-mail" name="Email" required>
							</div>
							<div class="styled-input">
								<input type="password" placeholder="Password" name="password" id="password1" required>
							</div>
							<div class="styled-input">
								<input type="password" placeholder="Confirm Password" name="Confirm Password" id="password2" required>
							</div>
							<input type="submit" value="Sign Up">
						</form>
						<p>
							<a href="#">By clicking register, I agree to your terms</a>
						</p>
					</div>
				</div>
			</div>
			<!-- //Modal content-->
		</div>
	</div>
	<!-- //Modal2 -->
	<!-- //signup Model -->
	<!-- //header-bot -->
	<!-- navigation -->
	<div class="ban-top">
		<div class="container">
			<div class="agileits-navi_search">
				<form action="#" method="post">
					<select id="agileinfo-nav_search" name="agileinfo_search" required="">
						<option value="">All Activitys</option>
						<option value="Kitchen">Dog Walking</option>
                        <option value="Kitchen">Drop- In Service</option>
                        <option value="Kitchen">Running</option>
					</select>
				</form>
			</div>
			<div class="top_nav_left">
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
							    aria-expanded="false">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse menu--shylock" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav menu__list">
								<li class="active">
									<a class="nav-stylehead" href="index.html">Home
										<span class="sr-only">(current)</span>
									</a>
								</li>
								<li class="">
									<a class="nav-stylehead" href="about.html">About Us</a>
								</li>
								<li class="">
									<a class="nav-stylehead" href="contact.html">Contact</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>
	<!-- //navigation -->