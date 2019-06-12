<?php

$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" />

    <link href="'.base_url('assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css').'" rel="stylesheet" />';

$this->load->view('top',$assets_header); 

?>

<!-- begin #content -->

<div id="content" class="content">

    <!-- begin breadcrumb -->

    <ol class="breadcrumb pull-right">

        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>

        <li class="breadcrumb-item active">Dashboard</li>

    </ol>

    <!-- end breadcrumb -->

    <!-- begin page-header -->

    <h1 class="page-header">Dashboard</h1>

    <!-- end page-header -->

    

    <!-- begin row -->

    <div class="row">

        <!-- begin col-3 -->

        <div class="col-lg-3 col-sm-6">

            <!-- begin widget -->

            <div class="widget widget-stat bg-primary text-white">

                <div class="widget-stat-btn"><a href="#" data-click="widget-reload" data-type="user-count"><i class="fa fa-redo"></i></a></div>

                <div class="widget-stat-icon"><i class="fa fa-users"></i></div>

                <div class="widget-stat-info">

                    <div class="widget-stat-title"><i class="fa fa-user"></i> Total User</div>

                    <div class="widget-stat-number">Loading...</div>

                    <div class="widget-stat-text">Loading...</div>

                </div>

            </div>

            <!-- end widget -->

        </div>

        <!-- end col-3 -->

        <!-- begin col-3 -->

        <div class="col-lg-3 col-sm-6">

            <!-- begin widget -->

            <div class="widget widget-stat bg-success text-white">

                <div class="widget-stat-btn"><a href="#" data-click="widget-reload" data-type="pets-count"><i class="fa fa-redo"></i></a></div>

                <div class="widget-stat-icon"><i class="fa fa-dove"></i></div>

                <div class="widget-stat-info">

                    <div class="widget-stat-title"><i class="fa fa-dove"></i> Total Pets</div>

                    <div class="widget-stat-number">Loading...</div>

                    <div class="widget-stat-text">Loading...</div>

                </div>

            </div>

            <!-- end widget -->

        </div>

        <!-- end col-3 -->

        <!-- begin col-3 -->

        <div class="col-lg-3 col-sm-6">

            <!-- begin widget -->

            <div class="widget widget-stat bg-grey text-white">

                <div class="widget-stat-btn"><a href="#" data-click="widget-reload" data-type="order-count"><i class="fa fa-redo"></i></a></div>

                <div class="widget-stat-icon"><i class="fa fa-shopping-cart"></i></div>

                <div class="widget-stat-info">

                    <div class="widget-stat-title"><i class="fa fa-cart-plus"></i> Order</div>

                    <div class="widget-stat-number">Loading...</div>

                    <div class="widget-stat-text">Loading...</div>

                </div>

            </div>

            <!-- end widget -->

        </div>

        <!-- end col-3 -->

        <!-- begin col-3 -->

        <div class="col-lg-3 col-sm-6">

            <!-- begin widget -->

            <div class="widget widget-stat bg-inverse text-white">

                <div class="widget-stat-btn"><a href="#" data-click="widget-reload" data-type="pending-order-count"><i class="fa fa-redo"></i></a></div>

                <div class="widget-stat-icon"><i class="fa fa-shopping-cart"></i></div>

                <div class="widget-stat-info">

                    <div class="widget-stat-title"><i class="fa fa-shopping-cart"></i> Pending Order</div>

                    <div class="widget-stat-number">29</div>

                    <div class="widget-stat-text">(3 new transaction)</div>

                </div>

            </div>

            <!-- end widget -->

        </div>

        <!-- end col-3 -->

    </div>

    <!-- end row -->

<?php 

$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script>

	<script src="'.base_url('assets/plugins/sparkline/jquery.sparkline.min.js').'"></script>

	<script src="'.base_url('assets/plugins/flot/jquery.flot.min.js').'"></script>

	<script src="'.base_url('assets/plugins/flot/jquery.flot.time.min.js').'"></script>

	<script src="'.base_url('assets/plugins/flot/jquery.flot.resize.min.js').'"></script>

	<script src="'.base_url('assets/plugins/flot/jquery.flot.pie.min.js').'"></script>

	<script src="'.base_url('assets/plugins/flot/jquery.flot.stack.min.js').'"></script>

	<script src="'.base_url('assets/plugins/flot/jquery.flot.crosshair.min.js').'"></script>

	<script src="'.base_url('assets/plugins/flot/jquery.flot.categories.js').'"></script>

	<script src="'.base_url('assets/plugins/flot/CurvedLines/curvedLines.js').'"></script>

    <script src="'.base_url('assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js').'"></script>

    <script src="'.base_url('assets/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js').'"></script>

   <script src="'.base_url('assets/js/page-index.demo.js').'"></script>

    <script src="'.base_url('assets/js/demo.min.js').'"></script>

    <script src="'.base_url('assets/js/apps.min.js').'"></script>';

$this->load->view('bottom',$assets_header); ?>