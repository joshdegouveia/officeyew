<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

  | -------------------------------------------------------------------------

  | URI ROUTING

  | -------------------------------------------------------------------------

  | This file lets you re-map URI requests to specific controller functions.

  |

  | Typically there is a one-to-one relationship between a URL string

  | and its corresponding controller class/method. The segments in a

  | URL normally follow this pattern:

  |

  |	example.com/class/method/id/

  |

  | In some instances, however, you may want to remap this relationship

  | so that a different class/function is called than the one

  | corresponding to the URL.

  |

  | Please see the user guide for complete details:

  |

  |	https://codeigniter.com/user_guide/general/routing.html

  |

  | -------------------------------------------------------------------------

  | RESERVED ROUTES

  | -------------------------------------------------------------------------

  |

  | There are three reserved routes:

  |

  |	$route['default_controller'] = 'welcome';

  |

  | This route indicates which controller class should be loaded if the

  | URI contains no data. In the above example, the "welcome" class

  | would be loaded.

  |

  |	$route['404_override'] = 'errors/page_missing';

  |

  | This route will tell the Router which controller/method to use if those

  | provided in the URL cannot be matched to a valid route.

  |

  |	$route['translate_uri_dashes'] = FALSE;

  |

  | This is not exactly a route, but allows you to automatically route

  | controller and method names that contain dashes. '-' isn't a valid

  | class or method name character, so it requires translation.

  | When you set this option to TRUE, it will replace ALL dashes in the

  | controller and method URI segments.

  |

  | Examples:	my-controller/index	-> my_controller/index

  |		my-controller/my-method	-> my_controller/my_method

 */

//$route['default_controller'] = 'login';
$route['default_controller'] = 'home';


$route['404_override'] = '';

$route['translate_uri_dashes'] = FALSE;


$route['my-stripe'] = "StripeController";
$route['stripePost']['post'] = "StripeController/stripePost";
$route['stripepostt'] = "StripeController/stripePost";

/* * ****************** Admin Route ****************** */

$route['admin'] = 'admin/auth';
//$route['admin/seller'] = 'admin/users/sellers';
//$route['admin/buyer'] = 'admin/users/buyers';
$route['admin/edit_product/(:any)'] = 'admin/products/editProduct';

/* * ****************** Admin Route ****************** */
/* * ****************** Website Route ****************** */
$route['register'] = "login/register";
$route['sign-in'] = "login/signin";
$route['forgot-password'] = 'login/forgot_password';

$route['login'] = 'login/index';

$route['dashboard'] = 'user/dashboard';

$route['subscription'] = 'login/subscription';

$route['payment'] = 'login/payment';

$route['payment-method'] = 'login/paymentMethod';

$route['thankyou'] = 'login/regSuccess';

$route['newuser/activation/(:any)'] = 'login/activation';

$route['hashtag/(:any)'] = 'search/hashtag';

$route['about-us'] = 'cms_pages/cms/about-us';
$route['who-we-are'] = 'cms_pages/cms/who-we-are';
$route['how-we-work'] = 'cms_pages/cms/how-we-work';
$route['work-with-us'] = 'cms_pages/cms/work-with-us';
$route['terms-condition'] = 'cms_pages/cms/terms-condition';
$route['privacy-policy'] = 'cms_pages/cms/privacy-policy';
$route['trust-safety'] = 'cms_pages/cms/trust-safety';
$route['support'] = 'cms_pages/cms/support';
$route['help'] = 'cms_pages/cms/help';
$route['contact-us'] = 'cms_pages/contact_us';

//================================================
$route['subscription-charges'] = 'home/subscription_and_charges';
$route['thankyou/(:any)'] = 'home/thank_you';


$route['subscription-boost/(:any)'] = 'payment/subscription_and_boost';
$route['job-posting-subscription/(:any)'] = 'payment/job_posting_subscription';
$route['product-purchase-payment/(:any)'] = 'payment/product_purchase_payment';


$route['installer'] = 'user/installer_listing';
$route['designer'] = 'user/designer_listing';
$route['profile-details/(:any)/(:any)'] = 'user/profile_details';
$route['installer-request'] = 'user/installer_request';


$route['products/categories'] = 'products/product_categories';
$route['products/list/(:any)/(:any)'] = 'products/product_list';
$route['products/list-all'] = 'products/product_list'; // All product list
$route['products/search'] = 'products/product_search';
$route['products/detail/(:any)/(:any)/(:any)/(:any)'] = 'products/product_details'; //=== product details from caregory list [with bread camp] =====//
$route['products/details/(:any)/(:any)'] = 'products/product_details';  //=== product details without bread camp =====//
$route['products/product-purchase/(:any)/(:any)'] = 'products/product_purchase';
$route['products/upload'] = 'products/product_upload';
$route['products/update/(:any)'] = 'products/product_upload';


$route['job-search'] = "user/job_search";
$route['job-details/(:any)/(:any)'] = "user/job_details";





$route['job-candidate'] = "user/job_candidate";
$route['candidate-details/(:any)/(:any)'] = "user/candidate_details";
/* * ****************** Website Route ****************** */
/* * ****************** App Route ****************** */


$route['appregister'] = "App/auth/register";
$route['applogin'] = "App/auth/login";
$route['usertype'] = "App/auth/getuserType";
$route['getcategory'] = "App/auth/getcategory";
$route['allproducts'] = "App/products/getallproducts";
$route['allProduct/(:any)'] = "App/products/getallproducts";
$route['productlist/(:any)/(:any)'] = "App/products/get_product_list";
$route['productdetails/(:any)/(:any)'] = "App/products/product_details";
$route['addfav'] = "App/products/addfavorite";
$route['createpurchasereq'] = "App/products/send_purchase_request";
$route['messageseller'] = "App/products/message_to_seller";
$route['addInstallerRequest'] = "App/products/addinstallerrequest";
$route['getInstaller/(:any)/(:any)/(:any)'] = 'App/products/getinstallerlist';
$route['userDetails/(:any)/(:any)/(:any)'] = 'App/auth/userdetails';
$route['addfavuser'] = 'App/auth/add_favorite_user';
$route['getDesigner/(:any)/(:any)/(:any)'] = 'App/products/getdesignerlist';
$route['addDesignerRequest'] = "App/products/adddesignerrequest";
$route['getJobSearch/(:any)/(:any)/(:any)'] = 'App/products/getjobsearchlist';
$route['jobdetails/(:any)/(:any)'] = "App/products/job_details";
$route['addsaveJob'] = "App/products/save_job";
$route['addappliedJob'] = "App/products/apply_job";
$route['getcandidateSearch/(:any)/(:any)/(:any)'] = 'App/products/getcandidatesearchlist';
$route['candidatedetails/(:any)/(:any)'] = "App/products/candidate_details";
$route['messagecandidate'] = "App/products/message_to_candidate";
$route['addfavcandidate'] = 'App/auth/add_favorite_candidate';




$route['get_product_details'] = "App/auth/get_product_details";
$route['get_jobs'] = "App/auth/get_jobs";
$route['get_candidate_list'] = "App/auth/get_candidate_list";
$route['get_candidate_details'] = "App/auth/get_candidate_details";


//////////////////Buyers///////////////
$route['user_favouite'] = "App/buyers/get_user_favourite";
$route['user_my_order'] = "App/buyers/get_my_orders";
$route['user_submitted_request'] = "App/buyers/get_user_submitted_request";
$route['user_delete_favourite'] = "App/buyers/user_delete_favourite";
$route['getSearchProduct/(:any)'] = 'App/buyers/get_search_product';

/////////////////Sellers/////////////////////

$route['user_recent_purchase_requests'] = "App/sellers/get_user_recent_purchase_requests";
$route['user_my_product'] = "App/sellers/get_user_my_product";
$route['user_purchase_requests'] = "App/sellers/get_user_purchase_requests";
$route['user_purchase_requests'] = "App/sellers/get_user_purchase_requests";
$route['single_purchase_details'] = "App/sellers/get_user_single_purchase_details";
$route['user_subscription_charges'] = "App/sellers/get_user_subscription_charges";
$route['product_add_criteria'] = "App/sellers/get_product_add_criteria";
$route['seller_add_product'] = "App/sellers/user_add_product";
$route['seller_edit_product'] = "App/sellers/user_edit_product";
$route['seller_payment_data'] = "App/sellers/get_payment_data";
$route['getautoloaction/(:any)'] = "App/sellers/get_auto_location";
$route['get_some_data/(:any)'] = "App/sellers/get_some_data";
$route['update_purchase_requests'] = "App/sellers/update_purchase_requests";
$route['get_transaction_list'] = "App/sellers/get_transaction_list";


////////////////Installer///////////////

$route['user_installer_incoming_request'] = "App/auth/get_user_installer_incoming_request";
$route['get_all_request'] = "App/installers/get_all_request";
$route['installer_dashboard'] = "App/installers/installer_dashboard";

////////////////EMPLOYER    /////////
$route['user_recent_job_applicant'] = "App/employers/user_recent_job_applicant";
$route['user_recent_job_posted'] = "App/employers/user_recent_job_posted";
$route['user_my_jobs'] = "App/employers/get_user_my_jobs";
$route['user_all_applicants'] = "App/employers/get_user_all_applicants";
$route['user_find_resume'] = "App/employers/user_find_resume";
$route['user_job_applicants'] = "App/employers/get_user_job_applicants";
$route['user_add_jobs'] = "App/employers/user_add_jobs";
$route['user_update_jobs'] = "App/employers/user_update_jobs";

//////////////////CANDIDATES//////////////
$route['candiadate_dashboard_list_all_jobs'] = "App/candidates/get_candiadate_dashboard_list_all_jobs";
$route['candiadate_all_applied_jobs'] = "App/candidates/get_candiadate_all_applied_jobs";
$route['candidate_list_all_save_jobs'] = "App/candidates/get_candidate_list_all_save_jobs";
$route['candiadate_dashboard_list_all_jobs'] = "App/candidates/get_candiadate_dashboard_list_all_jobs";

$route['candiadate_apply_job'] = "App/candidates/apply_job";
$route['candiadate_remove_apply_jobs'] = "App/candidates/remove_apply_jobs";
$route['candiadate_save_job'] = "App/candidates/save_job";
$route['candiadate_remove_save_job'] = "App/candidates/remove_save_job";
//////////////////////
$route['user_installer_request'] = "App/auth/get_user_installer_request";
$route['user_designer_submitted_request'] = "App/auth/get_user_designer_submitted_request";
$route['user_designer_incoming_request'] = "App/auth/get_user_designer_incoming_request";
$route['user_message_request'] = "App/auth/get_user_message_request";

$route['add_user_fav_candidate'] = "App/auth/add_user_fav_candidate";
$route['remove_user_fav_candidate'] = "App/auth/remove_user_fav_candidate";
$route['get_user_fav_candidate'] = "App/auth/get_user_fav_candidate";

$route['add_user_fav_installer'] = "App/auth/add_user_fav_installer";
$route['remove_user_fav_installer'] = "App/auth/remove_user_fav_installer";
$route['get_user_fav_installer'] = "App/auth/get_user_fav_installer";

$route['add_user_fav_designer'] = "App/auth/add_user_fav_designer";
$route['remove_user_fav_designerr'] = "App/auth/remove_user_fav_designerr";
$route['get_user_fav_designer'] = "App/auth/get_user_fav_designer";


/* * ****************** App Route ****************** */




