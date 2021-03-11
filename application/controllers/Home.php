<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Home extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Cms_model');
        $this->load->model('Users_model');
        $this->load->model('Product_model');
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index() {
        $user = authentication(false);
        $userId = 0;
        if (isset($user['id']) && ($user['id'] != '')) {
            $userId = $user['id'];
        }

        $categories = $this->Users_model->getData('product_category', ['status' => 1], '*', [], [], ['order_by' => 'name', 'sort' => 'ASC']);

        $currentIp = get_client_ip();
        $currentCity = "Kolkata";
        if (!in_array($currentIp, ["::1", "127.0.0.1"])) {
            $currentData = json_decode(file_get_contents('http://ip-api.io/json/' . get_client_ip()));
            $currentCity = (isset($currentData->city)) ? $currentData->city : "";
        }
//        print_r($currentCity);
////        echo "<br>";
//        die;
        $limit['limit'] = ITEM_PRODACT_LG_HOME;
        $limit['offset'] = 0;

        $orderBy['orderBy'] = 'p.is_boost';
        $orderBy['type'] = 'DESC';

        $la_productList = $this->Product_model->getProductList_home($userId, $limit, $orderBy, $currentCity);
//        $la_productList = $this->Product_model->getProductList('', 0, $limit, '', '', '', $orderBy);

        $this->commonData['page'] = 'home';
        $this->commonData['categories'] = $categories;
        $this->commonData['la_productList'] = $la_productList;

        $this->loadFScreen('frontend/home');
    }

    public function subscription_and_charges() {
        $user = authentication(false);
        $userId = 0;
        $activeSubscriptionId = 0;
        $activeJobPostingSubscriptionId = array();
        if (isset($user['id']) && ($user['id'] != '')) {
            $userId = $user['id'];

            $subscription = $this->Users_model->getData('subscription_for_boost', ['user_id' => $userId, 'status' => 'A']);
            
            if(count($subscription) > 0){
                $activeSubscriptionId = $subscription[0]->subscription_id;
            }

            $jobSubscription = $this->Users_model->getData('job_posting_subscription', ['user_id' => $userId, 'status' => 'A']);
			//echo '<pre>';
			//print_r($jobSubscription);
			if (count($jobSubscription) > 0) {
				for ($i=0;$i<count($jobSubscription);$i++) {
					$activeJobPostingSubscriptionId[] = $jobSubscription[$i]->subscription_id;
				}
                
            }
        }
		//print_r($activeJobPostingSubscriptionId);

        $la_dataProductBoost = $this->Cms_model->get_subscription_and_charges();
        $la_dataJobPosting = $this->Cms_model->get_subscription_for_job_posting();

//print_r($subscription);die;
        $this->commonData['title'] = 'Optional Subscription & Charges';
        $this->commonData['header_flag'] = 'text_only';
        $this->commonData['activeSubscriptionId'] = $activeSubscriptionId;
        $this->commonData['activeJobPostingSubscriptionId'] = $activeJobPostingSubscriptionId;
        $this->commonData['la_data'] = $la_dataProductBoost;
        $this->commonData['la_dataJobPosting'] = $la_dataJobPosting;
        $this->loadFScreen('frontend/subscription_and_charges');
    }

	public function thank_you(){
		$data = $this->uri->segment(2);
		$this->commonData['title'] = 'Thank You';
        $this->commonData['header_flag'] = 'text_only';
		 $this->commonData['transId'] = $data;
		$this->loadFScreen('frontend/thankyou');
	}

}
