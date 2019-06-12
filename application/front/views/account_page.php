<?php
$assets["assets_header"] = '<link rel="stylesheet" type="text/css" href="'.base_url('assets/plugins/time-picki/css/timepicki.css').'"/><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />';
$this->load->view("header",$assets);
?>
<style>
.search-partner-wrap input[type=text] {padding: 10px 0 10px 20px;font-size: 16px; border-bottom: 1px solid var(--theam-color); border-top: 1px solid var(--theam-color); border-left: 1px solid var(--theam-color); border-right: none; float: left; width: 80%; background: #FFF;border-top-left-radius: 25px;  border-bottom-left-radius: 25px;}
.search-partner-wrap input[type=text]:focus {outline: none;}
.search-partner-wrap button { float: left; width: 20%; padding: 10px; background: #FFF; color: var(--theam-color); font-size: 16px; border: 1px solid var(--theam-color); border-left: none;  cursor: pointer; border-bottom-right-radius: 25px; border-top-right-radius: 25px;}
.search-partner-wrap:focus{outline: none;}
.search-partner-wrap button:focus{outline: none;}
.search-partner-wrap::after { content: ""; clear: both; display: table;}
.activity-media,.pets-profile{max-width:200px; display:inline-block;}
.pets-profile{position: relative;}
#geomap, #geomap_book, #geomap_book_form, #geomap_book_new{height:250px;}
.book-form-heading{font-weight:bolder;}
.day{padding:10px;}
.active.day{background-color: var(--theam-color) !important; background-image: var(--theam-color) !important;}
.timepicker_wrap {padding: 10px 0;top: 40px;}
.time, .mins, .meridian {margin: 0 7px;}
.request-date{border-bottom: solid 1px #ccc;}
.paddind10{padding:10px;}
.request-time{width: 35%; display: inline-block; border-right: solid 1px #ccc;}
.bold500{font-weight:500;}
.bold600{font-weight:600}
.gray{color: #767373 !important;}
.text-left{text-align:left;} 
.request-wrap{border: 2px solid #ccc; border-radius: 15px;}
.no-border{border: 0 !important;}
.d50-block{width: 50%; display: inline-block;}
.pets-image-name {position: absolute;bottom: 0;padding: 10px;text-align: center;width: 100%;font-weight: bold;color: #FFF;text-shadow: 2px 1px #000;}
.pets-profile img{max-height: 150px !important;max-width: 100%;}
.img-round-cust{max-width: 100%;height: 150px;width: 150px;border-radius: 50%;}
</style>

<div class="site-section bg-light" id="section-profile">
<input type="hidden" name="site_user_key" value="<?php echo $this->user_id; ?>">
<input type="hidden" name="site_url_key" value="<?php echo SITEURL; ?>">
    <div class="container emp-profile mt-3">
        <form id="acitivty_book_form">
        <div class="row activity-tabs">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-book-tab" data-toggle="pill" href="#v-pills-book" role="tab" aria-controls="v-pills-book" aria-selected="true">Book</a>
                    <a class="nav-link" id="v-pills-request-tab" data-toggle="pill" href="#v-pills-request" role="tab" aria-controls="v-pills-request" aria-selected="false">Request</a>
                    <a class="nav-link" id="v-pills-order-tab" data-toggle="pill" href="#v-pills-order" role="tab" aria-controls="v-pills-order" aria-selected="false">Orders</a>
                    <a class="nav-link" id="v-pills-friend-tab" data-toggle="pill" href="#v-pills-friend" role="tab" aria-controls="v-pills-friend" aria-selected="false">Friends</a>
                
                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content px-4" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-book" role="tabpanel" aria-labelledby="v-pills-book-tab">
                        <div class="activity-parent">
                            <h3 class="mb-4">What are you looking for?</h3>
                            <div class="row">
                                <?php
                                if(isset($activity) && !empty($activity)){
                                    foreach($activity as $val){
                                ?>
                                    <div class="col-sm-3 mb-3 activity-accelerate pointer" data-act-id="<?php echo $val["id"]; ?>">
                                        <div class="text-center activity-container">
                                            <div><img class="img" src="<?php echo SITEURL.$val["image"]; ?>" /></div>
                                            <div class="mb-2 activity-title"><?php echo $val["title"]; ?></div>
                                        </div>
                                    </div>
                                <?php
                                    }
                                }else{
                                    echo "No activity available at the movement!";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="partner-parent" style="display:none;">
                            <div class="search-partner-wrap" style="max-width:60%">
                                <input type="text" placeholder="Search.." id="get-partner" name="search2">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 partner-list">
                                </div>
                            </div>
                        </div>
                        
                        <div class="partner-details" style="display:none;">
                            <div class="row">
                                <div class="col-sm-10 partner-details-wrap">
                                        
                                </div>
                            </div>
                        </div>
                        <!-- Book Form -->
                        <div class="row book-form mt-1" style="display:none;"></div>

                    </div>
                    <div class="tab-pane fade" id="v-pills-request" role="tabpanel" aria-labelledby="v-pills-request-tab">
                        <div class="book-pending-order">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <input type="button" value="Add New Reqquest" id="add_new_request" class="btn btn-primary round-button-full py-2 px-4 text-white text-center active">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <h3>Open Requests</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 customer-open-requets"></div>
                            </div>
                        </div>
                        
                        <div class="book-pending-order-details" style="display:none"></div>

                        <div class="add-new-request-form" style="display:none;">
                            
                            <div class="col-sm-12">
                                <div class="h4 mb-3 book-form-heading">Add New Request</div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <?php echo form_dropdown("new_activity",$activity_dd,"",array("class"=>"form-control new_err")); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <select class="form-control" name="new_service_type">
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
                                        <?php echo form_dropdown("new_pets",$pets_list,"",array("class"=>"form-control new_err")); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <div id="geomap_book_new"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <input type="text" name="new_address" class="form-control new_err" placeholder="Enter your address or pick on map" />
                                        <input type="hidden" name="new_lat" />
                                        <input type="hidden" name="new_long" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <input type="text" readonly  name="new_date" class="form-control partner_date pointer new_err" placeholder="Select Available Slot" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <input type="text" readonly  name="new_from_time" class="form-control partner_time pointer new_err" placeholder="Select from time" />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" readonly  name="new_to_time" class="form-control partner_time pointer new_err" placeholder="Select to time" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <?php 
                                        echo form_dropdown("new_payment_method",$payment_list,"",array("class"=>"form-control new_err"));
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <input type="button" value="Confirm" id="new_book_accelarate" class="btn btn-primary round-button-full py-2 px-4 text-white text-center active">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="edit_partner_list" style="display:none;">
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab">
                        <div class="book_order_history" style="display:none;">
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-friend" role="tabpanel" aria-labelledby="v-pills-friend-tab">...</div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="user-profile-parent" style="display:none;"></div>
                        <div class="add-pets-form" style="display:none;">
                        
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="text" name="pets_name" placeholder="Name" class="form-control pets_err" />
                                    </div>

                                    <div class="col-md-6">
                                        <select class="form-control pets_err" name="pets_age">
                                            <option value="">Select age</option>
                                            <option value="1week">1 Week</option>
                                            <option value="2week">2 Week</option>
                                            <option value="1month">1 Month </option>
                                            <option value="2month">2 Month</option>
                                            <option value="3month">3 Month</option>
                                            <option value="6month">6 Month </option>
                                            <option value="1year">1 Year </option>
                                            <option value="1gtyear">1 Year +</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <?php echo form_dropdown("pets_type",$pets_type,"",array("class"=>"form-control pets_err")); ?>
                                    </div>

                                    <div class="col-md-6">
                                        <select class="form-control pets_err" name="pets_weight">
                                            <option value="">Weight</option>
                                            <option value="1kg">1 Kg</option>
                                            <option value="2kg">2 Kg </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <?php 
                                        echo form_dropdown("breed_type",array(""=>"Select Breed"),"",array("class"=>"form-control"));
                                        ?>
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="file" value="Upload Photo" id="pets_file" class="btn btn-primary round-button-full py-2 px-4 text-white text-center pets_err active">
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="button" value="Confirm" id="add_pets_accelerate" class="btn btn-primary round-button-full py-2 px-4 text-white text-center active">
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        </form>
    </div>
</div>
<?php
$assets["assets_footer"] = '<script type="text/javascript" src="'.base_url('assets/plugins/time-picki/js/timepicki.js').'"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" crossorigin="anonymous"></script><script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyAOrnFPCKruyje0NvuFMkBEB17L_JHUnyM"></script><script type="text/javascript" src="'.base_url('assets/front/js/customer.js').'"></script>';
$this->load->view("footer", $assets);
?>
<script>
/* End Slot Booking */
</script>