<?php 
$assets["header_assets"] = '<link rel="stylesheet" type="text/css" href="'.base_url('assets/plugins/fancybox-master/dist/jquery.fancybox.min.css').'"> <link rel="stylesheet" type="text/css" href="'.base_url('assets/plugins/fancybox-master/src/css/core.css').'"> <link rel="stylesheet" type="text/css" href="'.base_url('assets/plugins/fancybox-master/src/css/thumbs.css').'">  <link rel="stylesheet" type="text/css" href="'.base_url('assets/plugins/fancybox-master/src/css/slideshow.css').'">';
$this->load->view("header",$assets);
?>
	<!-- banner -->
	<!-- //banner -->
	<!-- special offers -->
	<div class="featured-section" id="projects">
		<div class="container">
			<h3 class="tittle-w3l">Book Activity
				<span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
			</h3>
			<!-- //tittle heading -->
            <?php
			if(!empty($activity_list)){
			?>
			<div class="activity-wrap">
				<?php
                foreach($activity_list as $val){
                ?>
                <div class="activity-holder">
                    <div class="row">                    
                        <div class="col-sm-2">
                            <a href="<?php base_url("activity/details") ?>">
                                <img class="activity-image-book " src="../<?php echo $val["image"]; ?>" alt="<?php echo $val["name"]; ?>">
                            </a>
                        </div>
                        <div class="col-sm-7">
                        	<div class="row">
                                <div class="col-sm-5">
                                    <h3 class="line-h-7x"><a href="<?php echo base_url("activity/details/".$val["activity_id"]) ?>"><?php echo ucwords($val["name"]); ?></a></h3>
                                </div>
                                <div class="col-sm-7"><span class="line-h-7x">$<?php echo $val["price"] ?> : <?php echo $val["rate_on"]; ?></span></div>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 line-h-7x">
	                        <button type="button" data-activity="<?php echo $val["activity_id"]; ?>" data-toggle="modal" data-target="#book-full-model" class="btn btn-primary theme-color book-activity-start">Book it</button>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <?php
			}
			?>
		</div>
	</div>
	<!-- //special offers -->
    <!-- Button trigger modal -->
    
    <!-- Modal -->
    <div class="modal fade full-width-model" id="book-full-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Add New Request</h4>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="book-order">Confirm</button>
        </div>
        </div>
    </div>
    </div>

    <?php 
    $assets["footer"] = '<script src="'.base_url('assets/plugins/fancybox-master/dist/jquery.fancybox.min.js').'"></script> <script src="'.base_url('assets/plugins/fancybox-master/src/js/core.js').'"></script> <script src="'.base_url('assets/plugins/fancybox-master/src/js/wheel.js').'"></script> <script src="'.base_url('assets/plugins/fancybox-master/src/js/slideshow.js').'"></script> <script src="'.base_url('assets/plugins/fancybox-master/src/js/thumbs.js').'"></script> <script src="'.base_url('assets/plugins/fancybox-master/src/js/media.js').'"></script>';
	$this->load->view("footer",$assets);
    ?>
    <script>
    
    $(document).on("click",".book-activity-start",function(e){
        var $obj = $(this);
        $obj.text("Loading...");
        var activity = $obj.attr("data-activity");
        loader.set("#book-full-model .modal-body");
        
        if(activity != ""){
            $.ajax({
                url:base_url+"home/get_activity_partner",
                type : "POST",
                data :{"activity" : activity},
                success : function(res){
                    $obj.text("Book it");
                    loader.remove();
                    $("#book-full-model").find(".modal-body").html(res);
                    $("#date").datepicker({autoclose: true, todayHighlight: true,format: 'yyyy-mm-dd'});
                }
            });
        }else{

        }  
    });

    $(document).on("change","input[name='date']",function(){
        $obj = $(this);
        var date = $obj.val();
        var partner_id = $("select[name='partner']").val();
        var activity = $("input[name='activity']").val();
        if(date != "" && partner_id != "" && activity != ""){
            $.ajax({
                type : "POST",
                url : base_url + "home/get_available_slot",
                data : {"activity":activity,"partner_id":partner_id,"date":date},
                dataType : "json",
                success : function(res){
                    if(typeof res.Result != "undefined" && res.Result == 1 && res.data != ""){
                        $("#slot_id").html(res.data);
                    }else{
                    }
                },
                error : function(err){

                }
            });
        }
    });

    $(document).on("click","#book-order",function(){
        $obj = $(this);
        var error_flag = false;
        $("#book-activity-form").find(".required").each(function(index,element){
            if($(element).val() == ""){
                $(element).addClass("error");
                error_flag = true;
            }else{
                $(element).removeClass("error");
            }
            console.log(error_flag);
        });

        if(!error_flag){
            //$(".book-form").submit();
            $.ajax({
                type : "POST",
                url : base_url+"activity/book",
                data : $("#book-activity-form").serialize(),
                dataType : "json",
                beforeSend : function(){
                    loader.set("body");
                    $obj.attr("disabled","disabled");
                },
                success : function(res){
                    $("#book-full-model").modal("hide");
                    loader.remove();
                    $obj.removeAttr("disabled");
                }
            })
        }
    });
    </script>