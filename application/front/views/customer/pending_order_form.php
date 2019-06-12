<div class="row mb-4">

    <div class="col-md-6">
        <h5 class="py-3">Request Details</h5>
    </div>

    <div class="col-md-6 text-right">
        <input type="button" name="edit_request" data-order="<?php echo $pending_order["order_id"]; ?>" value="Edit" class="btn btn-primary login-form-button  py-2 px-4 text-white text-center">
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">

        <div class="row form-group">
            <div class="col-md-6"><label class="bold600"><?php echo ucwords(@$pending_order["order_title"]); ?></label></div>
            <div class="col-md-6 bold600 text-right">$ <?php echo @$pending_order["order_price"]; ?></div>
        </div>

        <div class="row form-group">
            <div class="col-sm-12">
            <?php echo form_dropdown("edit_pets_id",$pets_list,@$pending_order["pet_id"],array("class"=>"form-control edit_err")); ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-12">
                <label class="bold600">Select Location</label>
                <div id="geomap_book_form"></div>
            </div>
        </div>

    </div>

    <div class="col-md-6 mb-3">
        <div class="row form-group">
            <div class="col-sm-12">
                <input type="text" readonly class="form-control pointer edit_err" name="edit_date" value="<?php echo $pending_order["order_date"]; ?>" />
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
                <input type="text" readonly class="form-control pointer edit_err" name="edit_from_time" value="<?php echo date("h i A",strtotime($pending_order["activity_from_time"])); ?>" />
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <input type="text" readonly class="form-control pointer edit_err" name="edit_to_time" value="<?php echo date("h i A",strtotime($pending_order["activity_to_time"])); ?>" />
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
                <input type="text" class="form-control edit_err" name="edit_address" value="<?php echo $pending_order["address"]; ?>" />
            </div>
        </div>

        <input type="hidden" name="edit_lat" value="<?php echo $pending_order["lat"]; ?>" />
        <input type="hidden" name="edit_long" value="<?php echo $pending_order["long"]; ?>" />


        <input type="hidden" name="edit_activity_id" value="<?php echo $pending_order["activity_id"]; ?>" />
        <input type="hidden" name="edit_service_type" value="<?php echo $pending_order["service_type"]; ?>" />
        
        <div class="row form-group">
            <div class="col-sm-12">
            <?php echo form_dropdown("edit_payment_id",$payment_list,@$pending_order["payment_id"],array("class"=>"form-control edit_err")); ?>
            </div>
        </div>
    </div>

    

    <!-- <div class="col-md-6 mb-3">
        
    </div> -->

    <div class="col-md-6 mb-3">
        
    </div>
</div>