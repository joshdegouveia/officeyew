<?php

defined('BASEPATH') OR exit('No direct script access allowed'); 

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class User extends BaseController {

    const MAX_PASSWORD_SIZE_BYTES = 4096;

    public function __construct() {
        parent::__construct();
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

        $user_detail = $this->users_model->getUserListById($uid);
        if (empty($user_detail)) {
            redirect(base_url());
        }
        $user_types = $user['user_types'];
        $la_mySubmittedRequest = [];
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
        if (in_array($user['type'], ['installer', 'designer'])) {
            $la_userLocationData = $this->Users_model->single_user_location($uid);
        }
        $li_myMessageList_count = $this->Message_model->my_message_list_count($uid)[0]->count;
//        $la_myMessageList = $this->Message_model->my_message_list($uid, $limit);
        $la_myMessageListAll = $this->Message_model->my_message_list($uid);

//        print_r($la_userLocationData);
//        die;
        $data['flag'] = $flag;
        $data['user'] = $user;
        $data['currentPage'] = 1;
        $data['user_detail'] = $user_detail[0];
        $data['la_pCategory'] = $la_pCategory;
        $data['li_mySubmittedRequest_count'] = $li_mySubmittedRequest_count;
        $data['li_myFavorites_count'] = $li_myFavorites_count;
        $data['li_purchaseRequests_count'] = $li_purchaseRequests_count;
        $data['li_myProduct_count'] = $li_myProduct_count;

        $data['la_mySubmittedRequest'] = $la_mySubmittedRequest;
        $data['la_myFavorites'] = $la_myFavorites;
        $data['la_myProduct'] = $la_myProduct;
        $data['la_purchaseRequests'] = $la_purchaseRequests;
        $data['li_subscriptionCharges_count'] = $li_subscriptionCharges_count;
        $data['la_subscriptionCharges'] = $la_subscriptionCharges;
        $data['li_myMessageList_count'] = $li_myMessageList_count;
//        $data['la_myMessageList'] = $la_myMessageList;
        $data['la_myMessageListAll'] = $la_myMessageListAll;
        $data['la_productsCondition'] = $la_productsCondition;
        $data['la_notableDefects'] = $la_notableDefects;
        $data['la_userLocationData'] = $la_userLocationData;


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

    public function profileDataUpdate() { // Update own profile data by Ajax
        $user = authentication();
        $uid = $user['id'];
        $response = array('success' => false, 'msg' => 'Unable to process');

        $this->form_validation->set_rules('first_name', 'first name', 'required');
        $this->form_validation->set_rules('last_name', 'last name', 'required');
        $this->form_validation->set_rules('phone', 'phone', 'required');
        $this->form_validation->set_rules('address', 'phone', 'required');
        if (in_array($user['type'], ['seller', 'installer', 'designer'])) {
            $this->form_validation->set_rules('stripe_secret_key', 'stripe secret key', 'required');
            $this->form_validation->set_rules('stripe_publish_key', 'stripe publish key', 'required');
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
            $la_post = $this->input->post();

            if (isset($la_post['location_id']) && count($la_post['location_id']) > 0) {
                
            } else {
                $response = array('success' => false, 'data' => $la_post, 'msg' => 'Please add business location!');
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
                if (isset($la_post['location_id']) && count($la_post['location_id']) > 0) {
                    $this->Users_model->deleteData('users_business_location', ['user_id' => $uid]);
                    foreach ($la_post['location_id'] as $city_id) {
                        $returnLocationData = $this->Users_model->getData('users_business_location', ['user_id' => $uid, 'city_id' => $city_id]);
                        if (count($returnLocationData) == 0) {
                            $this->Users_model->insertData('users_business_location', ['user_id' => $uid, 'city_id' => $city_id]);
                        }
                    }
                }
            }

            $update = $this->users_model->update($uid, $post);

            if ($update) {
                $_SESSION['user_data']['first_name'] = $post['first_name'];
                $_SESSION['user_data']['last_name'] = $post['last_name'];
                $_SESSION['user_data']['phone'] = $post['phone'];
                $_SESSION['user_data']['address'] = $post['address'];
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

        $la_usersData_count = $this->Users_model->getUsersByUserType_count("'installer'", $loggedId);
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

        $limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);

        $la_usersData_count = $this->Users_model->getUsersByUserType_count("'designer'", $loggedId);
        $la_usersData = $this->Users_model->getUsersByUserType("'designer'", $loggedId, $limit);
//        print_r($la_installer);die;
        $this->commonData['title'] = 'Designer list';
        $this->commonData['header_flag'] = 'search_designer_installer_list';
        $this->commonData['userType'] = 'designer';
        $this->commonData['uId'] = 0;
        $this->commonData['uName'] = '';
        $this->commonData['location_id'] = '';
        $this->commonData['ls_location'] = '';
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['li_usersDataCount'] = $la_usersData_count->user_count;
        $this->commonData['la_usersData'] = $la_usersData;
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
        $uName = (isset($_GET['name']) && ($_GET['name'] != '')) ? str_replace(["+"], " ", $_GET['name']) : '';
        $location_id = (isset($_GET['location_id'])) ? $_GET['location_id'] : "";

        $limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);

        $la_usersData_count = $this->Users_model->getUsersByUserType_count("'installer'", $loggedId);
        $la_usersData = $this->Users_model->getUsersByUserType("'installer'", $loggedId, $limit, '', '', $uId, $location_id);

        $this->commonData['title'] = 'Installer search';
        $this->commonData['header_flag'] = 'search_designer_installer_list';
        $this->commonData['userType'] = 'installer';
        $this->commonData['uId'] = $uId;
        $this->commonData['uName'] = $uName;
        $this->commonData['location_id'] = $location_id;
        $this->commonData['ls_location'] = (isset($_GET['location'])) ? $_GET['location'] : "";
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['li_usersDataCount'] = $la_usersData_count->user_count;
        $this->commonData['la_usersData'] = $la_usersData;
        $this->loadScreen('frontend/user/designer_installer_listing');
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

        $limit['limit'] = USER_GRID;
        $limit['offset'] = (($currentPage - 1 ) * USER_GRID);

        $la_usersData_count = $this->Users_model->getUsersByUserType_count("'designer'", $loggedId);
        $la_usersData = $this->Users_model->getUsersByUserType("'designer'", $loggedId, $limit, '', '', $uId, $location_id);

        $this->commonData['title'] = 'Designer search';
        $this->commonData['header_flag'] = 'search_designer_installer_list';
        $this->commonData['userType'] = 'designer';
        $this->commonData['uId'] = $uId;
        $this->commonData['uName'] = $uName;
        $this->commonData['location_id'] = $location_id;
        $this->commonData['ls_location'] = (isset($_GET['location'])) ? $_GET['location'] : "";
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['li_usersDataCount'] = $la_usersData_count->user_count;
        $this->commonData['la_usersData'] = $la_usersData;
        $this->loadScreen('frontend/user/designer_installer_listing');
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
        if (isset($lo_userDetail[0]->id) && ($lo_userDetail[0]->id != '')) {
            $lo_userDetail = $lo_userDetail[0];
            $user_location = $this->Users_model->single_user_location($lo_userDetail->id);
        } else {
            redirect();
        }
//        print_r($user_location);
//        die;
        $this->commonData['userId'] = $userId;
        $this->commonData['userType'] = $userType;
        $this->commonData['lo_userDetail'] = $lo_userDetail;
        $this->commonData['user_location'] = $user_location;
        $this->commonData['my_favorites'] = $my_favorites;
        $this->loadScreen('frontend/user/profile_details');
    }

    public function add_favorite_user() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != ''))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');

            $userId = $this->uri->segment(3);

            $la_post['added_by_user_id'] = $uid;
            $la_post['user_id'] = $userId;
            $la_post['added_datetime'] = date('Y-m-d H:i:s');

            $favorites = $this->Users_model->getData('favorites_user', ['added_by_user_id' => $uid, 'user_id' => $userId]);
            if (empty($favorites)) {
                $insertId = $this->Users_model->insertData('favorites_user', $la_post);
                if ($insertId) {
                    $response['success'] = true;
                    $response['text'] = "<i class='fa fa-heart'></i> Favorite";
                    $response['flag'] = "add";
                    $response['msg'] = 'Added to your favorites';
                }
            } else {
                $return = $this->Users_model->deleteData('favorites_user', ['added_by_user_id' => $uid, 'user_id' => $userId]);
                if ($return) {
                    $response['success'] = true;
                    $response['text'] = "<i class='fa fa-heart-o'></i> Favorite";
                    $response['flag'] = "remove";
                    $response['msg'] = 'Remove from your favorites';
                }
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login at first');
        }

        echo json_encode($response);
    }

    public function test() {
        $this->loadScreen('frontend/test');
    }

    

        public function addDesignerRequest(){
            //print_r($_POST);die;
            //$user = authentication();
            //if ((isset($user['id']) && ($user['id'] != ''))) {
                if ($this->input->post('office_qty')) {
                    //print_r($_POST);die;
                    //if(isset($this->input->post('area_required'))){
                        if(!empty($this->input->post('area_required'))){
                            $post_data['area_required'] = implode(",", $this->input->post('area_required'));
                        }else{
                            $post_data['area_required'] = "";
                        }
                    //}

                    $post_data['office_qty'] = $this->input->post('office_qty');
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
                    $this->session->set_flashdata('msg_success', 'Request created sucessfully..');
                }
            // }else{
            //     $this->session->set_flashdata('msg_error', 'Please login first.');
            // }
        }

}
