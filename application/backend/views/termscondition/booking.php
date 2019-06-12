<?php 
	//if($blnAjax != 1):
	include(APPPATH.'views/top.php');
	//endif;
?>

<div class="page-header position-relative">
    <h1>Edit Terms Booking</h1>
    <?php  echo $this->Page->getMessage();   ?>
</div> 
<br />
<div class="row-fluid">
    <div class="span12">
    <form action="<?php echo site_url('c=termsandcondition&m=update_booking_terms'); ?>" method="post">
        <div><textarea name="editor1" id="editor1" rows="10" cols="80"><?php echo isset($terms_data[0]['terms']) ? $terms_data[0]['terms'] : ''; ?></textarea></div>
        <input type="hidden" name="terms_id" value="<?php echo isset($terms_data[0]['id']) ? $terms_data[0]['id'] : ''; ?>"
        <div><input type="submit" name="term_btn" class="btn btn-success" value="submit" /> </div>
    </form>
    </div>   
</div>
<?php //if($blnAjax != 1): ?>
    <?php include(APPPATH.'views/bottom.php'); ?>
    <?php //endif; ?>
<script type="text/javascript">
	var base_url = '<?php echo site_url(); ?>';
	CKEDITOR.replace( 'editor1' );
	
	$(document).on('click','input[name="term_btn"]',function(e){
		e.preventDefault();
		var form_url = $(this).parents('form').attr('action');
		var terms_data = CKEDITOR.instances.editor1.getData();
		var id = $('input[name="terms_id"]').val();
		$.ajax({
			type:'POST',
			url:form_url,
			data:{'val_text':terms_data,'id':id},
			dataType:"json",
			success: function(res){ 
				if(typeof res.id != 'undefined'){
					$('input[name="terms_id"]').val(res.id);
				}
			}
		});
	});
	
	
    $(document).ready(function() {
 		
    });
	
	
</script>
