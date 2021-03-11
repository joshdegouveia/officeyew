<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Seller extends BaseController {

	public function __construct(){
		parent::__construct();  
		$this->load->model('Users_model');
		$this->load->model('Seller_model');
		$this->load->model('Product_model');
		$this->load->library('image_lib');
	}
	
	public function store()
	{
		$user = authentication();
		$post=$this->input->post();
		if($post)
		{
			if($post['store_name']!='')
			{
				$check_store_name = $this->Seller_model->check_store_name($post['store_name']);
				// echo 'test';
				// print_r($check_store_name);
				// exit();
				if(empty($check_store_name))
				{
					$slug = preg_replace("![^a-z0-9]+!i", "-", $post['store_name']);
					if(isset($_FILES['store_image']))
					{
						$file = $_FILES['store_image'];
						$image_types = array('image/png', 'image/jpg', 'image/jpeg', 'image/svg' ,'image/gif');
						if(!in_array($file['type'], $image_types))
						{
							$this->session->set_flashdata('msg_error', 'Invalid profile image uploaded.');
							redirect(base_url('store'), 'refresh');
						}
						$path = 'user/store/';
						$upload_dir = UPLOADDIR . $path;
						$thumb_path = 'thumb/';
						if ($_SERVER['HTTP_HOST'] == 'localhost') {
							$path = 'user\\store\\';
							$upload_dir = UPLOADDIR . $path;
							$thumb_path = 'thumb\\';
						}

						folderCheck($upload_dir . $thumb_path);

						$folder_path = $upload_dir . "/";
						$ext_arr = explode('.', $file['name']);

						$config['upload_path'] = $folder_path;
						$config['allowed_types'] = '*';
						$config['max_size']	= '0';
						$config['max_width'] = '0';
						$config['max_height'] = '0';
						$config['overwrite'] = TRUE;
						$image = 'store_' . time() . '_' . $user['id'] . '.' . end($ext_arr);
						$config['file_name'] = $image;
						$config['orig_name'] = $file['name'];
						$config['image'] = $image;
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						$this->upload->do_upload('store_image');
						//generate the thumbnail photo from the main photo
						$config['image_library'] = 'gd2';
						$config['source_image'] = $folder_path . $config['image'];
						$config['new_image'] = $folder_path . $thumb_path . $config['image'];
						$config['thumb_marker'] = '';
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 100;
						$config['height'] = 100;
						$this->load->library('upload', $config);
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						//generate the thumbnail photo from the main photo

						$fields = array(
							'user_id' => $user['id'],
							'name' => $post['store_name'],
							'slug' => $slug,
							'image' => $image,
							'description' => $post['store_desc'],
							'account_no' => $post['bank_acc_no'],
							'bank_name' => $post['bank_name'],
							'account_name' => $post['bank_acc_name'],
							'ifsc_code' => $post['bank_ifsc'],
							'created_date' => time()
						);
						$this->Seller_model->insert($fields);
						$this->session->set_flashdata('msg_success', 'Store created sucessfully..');
						redirect(base_url('store'), 'refresh');
					}
				}
				else if($check_store_name)
				{

				}
				else
				{
					$this->session->set_flashdata('msg_error', 'This store name is already exist');
					redirect(base_url('store'), 'refresh');
				}
			}
		}

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');
		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}
		$store_data = $this->Users_model->getData('store', array('user_id' => $user['id']));
		if(!empty($store_data))
		{
			$this->commonData['store_data'] =$store_data[0];
		}
		else{
			$this->commonData['store_data'] ='';
		}
		$this->commonData['user'] = $user;
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['js'][] = 'libs/ckeditor/ckeditor.js';	
		$this->loadScreen('frontend/seller/store');
	}

	public function favourites()
	{
		$user = authentication();
		$products = $this->Product_model->getUser_wishlistProduct($user['id']);
		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');
		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}
		$this->commonData['user'] = $user;
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['products'] = $products;
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';
		$this->loadScreen('frontend/seller/favourites');
	}

	public function deleteFavourites()
	{
		$user = authentication();
		$where = array('user_id'=>$_GET['uid'], 'product_id'=>$_GET['pid']);
		$wish_id = $this->Product_model->deleteData('product_wishlist', $where);
		$this->session->set_flashdata('msg_success', 'Favourit deleted sucessfully..');
		redirect(base_url('seller/favourites'), 'refresh');
	}
	////koustav mondal 04-12-2019////

	public function products () {
		$user = authentication();

		if ($user['type'] != SELLER) {
			redirect(base_url());
		}
		$products = $this->Product_model->getProducts('b2c_user_product_list', '', array('user_id' => $user['id']));
		// pre($products);
		// exit();
		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');
		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['products'] = $products;
		$this->commonData['title'] = 'Product List';
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		$this->commonData['js'][] = 'libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';
		$this->loadScreen('frontend/seller/product_list');
	}
	public function addProduct ($cid = '') {
		$user = authentication();
		if ($user['type'] != SELLER) {
			redirect(base_url());
		}
		$is_post = false;
		$cover_image = false;
		if ($this->input->post('name')) {
			$post = $this->input->post();
			$fields = array(
				'sku' => $post['sku'],
				'name' => trim($post['name']),
				'short_description' => $post['short_description'],
				'description' => $post['description'],
				'tags' => $post['tags'],
				'regular_price' => $post['regular_price'],
				'sale_price' => $post['sale_price'],
				'stock' => $post['stock'],
				'status' => ($post['status'] == 'on') ? 1 : 0,
				'modified_date' => time(),
			);
			if (!empty($cid)) {
				$this->Users_model->updateData('products', array('id' => $cid), $fields);
				$this->session->set_flashdata('msg_success', 'Product successfully updated.');
			} else {
				$fields['user_id'] = $user['id'];
				$fields['created_date'] = time();
				$cid = $this->Users_model->insertData('products', $fields);
				$stock_data = array(
					'seller_id'	=>	$user['id'],
					'b2b_id'	=>	0,
					'product_id'=>	$cid,
					'regular_price'	=>	$post['regular_price'],
					'sale_price'	=>	$post['sale_price'],
					'stock' => $post['stock'],
					'status' => ($post['status'] == 'on') ? 1 : 0,
				);
				$stock_cid = $this->Users_model->insertData('seller_stock_product', $stock_data);
				$this->session->set_flashdata('msg_success', 'Product successfully added.');
			}
			if (!empty($post['categories'])) {
				$this->Users_model->deleteData('product_categories', array('product_id' => $cid));
				$fields = array();
				foreach ($post['categories'] as $value) {
					$fields[] = array(
						'product_id' => $cid,
						'category_id' => $value,
						'created_date' => time()
					);
				}
				$this->Users_model->insertBatch('product_categories', $fields);
			}
			$is_post = true;
		}
		if (isset($_FILES['primary_image'])) {
			$file = $_FILES['primary_image'];
			$image_types = array('image/png', 'image/jpg', 'image/jpeg', 'image/svg' ,'image/gif');

			if (in_array($file['type'], $image_types)) {
				$path = 'products/';
				$thumb_path = 'thumb/';
				$upload_dir = UPLOADDIR . $path;
				if ($_SERVER['HTTP_HOST'] == 'localhost') {
					$path = 'products\\';
					$upload_dir = UPLOADDIR . $path;
					$thumb_path = 'thumb\\';
				}
				folderCheck($upload_dir . $thumb_path);
				$folder_path = $upload_dir . "/";
				$ext_arr = explode('.', $file['name']);

				$config['upload_path'] = $folder_path;
				$config['allowed_types'] = '*';
				$config['max_size']	= '0';
				$config['max_width'] = '0';
				$config['max_height'] = '0';
				$config['overwrite'] = TRUE;
				$image = 'product_' . time() . '_' . $user['id'] . '_' . rand(111, 999999) . '.' . end($ext_arr);
				$config['file_name'] = $image;
				$config['orig_name'] = $file['name'];
				$config['image'] = $image;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('primary_image')) {
					//generate the thumbnail photo from the main photo
					$config['image_library'] = 'gd2';
					$config['source_image'] = $folder_path . $config['image'];
					$config['new_image'] = $folder_path . $thumb_path . $config['image'];
					$config['thumb_marker'] = '';
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 698;
					$config['height'] = 399;
					$this->load->library('upload', $config);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();

					$cover_image = true;
					$fields = array('cover' => 'no');
					$this->Users_model->updateData('product_images', array('product_id' => $cid), $fields);
					$fields = array(
						'product_id' => $cid,
						'image' => $image,
						'cover' => 'yes',
						'created_date' => time(),
						'modified_date' => time(),
					);
					$this->Users_model->insertData('product_images', $fields);
				}
			}
		}
		if (isset($_FILES['images'])) {
			$files = $_FILES['images'];
			$image_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
			$files_total = count($files['name']);
			$path = 'products/';
			$upload_dir = UPLOADDIR . $path;
			if ($_SERVER['HTTP_HOST'] == 'localhost') {
				$path = 'products\\';
				$upload_dir = UPLOADDIR . $path;
			}
			folderCheck($upload_dir);
			$folder_path = $upload_dir . "/";
			$fields = array();
			for ($i = 0; $i < $files_total; $i++) {
				if (in_array(strtolower($files['type'][$i]), $image_types)) {
					if (isset($files['name'][$i]) && !empty($files['name'][$i])) {
						$_FILES['ufile']['name'] = $files['name'][$i];
			            $_FILES['ufile']['type'] = $files['type'][$i];
			            $_FILES['ufile']['tmp_name'] = $files['tmp_name'][$i];
			            $_FILES['ufile']['error'] = $files['error'][$i];
			            $_FILES['ufile']['size'] = $files['size'][$i];
			            $ext_arr = explode('.', $files['name'][$i]);
						$config['upload_path'] = $folder_path;
						$config['allowed_types'] = '*';
						$config['max_size']	= '0';
						$config['max_width'] = '0';
						$config['max_height'] = '0';
						$config['overwrite'] = TRUE;
						$image = 'product_' . time() . '_' . $user['id'] . '_' . rand(111, 999999) . $i . '.' . end($ext_arr);
						$config['file_name'] = $image;
						$config['orig_name'] = $files['name'][$i];
						$config['image'] = $image;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload('ufile')) {
							$cover = 'no';

							if (!$cover_image) {
								$cover = 'yes';
								$cover_image = true;
							}
							$fields[] = array(	
								'product_id' => $cid,
								'image' => $image,
								'cover' => $cover,
								'created_date' => time(),
								'modified_date' => time(),
							);
						}
					}
				}					
			}

			if (!empty($fields)) {
				$this->Users_model->insertBatch('product_images', $fields);
			}
		}

		if ($is_post) {
			redirect(base_url('seller/products'));
			exit();
		}

		$product = $categories = $product_images = $stock = array();
		$this->commonData['title'] = 'Product Add';
		if (!empty($cid)) {
			$product = $this->Users_model->getData('products', array('id' => $cid));
			$product = $product[0];
			if($product->user_id != $user['id'])
			{
				$stock = $this->Users_model->getData('seller_stock_product' , array('product_id' => $cid));
				$stock = $stock[0];
			}
			$categories = $this->Users_model->getData('product_categories', array('product_id' => $cid));
			$product_images = $this->Users_model->getData('product_images', array('product_id' => $cid));
			$this->commonData['title'] = 'Product Edit';
		}

		$product_categories = $this->Users_model->getData('product_category', array('status' => 1), 'id, name');
		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['product'] = $product;
		$this->commonData['user_categories'] = $categories;
		$this->commonData['product_images'] = $product_images;
		$this->commonData['product_categories'] = $product_categories;
		$this->commonData['stock'] = $stock;
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['js'][] = 'libs/ckeditor/ckeditor.js';
		$this->loadScreen('frontend/seller/product_add');
	}
	public function editProduct () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;
		if (empty($cid)) {
			redirect('seller/products', 'refresh');
		}
		$this->addProduct($cid);
	}

/////////////////////////////////////////////////////////////////////////
	public function vouchers () {
		$user = authentication();

		if ($user['type'] != SELLER) {
			redirect(base_url());
		}

		$vouchers = $this->Users_model->getdata('seller_discount_voucher', array('user_id' => $user['id']));

		$templates = $this->Users_model->getData('voucher_template', array('status' => 1), 'id, name, template');
		$customers = $this->Users_model->getFollowers($user['id'], array('status' => 1, 'block' => 0));

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['vouchers'] = $vouchers;
		$this->commonData['templates'] = $templates;
		$this->commonData['customers'] = $customers;
		$this->commonData['title'] = 'Voucher List';
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		$this->commonData['js'][] = 'libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';

		$this->loadScreen('frontend/seller/voucher_list');
	}

	public function editVoucher () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;

		if (empty($cid)) {
			redirect('seller/vouchers', 'refresh');
		}

		$this->addVoucher($cid);
	}

	public function addVoucher ($cid = '') {
		$user = authentication();

		if ($user['type'] != SELLER) {
			redirect(base_url());
		}

		if ($this->input->post('name')) {
			$post = $this->input->post();
			$fields = array(
				'name' => trim($post['name']),
				'code' => trim($post['code']),
				'description' => $post['description'],
				'discount_type' => 'all',
				'total_use' => $post['total_use'],
				'start_date' => $post['start_date'],
				'expiry_date' => $post['expiry_date'],
				'status' => ($post['status'] == 'on') ? 1 : 0,
				'modified_date' => time(),
			);
			
			$fields['percentage'] = $post['discount_price'];

			if ($post['discount_for'] == 'flat_rate') {
				$fields['percentage'] = 0;
				$fields['flat_rate'] = $post['discount_price'];
			}

			if (!empty($cid)) {
				$this->Users_model->updateData('seller_discount_voucher', array('id' => $cid), $fields);
				$this->session->set_flashdata('msg_success', 'Discout Voucher successfully updated.');
			} else {
				$fields['user_id'] = $user['id'];
				$fields['created_date'] = time();
				$cid = $this->Users_model->insertData('seller_discount_voucher', $fields);
				$this->session->set_flashdata('msg_success', 'Discount Voucher successfully added.');
			}

			/*$this->Users_model->deleteData('product_discount_categories', array('voucher_id' => $cid));
			$this->Users_model->deleteData('product_discount_items', array('voucher_id' => $cid));

			if ($post['discount_product'] == 'product' && !empty($post['product_items'])) {
				$fields = array();
				foreach ($post['product_items'] as $value) {
					$fields[] = array(
						'voucher_id' => $cid,
						'product_id' => $value,
						'created_date' => time()
					);
				}
				$this->Users_model->insertBatch('product_discount_items', $fields);
			} else if ($post['discount_product'] == 'category' && !empty($post['by_category'])) {
				$fields = array();
				foreach ($post['by_category'] as $value) {
					$fields[] = array(
						'voucher_id' => $cid,
						'category_id' => $value,
						'created_date' => time()
					);
				}
				$this->Users_model->insertBatch('product_discount_categories', $fields);
			}*/

			redirect(base_url('seller/vouchers'), 'refresh');
		}

		// $voucher = $categories = $product_items = array();
		$voucher = array();
		$this->commonData['title'] = 'Discount Voucher Add';
		if (!empty($cid)) {
			$voucher = $this->Users_model->getData('seller_discount_voucher', array('id' => $cid));
			$voucher = $voucher[0];
			/*$categories_arr = $this->Users_model->getData('product_discount_categories', array('voucher_id' => $cid), 'category_id');
			$product_items_arr = $this->Users_model->getData('product_discount_items', array('voucher_id' => $cid), 'product_id');
			if (!empty($categories_arr)) {
				foreach ($categories_arr as $value) {
					$categories[] = $value->category_id;
				}
			}
			if (!empty($product_items_arr)) {
				foreach ($product_items_arr as $value) {
					$product_items[] = $value->product_id;
				}
			}*/
			$this->commonData['title'] = 'Discount Voucher Edit';
		}

		/*$product_categories = $this->Users_model->getData('product_category', array('status' => 1), 'id, name');
		$products = $this->Users_model->getData('products', array('status' => 1, 'user_id' => $user['id']), 'id, name');*/
		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['voucher'] = $voucher;
		/*$this->commonData['user_categories'] = $categories;
		$this->commonData['user_products'] = $product_items;
		$this->commonData['product_categories'] = $product_categories;
		$this->commonData['products'] = $products;*/
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;

		$this->commonData['js'][] = 'libs/ckeditor/ckeditor.js';
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->loadScreen('frontend/seller/voucher_add');
	}

	public function delete () {
		$user = authentication();
		$response = array('success' => false, 'msg' => 'Unable to process');
		$action = (isset($_GET['tp'])) ? $_GET['tp'] : '';
		$cid = (isset($_GET['cid'])) ? $_GET['cid'] : '';
		
		if (empty($action) || empty($cid)) {
			$this->session->set_flashdata('msg_error', 'Unable process');
			redirect(base_url('user/dashboard'), 'refresh');
		}

		if ($action == 'voucher') {
			$this->Users_model->deleteData('seller_discount_voucher', array('id' => $cid));
			/*$this->Users_model->deleteData('product_discount_categories', array('voucher_id' => $cid));
			$this->Users_model->deleteData('product_discount_items', array('voucher_id' => $cid));*/
			$this->session->set_flashdata('msg_success', 'Discout Voucher successfully deleted.');
			redirect(base_url('seller/vouchers'), 'refresh');
		}
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
		if ($action == 'voucherpreview') {
			$user_ids = array();

			foreach ($post['customers'] as $value) {
				$user_ids[] = $value;
			}

			$template_arr = $this->Users_model->getData('voucher_template', array('id' => $post['template']), 'template');
			$template = $template_arr[0]->template;
			$voucher = $this->Users_model->getData('seller_discount_voucher', array('id' => $post['vid']));

			if (!empty($voucher)) {
				$voucher = $voucher[0];
				$discount = ($voucher->percentage > 0) ? $voucher->percentage . '%' : $voucher->flat_rate . ' rupees';
				$output = str_replace('{{name}}', 'Customer name', $template);
				$output = str_replace('{{code}}', $voucher->code, $output);
				$output = str_replace('{{expiry_date}}', $voucher->expiry_date, $output);
				$output = str_replace('{{limit}}', $voucher->total_use, $output);
				$output = str_replace('{{discount}}', $discount, $output);
				$response['success'] = true;
				$response['msg'] = 'Voucher preview done';
				$response['data'] = $output . '<button type="button" class="btn btn-sm btn-secondary preview-complete">Done</button>';
			}
		} else if ($action == 'vouchersend') {
			$user_ids = array();

			foreach ($post['customers'] as $value) {
				$user_ids[] = $value;
			}

			$template_arr = $this->Users_model->getData('voucher_template', array('id' => $post['template']), 'template');
			$template = $template_arr[0]->template;
			$users = $this->Users_model->getData('users', array(), 'id, first_name, last_name, email', array(), array('id' => $user_ids));
			$voucher = $this->Users_model->getData('seller_discount_voucher', array('id' => $post['vid']));

			if (!empty($voucher) && !empty($users)) {
				$voucher = $voucher[0];
				$discount = ($voucher->percentage > 0) ? $voucher->percentage . '%' : $voucher->flat_rate . ' rupees';
				$output = str_replace('{{code}}', $voucher->code, $template);
				$output = str_replace('{{expiry_date}}', $voucher->expiry_date, $output);
				$output = str_replace('{{limit}}', $voucher->total_use, $output);
				$template = str_replace('{{discount}}', $discount, $output);

				foreach ($users as $value) {
					$output = str_replace('{{name}}', ucwords($value->first_name . ' ' . $value->last_name), $template);
					// mail for confurmation
					$config = array (
				      	'mailtype' => 'html',
					    'charset'  => 'utf-8',
					    'priority' => '1'
					);
				    $this->email->initialize($config);
				    $this->email->from(SITE_EMAIL, SITE_NAME);
			    	// $this->email->to('rupam.brainium@gmail.com');
			    	$this->email->to($value->email);
				    $this->email->subject(SITE_NAME . ' Product Voucher');
				    $body = $output;
				    $this->email->message($body);
				    @$this->email->send();
					// // mail
				}

				$response['success'] = true;
				$response['msg'] = 'Voucher successfully has sent.';
				$response['data'] = '';
			}
		}
		
		echo json_encode($response);
	}

	public function businessVouchers () {
		$user = authentication();

		if ($user['type'] != SELLER) {
			redirect(base_url());
		}

		$data = $this->Seller_model->getVouchers('reseller_voucher_list', array('sv.seller_id' => $user['id']));
		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');
		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['content'] = $data;
		$this->commonData['title'] = 'Business Vouchers';
		// $this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		// $this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		// $this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		// $this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		// $this->commonData['js'][] = 'libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';
		$this->loadScreen('frontend/seller/businessvouchers');
	}

	public function editBusinessVoucher ($cid = '') {
		$user = authentication();

		if ($user['type'] != SELLER || empty($cid) || !is_numeric($cid)) {
			redirect(base_url());
		}

		if ($this->input->post('name')) {
			$post = $this->input->post();
			$fields = array(
				'name' => trim($post['name']),
				'sale_price' => $post['sale_price'],
				'description' => $post['description'],
				'status' => (isset($post['status']) && $post['status'] == 'on') ? 1 : 0,
				'modified_date' => time(),
			);
			
			$this->Users_model->updateData('seller_stock_voucher', array('id' => $cid), $fields);
			$this->session->set_flashdata('msg_success', 'Business Voucher successfully updated.');
			
			redirect(base_url('seller/businessvouchers'), 'refresh');
		}

		$data = $this->Seller_model->getVouchers('reseller_voucher_list', array('sv.seller_id' => $user['id']));

		if (empty($data)) {
			redirect(base_url('seller/businessvouchers'), 'refresh');
		}

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['title'] = 'Business Voucher';
		$this->commonData['voucher'] = $data[0];
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;

		$this->commonData['js'][] = 'libs/ckeditor/ckeditor.js';
		// $this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		// $this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->loadScreen('frontend/seller/businessvoucher_edit');
	}

	public function changeStat () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '';
		$stat = ($this->input->get('stat') &&  $this->input->get('stat') == '1') ? '0' : '1';
		$tp = ($this->input->get('tp')) ? $this->input->get('tp') : '';

		if (empty($cid)) {
			redirect('admin/faq/items', 'refresh');
		}
		
		if ($tp == 'bvouchers') {
			$fields = array(
				'status' => $stat
			);
			$this->Users_model->updateData('seller_stock_voucher', array('id' => $cid), $fields);
			redirect(base_url('seller/businessvouchers'), 'refresh');
		}
	}
}