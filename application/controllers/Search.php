<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Search extends BaseController {

	public function __construct(){
		parent::__construct();  
		$this->load->model('Search_model');
		//$this->load->library('image_lib');
    }

    public function products () {
    	$user = authentication(false);
    	$this->load->model('Users_model');
    	$k = ($this->input->get('k')) ? $this->input->get('k') : '';
    	$country = $state = $city = '';
    	if ($this->input->get('a')) {
    		$a = base64_decode($this->input->get('a'));
    		$a = explode(',', $a);
    		$country = $a[0];
    		$state = $a[1];
    		$city = $a[2];
    	}

    	/* current user select country */
		$this->load->helper('custom_helper');
		$country_code = (isset($_COOKIE['bm_rg'])) ? get_cookie('bm_rg') : 'in';
		$current_country = getCountries($country_code);
		/* current user select country */
    	$products = $this->Search_model->getSearchProducts($k, $country, $state, $city, $current_country['id']);

    	$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['title'] = 'Product Search';
		$this->commonData['user'] = $user;
		$this->commonData['products'] = $products;
		$this->loadScreen('frontend/search/search');
    }

    public function ajaxUpdate () {
    	$user = authentication(false);
		$response = array('success' => false, 'msg' => 'Unable to process');
		$post = $this->input->post();

		if (!isset($post['action']) || $post['action'] == '' || !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
			echo json_encode($response);
			exit;
		}

		$action = $post['action'];

		if ($action == 'get_product') {
			/* current user select country */
			$this->load->helper('custom_helper');
			$country_code = (isset($_COOKIE['bm_rg'])) ? get_cookie('bm_rg') : 'in';
			$current_country = getCountries($country_code);
			/* current user select country */
			$products = $this->Search_model->productsByTerm($post['term'], $current_country['id']);

			if (!empty($products)) {
				$output = '';
				foreach ($products as $value) {
					$link = base_url('products/detail/' . urlencode(base64_encode($value->id)));
					$output .= '<li>
                  <a class="list-link" href="' . $link . '">
                    <i class="fas fa-search"></i>
                    <span>' . $value->name . '</span> in ' . $value->category_name . '
                  </a>
                </li>';
				}

				$response['success'] = true;
				$response['msg'] = 'Search done';
				$response['data'] = $output;
			}
		}

		echo json_encode($response);
	}
    
}
	