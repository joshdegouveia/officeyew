<?php if ($user['type'] != SELLER) { ?>
<div data-toggle="sticky" data-sticky-offset="30" data-negative-margin=".card-profile-cover">
  <div class="card">
    <div class="card-header py-3">
      <span class="h6">Settings</span>
    </div>
    <div class="list-group list-group-sm list-group-flush">
      <a href="<?php echo base_url('user/dashboard'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fa fa-desktop mr-2"></i>
          <span>Dashboard</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <a href="<?php echo base_url('user/account'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-user-circle mr-2"></i>
          <span>Profile</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <?php if ($user['type'] == B2B) { ?>
      <a href="<?php echo base_url('user/profile'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-user-circle mr-2"></i>
          <span>Public Profile</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <a href="<?php echo base_url('business/profile'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-user-circle mr-2"></i>
          <span>Company Profile</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <a href="<?php echo base_url('business/products'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-shopping-bag mr-2"></i>
          <span>Products</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <a href="<?php echo base_url('user/billing'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-credit-card mr-2"></i>
          <span>Billing</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <?php } ?>
      <?php if ($user['type'] == SELLER) { ?>
      <a href="<?php echo base_url('user/profile'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-user-circle mr-2"></i>
          <span>Public Profile</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <a href="<?php echo base_url('seller/store'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-plus-circle mr-2"></i>
          <span>Store</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <a href="<?php echo base_url('seller/products'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-list mr-2"></i>
          <span>Products</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <a href="<?php echo base_url('seller/favourites'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-heart"></i>
          <span>Favourites</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <a href="<?php echo base_url('user/billing'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-credit-card mr-2"></i>
          <span>Billing</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <?php } ?>
      <?php if ($user['type'] == CUSTOMER) { ?>
      <a href="<?php echo base_url('seller/favourites'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-heart"></i>
          <span>Favourites</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <?php } ?>
      <a href="<?php echo base_url('user/settings'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-cog mr-2"></i>
          <span>Settings</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
      <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <i class="fas fa-bell mr-2"></i>
          <span>Notifications</span>
        </div>
        <div>
          <i class="fas fa-angle-right"></i>
        </div>
      </a>
    </div>
  </div>
</div>
      <?php } ?>