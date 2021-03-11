<div class="main-content">
    <section class="slice slice-lg delimiter-bottom bg-primary" id="sct-products">
      <!--for menue backgroung color -->
    </section>
    <section class="slice slice-xl mh-100vh d-flex align-items-center" data-offset-top="#header-main">
      <!-- SVG background -->
      <div class="bg-absolute-cover bg-size--contain d-flex align-items-center">
        <figure class="w-100 px-4">
          <img alt="Image placeholder" src="<?php echo FILEPATH.'img/svg/backgrounds/bg-3.svg'?>" class="svg-inject">
        </figure>
      </div>
      <div class="container pt-6 position-relative zindex-100">
        <div class="row justify-content-center">
          <div class="col-lg-7">
          <?php if ($this->session->flashdata('msg_error')) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
            </div>
            <?php } else if ($this->session->flashdata('msg_success')) { ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
            </div>
            <?php } ?>
            <div class="text-center">
              <!-- SVG illustration -->
              <div class="row justify-content-center mb-5">
                <div class="col-md-5">
                  <img alt="Image placeholder" src="<?php echo FILEPATH.'img/svg/illustrations/online-shopping.svg'?>" class="svg-inject img-fluid">
                </div>
              </div>
              <!-- Empty cart container -->
              <h6 class="h4 my-4">Your cart is empty.</h6>
              <p class="px-md-5">
                Your cart is currently empty. Return to our shop and check out the latest offers.
                We have some great items that are waiting for you.
              </p>
              <a href="<?php echo base_url('products');?>" class="btn btn-sm btn-primary btn-icon rounded-pill mt-5">
                <span class="btn-inner--icon"><i class="fas fa-angle-left"></i></span>
                <span class="btn-inner--text">Return to shop</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>