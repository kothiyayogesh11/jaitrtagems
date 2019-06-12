<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header);
?>
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Activities Category</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add Activities Category<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('activities_category/process', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->id));
				?>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="title">Title <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="title" name="title" value="<?php echo @$rsEdit->title; ?>" placeholder="Enter name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="index">Index <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control" autocomplete="nope" type="text" value="<?php echo @$rsEdit->index; ?>" id="index" name="index" placeholder="i.e 1" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="description">Description <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                    		<textarea class="form-control" name="description" id="description" rows="3" placeholder="description"><?php echo @$rsEdit->description; ?></textarea>
                    	</div>
                    </div>
                    
                    <div class="form-group">
                    	<label class="col-form-label col-sm-3" for="image">Image <span class="text-danger">*</span></label>
                        <div class="custom-file col-sm-6">
                          	<input id="image" type="file" name="image" class="custom-file-input <?php echo @$rsEdit->image != "" ? "" : "required"; ?>">
                          	<label class="custom-file-label drag-uploadd" for="image">Choose file or drag file here</label>
                            
                    	</div>
                        <div class="col-sm-3">
                        	<?php 
							if(@$rsEdit->image != ""){
								echo '<img class="profile-img" src="'.file_check($rsEdit->image).'" />';
							}
							?>
                        </div>
					</div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Is Activity <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <div class="radio">
                                <label for="yes"><input type="radio" <?php echo (isset($rsEdit->is_activity) && $rsEdit->is_activity == 1 ? 'checked="checked"' : 'checked="checked"'); ?> name="is_activity"  value="1" id="yes"> Yes</label>
                            </div>
                            <div class="radio">
                                <label for="no"><input type="radio" <?php echo (@$rsEdit->is_activity != 1 ? 'checked="checked"' : ''); ?> name="is_activity" id="no" value="0"> No</label>
                            </div>
                        </div>
                    </div>
                    
                    <!--<div class="form-group mt-3">
                    	<label class="col-form-label col-sm-3" for="inputGroupFile02">City <span class="text-danger">*</span></label>
                        <div class="col-sm-6 custom-file">
                          <input id="inputGroupFile02" type="file"  multiple class="custom-file-input">
                          <label class="custom-file-label drag-uploadd" for="inputGroupFile02">Choose several files</label>
                    	</div>
                  	</div>-->
                    
                    
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
$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js').'"></script><script src="'.base_url('assets/plugins/drag-upload/dist/bs-custom-file-input.min.js').'"></script>
    <script src="'.base_url('assets/js/demo.min.js').'"></script>
    <script src="'.base_url('assets/js/apps.min.js').'"></script>';
$this->load->view('bottom',$assets_header); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
	bsCustomFileInput.init()
});
var code_error = true;
$(document).ready(function(e) {
	$("#country").selectpicker("render");
	$("#state").selectpicker("render");
	$("#city").selectpicker("render");
});
$(document).on("click","button[type=submit]",function(){
	var error_lable = true;
	$form = $(this).parents("form");
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