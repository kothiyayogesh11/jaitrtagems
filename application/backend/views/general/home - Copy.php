<?php //include(APPPATH.'views/top.php'); ?>
<?php
$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
$this->output->set_header('Pragma: no-cache');
$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

if($strMessage = $this->page->getMessage())
{
    echo $strMessage;
}

$strProfilePath	=	$this->page->getSetting("PROFILE_IMAGE_PATH");

?>

<table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
        <td align="center" style="font-size:15px;font-weight:bold">
        	<div class="header_message">Welcome, <?php echo $this->page->getSession("strFullName"); ?></div>
        </td>
    </tr>
    
    <tr>
        <td>
            
        </td>
    </tr>
</table>
<div id='calendar'></div>
<div class="modal fade" id="bookingDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style=" display: initial;" id="exampleModalLongTitle">Booking Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<h4>Loading...</h4>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-small" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php include(APPPATH.'views/bottom.php'); ?>

<script language="javascript">
	$(document).ready(function(e) {
        $('#calendar').fullCalendar({
			defaultDate: '<?php echo date('Y-m-d') ?>',
			editable: true,
			eventLimit: true,
			events: function(start, end, timezone, callback) {
				$.ajax({
					url: 'index.php?c=general&m=jdata',
					type:"POST",
					dataType: 'json',
					data: {
						start: start.unix(),
						end: end.unix()
					},
					success: function(doc) {
						callback(doc);
					}
				});
			},
			eventClick: function(event) {
				console.log(event);
				var eid = typeof event.id != 'undefined' ? event.id : '';
				var title = typeof event.title != 'undefined' ? event.title : '';
				open_details(eid,title);
			},
			eventRender: function(event, element) {
            	element.attr('data-toggle',"modal");
				element.attr('data-target',"#bookingDetails");
        	}
		});
		
    });
	
	function open_details(id,title){
		$.ajax({
			url: 'index.php?c=general&m=getbookinginformation',
			type:"POST",
			data:{'id':id},
			beforeSend: function(){$('#bookingDetails .modal-body').html('<h4>Loading...</h4>');$('#exampleModalLongTitle').text('Booking Details')},
			success: function(res) {
				$('#exampleModalLongTitle').text('Booking Details > '+title);
				$('#bookingDetails .modal-body').html(res);
				
			}
		});
	}
</script>
