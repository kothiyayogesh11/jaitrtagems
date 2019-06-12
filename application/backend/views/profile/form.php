<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header);
?>

<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Client</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Update Profile<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('profile/process', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->user_id));
				?>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="name">User Name <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="name" name="name" value="<?php echo @$rsEdit->user_name; ?>" placeholder="Full name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="user_full_name">Full Name <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="user_full_name" name="user_full_name" value="<?php echo @$rsEdit->user_full_name; ?>" placeholder="Full name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="email">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" autocomplete="nope" type="email" value="<?php echo @$rsEdit->user_email; ?>" id="email" name="email" placeholder="i.e xyz@domain.com" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="password">Password <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" autocomplete="nope" type="password" value="<?php echo @$rsEdit->user_password; ?>" id="password" name="password" placeholder="i.e *******" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="mobile">Mobile <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="mobile" value="<?php echo @$rsEdit->user_phone; ?>" name="mobile" placeholder="i.e 0000000000" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Gender <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <div class="radio">
                                <label for="male"><input type="radio" name="gender" <?php echo @$rsEdit->gender != "Female" ? 'checked="checked"' : ''; ?>  value="Male" id="male"> Male</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="gender" <?php echo @$rsEdit->gender == "Female" ? 'checked="checked"' : ''; ?> id="female" value="Female"> Female</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                    	<label class="col-form-label col-sm-3" for="profile">Profile <span class="text-danger">*</span></label>
                        <div class="custom-file col-sm-6">
                          	<input id="profile" type="file" name="profile" class="custom-file-input">
                          	<label class="custom-file-label drag-uploadd" for="profile">Choose file or drag file here</label>
                    	</div>
                        <div class="col-sm-3">
						<?php if(@$rsEdit->user_image != "") echo '<img class="profile-img" src="'.file_check($rsEdit->user_image).'" />'; ?>
                        </div>
					</div>
                    <?php if($this->page->getSession("strUserType") != 1): ?>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="user_type">Parent User <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <select id="user_type" class="form-control required selectpicker" autocomplete="false" name="user_type" data-size="10" data-live-search="true" data-style="btn-default picker-btn">
                                <?php
                                	echo $this->page->generateComboByTable("user_master","user_id","user_full_name","","",@$rsEdit->parent_user_id," Select User");
								?>
                            </select>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    
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
	$("#user_type").selectpicker("render");
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

$(document).on("blur","#email",function(){
	$obj = $(this);
	var data_post = {};
	data_post.id = $("#hid_id").val();
	data_post.email = $obj.val();
	var email_test = (/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(data_post.email));
	if(data_post.email != "" && email_test){
		$.ajax({
			type:"POST",
			url:BASE_URL+"profile/type_check_email",
			data:data_post,
			dataType:"json",
			success: function(res){
				if(typeof res.error !== "undefined" && res.error == 1){
					code_error = false;
					alert(res.message);
					$("#email").addClass("parsley-error");
				}else{
					code_error = true;
					$("#email").removeClass("parsley-error");
				}
			}
		});
	}else if(data_post.email != "" && !email_test){
		code_error = false;
		alert("Enter valid email format!");
		$("#email").addClass("parsley-error");
	}else{
		code_error = false;
		$("#email").addClass("parsley-error");
	}
});

</script>