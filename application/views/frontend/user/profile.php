<style>
    .acc_content a{display: block !important;}
    .pager_content {padding: 10px 0px;}
	.advancesearch{
	color: #fff !important;
    background: rgb(221, 0, 141);
    background: -moz-linear-gradient(top, rgba(221, 0, 141, 1) 0%, rgba(137, 0, 144, 1) 100%);
    background: -webkit-linear-gradient(top, rgba(221, 0, 141, 1) 0%, rgba(137, 0, 144, 1) 100%);
    background: linear-gradient(to bottom, rgba(221, 0, 141, 1) 0%, rgba(137, 0, 144, 1) 100%);
	font-size: 16px;
    font-weight: 600;
    border: 1px solid #760091;
    border-radius: 10px;
    padding: 5px 20px !important;
	position:absolute;
	top:0px;
	right:0px;
}
</style>
<?php

$key = 0 ;
$max_resume_no = 0;
$job_categoryy = '';
$max_valid_upto = 'unlimited';
$user_d = $this->db->select('*')->from('users')->where(array('id'=>$user['id']))->get()->result_array();
$max_job_posted_limit = $user_d[0]['max_job_posted_limit'];
$resume_search_count = $user_d[0]['resume_search_count'];

?>
<?php

$created_at = date('Y-m-d H:i:s');	
$this->db->where(array('user_id'=>$user['id'],'valid_upto<>'=>'unlimited','valid_upto<'=>$created_at));
$this->db->update('job_posting_subscription',array('status'=>'Ar'));
$where_arr = array('job_posting_subscription.status'=>'A','job_posting_subscription.user_id'=>$user['id'],'job_posting_subscription.valid_upto>='=>$created_at);			
$query_subscription = $this->db->select('job_posting_subscription.*,job_posting_subscription.job_category,job_posting_subscription.valid_upto')->from('job_posting_subscription')->join('job_posting_charges','job_posting_subscription.subscription_id=job_posting_charges.job_posting_charges_id')->where($where_arr);
$user_subscription=$query_subscription->get()->result_array();
$download_status = 'no';
$job_category = array();
if (count($user_subscription)>0) {
	for ($i=0;$i<count($user_subscription);$i++) {
		$job_category[$user_subscription[$i]['subscription_for_boost_id']] = $user_subscription[$i]['job_category'];
		$job_valid_upto[$user_subscription[$i]['subscription_for_boost_id']] = $user_subscription[$i]['valid_upto'];
		$job_product_no[$user_subscription[$i]['subscription_for_boost_id']] = $user_subscription[$i]['product_no'];
	}
}
if (count($job_category)>0) {
	if (in_array('monthly',$job_category)) {
		$key = array_search ('monthly', $job_category);
		$max_valid_upto = $job_valid_upto[$key];
		$job_categoryy = $job_category[$key];
		$max_resume_no = 'unlimited';
	}elseif(in_array('per_post',$job_category)){
		$key = array_search ('per_post', $job_category);
		$max_valid_upto = $job_valid_upto[$key];
		$job_categoryy = $job_category[$key];
		$max_resume_no = 'unlimited';
	} elseif (in_array('one_time',$job_category)) {
		$key = array_search ('one_time', $job_category);
		$max_valid_upto = 'unlimited';
		$job_categoryy = $job_category[$key];
		$max_resume_no =  $job_product_no[$key];
	}
}

$resume_download_permission =0;
if (($max_resume_no == 'unlimited')&&(strtotime($created_at)<=strtotime($max_valid_upto))) {
	$resume_download_permission = 1;
}elseif(($max_resume_no != 'unlimited')&&($resume_search_count<=$max_resume_no)){
	$resume_download_permission = 1;	
}
$_SESSION['resume_download_permission']=$resume_download_permission;
$_SESSION['subscription_id']=$key;$_SESSION['job_category'] = $job_categoryy;
$_SESSION['max_resume_no']=$max_resume_no;
$_SESSION['max_valid_upto']=$max_valid_upto;

?>
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
                    } elseif ($user['type'] == 'designer') {
                        ?>

                        <?php
                    }elseif ($user['type'] == 'candidate'){
						
                    ?>
						<li class="tablinks applied_jobs_tab" onclick="openCity('applied_jobs_tab', 'applied_jobs')">
							<i class="ofc-icons-tabs tabs-icon-3"></i>
							<span>Applied Jobs</span>
						</li>
						 <li class="tablinks saved_jobs_tab" onclick="openCity('saved_jobs_tab', 'saved_jobs')">
                            <i class="ofc-icons-tabs tabs-icon-2"></i>
                            <span>Saved Jobs</span>
                        </li>
						  <li class="tablinks upload_resume_tab" onclick="openCity('upload_resume_tab', 'upload_resume')">
                            <i class="ofc-icons-tabs tabs-icon-2"></i>
                            <span>Upload Resume</span>
                        </li>
                      
						
					<?php
						}elseif ($user['type'] == 'employer'){
					?>
						<li class="tablinks my_jobs_tab" onclick="openCity('my_jobs_tab', 'my_jobs')">
							<i class="ofc-icons-tabs tabs-icon-3"></i>
							<span>My Jobs</span>
						</li>
						 <li class="tablinks job_applicants_tab" onclick="openCity('job_applicants_tab', 'job_applicants')">
                            <i class="ofc-icons-tabs tabs-icon-2"></i>
                            <span>Job Applicants</span>
                        </li>
					<li class="tablinks subscription_charges_tab" onclick="openCity('subscription_charges_tab', 'subscription_charges')">
						<i class="ofc-icons-tabs tabs-icon-3"></i>
						<span>Subscription-charges</span>
					</li>
						  <li class="tablinks find_resume_tab" onclick="openCity('find_resume_tab', 'find_resume')">
                            <i class="ofc-icons-tabs tabs-icon-2"></i>
                            <span>Find Resume</span>
                        </li>
					<?php
					}
					?>

                    <li class="tablinks installer_request_tab" onclick="openCity('installer_request_tab', 'installer_request')">
                        <i class="ofc-icons-tabs tabs-icon-2"></i>
                        <span>Installer  Requests</span>
                    </li>
					 <li class="tablinks designer_service_request_tab" onclick="openCity('designer_service_request_tab', 'designer_service_request')">
                        <i class="ofc-icons-tabs tabs-icon-2"></i>
                        <span>Designer  Requests</span>
                    </li>
                    
					<li class="tablinks fav_installer_tab " onclick="openCity('fav_installer_tab', 'fav_installer_request')">
						<i class="ofc-icons-tabs tabs-icon-2"></i>
						<span>Favourite  Installer</span>
					</li>
					<li class="tablinks fav_designer_tab" onclick="openCity('fav_designer_tab', 'fav_designer_request')">
						<i class="ofc-icons-tabs tabs-icon-2"></i>
						<span>Favourite  Designer</span>
					</li>
					<!--<li class="tablinks fav_product_tab" onclick="openCity('fav_product_tab', 'fav_product_request')">
						<i class="ofc-icons-tabs tabs-icon-2"></i>
						<span>Favourite  Products</span>
					</li>-->
					<li class="tablinks fav_candidate_tab" onclick="openCity('fav_candidate_tab', 'fav_candidate_request')">
						<i class="ofc-icons-tabs tabs-icon-2"></i>
						<span>Favourite  Candidate</span>
					</li>
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
        <div class="col-lg-9 col-xs-12 col-sm-12 col-md-9 modified_profile_class">
            <div class="main-container web-view modified_class">
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
                                //$this->load->view('frontend/user/include_script/include_buyer_dashboard_js.php');
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
                        }elseif ($user['type'] == 'candidate') {
                        ?>
							 <h4>Dashboard</h4>
								<?php
									$this->load->view('frontend/user/include_candidate_dashboard.php');
									$this->load->view('frontend/user/include_job_advance_search_modal.php')
								?>
						
						<?php
						}elseif ($user['type'] == 'employer') {
						?>
				
                            <h4>
                                Recent Job Applicants
                            </h4>
                            <div class="include_submitted_request">
								<?php
									$this->load->view('frontend/user/include_recent_job_applicants.php');
								?>
                            </div>
							<h4>
                                Recent Job Posted
                            </h4>
							<div class="include_submitted_request">
								<?php
									$this->load->view('frontend/user/include_recent_job_posted.php');
								?>
                            </div>
						<?php
						}elseif($user['type'] == 'installer'){
						?>
						<h4>
                                Installer Recent Incoming Requests
                            </h4>
                            <div class="include_submitted_request">
								<?php
									$this->load->view('frontend/user/include_installer_recent_incoming_request.php');
								?>
                            </div>
							<h4>
                                Recent Submitted Requests
                            </h4>
							<div class="include_submitted_request">
								<?php
									$this->load->view('frontend/user/include_installer_recent_submitted_request.php');
								?>
                            </div>
						<?php
						}elseif($user['type'] == 'designer'){
						?>
						<h4>
                                Designer Recent Incoming Requests
                            </h4>
                            <div class="include_submitted_request">
								<?php
									$this->load->view('frontend/user/include_designer_recent_incoming_request.php');
								?>
                            </div>
							<h4>
                                Designer Recent Submitted Requests
                            </h4>
							<div class="include_submitted_request">
								<?php
									$this->load->view('frontend/user/include_designer_recent_submitted_request.php');
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

                           
                            <?php $this->load->view('frontend/user/include_my_order.php'); ?>
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
                            <h4>Optional Subscription & Charges</h4>

                            <div class='include_subscription_charges'>
                                <?php $this->load->view('frontend/user/include_subscription_charges.php'); ?>
                            </div>
                            <?php $this->load->view('frontend/user/include_script/include_subscription_charges_js.php'); ?>
                        </div>

                    </div>
                <?php } elseif ($user['type'] == 'designer') { ?>

                <?php } elseif ($user['type'] == 'candidate') { ?>
				<div class="acc_set">
					<a href="javascript:void(0)">
						<span class="acc_title">
							My Applied Jobs
						</span>            
						<i class="fa fa-plus"></i>
					</a>
					<div class="acc_content tabcontent collapse"  id="applied_jobs">
						<h4 style="margin-bottom:15px">My Applied Jobs</h4>
						<?php  $this->load->view('frontend/user/include_my_applied_jobs.php');    ?>
					</div>
				</div>

				<div class="acc_set">
					<a href="javascript:void(0)">
						<span class="acc_title">
							My Saved Jobs
						</span>            
						<i class="fa fa-plus"></i>
					</a>
					<div class="acc_content tabcontent collapse"  id="saved_jobs">
						<h4 style="margin-bottom:15px">My Saved Jobs</h4>
						<?php  $this->load->view('frontend/user/include_my_saved_jobs.php');    ?>
					</div>
				</div>

				<div class="acc_set">
					<a href="javascript:void(0)">
						<span class="acc_title">
							Upload Resume
						</span>            
						<i class="fa fa-plus"></i>
					</a>
					<div class="acc_content tabcontent collapse"  id="upload_resume">
						<h4 style="margin-bottom:15px">Upload Resume</h4>
						<?php  $this->load->view('frontend/user/include_upload_resume.php');    ?>
					</div>
				</div>

				<div class="acc_set">
					<a href="javascript:void(0)">
						<span class="acc_title">
							Manage Profile
						</span>            
						<i class="fa fa-plus"></i>
					</a>
					<div class="acc_content tabcontent collapse"  id="manage_profile">
						<h4 style="margin-bottom:15px">Manage Profile</h4>
						<?php  $this->load->view('frontend/user/include_upload_resume.php');    ?>
					</div>
				</div>
				<?php }elseif ($user['type'] == 'employer') {
					
				?>
				<div class="acc_set">
					<a href="javascript:void(0)">
						<span class="acc_title">
							My Jobs
						</span>            
						<i class="fa fa-plus"></i>
					</a>
					<div class="acc_content tabcontent collapse"  id="my_jobs">
						<h4 style="margin-bottom:15px">My Jobs</h4>
						<?php
						/*echo '<pre>';
						print_r($_SESSION['user_subscriptions']);
						echo '</pre>';
						*/
						//echo $max_job_posted_limit;
						?>
						<?php if(in_array('per_post',$job_category)){ ?>
						<?php if(!empty($max_job_posted_limit)&&($max_job_posted_limit>0)){?>
						<button type = "button" class = "advancesearch btn btn-default " data-toggle="modal" data-target="#addjobs">Add Jobs</button>
						<?php }else{?>
						<?php 
						$up_sql = "update job_posting_subscription set `status`= 'Ar' where user_id='".$user['id']."'
						and job_category ='per_post' ";
						$this->db->query($up_sql);
						?>
						<button type = "button" class = "advancesearch btn btn-default " data-toggle="modal" data-target="#add_jobs_error">Add Jobs</button>
						<?php }?>
						<?php }else{?>
						
						<button type = "button" class = "advancesearch btn btn-default " data-toggle="modal" data-target="#add_jobs_error">Add Jobs</button>
						<?php }?>
						<?php $this->load->view('frontend/user/include_my_jobs.php');?>
						<?php $this->load->view('frontend/user/include_add_job_form.php') ?>
						<?php //$this->load->view('frontend/user/include_script/include_my_jobs_js.php'); ?>
					</div>
				</div>
				<div class="acc_set">
					<a href="javascript:void(0)">
						<span class="acc_title">
							Job Applicants
						</span>            
						<i class="fa fa-plus"></i>
					</a>
					<div class="acc_content tabcontent collapse"  id="job_applicants">
						<h4 style="margin-bottom:15px">Job Applicants</h4>
						<?php  $this->load->view('frontend/user/include_job_applicants.php');    ?>
					</div>
				</div>
				
				<div class="acc_content tabcontent collapse"  id="subscription_charges">
					<h4>Subscription & charges</h4>

					<div class='include_subscription_charges'>
						<?php $this->load->view('frontend/user/include_employer_subscription_charges.php'); ?>
					</div>
					<?php $this->load->view('frontend/user/include_script/include_employer_subscription_charges_js.php'); ?>
				</div>
				
				<div class="acc_set">
					<a href="javascript:void(0)">
						<span class="acc_title">
							Find Resume
						</span>            
						<i class="fa fa-plus"></i>
					</a>
					<div class="acc_content tabcontent collapse"  id="find_resume">
						<h4 style="margin-bottom:15px">Find Resume</h4>
						<?php  $this->load->view('frontend/user/include_find_resume.php');    ?>
					</div>
				</div>
				<?php
				}
				?>
                <div class="acc_set">
                    <a href="javascript:void(0)">
                        <span class="acc_title"> Installer Request </span>            
                        <i class="fa fa-plus"></i>
                    </a>

                    <div class="acc_content tabcontent collapse"  id="installer_request">
                        <h4>Installer Request</h4>

                        <div class='include_installer_request'>
                            <?php $this->load->view('frontend/user/include_installer_request.php'); ?>
                        </div>
                        <?php $this->load->view('frontend/user/include_script/include_installer_request_js.php'); ?>
                    </div>

                </div>
				 <div class="acc_set">
                    <a href="javascript:void(0)">
                        <span class="acc_title">  Designer Request </span>            
                        <i class="fa fa-plus"></i>
                    </a>

                    <div class="acc_content tabcontent collapse"  id="designer_service_request">
                        <h4>Designer Request</h4>

                         <div class='include_designer_request'>
                            <?php $this->load->view('frontend/user/include_designer_request.php'); ?>
                        </div>
                        <?php $this->load->view('frontend/user/include_script/include_designer_request_js.php'); ?>
                    </div>

                </div>


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
							<?php
								if ($user['type'] == 'seller') {
							?>
							<li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="profile" aria-selected="false">Payment Settings</a>
                            </li>
							<?php
								}
							?>
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

							<div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="profile-tab">

                              

                                <?php $this->load->view('frontend/user/include_payment_setup.php'); ?>                                
                            </div>
						
							
                        </div>




                        <div class="clearfix"></div>
                    </div>
                </div>
            
            
				<div class="acc_set">
				<a href="javascript:void(0)">
                        <span class="acc_title">
                            Favourite Installer
                        </span>            
                        <i class="fa fa-plus"></i>
                    </a>
					<div class="acc_content tabcontent collapse"  id="fav_installer_request">
						<h4>Favourite Installer</h4>
						<div class='include_fav_installer_request'>
						
							<?php $this->load->view('frontend/user/fav_installer_request.php'); ?>
						</div>
					</div>
				</div>
				<div class="acc_set">
				<a href="javascript:void(0)">
                        <span class="acc_title">
                            Favourite Designer
                        </span>            
                        <i class="fa fa-plus"></i>
                    </a>
					<div class="acc_content tabcontent collapse"  id="fav_designer_request">
						<h4>Favourite Designer</h4>
						<div class='include_fav_designer_request'>
							<?php $this->load->view('frontend/user/fav_designer_request.php'); ?>
						</div>
					</div>
				</div>
				<div class="acc_set">
				<a href="javascript:void(0)">
                        <span class="acc_title">
                            Favourite Product
                        </span>            
                        <i class="fa fa-plus"></i>
                    </a>
					<div class="acc_content tabcontent collapse"  id="fav_product_request">
						<h4>Favourite Product</h4>
						<div class='include_fav_product_request'>
							<?php $this->load->view('frontend/user/fav_product_request.php'); ?>
						</div>
					</div>
				</div>
				<div class="acc_set">
				<a href="javascript:void(0)">
                        <span class="acc_title">
                            Favourite Candidate
                        </span>            
                        <i class="fa fa-plus"></i>
                    </a>
					<div class="acc_content tabcontent collapse"  id="fav_candidate_request">
						<h4>Favourite Candidate</h4>
						<div class='include_fav_product_request'>
							<?php $this->load->view('frontend/user/fav_candidate_request.php'); ?>
						</div>
					</div>
				</div>
            
            </div>

        </div>
    </div>
</section>
<!-- Modal -->
<div id="add_jobs_error" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      	<h4 class="modal-title">Error!!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <p>To post a job, please reference Subscriptions and Charges for pricing.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- dashboard end -->
