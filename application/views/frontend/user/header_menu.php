<?php
$actual_link = "$_SERVER[REQUEST_URI]";
//$url_array = explode('/',$actual_link);
$dashboard_menu = 'user/dashboard';
$dashboard_menu_style = $account_menu_style = $orders_menu_style = $analytics_menu_style = '';
$account_menu = array('user/account' => '', 'seller/favourites' => '', 'report/productorders' => '');
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
?>
<div class="btn-group btn-group-nav shadow ml-auto1" role="group" aria-label="Basic example">
  <div class="btn-group" role="group">
    <button id="btn-group-settings" type="button" class="btn btn-neutral btn-icon <?php echo $dashboard_menu_style; ?>" data-offset="0,8" aria-haspopup="true" aria-expanded="false">
    <span class="btn-inner--text d-none d-sm-inline-block"><a href="<?php echo base_url('user/dashboard');?>"><i class="fa fa-life-ring" aria-hidden="true"></i> Dashboard</a></span>
    </button>
  </div>
  <div class="btn-group" role="group">
    <button id="btn-group-settings" type="button" class="btn btn-neutral btn-icon <?php echo $account_menu_style; ?>" data-toggle="dropdown" data-offset="0,8" aria-haspopup="true" aria-expanded="false">
    <span class="btn-inner--icon"><i class="fas fa-sliders-h"></i></span>
    <span class="btn-inner--text d-none d-sm-inline-block">Account</span>
    </button>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="btn-group-settings">
      <span class="dropdown-header">Profile</span>
      <a class="dropdown-item <?php echo $account_menu['user/account']; ?>" href="<?php echo base_url('user/account'); ?>">Profile Management</a>
      <a class="dropdown-item <?php echo $account_menu['seller/favourites']; ?>" href="<?php echo base_url('seller/favourites'); ?>">My Favourites</a>
      <a class="dropdown-item <?php echo $account_menu['report/productorders']; ?>" href="<?php echo base_url('report/productorders'); ?>">My Order</a>
    </div>
  </div>
</div>