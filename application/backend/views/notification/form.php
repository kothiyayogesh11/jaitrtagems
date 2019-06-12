<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css').'" rel="stylesheet" />
	<link href="'.base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css').'" rel="stylesheet" />';
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
				<li class="breadcrumb-item"><a href="javascript:;">Notification</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add Notification<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <!--<div id="geomap"></div>-->
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('notification/process', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->id));
				?>
                	<div class="form-group">
                        <label class="col-form-label col-sm-3" for="for">User <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                           	<?php
								$dd[""] = "Select user";
								if(!empty($user_list)){
									//$dd["all"] = "Select All";
									foreach($user_list as $val){
										$dd[$val["id"]] = ucwords($val["name"]);
									}
								}
								echo form_dropdown("for[]",$dd,@$rsUsers,array("id"=>"for","class"=>"form-control required selectpicker","multiple"=>"multiple","data-size"=>10,"data-live-search"=>"true","data-style"=>"btn-default picker-btn"));
							?>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="title">Title <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="title" name="title" value="<?php echo @$rsEdit->title; ?>" placeholder="Enter name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="content">Description <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                    		<textarea class="form-control required" name="content" id="content" rows="3" placeholder="description"><?php echo @$rsEdit->content; ?></textarea>
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
$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js').'"></script><script src="'.base_url('assets/plugins/drag-upload/dist/bs-custom-file-input.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js').'"></script><script src="'.base_url('assets/js/demo.min.js').'"></script><script src="'.base_url('assets/js/apps.min.js').'"></script>';
$this->load->view('bottom',$assets_header); ?>

<script>
var media = [];
document.addEventListener('DOMContentLoaded', function() {
	bsCustomFileInput.init()
});
var code_error = true;
$(document).ready(function(e) {
	$("#for").selectpicker("render");
});

/*$(document).on("change","#for",function(){
	$obj = $(this);
	if($obj.val().indexOf("all") >= 0){
		console.log($obj.val().indexOf("all"));
		$obj.find("option").each(function(index, element) {
            if($(element).attr("value") == "" || $(element).attr("value") == "all"){
				$(element).removeAttr("selected");
			}else if($(element).attr("value") != "" && $(element).attr("value") != "all"){
				$(element).attr("selected","selected");
			}
        });
		$("#for").selectpicker("refresh");
	}else{
		$obj.find("option[value='all']").removeAttr("selected");
	}
});*/

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