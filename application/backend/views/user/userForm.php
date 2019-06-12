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
				<li class="breadcrumb-item"><a href="javascript:;">User</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add User<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <!--<div id="geomap"></div>-->
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('user/saveUser', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->user_id));
				?>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="slt_user_type">User Type <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                        	<select id="slt_user_type" class="form-control required selectpicker" autocomplete="false" name="slt_user_type" data-size="10" data-live-search="true" data-style="btn-default picker-btn">
                            	<?php echo $this->page->generateComboByTable("user_types","u_typ_id","u_typ_name","","",@$rsEdit->user_type,"Select Types"); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_user_full_name">Use Full Name <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="txt_user_full_name" autocomplete="nope" name="txt_user_full_name" class="form-control required" value="<?php echo @$rsEdit->user_full_name; ?>" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_user_name">User Name <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="txt_user_name" autocomplete="nope" name="txt_user_name" class="form-control required" value="<?php echo @$rsEdit->user_name; ?>" onblur="checkEmailAndUsername(this)"/>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_user_email">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                    		<input type="text" id="txt_user_email" autocomplete="nope" name="txt_user_email" class="form-control required" value="<?php echo @$rsEdit->user_email ?>"/>
                        </div>
					</div>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_user_phone">Phone <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                    		<input type="text" id="txt_user_phone" autocomplete="nope" name="txt_user_phone" class="form-control required" value="<?php echo @$rsEdit->user_phone; ?>" />
						</div>
					</div>
                    
                    <div class="form-group">  
						<?php 
                            $required="required";
                            $red='<span class="text-danger">*</span>';
                            if(isset($rsEdit->user_id) && $rsEdit->user_id != ""){
                                $required="";
                                $red="";	
                            }
                        ?>          	
                		<label class="col-form-label col-sm-3" for="txt_user_password">Password <?php echo @$red; ?></label>
                        <div class="col-sm-6">                	
                            <input type="password" id="txt_user_password" autocomplete="nope" name="txt_user_password"class="form-control <?php echo @$required; ?> " value="" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="slt_parent_user">Parent user <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input type="hidden" name="slt_parent_user_hidden" id="slt_parent_user_hidden">
                            <select id="slt_parent_user" class="form-control required selectpicker" autocomplete="false" name="slt_parent_user" data-size="10" data-live-search="true" data-style="btn-default picker-btn">
                                <?php if (@$rsEdit->user_id && @$rsEdit->user_id != NULL): ?>
                                    <?php echo $this->page->generateComboByTable("user_master","user_id","user_full_name","","where status='ACTIVE' AND user_id != $rsEdit->user_id",@$rsEdit->parent_user_id,""); ?>
                                <?php else: ?>
                                    <?php echo $this->page->generateComboByTable("user_master","user_id","user_full_name","","where status='ACTIVE'",@$rsEdit->parent_user_id,""); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="slt_status">Status <span class="text-danger">*</span></label>
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
$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js').'"></script><script src="'.base_url('assets/plugins/drag-upload/dist/bs-custom-file-input.min.js').'"></script><script src="'.base_url('assets/js/demo.min.js').'"></script><script src="'.base_url('assets/js/apps.min.js').'"></script>';
$this->load->view('bottom',$assets_header); ?>

<script>
var media = [];
document.addEventListener('DOMContentLoaded', function() {
	bsCustomFileInput.init()
});
var code_error = true;
$(document).ready(function(e) {
	$("#slt_user_type").selectpicker("render");
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

/*$(document).ready(function() {
        $('#slt_parent_user').editableSelect({effects: 'slide'})
    }).on('select.editable-select', function (e, el) {
        $('#slt_parent_user_hidden').val(el.val());
        $('#slt_parent_user').text(el.text);
    });
*/    function checkEmailAndUsername(obj) {
	    var field = obj.id;
        var fieldVal = $('#'+obj.id).val();
        $.ajax({
            type:"POST",
            url:"<?php echo base_url('user/checkEmailAndUsername'); ?>",
            data:"field="+field+"&fieldVal="+fieldVal+"&id="+<?php echo @$id != '' ? $id : 'null'; ?>,
            beforeSend:function(){
            },
            success:function(res){
                if (res == 'userExists'){
                    $('#'+obj.id+'_error')
                        .css('color', 'red')
                        .html("User already exists in database.");
                    $('#'+obj.id).addClass('border-red');
                    $('#'+obj.id).focus();
                }
                else if (res == 'emailExists'){
                    $('#'+obj.id+'_error')
                        .css('color', 'red')
                        .html("Email already exists in database.");
                    $('#'+obj.id).addClass('border-red');
                    $('#'+obj.id).focus();
                }
                else{
                    $('#'+obj.id+'_error').empty();
                    $('#'+obj.id).removeClass('border-red');
                }
            }
        });
    }

</script>