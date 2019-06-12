<form class="form-horizontal" id="book-activity-form" action="<?php echo base_url("activity/book"); ?>" method="post">
    <input name="activity" type="hidden" value="<?php echo $activity_id ?>" />
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="pets_id" class="col-sm-2 control-label">Pets</label>
                <div class="col-sm-10">
                    <?php
                        $dd[""] = "-- Pets --";
                        if(isset($pets_potion) && !empty($pets_potion)) foreach($pets_potion as $val) $dd[$val["id"]] = ucwords($val["name"]);
                        echo form_dropdown("pets",$dd,"",array("class"=>"form-control required","id"=>"pets_id"));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="partner_id" class="col-sm-2 control-label">Partner</label>
                <div class="col-sm-10">
                    <?php
                        $dd = array();
                        $dd[""] = "-- Select Partner --";
                        if(isset($partner_option) && !empty($partner_option)) foreach($partner_option as $val) $dd[$val["partner_id"]] = ucwords($val["partner_name"]);
                        echo form_dropdown("partner",$dd,"",array("class"=>"form-control required","id"=>"partner_id"));
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label for="date" class="col-sm-2 control-label">Date</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control required" name="date" id="date" placeholder="ie. <?php echo date("Y-m-d"); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="slot_id" class="col-sm-2 control-label">Slot</label>
                <div class="col-sm-10">
                    <?php
                        $dd = array();
                        $dd[""] = "-- Select available slot --";
                        echo form_dropdown("slot",$dd,"",array("class"=>"form-control","id"=>"slot_id"));
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label for="payment_potion" class="col-sm-2 control-label">Payment</label>
                <div class="col-sm-10">
                    <?php
                        $dd = array();
                        $dd[""] = "-- Card Details --";
                        if(isset($payment_option) && !empty($payment_option)) foreach($payment_option as $val) $dd[$val["method_id"]] = $val["name_on_card"]." - ".substr($val["account_number"],-4);
                        echo form_dropdown("payment_potion",$dd,"",array("class"=>"form-control required","id"=>"payment_potion"));
                    ?>
                </div>
            </div>
        </div>
    </div>
</form>