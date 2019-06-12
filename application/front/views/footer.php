<footer class="site-footer">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-5 mr-auto">
            <h1 class="site-logo mb-0"><a href="index.html" class="text-white h2 mb-0"><span>J</span>aitra <span> G</span>ems</a></h1>
            <p></p>
            <p></p>
            <div class="border-top pt-2">
              <p>
                <small class="block">&copy; <?php echo date("Y"); ?> Pet App. All Rights Reserved.</small>
              </p>
            </div>
            <h2 class="footer-heading mb-4 text-uppercase">Subscribe to our news</h2>
            <form action="#" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control border-secondary text-white bg-transparent" placeholder="Your Email" aria-label="Your Email" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary text-white" type="button" id="button-addon2"> &nbsp; > &nbsp;</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div>
          <ul class="list-unstyled ">
            <li><a href="#section-home">Home</a></li>
            <li><a href="#section-about">About Us</a></li>
            <!-- <li><a href="#section-store">Store</a></li> -->
            <!-- <li><a href="#">My  Account</a></li> -->
            <li style="float: none;"><a href="#section-contact">Contact</a></li>
          </ul>
        </div>
        <div>
          <h2 class="footer-heading mb-4 text-uppercase">Follow Us</h2>
          <a href="https://www.facebook.com/MyPetConciergeService/" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
          <!-- <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a> -->
          <a href="https://instagram.com/mypetconcierge?utm_source=ig_profile_share&igshid=1ojo9sl6uuq2z" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
          <!-- <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a> -->
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- </div> -->
<!-- Book Activity Model -->
<?php if($this->user_id != ""){ ?>
  <div class="modal fade full-width-model" id="book-full-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add New Request</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
            <button type="button" class="btn round-button" id="book-order">Confirm</button>
        </div>
        </div>
    </div>
  </div>
<?php } ?>
<!-- End Book Activity Model -->
<script src="<?php echo base_url('assets/front/js/jquery-3.3.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/jquery-migrate-3.0.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/jquery-ui.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/jquery.easing.1.3.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/owl.carousel.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/jquery.stellar.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/jquery.countdown.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/jquery.magnific-popup.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/aos.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/main.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/script.js'); ?>"></script>
<script src="<?php echo base_url('assets/front/js/site.js'); ?>"></script>
<?php echo isset($assets_footer) ? $assets_footer : ""; ?>
</body>
</html>