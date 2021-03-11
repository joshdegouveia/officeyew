<div class="btn-group btn-group-nav shadow ml-auto" role="group" aria-label="Nav Menu">
  <div class="btn-group" role="group">
    <button id="btn-group-settings" type="button" class="btn btn-neutral btn-icon " data-offset="0,8" aria-haspopup="true" aria-expanded="false">
    <span class="btn-inner--text d-none d-sm-inline-block"><a href="<?php echo base_url('user/dashboard');?>" title="Dashboard"><i class="fa fa-life-ring" aria-hidden="true"></i></a></span>
    </button>
  </div>
  <div class="btn-group" role="group">
    <button id="btn-group-settings" type="button" class="btn btn-neutral btn-icon" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false" title="Account">
    <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
    <!-- <span class="btn-inner--text d-none d-sm-inline-block">Account</span> -->
    </button>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="btn-group-settings">
      <!-- <a class="dropdown-item" href="<?php //echo base_url('user/dashboard'); ?>">Dashboard</a> -->
     
      <a class="dropdown-item" href="<?php echo base_url('user/profile'); ?>">Public profile</a>
      
      <a class="dropdown-item" href="<?php echo base_url('business/profile'); ?>">Company profile</a>
   
      <a class="dropdown-item" href="<?php echo base_url('user/account'); ?>">Profile</a>
      <a class="dropdown-item" href="<?php echo base_url('user/settings'); ?>">Settings</a>
      <a class="dropdown-item" href="<?php echo base_url('user/billing'); ?>">Billing</a>
      <a class="dropdown-item" href="<?php echo base_url('user/notification'); ?>">Notifications <span class="noti"></span></a>
      <div class="dropdown-divider" role="presentation"></div>
      <a class="dropdown-item" href="<?php echo base_url('user/settings'); ?>">Settings</a>
      <div class="dropdown-divider" role="presentation"></div>
      <a class="dropdown-item sign-out" href="javascript:void(0)">Sign out</a>
    </div>
  </div>
  <div class="btn-group" role="group">
    <button id="btn-group-boards" type="button" class="btn btn-neutral btn-icon" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false" title="Add new">
    <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
    <!-- <span class="btn-inner--text d-none d-sm-inline-block">Add New</span> -->
    </button>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="btn-group-settings">
      <a class="dropdown-item" href="<?php echo base_url('business/addproduct'); ?>">Product</a>
      <a class="dropdown-item" href="<?php echo base_url('business/addvoucher'); ?>">Discount Voucher</a>
      <a class="dropdown-item" href="<?php echo base_url('business/addloyalty'); ?>">Loyalty Discount</a>
    </div>
  </div>
  <div class="btn-group" role="group">
    <button id="btn-group-listing" type="button" class="btn btn-neutral btn-icon rounded-right" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false" title="Listings">
    <span class="btn-inner--icon"><i class="fas fa-list-ul"></i></span>
    <!-- <span class="btn-inner--text d-none d-sm-inline-block">Listings</span> -->
    </button>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="btn-group-settings">
      <span class="dropdown-header">List</span>
      <a class="dropdown-item" href="<?php echo base_url('business/products'); ?>">Products</a>
      <a class="dropdown-item" href="<?php echo base_url('report/productorders'); ?>">Product Orders</a>
      <a class="dropdown-item" href="<?php echo base_url('business/vouchers'); ?>">Discount Vouchers</a>
      <a class="dropdown-item" href="<?php echo base_url('business/voucherorders'); ?>">Voucher Orders</a>
      <a class="dropdown-item" href="<?php echo base_url('business/loyalty'); ?>">Loyalty Discount</a>
      <a class="dropdown-item" href="<?php echo base_url('user/followlist'); ?>">Followers</a>
      <a class="dropdown-item" href="<?php echo base_url('business/endorselist'); ?>">Endorse</a>
      <a class="dropdown-item" href="<?php echo base_url('report/averagesale'); ?>">Report Analytics</a>
    </div>
  </div>
</div>