<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css').'" rel="stylesheet" />
	<link href="'.base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header);
?>

<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">User</a></li>
				<li class="breadcrumb-item active">Type Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add User Type<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <!--<div id="geomap"></div>-->
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('user/saveUserTypes', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->u_typ_id));
				?>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_u_typ_name">User Type Name <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="txt_u_typ_name" name="txt_u_typ_name" class="form-control required" value="<?php echo @$rsEdit->u_typ_name; ?>" />
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_u_typ_name">User Type Code <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="txt_u_typ_code" name="txt_u_typ_code" class="form-control required" value="<?php echo @$rsEdit->u_typ_code; ?>" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_u_typ_name">User Type Description <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="txt_u_typ_desc" name="txt_u_typ_desc" class="form-control" value="<?php echo @$rsEdit->u_typ_desc ?>" />
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="title">User Type Status <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                           	<select id="slt_status" class="form-control required selectpicker" autocomplete="false" name="slt_status" data-size="10" data-live-search="true" data-style="btn-default picker-btn">
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
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtCb2Pn0IVPkyDrg0HHzRK98joxHgNgiA&callback=initialize" type="text/javascript"> console.log(google); </script>-->
<?php 
$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js').'"></script><script src="'.base_url('assets/plugins/drag-upload/dist/bs-custom-file-input.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js').'"></script><script src="'.base_url('assets/js/demo.min.js').'"></script><script src="'.base_url('assets/js/apps.min.js').'"></script>';
$this->load->view('bottom',$assets_header); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
	bsCustomFileInput.init()
});
var code_error = true;
$(document).ready(function(e) {
	$("#slt_status").selectpicker("render");
	$("#date").datepicker({	format: 'yyyy-mm-dd',  todayHighlight: !0})
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
	
	if(!code_error){
		error_lable = false;
		$("#email").addClass("parsley-error");
	}else{
		$("#email").removeClass("parsley-error");
	}
	return error_lable && code_error;
});
</script>