<?php if($blnAjax != 1): ?>
<?php include(APPPATH.'views/top.php'); ?>
<?php endif; ?>
<?php
$attributes = array('id' => 'frm_list_record', 'name'=>'frm_list_record');
echo form_open_multipart('c=aheg&m=event_add', $attributes); 
?>

<div class="page-header position-relative">
    <h1>Customer's Credit List</h1>
    <?php
    echo $this->Page->getMessage();
    ?>
</div>
<input type="hidden" id="action" name="action" value="<?php echo $strAction; ?>" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

<div class="row-fluid">
    <div class="span6 text-left">
        <button type="button" class="btn btn-small btn-success" onclick="return openAddPage();"> <i class="icon-plus-sign bigger-125"></i> Add </button>
        <button type="button" class="btn btn-small btn-danger" onclick="return DeleteRow();" name="btnDelete" id="btnDelete"> <i class="icon-trash bigger-125"></i> Delete </button>
    </div>
</div>

<br />
<div class="row-fluid">
    <div class="span12">
        <table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable" id="pagelist_center">
            <thead>
                <tr class="hdr">
                    <th width="20">
                    	<input type="checkbox" name="chkAll_list1" id="chkAll_list1" onchange="checkAll('list1');" />
                        <span class="lbl"></span>
                    </th>
                    <th></th>
                    <th>Customer Name</th>
                    <th>Credit Amount</th>
                    <th>Allocation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
				if(count($rsCredits)==0)
                {
                    echo "<tr>";
                    echo '<td colspan="10" style="text-align:center;">No data found.</td>';
                    echo "</tr>";
                }
                else
                {
                    foreach($rsCredits as $arrRecord)
                    {
                        $strEditLink	=	"index.php?c=customer&m=AddCustomerCredit&action=E&id=".$arrRecord['credit_id'];
                        echo '<tr>';
						echo '<td><input type="checkbox" name="chk_lst_list1[]" id="chk_lst_'.$arrRecord['credit_id'].'" value="'.$arrRecord['credit_id'].'" /><span class="lbl"></span></td>';
                        echo '<td width="20" class="action-buttons" nowrap="nowrap">';
						echo '<a href="'.$strEditLink.'" class="green" title="Edit"><i class="icon-pencil bigger-130"></i></a>';
						echo '<td>'. $arrRecord['customer_name'] .'</td>';
						echo '<td>'. $arrRecord['credit_amount'] .'</td>';
                        echo '<td>'. $arrRecord['allocated_on_date'] .'</td>';
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

$(document).ready(function() {

<?php if(count($rsCredits)> 0): ?>
var oTable1 =	$('#pagelist_center').dataTable( {
					"aoColumns": [{"bSortable": false}, {"bSortable": false}, null, null, null],
					"iDisplayLength": 25,
				});
<?php endif; ?>

});	

function openAddPage()
{
    window.location.href = 'index.php?c=customer&m=AddCustomerCredit&action=A';
}

function DeleteRow()
{
	var intChecked = $("input[name='chk_lst_list1[]']:checked").length;
	if(intChecked == 0)
	{
		alert("No credit selected.");
		return false;
	}
	else
	{
		var responce = confirm("Do you want to delete selected record(s)?");
		if(responce==true)
		{
			$('#frm_list_record').attr('action','index.php?c=customer&m=deleteCredits');
			$('#frm_list_record').submit()	
		}
	}
}
</script>
