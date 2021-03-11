<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php if (!empty($meta_data)) { ?>
    <meta name="description" content="<?php echo $meta_data->meta_description; ?>">
    <meta name="key" content="<?php echo $meta_data->meta_key; ?>">
    <?php } ?>
    <meta name="author" content="Webpixels">
    <title><?php echo (isset($title) ? ucwords($title) . ' | ' : '') . SITE_NAME; ?></title>
    <!-- Favicon -->
    <link rel="icon" href="<?php echo FILEPATH; ?>img/default/favicon.ico" type="image/png">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <!-- <link rel="icon" type="image/png" sizes="32x32" href="https://imba-exchange.co/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://imba-exchange.co/favicon-16x16.png"> -->
    <link rel="manifest" href="<?php echo base_url('manifest.json'); ?>">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#da532c">
    <meta name="apple-mobile-web-app-title" content="<?php echo SITE_NAME; ?>">
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/libs/@fortawesome/fontawesome-free/css/all.min.css"><!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/libs/swiper/dist/css/swiper.min.css">
    <!-- Purpose CSS -->
    <?php
    if (isset($css)) {
        if (!empty($css)) {
            foreach ($css as $value) {
    ?>
      <link rel="stylesheet" href="<?php echo base_url('assets/frontend/' . $value); ?>" rel="stylesheet" type="text/css">
    <?php   }
        }
    }
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/libs/select2/dist/css/select2.min.css" id="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/purpose.css" id="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/style.css" id="stylesheet">
    <script type="text/javascript">
      var base_url = '<?php echo base_url(); ?>';
      var FILEPATH = '<?php echo FILEPATH; ?>';
      var UPLOADPATH = '<?php echo UPLOADPATH; ?>';
    </script>
  </head>
  <body>
    <div class="overlay"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>
    <header class="header header-transparent" id="header-main">
      <!-- Topbar -->
      <div id="navbar-top-main" class="navbar-top  navbar-dark bg-dark border-bottom">
        <div class="container px-0">
          <div class="navbar-nav align-items-center">
            <div class="d-none d-lg-inline-block">
              <?php
              $show_business_menu = true;
              $show_seller_menu = false;
              $endorse_link = '';
              $is_customer_user = false;
              if (!empty($user)) {
                $show_business_menu = false;
                if ($user['type'] != B2B) {
                  $endorse_link = base_url('business/brands'); 
                }
                if ($user['type'] != SELLER) {
                  $show_seller_menu = true;
                }
                if ($user['type'] == CUSTOMER) {
                  $is_customer_user = true;
                }
              } else{
                $endorse_link = base_url('why-endorse');
                $is_customer_user = true;
              }
              ?>
              <!-- Main navbar  base_url('business/brands');  https://mydevfactory.com/~mywork/booking-management/why-endorse -->
              <nav class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-dark bg-dark" id="navbar-main">
                <div class="container px-lg-0">
                  <!-- Logo -->
                  <a class="navbar-brand mr-lg-5" href="<?php echo base_url(); ?>">
                    <?php
                    $logo = base_url('assets/frontend/img/default/logo.png');
                    if ($site_setting->site_logo) {
                    $logo = UPLOADPATH . 'default/logo/' . $site_setting->site_logo;
                    }
                    ?>
                    <img alt="Image placeholder" src="<?php echo $logo; ?>" id="navbar-logo" >
                  </a>
                  <!-- Navbar collapse trigger -->
                  <button class="navbar-toggler pr-0" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                  </button>
                </div>
              </nav>
            </div>
            
            <div class="ml-auto">
              <ul class="nav menu-topr ebmnu">
                <?php if (!empty($endorse_link)) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $endorse_link ; ?>">Endorse</a>
                </li>
                <?php } ?>
                <?php if ($show_business_menu) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('business'); ?>">Businesses</a>
                </li>
                <?php } ?>
              </ul>
              <?php if (!empty($user)) { ?>
                <?php if ($user['type'] == B2B) { ?>
                <?php $this->load->view('frontend/business/header_menu'); ?>
                <?php } else if ($user['type'] == SELLER) { ?>
                <?php $this->load->view('frontend/seller/header_menu'); ?>
                <?php } else if ($user['type'] == CUSTOMER) { ?>
                <?php $this->load->view('frontend/user/header_menu'); ?>
                <?php } ?>
              <?php } else { ?>
              <?php } ?>

              <ul class="nav menu-topr">
                <?php /* ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $endorse_link ; ?>">Endorse</a>
                </li>
                <?php if ($show_business_menu) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('business'); ?>">Businesses</a>
                </li>
                <?php }*/ ?>
                <!-- <li class="nav-item">
                  <a class="nav-link" href="javascript:void(0)">Support</a>
                </li> -->
                <?php if (!empty($user)) { ?>
                <?php /* ?>
                <li class="nav-item dropdown">
                  <a class="nav-link pr-0" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <h6 class="dropdown-header">User menu</h6>
                    <a class="dropdown-item" href="<?php echo base_url('user/account'); ?>">
                      <i class="fas fa-user"></i>Account
                    </a>
                    <!-- <a class="dropdown-item" href="<?php echo base_url('user/messages'); ?>">
                      <span class="float-right badge badge-primary"></span>
                      <i class="fas fa-envelope"></i>Messages
                    </a> -->
                    <a class="dropdown-item" href="<?php echo base_url('user/settings'); ?>">
                      <i class="fas fa-cog"></i>Settings
                    </a>
                    <div class="dropdown-divider" role="presentation"></div>
                    <a class="dropdown-item sign-out" href="javascript:void(0)">
                      <i class="fas fa-sign-out-alt"></i>Sign out
                    </a>
                  </div>
                </li><?php */ ?>
                <li class="nav-item dropdown">
                  <a class="nav-link pr-0" href="<?php echo base_url('user/messages'); ?>" title="Messages">
                    <i class="fas fa-envelope"></i>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <div class="btn-group show notifications" role="group">
                    <a class="nav-link pr-0" href="javascript:void(0)" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="true" title="Notifications">
                      <i class="fas fa-info-circle"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow show" aria-labelledby="btn-group-settings" x-placement="bottom-end" style="position: absolute; left: -169px; top: 100%; display: none;"></div>
                  </div>
                  <span class="noti"></span>
                </li>

                <?php } else { ?>
                <li class="nav-item ">
                  <a class="nav-link bit_custom_menu_link1" href="<?php echo base_url('login/register'); ?>">Sign Up</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('login/signin'); ?>">Login</a>
                </li>
                <?php } ?>
                <li class="nav-item">
                  <div class="header-glob" title="Region">
                    <i class="fa fa-globe region-sel" aria-hidden="true"></i>
                    <!-- <span><i class="fa fa-arrow-down" aria-hidden="true"></i></span> -->
                    <?php
                    $region_nz_class = '';
                    $region_in_class = 'class="active"';
                    $current_country = (isset($_COOKIE['bm_rg'])) ? $_COOKIE['bm_rg'] : 'in';
                    if ($current_country == 'nz') {
                      $region_in_class = '';
                      $region_nz_class = 'class="active"';
                    }
                    ?>
                    <div class="region" style="display: none;">
                      <span data-val="in" <?php echo $region_in_class; ?>>India</span>
                      <span data-val="nz" <?php echo $region_nz_class; ?>>New Zealand</span>
                    </div>
                  </div>
                </li>
                <li class="nav-item">
                  <a href="javascript:void(0)" title="Search" class="nav-link" data-action="omnisearch-open" data-target="#omnisearch"><i class="fas fa-search"></i></a>
                </li>
                <?php if ($is_customer_user) { ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('products/cart');?>" title="Cart"><i class="fas fa-shopping-cart"></i></a>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="breadcrumb">
        <div class="container px-0">
          <?php //echo $breadcrumb; ?>
        </div>
      </div>
    </header>

    <!-- Omnisearch -->
    <div id="omnisearch" class="omnisearch">
      <div class="container">
        <!-- Search form -->
        <form class="omnisearch-form" action="<?php echo base_url('search/products'); ?>">
          <div class="form-group">
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
              </div>
              <input type="text" name="k" id="src_txt" class="form-control" placeholder="Type and hit enter ..." autocomplete="off">
              <div class="input-group-prepend adv-search">
                <a href="javascript:void(0)">Advanced Search</a>
              </div>
            </div>
          </div>
        </form>
        <div class="omnisearch-suggestions adv-search-container" style="display: none;">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Country</label>
                <select class="form-control" data-toggle="select" title="Country" data-live-search="true" data-live-search-placeholder="Country" name="scountry" id="scountry">
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">State</label>
                <select class="form-control" data-toggle="select" title="State" data-live-search="true" data-live-search-placeholder="State" name="sstate" id="sstate">
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">City</label>
                <select class="form-control" data-toggle="select" title="City" data-live-search="true" data-live-search-placeholder="City" name="scity" id="scity">
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group submit text-center">
                <label class="form-control-label"></label>
                <button class="btn btn-primary"> Search </button>
              </div>
            </div>
          </div>
        </div>
        <div class="omnisearch-suggestions product-sug-list" style="display: none;">
          <h6 class="heading">Search Suggestions</h6>
          <div class="row">
            <div class="col-sm-6">
              <ul class="list-unstyled mb-0">
                <?php /* ?>
                <li>
                  <a class="list-link" href="#">
                    <i class="fas fa-search"></i>
                    <span>macbook pro</span> in Laptops
                  </a>
                </li>
                <li>
                  <a class="list-link" href="#">
                    <i class="fas fa-search"></i>
                    <span>iphone 8</span> in Smartphones
                  </a>
                </li>
                <li>
                  <a class="list-link" href="#">
                    <i class="fas fa-search"></i>
                    <span>macbook pro</span> in Laptops
                  </a>
                </li>
                <li>
                  <a class="list-link" href="#">
                    <i class="fas fa-search"></i>
                    <span>beats pro solo 3</span> in Headphones
                  </a>
                </li>
                <li>
                  <a class="list-link" href="#">
                    <i class="fas fa-search"></i>
                    <span>smasung galaxy 10</span> in Phones
                  </a>
                </li><?php */ ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>