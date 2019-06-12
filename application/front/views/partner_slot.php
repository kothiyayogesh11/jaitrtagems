<div class="site-section" id="section-activity">
  <div class="container mb-5">
    <div class="row mb-5">
      <div class="col-md-12 mb-4 order-md-2 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
        <h2 class="text-primary text-center text-uppercase font-weight-bold mb-3">List Order</h2>
      </div>
    </div>
    <div class="row mb-5">
      
      <div class="col-md-12">
      <?php	if(!empty($activity_list)){	?>
        <div class="activity-wrap">
        <?php foreach($activity_list as $val){ ?>
          <div class="activity-holder">
            <div class="row">                    
              <div class="col-md-2 text-center">
                <a href="<?php base_url("activity/details") ?>">
                  <img class="activity-image-book " src="<?php echo SITEURL.$val["image"]; ?>" alt="<?php echo $val["name"]; ?>">
                </a>
              </div>
              <div class="col-md-7">
                <div class="row">
                  <div class="col-sm-5 text-center">
                    <h3 class="line-h-6x"><a href="<?php echo base_url("activity/details/".$val["activity_id"]) ?>"><?php echo ucwords($val["name"]); ?></a></h3>
                  </div>
                  <div class="col-sm-7 text-center"><span class="line-h-6x">$<?php echo $val["price"] ?> : <?php echo $val["rate_on"]; ?></span></div>
                </div>
              </div>
              <div class="col-md-3 line-h-6x text-right">
                <button type="button" data-activity="<?php echo $val["activity_id"]; ?>" data-toggle="modal" data-target="#book-full-model" class="btn theme-color round-button-full book-activity-start">Book it</button>
              </div>
            </div>
          </div>
        <?php } ?>
        </div>
        <?php }	?>
      </div>
    </div>
  </div>
</div>