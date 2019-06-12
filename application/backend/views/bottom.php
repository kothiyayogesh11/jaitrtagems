<!-- begin #footer -->
    <div id="footer" class="footer">
        <span class="pull-right">
            <a href="javascript:;" class="btn-scroll-to-top" data-click="scroll-top">
                <i class="fa fa-arrow-up"></i> <span class="hidden-xs">Back to Top</span>
            </a>
        </span>
        &copy; <?php echo date("Y"); ?> <b>Pet App Admin</b> All Right Reserved
    </div>
    <!-- end #footer -->
</div>
<!-- end #content -->
		<!-- begin #sidebar-right -->


		<!-- end #sidebar-right -->
	</div>
	<!-- end page container -->
	
    <!-- begin theme-panel -->

    <!-- end theme-panel -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url('assets/plugins/jquery/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap/bootstrap-4.1.1/js/bootstrap.bundle.min.js'); ?>"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo base_url('assets/crossbrowserjs/html5shiv.js'); ?>"></script>
		<script src="<?php echo base_url('assets/crossbrowserjs/respond.min.js'); ?>"></script>
	<![endif]-->
	<script src="<?php echo base_url('assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jquery-cookie/jquery.cookie.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <?php echo isset($js) ? $js : ""; ?>
	<!-- ================== END PAGE LEVEL JS ================== -->
    
	<script>
		$(document).ready(function() {
			
		    App.init();
		    Demo.init();
			if(typeof PageDemo !== 'undefined')
		    PageDemo.init();
			
			$(document).on("change","input[name=record_all]",function(){
				var $obj = $(this);
				$("input[name='record[]'").prop("checked",$obj.is(":checked"));
			});
		});
	</script>
<script>
/*
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-53034621-1', 'auto');
ga('send', 'pageview');
*/
</script>
</body>

<!-- Mirrored from seantheme.com/source-admin-v1.5/admin/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 Dec 2018 09:12:44 GMT -->
</html>