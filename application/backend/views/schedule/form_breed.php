<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header);
?>

<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Pets</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add Breed<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('pets/breed_process', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->id));
				?>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="name">Name <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="name" name="name" value="<?php echo @$rsEdit->name; ?>" placeholder="Name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="country">Pets Type <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <select id="pet_type" class="form-control required selectpicker" autocomplete="false" name="pet_type" data-size="10" data-live-search="true" data-style="btn-default picker-btn">
                                <?php
                                	echo $this->page->generateComboByTable($this->pets->tbl_pet_type,"id","name","","WHERE delete_flag = 0",@$rsEdit->pet_type,"Select Pets Type");
								?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="email">Code <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" autocomplete="nope" type="text" value="<?php echo @$rsEdit->code; ?>" id="code" name="code" placeholder="i.e unique code" />
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
	$("#pet_type").selectpicker("render");
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

$(document).on('keypress',"#code",function(e){
	var regex = new RegExp("^[a-zA-Z0-9-_]+$");
	console.log(e.which);
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
	console.log(str);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});

$(document).on("blur","#code",function(){
	$obj = $(this);
	var data_post = {};
	data_post.id = $("#hid_id").val();
	data_post.code = $obj.val();
	if(data_post.code != ""){
		$.ajax({
			type:"POST",
			url:BASE_URL+"pets/breed_check_code",
			data:data_post,
			dataType:"json",
			success: function(res){
				if(typeof res.error !== "undefined" && res.error == 1){
					code_error = false;
					alert(res.message);
					$("#code").addClass("parsley-error");
				}else{
					code_error = true;
					$("#code").removeClass("parsley-error");
				}
			}
		});
	}
});


</script>