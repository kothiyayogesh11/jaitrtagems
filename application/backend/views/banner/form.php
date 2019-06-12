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
				<li class="breadcrumb-item"><a href="javascript:;">Bennars</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add Banner<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <!--<div id="geomap"></div>-->
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('banner/process', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->id));
				?>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="title">Title <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="title" name="title" value="<?php echo @$rsEdit->title; ?>" placeholder="Enter name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="url">URL </label>
                        <div class="col-sm-6">
                            <input class="form-control" autocomplete="nope" type="text" value="<?php echo @$rsEdit->url; ?>" id="url" name="url" placeholder="i.e https://www.domain.com" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="index">Index</label>
                        <div class="col-sm-6">
                            <input class="form-control" autocomplete="nope" type="text" value="<?php echo @$rsEdit->index; ?>" id="index" name="index" placeholder="i.e 1" />
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
                    
                    <div class="form-group mt-3">
                    	<label class="col-form-label col-sm-3" for="inputGroupFile02">Media </label>
                        <div class="col-sm-6 custom-file">
                          	<input id="inputGroupFile02" type="file" name="media[]"  multiple class="custom-file-input">
                          	<label class="custom-file-label drag-uploadd" for="inputGroupFile02">Choose file or drag file here</label>
                    	</div>
                        <div class="col-sm-3">
                        	<input type="hidden" name="remove_media" value="" />
                        	<?php 
							if(isset($rsMedia) && !empty($rsMedia)){
								foreach($rsMedia as $val){
									echo '<div data-id="'.$val["id"].'" class="remove-image-wp" style=""><img class="profile-img" src="'.file_check($val["file"]).'" /><label style="">&times;</label></div> ';
								}
							}
							?>
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
$this->load->view('bottom',$assets_header); ?>

<script>
var media = [];
document.addEventListener('DOMContentLoaded', function() {
	bsCustomFileInput.init()
});
var code_error = true;
$(document).ready(function(e) {
	$("#category_id").selectpicker("render");
	$("#price_type").selectpicker("render");
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

$(document).on("click",".remove-image-wp label",function(){
	var $div = $(this).parents(".remove-image-wp");
	if($div.attr("data-id") != "undefined" && $div.attr("data-id") != ""){
		media.push($div.attr("data-id"));
		$div.hide(400,function(){$div.remove();});
		$("input[name='remove_media']").val(media.toString());
	}
});

$(document).on('keypress',"#price",function(e){
	var regex = new RegExp("^[0-9.]+$");
	console.log(e.which);
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
	console.log(str);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});
</script>