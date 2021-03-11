<?php
$actual_link = "$_SERVER[REQUEST_URI]";//(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$url_array = explode('/',$actual_link);
$dashboard_menu = 'user/dashboard';
$dashboard_menu_style = $account_menu_style = $orders_menu_style = $analytics_menu_style = '';
$account_menu = array('user/account' => '', 'user/messages' => '', 'user/profile' => '', 'seller/store' => '', 'seller/favourites' => '', 'user/followlist' => '', 'user/settings' => '');
$orders_menu = array('seller/products' => '', 'seller/addproduct' => '', 'seller/vouchers' => '', 'seller/addvoucher' => '', 'seller/businessvouchers' => '', 'report/productorders' => '', 'report/voucherorders' => '');
$analytics_menu = array('report/averagesale' => '', 'report/customgraph' => '', 'report/trendingreport' => '', 'report/customreport' => '', 'report/customgraph' => '');
$match = false;
if (strpos($actual_link, $dashboard_menu) > 0) {
  $match = true;
  $dashboard_menu_style = 'active';
}
if (!$match) {
  foreach($account_menu as $k => $val) {
    if (strpos($actual_link, $k) > 0) {
      $account_menu[$k] = 'active';
      $match = true;
      $account_menu_style = 'active';
      break;
    }
  }
}
if (!$match) {
  foreach($orders_menu as $k => $val) {
    if (strpos($actual_link, $k) > 0) {
      $orders_menu[$k] = 'active';
      $match = true;
      $orders_menu_style = 'active';
      break;
    }
  }
}
if (!$match) {
  foreach($analytics_menu as $k => $val) {
    if (strpos($actual_link, $k) > 0) {
      $analytics_menu[$k] = 'active';
      $match = true;
      $analytics_menu_style = 'active';
      break;
    }
  }
}
?>
<div class="btn-group btn-group-nav shadow ml-auto1" role="group" aria-label="Nav Menu">
  <div class="btn-group" role="group">
    <button id="btn-group-settings" type="button" class="btn btn-neutral btn-icon <?php echo $dashboard_menu_style; ?>" data-offset="0,8" aria-haspopup="true" aria-expanded="false">
    <span class="btn-inner--text d-none d-sm-inline-block"><a href="<?php echo base_url('user/dashboard');?>" title="Dashboard"><i class="fa fa-life-ring" aria-hidden="true"></i></a></span>
    </button>
  </div>
  <div class="btn-group" role="group">
    <button id="btn-group-settings" type="button" class="btn btn-neutral btn-icon <?php echo $account_menu_style; ?>" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false" title="Account">
    <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
    <!-- <span class="btn-inner--text d-none d-sm-inline-block">Account</span> -->
    </button>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="btn-group-settings">
      <span class="dropdown-header">Profile</span>
      <a class="dropdown-item <?php echo $account_menu['user/account']; ?>" href="<?php echo base_url('user/account'); ?>">Profile Management</a>
      <?php /* ?><a class="dropdown-item <?php echo $account_menu['user/messages']; ?>" href="<?php echo base_url('user/messages'); ?>">Messages</a>
      <a class="dropdown-item" <?php echo $account_menu['user/notification']; ?> href="<?php echo base_url('user/notification'); ?>">Notifications <span class="noti"></span></a><?php */ ?>
      <a class="dropdown-item <?php echo $account_menu['user/profile']; ?>" href="<?php echo base_url('user/profile'); ?>">Public Profile</a>
      <a class="dropdown-item <?php echo $account_menu['seller/store']; ?>" href="<?php echo base_url('seller/store'); ?>">General Information</a>
      <a class="dropdown-item <?php echo $account_menu['seller/favourites']; ?>" href="<?php echo base_url('seller/favourites'); ?>">Favourites</a>
      <a class="dropdown-item <?php echo $account_menu['user/followlist']; ?>" href="<?php echo base_url('user/followlist'); ?>">Followers</a>
      <div class="dropdown-divider" role="presentation"></div>
      <a class="dropdown-item <?php echo $account_menu['user/settings']; ?>" href="<?php echo base_url('user/settings'); ?>">Settings</a>
      <div class="dropdown-divider" role="presentation"></div>
      <a class="dropdown-item sign-out" href="javascript:void(0)">Sign out</a>
    </div>
  </div>
  <div class="btn-group" role="group">
    <button id="btn-group-boards" type="button" class="btn btn-neutral btn-icon <?php echo $orders_menu_style; ?>" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false" title="Orders">
    <span class="btn-inner--icon"><i class="fas fa-list-ul"></i></span>
    <!-- <span class="btn-inner--text d-none d-sm-inline-block">Orders</span> -->
    </button>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="btn-group-settings">
      <span class="dropdown-header">Products</span>
      <a class="dropdown-item <?php echo $orders_menu['seller/products']; ?>" href="<?php echo base_url('seller/products'); ?>">All Products</a>
      <a class="dropdown-item <?php echo $orders_menu['seller/addproduct']; ?>" href="<?php echo base_url('seller/addproduct'); ?>">Add Product</a>
      <a class="dropdown-item <?php echo $orders_menu['seller/vouchers']; ?>" href="<?php echo base_url('seller/vouchers'); ?>">Vouchers</a>
      <a class="dropdown-item <?php echo $orders_menu['seller/addvoucher']; ?>" href="<?php echo base_url('seller/addvoucher'); ?>">Add Vouchers</a>
      <a class="dropdown-item <?php echo $orders_menu['seller/businessvouchers']; ?>" href="<?php echo base_url('seller/businessvouchers'); ?>">Business Vouchers</a>
      <span class="dropdown-header">Orders</span>
      <!-- <a class="dropdown-item" href="javascript:void(0)">Receipts</a> -->
      <a class="dropdown-item <?php echo $orders_menu['report/productorders']; ?>" href="<?php echo base_url('report/productorders'); ?>">Receipts</a>
      <a class="dropdown-item <?php echo $orders_menu['report/voucherorders']; ?>" href="<?php echo base_url('report/voucherorders'); ?>">Business Vouchers</a>
    </div>
  </div>
  <div class="btn-group" role="group">
    <button id="btn-group-listing" type="button" class="btn btn-neutral btn-icon rounded-right <?php echo $analytics_menu_style; ?>" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false" title="Analytics">
    <span class="btn-inner--icon"><i class="fa fa-bar-chart" aria-hidden="true"></i></span>
    <!-- <span class="btn-inner--text d-none d-sm-inline-block">Analytics</span> -->
    </button>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="btn-group-settings">
      <a class="dropdown-item <?php echo $analytics_menu['report/averagesale']; ?>" href="<?php echo base_url('report/averagesale'); ?>">Reports</a>
      <a class="dropdown-item <?php echo $analytics_menu['report/customgraph']; ?>" href="<?php echo base_url('report/customgraph'); ?>">Graphs</a>
      <!-- <a class="dropdown-item" href="<?php echo base_url('products/orders'); ?>">Product Orders</a>
      <a class="dropdown-item" href="<?php echo base_url('business/vouchers'); ?>">Discount Vouchers</a>
      <a class="dropdown-item" href="<?php echo base_url('business/loyalty'); ?>">Loyalty Discount</a>
      <a class="dropdown-item" href="<?php echo base_url('user/followlist'); ?>">Followers</a>
      <a class="dropdown-item" href="<?php echo base_url('business/endorselist'); ?>">Endorse</a>
      <a class="dropdown-item" href="<?php echo base_url('report/averagesale'); ?>">Report Analytics</a> -->
    </div>
  </div>
</div>