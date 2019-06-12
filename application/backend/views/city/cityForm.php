<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header);
?>

<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">City</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add City<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('city/saveCity', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->city_id));
				?>
                	<div class="form-group">
                        <label class="col-form-label col-sm-3" for="slt_country">Country <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                			<select name="slt_country" id="slt_country" onchange="getStates(this)" class="form-control required selectpicker" autocomplete="false"  data-size="10" data-live-search="true" data-style="btn-default picker-btn" >
                        <?php echo $this->page->generateComboByTable("country_master","country_id","country_name","","order by country_name",$rsEdit->country_id,"Select Country"); ?>
                    		</select>
                    	</div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="slt_state">State <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                			<select class="form-control required selectpicker" name="slt_state" id="slt_state" autocomplete="false"  data-size="10" data-live-search="true" data-style="btn-default picker-btn" >
                        <?php //echo $this->page->generateComboByTable("country_master","country_id","country_name","","order by country_name",$rsEdit->country_id,"Select Country"); ?>
                    		</select>
                    	</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_city_name">City Name <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="txt_city_name" name="txt_city_name" class="required form-control" placeholder="i.e California" value="<?php echo @$rsEdit->city_name; ?>" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_city_code">Code <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="txt_city_code" name="txt_city_code" placeholder="i.e AL" class="form-control required" value="<?php echo @$rsEdit->city_code; ?>" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="slt_status">Status <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <select id="slt_status" class="form-control selectpicker" name="slt_status" autocomplete="false"  data-size="10" data-live-search="true" data-style="btn-default picker-btn">
                                <?php echo $this->page->generateComboByTable("combo_master","combo_key","combo_value",0,"where combo_case='STATUS' order by seq",@$rsEdit->status,""); ?>
                            </select>
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
<?php 
$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js').'"></script><script src="'.base_url('assets/plugins/drag-upload/dist/bs-custom-file-input.min.js').'"></script><script src="'.base_url('assets/js/demo.min.js').'"></script><script src="'.base_url('assets/js/apps.min.js').'"></script>';
$this->load->view('bottom',$assets_header); ?>
<script>
var code_error = true;
document.addEventListener('DOMContentLoaded', function() {
	bsCustomFileInput.init()
});
$(document).ready(function(e) {
	$("#slt_country").selectpicker("render");
	$("#slt_state").selectpicker("render");
	$("#slt_status").selectpicker("render");
});
$(document).on("click","button[type=submit]",function(){
	var error_lable = true;
	$form = $(this).parents("form");
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
	if(!code_error){
		error_lable = false;
		$("#email").addClass("parsley-error");
	}else{
		$("#email").removeClass("parsley-error");
	}
	return error_lable && code_error;
});

function getStates(obj) {
	var fieldVal = $('#'+obj.id).val();
	$.ajax({
		cache: false,
		type:"POST",
		url:BASE_URL+"city/getStates",
		data:"fieldVal="+fieldVal+"&state_id="+<?php echo isset($rsEdit->state_id) ? $rsEdit->state_id : 'null';?>,
		success:function(res){
			if (res){
				$('#slt_state').empty();
				$('#slt_state').append(res);
				$("#slt_state").selectpicker("refresh");
			}

		}
	});
}
$( document ).ready(function() {
   if($("#hid_id").val() != ""){
		getStates(slt_country);
   }
});


</script>