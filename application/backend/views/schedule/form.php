<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css').'" rel="stylesheet" />
	<link href="'.base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header);
?>

<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Weekly Schedule</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add Weekly Schedule<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
			   
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('schedule/process', $attributes);
					$rsFromtime = isset($rsEdit->from_time) && $rsEdit->from_time != "" ? explode(":",$rsEdit->from_time) : array("","","");
					$rsTotime = isset($rsEdit->to_time) && $rsEdit->to_time != "" ? explode(":",$rsEdit->to_time) : array("","","");
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->id));
				?>
                    <?php
					if(isset($week)) echo form_input(array('type' => 'hidden','name' => 'week','id'=> 'week','value' => $week));

					if(isset($weekDates)){
						foreach($weekDates as $val){
							echo form_input(array('type' => 'hidden','name' => 'date[]','value' => $val));
							?>
                            <div class="form-group time">
                                <label class="col-form-label col-sm-3" for="fullname">Date : <?php echo date("D, d-M-Y",strtotime($val)); ?> <span class="text-danger">*</span></label>
                                <div class="col-sm-1">
                                    <?php
										
										$fhhdd[''] = "HH";
										for($i=0;$i<=23;$i++){
											$hh0 = str_pad($i,2,"0",STR_PAD_LEFT);
											$fhhdd[$hh0] = $hh0;
										}
										
										echo form_dropdown("fhh[]",$fhhdd,@$rsFromtime[0],array("class"=>"form-control selectpicker ftime_input_hh","autocomplete"=>"false","data-live-search"=>"true","data-size"=>"10","data-style"=>"btn-default picker-btn","data-date"=>$val));
									?>
                                </div>
                                <div class="col-sm-1 text-center">:</div>
                                <div class="col-sm-1">
                                    <?php
										$fmmdd[''] = "MM";
										for($i=0;$i<=59;$i++){
											$mm0 = str_pad($i,2,"0",STR_PAD_LEFT);
											$fmmdd[$mm0] = $mm0;
										}
										
										echo form_dropdown("fmm[]",$fmmdd,@$rsFromtime[1],array("class"=>"form-control selectpicker ftime_input_mm","autocomplete"=>"false","data-live-search"=>"true","data-size"=>"10","data-style"=>"btn-default picker-btn","data-date"=>$val));
									?>
                                </div>
                                <div class="col-sm-1 text-center">to</div>
                                <div class="col-sm-1">
                                    <?php
										$thhdd[''] = "HH";
										for($i=0;$i<=23;$i++){
											$hh0 = str_pad($i,2,"0",STR_PAD_LEFT);
											$thhdd[$hh0] = $hh0;
										}
										
										echo form_dropdown("thh[]",$thhdd,@$rsTotime[0],array("class"=>"form-control selectpicker ttime_input_hh","autocomplete"=>"false","data-live-search"=>"true","data-size"=>"10","data-style"=>"btn-default picker-btn","data-date"=>$val));
									?>
                                </div>
                                <div class="col-sm-1 text-center">:</div>
                                <div class="col-sm-1">
                                    <?php
										$tmmdd[''] = "MM";
										for($i=0;$i<=59;$i++){
											$mm0 = str_pad($i,2,"0",STR_PAD_LEFT);
											$tmmdd[$mm0] = $mm0;
										}
										
										echo form_dropdown("tmm[]",$tmmdd,@$rsTotime[1],array("class"=>"form-control selectpicker ttime_input_mm","autocomplete"=>"false","data-live-search"=>"true","data-size"=>"10","data-style"=>"btn-default picker-btn","data-date"=>$val));
									?>
                                </div>
                            </div>
                            
                            <?php
						}
					}
					?>
                    
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

$(document).ready(function(e) {
    $(".ftime_input_hh").selectpicker("render");
	$(".ftime_input_mm").selectpicker("render");
	$(".ttime_input_hh").selectpicker("render");
	$(".ttime_input_mm").selectpicker("render");
});


$(document).on("click","button[type=submit]",function(){
	var error_lable = true;
	var totalEl = 0;
	var nullEl = 0;
	$('select.ftime_input_hh').each(function(index, element) {
		totalEl++;
		var dateAttr = $(element).attr("data-date");
		var $fhh = $(element);
        var $fmm = $(".ftime_input_mm[data-date='"+dateAttr+"']");
		var $thh = $(".ttime_input_hh[data-date='"+dateAttr+"']");
		var $tmm = $(".ttime_input_mm[data-date='"+dateAttr+"']");
		if($fhh.val() != ""){
			$fhh.removeClass("parsley-error");
			if($fmm.val() == ""){
				error_lable = false;
				$fmm.addClass("parsley-error");
			}else{
				$fmm.removeClass("parsley-error");
			}
				
			if($thh.val() == ""){
				error_lable = false;
				$thh.addClass("parsley-error");
			}else{
				$thh.removeClass("parsley-error");
			}
			
			if($tmm.val() == ""){
				error_lable = false;
				$tmm.addClass("parsley-error");
			}else{
				$tmm.removeClass("parsley-error");
			}
			if($fhh.val() != "" && $thh.val() != ""){
				if(parseInt($fhh.val()) >= parseInt($thh.val())){
					error_lable = false;
					$fhh.addClass("parsley-error");
					$fmm.addClass("parsley-error");
					$thh.addClass("parsley-error");
					$tmm.addClass("parsley-error");
				}else{
					$fhh.removeClass("parsley-error");
					$fmm.removeClass("parsley-error");
					$thh.removeClass("parsley-error");
					$tmm.removeClass("parsley-error");
				}
			}
		}else{
			nullEl++;
		}
    });
	if(totalEl == nullEl){
		error_lable = false;
		$('.time').find('select').addClass('parsley-error');
	}
	return error_lable;
});
</script>