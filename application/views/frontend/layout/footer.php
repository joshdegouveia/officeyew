<!-- Footer start -->
<div class="clearfix"></div>
<footer class="ft-hold-wrapper">
    <div class="ft-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-3">
                    <ul class="ft-links">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li><a href="<?php echo base_url("products/list-all") ?>">Office Furniture</a></li>
                        <li><a href="<?php echo base_url("installer") ?>">Installer</a></li>
                        <li><a href="<?php echo base_url("designer") ?>">Designer</a></li>
                        <li><a href="#">Job</a></li>
                        <li><a href="#">Candidate</a></li>
                        <li><a href="<?php echo base_url('subscription-charges'); ?>">Optional Subscription & Charges</a></li>
                        <li><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
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
                        <?php
                        $la_socialLinks = getSocialLinks();

                        $facebook = $insta = $twitter = $linkdin = "#";
                        $facebookT = $instaT = $twitterT = $linkdinT = "";
                        foreach ($la_socialLinks as $row) {
                            if ($row->type == 'facebook') {
                                $facebook = $row->value;
                                $facebookT = $row->name;
                            } elseif ($row->type == 'insta') {
                                $insta = $row->value;
                                $instaT = $row->name;
                            } elseif ($row->type == 'twitter') {
                                $twitter = $row->value;
                                $twitterT = $row->name;
                            } elseif ($row->type == 'linkdin') {
                                $linkdin = $row->value;
                                $linkdinT = $row->name;
                            }
                        }
//                        print_r($getSocialLinks);
//                        die;
                        ?>
                        <a href="<?= $facebook ?>" title="<?= $facebookT ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="<?= $insta ?>" title="<?= $instaT ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="<?= $twitter ?>" title="<?= $twitterT ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="<?= $linkdin ?>" title="<?= $linkdinT ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
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



<script src="<?php echo base_url(); ?>assets/frontend/js/owl.carousel.min.js"></script>
<!-- Script for custom script-->
<script src="<?php echo base_url(); ?>assets/frontend/js/custom-script.js"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/select2.min.js"></script>
<?php
//die($secret_key);
if (isset($secret_key)) {
    ?>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/js/cart.js"></script>
<?php }
?>
<!-- Script for custom script-->
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/formValidation.min.js'></script>
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/framework/bootstrap.min.js'></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.toaster.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>


<script>
    function checkCaptcha(value, validator, $field) {
        var items = $('#captchaOperation').html().split(' '),
                sum = parseInt(items[0]) + parseInt(items[2]);
        return value == sum;
    }

    $(document).ready(function () {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

        $('#basicBootstrapForm').formValidation();
    });


    function openCity(className, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
//        evt.currentTarget.className += " active";
        $("." + className).addClass('active');
    }

    function update_user_type(type) {
        $("#update_user_type_form").submit();
    }

    function toaster_msg(priority, title, message) {
        $(".alert").hide();
        $.toaster({priority: priority, title: title, message: message, loader: true});
    }

    $(".select2").select2();


</script>


</body>

</html>