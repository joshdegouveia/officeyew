<?php
$social_links = array('fb' => 'javascript:void(0)', 'twit' => 'javascript:void(0)', 'insta' => 'javascript:void(0)', 'link' => 'javascript:void(0)');
$social_links_arr = getSocialLinks();
  if (!empty($social_links_arr)) {
    foreach ($social_links_arr as $value) {
      switch ($value->type) {
          case 'facebook':
              $social_links['fb'] = $value->value;
              break;
          case 'insta':
              $social_links['insta'] = $value->value;
              break;
          case 'tweet':
              $social_links['twit'] = $value->value;
              break;
          case 'linkedin':
              $social_links['link'] = $value->value;
              break;
      }
  }
}
$menu_links = getMenuLinks();
?>
<footer id="footer-main">
            <div class="footer footer-dark bg-gradient-primary footer-rotate">
                <div class="container">
                    <div class="row pt-md">
                        <?php
                        if (!empty($menu_links)) {
                            $prev_menu = $menu_links[0]->menu_id;
                        ?>
                        <div class="col-lg-3 col-6 col-sm-3 mb-5 mb-lg-0">
                            <h6 class="heading mb-3"><?php echo $menu_links[0]->menu_name; ?></h6>
                            <ul class="list-unstyled">
                        <?php
                            foreach ($menu_links as $value) {
                                $link = (!empty($value->link)) ? $value->link : 'javascript:void(0)';
                                if ($prev_menu != $value->menu_id) {
                                    $prev_menu = $value->menu_id;
                        ?>
                        </ul>
                        </div>
                        <div class="col-lg-3 col-6 col-sm-3 mb-5 mb-lg-0">
                            <h6 class="heading mb-3"><?php echo $value->menu_name; ?></h6>
                            <ul class="list-unstyled">
                                <?php } ?>
                                <li><a href="<?php echo $link; ?>"><?php echo $value->name; ?></a></li>
                        <?php } ?>
                        </ul>
                        </div>
                        <?php } ?>
                        <?php /* ?>
                        <div class="col-lg-3 col-6 col-sm-3 mb-5 mb-lg-0">
                            <h6 class="heading mb-3">Sponsa</h6>
                            <ul class="list-unstyled">
                                <li><a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
                                <li><a href="<?php echo base_url('terms-condition'); ?>">Terms & Conditions</a></li>
                                <li><a href="javascript:void(0)">Career</a></li>
                                <li><a href="javascript:void(0)">News</a></li>
                                <li><a href="<?php echo base_url('faq'); ?>">FAQ</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-6 col-sm-3 mb-5 mb-lg-0">
                            <h6 class="heading mb-3">Why & How</h6>
                            <ul class="list-unstyled">
                                <li><a href="javascript:void(0)">Why Endorse</a></li>
                                <li><a href="javascript:void(0)">How it Works</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-6 col-sm-3 mb-5 mb-lg-0">
                            <h6 class="heading mb-3">Support</h6>
                            <ul class="list-unstyled text-small">
                                <li><a href="<?php echo base_url('privacy-policy'); ?>">Privacy</a></li>
                                <li><a href="<?php echo base_url('contactus'); ?>">Contact</a></li>
                                <li><a href="<?php echo base_url('support'); ?>">Support</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-sm-3 mb-5 mb-lg-0">
                            <h6 class="heading mb-3">Social</h6>
                            <ul class="list-unstyled">
                                <li><a href="<?php echo $social_links['fb']; ?>" target="_blank">Facebook</a></li>
                                <li><a href="<?php echo $social_links['insta']; ?>" target="_blank">Instagram</a></li>
                                
                            </ul>
                        </div><?php */ ?>
                    </div>
                    <div class="row align-items-center justify-content-md-between py-4 mt-4 delimiter-top">
                        <div class="col-md-6">
                            <div class="copyright text-sm font-weight-bold text-center text-md-left">
                                <!-- &copy; 2018-2019 <a href="https://webpixels.io" class="font-weight-bold" target="_blank">Webpixels</a>. All rights reserved. -->
                                <?php echo $home_page_setting['footer_copy_right']; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $social_links['insta']; ?>" target="_blank">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $social_links['fb']; ?>" target="_blank">
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