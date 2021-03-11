<?php
$company_name = $company_address = $about_company = '';
$company_logo = FILEPATH . 'img/default/no-image.png';

if (!empty($company)) {
  $company_name = $company->company_name;
  $company_address = $company->company_address;
  $about_company = $company->about_company;
  $company_logo = (!empty($company->company_logo)) ? UPLOADPATH . 'business/logo/thumb/' . $company->company_logo : $company_logo;
}
$image_name = ($store_data!='')? $store_data->image :'';
?>
<div class="main-content store-page">
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
            <a href="<?php echo base_url('seller/store'); ?>" class="btn btn-icon btn-group-nav shadow btn-neutral">
              <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
              <span class="btn-inner--text d-none d-md-inline-block">Store</span>
            </a>
            <?php /*if ($user['type'] == SELLER) { ?>
            <?php $this->load->view('frontend/seller/header_menu'); ?>
            <?php } else { ?>
            <div class="btn-group btn-group-nav shadow ml-auto" role="group" aria-label="Basic example">
              <div class="btn-group" role="group">
                <button id="btn-group-settings" type="button" class="btn btn-neutral btn-icon" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false">
                <span class="btn-inner--icon"><i class="fas fa-sliders-h"></i></span>
                <span class="btn-inner--text d-none d-sm-inline-block">Account</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="btn-group-settings">
                  <span class="dropdown-header">Profile</span>
                  <a class="dropdown-item" href="javascript:void(0)">Public profile</a>
                  <span class="dropdown-header">Account</span>
                  <a class="dropdown-item" href="javascript:void(0)">Profile</a>
                  <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                  <a class="dropdown-item" href="javascript:void(0)">Billing</a>
                  <a class="dropdown-item" href="javascript:void(0)">Notifications</a>
                </div>
              </div>
              <div class="btn-group" role="group">
                <button id="btn-group-boards" type="button" class="btn btn-neutral btn-icon" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false">
                <span class="btn-inner--icon"><i class="fas fa-chart-line"></i></span>
                <span class="btn-inner--text d-none d-sm-inline-block">Board</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="btn-group-boards">
                  <a class="dropdown-item" href="javascript:void(0)">Overview</a>
                  <a class="dropdown-item" href="javascript:void(0)">Projects</a>
                  <a class="dropdown-item" href="javascript:void(0)">Tasks</a>
                  <a class="dropdown-item" href="javascript:void(0)">Connections</a>
                </div>
              </div>
              <div class="btn-group" role="group">
                <button id="btn-group-listing" type="button" class="btn btn-neutral btn-icon rounded-right" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false">
                <span class="btn-inner--icon"><i class="fas fa-list-ul"></i></span>
                <span class="btn-inner--text d-none d-sm-inline-block">Listing</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="btn-group-settings">
                  <span class="dropdown-header">Tables</span>
                  <a class="dropdown-item" href="javascript:void(0)">Orders</a>
                  <a class="dropdown-item" href="javascript:void(0)">Projects</a>
                  <span class="dropdown-header">Flex</span>
                  <a class="dropdown-item" href="javascript:void(0)">Users</a>
                </div>
              </div>
            </div>
            <?php }*/ ?>
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
          <!-- General information form -->
          <div class="actions-toolbar py-2 mb-4">
            <h5 class="mb-1">Store general information</h5>
            <p class="text-sm text-muted mb-0">You can help us, by filling your store data, create you a much better experience using our website.</p>
          </div>
          <form id="profile_form" enctype="multipart/form-data" method="post" action="<?php echo base_url('store'); ?>">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Store name</label>
                  <input class="form-control" type="text" name="store_name" id="store_name" placeholder="Enter your store name" value="<?php echo $name = ($store_data!='')? $store_data->name :''; ?>" required>
                </div>
              </div>
            </div>
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Store Image</label>
                  <input type="file" name="store_image" id="store_image" class="form-control" placeholder="Select a store image" required>
                </div>
                <?php 
                if($image_name!='')
                {
                ?>
                <div class="form-group">
                  <img src="<?php echo base_url().'assets/upload/user/store/thumb/'.$image_name; ?>" />
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label">Store Description</label>
                  <textarea class="form-control " name="store_desc" id="store_desc"><?php echo $desc = ($store_data!='') ? $store_data->description:''; ?></textarea>
                </div>
              </div>
            </div>
            <!-- Address -->
            <div class="pt-5 mt-5 delimiter-top">
              <div class="actions-toolbar py-2 mb-4">
                <h5 class="mb-1">Bank details</h5>
                <p class="text-sm text-muted mb-0">Fill your bank details.</p>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Bank Account no:</label>
                    <input class="form-control" type="text" placeholder="Enter your bank account no" name="bank_acc_no" id="bank_acc_no" value="<?php echo $acc_no = ($store_data != '') ? $store_data->account_no:''; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Bank Account Name</label>
                    <input class="form-control" type="text" placeholder="Enter your bank account name" name="bank_acc_name" id="bank_acc_name" value="<?php echo $account_name=($store_data !='') ? $store_data->account_name : ''; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Bank Name</label>
                    <input class="form-control" type="text" placeholder="Enter your bank name" name="bank_name" id="bank_name" value="<?php echo $bank_name = ($store_data !='') ? $store_data->bank_name : ''; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Bank IFSC code</label>
                    <input class="form-control" type="text" placeholder="Enter your bank IFSC code" name="bank_ifsc" id="bank_ifsc" value="<?php echo $ifsc_code = ($store_data !='') ? $store_data->ifsc_code:''; ?>">
                  </div>
                </div>
              </div>
            </div>
            <!-- Save changes buttons -->
            <div class="pt-5 mt-5 delimiter-top text-center">
              <button type="submit" class="btn btn-sm btn-primary">Save</button>
              <!-- <button type="button" class="btn btn-link text-muted">Cancel</button> -->
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