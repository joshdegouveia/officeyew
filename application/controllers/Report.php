<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Report extends BaseController {

	public function __construct(){
		parent::__construct();  
		$this->load->model('Report_model');
		//$this->load->library('image_lib');
    }

    public function averageSale () {
    	$user = authentication();
    	if ($user['type'] != B2B && $user['type'] != SELLER) {
    		redirect(base_url('user/dashboard'), 'refresh');
    	}
    	$this->load->model('Users_model');

    	$data = $this->Report_model->getAverageSale($user['id'], $user['type']);

    	$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['title'] = 'Average Sale';
		$this->commonData['user'] = $user;
		$this->commonData['content'] = $data;
		$this->loadScreen('frontend/report/average_report');
    }

    public function trendingReport () {
    	$user = authentication();
    	if ($user['type'] != B2B && $user['type'] != SELLER) {
    		redirect(base_url('user/dashboard'), 'refresh');
    	}
    	$this->load->model('Users_model');

    	$data = $this->Report_model->trendingReport($user['id']);

    	$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['title'] = 'Trending Report';
		$this->commonData['user'] = $user;
		$this->commonData['content'] = $data;
		$this->loadScreen('frontend/report/trendingreport');
    }

    public function topreSeller () {
    	$user = authentication();
    	if ($user['type'] != B2B && $user['type'] != SELLER) {
    		redirect(base_url('user/dashboard'), 'refresh');
    	}
    	$this->load->model('Users_model');

    	$data = $this->Report_model->topReseller($user['id']);

    	$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['title'] = 'Top Reseller';
		$this->commonData['user'] = $user;
		$this->commonData['content'] = $data;
		$this->loadScreen('frontend/report/topreseller');
    }

    public function customReport ($action = '', $cid = '') {
    	$user = authentication();
    	if ($user['type'] != B2B && $user['type'] != SELLER) {
    		redirect(base_url('user/dashboard'), 'refresh');
    	}

    	$this->load->model('Users_model');

    	if ($this->input->post('name')) {
    		if (!$this->input->post('fields')) {
    			$this->session->set_flashdata('msg_error', 'Please select fields.');
    			redirect(base_url('report/customreport'), 'refresh');
    		}

    		$fields = array(
    			'name' => trim($this->input->post('name')),
    			'fields' => serialize($this->input->post('fields')),
    			'created_date' => time(),
    			'modified_date' => time(),
    		);

    		if ($action == 'edit') {
    			$this->Users_model->updateData('custom_report', array('id' => $cid), $fields);
	    		$this->session->set_flashdata('msg_success', 'Custom report successfully updated.');
    		} else {
    			$fields['user_id'] = $user['id'];
	    		$this->Users_model->insertData('custom_report', $fields);
	    		$this->session->set_flashdata('msg_success', 'Custom report successfully added.');
    		}

			redirect(base_url('report/customreport'), 'refresh');
    	}

    	$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['title'] = 'Custom Report';
		$this->commonData['user'] = $user;
		$this->commonData['js'][] = 'js/report.js';
		$fields = array('product_name' => 'Product name', 'amount' => 'Amount', 'customer_id' => 'Customer id', 'customer' => 'Customer name', 'customer_email' => 'Customer email', 'date' => 'Date', 'unit_sold' => 'Unit sold', 'total_amount' => 'Total amount');

		if ($user['type'] == B2B) {
			$fields = array('product_name' => 'Product name', 'amount' => 'Amount', 'reseller_id' => 'Reseller id', 'reseller' => 'Reseller name', 'reseller_email' => 'Reseller email', 'date' => 'Date', 'unit_sold' => 'Unit sold', 'total_amount' => 'Total amount');
    	}
		if ($action != 'view') {
			$this->commonData['fields'] = $fields;
			$reports = $this->Users_model->getData('custom_report', array('user_id' => $user['id']));
			$this->commonData['report_create'] = (count($reports) >=10) ? false : true;
			$report = array();

			if ($action == 'edit' && !empty($cid)) {
				$report = $this->Users_model->getData('custom_report', array('id' => $cid));
				if (empty($report)) {
					redirect(base_url('report/customreport'), 'refresh');
				}
				$report = $report[0];
				$this->commonData['report_create'] = true;
			}
			$this->commonData['content'] = $reports;
			$this->commonData['report'] = $report;
			$this->loadScreen('frontend/report/customreport');
		} else if ($action == 'view') {
			$content = array();
			$data = $this->Users_model->getData('custom_report', array('id' => $cid), 'name, fields');
			$this->commonData['user_fields'] = array();
			if (!empty($data)) {
				$user_fields = unserialize($data[0]->fields);
				$this->commonData['user_fields'] = $user_fields;
				if ($user['type'] == SELLER) {
					$content = $this->Report_model->customReport($user['id'], $user['type']);
				} else if ($user['type'] == B2B) {
					$content = $this->Report_model->customReport($user['id'], $user['type']);
				}
			}
			$this->commonData['fields'] = $fields;
			$this->commonData['content'] = $content;
			$this->loadScreen('frontend/report/customreportresult');
		}
    }

    public function customGraph ($action = '', $cid = '') {
    	$user = authentication();
    	if ($user['type'] != B2B && $user['type'] != SELLER) {
    		redirect(base_url('user/dashboard'), 'refresh');
    	}

    	$this->load->model('Users_model');

    	if ($this->input->post('name')) {
    		if (!$this->input->post('fields')) {
    			$this->session->set_flashdata('msg_error', 'Please select fields.');
    			redirect(base_url('report/customgraph'), 'refresh');
    		}

    		$fields = array(
    			'name' => trim($this->input->post('name')),
    			'field' => $this->input->post('fields'),
    			'type' => $this->input->post('date_type'),
    			'from_date' => ($this->input->post('date_type') == 'custom') ? $this->input->post('from_date') : '',
    			'to_date' => ($this->input->post('date_type') == 'custom') ? $this->input->post('to_date') : '',
    			'created_date' => time(),
    			'modified_date' => time(),
    		);

    		if ($action == 'edit') {
    			$this->Users_model->updateData('custom_graph', array('id' => $cid), $fields);
	    		$this->session->set_flashdata('msg_success', 'Custom graph successfully updated.');
    		} else {
    			$fields['user_id'] = $user['id'];
	    		$this->Users_model->insertData('custom_graph', $fields);
	    		$this->session->set_flashdata('msg_success', 'Custom graph successfully added.');
    		}

			redirect(base_url('report/customgraph'), 'refresh');
    	}

    	$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['title'] = 'Custom Graph';
		$this->commonData['user'] = $user;
		$this->commonData['js'][] = 'js/report.js';
		$fields = array('total_product' => 'Products', 'total_sale' => 'Sales', 'total_customer' => 'Customers');

		if ($user['type'] == B2B) {
			$fields = array('total_product' => 'Products', 'total_sale' => 'Sales', 'total_reseller' => 'Resellers');
    	}

    	$report_types = array('custom' => 'Custom', 'by_year' => 'Yearly', 'by_month' => 'Monthly', 'by_week' => 'Weekly', 'by_day' => 'Daily');
		
		$this->commonData['fields'] = $fields;
		$reports = $this->Users_model->getData('custom_graph', array('user_id' => $user['id']));
		$this->commonData['report_create'] = (count($reports) >=10) ? false : true;
		$report_graph_dashboard = $this->Users_model->getData('custom_graph_dashboard', array('user_id' => $user['id']), 'graph_id');
		$report = $report_graph_dashboard_arr = array();

		if ($action == 'edit' && !empty($cid)) {
			$report = $this->Users_model->getData('custom_graph', array('id' => $cid));
			if (empty($report)) {
				redirect(base_url('report/customgraph'), 'refresh');
			}
			$report = $report[0];
			$this->commonData['report_create'] = true;
		}

		if (!empty($report_graph_dashboard)) {
			foreach ($report_graph_dashboard as $value) {
				$report_graph_dashboard_arr[] = $value->graph_id;
			}
		}

		$this->commonData['content'] = $reports;
		$this->commonData['report'] = $report;
		$this->commonData['report_types'] = $report_types;
		$this->commonData['report_graph_dashboard'] = $report_graph_dashboard_arr;
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		$this->loadScreen('frontend/report/customgraph');
    }

    public function ajaxUpdate () {
    	$user = authentication();
		$response = array('success' => false, 'msg' => 'Unable to process');
		$post = $this->input->post();

		if (!isset($post['action']) || $post['action'] == '' || !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
			echo json_encode($response);
			exit;
		}

		$action = $post['action'];

		if ($action == 'get_cstm_graph') {
			$this->load->model('Users_model');
			$cid = $post['cid'];
			$content = array();
			$type = $name = '';
			$data = $this->Users_model->getData('custom_graph', array('id' => $cid), 'name, field, type, from_date, to_date');
			// $user_fields = $fields = array();
			if (!empty($data)) {
				$content = $this->Report_model->customGraph($user['id'], $user['type'], $data[0]);
				$response['success'] = true;

				$fields = array('total_product' => 'Products', 'total_sale' => 'Sales', 'total_customer' => 'Customers');

				if ($user['type'] == B2B) {
					$fields = array('total_product' => 'Products', 'total_sale' => 'Sales', 'total_reseller' => 'Resellers');
		    	}

		    	$type = $fields[$data[0]->field];
		    	$name = $data[0]->name;
				/*if ($user['type'] == SELLER) {
					$content = $this->Report_model->customGraph($user['id'], $user['type'], $data[0]);
				} else if ($user['type'] == B2B) {
					$content = $this->Report_model->customGraph($user['id'], $user['type'], $data[0]);
				}
				$fields = array('product_name' => 'Product name', 'amount' => 'Amount', 'customer_id' => 'Customer id', 'customer' => 'Customer name', 'customer_email' => 'Customer email', 'date' => 'Date', 'unit_sold' => 'Unit sold', 'total_amount' => 'Total amount');

				if ($user['type'] == B2B) {
					$fields = array('product_name' => 'Product name', 'amount' => 'Amount', 'reseller_id' => 'Reseller id', 'reseller' => 'Reseller name', 'reseller_email' => 'Reseller email', 'date' => 'Date', 'unit_sold' => 'Unit sold', 'total_amount' => 'Total amount');
		    	}*/
			}
			// $response['user_fields'] = $user_fields;
			// $response['fields'] = $fields;
			$response['content'] = $content;
			$response['type'] = $type;
			$response['name'] = $name;
			$response['msg'] = 'Report get success';
			$response['ut'] = ($user['type'] == B2B) ? 'breport' : 'sereport';
		} else if ($action == 'get_cstm_graph_dashboard') {
			$this->load->model('Users_model');
			$content = array();
			$data_fields = new stdClass();
			$data_fields->field = 'total_product';
			$data_fields->type = '';
			$content = $this->Report_model->customGraph($user['id'], $user['type'], $data_fields);
			$response['content1'] = $content;
			$response['type1'] = 'Products';

			$set_data = $this->Users_model->getData('custom_graph_dashboard', array('user_id' => $user['id']), 'graph_id');

			if (!empty($set_data)) {
				$data = $this->Users_model->getData('custom_graph', array('id' => $set_data[0]->graph_id), 'name, field, type, from_date, to_date');
				if (!empty($data)) {
					$content = $this->Report_model->customGraph($user['id'], $user['type'], $data[0]);

					$fields = array('total_product' => 'Products', 'total_sale' => 'Sales', 'total_customer' => 'Customers');

					if ($user['type'] == B2B) {
						$fields = array('total_product' => 'Products', 'total_sale' => 'Sales', 'total_reseller' => 'Resellers');
			    	}

			    	$type = $fields[$data[0]->field];
					$response['content2'] = $content;
					$response['type2'] = $type;
					$response['name2'] = $data[0]->name;
				}
			}
			$response['success'] = true;
			$response['msg'] = 'Report get success';
			$response['ut'] = ($user['type'] == B2B) ? 'breport' : 'sereport';
		} else if ($action == 'graph_to_dashboard') {
			$this->load->model('Users_model');
			$this->Users_model->deleteData('custom_graph_dashboard', array('user_id' => $user['id']));
			$fields = array(
				'user_id' => $user['id'],
				'graph_id' => $post['pid'],
				'created_date' => time()
			);
			$this->Users_model->insertData('custom_graph_dashboard', $fields);
			$response['success'] = true;
			$response['msg'] = 'Report graph successfully set to dashboard';
		} else if ($action == 'product_status') {
			$pid = str_replace('pid-', '', $post['pid']);
			$status = $post['val'];
			if (!empty($pid) && !empty($status)) {
				$this->load->model('Users_model');
				$this->Users_model->updateData('product_orders', array('id' => $pid), array('product_status' => $status, 'modified_date' => time()));
				$response['success'] = true;
				$response['data'] = ucwords($status);
				$response['msg'] = 'Product status successfully updated.';
			}
		}

		echo json_encode($response);
	}

	public function delete () {
		$user = authentication();
		$response = array('success' => false, 'msg' => 'Unable to process');
		$action = (isset($_GET['tp'])) ? $_GET['tp'] : '';
		$cid = (isset($_GET['cid'])) ? $_GET['cid'] : '';
		
		if (empty($action) || empty($cid)) {
			$this->session->set_flashdata('msg_error', 'Unable process');
			redirect(base_url('report/averagesale'), 'refresh');
		}

		$this->load->model('Users_model');

		if ($action == 'creport') {
			$this->Users_model->deleteData('custom_report', array('id' => $cid));
			$this->session->set_flashdata('msg_success', 'Report successfully deleted.');
			redirect(base_url('report/customreport'), 'refresh');
		} else if ($action == 'crgraph') {
			$this->Users_model->deleteData('custom_graph', array('id' => $cid));
			$this->Users_model->deleteData('custom_graph_dashboard', array('graph_id' => $cid));
			$this->session->set_flashdata('msg_success', 'Report Graph successfully deleted.');
			redirect(base_url('report/customgraph'), 'refresh');
		} else if ($action == 'notification') {
			$this->Users_model->deleteData('notification', array('id' => $cid));
			$this->session->set_flashdata('msg_success', 'Notification successfully deleted.');
			redirect(base_url('user/notification'), 'refresh');
		}
	}

	public function reportgraph ($cid = '') {
		$user = authentication();
    	if (($user['type'] != B2B && $user['type'] != SELLER) || !is_numeric($cid)) {
    		redirect(base_url('user/dashboard'), 'refresh');
    	}
    	$this->load->model('Users_model');

    	$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['title'] = 'Report Graph';
		$this->commonData['user'] = $user;
		$this->commonData['js'][] = 'js/report.js';
		$this->commonData['js'][] = 'js/jquery.canvasjs.min.js';
		// $this->commonData['extjs'][] = 'https://canvasjs.com/assets/script/jquery.canvasjs.min.js';
		$this->loadScreen('frontend/report/report_graph');
	}

	public function voucherOrders () {
		$user = authentication();
    	if ($user['type'] != B2B && $user['type'] != SELLER) {
    		redirect(base_url('user/dashboard'), 'refresh');
    	}
    	$this->load->model('Users_model');

    	$data = $this->Report_model->getVoucherOrders(SELLER, $user['id']);
    	$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['title'] = 'Voucher Order Customers List';
		$this->commonData['user'] = $user;
		$this->commonData['content'] = $data;
		$this->loadScreen('frontend/report/voucher_orders');
	}

	public function productOrders () {
		$user = authentication();
    	if ($user['type'] != B2B && $user['type'] != SELLER) {
    		redirect(base_url('user/dashboard'), 'refresh');
    	}
    	$this->load->model('Users_model');
    	$this->load->model('Product_model');

    	// $data = $this->Report_model->getProductOrders($user['type'], $user['id']);
    	$data = $this->Product_model->getOrders($user['id'], $user['type']);
    	// pre($data, 1);
    	$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['title'] = 'Product Order Customers List';
		$this->commonData['user'] = $user;
		$this->commonData['content'] = $data;
		$this->loadScreen('frontend/report/product_orders');
	}
    
}
	