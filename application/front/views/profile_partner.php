<?php
$this->load->view("header");
?>
<div class="site-section bg-light" id="section-profile">
    <div class="container emp-profile mt-3">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="<?php echo file_check($profile_data["profile"]); ?>" alt=""/>
                        <div class="file btn btn-lg btn-primary">Change Photo<input type="file" name="file"/></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5><?php echo ucwords($profile_data["name"]); ?></h5>
                        <h6><?php echo ucwords($profile_data["business_name"]); ?></h6>
                        <p class="proile-rating">RANKINGS : <span>8/10</span></p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Schedule</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="activity-tab" data-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="false">activity</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <p>WORK LINK</p>
                        <a href="">Website Link</a><br/>
                        <a href="">Bootsnipp Profile</a><br/>
                        <a href="">Bootply Profile</a>
                        <p>SKILLS</p>
                        <a href="">Web Designer</a><br/>
                        <a href="">Web Developer</a><br/>
                        <a href="">WordPress</a><br/>
                        <a href="">WooCommerce</a><br/>
                        <a href="">PHP, .Net</a><br/>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6"><label>User Id</label></div>
                                <div class="col-md-6"><p>PID<?php echo str_pad($this->user_id,7,"0",STR_PAD_LEFT); ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><label>Name</label></div>
                                <div class="col-md-6"><p><?php echo ucwords($profile_data["name"]); ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><label>Email</label></div>
                                <div class="col-md-6"><p><?php echo $profile_data["email"]; ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><label>gender</label></div>
                                <div class="col-md-6"><p><?php echo $profile_data["gender"]; ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><label>Phone</label></div>
                                <div class="col-md-6"><p><?php echo $profile_data["mobile"]; ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><label>address</label></div>
                                <div class="col-md-6"><p><?php echo $profile_data["address"] ?></p></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-6"><label>Availability</label></div>
                                <div class="col-md-6"><p><?php echo $profile_data["is_available"] == 1 ? "On" : "Off"; ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><label>Working Hours</label></div>
                                <?php 
                                    $from_time = $profile_data["from_time"];
                                    $from_time = $from_time == "" ? "--" : date("H:i A",strtotime($from_time));
                                    $to_time = $profile_data["to_time"];
                                    $to_time = $to_time == "" ? "--" : date("H:i A",strtotime($to_time));
                                ?>
                                <div class="col-md-6"><p><?php echo $from_time." to ".$to_time; ?></p></div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                            
                            <?php
                            if(isset($activity) && !empty($activity)){
                                $i = 0;
                                foreach($activity as $val){
                                echo '<div class="row"><div class="col-md-2 col-xs-1"><label>'.($i+1).'</label></div><div class="col-md-10 col-xs-11"><p>'.ucwords($val["name"]).'</p></div></div>';
                                $i++;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>           
    </div>
</div>
<?php
$this->load->view("footer");
?>
<script>
$(document).ready(function(){
    if( !$('.js-site-navbar').hasClass('scrolled') ) {
        $('.js-site-navbar').addClass('scrolled');  
    }
    if( !$('.js-site-navbar').hasClass('awake') ) {
        $('.js-site-navbar').addClass('awake'); 
    }
});
</script>