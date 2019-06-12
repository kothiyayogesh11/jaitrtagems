<div class="col-sm-12">
    <div class="h4 mb-3 book-form-heading">Complate Booking</div>
</div>

<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-8">
            <select class="form-control" name="slot_service_type">
                <option value="">Select Service </option>    
                <option value="1">One-time </option>
                <option value="2">Recurring </option>
            </select>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-8">
            <?php echo form_dropdown("slot_pets",$pets_list,"",array("class"=>"form-control slot_err")); ?>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-8">
            <div id="geomap_book"></div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-8">
            <input type="text" name="slot_address" class="form-control slot_err" placeholder="Enter your address or pick on map" />
            <input type="hidden" name="slot_lat" />
            <input type="hidden" name="slot_long" />
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-8">
            <input type="text" readonly  name="slot_date" class="form-control partner_date pointer slot_err" placeholder="Select Available Slot" />
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-4">
            <input type="text" readonly  name="slot_from_time" class="form-control partner_time pointer slot_err" placeholder="Select from time" />
        </div>
        <div class="col-sm-4">
            <input type="text" readonly  name="slot_to_time" class="form-control partner_time pointer slot_err" placeholder="Select to time" />
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-8">
            <?php 
            echo form_dropdown("slot_payment_method",$payment_list,"",array("class"=>"form-control slot_err"));
            ?>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-8">
            <input type="button" value="Confirm" id="book_accelarate" class="btn btn-primary round-button-full py-2 px-4 text-white text-center active">
        </div>
    </div>
</div>