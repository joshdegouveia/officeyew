<style>
    .acc_content a{display: block !important;}
    .pager_content {padding: 10px 0px;}
</style>
<section class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 tab-contain">
            <div class="left-container">


                <ul>
                    <li class="tablinks dashboard_tab" onclick="openCity('dashboard_tab', 'dashboard')">
                        <!--<li class="tablinks" onclick="openCity(event, 'dashboard')">-->
                        <i class="ofc-icons-tabs tabs-icon-1"></i>
                        <span>Dashboard</span>
                    </li>
                    <?php
                    if ($user['type'] == 'buyer') {
                        ?>
                        <li class="tablinks orders_tab" onclick="openCity('orders_tab', 'orders')">
                            <!--<li class="tablinks" onclick="openCity(event, 'orders')">-->
                            <i class="ofc-icons-tabs tabs-icon-2"></i>
                            <span>My Orders</span>
                        </li>

                        <li class="tablinks favorites_tab" onclick="openCity('favorites_tab', 'favorites')">
                            <!--<li class="tablinks" onclick="openCity(event, 'favorites')">-->
                            <i class="ofc-icons-tabs tabs-icon-4"></i>
                            <span>My Favorites</span>
                        </li>

                        <li class="tablinks submitted_request_tab" onclick="openCity('submitted_request_tab', 'submitted_request')">
                            <i class="ofc-icons-tabs tabs-icon-2"></i>
                            <span>Submitted Request</span>
                        </li>

                        <?php
                    } elseif ($user['type'] == 'seller') {
                        ?>
                        <li class="tablinks my_product_tab" onclick="openCity('my_product_tab', 'my_product')">
                            <i class="ofc-icons-tabs tabs-icon-2"></i>
                            <span>My Product</span>
                        </li>
                        <li class="tablinks purchase_request_tab" onclick="openCity('purchase_request_tab', 'purchase_request')">
                            <!--<li class="tablinks" onclick="openCity(event, 'purchase_request')">-->
                            <i class="ofc-icons-tabs tabs-icon-3"></i>
                            <span>Purchase Requests</span>
                        </li>
                        <li class="tablinks subscription_charges_tab" onclick="openCity('subscription_charges_tab', 'subscription_charges')">
                            <i class="ofc-icons-tabs tabs-icon-3"></i>
                            <span>Subscription-charges</span>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="tablinks messages_tab" onclick="openCity('messages_tab', 'messages')">
                        <i class="ofc-icons-tabs tabs-icon-5"></i>
                        <span>Messages</span>
                    </li>
                    <li class="tablinks account_tab" onclick="openCity('account_tab', 'account')">
                        <!--<li class="tablinks" onclick="openCity(event, 'account')">-->
                        <i class="ofc-icons-tabs tabs-icon-6"></i>
                        <span>My Account</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9 col-xs-12 col-sm-12 col-md-9">
            <div class="main-container web-view">
                <?php $this->load->view('frontend/flash_message.php'); ?>
                <div class="acc_set">
                    <a href="javascript:void(0)">
                        <span class="acc_title">
                            Dashboard
                        </span>            
                        <i class="fa fa-plus"></i>
                    </a>
                    <div class="acc_content tabcontent collapse"  id="dashboard">
                        <?php
                        if ($user['type'] == 'buyer') {
                            ?>
                            <h4>Dashboard</h4>
                            <div class="search-container">
                                <input type="text" class="buyer_dashboard_search_product_input" name="search" placeholder="Search office furniture name" title="Enter to search product" autocomplete="false">
                                <div class="search_product_name_autocomplete_list"></div>

                                <div class="search_buyer_product_in_dashboard"></div>

                                <?php
                                $this->load->view('frontend/user/include_script/include_buyer_dashboard_js.php');
                                ?>
                            </div>
                            <?php
                        } elseif ($user['type'] == 'seller') {
                            ?>
                            <div class="search-container">
                                <?php
                                $this->load->view('frontend/user/include_seller_dashboard.php');
                                ?>
                            </div>
                            <?php
                        }
                        ?>


                    </div>
                </div>

                <?php
                if ($user['type'] == 'buyer') {
                    ?>

                    <div class="acc_set">
                        <a href="javascript:void(0)">
                            <span class="acc_title">
                                My Orders
                            </span>            
                            <i class="fa fa-plus"></i>
                        </a>
                        <div class="acc_content tabcontent collapse"  id="orders">
                            <h4>My Orders</h4>

                            my order ...
                            <?php // $this->load->view('frontend/user/include_my_order.php');    ?>
                        </div>
                    </div>

                    <div class="acc_set">
                        <a href="javascript:void(0)">
                            <span class="acc_title">
                                My Favorites
                            </span>            
                            <i class="fa fa-plus"></i>
                        </a>
                        <div class="acc_content tabcontent collapse"  id="favorites">
                            <h4>My Favorites</h4>

                            <div class="include_my_favorites">
                                <?php $this->load->view('frontend/user/include_my_favorites.php'); ?>
                            </div>
                            <?php $this->load->view('frontend/user/include_script/include_my_favorites_js.php'); ?>
                        </div>
                    </div>


                    <div class="acc_set">
                        <a href="javascript:void(0)">
                            <span class="acc_title">
                                Submitted Request
                            </span>            
                            <i class="fa fa-plus"></i>
                        </a>
                        <div class="acc_content tabcontent collapse"  id="submitted_request">
                            <h4>
                                Submitted Request
                            </h4>

                            <div class="include_submitted_request">
                                <?php $this->load->view('frontend/user/include_submitted_request.php'); ?>
                            </div>
                            <?php $this->load->view('frontend/user/include_script/include_submitted_request_js.php'); ?>
                        </div>
                    </div>
                <?php } elseif ($user['type'] == 'seller') {
                    ?>

                    <div class="acc_set">
                        <div class="acc_content tabcontent collapse"  id="my_product">
                            <div class="include_my_product">
                                <?php $this->load->view('frontend/user/include_my_product.php'); ?>
                                <!-- Modal -->
                                <?php $this->load->view('frontend/user/include_product_add_edit_modal.php'); ?>
                                <!--  -->
                            </div>
                            <?php $this->load->view('frontend/user/include_script/include_my_product_js.php'); ?>
                        </div>
                    </div>


                    <div class="acc_set">
                        <a href="javascript:void(0)">
                            <span class="acc_title">
                                Purchase Requests
                            </span>            
                            <i class="fa fa-plus"></i>
                        </a>
                        <div class="acc_content tabcontent collapse"  id="purchase_request">
                            <h4>
                                Purchase Requests
                            </h4>

                            <div class='include_purchase_requests'>
                                <?php $this->load->view('frontend/user/include_purchase_requests.php'); ?>
                            </div>
                            <?php $this->load->view('frontend/user/include_script/include_purchase_requests_js.php'); ?>
                        </div>
                    </div>


                    <div class="acc_set">
                        <a href="javascript:void(0)">
                            <span class="acc_title"> Subscription & charges </span>            
                            <i class="fa fa-plus"></i>
                        </a>

                        <div class="acc_content tabcontent collapse"  id="subscription_charges">
                            <h4>Subscription & charges</h4>

                            <div class='include_subscription_charges'>
                                <?php $this->load->view('frontend/user/include_subscription_charges.php'); ?>
                            </div>
                            <?php $this->load->view('frontend/user/include_script/include_subscription_charges_js.php'); ?>
                        </div>

                    </div>
                <?php } ?>

                <div class="acc_set">
                    <a href="javascript:void(0)">
                        <span class="acc_title">
                            Messages
                        </span>            
                        <i class="fa fa-plus"></i>
                    </a>
                    <div class="acc_content tabcontent collapse"  id="messages">
                        <h4>Messages</h4>
                        <div class='include_my_message_list'>
                            <?php $this->load->view('frontend/user/include_my_message_list.php'); ?>
                        </div>
                        <?php $this->load->view('frontend/user/include_my_message_details.php'); ?>
                        <?php $this->load->view('frontend/user/include_script/include_my_message_list_js.php'); ?>
                    </div>
                </div>

                <div class="acc_set">
                    <a href="javascript:void(0)">
                        <span class="acc_title">
                            My Account
                        </span>            
                        <i class="fa fa-plus"></i>
                    </a>
                    <div class="acc_content tabcontent collapse"  id="account">

                        <h4>
                            My Account
                        </h4>


                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Manage Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Change Password</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <h4>
                                    Manage Profile <span id="edit_profile_icon_btn"><i class="fa fa-pencil"></i></span>
                                </h4>

                                <?php $this->load->view('frontend/user/include_manage_profile.php'); ?>
                                <?php $this->load->view('frontend/user/include_script/include_manage_profile_js.php'); ?>
                            </div>

                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                <h4> Change Password</h4>

                                <?php $this->load->view('frontend/user/include_change_password.php'); ?>                                
                            </div>
                        </div>




                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- dashboard end -->
