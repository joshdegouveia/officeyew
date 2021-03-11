<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
require_once APPPATH . 'libraries/stripe/vendor/autoload.php';

use \Stripe\Stripe;
use \Stripe\Customer;
use \Stripe\ApiOperations\Create;
use \Stripe\Charge;
use \Stripe\Transfer;
use \Stripe\Token;

class Payment extends BaseController {

    private $apiKey;
    private $stripeService;

    public function __construct() {
        parent::__construct();
        $stripe = getAdminStripe();
//        print_r($stripe);die;
        $this->apiKey = '';
        if (!empty($stripe)) {
            $this->apiKey = $stripe->secret_key;
        }
        // $this->apiKey = 'sk_test_nvGHMb4PVb740YK9CRLRngcR';
        $this->stripeService = new \Stripe\Stripe();
        $this->stripeService->setVerifySslCerts(false);
        $this->stripeService->setApiKey($this->apiKey);
        $this->load->model('Product_model');
        $this->load->model('Users_model');
    }

    public function addCustomer($customerDetailsAry) {
        $customer = new Customer();
        $customerDetails = $customer->create($customerDetailsAry);
        return $customerDetails;
    }

    public function chargeAmountFromCard() {
        $user = authentication(false);
        $post = $this->input->post();

        if (!$post['token']) {
            $this->session->set_flashdata('msg_error', 'Unable to process.');
            redirect(base_url('subscription-charges'), 'refresh');
            exit();
        } else {
            $charge = new Charge();
            $trns = new Transfer();

            if (!empty($user)) {
                $uid = $user['id'];
            } else {
                $uid = 0;
                $this->session->set_flashdata('msg_error', 'Please login.');
                redirect(base_url('subscription-charges'), 'refresh');
                exit();
            }

            $batchid = md5(time());
            if (!isset($_SESSION['subscription_and_boost']) || empty($_SESSION['subscription_and_boost'])) {
                $this->session->set_flashdata('msg_error', 'Please login.');
                redirect(base_url('subscription-charges'), 'refresh');
                exit();
            }
            $subscription_and_boost = $_SESSION['subscription_and_boost'];
            $quentity = 1;
            $subscriptionId = $subscription_and_boost['subscriptionId'];
            $description = $subscription_and_boost['pName'];
            $totalprice = $subscription_and_boost['price'];
            $no_of_product = $subscription_and_boost['no_of_product'];
            $duration_in_days = $subscription_and_boost['duration_in_days'];

            $customerDetailsAry = array(
                'email' => $user['email'], // $post['email'],
                'source' => $post['token']
            );

            $customerResult = $this->addCustomer($customerDetailsAry);

            $postAry = array(
                'customer' => $customerResult->id,
                'amount' => $totalprice * 100, //$post['amount']*100 ,
                'currency' => CURRENCY_CODE, //$post['currency_code'],
                'description' => $description, // $post['item_name'],
                'metadata' => array(
                    'order_id' => $batchid// $post['item_number']
                )
            );
            unset($_SESSION['subscription_and_boost']);

            $result = $charge->create($postAry);

//            echo '<pre>';
//            print_r($result);
//            die;
            //echo '<pre>';print_r($result2);
            if ($result->status == 'succeeded') { //&& $result2->status == 'succeeded'
                $this->Users_model->updateData('subscription_for_boost', ['user_id' => $uid], ['status' => 'Ar']);

                $fields = array(
                    'user_id' => $uid,
                    'order_id' => $batchid,
                    'txn_no' => $result->id,
                    'subscription_id' => $subscriptionId,
                    'price' => $totalprice,
                    'duration_in_days' => $duration_in_days,
                    'product_no' => $no_of_product,
                    'ip' => get_client_ip(),
                    'status' => 'A',
                    'created_at' => date('Y-m-d H:i:s'),
                );
                $insert_id = $this->Product_model->insertData('subscription_for_boost', $fields);
                if ($insert_id) {
                    $this->session->set_flashdata('msg_success', 'Subscription successfully. Please check your dashboard');
                    redirect(base_url('subscription-charges'), 'refresh');
                    exit();
                } else {
                    $this->session->set_flashdata('msg_error', 'Something was wrong');
                    redirect(base_url('subscription-charges'), 'refresh');
                    exit();
                }
            } else {
//                echo '<pre>';
//                print_r($result);
//                die;
                $this->session->set_flashdata('msg_error', 'Something was wrong for payment');
                redirect(base_url('subscription-charges'), 'refresh');
                exit();
            }
        }
    }

    public function subscription_and_boost() {
        unset($_SESSION['subscription_and_boost']);
//        $_SESSION['subscription_and_boost'] = [];
        $ls_subscriptionId = $this->uri->segment(2);
        $subscriptionId = explode('-', $ls_subscriptionId)[0];
        $la_boostData = $this->Users_model->getData('boost_product_charges', ['boost_id' => $subscriptionId]);

        if (!isset($_SESSION['user_data']['id'])) {
            $_SESSION['user_data_url']['login_return_url'] = base_url("subscription-boost/$subscriptionId-" . time());
            redirect(base_url('sign-in'));
        } elseif (empty($la_boostData)) {
            redirect(base_url(), 'refresh');
        } else {
            $user = authentication();
            $row = $la_boostData[0];
            $boost_cat_id = $row->boost_cat_id;
            $no_of_product = ($row->product_posting_type == 'unlimited') ? "Unlimited" : $row->no_of_product;
            $price = 0;
            $pName = '';
            if ($boost_cat_id == 1) {
                $price = $row->month_wise_price;
                $pName = ($row->product_posting_type == 'unlimited') ? ucfirst($row->product_posting_type) : $row->no_of_product;
                $pName .= " products posting per month";
                $duration_in_days = 30;
            } elseif ($boost_cat_id == 2) {
                $price = $row->week_wise_price;
                $pName = ($row->product_posting_type == 'unlimited') ? ucfirst($row->product_posting_type) : $row->no_of_product;
                $pName .= " products posting for $row->no_of_weeks weeks";
                $duration_in_days = 7 * $row->no_of_weeks;
            }

            $_SESSION['subscription_and_boost']['subscriptionId'] = $subscriptionId;
            $_SESSION['subscription_and_boost']['pName'] = $pName;
            $_SESSION['subscription_and_boost']['price'] = $price;
            $_SESSION['subscription_and_boost']['no_of_product'] = $no_of_product;
            $_SESSION['subscription_and_boost']['duration_in_days'] = $duration_in_days;

            $stripe = getAdminStripe();

            $uid = $user['id'];
            $this->commonData['header_flag'] = 'text_only';
            $this->commonData['title'] = "Payment";
            $this->commonData['subscriptionId'] = $subscriptionId;
            $this->commonData['pName'] = $pName;
            $this->commonData['price'] = $price;
            $this->commonData['secret_key'] = $stripe->secret_key;
            $this->commonData['publish_key'] = $stripe->publish_key;
            $this->loadFScreen('frontend/payment/payment');
        }

//        print_r($user);
//        die($subscriptionId);
    }

    public function job_posting_subscription() {
        unset($_SESSION['job_posting_subscription']);
//        $_SESSION['job_posting_subscription'] = [];
        $ls_subscriptionId = $this->uri->segment(2);
        $subscriptionId = explode('-', $ls_subscriptionId)[0];
        $la_boostData = $this->Users_model->getData('job_posting_charges', ['job_posting_charges_id' => $subscriptionId]);
        //print_r($la_boostData);

        if (!isset($_SESSION['user_data']['id'])) {
            $_SESSION['user_data_url']['login_return_url'] = base_url("job-posting-subscription/$subscriptionId-" . time());
            redirect(base_url('sign-in'));
        } elseif (empty($la_boostData)) {
            redirect(base_url(), 'refresh');
        } else {
            $user = authentication();
            $row = $la_boostData[0];
//            print_r($row);
//            die;
            $price = 0;
            $pName = '';
            if ($row->job_category == 'per_post') {
                $price = $row->price;
                $pName = $row->description;
                $duration_in_days = 7 * $row->duration_in_week;
                $no_of_product = 0;
            } elseif ($row->job_category == 'monthly') {
                $price = $row->price;
                $pName = CURRENCY . $row->price . " for endless searches";
                $duration_in_days = 30;
                $no_of_product = 0;
            } elseif ($row->job_category == 'one_time') {
                $price = $row->price;
                $pName = CURRENCY . $row->price . " for " . $row->resume_number . " resumes";
                $duration_in_days = 0;
                $no_of_product = $row->resume_number;
            }
 

            $_SESSION['job_posting_subscription']['subscriptionId'] = $subscriptionId;
            $_SESSION['job_posting_subscription']['pName'] = $pName;
            $_SESSION['job_posting_subscription']['price'] = $price;
            $_SESSION['job_posting_subscription']['no_of_product'] = $no_of_product;
            $_SESSION['job_posting_subscription']['duration_in_days'] = $duration_in_days;

            $stripe = getAdminStripe();

            $uid = $user['id'];
            $this->commonData['header_flag'] = 'text_only';
            $this->commonData['title'] = "Payment";
            $this->commonData['subscriptionId'] = $subscriptionId;
            $this->commonData['pName'] = $pName;
            $this->commonData['price'] = $price;
            $this->commonData['secret_key'] = $stripe->secret_key;
            $this->commonData['publish_key'] = $stripe->publish_key;
            $this->loadFScreen('frontend/payment/job_posting_payment');
        }

//        print_r($user);
//        die($subscriptionId);
    }

	public function product_purchase_payment(){
		unset($_SESSION['purchase_and_payment']);
		$stripe = getAdminStripe();
		$ls_requestId = $this->uri->segment(2);
		$la_purchaseData = $this->Users_model->getData('purchase_request', ['purchase_request_id' => $ls_requestId]);
		$productid = $la_purchaseData[0]->product_id;
		$la_productData = $this->Users_model->getData('products', ['id' => $productid]);

		$_SESSION['purchase_and_payment']['purchaseId'] = $ls_requestId;
		$_SESSION['purchase_and_payment']['pId'] = $la_productData[0]->id;
        $_SESSION['purchase_and_payment']['pName'] = $la_productData[0]->name;
        $_SESSION['purchase_and_payment']['price'] = $la_purchaseData[0]->price;
        $_SESSION['purchase_and_payment']['no_of_product'] = 1;



		$this->commonData['header_flag'] = 'text_only';
        $this->commonData['title'] = "Payment for purchase product";
		$this->commonData['purchaseId'] = $ls_requestId;
		$this->commonData['pName'] = $la_productData[0]->name;
        $this->commonData['price'] = $la_purchaseData[0]->price;
		$this->commonData['pImage'] = $la_productData[0]->filename;
		$this->commonData['secret_key'] = $stripe->secret_key;
        $this->commonData['publish_key'] = $stripe->publish_key;
        $this->loadFScreen('frontend/payment/product_purchase_payment');
	}



    
    
    public function jobPostChargeAmountFromCard() {
        $user = authentication(false);
        $post = $this->input->post();

        if (!$post['token']) {
            $this->session->set_flashdata('msg_error', 'Unable to process.');
            redirect(base_url('subscription-charges'), 'refresh');
            exit();
        } else {
            $charge = new Charge();
            $trns = new Transfer();

            if (!empty($user)) {
                $uid = $user['id'];
            } else {
                $uid = 0;
                $this->session->set_flashdata('msg_error', 'Please login.');
                redirect(base_url('subscription-charges'), 'refresh');
                exit();
            }

            $batchid = md5(time());
            if (!isset($_SESSION['job_posting_subscription']) || empty($_SESSION['job_posting_subscription'])) {
                $this->session->set_flashdata('msg_error', 'Please login.');
                redirect(base_url('subscription-charges'), 'refresh');
                exit();
            }
            $job_posting_subscription = $_SESSION['job_posting_subscription'];
            $quentity = 1;
            $subscriptionId = $job_posting_subscription['subscriptionId'];
            $subscription_d = $this->db->select('*')->from('job_posting_charges')->where(array('job_posting_charges_id'=>$subscriptionId))->get()->result_array();
            $description = $job_posting_subscription['pName'];
            $totalprice = $job_posting_subscription['price'];
            $no_of_product = $job_posting_subscription['no_of_product'];
            
            $created_at = date('Y-m-d H:i:s');
            
            $job_category = $subscription_d[0]['job_category'];
            if($job_category=='per_post'){
            	$duration_in_days = $job_posting_subscription['duration_in_days'];
				$valid_upto=strtotime("+".$duration_in_days." day", strtotime($created_at));
				
				$valid_upto = date('Y-m-d H:i:s', $valid_upto);
				//echo $valid_upto ;exit;
			}elseif($job_category=='monthly'){
				$duration_in_days = '30';
				$valid_upto=strtotime("+".$duration_in_days." day", strtotime($created_at));
				$valid_upto = date('Y-m-d H:i:s', $valid_upto);
			}else{
				$duration_in_days =0;
				$valid_upto='unlimited';
			}
			
			
            $customerDetailsAry = array(
                'email' => $user['email'], // $post['email'],
                'source' => $post['token']
            );

            $customerResult = $this->addCustomer($customerDetailsAry);

            $postAry = array(
                'customer' => $customerResult->id,
                'amount' => $totalprice * 100, //$post['amount']*100 ,
                'currency' => CURRENCY_CODE, //$post['currency_code'],
                'description' => $description, // $post['item_name'],
                'metadata' => array(
                    'order_id' => $batchid// $post['item_number']
                )
            );
            unset($_SESSION['job_posting_subscription']);

            $result = $charge->create($postAry);

//            echo '<pre>';
//            print_r($result);
//            die;
            //echo '<pre>';print_r($result2);
            if ($result->status == 'succeeded') { //&& $result2->status == 'succeeded'
                $this->Users_model->updateData('job_posting_subscription', ['user_id' => $uid,'job_category'=>$job_category], ['status' => 'Ar']);

                $fields = array(
                    'user_id' => $uid,
                    'order_id' => $batchid,
                    'txn_no' => $result->id,
                    'subscription_id' => $subscriptionId,
                    'price' => $totalprice,
                    'duration_in_days' => $duration_in_days,
                    'product_no' => $no_of_product,
                    'ip' => get_client_ip(),
                    'status' => 'A',
                    'created_at' => $created_at,
                    'valid_upto'=>$valid_upto,
                    'job_category'=>$job_category
                );
                $insert_id = $this->Product_model->insertData('job_posting_subscription', $fields);
                if ($insert_id) {
                	$job_subscription_type = $job_category;
                	if($job_subscription_type=='per_post'){
						$this->Users_model->updateData('users', ['id' => $uid], ['max_job_posted_limit' => $subscription_d[0]['resume_number']]);
					}else{
						if($job_subscription_type=='one_time'){
							$limit_resume_number = $subscription_d[0]['resume_number'];
						}else{
							$limit_resume_number = 'unlimited';
						}
						$this->Users_model->updateData('users', ['id' => $uid], ['resume_search_count' => 0]);
					}
                	
                    $this->session->set_flashdata('msg_success', 'Subscription successfully.');
					//$this->session->set_flashdata('msg_success', 'Subscription successfully. Please check your dashboard');
                    redirect(base_url('subscription-charges'), 'refresh');
                    exit();
                } else {
                    $this->session->set_flashdata('msg_error', 'Something was wrong');
                    redirect(base_url('subscription-charges'), 'refresh');
                    exit();
                }
            } else {
//                echo '<pre>';
//                print_r($result);
//                die;
                $this->session->set_flashdata('msg_error', 'Something was wrong for payment');
                redirect(base_url('subscription-charges'), 'refresh');
                exit();
            }
        }
    }
	public function productPurchaseChargeAmountFromCard(){

		$user = authentication(false);
		print_r($user);
		exit;
        $post = $this->input->post();
		if (!$post['token']) {
            $this->session->set_flashdata('msg_error', 'Unable to process.');
            redirect(base_url(''), 'refresh');
            exit();
        }else{
			$charge = new Charge();
            $trns = new Transfer();
			if (!empty($user)) {
                $uid = $user['id'];
            } else {
                $uid = 0;
                $this->session->set_flashdata('msg_error', 'Please login.');
                redirect(base_url(''), 'refresh');
                exit();
            }
			$batchid = md5(time());
			if (!isset($_SESSION['purchase_and_payment']) || empty($_SESSION['purchase_and_payment'])) {
				$this->session->set_flashdata('msg_error', 'Please login.');
				redirect(base_url(''), 'refresh');
				exit();
			}
			$purchase_and_payment = $_SESSION['purchase_and_payment'];
			$quantity = 1;
			$purchaseId = $purchase_and_payment['purchaseId'];
            $description = $purchase_and_payment['pName'];
			$productid = $purchase_and_payment['pId'];
            $totalprice = $purchase_and_payment['price'];
            $no_of_product = $purchase_and_payment['no_of_product'];

			$get_purchaseDetails = $this->Users_model->getData('purchase_request', ['purchase_request_id' => $purchaseId]);
			$delivery_address = $get_purchaseDetails[0]->submitted_address;

			$get_productDetails = $this->Users_model->getData('products', ['id' => $productid]);
			$sellerId = $get_productDetails[0]->user_id;

			/*$getseller_stripe_account_id = $this->Users_model->getData('users_payment_details', ['userid' => $sellerId]);
			$seller_stripe_id = $getseller_stripe_account_id[0]->stripe_account_id;*/

			$totalAmount = $totalprice;
			$adminPercentage = 10;
			$sellerPercentage = (100 - $adminPercentage);
			$sellerAmount = round(($totalAmount * $sellerPercentage) / 100);
			$adminAmount = $totalAmount - $sellerAmount;

			$customerDetailsAry = array(
                'email' => $user['email'], // $post['email'],
                'source' => $post['token']
            );

			$customerResult = $this->addCustomer($customerDetailsAry);

			    $postAry = array(
                'customer' => $customerResult->id,
                'amount' => $totalprice * 100, //$post['amount']*100 ,
                'currency' => CURRENCY_CODE, //$post['currency_code'],
                'description' => $description, // $post['item_name'],
                'metadata' => array(
                    'order_id' => $batchid// $post['item_number']
                )
            );
			$result = $charge->create($postAry);
			
			
			/*$transferAry = array(
                'amount' => $sellerAmount,
                'currency' => CURRENCY_CODE, //$post['amount']*100 ,
                'destination' => $seller_stripe_id, //$post['currency_code'],
				'metadata' => array(
                    'order_id' => $batchid// $post['item_number']
                )
            );
			$transfer = $trns->create($transferAry);*/
		
			if ($result->status == 'succeeded') {
				$delete_req = $this->Users_model->deleteData('purchase_request', ['purchase_request_id' => $purchaseId]);

				 $fields = array(
					'product_id' => $productid,
					'order_by' => $uid,
					'seller_id' => $sellerId,
					'order_price' => $totalprice,
					'seller_amount' => $sellerAmount,
					'admin_amount' => $adminAmount,
					'order_qty' => $quantity,
					'order_by_email' =>  $user['email'],
					'order_by_phone' => $user['phone'],
					'order_status' => 'complete',
					'payment_status' => 'success',
					'delivery_status' => 'pending',
					'delivery_address' => $delivery_address,
					'transaction_id' => $batchid,
					'created_date' => date('Y-m-d H:i:s'),
					'modified_date' => date('Y-m-d H:i:s'),
                );

				 $insert_id = $this->Product_model->insertData('product_orders', $fields);
				 if ($insert_id) {
                    $this->session->set_flashdata('msg_success', 'Order Successfully Placed.');
//                    $this->session->set_flashdata('msg_success', 'Subscription successfully. Please check your dashboard');
                    redirect(base_url('thankyou/'.$batchid.''), 'refresh');
                    exit();
                } else {
                    $this->session->set_flashdata('msg_error', 'Something was wrong');
                    redirect(base_url('thankyou'), 'refresh');
                    exit();
                }
			}else{
				$this->session->set_flashdata('msg_error', 'Something was wrong for payment');
                redirect(base_url('product-purchase-payment/$purchaseId'), 'refresh');
                exit();
			}	
		} 

			
		}



}
