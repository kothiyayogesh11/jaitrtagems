<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" />';

$this->load->view('top',$assets_header);

?>
<style>
.remove-image-wp{display: inline-block; width: 40px; position: relative;}
.remove-image-wp label{color: #FFF; background: #000000cc; opacity: 0; position: absolute; top: 0; left: 0; text-align: center; width: 100%; height: 100%;   padding: 0%; border-radius: 50%; text-shadow: 1px 1px 1px #000; zoom: 1.5; cursor:pointer;}
.remove-image-wp label:hover{opacity: 0.8; border:2px solid #FFF;}
#geomap{ width: 100%; height: 400px;}
</style>
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Services</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add Service<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <!--<div id="geomap"></div>-->
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('package/subprocess', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->id));
				?>
                    <input type="hidden" name="partner_id" value="<?php echo $partner_id;?>">
                    
                     <div class="form-group">
                        <label class="col-form-label col-sm-3" for="training_type">Activity <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <select id="training_type" class="form-control required selectpicker" autocomplete="false" name="training_type" data-size="10" data-live-search="true" data-style="btn-default picker-btn">
                                <?php echo $this->page->generateComboByTable("activities","id","title","","WHERE delete_flag = 0",@$rsEdit->activity_id,"Select service");?>
                            </select>
                        </div>
                    </div>
                 
                     <div class="form-group">
                        <label class="col-form-label col-sm-3" for="description">Description <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" id="description" name="description" value="<?php echo @$rsEdit->description; ?>" placeholder="Enter Description" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="price">Price <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="price" name="price" value="<?php echo @$rsEdit->price; ?>" placeholder="Enter Price" />
                        </div>
                    </div>
                    
                    <div class="form-group m-b-0">
                        <label class="col-form-label col-sm-3"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success width-xs">Submit</button>
                            <button type="button" class="btn btn-success width-xs" onclick="window.history.go(-1);">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtCb2Pn0IVPkyDrg0HHzRK98joxHgNgiA&callback=initialize" type="text/javascript"> console.log(google); </script>-->
<?php 
$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js').'"></script><script src="'.base_url('assets/plugins/drag-upload/dist/bs-custom-file-input.min.js').'"></script><script src="'.base_url('assets/js/demo.min.js').'"></script><script src="'.base_url('assets/js/apps.min.js').'"></script>';

$this->load->view('bottom',$assets_header);  ?>

<script>
var media = [];
var hyper_remove = [];
var link_remove = [];
document.addEventListener('DOMContentLoaded', function() {
	bsCustomFileInput.init()
});
var code_error = true;
$(document).ready(function(e) {
	$("#date").datepicker({	format: 'yyyy-mm-dd',  todayHighlight: !0 ,})
});
$(document).on("click","button[type=submit]",function(){
	var error_lable = true;
	$form = $(this).parents("form");
	var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org|.us|.io|.co.in]+(\[\?%&=]*)?/;
	if($('.bootstrap-select.required').length > 0) $('.bootstrap-select.required').removeClass('required');
	$form.find(".required").each(function(index, element) {
        if($(element).val() == ""){
			error_lable = false;
			$(element).addClass("parsley-error");
		}else{
			if(element.name == 'email' && !(/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test($(element).val()))){
				$(element).addClass('parsley-error');
				error_lable = false;
			}else{
				$(element).removeClass('parsley-error');
			}
		}
    });
	
	$form.find(".links").each(function(index, element) {
        if((element.name == 'news_url[]' || element.name == 'hyper[]') && ($(element).val() != '') && (!re.test($(element).val()))){
			$(element).addClass('parsley-error');
			error_lable = false;
		}else{
			$(element).removeClass('parsley-error');
		}
    });
	
	//else if((element.name == 'news_url[]' || element.name == 'hyper[]') && ($(element).val() != '') && (!re.test($(element).val()))){
		
		
	if(!code_error){
		error_lable = false;
		$("#email").addClass("parsley-error");
	}else{
		$("#email").removeClass("parsley-error");
	}
	return error_lable && code_error;
});

$(document).on("click",".remove-image-wp label",function(){
	var $div = $(this).parents(".remove-image-wp");
	if($div.attr("data-id") != "undefined" && $div.attr("data-id") != ""){
		media.push($div.attr("data-id"));
		$div.hide(400,function(){$div.remove();});
		$("input[name='remove_media']").val(media.toString());
	}
});

$(document).on("click","#add",function(){  
	var htm = '';
	htm += '<div class="dynamic-added"><br/>';
		htm += '<div class="row"><div class="col-sm-10"><input type="text" name="news_url[]" class="form-control" value="" placeholder="Package time"/></div>';				
		htm += '<div class="col-sm-2"><button type="button" name="remove_btn_url" class="btn btn-danger btn-small" style="margin-left:3px;">&times;</button></div>';
		htm += '</div></div>';
	$('#dynamic_field').append(htm);
   
});

$(document).on("click","button[name='remove_btn_url']",function(){
	var $obj = $(this);
	var $pr = $obj.parents(".dynamic-added");
	var id = $pr.attr("data-id");
	if(typeof id != "undefined" && id != ""){
		link_remove.push(id);
		var arrstr1 = link_remove.toString();
		$("input[name='remove_news_url']").val(arrstr1);
	}
	$pr.hide(500,function(){$pr.remove();});
});



</script>