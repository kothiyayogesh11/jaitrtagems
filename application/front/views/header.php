<!DOCTYPE html>
<html lang="en">
<head>
  <title>Jaitra Gems</title>
   <link rel="shortcut icon" href="<?php echo base_url('assets/front/images/diamond_PNG6677.png'); ?>" type="image/x-icon">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="" />
  <meta name="keywords" content="Daimond, Ring, Jewellery, daimond export import, jewellery import export" />
  <meta name="author" content="YK11.CLUB" />
  <script> 
  var base_url = '<?php echo base_url(); ?>';
  </script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900|Display+Playfair:200,300,400,700">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/fonts/icomoon/style.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/css/font-awesome.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/css/magnific-popup.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/css/jquery-ui.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/css/owl.carousel.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/css/owl.theme.default.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/css/bootstrap-datepicker.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/fonts/flaticon/font/flaticon.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/css/aos.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/front/css/style.css'); ?>">
  <?php echo isset($assets_header) ? $assets_header : ""; ?>
  
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="200">
<!-- <div class="site-wrap"> -->
<div class="site-mobile-menu site-navbar-target">
  <div class="site-mobile-menu-header">
    <div class="site-mobile-menu-close mt-3">
      <span class="icon-close2 js-menu-toggle"></span>
    </div>
  </div>
  <div class="site-mobile-menu-body"></div>
</div>
<header class="site-navbar py-3 js-site-navbar site-navbar-target" role="banner" id="site-navbar">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-10 col-xl-3">
        <h3 class="site-logo mb-0"><a href="index.html" class="text-white h2 mb-0"><span>J</span>aitra <span>G</span>ems</a></h3>
        <!-- <a><img class="site-logo" style="max-width: 250px;" src="<?php echo base_url('assets/front/images/pc_logo2.png'); ?>"></a> -->
      </div>
      <div class="col-12 col-md-9 d-none d-xl-block">
        <nav class="site-navigation position-relative text-right" role="navigation">
          <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
            <li><a href="<?php echo base_url("home"); ?>#section-home" class="nav-link">Home</a></li>
            <li><a href="<?php echo base_url("home"); ?>#section-about" class="nav-link">About Us</a></li>
            <li><a href="<?php echo base_url("store"); ?>" class="nav-link">Store</a></li>
            <?php if($this->user_id == ""){ ?>
            <li><a href="<?php echo base_url("home"); ?>#section-account" class="nav-link">My Account</a></li>
            <?php }else{ ?>
            <!-- <li><a href="<?php echo base_url("home"); ?>#section-activity" class="nav-link">Book Activity</a></li> -->
            <li><a href="<?php echo base_url("account"); ?>" class="nav-link">My Account</a></li>
            <li><a href="<?php echo base_url("login/logout"); ?>" class="nav-link">Log out</a></li>
            <?php } ?>
            <li><a href="<?php echo base_url("home"); ?>#section-contact" class="nav-link">Contact</a></li>
            <?php
            if($this->user_id != ""){
              echo '<li><a href="'.base_url("profile").'" class=""><span><i class="fa fa-user fa-lg"></i></span></a></li>';
            }
            ?>
            <li><a href="" class=""><span><i class="fa fa-twitter fa-lg"></i></span></a></li>
            
            <li><a href="https://www.facebook.com/" class=""><span><i class="fa fa-facebook-square fa-lg"></i></span></a></li>
            <!-- <li><a href="#" class="active"><span><i class="fa fa-twitter-square"></i></span></a></li> -->
            <li><a href="https://instagram.com/" class=""><span><i class="fa fa-instagram fa-lg"></i></span></a></li>
          </ul>
        </nav>
      </div>
      <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative;"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu h3"></span></a></div>
    </div>
  </div>
  </div>
</header>