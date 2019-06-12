<?php if($blnAjax != 1): ?>
<?php include(APPPATH.'views/top.php'); ?>
<?php endif; ?>
<?php
$attributes = array('id' => 'frm_list_record', 'name'=>'frm_list_record');
echo form_open_multipart('c=aheg&m=event_add', $attributes); 
?>

<div class="page-header position-relative">
    <h1>Customer List</h1>
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
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Passport No</th>
                    <th>Nationality</th>
                    <th>Married</th>
                    <th>City</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
				if(count($rsCustomers)==0)
                {
                    echo "<tr>";
                    echo '<td colspan="10" style="text-align:center;">No data found.</td>';
                    echo "</tr>";
                }
                else
                {
                    foreach($rsCustomers as $arrRecord)
                    {
                        $strEditLink	=	"index.php?c=customer&m=AddCustomer&action=E&id=".$arrRecord['id'];
                        echo '<tr>';
						echo '<td><input type="checkbox" name="chk_lst_list1[]" id="chk_lst_'.$arrRecord['id'].'" value="'.$arrRecord['id'].'" /><span class="lbl"></span></td>';
                        echo '<td width="20" class="action-buttons" nowrap="nowrap">';
						echo '<a href="'.$strEditLink.'" class="green" title="Edit"><i class="icon-pencil bigger-130"></i></a>';
						echo '<td>'. $arrRecord['first_name'] .'</td>';
						echo '<td>'. $arrRecord['last_name'] .'</td>';
                        echo '<td>'. $arrRecord['email'] .'</td>';
                        echo '<td>'. $arrRecord['gender'] .'</td>';
						echo '<td>'. $arrRecord['dob'] .'</td>';
						echo '<td>'. $arrRecord['passport_id'] .'</td>';
                        echo '<td>'. $arrRecord['nationality'] .'</td>';
                        echo '<td>'. $arrRecord['marital_status'] .'</td>';

                        $query = $this->db->get_where('city_master', array('city_id' => $arrRecord['city']), 1);
                        $row = $query->row();

                        echo '<td>'. $row->city_name .'</td>';
                        echo '<td>'. $arrRecord['status'] .'</td>';
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

$(document).ready(function() {

<?php if(count($rsCustomers)> 0): ?>
var oTable1 =	$('#pagelist_center').dataTable( {
					"aoColumns": [{"bSortable": false}, {"bSortable": false},null, null, null, null,null, null, null, null, null, null,],
					"iDisplayLength": 25,
				});
<?php endif; ?>

});	

function openAddPage()
{
    window.location.href = 'index.php?c=customer&m=addCustomer&action=A';
}

function DeleteRow()
{
	var intChecked = $("input[name='chk_lst_list1[]']:checked").length;
	if(intChecked == 0)
	{
		alert("No customer selected.");
		return false;
	}
	else
	{
		var responce = confirm("Do you want to delete selected record(s)?");
		if(responce==true)
		{
			$('#frm_list_record').attr('action','index.php?c=customer&m=delete');
			$('#frm_list_record').submit()	
		}
	}
}
</script>
