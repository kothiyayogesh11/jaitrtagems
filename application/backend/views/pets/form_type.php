<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header);
$this->load->view('left');
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
			<h1 class="page-header">Add Pets Type<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
			    <!--<h5 class="m-t-0">Parsley JS</h5>
			    <p class="m-b-15">
			        Parsley is a javascript form validation library. It helps you provide your users with feedback on their form submission before sending it to your server. It saves you bandwidth, server load and it saves time for your users.
			    </p>-->
                <!--<form class=""  data-parsley-validate="true" name="demo-form">-->
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('pets/type_process', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$id));
				?>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="fullname">Name <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="name" name="name" placeholder="Pets Full name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="fullname">Code <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control required" type="text" id="code" name="code" placeholder="i.e dog" />
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
$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script>
    <script src="'.base_url('assets/js/demo.min.js').'"></script>
    <script src="'.base_url('assets/js/apps.min.js').'"></script>';
$this->load->view('bottom',$assets_header); ?>
<script>
var code_error = true;
$(document).on("click","button[type=submit]",function(){
	var error_lable = true;
	$form = $(this).parents("form");
	$form.find(".required").each(function(index, element) {
        if($(element).val() == ""){
			error_lable = false;
			$(element).addClass("parsley-error");
		}else{
			$(element).removeClass("parsley-error");
		}
    });
	if(!code_error){
		error_lable = false;
		$("#code").addClass("parsley-error");
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
			url:BASE_URL+"pets/type_check_code",
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