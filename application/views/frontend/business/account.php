<?php
$company_name = $company_address = $about_company = $endorse = $city = $state = $country = '';
$company_logo = FILEPATH . 'img/default/no-image.png';

if (!empty($company)) {
  $company_name = $company->company_name;
  $company_address = $company->company_address;
  $about_company = $company->about_company;
  $endorse = $company->endorse;
  $country = $company->country;
  $state = $company->state;
  $city = $company->city;
  $company_logo = (!empty($company->company_logo)) ? UPLOADPATH . 'business/logo/thumb/' . $company->company_logo : $company_logo;
}
?>
<div class="main-content account-page">
  <!-- Header (account) -->
  <section class="header-account-page bg-primary d-flex align-items-end" data-offset-top="#header-main">
    <!-- Header container -->
    <div class="container pt-4 pt-lg-0">
      <div class="row">
        <div class=" col-lg-12">
          <!-- Salute + Small stats -->
          <?php 
            $this->load->view('frontend/layout/account_heaer'); 
          ?>
          <!-- Account navigation -->
          <div class="d-flex">
            <a href="<?php echo base_url('business/profile'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Company Profile</span>
            </a>
            <?php //$this->load->view('frontend/business/header_menu'); ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="slice">
    <div class="container">
      <div class="row row-grid">
        <div class="col-lg-12 order-lg-2">
          <?php if ($this->session->flashdata('msg_error')) { ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
          </div>
          <?php } else if ($this->session->flashdata('msg_success')) { ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
          </div>
          <?php } ?>
          <!-- Change avatar -->
          <div class="card bg-gradient-warning hover-shadow-lg">
            <div class="card-body py-3">
              <div class="row row-grid align-items-center">
                <div class="col-lg-8">
                  <div class="media align-items-center">
                    <a href="javascript:void(0)" class="avatar avatar-lg rounded-circle mr-3">
                      <img alt="profile-image" src="<?php echo $company_logo; ?>">
                    </a>
                    <div class="media-body">
                      <h5 class="text-white mb-0"><?php echo $company_name; ?></h5>
                      <div>
                        <form method="post" enctype="multipart/form-data" id="profile_image_form" action="<?php echo base_url('business/profile'); ?>">
                          <input type="file" name="ufile" id="ufile" class="custom-input-file custom-input-file-link" accept="image/x-png,image/gif,image/jpeg" />
                          <label for="ufile">
                            <span class="text-white">Change Logo</span>
                          </label>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="col-auto flex-fill mt-4 mt-sm-0 text-sm-right d-none d-lg-block">
                  <a href="javascript:void(0)" class="btn btn-sm btn-white rounded-pill btn-icon shadow">
                    <span class="btn-inner--icon"><i class="fas fa-fire"></i></span>
                    <span class="btn-inner--text">Upgrade to Pro</span>
                  </a>
                </div> -->
              </div>
            </div>
          </div>
          <!-- General information form -->
          <div class="actions-toolbar py-2 mb-4">
            <h5 class="mb-1">General information</h5>
            <p class="text-sm text-muted mb-0">You can help us, by filling your data, create you a much better experience using our website.</p>
          </div>
          <form id="profile_form" method="post" action="<?php echo base_url('business/profile'); ?>">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Company name</label>
                  <input class="form-control" type="text" name="company_name" id="company_name" placeholder="Enter your company name" value="<?php echo $company_name; ?>" required>
                </div>
              </div>
            </div>
            <!-- Address -->
            <div class="delimiter-top">
              <div class="actions-toolbar py-2 mb-4">
                <h5 class="mb-1">Company Details</h5>
                <p class="text-sm text-muted mb-0">Fill in your address info for upcoming orders or payments.</p>
              </div>
              <?php /* ?>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <div class="form-group">
                      <label class="form-control-label">Company Address</label>
                      <textarea name="company_address" id="company_address" class="form-control" placeholder="Enter your company address" rows="3"><?php echo $company_address; ?></textarea>
                      <!-- <small class="form-text text-muted mt-2">You can @mention other users and organizations to link to them.</small> -->
                    </div>
                  </div>
                </div>
              </div><?php */ ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Country</label>
                    <select class="form-control" data-toggle="select" title="Country" data-live-search="true" data-live-search-placeholder="Country" name="country" id="country" data-country="<?php echo $country; ?>">
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">State</label>
                    <select class="form-control" data-toggle="select" title="State" data-live-search="true" data-live-search-placeholder="State" name="state" id="state" data-state="<?php echo $state; ?>">
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">City</label>
                    <select class="form-control" data-toggle="select" title="City" data-live-search="true" data-live-search-placeholder="City" name="city" id="city" data-city="<?php echo $city; ?>">
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <div class="form-group">
                      <label class="form-control-label">About Company</label>
                      <textarea name="about_company" id="about_company" class="form-control" placeholder="Enter about company" rows="3"><?php echo $about_company; ?></textarea>
                      <!-- <small class="form-text text-muted mt-2">You can @mention other users and organizations to link to them.</small> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="form-group">
                      <label class="form-control-label">Endorse</label>
                      <select name="endorse" id="endorse" class="form-control">
                        <option value="auto" <?php echo ($endorse != 'manual') ? 'selected="selected"' : ''; ?>>Auto</option>
                        <option value="manual" <?php echo ($endorse == 'manual') ? 'selected="selected"' : ''; ?>>Manual</option>
                      </select>
                      <!-- <small class="form-text text-muted mt-2">You can @mention other users and organizations to link to them.</small> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Save changes buttons -->
            <div class="pt-5 mt-5 delimiter-top text-center">
              <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
              <button type="button" class="btn btn-link text-muted">Cancel</button>
            </div>
          </form>
        </div>
        <?php /* ?>
        <div class="col-lg-3 order-lg-1">
          <?php $this->load->view('frontend/user/profile-left-panel'); ?>
        </div><?php */ ?>
      </div>
    </div>
  </section>
</div>