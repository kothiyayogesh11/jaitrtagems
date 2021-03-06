<?php include(APPPATH.'views/top.php');
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_customer', 'name' => 'frm_add_customer');
echo form_open_multipart('c=customer&m=saveCredit', $attributes);
?>
<div class="page-header position-relative">
    <h1>Add Credit</h1>
    <?php
		echo $strMessage;
	?>
</div>
<input type="hidden" name="action" value="<?php echo $strAction; ?>" id="action"/>
<input type="hidden" name="hid_id" value="<?php echo $id; ?>" id="hid_id" />
<input type="hidden" id="txt_counter" name="txt_counter" value="0" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />
<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Customer<span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_customer" id="slt_customer">
                        <?php echo $this->Page->generateComboByTable("customer_master","id","first_name","","where status='ACTIVE' order by first_name",$rsEdit->customer_id,"Select Customer"); ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Credit Amount</label>
                <div class="controls">
                    <input type="text" id="txt_amount" name="txt_amount" class="required span6 isnumber" value="<?php echo $rsEdit->credit_amount; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Allocation Date</label>
                <div class="controls">
                    <input type="text" readonly="readonly" id="txt_allocation_date" name="txt_allocation_date" class="required span6" value="<?php echo $rsEdit->allocated_on_date; ?>" />
                </div>
            </div>

            <div class="control-group non-printable">
                <div class="controls">
                    <input type="submit" class="btn btn-primary btn-small" value="Save" onclick="return submit_form(this.form);">
                    <input type="button" class="btn btn-primary btn-small" value="Cancel" onclick="window.history.back()" >
                </div>
            </div>

        </fieldset>
    </div>
</div>

<?php echo form_close(); ?>

<?php include(APPPATH.'views/bottom.php'); ?>

<script type="text/javascript">
    $(function() {
        $("#txt_allocation_date").datepicker({
            format: 'dd/mm/yyyy'
        });
    });
</script>