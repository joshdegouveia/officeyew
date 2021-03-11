<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <!-- + DASHBOARD -->
      <li class="<?php echo $activeMenues['menuParent'] == 'dashboard' ? 'active' : '' ; ?>">
        <a href="<?php echo base_url(); ?>admin/"><i class="fa fa-dashboard"></i>Dashboard</a>
      </li>
      <!-- - DASHBOARD -- -->
      <!-- + USERS MANAGEMENT -->
      <li class="treeview <?php echo $activeMenues['menuParent'] == 'users' ? 'active' : '' ; ?>">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Manage Users</span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $activeMenues['menuChild'] == 'buyer' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/users/user_list/buyer"><i class="fa fa-circle-o"></i> Manage Buyer</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'seller' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/users/user_list/seller"><i class="fa fa-circle-o"></i> Manage Seller</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'installer' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/users/user_list/installer"><i class="fa fa-circle-o"></i> Manage Installer</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'designer' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/users/user_list/designer"><i class="fa fa-circle-o"></i> Manage Designer</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'employer' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/users/user_list/employer"><i class="fa fa-circle-o"></i> Manage Employer</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'candidate' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/users/user_list/candidate"><i class="fa fa-circle-o"></i> Manage Candidate</a></li>
          
          <!-- <li class="<?php //echo $activeMenues['menuChild'] == 'add-user' ? 'active' : '' ; ?>"><a href="<?php //echo base_url(); ?>admin/users/add"><i class="fa fa-circle-o"></i> Add User</a></li> -->
        </ul>
      </li>
      <!-- - USERS MANAGEMENT -->
      <!-- + CMS MANAGEMENT -->
      <li class="treeview <?php echo $activeMenues['menuParent'] == 'cms' ? 'active' : '' ; ?>">
        <a href="#">
          <i class="fa fa-laptop"></i>
          <span>Manage Content</span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $activeMenues['menuChild'] == 'cms-list' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/cms"><i class="fa fa-sliders"></i> CMS List</a></li>
          <!--<li class="<?php // echo $activeMenues['menuChild'] == 'notification-list' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/cms/notification_list"><i class="fa fa-bell-o"></i> Notification List</a></li>-->
          <li class="<?php echo $activeMenues['menuChild'] == 'seller_review' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/cms/seller_review"><i class="fa fa-star"></i> Seller Review</a></li>
        </ul>
      </li>
      <!-- - CMS MANAGEMENT -->
      
      
      <!-- + PRODUCT MANAGEMENT -->
      <li class="treeview <?php echo $activeMenues['menuParent'] == 'products' ? 'active' : '' ; ?>">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Manage Products</span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $activeMenues['menuChild'] == 'product-category' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/products/categories"><i class="fa fa-circle-o"></i> Products Categories</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'seller-product-list' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/products/lists/seller"><i class="fa fa-circle-o"></i> Seller Products List</a></li>
          
        </ul>
      </li>
      <!-- - PRODUCT MANAGEMENT -->
      
      <!-- + COMMISSION MANAGEMENT -->
      <li class="treeview <?php echo $activeMenues['menuParent'] == 'commission' ? 'active' : '' ; ?>">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Manage Commission</span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $activeMenues['menuChild'] == 'commission-setting' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/products/commission"><i class="fa fa-circle-o"></i> Commission Setting</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'commission-setting' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/products/tax_for_city"><i class="fa fa-circle-o"></i> Tax for city</a></li>
        </ul>
      </li>
      <!-- - COMMISSION MANAGEMENT -->
      
      
      <!-- + ORDER MANAGEMENT -->
      <li class="treeview <?php echo $activeMenues['menuParent'] == 'orders' ? 'active' : '' ; ?>">
        <a href="<?php echo base_url(); ?>admin/products/order">
          <i class="fa fa-users"></i>
          <span>Manage Orders</span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $activeMenues['menuChild'] == 'product-order-list' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/products/order"><i class="fa fa-circle-o"></i> Products Order List</a></li>
        </ul>
      </li>
      <!-- - ORDER MANAGEMENT -->
      <!-- + Manage Boost -->
      <li class="treeview <?php echo $activeMenues['menuParent'] == 'boost' ? 'active' : '' ; ?>">
        <a href="<?php echo base_url(); ?>admin/products/boost">
          <i class="fa fa-users"></i>
          <span>Manage Product Boost</span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $activeMenues['menuChild'] == 'product-order-list' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/products/boost/1"><i class="fa fa-circle-o"></i> Boost List(Subscription Based)</a></li>
           <li class="<?php echo $activeMenues['menuChild'] == 'product-order-list' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/products/boost/2"><i class="fa fa-circle-o"></i> Boost List(One Time)</a></li>
           <li class="<?php echo $activeMenues['menuChild'] == 'job_posting' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/cms/job_posting_charge_list"><i class="fa fa-circle-o"></i> Job posting charge</a></li>
        </ul>
      </li>
      <!-- - Manage Boost -->
      
       <li class="treeview <?php echo $activeMenues['menuParent'] == 'subscription' ? 'active' : '' ; ?>">
        <a href="<?php echo base_url(); ?>admin/users/boost_subscription">
          <i class="fa fa-money"></i>
          <span>Subscription</span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $activeMenues['menuChild'] == 'boost_subscription' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/users/boost_subscription"><i class="fa fa-circle-o"></i> Boost subscription</a></li>
        </ul>
      </li>
      
      
      <!-- + SITE SETTING MANAGEMENT -->
      <li class="treeview <?php echo $activeMenues['menuParent'] == 'setting' ? 'active' : '' ; ?>">
        <a href="#">
          <i class="fa fa-gears"></i>
          <span>Setting</span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $activeMenues['menuChild'] == 'profile' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/users/profile"><i class="fa fa-circle-o"></i> Profile Setting</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'password_change' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/auth/change_password"><i class="fa fa-circle-o"></i> Change your password</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'setting' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/setting"><i class="fa fa-circle-o"></i> Site Setting</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'social-link' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/setting/social_links"><i class="fa fa-circle-o"></i> Social Links</a></li>
          <li class="<?php echo $activeMenues['menuChild'] == 'payment_credentials' ? 'active' : '' ; ?>"><a href="<?php echo base_url(); ?>admin/setting/payment_credentials"><i class="fa fa-circle-o"></i> Payment Credentials</a></li>
        </ul>
      </li>
      <!-- - SITE SETTING MANAGEMENT -->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>