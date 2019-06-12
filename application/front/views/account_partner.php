<?php
$assets["assets_header"] = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" /><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" /> <link rel="stylesheet" type="text/css" href="'.base_url('assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css').'" />';
$this->load->view("header",$assets);
?>
<style>
.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
.toggle.ios .toggle-handle { border-radius: 20px; }
.toggle.android { border-radius: 0px;}
.toggle.android .toggle-handle { border-radius: 0px; }
.btn-info {color: #fff;background-color: var(--theam-color);border-color: var(--theam-color);}
.btn-info:hover {color: #fff;background-color: var(--theam-color);border-color: var(--theam-color);}
.btn-info:not(:disabled):not(.disabled).active, .btn-info:not(:disabled):not(.disabled):active, .show>.btn-info.dropdown-toggle {
    color: #FFF;
    background-color: var(--theam-color);
    border-color: var(--theam-color);
}
.btn-default{background: var(--theam-color);color: #FFF;}
.toggle-handle{background: #FFF;}
input[name="available"]{display:none;}
.round-radio{width:20px; height: 20px; border:1px solid #CCC; margin:0; border-radius: 50%; vertical-align: middle;}
input[type=radio]:checked+label.round-radio{border:4px solid var(--theam-color);}
#available_datepicker table, #available_datepicker .datepicker-inline{width:100%;}
.image-round-activity-list{height:60px;width:60px;max-height:60px;max-width:60px;border-radius: 50%;}
.normal-border{border:1px solid #ccc; border-radius:5px;}
.middle{vertical-align: middle;}
</style>
<div class="site-section bg-light" id="section-profile">
<input type="hidden" name="site_user_key" value="<?php echo $this->user_id; ?>">
<input type="hidden" name="site_url_key" value="<?php echo SITEURL; ?>">
    <div class="container emp-profile mt-3">
        <form id="partner_order_form">
        <div class="row activity-tabs">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-schedule-tab" data-toggle="pill" href="#v-pills-schedule" role="tab" aria-controls="v-pills-schedule" aria-selected="true">Schedule</a>

                    <a class="nav-link" id="v-pills-job-tab" data-toggle="pill" href="#v-pills-job" role="tab" aria-controls="v-pills-job" aria-selected="false">Jobs</a>

                    <a class="nav-link" id="v-pills-message-tab" data-toggle="pill" href="#v-pills-message" role="tab" aria-controls="v-pills-message" aria-selected="false">Orders</a>

                    <a class="nav-link" id="v-pills-friend-tab" data-toggle="pill" href="#v-pills-friend" role="tab" aria-controls="v-pills-friend" aria-selected="false">Friends</a>
                
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content px-4" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-schedule" role="tabpanel" aria-labelledby="v-pills-schedule-tab">
                        <div class="row partner-activity-wraper">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="bold500">Set Availability</h4>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <input type="checkbox" value="1" <?php echo @$partner_availability["is_available"] == 1 ? 'checked="checked"' : ''; ?> name="main_availability" data-toggle="toggle" data-style="ios" data-width="80" data-onstyle="info">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                    <?php 
                                    $from_time  = @$partner_availability["from_time"];
                                    $to_time    = @$partner_availability["to_time"];
                                    $from_time  = $from_time != "" ? date("h:i A",strtotime($from_time)) : "";
                                    $to_time    = $to_time != "" ? date("h:i A",strtotime($to_time)) : "";
                                    ?>
                                        <div class="col-md-3 ">
                                            <label class="bold500">From</label>
                                            <div class="text-center">
                                            <input type="text" class="form-control datetimepicker-input pointer" readonly id="from_time" name="from_time" data-toggle="datetimepicker" data-target="#from_time" data-time="<?php echo $from_time; ?>" value="<?php echo $from_time; ?>" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="bold500">To</label>
                                            <input type="text" class="form-control datetimepicker-input pointer" readonly id="to_time" name="to_time" data-toggle="datetimepicker" data-target="#to_time" data-time="<?php echo $to_time; ?>" value="<?php echo $to_time; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="bold500">Days</label>
                                            <?php
                                            $av_date = @$partner_schedule["available_date"] != "" ? date("Y-m-d",strtotime(@$partner_schedule["available_date"])) : date("d M, Y");
                                            
                                            ?>
                                            <div id="available_datepicker" data-date="<?php echo date("Y-m-d",strtotime(@$av_date)); ?>"></div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="request-wrap">
                                                <div class="request-date paddind10 gray">
                                                    <div class="d50-block text-left date-div-title"><?php echo $av_date; ?></div>
                                                </div>
                                                <div class="request-date paddind10 no-border">
                                                    <div>
                                                        
                                                        <input type="radio" <?php echo @$partner_schedule["available"] == 1 ? 'checked="checked"' : ''; ?> name="available" value="1" id="availabel-on" /><label class="round-radio pointer" for="availabel-on"> </label>
                                                        <label class="bold500 pointer" for="availabel-on">&nbsp Available</label>

                                                    </div>
                                                    <div>
                                                        <input type="radio" <?php echo @$partner_schedule["available"] == 0 ? 'checked="checked"' : ''; ?> value="0" name="available" id="availabel-off" /><label class="round-radio pointer" for="availabel-off"> </label> 
                                                        <label class="bold500 pointer" for="availabel-off">&nbsp Not Available</label>
                                                    </div>
                                                </div>
                                                <div class="paddind10 text-right"><input type="button" value="Save" id="save-schedule" class="btn btn-primary login-form-button py-2 px-4 text-white text-center"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-job" role="tabpanel" aria-labelledby="v-pills-job-tab">
                        
                    </div>
                    <div class="tab-pane fade" id="v-pills-message" role="tabpanel" aria-labelledby="v-pills-message-tab">
                        
                    </div>

                    <div class="tab-pane fade" id="v-pills-friend" role="tabpanel" aria-labelledby="v-pills-friend-tab"></div>

                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-5">
                                    <div class="col-md-12">
                                        <h4 class="bold600 mb-4">Profile</h4>
                                    </div>

                                    <div class="col-md-3 text-center">
                                        <img class="image-round" src="<?php echo file_check($this->login_user['user_profile']); ?>" />
                                    </div>
                                    <div class="col-md-6 text-left align-middle">
                                        <div class="bold500 pt-3 mb-2"><span><?php echo $this->login_user['user_name']; ?></span><br><span class="text-muted"><i class="fa fa-marker"></i> New Your, USA</span></div>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <label class="py-3 m-0 align-middle">Edit</label>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6 text-left">
                                        <h5 class="bold600">Service</h5>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span class="theam-color pointer add-service">Add</span>
                                    </div>

                                </div>
                                <div class="activity-service-list">
                                    <?php
                                    if(isset($activity) && !empty($activity)){
                                        foreach($activity as $val){
                                    ?>
                                            
                                        <div class="row mb-4 activity-block" data-activity="<?php echo $val["activity_id"]; ?>">
                                            <div class="col-md-6">
                                                <h6 class="m-0 bold500" data-name="<?php echo $val["name"]; ?>"><?php echo $val["name"]; ?></h6>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-9 normal-border"><span class="middle" data-price="<?php echo $val["price"]; ?>"><?php echo $val["price"] != "" ? "$ ".$val["price"] : "N/A"; ?></span></div>
                                                    <div class="col-md-3 text-right">
                                                        <label><i class="fa fa-edit pointer edit-activity"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <?php 
                                                    $mi=0;
                                                    if(isset($val["media"]) && !empty($val["media"])){
                                                        foreach($val["media"] as $mv){
                                                    ?>
                                                    <div class="col-md-2">
                                                        <img class="image-round-activity-list" src="<?php echo SITEURL.$mv["media"]; ?>" />
                                                    </div>
                                                    <?php 
                                                            $mi++;
                                                            if($mi==2) break;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    <?php
                                        }
                                    }
                                    ?>
                                    
                                </div>


                            </div>
                            <div class="col-md-8">
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>    
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addServiceModalTitle">Add Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                        <?php 
                            $act_dd[""] = "Select Service";
                            echo form_dropdown("activity_main",$act_dd,"",array("class"=>"form-control err_main_activity")); 
                        ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea name="comment" placeholder="Description..." rows="4" class="form-control err_main_activity"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" placeholder="$" name="activity_rate" class="form-control err_main_activity" />
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                        <?php 
                            $duration[""] = "Duration";
                            $duration["1"] = "1 hour";
                            $duration["2"] = "2 hour";
                            $duration["3"] = "3 hour";
                            $duration["4"] = "4 hour";
                            echo form_dropdown("activity_duration",$duration,"",array("class"=>"form-control"));
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        <form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary add-main-activity">Save</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editServiceModalTitle"><i class="fa fa-edit"></i> Edit Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <h4 class="bold500 edit-act-name"></h4>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea name="comment" placeholder="Description..." rows="3" class="form-control err_main_activity"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" placeholder="$" name="activity_rate" class="form-control err_main_activity" />
                        </div>
                    </div>
                </div>
            </div>
        <form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary edit-main-activity" data-activity-id="">Save</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="addSubServiceModal" tabindex="-1" role="dialog" aria-labelledby="addSubServiceModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSubServiceModalTitle">Add Sub Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                        <?php 
                            /* $act_dd[""] = "Select Category";
                            if(isset($activity_sub)){
                                foreach($activity_sub as $act_val)
                                $act_dd[$act_val["activity_id"]] = ucwords($act_val["name"]);
                            }
                            echo form_dropdown("activity_category",$act_dd,"",array("class"=>"form-control"));  */
                        ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="sub_activity" placeholder="name" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea name="comment" placeholder="Description..." rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" placeholder="$" name="sub_activity_rate" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                        <?php 
                            $duration[""] = "Duration";
                            $duration["1"] = "1 hour";
                            $duration["2"] = "2 hour";
                            $duration["3"] = "3 hour";
                            $duration["4"] = "4 hour";
                            echo form_dropdown("activity_duration",$duration,"",array("class"=>"form-control"));
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        <form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary add-sub-activity">Save</button>
      </div>
    </div>
  </div>
</div>
<?php
$assets["assets_footer"] = '<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js" type="text/javascript" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script><script type="text/javascript" src="'.base_url('assets/plugins/bootstrap-toggle/js/bootstrap2-toggle.min.js').'"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" crossorigin="anonymous"></script><script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyAOrnFPCKruyje0NvuFMkBEB17L_JHUnyM"></script><script type="text/javascript" src="'.base_url('assets/front/js/partner.js').'"></script>';
$this->load->view("footer", $assets);
?>
