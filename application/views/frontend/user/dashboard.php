<?php
$company_name = $company_address = $about_company = '';
$company_logo = FILEPATH . 'img/default/no-image.png';
if (!empty($company)) {
$company_name = $company->company_name;
$company_address = $company->company_address;
$about_company = $company->about_company;
$company_logo = (!empty($company->company_logo)) ? UPLOADPATH . 'business/logo/thumb/' . $company->company_logo : $company_logo;
}
?>
<div class="main-content dashboard-page">
  <!-- Header (account) -->
  <section class="header-account-page bg-primary d-flex align-items-end" data-offset-top="#header-main">
    <!-- Header container -->
    <div class="container pt-4 pt-lg-0">
      <div class="row">
        <div class=" col-lg-12">
          <!-- Salute + Small stats -->
          <?php 
            $data['user'] = $user;
            $this->load->view('frontend/layout/account_heaer', $data); 
          ?>
          <!-- Account navigation -->
          <div class="d-flex">
            <a href="<?php echo base_url('user/dashboard'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Dashboard</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="slice">
    <div class="container">
      <div class="row row-grid">
        <?php if ($this->session->flashdata('msg_error')) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
        </div>
        <?php } else if ($this->session->flashdata('msg_success')) { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
        </div>
        <?php } ?>
        <div class="col-lg-6 order-lg-2 gr1">
          
          <!-- <section class="content">
            <div class="row"> -->
              <?php
              /*if (!empty($categories)) {
                foreach ($categories as $value) {
              ?>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                  <a href="javascript:void(0)">
                    <span class="info-box-icon bg-primary"><i class="fa fa-briefcase" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text"><?php echo $value->name; ?></span>
                    </div>
                  </a>
                </div>
              </div>
              <?php
                }
              }*/
              ?>
              <!-- <div class="col-lg-6"> -->
              <div class="header">
                <h2 class="title"></h2>
                <div class="act">
                  <button type="button" class="btn print"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                  <button type="button" class="btn jpg"><i class="fa fa-file-image" aria-hidden="true"></i> Save as JPEG</button>
                  <button type="button" class="btn png"><i class="fa fa-file-image" aria-hidden="true"></i> Save as PNG</button>
                </div>
              </div>
              <div class="graph-container">
                <div class="gr-title"></div>
                <div class="graph" id="graph1"></div>
                <div class="hd-tr"></div>
              </div>
              <!-- </div> -->
            <!-- </div>
          </section -->
        </div>
        <div class="col-lg-6 order-lg-2 gr2" style="display: none;">
          <div class="header">
            <h2 class="title"></h2>
            <div class="act">
              <button type="button" class="btn print"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
              <button type="button" class="btn jpg"><i class="fa fa-file-image" aria-hidden="true"></i> Save as JPEG</button>
              <button type="button" class="btn png"><i class="fa fa-file-image" aria-hidden="true"></i> Save as PNG</button>
            </div>
          </div>
          <div class="graph-container">
            <div class="gr-title"></div>
            <div class="graph" id="graph2"></div>
            <div class="hd-tr"></div>
          </div>
        </div>
        <?php /* ?>
        <div class="col-lg-3 order-lg-1">
          <?php $this->load->view('frontend/user/profile-left-panel'); ?>
        </div><?php */ ?>
      </div>
    </div>
  </section>
</div>