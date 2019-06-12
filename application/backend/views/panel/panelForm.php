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
			<h1 class="page-header">Add Panel<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('setting/savePanel', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->panel_id));
				?>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_panel_name">Panel Name <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="txt_panel_name" name="txt_panel_name" value="<?php echo @$rsEdit->panel_name; ?>" placeholder="Full name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_seq">Sequence <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" autocomplete="nope" type="text" value="<?php echo @$rsEdit->seq; ?>" id="txt_seq" name="txt_seq" placeholder="i.e 1" />
                        </div>
                    </div>
                    
                    
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="txt_img_url">Image Url <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required icp icp-auto" type="text" id="txt_img_url" value="<?php echo @$rsEdit->img_url; ?>" name="txt_img_url" placeholder="icon class" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="country">Status <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <select id="slt_status" class="form-control selectpicker" autocomplete="false" name="slt_status" data-size="10" data-live-search="true" data-style="btn-default">
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
$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js').'"></script><script type="text/javascript"></script><script src="'.base_url('assets/js/demo.min.js').'"></script><script src="'.base_url('assets/js/apps.min.js').'"></script>';
$this->load->view('bottom',$assets_header); ?>
<script>
var code_error = true;
$(document).ready(function(e) {
	$("#slt_status").selectpicker("render");
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