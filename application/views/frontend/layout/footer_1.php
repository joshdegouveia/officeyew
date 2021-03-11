<!-- Footer start -->
    <footer class="ft-hold-wrapper">
        <div class="ft-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-3">
                        <ul class="ft-links">
                            <li><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li><a href="#">Office Furniture</a></li>
                            <li><a href="#">Installer</a></li>
                            <li><a href="#">Designer</a></li>
                            <li><a href="#">Job</a></li>
                            <li><a href="#">Candidate</a></li>
                            <li><a href="#">Subscription & Charges</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 col-lg-3 mrt-m-30">
                        <ul class="ft-links">
                            <li><a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
                            <li><a href="<?php echo base_url('who-we-are'); ?>">Who we are</a></li>
                            <li><a href="<?php echo base_url('how-we-work'); ?>">How we work</a></li>
                            <li><a href="<?php echo base_url('work-with-us'); ?>">Work with us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 col-lg-3 mrt-m-30">
                        <ul class="ft-links">
                            <li><a href="<?php echo base_url('terms-condition'); ?>">Terms and Conditions</a></li>
                            <li><a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policies</a></li>
                            <li><a href="<?php echo base_url('trust-safety'); ?>">Trust and Safety</a></li>
                            <li><a href="<?php echo base_url('support'); ?>">Support</a></li>
                            <li><a href="<?php echo base_url('help'); ?>">Help</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 col-lg-3 mrt-m-30">
                        <div class="ft-social-links">
                            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ft-bottom">
            <div class="container">
                <p class="copyright-txt">Copyright © 2020 Officeyew.com. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <!-- Footer end -->
    <a href="#" id="back-to-top" title="Back to top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>


    
<!-- Common js library -->
    <script src="<?php echo base_url(); ?>assets/frontend/js/jquery-1.11.0.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url(); ?>assets/frontend/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/js/owl.carousel.min.js"></script>
    <!-- Script for custom script-->
    <script src="<?php echo base_url(); ?>assets/frontend/js/custom-script.js"></script>

    <!-- Script for custom script-->
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/formValidation.min.js'></script>
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/framework/bootstrap.min.js'></script>

<script>
    function checkCaptcha(value, validator, $field) {
    var items = $('#captchaOperation').html().split(' '),
        sum   = parseInt(items[0]) + parseInt(items[2]);
    return value == sum;
}

$(document).ready(function() {
    // Generate a simple captcha
    function randomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }
    $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

    $('#basicBootstrapForm').formValidation();
});
</script>


</body>

</html>