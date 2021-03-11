<style>
.section-rotate{padding-top: 180px !important;}
</style>
<div class="main-content home-page">
  <!-- Header (v1) -->
  <section class="header-1 section-rotate bg-section-secondary" data-offset-top="#header-main">
    <div class="section-inner bg-gradient-primary"></div>
    <!-- SVG illustration -->
    <!-- <div class="pt-7 position-absolute middle right-0 col-lg-7 col-xl-6 d-none d-lg-block">
      <figure class="w-100" style="max-width: 1000px;">
        <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/svg/illustrations/work-chat.svg" class="svg-inject img-fluid" style="height: 1000px;">
      </figure>
    </div> -->
    <!-- SVG background -->
    <!-- <div class="bg-absolute-cover bg-size--contain d-flex align-items-center">
      <figure class="w-100 d-none d-lg-block">
        <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/svg/backgrounds/bg-4.svg" class="svg-inject" style="height: 1000px;">
      </figure>
    </div> -->
    <!-- Hero container -->
    <div style="padding-left: 0px;" class="container d-flex align-items-center position-relative zindex-100">
      <div class="col home_headding_contener">
        <?php if ($this->session->flashdata('msg_error')) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
        </div>
        <?php } else if ($this->session->flashdata('msg_success')) { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
        </div>
        <?php } ?>
        <div class="row">
          <div class="col-lg-5 col-xl-6 text-center text-lg-left home_headding_contener">
            <!-- <div class="d-none d-lg-block mb-4">
              <div class="alert alert-modern alert-dark">
                <span class="badge badge-danger badge-pill">
                  Hot
                </span>
                <span class="alert-content">Dark mode, awesome shortcode library and more.</span>
              </div>
            </div> -->
            <div>
              <h2 class="text-white mb-4">
              <span class="display-4 font-weight-light"><?php echo $home_page_setting['first_heading']; ?></span>
              <span class="d-block"><?php echo $home_page_setting['second_heading']; ?></span>
              </h2>
              <p class="lead text-white"><?php echo $home_page_setting['summary']; ?></p>
              <div class="mt-5">
                <a href="<?php echo $home_page_setting['first_button_link']; ?>" class="btn btn-white rounded-pill hover-translate-y-n3 btn-icon mr-sm-4 scroll-me">
                  <span class="btn-inner--text"><?php echo $home_page_setting['first_button_title']; ?></span>
                  <span class="btn-inner--icon"><i class="fas fa-angle-right"></i></span>
                </a>
                <a href="<?php echo $home_page_setting['second_button_link']; ?>" class="btn btn-outline-white rounded-pill hover-translate-y-n3 btn-icon d-xl-inline-block scroll-me">
                  <span class="btn-inner--icon"><i class="fas fa-file-alt"></i></span>
                  <span class="btn-inner--text"><?php echo $home_page_setting['second_button_title']; ?></span>
                </a>
              </div>
            </div>
          </div>
          <?php if (empty($user)) { ?>
          <div class="col-lg-5 col-xl-6 text-center text-lg-left">
            <div class="register-form">
              <div class="text-center">
                <?php echo $home_page_setting['register_form_heading_content']; ?>
                <!-- <h6 class="h3">Signup</h6>
                <p class="text-muted mb-0">Start with us and enjoy the life.</p> -->
                <?php if ($this->session->flashdata('msg_email_error')) { ?>
                <p>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <strong><?php echo $this->session->flashdata('msg_email_error'); ?></strong>
                  </div>
                  <?php } ?>
                </p>
              </div>
              <span class="clearfix"></span>
              <form role="form" method="post" action="" id="register_form">
                <!-- <div class="form-group">
                  <label class="form-control-label">Type</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                    </div>
                    <select name="type" id="type" class="form-control">
                      <option value="<?php //echo CUSTOMER; ?>">Customer</option>
                      <option value="<?php //echo SELLER; ?>">Reseller</option>
                      <option value="<?php //echo B2B; ?>">B2B</option>
                    </select>
                  </div>
                </div> -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label">Full Name</label>
                      <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" value="<?php echo set_value('first_name');?>" class="form-control" name="first_name" id="first_name" placeholder="John" required>
                      </div>
                      <p><?php echo form_error('first_name');?></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label">Email address</label>
                      <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" value="<?php echo set_value('email');?>" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                      </div>
                      <p><?php echo form_error('email');?></p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label">Phone Number</label>
                      <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" value="<?php echo set_value('phone');?>" class="form-control" name="phone" id="phone" placeholder="9876543210" required>
                      </div>
                      <p><?php echo form_error('phone');?></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-4">
                      <label class="form-control-label">Password</label>
                      <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" name="password" id="password" placeholder="********" required>
                        <div class="input-group-append">
                          <span class="input-group-text pwdsh">
                            <i class="fa fa-eye"></i>
                          </span>
                        </div>
                      </div>
                      <p><?php echo form_error('password');?></p>
                    </div>
                  </div>
                </div>
                
                <?php /*
                <div class="form-group">
                  <label class="form-control-label">Last Name</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" value="<?php echo set_value('last_name');?>" class="form-control" name="last_name" id="last_name" placeholder="Doe" required>
                  </div>
                  <p><?php echo form_error('last_name');?></p>
                </div> */ ?>
                <div class="my-1">
                  <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="check-terms" name="terms" required>
                    <label class="custom-control-label" for="check-terms">I agree to the <a href="<?php echo base_url('terms-condition'); ?>" target="_blank">terms and conditions</a> and <a href="<?php echo base_url('privacy-policy'); ?>" target="_blank">privacy policy</a></label>
                    <p><?php echo form_error('terms');?></p>

                  </div>
                  <?php /*
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="check-privacy" name="privacy" required>
                    <label class="custom-control-label" for="check-privacy">I agree to the <a href="<?php echo base_url('privacy-policy'); ?>" target="_blank">privacy policy</a></label>
                  </div>
                  <p><?php echo form_error('privacy');?></p>
                  */ ?>
                </div>
                <div class="mt-1">
                <button type="submit" class="btn btn-block btn-primary">Create my account</button></div>
              </form>
              <div class="mt-1 text-center"><small>Already have an account?</small>
                <a href="#" class="small font-weight-bold">Sign in</a>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>
  <!-- Features (v1) -->
  <!-- Features (v2) -->
  <section class="slice slice-lg">
    <div class="container">
      <div class="row row-grid justify-content-around align-items-center">
        <div class="col-lg-5 order-lg-2">
          <div class=" pr-lg-4">
            <?php echo $home_page_setting['store_section_content']; ?>
            <!-- <h5 class=" h3">Change the way you build wesites. Forever.</h5>
            <p class="lead mt-4 mb-5">With Purpose you get components and examples, including tons of variables that will help you customize this theme with ease.</p>
            <a href="https://themes.getbootstrap.com/product/purpose-website-ui-kit/" class="link link-underline-primary">Purchase now</a> -->
          </div>
        </div>
        <?php
        $store_image = base_url('assets/frontend/img/theme/light/presentation-1.png');
        if (!empty($home_page_setting['store_section_image'])) {
          $store_image = UPLOADPATH . 'setting/home_page_setting/' . $home_page_setting['store_section_image'];
        }
        ?>
        <div class="col-lg-6 order-lg-1">
          <img alt="Image placeholder" src="<?php echo $store_image; ?>" class="img-fluid img-center">
        </div>
      </div>
    </div>
  </section>
  <!-- Features (v3) -->
  <section id="howitsWork" class="slice slice-lg">
    <div class="container">
      <div class="row row-grid justify-content-around align-items-center">
        <div class="col-lg-5">
          <div class="">
            <?php echo $home_page_setting['app_section_content']; ?>
            <?php /* ?>
            <h5 class=" h3">Welcome to Yulo</h5>
            <p class="lead my-4">With Purpose you get components and examples, including tons of variables that will help you customize this theme with ease.</p>
            <ul class="list-unstyled">
              <li class="py-2">
                <div class="d-flex align-items-center">
                  <div>
                    <div class="icon icon-shape icon-primary icon-sm rounded-circle mr-3">
                      <i class="fas fa-store-alt"></i>
                    </div>
                  </div>
                  <div>
                    <span class="h6 mb-0">Perfect for modern startups</span>
                  </div>
                </div>
              </li>
              <li class="py-2">
                <div class="d-flex align-items-center">
                  <div>
                    <div class="icon icon-shape icon-warning icon-sm rounded-circle mr-3">
                      <i class="fas fa-palette"></i>
                    </div>
                  </div>
                  <div>
                    <span class="h6 mb-0">Built with customization and ease-of-use at its core</span>
                  </div>
                </div>
              </li>
              <li class="py-2">
                <div class="d-flex align-items-center">
                  <div>
                    <div class="icon icon-shape icon-success icon-sm rounded-circle mr-3">
                      <i class="fas fa-cog"></i>
                    </div>
                  </div>
                  <div>
                    <span class="h6 mb-0">Quality design and thoughfully crafted code</span>
                  </div>
                </div>
              </li>
            </ul><?php */ ?>
          </div>
        </div>
        <?php
        $app_image = base_url('assets/frontend/img/theme/light/presentation-2.png');
        if (!empty($home_page_setting['store_section_image'])) {
          $app_image = UPLOADPATH . 'setting/home_page_setting/' . $home_page_setting['app_section_image'];
        }
        ?>
        <div class="col-lg-6">
          <img alt="Image placeholder" src="<?php echo $app_image; ?>" class="img-fluid img-center">
        </div>
      </div>
    </div>
  </section>
  <!-- Features (v4) -->
  <?php /* ?>
  <section class="slice slice-lg bg-section-secondary overflow-hidden">
    <div class="bg-absolute-cover bg-size--contain d-flex align-items-center">
      <figure class="w-100">
        <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/svg/backgrounds/bg-2.svg" class="svg-inject" style="height: 1000px;">
      </figure>
    </div>
    <div class="container position-relative zindex-100">
      <div class="mb-5 px-3 text-center">
        <span class="badge badge-soft-success badge-pill badge-lg">
          Build tools
        </span>
        <h3 class=" mt-4">Built for awesomeness</h3>
        <div class="fluid-paragraph mt-3">
          <p class="lead lh-180">We use the latest technologies and tools in order to create a better code that not only works great, but it is easy easy to work with too.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="card px-3">
            <div class="card-body py-5">
              <div class="d-flex align-items-center">
                <div class="icon bg-gradient-primary text-white rounded-circle icon-shape shadow-primary">
                  <i class="fab fa-html5"></i>
                </div>
                <div class="icon-text pl-4">
                  <h5 class="mb-0">Created with the latest technologies</h5>
                </div>
              </div>
              <p class="mt-4 mb-0">We use the latest technologies and tools in order to create a better code that not only works great, but it is easy easy to work with too.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card px-3">
            <div class="card-body py-5">
              <div class="d-flex align-items-center">
                <div class="icon bg-gradient-warning text-white rounded-circle icon-shape shadow-warning">
                  <i class="fab fa-node-js"></i>
                </div>
                <div class="icon-text pl-4">
                  <h5 class="mb-0">Built by developers for developers</h5>
                </div>
              </div>
              <p class="mt-4 mb-0">You don't only need a theme, but also great tools in order to ease the process or building and customizing. And this is exactly what we offer you.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card px-3">
            <div class="card-body py-5">
              <div class="d-flex align-items-center">
                <div class="icon bg-gradient-info text-white rounded-circle icon-shape shadow-info">
                  <i class="fas fa-thumbs-up"></i>
                </div>
                <div class="icon-text pl-4">
                  <h5 class="mb-0">Made for great first impressions</h5>
                </div>
              </div>
              <p class="mt-4 mb-0">is lighter and faster than most of the themes out there which means you get more for less. Check out the components and examples pages.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><?php */ ?>
  <!-- Features (v5) -->
  <section class="slice slice-xl has-floating-items bg-gradient-primary" id=sct-call-to-action>
    <a href="#sct-call-to-action" class="tongue tongue-up tongue-section-secondary" data-scroll-to>
      <i class="fas fa-angle-up"></i>
    </a>
    <div class="container text-center">
      <div class="row">
        <div class="col-12">
          <h1 class="text-white"><?php echo $home_page_setting['about_section_title']; ?></h1>
          <div class="row justify-content-center mt-4">
            <div class="col-lg-8 mb-4">
              <div class="lead text-white">
                <?php echo $home_page_setting['about_section_sub_heading']; ?>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-6">
                <?php
                  $about_image = base_url('assets/frontend/img/theme/light/presentation-2.png');
                  if (!empty($home_page_setting['about_section_image'])) {
                    $about_image = UPLOADPATH . 'setting/home_page_setting/' . $home_page_setting['about_section_image'];
                  }
                  ?>
                  <img style="width:100%;height:auto;max-width:535px;max-height:500px;padding-bottom:10px;" alt="Image placeholder" src="<?php echo $about_image; ?>" class="img-fluid img-center">
                </div>
                  
                <div class="col-lg-6 text-white">
                  <?php //echo $home_page_setting['about_section_image']; ?>
                  <?php echo $home_page_setting['about_application_section']; ?>
                </div>
              </div>
              <!-- <p class="lead text-white">
                Purpose is a great premium UI package including all the important and needed features so you can jumpstart the hard work and get right to the website creation fast and easy with more than 100 customized Bootstrap components and 15+ integrated plugins.
              </p> -->
              <div class="btn-container mt-5">
                <a href="<?php echo $home_page_setting['about_section_link']; ?>" class="btn btn-dark rounded-pill btn-icon hover-translate-y-n3 mb-4 mb-md-0">
                  <span class="btn-inner--icon">
                    <i class="fas fa-shopping-basket"></i>
                  </span>
                  <span class="btn-inner--text">More</span>
                </a>
                <!-- <a href="https://themes.getbootstrap.com/product/purpose-website-ui-kit/" class="btn btn-dark rounded-pill btn-icon hover-translate-y-n3 mb-4 mb-md-0">
                  <span class="btn-inner--icon">
                    <i class="fas fa-shopping-basket"></i>
                  </span>
                  <span class="btn-inner--text">Purchase now</span>
                </a>
                <a href="docs/index.html" class="btn btn-white rounded-pill btn-icon hover-translate-y-n3">
                  <span class="btn-inner--icon">
                    <i class="fas fa-book"></i>
                  </span>
                  <span class="btn-inner--text">Read the Docs</span>
                </a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container floating-items">
      <?php
      if (!empty($ficons)) {
        foreach ($ficons as $value) {
          if (!file_exists(UPLOADDIR . 'setting/home_page_ficons/' . $value->filename)) {
            continue;
          }
          $image = UPLOADPATH . 'setting/home_page_ficons/' . $value->filename;
      ?>
      <div class="icon-floating bg-white floating">
        <span></span>
        <img alt="Image placeholder" src="<?php echo $image; ?>" class="svg-inject">
      </div>
      <?php
        }
      }
      ?>
      <?php /* ?>
      <div class="icon-floating bg-white floating">
        <span></span>
        <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/icons/essential/detailed/Apps.svg" class="svg-inject">
      </div>
      <div class="icon-floating icon-lg bg-white floating">
        <span></span>
        <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/icons/essential/detailed/Apple.svg" class="svg-inject">
      </div>
      <div class="icon-floating icon-sm bg-white floating">
        <span></span>
        <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/icons/essential/detailed/Ballance.svg" class="svg-inject">
      </div>
      <div class="icon-floating icon-lg bg-white floating">
        <span></span>
        <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/icons/essential/detailed/Book.svg" class="svg-inject">
      </div>
      <div class="icon-floating bg-white floating">
        <span></span>
        <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/icons/essential/detailed/Chat.svg" class="svg-inject">
      </div>
      <div class="icon-floating icon-sm bg-white floating">
        <span></span>
        <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/icons/essential/detailed/Coffee.svg" class="svg-inject">
      </div><?php */ ?>
    </div>
  </section>
  <?php if ($home_page_setting['show_review_section'] == 'yes') { ?>
  <!-- Testimonials (v1) -->
  <section class="slice slice-lg bg-section-secondary">
    <div class="container">
      <div class="mb-5 text-center">
        <h3 class=" mt-4"><?php echo $home_page_setting['customer_review_title']; ?></h3>
        <div class="fluid-paragraph mt-3">
          <p class="lead lh-180"><?php echo $home_page_setting['customer_review_section']; ?></p>
          <!-- <p class="lead lh-180">Start building fast, beautiful and modern looking websites in no time using our theme.</p> -->
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-11">
          <div class="swiper-js-container overflow-hidden">
            <div class="swiper-container" data-swiper-items="1" data-swiper-space-between="0" data-swiper-sm-items="2" data-swiper-xl-items="3">
              <div class="swiper-wrapper">
                <?php
                if (!empty($testimonials)) {
                  foreach ($testimonials as $value) {
                    $image = FILEPATH . 'img/default/no-image.png';
                    if (!empty($value->filename) && file_exists(UPLOADDIR . 'setting/home_page_testimonials/' . $value->filename)) {
                      $image = UPLOADPATH . 'setting/home_page_testimonials/' . $value->filename;
                    }
                ?>
                <div class="swiper-slide p-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div>
                          <img alt="Image placeholder" src="<?php echo $image; ?>" class="avatar rounded-circle">
                        </div>
                        <div class="pl-3">
                          <h5 class="h6 mb-0"><?php echo $value->name; ?></h5>
                          <small class="d-block text-muted"><?php echo $value->tag; ?></small>
                        </div>
                      </div>
                      <p class="mt-4 lh-180"><?php echo $value->description; ?></p>
                      <span class="static-rating static-rating-sm">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                          $voted = '';
                          if ($i <= $value->rating) {
                            $voted = 'voted';
                          }
                        ?>
                        <i class="star fas fa-star <?php echo $voted; ?>"></i>
                        <?php } ?>
                      </span>
                    </div>
                  </div>
                </div>
                <?php
                  }
                }
                ?>
                <?php /* ?>
                <div class="swiper-slide p-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div>
                          <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/theme/light/team-2-800x800.jpg" class="avatar  rounded-circle">
                        </div>
                        <div class="pl-3">
                          <h5 class="h6 mb-0">Monroe Parker</h5>
                          <small class="d-block text-muted">Apple</small>
                        </div>
                      </div>
                      <p class="mt-4 lh-180">Amazing template! All-in-one, clean code, beautiful design, and really not hard to work with.Highly recommended for any kind on website.</p>
                      <span class="static-rating static-rating-sm">
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide p-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div>
                          <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/theme/light/team-3-800x800.jpg" class="avatar  rounded-circle">
                        </div>
                        <div class="pl-3">
                          <h5 class="h6 mb-0">John Sullivan</h5>
                          <small class="d-block text-muted">Amazon</small>
                        </div>
                      </div>
                      <p class="mt-4 lh-180">Amazing template! All-in-one, clean code, beautiful design, and really not hard to work with.Highly recommended for any kind on website.</p>
                      <span class="static-rating static-rating-sm">
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide p-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div>
                          <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/theme/light/team-4-800x800.jpg" class="avatar  rounded-circle">
                        </div>
                        <div class="pl-3">
                          <h5 class="h6 mb-0">James Lewis</h5>
                          <small class="d-block text-muted">Google</small>
                        </div>
                      </div>
                      <p class="mt-4 lh-180">Amazing template! All-in-one, clean code, beautiful design, and really not hard to work with.Highly recommended for any kind on website.</p>
                      <span class="static-rating static-rating-sm">
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide p-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div>
                          <img alt="Image placeholder" src="<?php echo base_url(); ?>assets/frontend/img/theme/light/team-5-800x800.jpg" class="avatar  rounded-circle">
                        </div>
                        <div class="pl-3">
                          <h5 class="h6 mb-0">Julia Howe</h5>
                          <small class="d-block text-muted">Google</small>
                        </div>
                      </div>
                      <p class="mt-4 lh-180">Amazing template! All-in-one, clean code, beautiful design, and really not hard to work with.Highly recommended for any kind on website.</p>
                      <span class="static-rating static-rating-sm">
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                        <i class="star fas fa-star voted"></i>
                      </span>
                    </div>
                  </div>
                </div><?php */ ?>
              </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination w-100 mt-4 d-flex align-items-center justify-content-center"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php } ?>
  <!-- Features (v7) -->
  <?php /* ?>
  <section class="slice slice-lg">
    <div class="container">
      <div class="mb-5 text-center">
        <h3 class=" mt-4">Really useful features</h3>
        <div class="fluid-paragraph mt-3">
          <p class="lead lh-180">You get all Bootstrap components fully customized. Besides, you receive another numerous plugins out of the box and ready to use.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fab fa-twitter"></i>
              </div>
            </div>
            <h5 class="">Latest Bootstrap</h5>
            <p class=" mt-2 mb-0">A responsive and mobile-first theme built with the world's most popular component library.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fab fa-sass"></i>
              </div>
            </div>
            <h5 class="">Built with Sass</h5>
            <p class=" mt-2 mb-0">Change one variable and the theme adapts. Colors, fonts, sizes ... you name it.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fas fa-layer-group"></i>
              </div>
            </div>
            <h5 class="">700+ Components</h5>
            <p class=" mt-2 mb-0">Nicely customized components that can be reused anytime and anywhere in your project.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fas fa-puzzle-piece"></i>
              </div>
            </div>
            <h5 class="">Everything is modular</h5>
            <p class=" mt-2 mb-0">Nicely customized components that can be reused anytime and anywhere in your project.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fas fa-tint"></i>
              </div>
            </div>
            <h5 class="">Extended color palette</h5>
            <p class=" mt-2 mb-0">A beautiful color palette that can be easily modified with our nicely coded Sass files.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fas fa-code"></i>
              </div>
            </div>
            <h5 class="">15+ integrated plugins</h5>
            <p class=" mt-2 mb-0">More functionality with the ready to use plugins we have integrated in this theme for you.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fas fa-font"></i>
              </div>
            </div>
            <h5 class="">1500 vector icons</h5>
            <p class=" mt-2 mb-0">One nice collection of icons so you can add a more intuitive and playful touch to your website.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fas fa-grimace"></i>
              </div>
            </div>
            <h5 class="">SVG illustrations</h5>
            <p class=" mt-2 mb-0">One nice collection of icons so you can add a more intuitive and playful touch to your website.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fab fa-twitter"></i>
              </div>
            </div>
            <h5 class="">Latest Bootstrap</h5>
            <p class=" mt-2 mb-0">A responsive and mobile-first theme built with the world's most popular component library.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fab fa-sass"></i>
              </div>
            </div>
            <h5 class="">Built with Sass</h5>
            <p class=" mt-2 mb-0">Change one variable and the theme adapts. Colors, fonts, sizes ... you name it.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fas fa-layer-group"></i>
              </div>
            </div>
            <h5 class="">700+ Components</h5>
            <p class=" mt-2 mb-0">Nicely customized components that can be reused anytime and anywhere in your project.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="mb-4">
            <div class="py-5">
              <div class="icon text-primary">
                <i class="fas fa-puzzle-piece"></i>
              </div>
            </div>
            <h5 class="">Everything is modular</h5>
            <p class=" mt-2 mb-0">Nicely customized components that can be reused anytime and anywhere in your project.</p>
          </div>
        </div>
      </div>
    </div>
  </section><?php */ ?>
  <!-- Call to action (v10) -->
  <!-- <section class="slice slice-lg">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="card bg-gradient-dark shadow hover-shadow-lg border-0 position-relative zindex-100">
            <div class="card-body py-5">
              <div class="d-flex align-items-start">
                <div class="icon">
                  <i class="fas fa-file-alt text-white"></i>
                </div>
                <div class="icon-text">
                  <h3 class="text-white h4">70+ example pages</h3>
                  <p class="text-white mb-0">You get 70+ pre-built pages for a variety of purposes that makes it the ideal point to start building websites of any kind.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card bg-primary shadow hover-shadow-lg border-0 position-relative zindex-100">
            <div class="card-body py-5">
              <div class="d-flex align-items-start">
                <div class="icon text-white">
                  <i class="fas fa-question-circle"></i>
                </div>
                <div class="icon-text">
                  <h5 class="h4 text-white">6 months technical support</h5>
                  <p class="mb-0 text-white">Use our dedicated support email to send your issues or suggestions. We are here to help anytime: <strong>support@webpixels.io</strong></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>-->
</div>