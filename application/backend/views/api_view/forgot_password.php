<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Pets APP - Change Password</title>
        <link href="<?php echo base_url('assets/plugins/bootstrap/bootstrap-4.1.1/css/bootstrap.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/plugins/font-awesome/5.1/css/all.css'); ?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/animate.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/style.min.css'); ?>" rel="stylesheet" />
        <script src="<?php echo base_url('assets/plugins/jquery/jquery-3.3.1.min.js'); ?>"></script>
        <style>.fade{opacity:1 !impo}.fade:not(.show) {
    opacity: 1;
}</style>
    </head>
    <body class="bg-dark">
        <div class="container">
            <div class="card card-login mx-auto mt-5">
            	<div class="card-header">Reset Password</div>
                <div class="card-body">
                	<?php if(!empty($user)){ ?>
                    <form action="<?php echo base_url('forgot_password/process'); ?>" method="post">
                    	<input type="hidden" name="otp" value="<?php echo @$otp ?>" />
                        <input type="hidden" name="u_type" value="<?php echo @$u_type; ?>" />
                        <div class="form-group"><input class="form-control required" type="password" name="password" placeholder="Enter new password"></div>
                        <div class="form-group"><input class="form-control required" type="password" name="cpassword" placeholder="Enter confirm password"></div>
                    	<button class="btn btn-primary btn-block" type="submit">Reset Password</button>
                    </form>
                    <?php }else{ ?>
                    	<div><?php echo @$msg; ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>        
        <script src="<?php echo base_url('assets/plugins/bootstrap/bootstrap-4.1.1/js/bootstrap.bundle.min.js'); ?>"></script>
        <script>
			$(document).on('click','button[type="submit"]',function(){
				var error_flag = true;
				$(this).parents('form').find('.required').each(function(index, element) {
                    if($.trim($(element).val()) == ''){
						error_flag = false;
						$(element).addClass('parsley-error');
					}else{
						$(element).removeClass('parsley-error');
					}
                });
				if(($('input[name="password"]').val() == '' && $('input[name="cpassword"]').val() == '') || $('input[name="password"]').val() != $('input[name="cpassword"]').val()){
					error_flag = false;
					$('input[name="password"]').addClass('parsley-error');
					$('input[name="cpassword"]').addClass('parsley-error');
				}else{
					$('input[name="password"]').removeClass('parsley-error');
					$('input[name="cpassword"]').removeClass('parsley-error');
				}
				return error_flag;
			});
		</script>
    </body>
</html>