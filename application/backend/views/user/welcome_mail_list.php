<?php if($blnAjax != 1): ?>
<?php include(APPPATH.'views/top.php'); ?>
<?php endif; ?>
<?php
$attributes = array('id' => 'frm_list_record', 'name'=>'frm_list_record');
echo form_open_multipart('c=aheg&m=event_add', $attributes); 
?>

<div class="page-header position-relative">
    <h1>User List</h1>
    <?php
    echo $this->Page->getMessage();
    ?>
</div>
<input type="hidden" id="action" name="action" value="<?php echo $strAction; ?>" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />


<br />
<div class="row-fluid">
    <div class="span12">
        <table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable" id="pagelist_center">
            <thead>
                <tr class="hdr">
                    
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>DOB</th>
                    <th>Message</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
				if(count($userList)==0)
                {
                    echo "<tr>";
                    echo '<td colspan="6" style="text-align:center;">No data found.</td>';
                    echo "</tr>";
                }
                else
                {
                    foreach($userList as $arrRecord)
                    {
                       
                        echo '<tr>';
						echo '<td>'. ucwords($arrRecord['first_name'] .' '.$arrRecord['middle_name'].' '.$arrRecord['last_name']).'</td>';
						echo '<td>'. $arrRecord['email'] .'</td>';
                        echo '<td>'. $arrRecord['mobile_no'] .'</td>';
                        echo '<td>'. $arrRecord['dob'] .'</td>';
						echo '<td>Failed to sent active link mail</td>';
						echo '<td class="act-status" data-val="'.$arrRecord['id'].'" ><a class=" btn btn-primary btn-small">ACTIVE</a></td>';														
                        echo '</tr>';
                    }
				}
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($blnAjax != 1): ?>
<?php include(APPPATH.'views/bottom.php'); ?>
<?php endif; ?>
<script type="text/javascript">
$(document).on('click','.act-status',function(){
	var id = $(this).data('val');
	var obj = $(this);
	if(id != ''){
		$.ajax({
			url:'?c=user&m=activeFauledMailCustomer',
			type:'POST',
			data:{'id':id},
			dataType:"json",
			success: function(res){	if(res.error == 0)$(obj).parents('tr').hide(1000,function(){$(this).remove()});	}
		});
	}
});
$(document).ready(function() {
<?php if(count($userList)> 0): ?>
var oTable1 = $('#pagelist_center').dataTable({"aoColumns": [null, null, null, null, null,null],"iDisplayLength":25,});
<?php endif; ?>

});
</script>
