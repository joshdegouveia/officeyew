<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if (!empty($meta_data)) { ?>
            <meta name="description" content="<?php echo $meta_data->meta_description; ?>">
            <meta name="key" content="<?php echo $meta_data->meta_key; ?>">
        <?php } ?>
        <title><?php echo (isset($title) ? ucwords($title) . ' | ' : '') . SITE_NAME; ?></title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url(); ?>assets/frontend/images/favicon.ico" type="image/x-icon">
        <!-- Bootstrap CSS-->
        <link href="<?php echo base_url(); ?>assets/frontend/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <!-- Custom CSS -->
        <link href="<?php echo base_url(); ?>assets/frontend/css/global-style.css" rel="stylesheet" type="text/css">
        <!-- Media queries CSS -->
        <link href="<?php echo base_url(); ?>assets/frontend/css/media-queries.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/frontend/css/developer.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/frontend/css/select2.min.css" rel="stylesheet" type="text/css">
        <!-- Carousel CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/owl.carousel.min.css" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <!--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css'>-->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/css/formValidation.min.css'>




        <!-- Common js library -->
        <script src="<?php echo base_url(); ?>assets/frontend/js/jquery-1.11.0.js"></script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo base_url(); ?>assets/frontend/js/bootstrap.min.js"></script>
    </head>

    <body>


        <!-- Header start -->
        <header class="header-hold-wrapper for-Homebg  ">
            <div class="container">
                <div class="topheader-hold">
                    <a class="logo" href="<?php echo base_url(''); ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/logo.png" alt="Logo" title="Logo" class="img-responsive" /></a>

                    <?php
                    if (isset($_SESSION['user_data']) && !empty($_SESSION['user_data'])) {
                        $user = authentication();
//                    	print_r($user);die;
                        ?>
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
					//echo $this->db->last_query();
					$download_status = 'no';
					$_SESSION['user_subscriptions']=$user_subscription;
					/*
					echo '<pre>';
					print_r($user_subscription);
					echo '</pre>';
					*/
					$job_category = array();
					if (count($user_subscription)>0) {
						for ($i=0;$i<count($user_subscription);$i++) {
							$job_category[$user_subscription[$i]['subscription_for_boost_id']] = $user_subscription[$i]['job_category'];
							$job_valid_upto[$user_subscription[$i]['subscription_for_boost_id']] = $user_subscription[$i]['valid_upto'];
							$job_product_no[$user_subscription[$i]['subscription_for_boost_id']] = $user_subscription[$i]['product_no'];
						}
					}
					/*echo '<pre>';
					print_r($job_category);
					echo '</pre>';
					*/
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
					/*echo $max_valid_upto;
					echo '<br>';
					echo $max_resume_no;
					echo '<br>';
					echo $resume_download_permission;
					*/
					$_SESSION['resume_download_permission']=$resume_download_permission;
					$_SESSION['subscription_id']=$key;$_SESSION['job_category'] = $job_categoryy;
					$_SESSION['max_resume_no']=$max_resume_no;
					$_SESSION['max_valid_upto']=$max_valid_upto;
					?>
                        <div class="right-profile">
                            <div class="profile">
                                <div class="profile-img">
                                    <?php
                                    $path = BASE_URL . 'assets/upload/user/profile/no_img.png';
                                    if ($user['filename'] != '') {
                                        $path = BASE_URL . 'assets/upload/user/profile/' . $user['filename'];
                                    }
                                    ?>
                                    <a href="<?php echo base_url('user/profile'); ?>" id="heaser_user_name">
                                        <img src="<?php echo $path ?>" style="width: 200px;" alt="<?= $user['first_name'] ?>">
                                    </a>
                                </div>
                                <div class="profile-name">
                                    <span> <a href="<?php echo base_url('user/profile'); ?>" id="heaser_user_name"><span><?= $user['first_name'] ?></span></a></span>
                                    <form action="<?php echo base_url('login/update_user_status') ?>" id="update_user_type_form" method="post">
                                        <select onchange="update_user_type($(this).val())" name="user_type">
                                            <?php
                                            foreach ($user['user_types'] as $user_type) {
                                                ?>
                                                <option value="<?= $user_type ?>" <?php echo ($user_type == $user['type']) ? "selected" : "" ?>><?= ucfirst($user_type) ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <a href="<?php echo base_url('user/logout'); ?>" class="contact-header"><span>Logout</span></a>
                            <i class="logout-icon"></i>
                            <!--<a href = "<?php echo base_url('about-us'); ?>">About Us</a>-->

                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="right-header-box">
                            <a href="<?php echo base_url('login/signin'); ?>"><i class="fa fa-sign-in" aria-hidden="true"></i> <span>Login</span></a>
                            <a href="<?php echo base_url('login/register'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <span>Sign Up</span></a>
                            <!--<a href="<?php echo base_url('user/profile'); ?>"><i class="fa fa-tachometer" aria-hidden="true"></i> <span>My Dashboard</span></a>-->
                            <!--<a href = "<?php echo base_url('about-us'); ?>">About Us</a>-->
                        </div>
                        <?php
                    }
                    ?>

                </div>

                <nav class="navbar navbar-expand-lg navbar-light custom-nav">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item  <?php echo ((isset($this->commonData['page'])) && ($this->commonData['page'] == 'home')) ? "active" : "" ?>">
                                <a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url("products/list-all") ?>">Office Furniture</a>
                            </li>
                            <li class="nav-item <?php echo ((isset($this->commonData['userType'])) && ($this->commonData['userType'] == 'installer')) ? "active" : "" ?>">
                                <a class="nav-link " href="<?php echo base_url("installer-request") ?>">Installer</a>
                                <!--<a class="nav-link " href="<?php echo base_url("installer-request") ?>">Installer</a>-->
                            </li>
                            <li class="nav-item <?php echo ((isset($this->commonData['userType'])) && ($this->commonData['userType'] == 'designer')) ? "active" : "" ?>">
                                <a class="nav-link" href="<?php echo base_url("designer") ?>">Designer</a>
                            </li>
                            <li class="nav-item <?php echo ((isset($this->commonData['userType'])) && ($this->commonData['userType'] == 'candidate')) ? "active" : "" ?>">
                                <a class="nav-link" href="<?php echo base_url("job-search") ?>">Job Postings</a>
                            </li>
                            <li class="nav-item <?php echo ((isset($this->commonData['userType'])) && ($this->commonData['userType'] == 'employeer')) ? "active" : "" ?>">
                                <a class="nav-link" href="<?php echo base_url("job-candidate") ?>">Job Candidate</a>
                            </li>
                        </ul>
                    </div>


                    <div class="rightPart">
                        <?php
//                        if (!isset($_SESSION['user_data']) || empty($_SESSION['user_data'])) {
                        //                    $user = authentication();
                        //                    if (in_array('seller', $user['user_types'])) {
                        ?>
                        <a href="<?php echo base_url("sign-in?type=seller") ?>" class="sell-btn"><i class="fa fa-camera" aria-hidden="true"></i> Sell</a>
                        <?php
                        //                    }
//                        }
                        ?>
                        <div class = "dropdown">   
                            <button type = "button" class = "btn dropdown-toggle" id = "dropdownMenu1" data-toggle = "dropdown">
                                <i class="fa fa-bars"></i>
                            </button>

                            <ul class = "dropdown-menu" role = "menu" aria-labelledby = "dropdownMenu1">
                               
                                <li role = "presentation">
                                    <a role = "menuitem" tabindex = "-1" href = "<?php echo base_url('about-us'); ?>">About Us</a>
                                </li> 
                                <li role = "presentation">
                                    <a role = "menuitem" tabindex = "-1" href = "<?php echo base_url('how-we-work'); ?>">How Officeyew Works</a>
                                </li>
                                 <li role = "presentation">
									<a role = "menuitem" tabindex = "-1" href = "<?php echo base_url('subscription-charges'); ?>">Subscription & Charges</a>
								</li>
                                <li role = "presentation">
                                    <a role = "menuitem" tabindex = "-1" href = "<?php echo base_url('help'); ?>">Officeyew Guidelines</a>
                                </li>
							
                                <li role = "presentation">
                                    <a role = "menuitem" tabindex = "-1" href = "<?php echo base_url('contact-us'); ?>">Contact Us</a>
                                </li> 
                            </ul>

                        </div>
                    </div>
                </nav>

                <?php if ((isset($this->commonData['page'])) && ($this->commonData['page'] == 'home')) {
                    ?>

                    <div class="home_slide">
                        <h2>Office Furniture</h2>
                        <h4>Categories</h4>
                        <div class="ofc-hold-wrap">
                            <div class="owl-carousel owl-theme" id="ofc-item-slider">
                                <?php foreach ($categories as $cat) { ?>
                                    <?php
                                    $cat_img_src = UPLOADPATH . 'products/product_categories/thumb/' . $cat->filename;
                                    ?>
                                    <a href="<?php echo base_url("products/list/$cat->id/" . str_replace([' ', '_', "'"], '-', $cat->name)) ?>">
                                        <div class="item">
                                            <div class="ofc-item-box">
                                                <!--<i class="ofc-icons" style="background-image:url('<?php echo $cat_img_src; ?>')"></i>-->
                                                <span class="ofc-icons">
                                                    <img src="<?php echo $cat_img_src; ?>" alt="<?php echo $cat->name; ?>" class="def_img">
                                                    <img src="<?php echo $cat_img_src; ?>" alt="<?php echo $cat->name; ?>" class="def_img_hover">
                                                </span>
                                                <h4><?php echo $cat->name; ?></h4>
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }



                if ((isset($this->commonData['header_flag'])) && ($this->commonData['header_flag'] == 'search_cat_and_location')) {
                    ?>
                    <section class="seahching-hold-wrap prod_search padd-tb60">
                        <form class="form-inline"  action="<?php echo base_url("products/search"); ?>" method="get">
                            <div class="form-group sm-width-100">
                                <label class="search-label">Searching for:</label>
                            </div>
                            <div class="form-group col-4 sm-width-45">
                                <select class="form-control select2 select_categories_dropdown" name="category">
                                    <option value="">Select Category</option>
                                    <?php if (count($categories) > 0) { ?>
                                        <?php foreach ($categories as $cat) { ?>
                                            <option value="<?php echo $cat->id; ?>" <?= ($catId == $cat->id) ? "selected" : "" ?>><?php echo $cat->name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="at-label">at</label>
                            </div>
                            <div class="form-group col-4 sm-width-45">

                                <div class="form-group col-12">
                                    <input type="text" class="form-control location_autocomplete_search_input" name="location" value="<?= $ls_location ?>" placeholder="Search city name"   autocomplete="off">
                                    <input type="hidden" class=" location_autocomplete_id" name="location_id" value="<?= $location_id ?>">
                                </div>

                                <div class="form-group  col-12">
                                    <div class="location_autocomplete_list" ></div>
                                </div> 

                                </select> 
                            </div>
                            <div class="form-group sm-width-100">
                                <button type="submit" class="btn btn-search">Search</button>
                            </div>
                        </form>

                    </section>
                    <?php
                } elseif ((isset($this->commonData['header_flag'])) && ($this->commonData['header_flag'] == 'text_only')) {
                    ?>
                    <section class="seahching-hold-wrap prod_search padd-tb60">
                        <div class="heading4">
                            <h2> <?php echo (isset($title) ? ucwords($title) : ''); ?></h2>
                        </div>
                        <?php if (isset($short_description)) {
                            ?>

                            <div class="heading4">
                                <h4> <?php echo (isset($short_description) ? $short_description : ''); ?></h4>
                            </div>
                            <?php
                        }
                        ?>
                    </section>
                    <?php
                } elseif ((isset($this->commonData['header_flag'])) && ($this->commonData['header_flag'] == 'search_designer_installer_list')) {
                    ?>
                    <section class="seahching-hold-wrap prod_search padd-tb60">
                        <form class="form-inline"  action="<?php echo base_url("user/" . $userType . "_search"); ?>" method="get">
                            <div class="form-group sm-width-100">
                                <label class="search-label">Searching for:</label>
                            </div>
                            <div class="form-group col-4 sm-width-45">

                                <div class="form-group col-12">
                                    <input type="text" class="form-control designer_autocomplete_search_input" name="designer" value="<?php
                                    if (!empty($ls_designer)) {
                                        echo $ls_designer;
                                    } else {
                                        echo "";
                                    }
                                    ?>" placeholder="<?php echo "Enter $userType name" ?>"   <?php echo "Enter $userType name" ?>autocomplete="off">
                                    <input type="hidden" class=" designer_autocomplete_id" name="id" value="<?php
                                    if (!empty($id)) {
                                        echo $id;
                                    } else {
                                        echo "";
                                    }
                                    ?>">
                                </div>
                                <!-- <div class="form-group col-12">
                                    <input class="form-control designer_installer_name " name="name" value="<?= $uName ?>" placeholder="<?php echo "Enter $userType name" ?>"  autocomplete="off">
                                    <input type="hidden" class="user_id" name="id" value="<?php echo $uId ?>">
                                </div> -->

                                <div class="form-group  col-12">
                                    <div class="designer_autocomplete_list" ></div>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label class="at-label">at</label>
                            </div>

                            <div class="form-group col-4 sm-width-45">

                                <div class="form-group col-12">
                                    <input type="text" class="form-control location_autocomplete_search_input" name="location" value="<?= $ls_location ?>" placeholder="Search city name"   autocomplete="off">
                                    <input type="hidden" class=" location_autocomplete_id" name="location_id" value="<?= $location_id ?>">
                                </div>

                                <div class="form-group  col-12">
                                    <div class="location_autocomplete_list" ></div>
                                </div> 

                                </select> 
                            </div>
                            <div class="form-group sm-width-100">
                                <button type="submit" class="btn btn-search">Search</button>
                            </div>
                        </form>

                    </section>
			<?php
			}elseif ((isset($this->commonData['header_flag'])) && ($this->commonData['header_flag'] == 'installer_request')) {
?>

                    <section class="seahching-hold-wrap prod_search padd-tb60">
                        <form class="form-inline"  action="<?php echo base_url("user/installer_search"); ?>" method="get">
                            <div class="form-group sm-width-100">
                                <label class="search-label">Searching for:</label>
                            </div>
                            <div class="form-group col-4 sm-width-45">

                                <div class="form-group col-12">
                                    <input type="text" class="form-control installer_autocomplete_search_input" name="installer" value="<?php
                                    if (!empty($uName)) {
                                        echo $uName;
                                    } else {
                                        echo "";
                                    }
                                    ?>" placeholder="<?php echo "Enter installer name" ?>"   <?php echo "Enter installer name" ?>autocomplete="off">
                                    <input type="hidden" class=" installer_autocomplete_id" name="id" value="<?php
                                    if (!empty($uId)) {
                                        echo $uId;
                                    } else {
                                        echo "";
                                    }
                                    ?>">
                                </div>
                                <!-- <div class="form-group col-12">
                                    <input class="form-control designer_installer_name " name="name" value="<?= $uName ?>" placeholder="<?php echo "Enter $userType name" ?>"  autocomplete="off">
                                    <input type="hidden" class="user_id" name="id" value="<?php echo $uId ?>">
                                </div> -->

                                <div class="form-group  col-12">
                                    <div class="designer_autocomplete_list" ></div>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label class="at-label">at</label>
                            </div>

                            <div class="form-group col-4 sm-width-45">

                                <div class="form-group col-12">
                                    <input type="text" class="form-control location_autocomplete_search_input" name="location" value="<?php echo $ls_location ?>" placeholder="Search city name"   autocomplete="off">
                                    <input type="hidden" class=" location_autocomplete_id" name="location_id" value="<?php echo $location_id ?>">
                                </div>

                                <div class="form-group  col-12">
                                    <div class="location_autocomplete_list" ></div>
                                </div> 

                                </select> 
                            </div>
                            <div class="form-group sm-width-100">
                                <button type="submit" class="btn btn-search">Search</button>
                            </div>
                        </form>

                    </section>
                <?php
                        }elseif ((isset($this->commonData['header_flag'])) && ($this->commonData['header_flag'] == 'job_search_list')) {
			?>
				<section class="seahching-hold-wrap prod_search padd-tb60">
                        <form class="form-inline"  action="<?php echo base_url("user/employer_job_search"); ?>" method="get">
                            <div class="form-group sm-width-100">
                                <label class="search-label">Searching for:</label>
                            </div>
                            <div class="form-group col-4 sm-width-45">
                                <div class="form-group col-12">
									<select class="form-control select2 select_categories_dropdown" name="designation">
										<option value="">Select Designation Type</option>
											<option value="Executive" <?php echo  ($ls_type == 'Executive') ? "selected" : "" ?>>Executive</option>
											<option value="Accounting" <?php echo ($ls_type == 'Accounting') ? "selected" : "" ?>>Accounting</option>
											<option value="Sales Management" <?php echo ($ls_type == 'Sales Management') ? "selected" : "" ?>>Sales Management</option>
											<option value="Inside Sales" <?php echo ($ls_type == 'Inside Sales') ? "selected" : ""?>>Inside Sales</option>
											<option value="Administration" <?php echo ($ls_type == 'Administration') ? "selected" : ""?>>Administration</option>
											<option value="Marketing" <?php echo ($ls_type == 'Marketing') ? "selected" : ""?>>Marketing</option>
											<option value="Service" <?php echo ($ls_type == 'Service') ? "selected" : ""?>>Service</option>
											<option value="Designer" <?php echo ($ls_type == 'Designer') ? "selected" : "" ?>>Designer</option>
											<option value="Installer" <?php echo ($ls_type == 'Installer') ? "selected" : "" ?>>Installer</option>
											<option value="Other" <?php echo ($ls_type == 'Other') ? "selected" : "" ?>>Other</option>
									</select>
                                </div>
                                <!-- <div class="form-group col-12">
                                    <input class="form-control designer_installer_name " name="name" value="<?= $uName ?>" placeholder="<?php echo "Enter $userType name" ?>"  autocomplete="off">
                                    <input type="hidden" class="user_id" name="id" value="<?php echo $uId ?>">
                                </div> -->

                                <div class="form-group  col-12">
                                    <div class="designer_autocomplete_list" ></div>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label class="at-label">at</label>
                            </div>

                            <div class="form-group col-4 sm-width-45">
                                <div class="form-group col-12">
									<input type="text" class="form-control location_autocomplete_search_input" name="location" value="<?php echo $ls_location;?>" placeholder="Search city name" autocomplete="off">
									<input type="hidden" class=" location_autocomplete_id" name="location_id" value="<?= $location_id ?>">
                                </div>
                                <div class="form-group  col-12">
                                    <div class="location_autocomplete_list" ></div>
                                </div> 

                                </select> 
                            </div>
                            <div class="form-group sm-width-100">
                                <button type="submit" class="btn btn-search">Search</button>
                            </div>
                        </form>


                    </section>
		<?php
			}elseif ((isset($this->commonData['header_flag'])) && ($this->commonData['header_flag'] == 'job_Candidate_list')) {
		?>
			<section class="seahching-hold-wrap prod_search padd-tb60">
                        <form class="form-inline"  action="<?php echo base_url("user/candidate_search"); ?>" method="get">
                            <div class="form-group sm-width-100">
                                <label class="search-label">Searching for:</label>
                            </div>
                            <div class="form-group col-4 sm-width-45">
                                <div class="form-group col-12">
									<select class="form-control select2 select_categories_dropdown" name="category">
										<option value="">Select Candidate Type</option>
											<option value="Executive" <?php echo  ($ls_type == 'Executive') ? "selected" : "" ?>>Executive</option>
											<option value="Accounting" <?php echo ($ls_type == 'Accounting') ? "selected" : "" ?>>Accounting</option>
											<option value="Sales Management" <?php echo ($ls_type == 'Sales Management') ? "selected" : "" ?>>Sales Management</option>
											<option value="Inside Sales" <?php echo ($ls_type == 'Inside Sales') ? "selected" : ""?>>Inside Sales</option>
											<option value="Administration" <?php echo ($ls_type == 'Administration') ? "selected" : ""?>>Administration</option>
											<option value="Marketing" <?php echo ($ls_type == 'Marketing') ? "selected" : ""?>>Marketing</option>
											<option value="Service" <?php echo ($ls_type == 'Service') ? "selected" : ""?>>Service</option>
											<option value="Designer" <?php echo ($ls_type == 'Designer') ? "selected" : "" ?>>Designer</option>
											<option value="Installer" <?php echo ($ls_type == 'Installer') ? "selected" : "" ?>>Installer</option>
											<option value="Other" <?php echo ($ls_type == 'Other') ? "selected" : "" ?>>Other</option>
									</select>
                                </div>
                                <!-- <div class="form-group col-12">
                                    <input class="form-control designer_installer_name " name="name" value="<?= $uName ?>" placeholder="<?php echo "Enter $userType name" ?>"  autocomplete="off">
                                    <input type="hidden" class="user_id" name="id" value="<?php echo $uId ?>">
                                </div> -->

                                <div class="form-group  col-12">
                                    <div class="designer_autocomplete_list" ></div>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label class="at-label">at</label>
                            </div>

                            <div class="form-group col-4 sm-width-45">
                                <div class="form-group col-12">
                                  <input type="text" class="form-control location_autocomplete_search_input" name="location" value="<?= $ls_location ?>" placeholder="Search city name" autocomplete="off">
								  <input type="hidden" class=" location_autocomplete_id" name="location_id" value="<?= $location_id ?>">
                                </div>
                                <div class="form-group  col-12">
                                    <div class="location_autocomplete_list" ></div>
                                </div> 

                                </select> 
                            </div>
                            <div class="form-group sm-width-100">
                                <button type="submit" class="btn btn-search">Search</button>
                            </div>
                        </form>

                    </section>
		<?php
			}elseif ((isset($this->commonData['page'])) && ($this->commonData['page'] == 'ContactUs')) {
		?>
		  <section class="seahching-hold-wrap prod_search padd-tb60">
                        <div class="heading4">
                            <h2>Contact Us</h2>
                        </div>
                        
                            <div class="heading4">
                                <h4>  </h4>
                            </div>
                                                </section>
		<?php
					}
		?>
            </div>
        </header>

        <!-- Header end -->
        <!-- Navigation start -->
        <!--
                <section class="container">
                    
                </section>
        -->
        <!-- Navigation end -->
		<script>
    $(document).ready(function () {

        $('body').on('keyup', '.location_autocomplete_search_input', function (e) {
            var searchVal = $(".location_autocomplete_search_input").val();
            e.preventDefault(); // Ensure it is only this code that rusn

            $.ajax({
                url: '<?php echo base_url("user/location_autocomplete_search"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'searchVal': searchVal},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".location_autocomplete_list").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });


        });

        $('body').on('click', '.auto_location_city_name', function (e) { // == Auto complete search ====
            var thisName = $(this).html();
            var locName = thisName.replace('<b>', '');
            locName = locName.replace('</b>', '', );
            $(".location_autocomplete_id").val($(this).attr('id'));
            $(".location_autocomplete_search_input").val(locName);
            $('body').find(".location_autocomplete_list").html('');
            console.log(locName);
        });

		$('body').on('keyup', '.installer_autocomplete_search_input', function (e) {
			var searchVal = $(".installer_autocomplete_search_input").val();
            e.preventDefault(); // Ensure it is only this code that rusn
			if (searchVal == '') {
                $(".installer_autocomplete_id").val('');
            }
			   $.ajax({
                url: '<?php echo base_url("user/installer_autocomplete_search"); ?>',
                type: 'post',
                dataType: 'json',
                data: {'searchVal': searchVal},
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $('body').find(".designer_autocomplete_list").html(response.data);
                    } else {
                        toaster_msg('danger', '<i class="fa fa-exclamation"></i>', response.msg);
                    }

                }
            });
		})
		$('body').on('click', '.auto_installer_name', function (e) { // == Auto complete search ====
            var thisName = $(this).html();
            var locName = thisName.replace(/<b>|<\/b>/gi, function (x) {
                return '';
            });
            $(".installer_autocomplete_id").val($(this).attr('id'));
            $(".installer_autocomplete_search_input").val(locName);
            $('body').find(".designer_autocomplete_list").html('');
            console.log(locName);
        });



    });
</script>