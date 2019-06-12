<?php
$this->load->view("header");
?>
<div class="site-section bg-light " id="section-store">
  <div class="container mt-3 store-page">
    <div class="row">
      <div class="col-sm-12"><h4>Category</h4></div>
    </div>
    <div class="row">
      <div class="col-sm-3 category-wraper">
        <div class="row">
          <div class="col-sm-12 p-3">
              <div class="row">
                <?php
                  if(isset($category) && !empty($category)){
                    $i=0;
                    foreach($category as $val){
                ?>
                    <div class="col-sm-12 ">
                      <label class="cat-label pointer <?php echo ($i==0 ? "active" : ""); ?>" data-class="<?php echo $val["cat_slug"]; ?>">
                        <?php echo str_lim($val["category_name"],20); ?>
                      </label>
                      <?php if(isset($val["product"]) && !empty($val["product"])){ ?>
                      <div class="<?php echo $val["cat_slug"]; ?>">
                        <?php foreach($val["product"] as $pval){ ?>
                          <label class="product-label" title="<?php echo $pval["product_name"]; ?>">
                          <?php echo str_lim($pval["product_name"],30); ?>
                          </label>
                        <?php } ?>
                      </div>
                      <?php } ?>
                    </div>      
                <?php
                    $i++;
                    }
                  }
                ?>
            </div>
          </div>
        </div>
      </div>
      <!-- </div> -->

      <div class="col-sm-8">
        <div class="row">
          <?php
          if(isset($category) && !empty($category) && !empty($product)){
            foreach($product as $pval){
          ?>
            <div class="col-sm-3 col-md-3 col-12 text-center mb-4 product-pr <?php echo $pval["cat_slug"]; ?>">
              <div class="product-wraper mb-4">
                <div class="store-product-image">
                  <img src="<?php echo SITEURL.$pval["p_image"]; ?>"  />
                </div>
                <div class="product-title" title="<?php echo $pval["product_name"]; ?>">
                  <p><?php echo str_lim($pval["product_name"],15); ?></p>
                </div>
                <div class="product-button-wrap">
                  <input type="button" class="btn squer-button-full" value="$<?php echo $pval["price"]; ?>" />
                </div>
              </div>
            </div>
          <?php
            }
          }
          ?>
      </div>
      
    </div>
  </div>
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

$(document).on("click",".cat-label",function(){
  loader.set("body");
  $obj = $(this);
  $(".cat-label").removeClass("active");
  $obj.addClass("active");
  $(".product-pr").hide();
  $("."+$obj.attr("data-class")).show();
  window.setTimeout(() => {
    loader.remove();
  }, 1000);
});
</script>