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
				<li class="breadcrumb-item"><a href="javascript:;">News</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add News<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <!--<div id="geomap"></div>-->
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('news/process', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->id));
				?>
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
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="date">Date <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" autocomplete="nope" type="text" value="<?php echo @$rsEdit->date; ?>" id="date" name="date" placeholder="i.e YYYY-MM-DD" />
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="title" class="col-form-label col-sm-3">URL </label>
                        <input type="hidden" name="remove_news_url" value="">
						<div id="dynamic_field" class="col-sm-7"> 
                        	<div class="row">
                            	<div class="col-sm-10">
                                	<input type="text" name="news_url[]" class="form-control links" value="" placeholder="News Url">
                                </div>
                                <div class="col-sm-2">
                                   <button type="button" name="add" id="add" class="btn btn-success btn-small">Add More</button>
                                </div>
                           	</div>
                           	<?php
						   	if(isset($rsNewsUrl) && !empty($rsNewsUrl)){
								foreach($rsNewsUrl as $val){
							?>
                            
							<div class="dynamic-added" data-id="<?php echo $val["id"]; ?>"><br />
                            	<div class="row">
                            	<div class="col-sm-10">
                                	<input type="text" name="news_url_edit[<?php echo $val["id"]; ?>]" class="form-control links" value="<?php echo $val["url"]; ?>" placeholder="News Url">
                                </div>
                                <div class="col-sm-2">
                                   	<button type="button" name="remove_btn_url" class="btn btn-danger btn-small" style="margin-left:3px;">&times;</button>
                                </div>
                                </div>
                           	</div>
                            <?php 
								}
							}
						   	?>
                        </div>
                   	</div>
                    
                    <div class="form-group">
                        <label for="" class="col-form-label col-sm-3">Hyper links</label>
                        <input type="hidden" name="remove_hyper_data" value="">
                        <div id="hyper-holder" class="col-sm-7">
                            
                            <div id="dynamic_url"> 
                                 <div class="row">   
                                 	<div class="col-sm-10">      
                            			<input type="text" style="margin-bottom:2px;" name="title_link[]" value="" id="" class="form-control hyper-link" placeholder="i.e title">
                                        <input type="text" name="hyper[]" value="" id="" class="form-control hyper-link links" placeholder="i.e https://www.domain.com">
                                    </div>
                                    <div class="col-sm-2">
                                       <button type="button" name="add" id="add_hyper_ctr" class="btn btn-success btn-small">Add More</button>
                                    </div>
                                 </div>
                            </div>
                            <div class="hyper_more">
                            	<?php
								if(isset($rsHyper) && !empty($rsHyper)){
									foreach($rsHyper as $val){
								?>
                                	<div class="row" data-id="<?php echo $val['id']; ?>" style="margin-top:15px;">
                                    	<div class="col-sm-10">
                                        	<input type="text" style="margin-bottom:2px;" name="title_upd[<?php echo $val['id'] ?>]" value="<?php echo $val['title'] ?>" id="" class="form-control hyper-link" placeholder="i.e title">
                                        	<input type="text" name="hyper_upd[<?php echo $val['id'] ?>]" value="<?php echo $val['url'] ?>" id="" class="form-control hyper-link" placeholder="i.e https://www.domain.com">
                                        </div>
                                        <div class="col-sm-2">
                                        	<button type="button" name="remove" class="btn btn-danger remove_hyper" style="margin-left:3px;">&times;</button> 
                                        </div>
                                    </div>
                                <?php
										
									}
								}
								?>
                            </div>
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
$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js').'"></script><script src="'.base_url('assets/plugins/drag-upload/dist/bs-custom-file-input.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js').'"></script><script src="'.base_url('assets/js/demo.min.js').'"></script><script src="'.base_url('assets/js/apps.min.js').'"></script>';
$this->load->view('bottom',$assets_header); ?>

<script>
var media = [];
var hyper_remove = [];
var link_remove = [];
document.addEventListener('DOMContentLoaded', function() {
	bsCustomFileInput.init()
});
var code_error = true;
$(document).ready(function(e) {
	$("#date").datepicker({	format: 'yyyy-mm-dd',  todayHighlight: !0 ,})
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
	
	$form.find(".links").each(function(index, element) {
        if((element.name == 'news_url[]' || element.name == 'hyper[]') && ($(element).val() != '') && (!re.test($(element).val()))){
			$(element).addClass('parsley-error');
			error_lable = false;
		}else{
			$(element).removeClass('parsley-error');
		}
    });
	
	//else if((element.name == 'news_url[]' || element.name == 'hyper[]') && ($(element).val() != '') && (!re.test($(element).val()))){
		
		
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

$(document).on("click","#add",function(){  
	var htm = '';
	htm += '<div class="dynamic-added"><br/>';
		htm += '<div class="row"><div class="col-sm-10"><input type="text" name="news_url[]" class="form-control links" value="" placeholder="News Url"/></div>';				
		htm += '<div class="col-sm-2"><button type="button" name="remove_btn_url" class="btn btn-danger btn-small" style="margin-left:3px;">&times;</button></div>';
		htm += '</div></div>';
	$('#dynamic_field').append(htm);
   
});

$(document).on("click","button[name='remove_btn_url']",function(){
	var $obj = $(this);
	var $pr = $obj.parents(".dynamic-added");
	var id = $pr.attr("data-id");
	if(typeof id != "undefined" && id != ""){
		link_remove.push(id);
		var arrstr1 = link_remove.toString();
		$("input[name='remove_news_url']").val(arrstr1);
	}
	$pr.hide(500,function(){$pr.remove();});
});

$(document).on("click","#add_hyper_ctr",function(){
	var $el = '<div class="row" style="margin-top:15px;"><div class="col-sm-10"><input type="text" style="margin-bottom:2px;" name="title_link[]" value="" id="" class="form-control hyper-link required" placeholder="i.e title"><input type="text" name="hyper[]" value="" id="" class="form-control links hyper-link" placeholder="i.e https://www.domain.com"> </div><div class="col-sm-2"><button type="button" name="remove" class="btn btn-danger remove_hyper" style="margin-left:3px;">&times;</button> </div></div> ';
	$(".hyper_more").append($el);
});

$(document).on("click",".remove_hyper",function(){
	var $obj = $(this);
	var $pr = $obj.parents(".row");
	var id = $pr.attr("data-id");
	if(typeof id != "undefined" && id != ""){
		hyper_remove.push(id);
		var arrstr = hyper_remove.toString();
		$("input[name='remove_hyper_data']").val(arrstr);
	}
	$pr.hide(300,function(){$pr.remove()});
});

</script>