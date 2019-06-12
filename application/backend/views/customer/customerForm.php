<?php include(APPPATH.'views/top.php');
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_customer', 'name' => 'frm_add_customer');
echo form_open_multipart('c=customer&m=saveCustomer', $attributes);
?>
<style type="text/css">
input[type=checkbox], input[type=radio] { opacity: 1; position: inherit;}
</style>
<div class="page-header position-relative">
    <h1>Add Customer</h1>
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
                <label for="form-field-1" class="control-label">First Name<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_first_name" name="txt_first_name" class="required span6" value="<?php echo $rsEdit->first_name; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Middle Name<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_middle_name" name="txt_middle_name" class="required span6" value="<?php echo $rsEdit->middle_name; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Last Name<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_last_name" name="txt_last_name" class="required span6" value="<?php echo $rsEdit->last_name; ?>" />
                </div>
            </div>


            <div class="control-group">
                <label for="form-field-1" class="control-label">Mobile No <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_mobile_no" name="txt_mobile_no" class="required span6" value="<?php echo $rsEdit->mobile_no; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Email<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_email" name="txt_email" class="span6 required isemail" value="<?php echo $rsEdit->email ?>" onblur="checkEmail(this)"/>
                    &nbsp; <span id="txt_email_error"></span>
                </div>
            </div>

            <div class="control-group">
            		<?php 
						$required="required";
						$red="<span class='red'>*</span>";
						if($strAction == "E"){
							$required="";
							$red="";	
						}
					?>          	
                <label for="form-field-1" class="control-label">Password <?php echo $red; ?></label>
                
                <div class="controls">                	
                    <input type="password" id="txt_password" name="txt_password"class="span6 <?php echo $required; ?> " value="" />
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Gender<span class="red">*</span></label>
                <div class="controls">
                    <?php echo $this->Page->generateCombo('slt_gender',array('M' => 'Male','F' => 'Female','O' => 'Other'),"class=required span6",$rsEdit->gender);?>
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Image</label>
                <div class="controls">
                    <input type="file" name="userfile" id="userfile" size="20" /><label for="image_error"><?php echo $error;?></label>
                    <?php if (isset($rsEdit->image) && $rsEdit->image != null): ?>
                        <img width="150px" height="150px" src="<?php echo $rsEdit->image; ?>">
                        <a href="#" class="delete_file_link" data-file_id="<?php echo $file->id?>">Delete</a>
                    <?php endif;?>
                    <!--<input type="text" id="txt_iamge" name="txt_iamge" class="span6" value="<?php /*echo $rsEdit->image */?>"/>-->
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Date of birth </label>
                <div class="controls">
                    <input type="text" readonly="readonly" id="txt_dob" name="txt_dob" class="span6" value="<?php echo $rsEdit->dob; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Passport No </label>
                <div class="controls">
                    <input type="text" id="txt_passport_id" name="txt_passport_id" class="span6" value="<?php echo $rsEdit->passport_id; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Nationality </label>
                <div class="controls">
                    <input type="text" id="txt_nationality" name="txt_nationality" class="span6" value="<?php echo $rsEdit->nationality; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Married<span class="red">*</span></label>
                <div class="controls">
                    <?php echo $this->Page->generateCombo('slt_marital_status',array('Y' => 'Yes','N' => 'No'),"class=required span6",$rsEdit->marital_status)?>
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Address Line 1 <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_address1" name="txt_address1" class="required span6" value="<?php echo $rsEdit->address1; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Address Line 2 </label>
                <div class="controls">
                    <input type="text" id="txt_address2" name="txt_address2" class="span6" value="<?php echo $rsEdit->address2; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">Country<span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_country" id="slt_country" onchange="getStates(this)">
                        <?php echo $this->Page->generateComboByTable("country_master","country_id","country_name","","where status='ACTIVE' order by country_name",$rsEdit->country,"Select Country"); ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label for="form-field-1" class="control-label">State<span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_state" id="slt_state" onchange="getCities(this)">
                        <option value="">Select State</option>
                        <?php //echo $this->Page->generateComboByTable("state_master","state_id","state_name","","order by state_name",$rsEdit->state_id,"Select State"); ?>
                    </select>
                </div>
            </div>

<!--            <div class="control-group">
                <label for="form-field-1" class="control-label">State <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_state" id="slt_state" >
                        <?php /*echo $this->Page->generateComboByTable("state_master","state_id","state_name","","where status='ACTIVE' order by state_name",$rsEdit->state,"Select Satate"); */?>
                    </select>
                </div>
            </div>
-->
            <div class="control-group">
                <label for="form-field-1" class="control-label">City<span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_city" id="slt_city" >
                        <option value="">Select City</option>
                        <?php //echo $this->Page->generateComboByTable("city_master","city_id","city_name","","where status='ACTIVE' order by city_name",$rsEdit->city,"Select City"); ?>
                    </select>
                </div>
            </div>

<!--            <div class="control-group">
                <label for="form-field-1" class="control-label">City <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_city" id="slt_city" >
                        <?php /*echo $this->Page->generateComboByTable("city_master","city_id","city_name","","where status='ACTIVE' order by city_name",$rsEdit->city,"Select City"); */?>
                    </select>
                </div>
            </div>-->
			<div class="control-group">
                <label for="form-field-1" class="control-label">Allow COD<span class="red">*</span></label>
                <div class="controls">
                	<input type="checkbox" <?php echo isset($rsEdit->allow_COD) && $rsEdit->allow_COD == 1 ? 'checked="checked"' : ''; ?> name="allow_cod" value="1" />
                </div>
            </div>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Status<span class="red">*</span></label>
                <div class="controls">
                	<select class="required span6" name="slt_status" id="slt_status" >
                        <?php echo $this->Page->generateComboByTable("combo_master","combo_key","combo_value",0,"where combo_case='STATUS' order by seq",$rsEdit->status,""); ?>
                    </select>
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
    function checkEmail(obj) {
	    var field = obj.id;
        var fieldVal = $('#'+obj.id).val();
        $.ajax({
            type:"POST",
            url:"index.php?c=customer&m=checkEmail",
            data:"field="+field+"&fieldVal="+fieldVal+"&id="+<?php echo $id ? $id : 'null'; ?>,
            beforeSend:function(){
            },
            success:function(res){
                if (res == 'emailExists'){
                    $('#'+obj.id+'_error')
                        .css('color', 'red')
                        .html("Email already exists in database.");
                    $('#'+obj.id).addClass('border-red');
                    $('#'+obj.id).focus();
                }
                else{
                    $('#'+obj.id+'_error').empty();
                    $('#'+obj.id).removeClass('border-red');
                }
            }
        });
    }

    function getStates(obj) {
        var fieldVal = $('#'+obj.id).val();
        $.ajax({
            type:"POST",
            url:"index.php?c=city&m=getStates",
            data:"fieldVal="+fieldVal+"&state_id="+<?php echo isset($rsEdit->state) ? $rsEdit->state : 'null';?>,
            success:function(res){
                if (res){
                    $('#slt_state').empty();
                    $('#slt_state').append(res);
                }
                <?php if($strAction == 'E'):?>
                    getCities(slt_state);
                <?php endif; ?>
            }
        });
    }

    function getCities(obj) {
        var fieldVal = $('#'+obj.id).val();
        $.ajax({
            type:"POST",
            url:"index.php?c=city&m=getCities",
            data:"fieldVal="+fieldVal+"&city_id="+<?php echo isset($rsEdit->city) ? $rsEdit->city : 'null';?>,
            success:function(res){
                if (res){
                    $('#slt_city').empty();
                    $('#slt_city').append(res);
                }

            }
        });
    }

    $( document ).ready(function() {
        <?php if($strAction == 'E'):?>
            getStates(slt_country);
            //getCities(slt_state);
        <?php endif;?>
        //$("#txt_dob").datepicker({ showOn: 'both'})
    });
    $(function() {
        $("#txt_dob").datepicker({
            format: 'dd/mm/yyyy'
        });
    });

    $('.delete_file_link').click( function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete image?'))
        {
            var file = "<?php echo isset($rsEdit->image) ? $rsEdit->image : ''; ?>";
            $.ajax({
                url:"index.php?c=customer&m=deleteImage",
                data:"filename="+file+"&id="+<?php echo isset($rsEdit->id) ? $rsEdit->id : 'null';?>,
                success		: function (data)
                {
                    location.reload();
                }
            });
        }
    });
</script>