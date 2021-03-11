<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library

 */
require_once APPPATH .'libraries/stripe-php/init.php';

class User extends BaseController {

    const MAX_PASSWORD_SIZE_BYTES = 4096;

    public function __construct() {
        parent::__construct();
		//$stripe = getAdminStripe();
//        print_r($stripe);die;
        //$this->apiKey = '';
        /*if (!empty($stripe)) {
            $this->apiKey = $stripe->secret_key;
        }*/
         // Include the Stripe PHP bindings library 
         
        // Set API key 
        
        $this->load->model(['Users_model', 'users_model', 'Login_model', 'Product_model', 'Message_model']);
        $this->load->library('image_lib');
        $this->hash_method = $this->config->item('hash_method', 'ion_auth');
    }

    public function index() {
        $user = authentication();
        $game_id = 0;

        if ($this->input->post('games')) {
            $game_id = $this->input->post('games');
        }

        $data = array();
        $numbers = $this->getNUmbers(true, $game_id);

        if ($numbers !== false) {
            $games = $this->Users_model->getData('games', array('status' => 1), 'id, name');
            $data['games'] = $games;
        }

        $data['user'] = $user;
        $data['numbers'] = $numbers;
        $this->loadScreen('frontend/user/user_home', $data);
    }

    public function logout() {
        $this->session->set_userdata('user_data', '');
        redirect(base_url());
    }

    public function profile() {
        $user = authentication();
        $uid = $user['id'];
        $flag = $this->uri->segment(3);
		$getuserType = array();
		$la_groups = $this->users_model->getData('groups', ['id !=' => 1]);
		$userData = $this->users_model->getUserTypeData($uid);
        $user_detail = $this->users_model->getUserListById($uid);
        if (empty($user_detail)) {
            redirect(base_url());
        }
        $businessData = [];
        $businessId = 0;
		$paymentData = [];

		if(in_array($user['type'], ['seller'])){
			$la_paymentData = $this->Users_model->get_payment_data($uid, $user['type']);
			$paymentData = (!empty($la_paymentData)) ? $la_paymentData[0] : [];
			
		}
        if (in_array($user['type'], ['installer', 'designer'])) {
            $la_businessData = $this->Users_model->get_business_data($uid, $user['type']);
            $businessData = (!empty($la_businessData)) ? $la_businessData[0] : [];
            $businessId = (!empty($la_businessData)) ? $la_businessData[0]->id : 0;
        }


		$detailsData = [];
		$detailsId = 0;
		$jobsData = [];
		$appliedData = [];
		$savedData = [];

		if(in_array($user['type'], ['candidate'])){
			$la_candidateData = $this->Users_model->get_candidate_data($uid, $user['type']);
			$detailsData = (!empty($la_candidateData)) ?  $la_candidateData[0] : [];
			$detailsId = (!empty($la_candidateData)) ? $la_candidateData[0]->details_id : 0;
			$currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
			$limit['limit'] = USER_GRID;
			$limit['offset'] = (($currentPage - 1 ) * USER_GRID);
			$jobsData = $this->Users_model->getjobbyuserType('', $limit,'','','');
			
			$appliedData = $this->Users_model->get_applied_data($uid);
			$savedData = $this->Users_model->get_saved_data($uid);


		}
		$la_jobdetailsData = [];
		$la_findresumedetails = [];
		$get_applicant_details = [];
		$la_subscriptionCharges_employee =[];
		$la_jobdetailsData_count =[];
		if(in_array($user['type'], ['employer'])){
			$currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
			/*$limit['limit'] = USER_GRID;
			$limit['offset'] = (($currentPage - 1 ) * USER_GRID);
			*/
			$limit['limit'] = 2;
			$limit['offset'] = (($currentPage - 1 ) * 2);
			
			$la_jobdetailsData = $this->Users_model->get_jobs_data($uid, $user['type'],$limit);
			$la_jobdetailsData_count = $this->Users_model->get_jobs_data($uid, $user['type']);
			$la_findresumedetails = $this->Users_model->getusersType("'candidate'", '', $limit,'','','');
			$get_applicant_details = $this->Users_model->get_job_applicant($uid);
			$la_subscriptionCharges_employee = $this->Product_model->my_subscription_charges_emp($uid, $limit);

		}

        $user_types = $user['user_types'];
        $la_mySubmittedRequest = [];
		$la_productOrder = [];
        $la_myFavorites = [];
        $la_myProduct = [];
        $la_purchaseRequests = [];
        $la_subscriptionCharges = [];
        $la_productsCondition = [];
        $la_notableDefects = [];

        $limit['limit'] = ITEM_LIST;
        $limit['offset'] = 0;
        $la_pCategory = [];
        $li_mySubmittedRequest_count = 0;
        $li_myFavorites_count = 0;
        $li_purchaseRequests_count = 0;
        $li_myProduct_count = 0;
        $li_subscriptionCharges_count = 0;

        if ($user['type'] == 'buyer') {
            $li_mySubmittedRequest_count = $this->Product_model->mySubmittedRequest_count($uid)[0]->count;
            $li_myFavorites_count = $this->Product_model->my_favorites_list_count($uid)[0]->count;
			$la_productOrder = $this->Users_model->get_product_order_data($uid);
            $la_mySubmittedRequest = $this->Product_model->mySubmittedRequest($uid, $limit);
            $la_myFavorites = $this->Product_model->my_favorites_list($uid, ['limit' => ITEM_MY_FAVORITES, 'offset' => 0]);
        }
        if ($user['type'] == 'seller') {
            $li_purchaseRequests_count = $this->Product_model->my_purchase_requests_count($uid)[0]->count;
            $li_myProduct_count = $this->Product_model->getProductList_count(0, $uid)[0]->count;

            $la_pCategory = $this->Users_model->getData('product_category', array('status' => 1));
            $la_myProduct = $this->Product_model->getProductList(0, $uid, ['limit' => ITEM_PRODACT, 'offset' => 0]);
            $la_purchaseRequests = $this->Product_model->my_purchase_requests($uid, $limit);
            $la_productsCondition = $this->Users_model->getData('products_condition', array('status' => "A"));
            $la_notableDefects = $this->Users_model->getData('products_notable_defects', array('status' => "A"));

            $li_subscriptionCharges_count = $this->Product_model->my_subscription_charges_count($uid)->count;
            $la_subscriptionCharges = $this->Product_model->my_subscription_charges($uid, $limit);
        }
        $la_userLocationData = [];
        $la_userBusenessServiceData = [];
		$all_business_service = [];
        if (in_array($user['type'], ['installer', 'designer'])) {
            $la_userLocationData = $this->Users_model->single_user_location($businessId);
            if ($businessId > 0) {
                $la_userBusenessServiceData = $this->Users_model->get_business_service($uid, $user['type'], $businessId);
				
			
            }
			$all_business_service_search = $this->Users_model->get_business_service_autocomplete_search('', $user['type']);
			if (count($all_business_service_search) > 0) {
				$all_business_service = $all_business_service_search;
			}

        }
        $desReqOrder_by['order_by'] = 'id';
        $desReqOrder_by['sort'] = 'DESC';
        $la_designer_request = $this->Users_model->getData('designer_request', array('user_id' => $uid), '', [], [], $desReqOrder_by, $limit);
        //$la_designer_request_2 = $this->db->select('*')->from('designer_request')->where(array('user_id' => $uid))->order_by('id','desc')->limit(5,0)->get()->result();
        $la_designer_request_data_2=$this->db->select('*')->from('designer_request')->where(array('user_id'=>$uid))->order_by('id','desc')->limit(5,0)->get()->result();
        $la_myDesignerServiceRequest_count = $this->Users_model->getCountDesignerServiceRequest($uid);

        $la_designer_request_received = $this->Users_model->designer_request_received($uid, $limit);
        /*$la_designer_request_received_2 = $this->db->select('dr.*, u.first_name, u.last_name')->from('designer_request dr')->join('designer_request_user dru', 'dru.request_id = dr.id', 'left')->join('users u', 'u.id = dr.user_id', 'left')->where(array("dru.designer_id"=> $uid))->order_by('dr.id', 'DESC')->limit('5','0')->get()->result();*/
        $la_designer_request_received_2 = $this->Users_model->designer_request_received($uid, $limit);
        
        $la_designerRequestReceived_count = $this->Users_model->getCountDesignerServiceRequest_received($uid);


        $installer_order_by['order_by'] = 'installer_request_id';
        $installer_order_by['sort'] = 'DESC';
        $la_installer_request_data = $this->Users_model->getData('installer_request', array('user_id' => $uid), '', [], [], $installer_order_by, $limit);
        //$la_installer_request_data_2 = $this->Users_model->getData_2('installer_request', array('user_id' => $uid), '', [], [], $installer_order_by, 5);
        $la_installer_request_data_2=$this->db->select('*')->from('installer_request')->where(array('user_id'=>$uid))->order_by('installer_request_id','desc')->limit(5,0)->get()->result();
        
		
		
		$la_fav_installer=$this->db->select('favorites_user.*,users.first_name,users.last_name,users.filename,groups.name')->from('favorites_user')->join('users','favorites_user.user_id=users.id','inner')->join('users_groups','users_groups.user_id=users.id','inner')->join('groups','users_groups.group_id=groups.id','inner')->where(array('favorites_user.added_by_user_id'=>$uid,'groups.name'=>'installer','favorites_user.fav_group'=>'installer'))->limit(12,0)->get()->result();
		//echo $this->db->last_query();
		$la_fav_installer_count=$this->db->select('favorites_user.*,users.first_name,users.last_name,users.filename,groups.name')->from('favorites_user')->join('users','favorites_user.user_id=users.id','inner')->join('users_groups','users_groups.user_id=users.id','inner')->join('groups','users_groups.group_id=groups.id','inner')->where(array('favorites_user.added_by_user_id'=>$uid,'groups.name'=>'installer','favorites_user.fav_group'=>'installer'))->get()->result_array();
		
		
		$la_fav_designer=$this->db->select('favorites_user.*,users.first_name,users.last_name,users.filename,groups.name')->from('favorites_user')->join('users','favorites_user.user_id=users.id','inner')->join('users_groups','users_groups.user_id=users.id','inner')->join('groups','users_groups.group_id=groups.id','inner')->where(array('favorites_user.added_by_user_id'=>$uid,'groups.name'=>'designer','favorites_user.fav_group'=>'designer'))->limit(12,0)->get()->result();
		$la_fav_designer_count=$this->db->select('favorites_user.*,users.first_name,users.last_name,users.filename,groups.name')->from('favorites_user')->join('users','favorites_user.user_id=users.id','inner')->join('users_groups','users_groups.user_id=users.id','inner')->join('groups','users_groups.group_id=groups.id','inner')->where(array('favorites_user.added_by_user_id'=>$uid,'groups.name'=>'designer','favorites_user.fav_group'=>'designer'))->get()->result_array();
		
		$la_fav_candidate=$this->db->select('favorites_candidate.*,users.first_name,users.last_name,users.filename,profile_heading')->from('favorites_candidate')->join('users','favorites_candidate.favorite_in_user_id=users.id','inner')->join('users_candidate_details','users_candidate_details.userid=favorites_candidate.favorite_in_user_id','inner')->where(array('favorites_candidate.favorite_by_user_id'=>$uid))->limit(1,0)->get()->result();
		$la_fav_candidate_count=$this->db->select('favorites_candidate.*,users.first_name,users.last_name,users.filename,profile_heading')->from('favorites_candidate')->join('users','favorites_candidate.favorite_in_user_id=users.id','inner')->join('users_candidate_details','users_candidate_details.userid=favorites_candidate.favorite_in_user_id','inner')->where(array('favorites_candidate.favorite_by_user_id'=>$uid))->get()->result();
		
		$la_fav_products=$this->db->select('my_favorites.*,products.name')->from('my_favorites')->join('products','my_favorites.product_id=products.id','inner')->where(array('my_favorites.added_by_user_id'=>$uid))->get()->result();
		//echo $this->db->last_query();
        $li_installerRequestData_count = $this->Users_model->getCountInstallerRequest($uid)->count;

        $la_installer_request_received = $this->Users_model->installer_request_received($uid, $limit, $installer_order_by);
        $la_installer_request_received_2= $this->db->select('ir.*, u.first_name, u.last_name')->from('installer_request ir')->join('installer_request_map irm', 'irm.request_id = ir.installer_request_id', 'left')->join('users u', 'u.id = ir.user_id', 'left')->where("irm.installer_id = $uid")->order_by('ir.installer_request_id', 'DESC')->limit(5,0)->get()->result();
        $la_installerRequestReceived_count = $this->Users_model->getCountInstallerRequest_received($uid)->count;
//        print_r($la_installerRequestReceived_count);die;

        $li_myMessageList_count = $this->Message_model->my_message_list_count($uid)[0]->count;
//        $la_myMessageList = $this->Message_model->my_message_list($uid, $limit);
        $la_myMessageListAll = $this->Message_model->my_message_list($uid);
	
		$created_at = date('Y-m-d H:i:s');
		$where_arr = array('job_posting_subscription.status'=>'A','job_posting_subscription.user_id'=>$user['id'],'job_posting_subscription.valid_upto>='=>$created_at);	
		$query_subscription = $this->db->select('job_posting_subscription.*,job_posting_subscription.job_category,job_posting_subscription.valid_upto')->from('job_posting_subscription')->join('job_posting_charges','job_posting_subscription.subscription_id=job_posting_charges.job_posting_charges_id')->where($where_arr);
		$user_subscription=$query_subscription->get()->result_array();
//        print_r($la_userLocationData);
//        die;
		$data['user_subscription'] = $user_subscription;
        $data['flag'] = $flag;
        $data['user'] = $user;
		$data['la_groups'] = $la_groups;
		$data['user_type_now'] = $userData;
        $data['currentPage'] = 1;
        $data['user_detail'] = $user_detail[0];
        $data['businessData'] = $businessData;
		$data['paymentDetailsData'] = $paymentData; 
		$data['candidateDetailsData'] = $detailsData;
		$data['candidate_jobData'] = $jobsData;
		$data['applied_details'] = $appliedData;
		$data['all_business_service'] = $all_business_service;
		$data['saved_details'] = $savedData;
		$data['posted_jobs'] = $la_jobdetailsData;
		$data['posted_jobs_count'] = $la_jobdetailsData_count;
		$data['find_resume'] = $la_findresumedetails;
		$data['applicants_details'] = $get_applicant_details;
        $data['la_pCategory'] = $la_pCategory;
        $data['li_mySubmittedRequest_count'] = $li_mySubmittedRequest_count;
        $data['li_myFavorites_count'] = $li_myFavorites_count;
        $data['li_purchaseRequests_count'] = $li_purchaseRequests_count;
        $data['li_myProduct_count'] = $li_myProduct_count;

        $data['la_mySubmittedRequest'] = $la_mySubmittedRequest;
		$data['la_myProductOrder'] = $la_productOrder;
        $data['la_myFavorites'] = $la_myFavorites;
        $data['la_myProduct'] = $la_myProduct;
        $data['la_purchaseRequests'] = $la_purchaseRequests;
        $data['li_subscriptionCharges_count'] = $li_subscriptionCharges_count;
        $data['la_subscriptionCharges'] = $la_subscriptionCharges;
		$data['la_subscriptionCharges_employee'] = $la_subscriptionCharges_employee;
        $data['li_myMessageList_count'] = $li_myMessageList_count;
//        $data['la_myMessageList'] = $la_myMessageList;
        $data['la_myMessageListAll'] = $la_myMessageListAll;
        $data['la_productsCondition'] = $la_productsCondition;
        $data['la_notableDefects'] = $la_notableDefects;
        $data['la_userLocationData'] = $la_userLocationData;
        $data['la_userBusenessServiceData'] = $la_userBusenessServiceData;

        $data['la_designer_request_data'] = $la_designer_request;
        $data['la_designer_request_data_2'] = $la_designer_request_data_2;
        $data['la_myDesignerServiceRequest_count'] = $la_myDesignerServiceRequest_count->count;
        $data['la_designer_request_received'] = $la_designer_request_received;
        $data['la_designer_request_received_2']=$la_designer_request_received_2;
        $data['la_designerRequestReceived_count'] = $la_designerRequestReceived_count->count;

        $data['la_installer_request_data'] = $la_installer_request_data;
        $data['la_installer_request_data_2'] = $la_installer_request_data_2;

        $data['li_installerRequestData_count'] = $li_installerRequestData_count;
        $data['la_installer_request_received'] = $la_installer_request_received;
        $data['la_installer_request_received_2'] = $la_installer_request_received_2;
        $data['la_installerRequestReceived_count'] = $la_installerRequestReceived_count;
		$data['location_id'] = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
        $data['ls_type'] =  (isset($_GET['designation'])) ? $_GET['designation'] : "";
        $data['ls_location'] =  (isset($_GET['location'])) ? $_GET['location'] : "";
		$data['la_designer_request_data_2']=$la_designer_request_data_2;
		
		$data['la_fav_installer']=$la_fav_installer;
		$data['la_fav_installer_count'] = $la_fav_installer_count;
		$data['la_fav_designer']=$la_fav_designer;
		$data['la_fav_designer_count']=$la_fav_designer_count;
		$data['la_fav_candidate']=$la_fav_candidate;
		$data['la_fav_candidate_count']=$la_fav_candidate_count;
		$data['la_fav_products']=$la_fav_products;
		
		

        $this->loadScreen('frontend/user/profile', $data);
    }


		public function candidate_dashboard_employer_job_search(){
		$loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }
		$currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
        $uName = (isset($_GET['designation']) && ($_GET['designation'] != '')) ? str_replace(["+"], " ", $_GET['designation']) : '';
        $location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
		$locationName = (isset($_GET['location'])) ? $_GET['location'] : "";
		$limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);
		$la_jobs_count = $this->Users_model->getjobbyuser_count($loggedId);
		$jobsData = $this->Users_model->getjobbyuserType( $loggedId, $limit,$uName,$locationName,$location_id);
		$appliedData = $this->Users_model->get_applied_data($loggedId);
		$savedData = $this->Users_model->get_saved_data($loggedId);
		$la_candidateData = $this->Users_model->get_candidate_data($loggedId, $user['type']);
		$detailsData = (!empty($la_candidateData)) ?  $la_candidateData[0] : [];
		$detailsId = (!empty($la_candidateData)) ? $la_candidateData[0]->details_id : 0;
		$user_detail = $this->users_model->getUserListById($loggedId);
		$li_myMessageList_count = $this->Message_model->my_message_list_count($loggedId)[0]->count;
//        $la_myMessageList = $this->Message_model->my_message_list($uid, $limit);
        $la_myMessageListAll = $this->Message_model->my_message_list($loggedId);

		$data['user'] = $user;
        $data['currentPage'] = 1;
		$data['user_detail'] = $user_detail[0];
		$data['candidateDetailsData'] = $detailsData;
		$data['candidate_jobData'] = $jobsData;
		$data['applied_details'] = $appliedData;
		$data['saved_details'] = $savedData;
		$data['li_myMessageList_count'] = $li_myMessageList_count;
//        $data['la_myMessageList'] = $la_myMessageList;
        $data['la_myMessageListAll'] = $la_myMessageListAll;
		$data['location_id'] = $location_id;;
        $data['ls_type'] =  (isset($_GET['designation'])) ? $_GET['designation'] : "";;
        $data['ls_location'] =  (isset($_GET['location'])) ? $_GET['location'] : "";;

		$this->loadScreen('frontend/user/profile', $data);

	}

	public function candidate_dashboard_employer_job_advance_search(){
		$loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }
		$currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
		$job_title = (isset($_GET['job_title']) && ($_GET['job_title'] != '')) ? str_replace(["+"], " ", $_GET['job_title']) : '';
		$job_desc = (isset($_GET['job_description']) && ($_GET['job_description'] != '')) ? str_replace(["+"], " ", $_GET['job_description']) : '';
		$experience = (isset($_GET['experience']) && ($_GET['experience'] != '')) ? str_replace(["+"], " ", $_GET['experience']) : '';
		$locationName = (isset($_GET['preferred_location'])) ? $_GET['preferred_location'] : "";
		$designation = (isset($_GET['designation']) && ($_GET['designation'] != '')) ? str_replace(["+"], " ", $_GET['designation']) : '';
		$avl_time_frame = (isset($_GET['avl_time_frame']) && ($_GET['avl_time_frame'] != '')) ? str_replace(["+"], " ", $_GET['avl_time_frame']) : '';
		$travel = (isset($_GET['travel_required']) && ($_GET['travel_required'] != '')) ? str_replace(["+"], " ", $_GET['travel_required']) : '';

		$limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);
		$la_jobs_count = $this->Users_model->getjobbyuser_count($loggedId);
		$jobsData = $this->Users_model->getjobbyadvanceType( $loggedId, $limit,$job_title,$job_desc,$experience,$designation,$locationName,$avl_time_frame,$travel);
		$appliedData = $this->Users_model->get_applied_data($loggedId);
		$savedData = $this->Users_model->get_saved_data($loggedId);
		$la_candidateData = $this->Users_model->get_candidate_data($loggedId, $user['type']);
		$detailsData = (!empty($la_candidateData)) ?  $la_candidateData[0] : [];
		$detailsId = (!empty($la_candidateData)) ? $la_candidateData[0]->details_id : 0;
		$user_detail = $this->users_model->getUserListById($loggedId);
		$li_myMessageList_count = $this->Message_model->my_message_list_count($loggedId)[0]->count;
//        $la_myMessageList = $this->Message_model->my_message_list($uid, $limit);
        $la_myMessageListAll = $this->Message_model->my_message_list($loggedId);

		$data['user'] = $user;
        $data['currentPage'] = 1;
		$data['user_detail'] = $user_detail[0];
		$data['candidateDetailsData'] = $detailsData;
		$data['candidate_jobData'] = $jobsData;
		$data['applied_details'] = $appliedData;
		$data['saved_details'] = $savedData;
		$data['li_myMessageList_count'] = $li_myMessageList_count;
//        $data['la_myMessageList'] = $la_myMessageList;
        $data['la_myMessageListAll'] = $la_myMessageListAll;
		$data['location_id'] = $location_id;;
        $data['ls_type'] =  (isset($_GET['designation'])) ? $_GET['designation'] : "";;
        $data['ls_location'] =  (isset($_GET['location'])) ? $_GET['location'] : "";;

		$this->loadScreen('frontend/user/profile', $data);
	}



    public function ajax_pagination_submitted_request() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $limit['limit'] = ITEM_LIST;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_LIST);

            $li_mySubmittedRequest_count = $this->Product_model->mySubmittedRequest_count($uid)[0]->count;
            $la_mySubmittedRequest = $this->Product_model->mySubmittedRequest($uid, $limit);

            ob_start();
            include(APPPATH . 'views/frontend/user/include_submitted_request.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        echo json_encode($response);
    }

    public function ajax_my_favorites() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $limit['limit'] = ITEM_MY_FAVORITES;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_MY_FAVORITES);

            $li_myFavorites_count = $this->Product_model->my_favorites_list_count($uid)[0]->count;
            $la_myFavorites = $this->Product_model->my_favorites_list($uid, $limit);

            ob_start();
            include(APPPATH . 'views/frontend/user/include_my_favorites.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        echo json_encode($response);
    }

    public function ajax_purchase_requests() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $limit['limit'] = ITEM_LIST;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_LIST);

            $li_purchaseRequests_count = $this->Product_model->my_purchase_requests_count($uid)[0]->count;
            $la_purchaseRequests = $this->Product_model->my_purchase_requests($uid, $limit);

            ob_start();
            include(APPPATH . 'views/frontend/user/include_purchase_requests.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        echo json_encode($response);
    }

    public function ajax_subscription_charges() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $limit['limit'] = ITEM_LIST;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_LIST);

            $li_subscriptionCharges_count = $this->Product_model->my_subscription_charges_count($uid)->count;
            $la_subscriptionCharges = $this->Product_model->my_subscription_charges($uid, $limit);

            ob_start();
            include(APPPATH . 'views/frontend/user/include_subscription_charges.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a seller');
        }
        echo json_encode($response);
    }

    public function ajax_subscription_charges_details() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('seller', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');
            $thisId = $_POST['thisId'];
            $thisIdArr = explode("__", $thisId);
            $rowId = $thisIdArr[1];
            $la_data = $this->Product_model->single_subscription_charges($rowId);


//            print_r($top_subscription);die;
            if (!empty($la_data)) {
                $top_subscription = $this->Product_model->top_subscription($rowId);

                $response['success'] = true;
                $response['data'] = $la_data;
                $response['top_subscription'] = (($la_data->price < $top_subscription->monthly) || (($la_data->price < $top_subscription->weekly))) ? 0 : 1;
                $response['created_at'] = date("d-m-Y H:i", strtotime($la_data->created_at));
                $response['expired_at'] = date("d-m-Y H:i", strtotime("+$la_data->duration_in_days days", strtotime($la_data->created_at)));
                $response['msg'] = "Success";
            } else {
                $response = array('success' => false, 'msg' => 'Data not found.');
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a seller');
        }
        echo json_encode($response);
    }

	public function download_resume(){
		$user = authentication(false);
		$user_d = $this->db->select('*')->from('users')->where(array('id'=>$user['id']))->get()->result_array();
		$resume_search_count = $user_d[0]['resume_search_count'];
		
		$created_at = date('Y-m-d H:i:s');	
		$subscription_id = $_POST['subscription_id'];
		$subscription_category = $_POST['job_category'];
		$max_resume_no = $_POST['max_resume_no'];
		$max_valid_upto=$_POST['max_valid_upto'];
		
		if (($subscription_category=='one_time')&& ($resume_search_count<$max_resume_no)){
			if (!empty($resume_search_count)) {
				$resume_search_count = $resume_search_count+1;
			}else{
				$resume_search_count =1;
			}
			$up_sql = "update users set `resume_search_count`= '".$resume_search_count."' where id='".$user['id']."' ";
			$this->db->query($up_sql);
			echo "success";
		}elseif(($subscription_category=='per_post')||(($subscription_category=='monthly'))){
			if ($max_valid_upto!='unlimited') {
				if (strtotime($created_at)<=strtotime($max_valid_upto)) {
					if (!empty($resume_search_count)) {
						$resume_search_count = $resume_search_count+1;
					} else {
						$resume_search_count =1;
					}
					$up_sql = "update users set `resume_search_count`= '".$resume_search_count."' where id='".$user['id']."' ";
					$this->db->query($up_sql);
					echo "success";
				}
			}else{
				/*$up_sql = "update job_posting_subscription set `status`= 'Ar' where subscription_id='".$subscription_id."' 
						   and user_id = '".$user['id']."' ";*/
				$up_sql = "update job_posting_subscription set `status`= 'Ar' where job_category='one_time'
						   and user_id = '".$user['id']."' ";
				$this->db->query($up_sql);
				echo "error";
			}
			
		}else{
			/* $up_sql = "update job_posting_subscription set `status`= 'Ar' where subscription_id='".$subscription_id."'
						   and user_id = '".$user['id']."' ";*/
			$up_sql = "update job_posting_subscription set `status`= 'Ar' where job_category='one_time'
					   and user_id = '".$user['id']."' ";
			$this->db->query($up_sql);
			echo "error";
		}
		
	}
	public function ajax_subscription_charges_details_emp()
	{
		$user = authentication(false);
		if ((isset($user['id']) && ($user['id'] != '')) && (in_array('employer', $user['user_types']))) {
			$uid = $user['id'];
			$response = array('success' => false, 'msg' => 'Unable to process');
			$thisId = $_POST['thisId'];
			$thisIdArr = explode("__", $thisId);
			$rowId = $thisIdArr[1];
			$la_data = $this->Product_model->single_subscription_charges_emp($rowId);


			//print_r($top_subscription);die;
			if (!empty($la_data)) {
				$top_subscription = $this->Product_model->top_subscription($rowId);

				$response['success'] = true;
				$response['data'] = $la_data;
				$response['top_subscription'] = (($la_data->price < $top_subscription->monthly) || (($la_data->price < $top_subscription->weekly))) ? 0 : 1;
				$response['created_at'] = date("d-m-Y H:i", strtotime($la_data->created_at));
				$response['expired_at'] = date("d-m-Y H:i", strtotime("+$la_data->duration_in_days days", strtotime($la_data->created_at)));
				$response['msg'] = "Success";
			} else {
				$response = array('success' => false, 'msg' => 'Data not found.');
			}
		} else {
			$response = array('success' => false, 'msg' => 'Please login as a seller');
		}
		echo json_encode($response);
	}
    
    
    public function ajax_my_product() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $sort_by = (isset($_POST['sort_by']) && ($_POST['sort_by'] != '')) ? $_POST['sort_by'] : "latest";

            if ($sort_by == 'boost') {
                $orderBy['orderBy'] = 'p.is_boost';
                $orderBy['type'] = 'DESC';
            } elseif ($sort_by == 'name') {
                $orderBy['orderBy'] = 'p.name';
                $orderBy['type'] = 'ASC';
            } else {
                $orderBy['orderBy'] = 'p.id';
                $orderBy['type'] = 'DESC';
            }

            $limit['limit'] = ITEM_PRODACT;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_PRODACT);

            $li_myProduct_count = $this->Product_model->getProductList_count(0, $uid)[0]->count;
            $la_myProduct = $this->Product_model->getProductList(0, $uid, $limit, '', '', '', $orderBy);

            ob_start();
            include(APPPATH . 'views/frontend/user/include_my_product.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a seller');
        }
        echo json_encode($response);
    }
	public function ajax_installer_request() {
        //$user = authentication();
        
        $user = $this->session->userdata('user_data');
        //echo '<pre>';
        //print_r($user);

		$loggedId = 0;
		$uId =0;
        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $loggedId = $user['id'];
            $uId = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $sort_by = (isset($_POST['sort_by']) && ($_POST['sort_by'] != '')) ? $_POST['sort_by'] : "latest";
			$location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
           
		    $ITEM_PRODACT =12;
            $limit['limit'] = $ITEM_PRODACT;
            $limit['offset'] = (($currentPage - 1 ) * $ITEM_PRODACT);

            $la_usersData_count =  $this->Users_model->getUserReq_count("'installer'", $loggedId);
            $la_usersData = $this->Users_model->getUsersByUserType_2("installer", $loggedId, $limit, '', '',$uId, $location_id);
			
            ob_start();
            include(APPPATH . 'views/frontend/user/installer_request_paging.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
        	$currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
        	$location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
        	$ITEM_PRODACT =12;
            $limit['limit'] = $ITEM_PRODACT;
            $limit['offset'] = (($currentPage - 1 ) * $ITEM_PRODACT);
            $la_usersData_count =  $this->Users_model->getUserReq_count("'installer'", $loggedId);
            $la_usersData = $this->Users_model->getUsersByUserType_2("installer", $loggedId, $limit, '', '',$uId, $location_id);
            //echo $this->db->last_query();
			
            ob_start();
            include(APPPATH . 'views/frontend/user/installer_request_paging.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        }
        echo json_encode($response);
        
    }
	
	public function ajax_designer_request() {
        //$user = authentication();
        
        $user = $this->session->userdata('user_data');
       

		$loggedId = 0;
		$uId =0;
        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $loggedId = $user['id'];
            $uId = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $sort_by = (isset($_POST['sort_by']) && ($_POST['sort_by'] != '')) ? $_POST['sort_by'] : "latest";
			$location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
           
		    $ITEM_PRODACT =12;
            $limit['limit'] = $ITEM_PRODACT;
            $limit['offset'] = (($currentPage - 1 ) * $ITEM_PRODACT);

            $la_usersData_count =  $this->Users_model->getUserReq_count("'designer'", $loggedId);
            $la_usersData = $this->Users_model->getUsersByUserType_2("designer", $loggedId, $limit, '', '',$uId, $location_id);
			
            ob_start();
            include(APPPATH . 'views/frontend/user/designer_request_paging.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
        	$currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
        	$location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
        	$ITEM_PRODACT =12;
            $limit['limit'] = $ITEM_PRODACT;
            $limit['offset'] = (($currentPage - 1 ) * $ITEM_PRODACT);
            $la_usersData_count =  $this->Users_model->getUserReq_count("'designer'", $loggedId);
            $la_usersData = $this->Users_model->getUsersByUserType_2("designer", $loggedId, $limit, '', '',$uId, $location_id);
            //echo $this->db->last_query();
			
            ob_start();
            include(APPPATH . 'views/frontend/user/designer_request_paging.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        }
        echo json_encode($response);
        
    }
	
	
	public function ajax_my_jobs() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $sort_by = (isset($_POST['sort_by']) && ($_POST['sort_by'] != '')) ? $_POST['sort_by'] : "latest";

            if ($sort_by == 'boost') {
                $orderBy['orderBy'] = 'p.is_boost';
                $orderBy['type'] = 'DESC';
            } elseif ($sort_by == 'name') {
                $orderBy['orderBy'] = 'p.name';
                $orderBy['type'] = 'ASC';
            } else {
                $orderBy['orderBy'] = 'p.id';
                $orderBy['type'] = 'DESC';
            }
		    $ITEM_PRODACT =12;
            $limit['limit'] = $ITEM_PRODACT;
            $limit['offset'] = (($currentPage - 1 ) * $ITEM_PRODACT);

            /*
            $li_myProduct_count = $this->Product_model->getProductList_count(0, $uid)[0]->count;
            $la_myProduct = $this->Product_model->getProductList(0, $uid, $limit, '', '', '', $orderBy);
            */
            $posted_jobs = $this->Users_model->get_jobs_data($uid, $user['type'],$limit);
			$posted_jobs_count = $this->Users_model->get_jobs_data($uid, $user['type']);
            ob_start();
            include(APPPATH . 'views/frontend/user/include_my_jobs.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a seller');
        }
        echo json_encode($response);
    }
	public function ajax_my_fav_ins() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            
			$ITEM_PRODACT = 12;
            $limit['limit'] = $ITEM_PRODACT;
            $limit['offset'] = (($currentPage - 1 ) * $ITEM_PRODACT);

            $la_fav_installer_count = $this->db->select('favorites_user.*,users.first_name,users.last_name,users.filename,groups.name')->from('favorites_user')->join('users','favorites_user.user_id=users.id','inner')->join('users_groups','users_groups.user_id=users.id','inner')->join('groups','users_groups.group_id=groups.id','inner')->where(array('favorites_user.added_by_user_id'=>$uid,'groups.name'=>'installer','favorites_user.fav_group'=>'installer'))->get()->result_array();
            $this->db->select('favorites_user.*,users.first_name,users.last_name,users.filename,groups.name')->from('favorites_user')->join('users','favorites_user.user_id=users.id','inner')->join('users_groups','users_groups.user_id=users.id','inner')->join('groups','users_groups.group_id=groups.id','inner')->where(array('favorites_user.added_by_user_id'=>$uid,'groups.name'=>'installer','favorites_user.fav_group'=>'installer'));
             if (!empty($limit)) {
            	$this->db->limit($limit['limit'], $limit['offset']);
       		 }
            
            $la_fav_installer =$this->db->get()->result();

            ob_start();
            include(APPPATH . 'views/frontend/user/fav_installer_request.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login');
        }
        echo json_encode($response);
    }
   
   
   public function ajax_my_fav_designer() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            
			$ITEM_PRODACT = 12;
            $limit['limit'] = $ITEM_PRODACT;
            $limit['offset'] = (($currentPage - 1 ) * $ITEM_PRODACT);

            $la_fav_designer_count=$this->db->select('favorites_user.*,users.first_name,users.last_name,users.filename,groups.name')->from('favorites_user')->join('users','favorites_user.user_id=users.id','inner')->join('users_groups','users_groups.user_id=users.id','inner')->join('groups','users_groups.group_id=groups.id','inner')->where(array('favorites_user.added_by_user_id'=>$uid,'groups.name'=>'designer','favorites_user.fav_group'=>'designer'))->get()->result_array();
            $this->db->select('favorites_user.*,users.first_name,users.last_name,users.filename,groups.name')->from('favorites_user')->join('users','favorites_user.user_id=users.id','inner')->join('users_groups','users_groups.user_id=users.id','inner')->join('groups','users_groups.group_id=groups.id','inner')->where(array('favorites_user.added_by_user_id'=>$uid,'groups.name'=>'designer','favorites_user.fav_group'=>'designer'));
             if (!empty($limit)) {
            	$this->db->limit($limit['limit'], $limit['offset']);
       		 }
            
            $la_fav_designer =$this->db->get()->result();

            ob_start();
            include(APPPATH . 'views/frontend/user/fav_designer_request.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login ');
        }
        echo json_encode($response);
    }
    public function ajax_my_message_list() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $limit['limit'] = ITEM_LIST;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_LIST);

            $li_myMessageList_count = $this->Message_model->my_message_list_count($uid)[0]->count;
            $la_myMessageListAll = $this->Message_model->my_message_list($uid, $limit);

            ob_start();
            include(APPPATH . 'views/frontend/user/include_my_message_list.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        echo json_encode($response);
    }

	public function bankDataUpdate(){
		$user = authentication();
        $uid = $user['id'];
        $response = array('success' => false, 'msg' => 'Unable to process');
		$this->form_validation->set_rules('acc_number', 'Account Number', 'required');
        $this->form_validation->set_rules('routing_number', 'Routing Number', 'required');

		$post['bank_account_number'] = $this->input->post('acc_number');
        $post['bank_routing_number'] = $this->input->post('routing_number');

		if ($this->form_validation->run() == FALSE) {
            $response['msg'] = str_replace(["<p>"], " ", validation_errors());
            $response['msg'] = str_replace(["</p>"], "<br>", $response['msg']);
        } else {
			$bankId = $this->Users_model->payment_data_update($uid, $post);
			if($bankId){
				$response = array('success' => true, 'msg' => 'Bank Details Updated Successfully!');
			}else{
				$response = array('success' => false, 'msg' => 'Something Went Wrong!');
			}
		}
		echo json_encode($response);

	}

	public function profileDataUpdate()
	{
		// Update own profile data by Ajax
		$user = authentication();
		$uid = $user['id'];
		$response = array('success' => false, 'msg' => 'Unable to process');

		$this->form_validation->set_rules('first_name', 'first name', 'required');
		$this->form_validation->set_rules('last_name', 'last name', 'required');
		$this->form_validation->set_rules('phone', 'phone', 'required');
		$this->form_validation->set_rules('address', 'address', 'required');
		
		if (in_array($user['type'], ['installer', 'designer'])) {
			$this->form_validation->set_rules('company_name', 'business name', 'required');
			$this->form_validation->set_rules('years_of_experience', 'years of experience', 'required');
			$this->form_validation->set_rules('company_address', 'business address ', 'required');
			//            $this->form_validation->set_rules('business_services', 'business services ', 'required');
		}
		if (in_array($user['type'], ['candidate'])) {
			$this->form_validation->set_rules('skills', 'Skills', 'required');
			$this->form_validation->set_rules('years_of_experience', 'Years Of Experience', 'required');
			//$this->form_validation->set_rules('location', 'Location', 'required');
			$this->form_validation->set_rules('avl_time_frame', 'Availability Time Frame', 'required');
			$this->form_validation->set_rules('designation', 'Designation', 'required');
			$this->form_validation->set_rules('travel', 'Travel', 'required');
			//$this->form_validation->set_rules('apply_anonymous', 'Apply as anonymous', 'required');
		}
		$post['first_name'] = $this->input->post('first_name');
		$post['last_name'] = $this->input->post('last_name');
		$post['phone'] = $this->input->post('phone');
		$post['address'] = $this->input->post('address');
		//        print_r($post);die;

		if (in_array($user['type'], ['seller', 'installer', 'designer'])) {
			$post['stripe_secret_key'] = $this->input->post('stripe_secret_key');
			$post['stripe_publish_key'] = $this->input->post('stripe_publish_key');
		}
		if (in_array($user['type'], ['installer', 'designer'])) {
			$bPost['company_name'] = $this->input->post('company_name');
			$bPost['years_of_experience'] = $this->input->post('years_of_experience');
			$bPost['company_address'] = $this->input->post('company_address');
			$bPost['insured'] = $this->input->post('insured');
			$bPost['license_and_bonded'] = $this->input->post('license_and_bonded');
		}

		if (in_array($user['type'], ['candidate'])) {
			$cPost['candidate_skills'] = $this->input->post('skills');
			$cPost['candidate_experience'] = $this->input->post('years_of_experience');
			$cPost['profile_heading'] = $this->input->post('profile_heading');
			$cPost['candidate_location'] = 'kolkata';
			$cPost['candidate_timeframe'] = $this->input->post('avl_time_frame');
			$cPost['candidate_designation'] = $this->input->post('designation');
			$cPost['candidate_travel'] = $this->input->post('travel');
			$cPost['apply_as_anonymous'] = $this->input->post('apply_anonymous');
			$location_id_arr = $this->input->post('location_id');
		}
		$la_userType = $this->input->post('user_type');
		
		if(empty($la_userType))
		{
			$this->form_validation->set_rules('user_type', 'User Type', 'required');
		}
		

		//        print_r($_POST);
		//        die;

		if (in_array($user['type'], ['installer', 'designer'])) {

			$la_post = $this->input->post();
			if (isset($la_post['location_id']) && count($la_post['location_id']) > 0) {

			} else {
				$response = array('success' => false, 'data' => $la_post, 'msg' => 'Please add business location!');
				echo json_encode($response);
				exit();
			}

			if (isset($la_post['services_id']) && count($la_post['services_id']) > 0) {

			} else {
				$response = array('success' => false, 'data' => $la_post, 'msg' => 'Please add business services!');
				echo json_encode($response);
				exit();
			}
		}



		if ($this->form_validation->run() == FALSE) {
			$response['msg'] = str_replace(["<p>"], " ", validation_errors());
			$response['msg'] = str_replace(["</p>"], "<br>", $response['msg']);
		} else {

			if (in_array($user['type'], ['installer', 'designer'])) {
				$la_post = $this->input->post();
				$businessId = $this->Users_model->business_data_update($uid, $user['type'], $bPost);
				if ($businessId > 0) {
					if (isset($la_post['location_id']) && count($la_post['location_id']) > 0) {
						$this->Users_model->deleteData('users_business_location', ['business_id' => $businessId]);
						foreach ($la_post['location_id'] as $city_id) {
							$returnLocationData = $this->Users_model->getData('users_business_location', ['business_id' => $businessId, 'city_id' => $city_id]);
							if (count($returnLocationData) == 0) {
								$this->Users_model->insertData('users_business_location', ['business_id' => $businessId, 'city_id' => $city_id]);
							}
						}
					}


					if (isset($la_post['services_id']) && count($la_post['services_id']) > 0) {
						$this->Users_model->deleteData('users_business_services_map', ['business_id' => $businessId]);
						foreach ($la_post['services_id'] as $service_id) {

							$returnServiceData = $this->Users_model->getData('users_business_services_map', ['business_id' => $businessId, 'services_id' => $service_id]);
							if (count($returnServiceData) == 0) {
								$getserviceInfo = '';
								if ($service_id == 6 || $service_id == 11) {
									$getserviceInfo = $this->input->post('other_service');
								}
								$this->Users_model->insertData('users_business_services_map', ['business_id' => $businessId, 'services_id' => $service_id, 'service_info' => $getserviceInfo]);
							}
						}
					}
				}
			}

			if (in_array($user['type'], ['candidate'])) {

				$candidateId = $this->Users_model->candidate_data_update($uid, $user['type'], $cPost);
				if(!empty($location_id_arr)){
					if (count($location_id_arr)>0) {
					$this->db->delete('candidate_city',array('user_id'=>$uid));
					for ($i=0;$i<count($location_id_arr);$i++) {

						$this->db->insert('candidate_city',array('user_id'=>$uid,'location_id'=>$location_id_arr[$i]));
					}
					}
					
				}
				
			}

			$return = $this->Users_model->deleteData('users_groups', ['user_id' => $uid]);
			foreach ($la_userType as $li_userTypeId) {
				$this->Login_model->insert('users_groups', ['user_id' => $uid, 'group_id' => $li_userTypeId]);
			}
			$userDataNow = array();
			$userData = $this->users_model->getUserTypeData($uid);
			foreach ($userData as $data) {
				array_push($userDataNow,$data->name);
			}

			$update = $this->users_model->update($uid, $post);

			if ($update) {
				$_SESSION['user_data']['first_name'] = $post['first_name'];
				$_SESSION['user_data']['last_name'] = $post['last_name'];
				$_SESSION['user_data']['phone'] = $post['phone'];
				$_SESSION['user_data']['address'] = $post['address'];
				$_SESSION['user_data']['user_types'] = $userDataNow;
				$response['success'] = true;
				$response['data'] = $post;
				$response['msg'] = 'Success';
			}
		}
		echo json_encode($response);
	}

    public function profile_image_upload() { // Update own profile image
        $user = authentication();
        $uid = $user['id'];
//        $response = array('success' => false, 'msg' => 'Unable to process');
        $file = $_FILES['profile_image'];

        if (isset($file['name']) && ($file['name'] != '')) {

            $fileName = $uid . "-" . time() . "-" . $file['name'];
            $path = 'user/profile/';
            $upload_dir = UPLOADDIR . $path;
            move_uploaded_file($file['tmp_name'], $upload_dir . $fileName);
            $update = $this->users_model->update($uid, ['filename' => $fileName]);

            $_SESSION['user_data']['filename'] = $fileName;
        }

        redirect(base_url('user/profile'));
//        echo json_encode($response);
    }

	public function profile_resume_upload(){
		 $user = authentication();
		$uid = $user['id'];
		
		$file = $_FILES['resume_image'];
		if (isset($file['name']) && ($file['name'] != '')) {
			$fileName = $uid . "-" . time() . "-" . $file['name'];
			$path = 'user/resume/';
            $upload_dir = UPLOADDIR . $path;
			 move_uploaded_file($file['tmp_name'], $upload_dir . $fileName);
            $update = $this->users_model->resumeupdate($uid, ['candidate_resume' => $fileName]);
		 }
		redirect(base_url('user/profile'));
	}

	public function profile_resume_upload_another(){
		$user = authentication();
		$uid = $user['id'];
		$file = $_FILES['resume_image'];
		if (isset($file['name']) && ($file['name'] != '')) {
			echo "file eseche";
			exit;
		}else{
			echo "file aseni";
			exit;
		}
		

	}

    public function changePassword() {  // ajax 
        $user = authentication();
        $uid = $user['id'];
        $response = array('success' => false, 'msg' => 'Unable to process');
        $post = $this->input->post();
//        print_r($post);die;

        $this->form_validation->set_rules('current_password', 'current password', 'required');
        $this->form_validation->set_rules('new_password', 'new password', 'required');
        $this->form_validation->set_rules('confirm_password', 'confirm password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response['msg'] = str_replace(["<p>"], " ", validation_errors());
            $response['msg'] = str_replace(["</p>"], "<br>", $response['msg']);
        } else {
            $user_details = $this->Users_model->getData('users', array('id' => $uid), 'password');
            if (md5($post['current_password']) !== $user_details[0]->password) {
                $response['msg'] = 'Current password does not match.';
            } elseif ($post['new_password'] != $post['confirm_password']) {
                $response['msg'] = 'New password & Confirm password does not match.';
            } else {

                $fields = array('password' => md5($post['new_password']));
                $update = $this->users_model->update($uid, $fields);
                if ($update) {
                    $response['success'] = true;
                    $response['data'] = $post;
                    $response['msg'] = 'New password successfully updated.';
                }
            }
        }
        echo json_encode($response);
    }

    public function downloadFile($file, $ofile) {
        $ref = $_SERVER['HTTP_REFERER'];
        if (empty($file) || empty($ofile)) {
            redirect($ref);
        }

        $file = str_replace('file-', '', $file);
        $ofile = str_replace('file-', '', $ofile);
        $file = UPLOADDIR . 'messages/' . $file;

        if (!file_exists($file)) {
            redirect($ref);
        }

        $result = basename($file);
        ob_start();
        header('Content-Description: File Transfer');
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename=' . $ofile);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_end_clean();
        flush();
        readfile($file);
        exit();
    }

    //=========  Autocomplete location search on Home page & Product listing page && Add product modal ======//
    public function location_autocomplete_search() {
        $response = array('success' => false, 'msg' => 'Unable to process');
        $searchVal = $_POST['searchVal'];

        $ls_cityName = '';
        if ($searchVal != '') {
            $limit['limit'] = 10;
            $limit['offset'] = 0;
            $la_city = $this->Users_model->get_location_autocomplete_search($searchVal, $limit);

            if (count($la_city) > 0) {
                $ls_cityName = "<ul>";
                foreach ($la_city as $lo_row) {
                    $ls_cityName .= "<li class='auto_location_city_name' title='" . $lo_row->COUNTRY . "' id='" . $lo_row->ID . "'>" . str_replace($searchVal, "<b>$searchVal</b>", $lo_row->CITY) . "</li>";
                }
                $ls_cityName .= "</ul>";
            }
        }

        $response['data'] = $ls_cityName;
        $response['success'] = true;
        $response['msg'] = "Success";

        echo json_encode($response);
    }
     public function location_autocomplete_search2() {
        $response = array('success' => false, 'msg' => 'Unable to process');
        $searchVal = $_POST['searchVal'];
		$job_id = $_POST['job_id'];

        $ls_cityName = '';
        if ($searchVal != '') {
            $limit['limit'] = 10;
            $limit['offset'] = 0;
            $la_city = $this->Users_model->get_location_autocomplete_search($searchVal, $limit);

			if (count($la_city) > 0) {
				$ls_cityName = "<ul>";
				foreach ($la_city as $lo_row) {
					
					$str = '"'.$job_id.'"'.','.'"'.$lo_row->ID.'"';
				
					$ls_cityName .= "<li onclick='javascript:select_city(".$str.");'  class='auto_location_city_name2' title='" . $lo_row->COUNTRY . "' id='" . $lo_row->ID . "'>" . str_replace($searchVal, "<b>$searchVal</b>", $lo_row->CITY) . "</li>";
                }
                $ls_cityName .= "</ul>";
            }
        }

        $response['data'] = $ls_cityName;
        $response['success'] = true;
        $response['msg'] = "Success";

        echo json_encode($response);
    }

    public function installer_listing() {
        $loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }

        $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

        $limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);

        $la_usersData_count = $this->Users_model->getUsersByUserType_count("'installer'", $loggedId,$limit);
        $la_usersData = $this->Users_model->getUsersByUserType("'installer'", $loggedId, $limit);

//        print_r($la_usersData_count);
//        die;
        $this->commonData['title'] = 'Installer list';
        $this->commonData['header_flag'] = 'search_designer_installer_list';
        $this->commonData['userType'] = 'installer';
        $this->commonData['uId'] = 0;
        $this->commonData['uName'] = '';
        $this->commonData['location_id'] = '';
        $this->commonData['ls_location'] = '';
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['li_usersDataCount'] = $la_usersData_count->user_count;
        $this->commonData['la_usersData'] = $la_usersData;
        $this->loadScreen('frontend/user/designer_installer_listing');
    }

    public function designer_listing() {
        $loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }
        $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

        /*$limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);
        */
        $limit['limit'] = 2;
        $limit['offset'] = (($currentPage - 1 ) * 2);

        //$la_usersData_count = $this->Users_model->getUsersByUserType_count("'designer'", $loggedId);
        $la_usersData_count = $this->Users_model->getUserReq_count("'designer'", $loggedId);
        
        $la_usersData = $this->Users_model->getUsersByUserType("designer", $loggedId, $limit);
        $la_designerArea = $this->Users_model->getData('designer_area_required', ['status' => 'A']);
//        $la_collaboration = $this->Users_model->getData('collaboration_for_designer_req', ['status' => 'A']);

//        print_r($la_designerArea);die;
        $this->commonData['title'] = 'Designer list';
        $this->commonData['header_flag'] = 'search_designer_installer_list';
        $this->commonData['userType'] = 'designer';
        $this->commonData['loggedId'] = $loggedId;
        $this->commonData['uId'] = 0;
        $this->commonData['uName'] = '';
        $this->commonData['location_id'] = '';
        $this->commonData['id'] = '';
        $this->commonData['ls_location'] = '';
        $this->commonData['ls_designer'] = '';
        $this->commonData['ls_id'] = '';
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['li_usersDataCount'] = $la_usersData_count->user_count;
        $this->commonData['la_usersData'] = $la_usersData;
        $this->commonData['la_designerArea'] = $la_designerArea;
//        $this->commonData['la_collaboration'] = $la_collaboration;
        $this->loadScreen('frontend/user/designer_installer_listing');
    }

	public function job_search() {
		  $loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }
		$currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
		$limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);

		$la_jobs_count = $this->Users_model->getUsersByUserType_count("'employer'", $loggedId);
		$la_jobsData = $this->Users_model->getjobbyuserType( $loggedId, $limit,'','','');


		$this->commonData['title'] = 'Job list';
        $this->commonData['header_flag'] = 'job_search_list';
        $this->commonData['userType'] = 'candidate';
        $this->commonData['loggedId'] = $loggedId;
		$this->commonData['uId'] = 0;
        $this->commonData['uName'] = '';
        $this->commonData['location_id'] = '';
        $this->commonData['ls_type'] =  "";
        $this->commonData['ls_location'] =  "";
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['li_jobsDataCount'] = $la_jobs_count->user_count;
        $this->commonData['la_jobsData'] = $la_jobsData;
		$this->loadScreen('frontend/user/job_search_listing');
	}


	public function job_candidate () {
		$loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }
		$currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

        $limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);

		$la_usersData_count = $this->Users_model->getUsersByUserType_count("'candidate'", $loggedId);
		//echo $this->db->last_query();
		//echo '<br>';
		$la_usersData = $this->Users_model->getusersType("'candidate'", $loggedId, $limit,'','','');
		
		//echo $this->db->last_query();
		//echo '<br>';

		$created_at = date('Y-m-d H:i:s');
		$where_arr = array('job_posting_subscription.status'=>'A','job_posting_subscription.user_id'=>$loggedId,'job_posting_subscription.valid_upto>='=>$created_at);
		$query_subscription = $this->db->select('job_posting_subscription.*,job_posting_subscription.job_category,job_posting_subscription.valid_upto')->from('job_posting_subscription')->join('job_posting_charges','job_posting_subscription.subscription_id=job_posting_charges.job_posting_charges_id')->where($where_arr);
		$user_subscription=$query_subscription->get()->result_array();
		//        print_r($la_userLocationData);
		//        die;
		$this->commonData['user_subscription'] = $user_subscription;
		
		$this->commonData['title'] = 'Job Candidate list';
        $this->commonData['header_flag'] = 'job_Candidate_list';
        $this->commonData['userType'] = 'employeer';
        $this->commonData['loggedId'] = $loggedId;
		$this->commonData['uId'] = 0;
        $this->commonData['uName'] = '';
        $this->commonData['location_id'] = '';
        $this->commonData['ls_type'] =  "";
        $this->commonData['ls_location'] =  "";
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['li_usersDataCount'] = $la_usersData_count->user_count;
        $this->commonData['la_usersData'] = $la_usersData;
		$this->loadScreen('frontend/user/job_candidate_listing');
	}

	public function candidate_details(){
		$loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }
		
		$userId = $this->uri->segment(2);
        $userName = $this->uri->segment(2);
		$userdetails = '';
		$user = $this->Users_model->single_user($userId);
		if($user){
			$userdetails = $user[0];
		}
		$created_at = date('Y-m-d H:i:s');
		$where_arr = array('job_posting_subscription.status'=>'A','job_posting_subscription.user_id'=>$loggedId,'job_posting_subscription.valid_upto>='=>$created_at);
		$query_subscription = $this->db->select('job_posting_subscription.*,job_posting_subscription.job_category,job_posting_subscription.valid_upto')->from('job_posting_subscription')->join('job_posting_charges','job_posting_subscription.subscription_id=job_posting_charges.job_posting_charges_id')->where($where_arr);
		$user_subscription=$query_subscription->get()->result_array();
		//echo $this->db->last_query();
		
		$get_favorite = $this->Users_model->get_favorite_list($userId,$loggedId);
		$this->commonData['title'] = 'Job Candidate Details';
        $this->commonData['header_flag'] = 'job_Candidate_list';
        $this->commonData['userType'] = 'employeer';
		$this->commonData['uId'] = 0;
        $this->commonData['uName'] = '';
        $this->commonData['location_id'] = '';
        $this->commonData['ls_type'] =  "";
        $this->commonData['ls_location'] =  "";
		$this->commonData['favorite_list'] = $get_favorite;
		$this->commonData['la_userData'] = $userdetails;
        $this->commonData['loggedId'] = $loggedId;
		$this->commonData['user_subscription'] = $user_subscription;
		$this->loadScreen('frontend/user/job_candidate_details');
	}

	public function job_details(){
		$loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }

		$jobId = $this->uri->segment(2);
        $jobtitle = $this->uri->segment(2);
		$jobDetails = $this->Users_model->get_job_details($jobId);
		$get_applied = $this->Users_model->applied_jobs($jobId,$loggedId);
		$get_saved = $this->Users_model->saved_jobs($jobId,$loggedId);
		$this->commonData['title'] = 'Job Details';
        $this->commonData['header_flag'] = 'job_search_list';
        $this->commonData['userType'] = 'candidate';
		$this->commonData['uId'] = 0;
        $this->commonData['uName'] = '';
        $this->commonData['location_id'] = '';
        $this->commonData['ls_type'] =  "";
        $this->commonData['ls_location'] =  "";
		$this->commonData['applied_jobs'] = $get_applied;
		$this->commonData['saved_jobs'] = $get_saved;
		$this->commonData['la_jobData'] = $jobDetails[0];
        $this->commonData['loggedId'] = $loggedId;
		$this->loadScreen('frontend/user/job_search_details');
	}

//    public function installer_search() {
//        $loggedId = 0;
//        if (isset($_SESSION['user_data']['id'])) {
//            $user = authentication();
//
//            if (isset($user['id']) && ($user['id'] != '')) {
//                $loggedId = $user['id'];
//            }
//        }
//        $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
//        $uId = (isset($_GET['id']) && ($_GET['id'] > 0)) ? $_GET['id'] : 0;
//        $uName = (isset($_GET['name']) && ($_GET['name'] != '')) ? str_replace(["+"], " ", $_GET['name']) : '';
//        $location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
//
//        $limit['limit'] = USER_GRID;
//        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);
//
//        $la_usersData_count = $this->Users_model->getUsersByUserType_count("'installer'", $loggedId);
//        $la_usersData = $this->Users_model->getUsersByUserType("'installer'", $loggedId, $limit, '', '', $uId, $location_id);
//
//        $this->commonData['title'] = 'Installer search';
//        $this->commonData['header_flag'] = 'search_designer_installer_list';
//        $this->commonData['userType'] = 'installer';
//        $this->commonData['uId'] = $uId;
//        $this->commonData['uName'] = $uName;
//        $this->commonData['location_id'] = $location_id;
//        $this->commonData['ls_location'] = (isset($_GET['location'])) ? $_GET['location'] : "";
//        $this->commonData['currentPage'] = $currentPage;
//        $this->commonData['li_usersDataCount'] = $la_usersData_count->user_count;
//        $this->commonData['la_usersData'] = $la_usersData;
//        $this->loadScreen('frontend/user/designer_installer_listing');
//    }

public function candidate_search()
{
	$loggedId = 0;
	if (isset($_SESSION['user_data']['id'])) {
		$user = authentication();

		if (isset($user['id']) && ($user['id'] != '')) {
			$loggedId = $user['id'];
		}
	}
	$currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
	$uName = (isset($_GET['category']) && ($_GET['category'] != '')) ? str_replace(["+"], " ", $_GET['category']) : '';
	$location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
	$locationName = (isset($_GET['location'])) ? $_GET['location'] : "";
	$limit['limit'] = USER_GRID;
	$limit['offset'] = (($currentPage - 1 ) * USER_GRID);
	
	$created_at = date('Y-m-d H:i:s');
	$where_arr = array('job_posting_subscription.status'=>'A','job_posting_subscription.user_id'=>$loggedId,'job_posting_subscription.valid_upto>='=>$created_at);
	$query_subscription = $this->db->select('job_posting_subscription.*,job_posting_subscription.job_category,job_posting_subscription.valid_upto')->from('job_posting_subscription')->join('job_posting_charges','job_posting_subscription.subscription_id=job_posting_charges.job_posting_charges_id')->where($where_arr);
	$user_subscription=$query_subscription->get()->result_array();



	$la_usersData_count = $this->Users_model->getUsersByUserType_count("'candidate'", $loggedId);

	$la_usersData = $this->Users_model->getusersType("'candidate'", $loggedId, $limit,$uName,$location_id,$locationName);
	$this->commonData['title'] = 'Job Candidate list';
	$this->commonData['header_flag'] = 'job_Candidate_list';
	$this->commonData['userType'] = 'employeer';
	$this->commonData['loggedId'] = $loggedId;
	$this->commonData['uId'] = 0;
	$this->commonData['uName'] = '';
	$this->commonData['location_id'] = $location_id;
	$this->commonData['ls_type'] = (isset($_GET['category'])) ? $_GET['category'] : "";
	$this->commonData['ls_location'] = (isset($_GET['location'])) ? $_GET['location'] : "";
	$this->commonData['currentPage'] = $currentPage;
	$this->commonData['li_usersDataCount'] = $la_usersData_count->user_count;
	$this->commonData['la_usersData'] = $la_usersData;
	$this->commonData['user_subscription'] = $user_subscription;
	$this->loadScreen('frontend/user/job_candidate_listing');
}

	public function employer_job_search(){
		$loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }
		$currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
        $uName = (isset($_GET['designation']) && ($_GET['designation'] != '')) ? str_replace(["+"], " ", $_GET['designation']) : '';
        $location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
		$locationName = (isset($_GET['location'])) ? $_GET['location'] : "";
		$limit['limit'] = USER_GRID;
		$limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);
		$la_jobs_count = $this->Users_model->getjobbyuser_count_2($loggedId,$uName,$locationName,$location_id);
		$la_jobsData = $this->Users_model->getjobbyuserType( $loggedId, $limit,$uName,$locationName,$location_id);
		//echo $this->db->last_query();
		$this->commonData['title'] = 'Job list';
        $this->commonData['header_flag'] = 'job_search_list';
        $this->commonData['userType'] = 'candidate';
        $this->commonData['loggedId'] = $loggedId;
		$this->commonData['uId'] = 0;
        $this->commonData['uName'] =$uName;
        $this->commonData['location_id'] = $location_id;;
        
       
        $this->commonData['ls_type'] =  (isset($_GET['designation'])) ? $_GET['designation'] : "";;
        $this->commonData['ls_location'] =  (isset($_GET['location'])) ? $_GET['location'] : "";;
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['li_jobsDataCount'] = $la_jobs_count->Total;
        $this->commonData['la_jobsData'] = $la_jobsData;
		$this->loadScreen('frontend/user/job_search_listing');

	}

    public function designer_search() {
        $loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }
        $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
        $uId = (isset($_GET['id']) && ($_GET['id'] > 0)) ? $_GET['id'] : 0;
        $uName = (isset($_GET['name']) && ($_GET['name'] != '')) ? str_replace(["+"], " ", $_GET['name']) : '';
        $location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
        $id = (isset($_GET['id'])) ? $_GET['id'] : "";
        $limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);

        $la_usersData_count = $this->Users_model->getUsersByUserType_count("'designer'", $loggedId);
        $la_usersData = $this->Users_model->getUsersByUserType("'designer'", $loggedId, $limit, '', '', $uId, $location_id);

        $la_designerArea = $this->Users_model->getData('designer_area_required', ['status' => 'A']);
//        $la_collaboration = $this->Users_model->getData('collaboration_for_designer_req', ['status' => 'A']);

        $this->commonData['title'] = 'Designer search';
        $this->commonData['header_flag'] = 'search_designer_installer_list';
        $this->commonData['userType'] = 'designer';
        $this->commonData['loggedId'] = $loggedId;
        $this->commonData['uId'] = $uId;
        $this->commonData['id'] = $id;
        $this->commonData['uName'] = $uName;
        $this->commonData['location_id'] = $location_id;
        $this->commonData['ls_designer'] = (isset($_GET['designer'])) ? $_GET['designer'] : "";
        $this->commonData['ls_location'] = (isset($_GET['location'])) ? $_GET['location'] : "";
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['li_usersDataCount'] = $la_usersData_count->user_count;
        $this->commonData['la_usersData'] = $la_usersData;
        $this->commonData['la_designerArea'] = $la_designerArea;
//        $this->commonData['la_collaboration'] = $la_collaboration;
        $this->loadScreen('frontend/user/designer_installer_listing');
    }

	public function installer_search() {
		$loggedId = 0;
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '')) {
                $loggedId = $user['id'];
            }
        }
        $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
        $uId = (isset($_GET['id']) && ($_GET['id'] > 0)) ? $_GET['id'] : 0;
        $uName = (isset($_GET['installer']) && ($_GET['installer'] != '')) ? str_replace(["+"], " ", $_GET['installer']) : '';
        $location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
		$ls_location =  (isset($_GET['location'])) ? $_GET['location'] : "";
        $id = (isset($_GET['id'])) ? $_GET['id'] : "";
		$limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);

		$la_usersData_count = $this->Users_model->getUsersByUserType_count("installer", $loggedId);
		$la_usersData = $this->Users_model->getUsersByUserType_s("installer", $loggedId, $limit,$uName, '', $uId, $location_id);
print_r($la_usersData);
exit;
		$this->commonData['header_flag'] = 'installer_request';
        $this->commonData['loggedId'] = $loggedId;
        $this->commonData['la_usersData_count'] = $la_usersData_count;
        $this->commonData['la_usersData'] = $la_usersData;
        
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['uId'] = $uId;
        $this->commonData['uName'] = $uName;
        $this->commonData['location_id'] = $location_id;
        $this->commonData['ls_location'] = $ls_location;
        $this->commonData['id'] = $id;
        
        $this->loadScreen('frontend/user/installer_request');
	}



    public function designer_installer_autocomplete_search() {
        $response = array('success' => false, 'msg' => 'Unable to process');
        $searchVal = $_POST['searchVal'];
        $type = $_POST['type'];

        $ls_cityName = '';
        if ($searchVal != '') {
            $limit['limit'] = 10;
            $limit['offset'] = 0;
            $la_usersData = $this->Users_model->getUsersByUserType_auto("'$type'", 0, $limit, $searchVal, "u.id, u.first_name, u.last_name");

            $ls_userName = "<ul>";
            if (count($la_usersData) > 0) {
                foreach ($la_usersData as $lo_row) {
                    $ls_userName .= "<li class='auto_user_name' title='" . $lo_row->first_name . " " . $lo_row->last_name . "' id='" . $lo_row->id . "'>" . str_replace($searchVal, "<b>$searchVal</b>", $lo_row->first_name . " " . $lo_row->last_name) . "</li>";
                }
            }
            $ls_userName .= "</ul>";
        }

        $response['data'] = $ls_userName;
        $response['success'] = true;
        $response['msg'] = "Success";

        echo json_encode($response);
    }

    public function profile_details() {
        $userType = $this->uri->segment(2);
        $userId = $this->uri->segment(3);

        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();

            if (isset($user['id']) && ($user['id'] != '') && ($user['id'] == $userId)) {
                redirect("user/profile");
            }
        }


        $my_favorites = [];
        if (isset($user['id']) && ($user['id'] != '')) {
            $loggedUserId = $user['id'];
            $my_favorites = $this->Users_model->getData('favorites_user', ['added_by_user_id' => $loggedUserId, 'user_id' => $userId]);


            if (!empty($my_favorites)) {
                $my_favorites = $my_favorites[0];
            }
        }

        $lo_userDetail = $this->users_model->getUserListById($userId);
        $user_location = [];
        $user_business = [];
        if (isset($lo_userDetail[0]->id) && ($lo_userDetail[0]->id != '')) {
            $lo_userDetail = $lo_userDetail[0];
            $user_business = $this->Users_model->single_business_profile_details($lo_userDetail->id, $userType);
		
//            $user_location = $this->Users_model->single_user_location($lo_userDetail->id);
        } else {
            redirect();
        }
//        print_r($user_location);
//        die;
        $this->commonData['userId'] = $userId;
        $this->commonData['userType'] = $userType;
        $this->commonData['lo_userDetail'] = $lo_userDetail;
        $this->commonData['user_business'] = $user_business;
//        $this->commonData['user_location'] = $user_location;
        $this->commonData['my_favorites'] = $my_favorites;
        $this->loadScreen('frontend/user/profile_details');
    }

    public function add_favorite_user() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != ''))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');

            $userId = $this->uri->segment(3);
			$fav_group=$this->uri->segment(4);
            $la_post['added_by_user_id'] = $uid;
            $la_post['user_id'] = $userId;
            $la_post['added_datetime'] = date('Y-m-d H:i:s');
            $la_post['fav_group'] = $fav_group;

            $favorites = $this->Users_model->getData('favorites_user', ['added_by_user_id' => $uid, 'user_id' => $userId,'fav_group' => $fav_group]);
			$qrr= $this->db->last_query();
            if (empty($favorites)) {
                $insertId = $this->Users_model->insertData('favorites_user', $la_post);
                if ($insertId) {
                    $response['success'] = true;
                    $response['text'] = "<i class='fa fa-heart'></i> Favorite";
                    $response['flag'] = "add";
                    $response['msg'] = 'Added to your favorites';
					$response['qrr'] = $qrr;
                }
            } else {
                $return = $this->Users_model->deleteData('favorites_user', ['added_by_user_id' => $uid, 'user_id' => $userId,'fav_group' => $fav_group]);
                if ($return) {
                    $response['success'] = true;
                    $response['text'] = "<i class='fa fa-heart-o'></i> Favorite";
                    $response['flag'] = "remove";
                    $response['msg'] = 'Remove from your favorites';
					$response['qrr'] = $qrr;
                }
            }
        } else {
			$response = array('success' => false, 'msg' => 'Please login at first','qrr'=>$qrr);
        }

        echo json_encode($response);
    }

    public function test() {
        $this->loadScreen('frontend/test');
    }

    public function addDesignerRequest() {
        $user = authentication(false);

        $this->form_validation->set_rules('request_type', 'request type', 'required');
        $this->form_validation->set_rules('space_planning_needed', 'space planning needed', 'required');
        $this->form_validation->set_rules('space_size', 'space size', 'required');
        $this->form_validation->set_rules('project_scope', 'project scope', 'required');
        $this->form_validation->set_rules('acheive_space', 'acheive space', 'required');
        $this->form_validation->set_rules('style_preference', 'style preference', 'required');
        $this->form_validation->set_rules('technology_requirement', 'technology requirement', 'required');
        $this->form_validation->set_rules('construction_involved', 'construction involved', 'required');
        $this->form_validation->set_rules('time_frame', 'time frame', 'required');
//        $this->form_validation->set_rules('area_required', 'area required', 'required');
        $this->form_validation->set_rules('message', 'message', 'required');

        if (isset($_POST['area_required']) && count($_POST['area_required']) > 0) {
            
        } else {
            $response = array('success' => false, 'data' => $_POST, 'msg' => 'Please add Check off areas!');
            echo json_encode($response);
            exit();
        }
		$userr = $_POST['userr'];
		if (count($userr)==0) {
			$response = array('success' => false, 'data' => $_POST, 'msg' => 'Please add designer');
			echo json_encode($response);
			exit();
		}
//        if (isset($_POST['collaboration']) && count($_POST['collaboration']) > 0) {
//            
//        } else {
//            $response = array('success' => false, 'data' => $_POST, 'msg' => 'Please add collaboration!');
//            echo json_encode($response);
//            exit();
//        }

        if ($this->form_validation->run() == FALSE) {
            $response['msg'] = str_replace(["<p>"], " ", validation_errors());
            $response['msg'] = str_replace(["</p>"], "<br>", $response['msg']);
        } else {
            if (isset($user['id']) && ($user['id'] != '')) {

                $uid = $user['id'];
                $response = array('success' => false, 'msg' => 'Unable to process');

                $post_data['request_type'] = $this->input->post('request_type');
                $post_data['user_id'] = $uid;
                $post_data['space_planning_needed'] = $this->input->post('space_planning_needed');
                $post_data['space_size'] = $this->input->post('space_size');
                $post_data['project_scope'] = $this->input->post('project_scope');
                $post_data['acheive_space'] = $this->input->post('acheive_space');
                $post_data['style_preference'] = $this->input->post('style_preference');
                $post_data['technology_requirement'] = $this->input->post('technology_requirement');
                $post_data['construction_involved'] = $this->input->post('construction_involved');
                $post_data['time_frame'] = $this->input->post('time_frame');
                $post_data['message'] = $this->input->post('message');
                $post_data['created_on'] = date("Y-m-d H:i:s");
                //print_r($post_data);die;
                $insertId = $this->Users_model->insertData('designer_request', $post_data);
                //$this->session->set_flashdata('msg_success', 'Request created sucessfully..');

                if ($insertId > 0) {
                    if (isset($_POST['area_required']) && count($_POST['area_required']) > 0) {
                        foreach ($_POST['area_required'] as $data_id) {
                            $this->Users_model->insertData('designer_request_area_map', ['designer_area_id' => $data_id, 'request_id' => $insertId]);
                        }
                    }
					
					if (count($userr)>0) {
						foreach ($userr as $u_val) {
							
							
							$post_data = array(
							"request_id" => $insertId,
							"designer_id" => $u_val,
							"created_on" => date("Y-m-d H:i:s")
							);
							
							$this->Users_model->insertData('designer_request_user', $post_data);
						}
					}
					
//                    if (isset($_POST['collaboration']) && count($_POST['collaboration']) > 0) {
//                        foreach ($_POST['collaboration'] as $data_id) {
//                            $this->Users_model->insertData('designer_collaboration_map', ['collaboration_id' => $data_id, 'request_id' => $insertId]);
//                        }
//                    }

                    $response['success'] = true;
                    $response['msg'] = 'Request Submitted Successfully';
                    $response['id'] = $insertId;
                }
            } else {
                //$this->session->set_flashdata('msg_error', 'Please login first.');
                $response = array('success' => false, 'msg' => 'Please login first');
            }
        }
        echo json_encode($response);
        exit();
    }

    public function updateDesignerId() {
        //print_r($_POST);die;
        $user = authentication(false);
        if (isset($user['id']) && ($user['id'] != '')) {
            if ($this->input->post('request_id') != 0) {
                $request_id = $this->input->post('request_id');
                if ($this->input->post('user') > 0) {
                    $users = $this->input->post('user');
                    //print_r($users);die;
                    foreach ($users as $key => $value) {
                        $post_data = array(
                            "request_id" => $request_id,
                            "designer_id" => $value,
                            "created_on" => date("Y-m-d H:i:s")
                        );
                        $insertId = $this->Users_model->insertData('designer_request_user', $post_data);
                    }
                    // $designer_ids = implode(",", $this->input->post('user'));
                    // $uid = $this->input->post('uid');
                    // //print_r($post_data);die;
                    // $return = $this->Users_model->updateData('designer_request', ['id' => $uid], ['designer_ids' => $designer_ids]);
                    $this->session->set_flashdata('msg_success', 'Request submitted sucessfully..');
                    redirect(base_url('designer'), 'refresh');
                } else {
                    $this->session->set_flashdata('msg_error', 'Please select atleast one.');
                    redirect(base_url('designer'), 'refresh');
                }
            } else {
                $this->session->set_flashdata('msg_error', 'At first please fillup the page');
                redirect(base_url('designer'), 'refresh');
            }
        } else {
            $this->session->set_flashdata('msg_error', 'Please login first.');
            redirect(base_url('designer'), 'refresh');
        }
    }

    //=========  Autocomplete serch business search in dashboard ======//
    public function business_services_autocomplete_search() {
        $response = array('success' => false, 'msg' => 'Unable to process');
        $searchVal = $_POST['searchVal'];

        $ls_service = '';
        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();
            $loggedId = $user['id'];
            $uType = $user['type'];
            $la_service = $this->Users_model->get_business_service_autocomplete_search($searchVal, $uType);
            if (count($la_service) > 0) {
                $ls_service = "<ul>";
                foreach ($la_service as $lo_row) {
                    $ls_service .= "<li class='auto_location_service_name' title='" . $lo_row->description . "' id='" . $lo_row->services_id . "'>" . str_replace($searchVal, "<b>$searchVal</b>", $lo_row->services) . "</li>";
                }
                $ls_service .= "</ul>";
            }

            $response['data'] = $ls_service;
            $response['success'] = true;
            $response['msg'] = "Success";
        } else {
            $response = array('success' => false, 'msg' => 'Please login!');
        }

        echo json_encode($response);
    }


	public function business_services_all_select(){
		$response = array('success' => false, 'msg' => 'Unable to process');
        $searchVal = $_POST['searchVal'];
		$ls_service = '';
		if (isset($_SESSION['user_data']['id'])) {
			$user = authentication();
            $loggedId = $user['id'];
            $uType = $user['type'];
			$la_service = $this->Users_model->get_business_service_autocomplete_search($searchVal, $uType);
			if (count($la_service) > 0) {
				foreach ($la_service as $lo_row) {
					if($lo_row->services != 'Other: Explain'){
						if($lo_row->services != 'All the above'){
							$ls_service.= "<span class='selected_service_span'><input type='hidden' class='selected_services_input' name='services_id[]' value='". $lo_row->services_id ."' readonly=''>".$lo_row->services."<i class='fa fa-times remove_selected_service'></i></span>";
						}
					}
				}
			}
			$response['data'] = $ls_service;
            $response['success'] = true;
            $response['msg'] = "Success";

		}else{
			$response = array('success' => false, 'msg' => 'Please login!');
		}
		echo json_encode($response);
	}

    public function designer_autocomplete_search() {
        $response = array('success' => false, 'msg' => 'Unable to process');
        $searchVal = $_POST['searchVal'];

        $ls_designerName = '';
        if ($searchVal != '') {
            $limit['limit'] = 10;
            $limit['offset'] = 0;
            $la_city = $this->Users_model->get_designer_autocomplete_search($searchVal, $limit);

            if (count($la_city) > 0) {
                $ls_designerName = "<ul>";
                foreach ($la_city as $lo_row) {
                    $ls_designerName .= "<li class='auto_designer_name' title='" . $lo_row->first_name . "' id='" . $lo_row->id . "'>" . str_replace($searchVal, "<b>$searchVal</b>", $lo_row->first_name . ' ' . $lo_row->last_name) . "</li>";
                }
                $ls_designerName .= "</ul>";
            }
        }

        $response['data'] = $ls_designerName;
        $response['success'] = true;
        $response['msg'] = "Success";

        echo json_encode($response);
    }

	

    public function installer_autocomplete_search() {
        $response = array('success' => false, 'msg' => 'Unable to process');
        $searchVal = $_POST['searchVal'];

        $ls_designerName = '';
        if ($searchVal != '') {
            $limit['limit'] = 10;
            $limit['offset'] = 0;
            $la_city = $this->Users_model->get_installer_autocomplete_search($searchVal, $limit);

            if (count($la_city) > 0) {
                $ls_designerName = "<ul>";
                foreach ($la_city as $lo_row) {
                    $ls_designerName .= "<li class='auto_installer_name' title='" . $lo_row->first_name . "' id='" . $lo_row->id . "'>" . str_replace($searchVal, "<b>$searchVal</b>", $lo_row->first_name . ' ' . $lo_row->last_name) . "</li>";
                }
                $ls_designerName .= "</ul>";
            }
        }

        $response['data'] = $ls_designerName;
        $response['success'] = true;
        $response['msg'] = "Success";

        echo json_encode($response);
    }

    public function ajax_designer_purchase_requests_details() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != ''))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');
            $puchase_details = $_POST['puchase_details'];
            $puchase_detailsArr = explode("__", $puchase_details);
            $puchaseId = $puchase_detailsArr[1];
//            if ($_POST['flag'] == 'send') {
            $la_purchaseRequests = $this->Users_model->designer_purchase_requests_details($uid, $puchaseId, $_POST['flag']);
//            } else {
//
//                $la_purchaseRequests = $this->Users_model->designer_purchase_requests_details_received($uid, $puchaseId, $_POST['flag']);
//            }
//            print_r($la_purchaseRequests);die;
            if (!empty($la_purchaseRequests['la_requestData'])) {
                $response['success'] = true;
                $response['data'] = $la_purchaseRequests;
                $response['msg'] = "Success";
            } else {
                $response = array('success' => false, 'msg' => 'Purchase request not found.');
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        $response['flag'] = $_POST['flag'];
        echo json_encode($response);
    }

    public function ajax_pagination_designer_service_request() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $limit['limit'] = ITEM_LIST;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_LIST);

//            $order_by['order_by'] = 'installer_request_id';
//            $order_by['sort'] = 'DESC';
//            $la_installer_request_data = $this->Users_model->getData('installer_request', array('user_id' => $uid), '', [], [], $order_by, $limit);
//            $la_installerRequest_count = $this->Users_model->getCountDesignerServiceRequest($uid)->count;

            $order_by['order_by'] = 'id';
            $order_by['sort'] = 'DESC';
            $la_designer_request_data = $this->Users_model->getData('designer_request', array('user_id' => $uid), '', [], [], $order_by, $limit);
            $la_myDesignerServiceRequest_count = $this->Users_model->getCountDesignerServiceRequest($uid)->count;


            ob_start();
            include(APPPATH . 'views/frontend/user/include_designer_request_by_me.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        echo json_encode($response);
    }

    public function ajax_pagination_designer_request_me() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $limit['limit'] = ITEM_LIST;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_LIST);

            $la_designer_request_received = $this->Users_model->designer_request_received($uid, $limit);
            $la_designerRequestReceived_count = $this->Users_model->getCountDesignerServiceRequest_received($uid)->count;

            ob_start();
            include(APPPATH . 'views/frontend/user/include_designer_request_for_me.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        echo json_encode($response);
    }

    public function installer_request() {
        $loggedId = 0;
//        $currentPage = 1;

        if (isset($_SESSION['user_data']['id'])) {
            $user = authentication();
            $loggedId = $user['id'];
        }

        $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;
        $uId = (isset($_GET['id']) && ($_GET['id'] > 0)) ? $_GET['id'] : 0;
        $uName = (isset($_GET['name']) && ($_GET['name'] != '')) ? str_replace(["+"], " ", $_GET['name']) : '';
        $location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";
        
        $ls_location =  (isset($_GET['location'])) ? $_GET['location'] : "";
        $id = (isset($_GET['id'])) ? $_GET['id'] : "";
        $limit['limit'] = 12;
        $limit['offset'] = (($currentPage - 1 ) * 12);
        
        /*$limit['limit'] = 12;
        $limit['offset'] = (($currentPage - 1 ) * 12);
        */

        //$la_usersData_count = $this->Users_model->getUsersByUserType_count("'installer'", $loggedId);
        $la_usersData_count = $this->Users_model->getUserReq_count("'installer'", $loggedId);
        //print_r($la_usersData_count);
       
//        $la_usersData = $this->Users_model->getUsersByUserType("'installer'", $loggedId, $limit);
        $la_usersData = $this->Users_model->getUsersByUserType("installer", $loggedId, $limit, '', '', $uId, $location_id);



//        print_r($la_usersData);
//        die;
        $this->commonData['header_flag'] = 'installer_request';
        $this->commonData['loggedId'] = $loggedId;
        $this->commonData['la_usersData_count'] = $la_usersData_count;
        $this->commonData['la_usersData'] = $la_usersData;
        
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['uId'] = $uId;
        $this->commonData['uName'] = $uName;
        $this->commonData['location_id'] = $location_id;
        $this->commonData['ls_location'] = $ls_location;
        $this->commonData['id'] = $id;
        
        $this->loadScreen('frontend/user/installer_request');
    }

    public function addInstallerRequest() {
        $user = authentication(false);
		
	
        $this->form_validation->set_rules('loading_dock_available', 'loading_dock_available', 'required');
        $this->form_validation->set_rules('delivery_site', 'delivery_site', 'required');
        $this->form_validation->set_rules('restricted_hours', 'restricted_hours', 'required');
        $this->form_validation->set_rules('receiving_hours', 'receiving_hours', 'required');
        $this->form_validation->set_rules('customer_to_remove', 'customer_to_remove', 'required');
        $this->form_validation->set_rules('installer_to_remove', 'installer_to_remove', 'required');
        $this->form_validation->set_rules('dumpster_provided_by_customer', 'dumpster_provided_by_customer', 'required');
        $this->form_validation->set_rules('single_phase_installation', 'single_phase_installation', 'required');
        $this->form_validation->set_rules('multiple_phase_installation', 'multiple_phase_installation', 'required');
//        $this->form_validation->set_rules('multiple_phase_installation_desc', 'multiple_phase_installation_desc', 'required');
        $this->form_validation->set_rules('anchor_product', 'anchor_product', 'required');
//        $this->form_validation->set_rules('anchor_product_desc', 'anchor_product_desc', 'required');
        $this->form_validation->set_rules('insurance_cert', 'insurance_cert', 'required');
//        $this->form_validation->set_rules('insurance_cert_desc', 'insurance_cert_desc', 'required');
        $this->form_validation->set_rules('delivery_made_floor', 'delivery_made_floor', 'required');
        $this->form_validation->set_rules('delivery_made_floor_type', 'delivery_made_floor_type', 'required');
        $this->form_validation->set_rules('access_to_freight', 'access_to_freight', 'required');
        $this->form_validation->set_rules('access_to_passenger', 'access_to_passenger', 'required');
        $this->form_validation->set_rules('non_union_labor', 'non_union_labor', 'required');
        $this->form_validation->set_rules('union_labor', 'union_labor', 'required');
        $this->form_validation->set_rules('security_clearance', 'security_clearance', 'required');
//        $this->form_validation->set_rules('additional_info_desc', 'additional_info_desc', 'required');
        $this->form_validation->set_rules('wall_receptacle', 'wall_receptacle', 'required');
        $this->form_validation->set_rules('floor_receptacle', 'floor_receptacle', 'required');
        $this->form_validation->set_rules('ceiling', 'ceiling', 'required');
//        $this->form_validation->set_rules('additional_info_desc_celling', 'additional_info_desc_celling', 'required');
        $this->form_validation->set_rules('comments_message', 'comments_message', 'required');
		//print_r($_POST);
		$userr = $this->input->post('userr');
		if (count($userr)==0) {
			$response = array('success' => false, 'data' => $_POST, 'msg' => 'Please add designer');
			echo json_encode($response);
			exit();
		}
        if ($this->form_validation->run() == FALSE) {
            $response['msg'] = "Please fill all fields!";
            $response['msg1'] = str_replace(["<p>"], " ", validation_errors());
            $response['msg1'] = str_replace(["</p>"], "<br>", $response['msg1']);
        } else {

            if (isset($user['id']) && ($user['id'] != '')) {
			if (isset($_POST['service_required']) && count($_POST['service_required']) > 0) {
                $_POST['service_required'] = implode(",",$_POST['service_required']);
            } else {
                $response = array('success' => false,  'msg' => 'Please add required service!');
                echo json_encode($response);
                exit();
            }

                $uid = $user['id'];
                $la_post = $_POST;
				unset($la_post['userr']);
                $la_post['user_id'] = $uid;
                $la_post['ip'] = get_client_ip();
                $la_post['status'] = 'A';
                $la_post['create_datetime'] = date('Y-m-d H:i:s');
                $response = array('success' => false, 'msg' => 'Unable to process');

                $insertId = $this->Users_model->insertData('installer_request', $la_post);
                //$this->session->set_flashdata('msg_success', 'Request created sucessfully..');

                if ($insertId > 0) {

                    
					if (count($userr)>0) {
						foreach ($userr as $u_val) {
							$post_data = array(
							"request_id" => $insertId,
							"installer_id" => $u_val,
							"created_on" => date("Y-m-d H:i:s")
							);
							$this->Users_model->insertData('installer_request_map', $post_data);
						}
					}
					//$this->session->set_flashdata('msg_success', 'Request submitted sucessfully..');
					//redirect(base_url('installer-request'), 'refresh');
					$response['success'] = true;
					$response['msg'] = 'Request submitted sucessfully..';
					$response['id'] = $insertId;
					
					
                }
            } else {
                //$this->session->set_flashdata('msg_error', 'Please login first.');
                $response = array('success' => false, 'msg' => 'Please login first');
            }
        }
        echo json_encode($response);
        exit();
    }

    public function updateInstallerId() {
//        print_r($_POST);die;
        $user = authentication(false);
        if (isset($user['id']) && ($user['id'] != '')) {
            if ($this->input->post('request_id') != 0) {
                $request_id = $this->input->post('request_id');
                if ($this->input->post('user') > 0) {
                    $users = $this->input->post('user');
                    //print_r($users);die;
                    foreach ($users as $key => $value) {
                        $post_data = array(
                            "request_id" => $request_id,
                            "installer_id" => $value,
                            "created_on" => date("Y-m-d H:i:s")
                        );
                        $insertId = $this->Users_model->insertData('installer_request_map', $post_data);
                    }

                    $this->session->set_flashdata('msg_success', 'Request submitted sucessfully..');
                    redirect(base_url('installer-request'), 'refresh');
                } else {
                    $this->session->set_flashdata('msg_error', 'Please select atleast one.');
                    redirect(base_url('installer-request'), 'refresh');
                }
            } else {
                $this->session->set_flashdata('msg_error', 'At first please fillup the page');
                redirect(base_url('installer-request'), 'refresh');
            }
        } else {
            $this->session->set_flashdata('msg_error', 'Please login first.');
            redirect(base_url('installer-request'), 'refresh');
        }
    }

    public function ajax_installer_purchase_requests_details() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != ''))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');
            $puchase_details = $_POST['puchase_details'];
            $puchase_detailsArr = explode("__", $puchase_details);
            $puchaseId = $puchase_detailsArr[1];

            $la_purchaseRequests = $this->Users_model->installer_purchase_requests_details($uid, $puchaseId, $_POST['flag']);

//            print_r($la_purchaseRequests);die;
            if (!empty($la_purchaseRequests['la_requestData'])) {
                $response['success'] = true;
                $response['data'] = $la_purchaseRequests;
                $response['msg'] = "Success";
            } else {
                $response = array('success' => false, 'msg' => 'Purchase request not found.');
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        $response['flag'] = $_POST['flag'];
        echo json_encode($response);
    }

    public function ajax_pagination_installer_request() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $limit['limit'] = ITEM_LIST;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_LIST);

            $order_by['order_by'] = 'installer_request_id';
            $order_by['sort'] = 'DESC';
            $la_installer_request_data = $this->Users_model->getData('installer_request', array('user_id' => $uid), '', [], [], $order_by, $limit);
            $li_installerRequestData_count = $this->Users_model->getCountInstallerRequest($uid)->count;

            ob_start();
            include(APPPATH . 'views/frontend/user/include_installer_request_by_me.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        echo json_encode($response);
    }

    public function ajax_pagination_installer_request_me() {
        $user = authentication();
        $response = array('success' => false, 'msg' => 'Unable to process');

        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $currentPage = (isset($_GET['pg']) && ($_GET['pg'] > 0)) ? $_GET['pg'] : 1;

            $limit['limit'] = ITEM_LIST;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_LIST);


            $la_installer_request_received = $this->Users_model->installer_request_received($uid, $limit);
            $la_installerRequestReceived_count = $this->Users_model->getCountInstallerRequest_received($uid)->count;

            ob_start();
            include(APPPATH . 'views/frontend/user/include_installer_request_for_me.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        echo json_encode($response);
    }

	public function upload_job_form() {

	    $user = authentication(false);
        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');


			$this->form_validation->set_rules('title', 'Job Title', 'required');
            $this->form_validation->set_rules('long_description', 'Job Description', 'required');
            $this->form_validation->set_rules('minsal', 'Minimum Salary', 'required');
            $this->form_validation->set_rules('maxsal', 'Maximum Salary', 'required');
//           $this->form_validation->set_rules('warranty', 'warranty', 'required');
            $this->form_validation->set_rules('educationlevel', 'Education Level', 'required');
            $this->form_validation->set_rules('years_of_experience', 'Years Of Experience', 'required');
			//$this->form_validation->set_rules('location', 'Location', 'required');
            $this->form_validation->set_rules('designation', 'Designation', 'required');
			$this->form_validation->set_rules('avl_time_frame', 'Availability Time-Frame', 'required');
			//$this->form_validation->set_rules('travelreq', 'Travel Required', 'required');
			$this->form_validation->set_rules('postanonymous', 'Post Anonymous', 'required');

			$post = $this->input->post();
			$la_post['job_title'] = (!isset($post['title'])) ? "" : $post['title'];
			$la_post['job_description'] = (!isset($post['long_description'])) ? "" : $post['long_description'];
			$la_post['min_salary'] = (!isset($post['minsal'])) ? "" : $post['minsal'];
			$la_post['max_salary'] = (!isset($post['maxsal'])) ? "" : $post['maxsal'];
			$la_post['educational_level'] = (!isset($post['educationlevel'])) ? "" : $post['educationlevel'];
			$la_post['experience'] = (!isset($post['years_of_experience'])) ? "" : $post['years_of_experience'];
			//$la_post['preferred_location'] = (!isset($post['location'])) ? "" : $post['location'];
			$la_post['preferred_location'] ='California';
			$la_post['designation'] = (!isset($post['designation'])) ? "" : $post['designation'];
			$la_post['avl_time_frame'] = (!isset($post['avl_time_frame'])) ? "" : $post['avl_time_frame'];
			$la_post['travel_required'] = (!isset($post['travelreq'])) ? "" : $post['travelreq'];
			$la_post['post_anonymous'] = (!isset($post['postanonymous'])) ? "" : $post['postanonymous'];
			$la_post['job_upload_date'] = time();
			$timestamp = time();
			$la_post['job_expiry_date'] = strtotime('+7 days', $timestamp);
            $la_post['job_status'] = 1;
			if ($this->form_validation->run() == FALSE) {
               $response['msg'] = str_replace(["<p>"], " ", validation_errors());
               $response['msg'] = str_replace(["</p>"], "<br>", $response['msg']);
            }else{

				 $la_post['userid'] = $uid;
				 $insertid = $this->Users_model->insertData('jobs', $la_post);
				 if($insertid){
				    $location_ids = $post['location_id'];
				    if(!empty($location_ids)){
						foreach ($location_ids as $location_id) {
							$this->db->insert('job_city',array('job_id'=>$insertid,'location_id'=>$location_id,'user_id'=>$uid));
				        }
				    }
				    $max_job_posted_limit =0;
				    $user_d = $this->db->select('*')->from('users')->where(array('id'=>$uid))->get()->result_array();
				    if(count($user_d)>0){
						$max_job_posted_limit = ($user_d[0]['max_job_posted_limit'])-1;
						$this->db->update('users',array('max_job_posted_limit'=>$max_job_posted_limit));

					}
					$la_post['Job_id'] = $insertid;
					$response['success'] = true;
					$response['data'] = $la_post;
					$response['msg'] = 'Job has been successfully uploaded';
				 }
			}

		}else{
			$response = array('success' => false, 'msg' => 'Please login at first');
		}
		echo json_encode($response);

 }
 public function update_job_details()
 {

	 $user = authentication(false);
	 if (isset($user['id']) && ($user['id'] != '')) {
		 $uid = $user['id'];
		 $response = array('success' => false, 'msg' => 'Unable to process');


		 $this->form_validation->set_rules('title', 'Job Title', 'required');
		 $this->form_validation->set_rules('long_description', 'Job Description', 'required');
		 $this->form_validation->set_rules('minsal', 'Minimum Salary', 'required');
		 $this->form_validation->set_rules('maxsal', 'Maximum Salary', 'required');
		 $this->form_validation->set_rules('educationlevel', 'Education Level', 'required');
		 $this->form_validation->set_rules('years_of_experience', 'Years Of Experience', 'required');
		 //$this->form_validation->set_rules('location', 'Location', 'required');
		 $this->form_validation->set_rules('designation', 'Designation', 'required');
		 $this->form_validation->set_rules('avl_time_frame', 'Availability Time-Frame', 'required');
		 //$this->form_validation->set_rules('travelreq', 'Travel Required', 'required');
		 $this->form_validation->set_rules('postanonymous', 'Post Anonymous', 'required');

		 $post = $this->input->post();
		 $la_post['job_title'] = (!isset($post['title'])) ? "" : $post['title'];
		 $la_post['job_description'] = (!isset($post['long_description'])) ? "" : $post['long_description'];
		 $la_post['min_salary'] = (!isset($post['minsal'])) ? "" : $post['minsal'];
		 $la_post['max_salary'] = (!isset($post['maxsal'])) ? "" : $post['maxsal'];
		 $la_post['educational_level'] = (!isset($post['educationlevel'])) ? "" : $post['educationlevel'];
		 $la_post['experience'] = (!isset($post['years_of_experience'])) ? "" : $post['years_of_experience'];
		 $la_post['preferred_location'] = (!isset($post['location'])) ? "" : $post['location'];
		 $la_post['designation'] = (!isset($post['designation'])) ? "" : $post['designation'];
		 $la_post['avl_time_frame'] = (!isset($post['avl_time_frame'])) ? "" : $post['avl_time_frame'];
		 $la_post['travel_required'] = (!isset($post['travelreq'])) ? "" : $post['travelreq'];
		 $la_post['post_anonymous'] = (!isset($post['postanonymous'])) ? "" : $post['postanonymous'];
		 $job_id =$post['job_id'];
		 
		 $la_post['job_status'] = 1;
		 if ($this->form_validation->run() == FALSE) {
			 $response['msg'] = str_replace(["<p>"], " ", validation_errors());
			 $response['msg'] = str_replace(["</p>"], "<br>", $response['msg']);
		 } else {
			 $this->db->where(array('id'=>$job_id));
			 $update = $this->db->update('jobs', $la_post);
			 if ($update) {
			      $location_ids = $post['location_id'];
			    
					if (!empty($location_ids)) {
						$this->db->delete('job_city',array('job_id'=>$job_id,'user_id'=>$uid));
						foreach ($location_ids as $location_id) {
							$this->db->insert('job_city',array('job_id'=>$job_id,'location_id'=>$location_id,'user_id'=>$uid));
				        }
				    }
				 $la_post['Job_id'] = $job_id;
				 $response['success'] = true;
				 $response['data'] = $la_post;
				 $response['msg'] = 'Job has been successfully updated';
			 }
		 }

	 } else {
		 $response = array('success' => false, 'msg' => 'Please login at first');
	 }
	 echo json_encode($response);
 }
     public function apply_job() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('candidate', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');

            $jobId = $this->uri->segment(3);

            $la_post['applied_by_user_id'] = $uid;
            $la_post['applied_in_job_id'] = $jobId;
            $la_post['applied_date'] = date('Y-m-d H:i:s');

            $favorites = $this->Users_model->getData('job_applied', ['applied_by_user_id' => $uid, 'applied_in_job_id' => $jobId]);
            if (empty($favorites)) {
                $insertId = $this->Users_model->insertData('job_applied', $la_post);
                if ($insertId) {
                    $response['success'] = true;
                    $response['text'] = "Already Aplied";
                    $response['flag'] = "add";
                    $response['msg'] = 'Job Applied Successfully';
                }
            } else {
                $return = $this->Users_model->deleteData('job_applied', ['applied_by_user_id' => $uid, 'applied_in_job_id' => $jobId]);
                if ($return) {
                    $response['success'] = true;
                    $response['text'] = "Apply";
                    $response['flag'] = "remove";
                    $response['msg'] = 'Successfully Remove From List';
                }
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a Candidate');
        }

        echo json_encode($response);
    }

	public function save_job() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('candidate', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');

            $jobId = $this->uri->segment(3);

            $la_post['save_by_user_id'] = $uid;
            $la_post['saved_job_id'] = $jobId;
            $la_post['saved_date'] = date('Y-m-d H:i:s');

            $favorites = $this->Users_model->getData('save_jobs', ['save_by_user_id' => $uid, '	saved_job_id' => $jobId]);
            if (empty($favorites)) {
                $insertId = $this->Users_model->insertData('save_jobs', $la_post);
                if ($insertId) {
                    $response['success'] = true;
                    $response['text'] = "Remove";
                    $response['flag'] = "add";
                    $response['msg'] = 'Added to your Savelist';
                }
            } else {
                $return = $this->Users_model->deleteData('save_jobs', ['save_by_user_id' => $uid, 'saved_job_id' => $jobId]);
                if ($return) {
                    $response['success'] = true;
                    $response['text'] = "Save This Job";
                    $response['flag'] = "remove";
                    $response['msg'] = 'Remove from Savelist';
                }
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a Candidate');
        }

        echo json_encode($response);
    }

	public function fav_candidate() {

        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('employer', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');
			$favId = $this->uri->segment(3);

            $la_post['favorite_by_user_id'] = $uid;
            $la_post['favorite_in_user_id'] = $favId;
            $la_post['favorite_date'] = date('Y-m-d H:i:s');

            $favorites = $this->Users_model->getData('favorites_candidate', ['favorite_by_user_id' => $uid, 'favorite_in_user_id' => $favId]);
            if (empty($favorites)) {
                $insertId = $this->Users_model->insertData('favorites_candidate', $la_post);
                if ($insertId) {
                    $response['success'] = true;
                    $response['text'] = "Remove From Favorite";
                    $response['flag'] = "add";
                    $response['msg'] = 'Added to your Favorite';
                }
            } else {
                $return = $this->Users_model->deleteData('favorites_candidate', ['favorite_by_user_id' => $uid, 'favorite_in_user_id' => $favId]);
                if ($return) {
                    $response['success'] = true;
                    $response['text'] = "Add to Favorite";
                    $response['flag'] = "remove";
                    $response['msg'] = 'Remove from Favorite';
                }
            }
            
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a Employer');
        }

        echo json_encode($response);
    }

	public function message_to_candidate() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('employer', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');

            $candidateId = $this->uri->segment(3);
		
            $this->form_validation->set_rules('subject', 'name', 'required');
            $this->form_validation->set_rules('message', 'message', 'required');
            $post = $this->input->post();

            $la_post['send_to'] = $candidateId;  // seller id
            $la_post['send_from'] = $uid; // buyer_id
            $la_post['subject'] = $post['subject'];
            $la_post['message'] = $post['message'];
            $la_post['created_on'] = date('Y-m-d H:i:s');
            $la_post['updated_on'] = date('Y-m-d H:i:s');
            $la_post['ip'] = get_client_ip();
		

//            print_r($mailBody);
//            die;
            if ($this->form_validation->run() == FALSE) {
                $response['msg'] = str_replace(["<p>"], " ", validation_errors());
                $response['msg'] = str_replace(["</p>"], "<br>", $response['msg']);
            } else {

                $insertId = $this->Users_model->insertData('message_chatting', $la_post);
                if ($insertId) {

                    $la_notification = [
                        'notification_for_user' => $candidateId,
                        'notification_by_user' => $uid,
                        'notification_type' => 'message',
                        'act_id' => $insertId,
                        'notification_title' => 'Message from candidate page',
                        'notification_body' => $post['subject'] . " send a message",
                    ];
                    $this->Login_model->save_notification($la_notification);

                    $response['success'] = true;
                    $response['data'] = $la_post;
                    $response['msg'] = ' Message Submitted Successfully';
                }
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a employer');
        }
        echo json_encode($response);
    }

	public function connectstripe(){
		$user = authentication();
		$stripe_details = getAdminStripe();
		$uid = $user['id'];
		$stripe = new \Stripe\StripeClient($stripe_details->secret_key);

		$get_seller_payment_details = $this->users_model->get_all_details($uid);
		if($get_seller_payment_details->stripe_doc_back_id != '' || $get_seller_payment_details->stripe_doc_front_id != '' || $get_seller_payment_details->bank_account_number != ''
			|| $get_seller_payment_details-> bank_account_number  != ''){

		$create_account = $stripe->accounts->create([
		'type' => 'custom',
		  'country' => 'US',
		  'email' => $user['email'],
		  'capabilities' => [
			'card_payments' => ['requested' => true],
			'transfers' => ['requested' => true],
		  ],
		'business_type' => "individual",            
		            
		"individual" => ["first_name" =>  'Ashok',                
		"last_name" => 'Majumder',                
		"address" => [
			'city'=> 'Belton',
			'country'=> 'US',
			'line1'=>  '1304 N Main St',
			'postal_code'=> '76513',
			'state'=> 'Texas'
		],   
		'email'=> $get_seller_payment_details->email,
		'phone'=> '+1'+$get_seller_payment_details->phone,
		"dob" => ["day" => "19",                    
		"month" => "12",                    
		"year" => "1990"], 
		"verification" => [
			"document"=> [
				"front"=> $get_seller_payment_details->stripe_doc_front_id,
				"back"=> $get_seller_payment_details->stripe_doc_back_id,
			],
			"additional_document" => [
				"front"=> $get_seller_payment_details->stripe_doc_front_id,
				"back"=> $get_seller_payment_details->stripe_doc_back_id,
			]
		],
		"ssn_last_4" => "1234"
		],
		"business_profile" => ['url' => "https://brainiuminfotech.com","mcc"=> 5734],
		"external_account" => [
			 "object"=> "bank_account",
              "country"=> "US",
              "currency"=> "USD",
              "routing_number"=> $get_seller_payment_details->bank_routing_number,
              "account_number"=> $get_seller_payment_details->bank_account_number
		],
		'tos_acceptance' => ['date' => time(),                
		'ip' => $_SERVER['REMOTE_ADDR']]
		]);
		
		/*$retreve_data = $stripe->accounts->retrieve('acct_1HybuP2Rb4r2rdhr',[]);

		$retreve_data->individual->address->city = $get_seller_payment_details->city != '' ? $get_seller_payment_details->city :'Nutley';
		$retreve_data->individual->address->state = $get_seller_payment_details->address != '' ? $get_seller_payment_details->address :'NJ';
		$retreve_data->individual->address->country ='US';
		$retreve_data->individual->address->postal_code = '07110';
		$retreve_data->individual->address->line1 = $get_seller_payment_details->address != '' ? $get_seller_payment_details->address :'898 Henry St';
		$retreve_data->save();*/

			
			if($create_account['id'] != ''){
				$update = $this->users_model->upload_account_details($uid, ['stripe_account_id'=>$create_account['id']]);
				if($update){
					$response = array('success' => true, 'msg' => 'Successfully Connected With Gateway');
				}else{
					$response = array('success' => false, 'msg' => 'Something Went Wrong!');
				}
			}else{
				$response = array('success' => false, 'msg' => 'Something Went Wrong!');
			}
				
		}else{
			
				$response = array('success' => false, 'msg' => 'Please Filled Up bank and payment forms');
		}
		echo json_encode($response);
		
	

		/*$account_links = $stripe->accountLinks->create([
		  'account' => $create_account['id'],
		  'refresh_url' => 'http://localhost/officeyew/user/reauth',
		  'return_url' => 'https://localhost/officeyew/user/success',
		  'type' => 'account_onboarding',
		]);*/

	
		//echo json_encode($account_links);
		
	}


	public function stripe_document_upload(){
		$user = authentication();
		$stripe_details = getAdminStripe();
		$uid = $user['id'];
		$stripe = new \Stripe\StripeClient($stripe_details->secret_key);
	

		/*$frontfile = $_FILES['front-file'];
		echo json_encode(frontfile);
		if (isset($frontfile['name']) && ($frontfile['name'] != '')) {
			echo json_encode($frontfile['name']);
		}else{
			echo "Please Upload a File";
		}*/
		if(isset($_FILES['frontFile']['name'])&& $_FILES['frontFile']['name'] != ''){
			$file = $_FILES['frontFile'];
			$fileName = $uid . "-" . time() . "-" . $_FILES['frontFile']['name'];
			$path = 'user/stripedoc/';
            $upload_dir = UPLOADDIR . $path;
			$filepath = $upload_dir."".$fileName;
			move_uploaded_file($file['tmp_name'], $upload_dir . $fileName);
			$fp = fopen($filepath, 'r');
			$createfrontfile = $stripe->files->create([
			  'purpose' => 'identity_document',
			  'file' => $fp
			]);
			
		}else{
			$createfrontfile['id'] = '';
			$fileName = '';

		}

		if(isset($_FILES['backFile']['name'])&& $_FILES['frontFile']['name'] != ''){
			$backfilename = $_FILES['backFile']['name'];
			$file = $_FILES['backFile'];
			$backfilename = $uid . "-" . time() . "-" . $_FILES['backFile']['name'];
			$path = 'user/stripedoc/';
            $upload_dir = UPLOADDIR . $path;
			$filepath = $upload_dir."".$fileName;
			move_uploaded_file($file['tmp_name'], $upload_dir . $backfilename);
			$fp = fopen($filepath, 'r');
			$createbackfile = $stripe->files->create([
			  'purpose' => 'identity_document',
			  'file' => $fp
			]);
			
		}else{
			$createbackfile['id'] = '';
			$backfilename = '';
		}
		

		$update = $this->users_model->upload_stripe_document($uid, ['stripe_doc_front_id'=>$createfrontfile['id'],'front_file' => $fileName,'stripe_doc_back_id'=>$createbackfile['id'],
			'back_file'=>$backfilename]);
			if($update){
				$response = array('success' => true, 'msg' => 'Document Uploaded Successfully!');
			}else{
		
			$response = array('success' => false, 'msg' => 'Something Went Wrong!');
		}
		echo json_encode($response);

	}



}

  

 
