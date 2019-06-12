<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css').'" rel="stylesheet" />
	<link href="'.base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header);
?>
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Slots </a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add Slots<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <!--<div id="geomap"></div>-->
                <?php
				//pre($rsEdit);
				
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('slot/process', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->id));
				?>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="title">Activity <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                           	<select id="activity_id" class="form-control required selectpicker" autocomplete="false" name="activity_id" data-size="10" data-live-search="true" data-style="btn-default picker-btn">
                            	<?php
									echo $this->page->generateComboByTable($this->slot->tbl_activities,"id","title","","WHERE delete_flag = 0 ORDER BY `index` ASC",@$rsEdit->activity_id,"Select Category");
								?>
                            </select>
                        </div>
                    </div>
				
                  
                     <div class="form-group">
                        <label class="col-form-label col-sm-3" for="url">Date <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" autocomplete="nope" type="text"  value="<?php echo @$rsEdit->date; ?>" id="date" name="date" placeholder="<?php echo date('Y-m-d');?>" />
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-form-label col-sm-3" for="url">From Time <span class="text-danger">*</span></label>
                        <div class="col-sm-2">
                       	 <select id="fhours" class="form-control required selectpicker" autocomplete="false" name="fhours" data-live-search="true" data-size="10" data-style="btn-default picker-btn">
							
                           	<option value="">Hours</option>
                           	<?php for($h=0; $h <= 23 ; $h++){
								$sel = isset($fromTime[0]) && intval($fromTime[0]) == intval($h) ? 'selected="selected"' : '';
                            	echo '<option value="'.str_pad($h, 2, '0', STR_PAD_LEFT).'" '.$sel.'>'.str_pad($h, 2, '0', STR_PAD_LEFT).'</option>';    
                           	}?>
                        	</select>
                        </div>
                        
                        <div class="col-sm-2">
                        		<select id="fminutes" class="form-control required selectpicker" autocomplete="false" name="fminutes" data-live-search="true" data-size="10" data-style="btn-default picker-btn">
                                   <option value="">Minutes</option>
                                   <?php for($m=0; $m <= 59 ; $m++){
									   $sel = isset($fromTime[1]) && intval($fromTime[1]) == intval($m) ? 'selected="selected"' : '';
                                       echo '<option value="'.str_pad($m, 2, '0', STR_PAD_LEFT).'" '.$sel.'>'.str_pad($m, 2, '0', STR_PAD_LEFT).'</option>';	
                                   }?>
                              </select>
                        </div>
                         <div class="col-sm-2">
                         	<select id="fseconds" class="form-control required selectpicker" autocomplete="false" name="fseconds" data-live-search="true" data-size="10" data-style="btn-default picker-btn">
                                   <option value="">Seconds</option>
							<?php for($s=0; $s <= 59 ; $s++){
										$sel = isset($fromTime[2]) && intval($fromTime[2]) == intval($s) ? 'selected="selected"' : '';
                                        echo '<option value="'.str_pad($s, 2, '0', STR_PAD_LEFT).'" '.$sel.'>'.str_pad($s, 2, '0', STR_PAD_LEFT).'</option>';	
                                   }?>
                              </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="url">To Time <span class="text-danger">*</span></label>
                        <div class="col-sm-2">
							<select id="thours" class="form-control required selectpicker" autocomplete="false" name="thours" data-live-search="true" data-size="10" data-style="btn-default picker-btn">
                            	<option value="">Hours</option>
								<?php for($h=0; $h <= 23 ; $h++){
								$sel = isset($toTime[0]) && intval($toTime[0]) == intval($h) ? 'selected="selected"' : '';
                                echo '<option value="'.str_pad($h, 2, '0', STR_PAD_LEFT).'" '.$sel.'>'.str_pad($h, 2, '0', STR_PAD_LEFT).'</option>';    
                                }?>
                           	</select>
                        </div>
                        
                        <div class="col-sm-2">
                            <select id="tminutes" class="form-control required selectpicker" autocomplete="false" name="tminutes" data-live-search="true" data-size="10" data-style="btn-default picker-btn">
                               <option value="">Minutes</option>
                               <?php for($m=0; $m <= 59 ; $m++){
								   	$sel = isset($toTime[1]) && intval($toTime[1]) == intval($m) ? 'selected="selected"' : '';
									echo '<option value="'.str_pad($m, 2, '0', STR_PAD_LEFT).'" '.$sel.'>'.str_pad($m, 2, '0', STR_PAD_LEFT).'</option>';	
                               }?>
                          </select>
                        </div>
                         <div class="col-sm-2">
                         	<select id="tseconds" class="form-control required selectpicker" autocomplete="false" name="tseconds" data-live-search="true" data-size="10" data-style="btn-default picker-btn">
                                <option value="">Seconds</option>
								<?php for($s=0; $s <= 59 ; $s++){
									$sel = isset($toTime[2]) && intval($toTime[2]) == intval($s) ? 'selected="selected"' : '';
									echo '<option value="'.str_pad($s, 2, '0', STR_PAD_LEFT).'" '.$sel.'>'.str_pad($s, 2, '0', STR_PAD_LEFT).'</option>';	
                                }?>
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
var media = [];
document.addEventListener('DOMContentLoaded', function() {
	bsCustomFileInput.init()
});
var code_error = true;

$(document).ready(function(e) {
	$("#category_id").selectpicker("render");
	$("#price_type").selectpicker("render");
	
	$("#date").datepicker({
		format: 'yyyy-mm-dd',
        todayHighlight: !0 ,
    })
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
</script>