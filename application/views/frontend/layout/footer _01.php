        <footer class="footer p-0 footer-light bg-section-secondary" id="footer-main">
            <div class="container">
                <div class="py-4">
                    <div class="row align-items-md-center">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="d-flex align-items-center">
                               <!--  <p class="text-sm mb-0">&copy; Purpose. 2019 <a href="https://webpixels.io" target="_blank">Webpixels</a>. All rights reserved.</p> -->
                               <?php echo $home_page_setting['footer_copy_right']; ?>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-4 mb-sm-0">
                            <ul class="nav justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url('support'); ?>">Support</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url('terms-condition'); ?>">Terms</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url('privacy-policy'); ?>">Privacy</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="https://dribbble.com/webpixels" target="_blank">
                                        <i class="fab fa-dribbble"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://www.instagram.com/webpixelsofficial" target="_blank">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://github.com/webpixels" target="_blank">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://www.facebook.com/webpixels" target="_blank">
                                        <i class="fab fa-facebook"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Core JS - includes jquery, bootstrap, popper, in-view and sticky-kit -->
        <script src="<?php echo base_url(); ?>assets/frontend/js/purpose.core.js"></script>
        <!-- Page JS -->
        <script src="<?php echo base_url(); ?>assets/frontend/libs/swiper/dist/js/swiper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/frontend/libs/select2/dist/js/select2.min.js"></script>
        <?php
        if (isset($extjs)) {
            if (!empty($extjs)) {
                foreach ($extjs as $value) {
        ?>
                    <script src="<?php echo $value; ?>"></script>
        <?php   }
            }
        }
        ?>
        <?php
        if (isset($stripe)) {
            ?>
            <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <?php
        }
        if (isset($js)) {
            if (!empty($js)) {
                foreach ($js as $value) {
        ?>
                    <script src="<?php echo base_url(); ?>assets/frontend/<?php echo $value; ?>"></script>
        <?php   }
            }
        }
        ?>
        <!-- <script src="https://localhost/booking-management/Files/html/purpose-website-ui-kit-v2.0.1/assets/libs/flatpickr/dist/flatpickr.min.js"></script> -->
        <!-- Purpose JS -->
        <script src="<?php echo base_url(); ?>assets/frontend/js/purpose.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- Demo JS - remove it when starting your project -->
        <!-- <script src="<?php //echo base_url(); ?>assets/frontend/js/demo.js"></script> -->
        <script src="<?php echo base_url(); ?>assets/frontend/js/custom-js.js"></script>
        <script src="<?php echo base_url(); ?>assets/frontend/js/search.js"></script>
        <script type="text/javascript">
        </script>
    </body>
</html>