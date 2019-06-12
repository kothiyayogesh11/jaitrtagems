<?php

$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" />

	<link href="'.base_url('assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css').'" rel="stylesheet" />

	<link href="'.base_url('assets/plugins/DataTables/extensions/FixedHeader/css/fixedHeader.bootstrap.min.css').'" rel="stylesheet" />

	<link href="'.base_url('assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css').'" rel="stylesheet" />
	
	<link href="'.base_url('assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css').'" rel="stylesheet" /><link rel="stylesheet" type="text/css" href="'.base_url('assets/plugins/fancybox-master/dist/jquery.fancybox.min.css').'"> <link rel="stylesheet" type="text/css" href="'.base_url('assets/plugins/fancybox-master/src/css/core.css').'"> <link rel="stylesheet" type="text/css" href="'.base_url('assets/plugins/fancybox-master/src/css/thumbs.css').'">  <link rel="stylesheet" type="text/css" href="'.base_url('assets/plugins/fancybox-master/src/css/slideshow.css').'">';

$this->load->view('top',$assets_header); 

?>
<style>

td .fancybox-button{background: rgba(222, 216, 216, 0.6);display: inline-block; width: 120px; height: auto; margin: 5px !important;}

td .fancybox-button[css-attr="video"]{width: 220px;}

.tdname span{margin:0;padding:5px 0 0 0;}

.table-news-image{height:100px; width:100px; object-fit:cover; display:inline-block; padding:5px;}

.table-news-text{max-height:200px; overflow:auto;}

</style>

<div id="content" class="content">

<?php

$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', 'name' => 'frm_add',"method"=>"post");

echo form_open_multipart('pets/list_type', $attributes);

?>

			<!-- begin breadcrumb -->

			<ol class="breadcrumb pull-right">

				<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>

				<li class="breadcrumb-item"><a href="javascript:;">Partner Service</a></li>

				<li class="breadcrumb-item active"><a href="javascript:;">Type</a></li>

			</ol>

			<!-- end breadcrumb -->

			<!-- begin page-header -->

			<h1 class="page-header">Partner Services - List <!--<small>header small text goes here...</small>--></h1>

			<!-- end page-header -->

            <!-- begin nav-pills -->

			<p class="m-b-0">

                <a href="<?php echo base_url("partner/serviceform/".$partner_id); ?>" class="btn btn-white m-r-5"><i class="fa fa-fw m-r-10 pull-left f-s-18 fa-plus"></i> Add</a>

                <a href="javascript:;" onclick="DeleteRow();" class="btn btn-white m-r-5"><i class="fa fa-fw m-r-10 pull-left f-s-18 fa-trash-alt"></i> Delete</a>
                
                <a href="<?php echo base_url("partner"); ?>" class="btn btn-white m-r-5"><i class="fa fa-fw m-r-10 pull-left f-s-18"></i> Back to Partner</a>

            </p>

            <br />

            <!-- end nav-pills -->

			<!-- begin section-container -->

			<div class="section-container section-with-top-border">

                <!-- begin panel -->

                <div class="panel pagination-inverse clearfix m-b-0">

                	<span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>

                    <table id="data-table" data-order='[[1,"asc"]]' class="table table-bordered table-hover">

                        <thead>

                            <tr class="">

                                <th data-sorting="disabled"><input type="checkbox" name="record_all" value="" /></th>

 						  <th data-sorting="disabled"><a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"><i class="fa fa-plus"></i></a></th>
                                <th>Activity</th>

                                <th>Description</th>

                                <th>Price</th>

                            </tr>

                        </thead>

                        <tbody>

						<?php

                        if(isset($rsData) && !empty($rsData)){

						$i=0;

						$row = "";

                        foreach($rsData as $rec):

						if($i %2 == 0)$row = "odd";

						else $row = "even";

                        ?>
					<input type="hidden" id="partner_id" value="<?php echo $partner_id;?>">
                        
                        <tr class="<?php echo $row;?>" id="row_<?php echo $rec["id"]; ?>" data-val="<?php echo $rec["id"]; ?>" data-partner="<?php echo $partner_id;?>" data-activity="<?php echo $rec['activity_id']?>">
                        
                            <td><input type="checkbox" name="record[]" value="<?php echo $rec["id"]; ?>" /></td>
                            
                            <td><a href="javascript:;" class="view_media btn btn-xs btn-icon btn-circle btn-default"><i class="fa fa-plus"></i></a></td>					
                            <td>

                            	<img class="profile-img" src="<?php echo file_check($rec["activity_image"]); ?>" /> 

                                <a href="<?php echo base_url("partner/serviceform/".$partner_id."/".$rec["id"]) ?>"><?php echo $rec["activity_name"]; ?></a>

                            </td>
                           
                            <td><?php echo $rec["description"]; ?></td>

                            <td><?php echo $rec["price"]; ?></td>

                        </tr>

                        <?php

						$i++;

                        endforeach;

                        }else{

                            echo '<tr><td colspan="8">No data available</td></tr>';	

                        }

                        ?>

                        </tbody>

                    </table>

                </div>

                <!-- end panel -->

			</div>

			<!-- end section-container -->

<?php 

echo form_close();

$assets_footer['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script>

	<script src="'.base_url('assets/plugins/DataTables/media/js/jquery.dataTables.js').'"></script>

	<script src="'.base_url('assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js').'"></script>

	<script src="'.base_url('assets/plugins/DataTables/extensions/FixedHeader/js/dataTables.fixedHeader.min.js').'"></script>

	<script src="'.base_url('assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js').'"></script>
	
	<script src="'.base_url("assets/plugins/fancybox-master/dist/jquery.fancybox.min.js").'"> <script src="'.base_url("assets/plugins/fancybox-master/src/js/core.js").'"></script> </script> <script src="'.base_url("assets/plugins/fancybox-master/src/js/wheel.js").'"></script> <script src="'.base_url("assets/plugins/fancybox-master/src/js/slideshow.js").'"></script> <script src="'.base_url("assets/plugins/fancybox-master/src/js/thumbs.js").'"></script> <script src="'.base_url("assets/plugins/fancybox-master/src/js/media.js").'"></script>

    <script src="'.base_url('assets/js/page-table-manage-fixed-header.demo.min.js').'"></script>

    <script src="'.base_url('assets/js/demo.min.js').'"></script>

    <script src="'.base_url('assets/js/apps.min.js').'"></script>';

$this->load->view('bottom',$assets_footer); ?>

<script>

$(document).on('click','.view_media',function(){
	var news_id = $(this).parents('tr').attr('data-val');
	var partner_id = $(this).parents('tr').attr('data-partner');
	var activity_id = $(this).parents('tr').attr('data-activity');
	var $obj = $(this);
	var len = $('.media_'+news_id).length;
	if(len > 0){
		$('.media_'+news_id).hide(300,function(){
			$obj.find("i").removeClass("fa-minus");
			$obj.find("i").addClass("fa-plus");
			$('.media_'+news_id).remove();
		});
	}else{
		$tr = $(this).parents('tr');
		if(news_id != ''){
			$.ajax({
				type:"POST",
				url:BASE_URL+"partner/getMedia",
				data:{news_id:news_id,partner_id:partner_id,activity_id:activity_id},
				dataType:"json",
				beforeSend: function(){
					$(".view_media").find("i").not($obj.find("i")).removeClass("fa-minus").addClass("fa-plus");
					$('.newstr').remove();
				},
				success: function(res){
					$("#wait").css("display", "none");
					if(typeof res.error != 'undefined' && res.error == 0){
						$tr.after('<tr class="media_'+news_id+' newstr"><td colspan="12">'+res.view+'</td><tr>');
                        $(".fancybox-button").fancybox({openEffect	: 'none', closeEffect	: 'none'});
						$obj.find("i").addClass("fa-minus");
						$obj.find("i").removeClass("fa-plus");
					}else if(typeof res.error != 'undefined' && res.error == 1){
						alert(res.msg);
					}
				}
			});
		}
	}
});

function DeleteRow(){
	
	var partner_id = $('#partner_id').val();

	var intChecked = $("input[name='record[]']:checked").length;

	if(intChecked == 0){

		alert("No User selected.");

		return false;

	}else{

		var responce = confirm("Do you want to delete selected record(s)?");

		if(responce==true){

			$('#frm_add').attr('action',BASE_URL+'partner/service_delete'+partner_id);

			$('#frm_add').submit()	

		}

	}

}

</script>