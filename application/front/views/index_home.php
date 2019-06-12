<?php
$this->load->view("header");
?>
<div class="site-blocks-cover overlay" style="background-image: url(<?php echo base_url('assets/front/images/home-banners.jpeg'); ?>);" data-aos="fade" data-stellar-background-ratio="0.5" id="section-home">
  <div class="container">
    <div class="row align-items-center justify-content-center text-center">
      <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">
        <h2 class="text-white font-weight-light font-weight-bold" data-aos="fade-up">Crystel clear choice,</h2>
        <h2 class="text-white font-weight-light font-weight-bold" data-aos="fade-up">Sparkling you with our daimonds</h2>
      </div>
      <!-- <p class="get-started-arrow" data-aos="fade-up" data-aos-delay="200"><a href="#" class="btn btn-primary  py-3 px-5 text-white">Get Started!</a></p> -->
    </div>
  </div>
</div>
<div class="site-section" id="section-about">
  <div class="container mb-5">
    <div class="row mb-5">
      <div class="col-md-12 mb-4 order-md-2" data-aos="fade-up" data-aos-delay="100">
        <h2 class="text-primary text-center text-uppercase font-weight-bold mb-3">About</h2>
        <h6 class="text-primary text-center text-uppercase font-weight-bold mb-1">Jaitra Gems is</h6>
        <h6 class="text-primary text-center text-uppercase font-weight-bold">made easiar to serve good quality.</h6>
      </div>
    </div>
    <div class="row mb-5">
      <div class="col-md-5 ml-auto mb-5 order-md-2" data-aos="fade-up" data-aos-delay="100">
        <img src="<?php echo base_url('assets/front/images/rowm.jpeg'); ?>" alt="Image" class="img-fluid rounded">
      </div>
      <div class="col-md-6 order-md-1" data-aos="fade-up">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap. It was popularised in the 1960s with the release, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        
        <ul class="ul-check list-unstyled success">
          <li>Natural Diamonds</li>
          <li>Treated Diamonds</li>
          <li>Man Made Diamonds</li>
          <li>Natural Fancy Color Diamonds</li>
          <li>And more!</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="site-section" id="section-store">
  <div class="site-blocks-cover overlay" style="background-image: url(<?php echo base_url('assets/front/images/banner.jpeg'); ?>);" data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center">
        <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">
          <h2 class="text-white font-weight-light font-weight-bold" data-aos="fade-up">Want to get real diamonds experience</h2>
          <div class="text-white font-weight-light m-0" data-aos="fade-up">Lorem ipsum dolor sit amet consectetur adipisicing elit</div>
          <div class="text-white font-weight-light m-0" data-aos="fade-up">ipsum dolor sit amet consectetur a</div>
          <div class="text-white font-weight-light mb-4" data-aos="fade-up">Lorem ipsum dolor sit amet consectetur adipisicing elit</div>
          <p class="" data-aos="fade-up" data-aos-delay="200"><a href="#" class="btn btn-primary  py-3 px-5 text-white download-our-app">Join our community to get latest updates</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if($this->user_id == ""){ ?>
<div class="site-section" id="section-account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 mb-5 p-3">
        <span><?php echo $this->page->getMessage("add_account") ?></span>
        <form action="<?php echo base_url("login"); ?>" class="bg-white login-form" method="post">
          <h3 class="text-primary font-weight-bold mb-4">Login to your account</h3>
          
          <div class="row form-group">
            <div class="col-md-12 mb-3 mb-md-0">
              <label class="text-black form-label font-weight-bold" for="email">E-Mail</label>
<div class="EmailPassWord">
         <input type="text" name="email" id="email" class="form-control" placeholder="email">
            <i class="fa fa-envelope-o" aria-hidden="true"></i>
     </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-12">
              <label class="text-black form-label font-weight-bold" for="password">Password</label>
<div class="EmailPassWord">
   <input type="password" id="password" name="password" class="form-control" placeholder="passwords" />
   <i class="fa fa-key" aria-hidden="true"></i>
</div>
           
              <div style="display:none; color:red;" id="login-error" class="red"></div>
            </div>
          </div>
          <div class="row form-group">
            
            <div class="col-md-6 col-6 text-center">
              <input type="button" value="Register" data-class="registration-form" data-hide="login-form" class="btn btn-primary login-form-button py-2 px-4 text-white action-class">
            </div>
            <div class="col-md-6 col-6 text-center">
              <input type="submit" value="Login" class="btn btn-primary login-form-button py-2 px-4 text-white text-center active">
              
            </div>
            
          </div>
        </form>
        <form action="<?php echo base_url("registration/add") ?>" style="display: none" class="bg-white registration-form" method="post">
          <h3 class="font-weight-light text-primary mb-3">Register</h3>
          <div class="row form-group">
            <div class="col-md-12">
              <label class="text-black font-weight-bold" for="reg-name">Name</label>
              <input type="text" name="user_name" id="reg-name" class="form-control required">
            </div>
          </div>
          
          <div class="row form-group" style="display:none;">
            <div class="col-md-12">
              <label class="text-black font-weight-bold" for="reg-bname">Business Name</label>
              <input type="text" name="business_name" id="reg-bname" class="form-control required">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-12">
              <label class="text-black font-weight-bold">Mobile</label>
              <input type="text" id="reg-mobile" name="mobile" class="form-control required">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-12">
              <label class="text-black font-weight-bold">Email</label>
              <input type="text" id="reg-email" name="email" class="form-control required">
              <span id="reg-email-error"></span>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-12">
              <label class="text-black font-weight-bold" for="password">Password</label>
              <input type="password" id="reg-pass" name="password" class="form-control required">
            </div>
          </div>

          <div class="row form-group">
            
            <div class="col-md-6 col-6 text-center">
              <input type="submit" value="Register" class="btn btn-primary login-form-button py-2 px-4 text-white active">
            </div>
            <div class="col-md-6 col-6 text-center">
              <input type="button" value="Login" data-class="login-form" data-hide="registration-form" class="btn btn-primary login-form-button py-2 px-4 text-white text-center action-class">
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-6">
		<img class="p-5 after-login-image" style="max-width:100%;" src="<?php echo base_url("assets/front/images/beautifull.png") ?>">
      </div>
    </div>
  </div>
</div>
<?php } ?>

<div class="site-section border-bottom">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 text-center border-primary">
        <h2 class="font-weight-light text-primary">Testimonials</h2>
      </div>
    </div>
    <div class="slide-one-item home-slider owl-carousel">
      <div>
        <div class="testimonial">
          <!-- <figure class="mb-4">
            <img src="<?php echo base_url('assets/front/images/person_1.jpg'); ?>" alt="Image" class="img-fluid mb-3">
          </figure> -->
          <blockquote>
            <p>&ldquo;I have hired the Pet Concierge services twice now. Lauren is extremely friendly and informative. She takes last minute bookings which makes her a complete LIFE SAVER... she sends pictures and updates when she arrives and leaves of my pup. I highly recommend her service.&rdquo;</p>
            <p class="author"> &mdash; Sabreen N</p>
          </blockquote>
        </div>
      </div>
      <div>
        <div class="testimonial">
       <!--    <figure class="mb-4">
            <img src="<?php echo base_url('assets/front/images/person_2.jpg'); ?>" alt="Image" class="img-fluid mb-3">
          </figure> -->
          <blockquote>
            <p>&ldquo;Lauren is professional and absolutely amazing! She’s great with the dogs! She got them both picked up and taken care of perfectly! She was punctual which is super important to me in the midst of a hectic schedule with being a mom and a business owner as well. I appreciate her and we will be seeing her once a month.&rdquo;</p>
            <p class="author"> &mdash; Erin L</p>
          </blockquote>
        </div>
      </div>
     <!--  <div>
        <div class="testimonial">
          <figure class="mb-4">
            <img src="<?php echo base_url('assets/front/images/person_4.jpg'); ?>" alt="Image" class="img-fluid mb-3">
          </figure>
          <blockquote>
            <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
            <p class="author"> &mdash; Ben Carson</p>
          </blockquote>
        </div>
      </div> -->
      <!-- <div>
        <div class="testimonial">
          <figure class="mb-4">
            <img src="<?php echo base_url('assets/front/images/person_5.jpg'); ?>" alt="Image" class="img-fluid mb-3">
          </figure>
          <blockquote>
            <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
            <p class="author"> &mdash; Jed Smith</p>
          </blockquote>
        </div>
      </div> -->
    </div>
  </div>
</div>
<div class="site-section bg-light" id="section-contact">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-md-7 text-center border-primary">
        <h2 class="font-weight-bold text-primary">Stay In Touch</h2>
        <p class="color-black-opacity-5">Get Jaitra gems news and updates (We promise not to overload your inbox)</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-5">
        <form action="#" class="p-5 bg-white contact-form">
          <div class="row form-group">
            <div class="col-md-6 mb-3 mb-md-0">
              <label class="text-black" for="fname">Name</label>
              <input type="text" id="name" class="form-control" placeholder="Name">
            </div>
            <div class="col-md-6">
              <label class="text-black" for="lname">E-Mail</label>
              <input type="text" id="cntact-emal" class="form-control" placeholder="email">
            </div>
          </div>
          
          <div class="row form-group">
            <div class="col-md-12 mb-3 mb-md-0">
              <label class="text-black" for="fname">Message</label>
              <textarea name="contact-message" class="form-control" placeholder="Message"></textarea>
            </div>
          </div>
          
          <div class="row form-group">
            <div class="col-md-12">
              <input type="submit" value="Send Message" class="btn py-2 px-4 text-white round-button">
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <div class="p-4 mb-3 bg-white">
          <!-- <p class="mb-2 mt-4"><i class="fa fa-map-marker pr-3"></i> 203 Fake St. Mountain View, San Francisco, California, USA</p> -->
          <p class="mb-2"><i class="fa fa-envelope pr-2" aria-hidden="true"></i> jaitragems2018@gmail.com</p>
          <p class="mb-2"><i class="fa fa-phone pr-2" aria-hidden="true"></i> +91 987 948 2994</p>
        </div>
        <div class="p-4 mb-3 social-links bg-white">
            <!-- <span><i class="fa fa-pinterest" aria-hidden="true"></i></span> -->
            <!-- <span><i class="fa fa-linkedin-square" aria-hidden="true"></i></span> -->
            <!-- <span><i class="fa fa-google-plus" aria-hidden="true"></i></span> -->
            <!-- <span><i class="fa fa-twitter" aria-hidden="true"></i></span> -->
           <a href="https://www.facebook.com/"> <span><i class="fa fa-facebook-square" aria-hidden="true"></i> Jaitra Gems</span></a>
            <a href="https://instagram.com/"><span><i class="fa fa-instagram" aria-hidden="true"> </i> My Shop</span></a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$this->load->view("footer");
?>
<script>
  var email_flag = true;
  $(document).on("click",".action-class",function(){
    var $obj = $(this);
    $(".action-class").removeClass("active");
    $obj.addClass("active");
    $($obj.attr("data-hide")).hide(300);
    $("."+$obj.attr("data-class")).show(300,function(){
      $("."+$obj.attr("data-hide")).hide(300);
      if($obj.attr("data-hide") == 'registration-form'){
        $('html, body').animate({
            scrollTop: $(".login-form").offset().top
        }, 400);
      }
    });
  });
  $(document).on("click",".book-activity-start",function(e){
    var $obj = $(this);
    $obj.text("Loading...");
    var activity = $obj.attr("data-activity");
    loader.set("#book-full-model .modal-body");
    if(activity != ""){
        $.ajax({
            url:base_url+"home/get_activity_partner",
            type : "POST",
            data :{"activity" : activity},
            success : function(res){
                $obj.text("Book it");
                loader.remove();
                $("#book-full-model").find(".modal-body").html(res);
                $("#date").datepicker({autoclose: true, todayHighlight: true,format: 'yyyy-mm-dd'});
            }
        });
    }else{
    }  
  });
    $(document).on("change","input[name='date']",function(){
        $obj = $(this);
        var date = $obj.val();
        var partner_id = $("select[name='partner']").val();
        var activity = $("input[name='activity']").val();
        if(date != "" && partner_id != "" && activity != ""){
            $.ajax({
                type : "POST",
                url : base_url + "home/get_available_slot",
                data : {"activity":activity,"partner_id":partner_id,"date":date},
                dataType : "json",
                success : function(res){
                    if(typeof res.Result != "undefined" && res.Result == 1 && res.data != ""){
                        $("#slot_id").html(res.data);
                    }else{
                    }
                },
                error : function(err){
                }
            });
        }
    });
    $(document).on("click","#book-order",function(){
        $obj = $(this);
        var error_flag = false;
        $("#book-activity-form").find(".required").each(function(index,element){
            if($(element).val() == ""){
                $(element).addClass("error");
                error_flag = true;
            }else{
                $(element).removeClass("error");
            }
            console.log(error_flag);
        });
        if(!error_flag){
            $.ajax({
                type : "POST",
                url : base_url+"activity/book",
                data : $("#book-activity-form").serialize(),
                dataType : "json",
                beforeSend : function(){
                    loader.set("body");
                    $obj.attr("disabled","disabled");
                },
                success : function(res){
                    $("#book-full-model").modal("hide");
                    loader.remove();
                    $obj.removeAttr("disabled");
                }
            })
        }
    });
    $(document).on("click",'input[value="Login"]',function(e){
      $obj = $(this);
      e.preventDefault();
      $form = $obj.parents("form");
      var from_data = $obj.parents("form").serialize();
      $.ajax({
        url:base_url+"login/check",
        type:"POST",
        data:from_data,
        dataType:"json",
        beforeSend:function(){
          $("#login-error").html("");
          $obj.val("Loading...");
          $obj.attr("disabled","disabled");
          loader.set("body");
        },
        success:function(res){
          $obj.removeAttr("disabled");
          $obj.val("Login");
          if(res.status == 1){
            $form.submit();
          }else{
            $("#login-error").html(res.message);
            $("#login-error").show();
          }
          loader.remove();
        },
        error:function(){
          loader.remove();$obj.val("Login");
          $obj.removeAttr("disabled");
        }
      });
    });
    $(document).on("change",".registration-form input[name='login_type']",function(){
      $obj = $(this);
      $("#reg-email").val("");
      if($obj.is(":checked") && $obj.val() == "partner"){
        $("#reg-bname").parents(".form-group").show();
      }else{
        $("#reg-bname").parents(".form-group").hide();
      }
    });
    $(document).on("click",".registration-form input[type='submit']",function(){
      var error_flag = true;
      $obj = $(this);
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
      $form = $obj.parents("form");
      $form.find(".required").each(function(index, element){
        if($(element).val() == "" && !$(element).is(":hidden")){
          $(element).addClass("error");
          error_flag = false;
        }else{
          $(element).removeClass("error");
        }
      });
      if($("#reg-email").val() != "" && !re.test(String($("#reg-email").val()).toLowerCase())){
        $("#reg-email-error").text("Provide valid email");
        $("#reg-email").addClass("error");
        error_flag = false;
      }else{
        $("#reg-email-error").text("");
      }
      return error_flag && email_flag;
    });
    $(document).on('keypress',"#reg-mobile, #price",function(e){
      var regex = new RegExp("^[0-9()+]+$");
      var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
      if (regex.test(str)) {
          return true;
      }
      e.preventDefault();
      return false;
    });
    $(document).on("blur","#reg-email",function(){
      $obj = $(this);
      var user_type = $("input[name='login_type']:checked").val();
      if($obj.val() != ""){
        $.ajax({
          type:"POST",
          url:base_url+"registration/email_check",
          data:{"user_type":user_type,"email":$obj.val()},
          dataType:"json",
          beforeSend:function(){
            loader.set("body");
          },
          success:function(res){
            if(res.status == 1){
              $("#reg-email-error").text("");
              $("#reg-email").removeClass("error");
              email_flag = true;
            }else{
              $("#reg-email").addClass("error");
              $("#reg-email-error").text(res.message);
              email_flag = false;
            }
            loader.remove();
          },
          error:function(err){
            loader.remove();
          }
        });
      }
    });
</script>