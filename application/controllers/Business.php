<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Business extends BaseController {

	public function __construct(){
		parent::__construct();
		// $this->load->library('facebook');
		$this->load->model('Users_model');
		$this->load->model('Product_model');
		$this->load->model('Login_model');
		$this->load->library('image_lib');		
	}

	public function index () {
		$user = authentication(false);

		if (!empty($user)) {
			redirect(base_url('user/account'));
		}

		if ($this->input->post()) {
			if ($this->Login_model->from_validation_login()) {
				$post_data = array();

				$post_data['email'] = $this->input->post('email');
				$post_data['password'] = $this->input->post('password');
				$post_data['type'] = B2B;

				$user = $this->Users_model->getData('users', $post_data);

				if (!empty($user)) {
					$user = $user[0];
					if($user->active == 0 && !empty($user)) {
						$this->session->set_flashdata('msg_error','Please active your account and try again.');
					} else if($user->active == 1 && !empty($user)) {
						$fields = array(
							'last_activity' => time()
						);
						$this->Users_model->updateData('users', array('id' => $user->id), $fields);
						$this->setUserData($user);
						redirect(base_url('user/profile'));
					}
				} else {
					$this->session->set_flashdata('msg_error','Email address does not exist.');
				}
			}
		}

		$region = array('b2b_login_logo', 'login_registration_logo');
		$logos = array('blfile' => 'b2b_login_logo', 'ufile' => 'login_registration_logo');
		$data = $this->Users_model->getData('home_page_setting', array(), 'id, region, value', array(), array('region' => $region));
		$logo = FILEPATH . 'img/backgrounds/img-12.jpg';
		$logo_images = array('b2b_login_logo' => '', 'login_registration_logo' => '');
		foreach ($data as $value) {
			if ($value->region == 'b2b_login_logo') {
				$logo_images['b2b_login_logo'] = $value->value;
			} else if ($value->region == 'login_registration_logo') {
				$logo_images['login_registration_logo'] = $value->value;
			}
		}

		if (!empty($logo_images['b2b_login_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['b2b_login_logo'];
		} else if (!empty($logo_images['login_registration_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['login_registration_logo'];
		}
		
		$this->commonData['logo'] = $logo;
		$this->commonData['title'] = 'Business Login';

		$this->loadPlainScreen('frontend/business/login');
	}

	public function register ()	{
		$user = authentication(false);
		if($this->input->post() && empty($user)) {
			if ($this->Login_model->from_validation_resgistration()) {
				if (!checkEmail(trim($this->input->post('email')))) {
					$post_data = array();
					$activation_code = md5(date("YmdHis") . rand(100,999));
					$post_data['uniqueid'] 			= uniqid();
					$post_data['first_name'] 		= trim($this->input->post('first_name'));
					$post_data['last_name'] 		= trim($this->input->post('last_name'));
					$post_data['email'] 			= trim($this->input->post('email'));
					$post_data['password'] 			= $this->input->post('password');
					$post_data['phone'] 			= trim($this->input->post('phone'));
					$post_data['type'] 				= B2B;
					$post_data['activation_code']	= $activation_code;
					$post_data['active']			= 0;
					$post_data['created_date']		= time();
					$post_data['modified_date']		= time();
					$post_data['ip_address']		= $_SERVER['REMOTE_ADDR'];

					$uid = $this->Login_model->insert('users', $post_data);
					// mail for confurmation
					$name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
					$name = ucwords($name);
					$config = array (
				      	'mailtype' => 'html',
					    'charset'  => 'utf-8',
					    'priority' => '1'
					);
				    $this->email->initialize($config);
				    $this->email->from(SITE_EMAIL, SITE_NAME);
			    	// $this->email->to('rupam.brainium@gmail.com');
			    	$this->email->to($this->input->post('email'));
				    $data_arr = array(
				    	'username'=> $name,
				    	'email'=> $this->input->post('email'),
				    	'active_link'=> base_url() . 'newuser/activation/' . $activation_code,
				    );
				    $this->email->subject(SITE_NAME . ' Register Activation Link');
				    $body = $this->load->view('frontend/email/registration.php', $data_arr, TRUE);
				    $this->email->message($body);
				    @$this->email->send();
					// // mail
					if(!empty($uid)) {
						$this->session->set_flashdata('msg_success', 'You have sucessfully registered. A verification link has been sent to your email account.');
						redirect(base_url('business'));
					} else {
						$this->session->set_flashdata('msg_error', 'You are not registred please try again');
					}
				} else {
						$this->session->set_flashdata('msg_error', 'Email address already exist. Please try with another email address.');
				}
			}
		}

		$region = array('b2b_registration_logo', 'login_registration_logo');
		$logos = array('blfile' => 'b2b_registration_logo', 'ufile' => 'login_registration_logo');
		$data = $this->Users_model->getData('home_page_setting', array(), 'id, region, value', array(), array('region' => $region));

		$logo = FILEPATH . 'img/backgrounds/img-12.jpg';

		$logo_images = array('b2b_registration_logo' => '', 'login_registration_logo' => '');

		foreach ($data as $value) {
			if ($value->region == 'b2b_registration_logo') {
				$logo_images['b2b_registration_logo'] = $value->value;
			} else if ($value->region == 'login_registration_logo') {
				$logo_images['login_registration_logo'] = $value->value;
			}
		}

		if (!empty($logo_images['b2b_registration_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['b2b_registration_logo'];
		} else if (!empty($logo_images['login_registration_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['login_registration_logo'];
		}
		
		$this->commonData['logo'] = $logo;		
		$this->commonData['title'] = 'Business Regsiter';
		$this->commonData['user'] = $user;
		
		$this->loadPlainScreen('frontend/business/register');
	}

	public function forgotPass () {
		if ($this->input->post('email')) {
			$email = trim($this->input->post('email'));
			$user = $this->Users_model->getData('users', array('email' => $email, 'type' => B2B));

			if (empty($user)) {
				$this->session->set_flashdata('msg_error', 'Email does not exist.');
			} else {
				$user = $user[0];
				$activation_code = md5($email . rand(111, 999));
				$this->Users_model->updateData('users', array('id' => $user->id), array('activation_code' => $activation_code, 'password' => ''));
                
				unset($_SESSION['msg_error']);
				$this->session->set_flashdata('msg_success', 'Password reset link has sent to your email address.');
				// mail
				$name = $user->first_name . ' ' . $user->last_name;
				$config = array (
			      	'mailtype' => 'html',
				    'charset'  => 'utf-8',
				    'priority' => '1'
				);
			    $this->email->initialize($config);
			    $this->email->from(SITE_EMAIL, SITE_NAME);
		    	$this->email->to($email);
			    $data_arr = array(
			    	'username'=> $name,
			    	'active_link'=> base_url() . 'login/passwordreset/' . $activation_code,
			    );
			    $this->email->subject(SITE_NAME . ' Register Password Rest Link');
			    $body = $this->load->view('frontend/email/forgotpass.php', $data_arr, TRUE);
			    $this->email->message($body);
			    @$this->email->send();
				// mail
			}
		}

		$region = array('b2b_forgot_pass_logo', 'login_registration_logo');
		$logos = array('blfile' => 'b2b_forgot_pass_logo', 'ufile' => 'login_registration_logo');
		$data = $this->Users_model->getData('home_page_setting', array(), 'id, region, value', array(), array('region' => $region));

		$logo = FILEPATH . 'img/backgrounds/img-12.jpg';

		$logo_images = array('b2b_forgot_pass_logo' => '', 'login_registration_logo' => '');

		foreach ($data as $value) {
			if ($value->region == 'b2b_forgot_pass_logo') {
				$logo_images['b2b_forgot_pass_logo'] = $value->value;
			} else if ($value->region == 'login_registration_logo') {
				$logo_images['login_registration_logo'] = $value->value;
			}
		}

		if (!empty($logo_images['b2b_forgot_pass_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['b2b_forgot_pass_logo'];
		} else if (!empty($logo_images['login_registration_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['login_registration_logo'];
		}
		
		$this->commonData['logo'] = $logo;
		$this->commonData['title'] = 'Business Forgot Password';
		$this->loadPlainScreen('frontend/business/forgotpass');
	}

	public function passwordreset () {
		unset($_SESSION['msg_success']);
		$data = array();
		$activation_code = $this->uri->segment(3);
		$user = $this->Users_model->getData('users', array('activation_code' => $activation_code));

		if ($this->input->post()) {
			if (empty($user)) {
				$this->session->set_flashdata('msg_error', 'Password reset link has expired.');
			} else {
				$user = $user[0];
				$password = md5($this->input->post('password'));
				$this->Users_model->updateData('users', array('id' => $user->id), array('password' => $password, 'activation_code' => ''));
				$this->setUserData($user);
				
				$this->session->set_flashdata('msg_success', 'You have successfully set new password.');
				redirect(base_url(), 'refresh');
			}
		}

		if (empty($user)) {
			show_error('Page not found!');
		}

		$this->loadPlainScreen('frontend/user/activation', $data);
	}

	public function profile () {
		$user = authentication();

		if ($user['type'] != B2B) {
			redirect(base_url());
		}

		$details = $this->Users_model->getData('users_business_details', array('user_id' => $user['id']));

		if (isset($_FILES['ufile'])) {
			$file = $_FILES['ufile'];
			$image_types = array('image/png', 'image/jpg', 'image/jpeg', 'image/svg' ,'image/gif');

			if (!in_array($file['type'], $image_types)) {
				$this->session->set_flashdata('msg_error', 'Invalid profile image uploaded.');
				redirect(base_url('business/profile'), 'refresh');
			}

			$path = 'business/logo/';
			$upload_dir = UPLOADDIR . $path;
			$thumb_path = 'thumb/';
			if ($_SERVER['HTTP_HOST'] == 'localhost') {
				$path = 'business\\logo\\';
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
			$image = 'com_' . time() . '_' . $user['id'] . '.' . end($ext_arr);
			$config['file_name'] = $image;
			$config['orig_name'] = $file['name'];
			$config['image'] = $image;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('ufile');
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
				'company_logo' => $image,
				'modified_date' => time()
			);
			if (empty($details)) {
				$fields['user_id'] = $user['id'];
				$fields['created_date'] = time();
				$this->Users_model->insertData('users_business_details', $fields);
			} else {
				if (!empty($details[0]->company_logo)) {
					@unlink($upload_dir . $details[0]->company_logo);
					@unlink($upload_dir . $thumb_path . $details[0]->company_logo);
				}

				$this->Users_model->updateData('users_business_details', array('user_id' => $user['id']), $fields);
			}
			$this->session->set_flashdata('msg_success', 'Company logo successfully updated.');
			redirect(base_url('business/profile'), 'refresh');
		}

		if ($this->input->post('company_name')) {
			$post = $this->input->post();
			$fields = array(
				'company_name' => $post['company_name'],
				// 'company_address' => $post['company_address'],
				'about_company' => $post['about_company'],
				'country' => $post['country'],
				'state' => $post['state'],
				'city' => $post['city'],
				'endorse' => $post['endorse'],
				'modified_date' => time()
			);

			if (empty($details)) {
				$fields['user_id'] = $user['id'];
				$fields['created_date'] = time();
				$this->Users_model->insertData('users_business_details', $fields);
			} else {
				$this->Users_model->updateData('users_business_details', array('user_id' => $user['id']), $fields);
			}
			$this->session->set_flashdata('msg_success', 'Company details successfully updated.');
			redirect(base_url('business/profile'), 'refresh');
		}

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['company'] = (!empty($details)) ? $details[0] : array();
		$this->commonData['title'] = 'Company Profile';
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		$this->commonData['js'][] = 'libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js';

		$this->loadScreen('frontend/business/account');
	}

	public function products () {
		$user = authentication();

		if ($user['type'] != B2B) {
			redirect(base_url());
		}

		$products = $this->Product_model->getProducts('b2b_user_product_list', '', array('user_id' => $user['id']));

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

		$this->loadScreen('frontend/business/product_list');
	}

	public function editProduct () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;

		if (empty($cid)) {
			redirect('business/products', 'refresh');
		}

		$this->addProduct($cid);
	}

	public function addProduct ($cid = '') {
		$user = authentication();

		if ($user['type'] != B2B) {
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
			redirect(base_url('business/products'));
		}

		$product = $categories = $product_images = array();
		$this->commonData['title'] = 'Product Add';
		if (!empty($cid)) {
			$product = $this->Users_model->getData('products', array('id' => $cid));
			$product = $product[0];
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
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;

		$this->commonData['js'][] = 'libs/ckeditor/ckeditor.js';
		$this->loadScreen('frontend/business/product_add');
	}

	public function ajaxUpdate () {
		$user = authentication();
		$response = array('success' => false, 'msg' => 'Unable to process');
		$post = $this->input->post();
		
		if (!isset($post['action']) || $post['action'] == '') {
			echo json_encode($response);
			exit;
		}

		$action = $post['action'];

		if ($action == 'category_add') {
			$val = trim($post['new_category']);
			if (empty($val)) {
				echo json_encode($response);
				exit;
			}
			$image = '';

			if (isset($_FILES['file'])) {
				$file = $_FILES['file'];

				$path = 'products/product_categories/';
				$upload_dir = UPLOADDIR . $path;
				$thumb_path = 'thumb/';
				if ($_SERVER['HTTP_HOST'] == 'localhost') {
					$path = 'products\\product_categories\\';
					$upload_dir = UPLOADDIR . $path;
					$thumb_path = 'thumb\\';
				}

				folderCheck($upload_dir . $thumb_path);

				$folder_path = $upload_dir . "/";
				$ext_arr = explode('.', $file['name']);

				$config['upload_path'] = $folder_path;
				$config['allowed_types'] = 'png|gif|jpg|jpeg';
				$config['max_size']	= '0';
				$config['max_width'] = '0';
				$config['max_height'] = '0';
				$config['overwrite'] = TRUE;
				$image = 'prodcate_' . time() . '_' . $user['id'] . '.' . end($ext_arr);
				$config['file_name'] = $image;
				$config['orig_name'] = $file['name'];
				$config['image'] = $image;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('file')) {
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
					//generate the thumbnail photo from the main photo
				}
			}

			$slug = preg_replace('/[^a-z0-9]/i', '-', $val);
			$fields = array(
				'name' => $val,
				'created_by' => $user['id'],
				'slug' => $slug,
				'filename' => $image,
				'created_date' => time(),
				'modified_date' => time(),
			);

			$cid = $this->Users_model->insertData('product_category', $fields);
			$response['success'] = true;
			$response['message'] = 'Category has successfully added';
			$response['cid'] = $cid;
			echo json_encode($response);
		} else if ($action == 'product_image_remove') {
			$id = str_replace('im-', '', $post['val']);
			if (empty($id)) {
				echo json_encode($response);
				exit;
			}
			$this->Users_model->deleteData('product_images', array('id' => $id));
			$response['success'] = true;
			$response['message'] = 'Product image successfully deleted';
			echo json_encode($response);
		} else if ($action == 'product_image_cover') {
			$id = str_replace('im-', '', $post['val']);
			$pid = str_replace('product-info', '', $post['pid']);
			if (empty($id) || empty($pid)) {
				echo json_encode($response);
				exit;
			}

			$this->Users_model->updateData('product_images', array('product_id' => $pid), array('cover' => 'no'));
			$this->Users_model->updateData('product_images', array('id' => $id), array('cover' => 'yes'));
			$response['success'] = true;
			$response['message'] = 'Product image successfully updated';
			echo json_encode($response);
		} else if ($action == 'voucher_update_status') {
			$pid = $post['pid'];
			$val = $post['val'];
			$this->Users_model->updateData('product_discount_voucher', array('id' => $pid), array('voucher_status' => $val));
			$response['data'] = ucwords($val);
			$response['success'] = true;
			$response['msg'] = 'Voucher status change successfully updated';
			echo json_encode($response);
		}
	}

	public function vouchers () {
		$user = authentication();

		if ($user['type'] != B2B) {
			redirect(base_url());
		}

		$vouchers = $this->Users_model->getdata('product_discount_voucher', array('user_id' => $user['id']));

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['vouchers'] = $vouchers;
		$this->commonData['title'] = 'Voucher List';
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		$this->commonData['js'][] = 'libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';

		$this->loadScreen('frontend/business/voucher_list');
	}

	public function editVoucher () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;

		if (empty($cid)) {
			redirect('business/vouchers', 'refresh');
		}

		$this->addVoucher($cid);
	}

	public function addVoucher ($cid = '') {
		$user = authentication();

		if ($user['type'] != B2B) {
			redirect(base_url());
		}

		if ($this->input->post('name')) {
			$post = $this->input->post();
			$image_name = '';
			if (isset($_FILES['ufile'])) {
				$file = $_FILES['ufile'];

				$path = 'vouchers/';
				$upload_dir = UPLOADDIR . $path;
				if ($_SERVER['HTTP_HOST'] == 'localhost') {
					$path = 'vouchers\\';
					$upload_dir = UPLOADDIR . $path;
				}

				folderCheck($upload_dir);

				$folder_path = $upload_dir . "/";
				$ext_arr = explode('.', $file['name']);

				$config['upload_path'] = $folder_path;
				$config['allowed_types'] = '*';
				$config['max_size']	= '0';
				$config['max_width'] = '0';
				$config['max_height'] = '0';
				$config['overwrite'] = TRUE;
				$image = 'voucher_' . time() . '_' . $user['id'] . '.' . end($ext_arr);
				$config['file_name'] = $image;
				$config['orig_name'] = $file['name'];
				$config['image'] = $image;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('ufile')) {
					$image_name = $image;
					if (!empty($post['ofile'])) {
						@unlink(UPLOADDIR . 'vouchers/' . $post['ofile']);
					}
				}
			}

			$fields = array(
				'name' => trim($post['name']),
				'voucher_price' => $post['voucher_price'],
				'code' => trim($post['code']),
				'description' => $post['description'],
				// 'discount_type' => $post['discount_product'],
				'total_use' => 1,//$post['total_use'],
				'start_date' => $post['start_date'],
				'expiry_date' => $post['expiry_date'],
				// 'voucher_amount' => $post['voucher_amount'],
				'status' => ($post['status'] == 'on') ? 1 : 0,
				'modified_date' => time(),
			);

			if (!empty($image_name)) {
				$fields['filename'] = $image_name;
			}
			
			$fields['percentage'] = $post['discount_price'];
			// $fields['loyal_percentage'] = $post['voucher_discount_price'];

			if ($post['discount_for'] == 'flat_rate') {
				$fields['percentage'] = 0;
				$fields['flat_rate'] = $post['discount_price'];
			}

			/*if ($post['voucher_discount_for'] == 'flat_rate') {
				$fields['loyal_percentage'] = 0;
				$fields['loyal_flat_rate'] = $post['voucher_discount_price'];
			}*/

			if (!empty($cid)) {
				$this->Users_model->updateData('product_discount_voucher', array('id' => $cid), $fields);
				$this->session->set_flashdata('msg_success', 'Discout Voucher successfully updated.');
			} else {
				$fields['user_id'] = $user['id'];
				$fields['created_date'] = time();
				$cid = $this->Users_model->insertData('product_discount_voucher', $fields);
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

			redirect(base_url('business/vouchers'), 'refresh');
		}

		$voucher = $categories = $product_items = array();
		$this->commonData['title'] = 'Discount Voucher Add';
		if (!empty($cid)) {
			$voucher = $this->Users_model->getData('product_discount_voucher', array('id' => $cid));
			$voucher = $voucher[0];
			$categories_arr = $this->Users_model->getData('product_discount_categories', array('voucher_id' => $cid), 'category_id');
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
			}
			$this->commonData['title'] = 'Discount Voucher Edit';
		}

		$product_categories = $this->Users_model->getData('product_category', array('status' => 1), 'id, name');
		$products = $this->Users_model->getData('products', array('status' => 1, 'user_id' => $user['id']), 'id, name');
		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['voucher'] = $voucher;
		$this->commonData['user_categories'] = $categories;
		$this->commonData['user_products'] = $product_items;
		$this->commonData['product_categories'] = $product_categories;
		$this->commonData['products'] = $products;
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;

		$this->commonData['js'][] = 'libs/ckeditor/ckeditor.js';
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->loadScreen('frontend/business/voucher_add');
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
			$this->Users_model->deleteData('product_discount_voucher', array('id' => $cid));
			$this->Users_model->deleteData('product_discount_categories', array('voucher_id' => $cid));
			$this->Users_model->deleteData('product_discount_items', array('voucher_id' => $cid));
			$this->session->set_flashdata('msg_success', 'Discout Voucher successfully deleted.');
			redirect(base_url('business/vouchers'), 'refresh');
		} else if ($action == 'loyalty') {
			$this->Users_model->deleteData('product_discount_loyalty', array('id' => $cid));
			$this->Users_model->deleteData('product_discount_loyalty_categories', array('loyalty_id' => $cid));
			$this->Users_model->deleteData('product_discount_loyalty_items', array('loyalty_id' => $cid));
			$this->session->set_flashdata('msg_success', 'Loyalty discout successfully deleted.');
			redirect(base_url('business/loyalty'), 'refresh');
		} else if ($action == 'endorse') {
			$this->Users_model->deleteData('endorse_business', array('id' => $cid));
			$this->session->set_flashdata('msg_success', 'Endorse user successfully deleted.');
			redirect(base_url('business/endorselist'), 'refresh');
		}
	}

	public function loyalty () {
		$user = authentication();

		if ($user['type'] != B2B) {
			redirect(base_url());
		}

		$loyalty = $this->Users_model->getdata('product_discount_loyalty', array('user_id' => $user['id']));

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['loyalty'] = $loyalty;
		$this->commonData['title'] = 'Loyalty List';
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		$this->commonData['js'][] = 'libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';

		$this->loadScreen('frontend/business/loyalty_list');
	}

	public function editLoyalty () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;

		if (empty($cid)) {
			redirect('business/loyalty', 'refresh');
		}

		$this->addLoyalty($cid);
	}

	public function addLoyalty ($cid = '') {
		$user = authentication();

		if ($user['type'] != B2B) {
			redirect(base_url());
		}

		if ($this->input->post('name')) {
			$post = $this->input->post();
			$fields = array(
				'name' => trim($post['name']),
				'description' => $post['description'],
				'discount_type' => $post['discount_product'],
				'total_use' => 0,//$post['total_use'],
				'loyalty_amount' => $post['loyalty_amount'],
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
				$this->Users_model->updateData('product_discount_loyalty', array('id' => $cid), $fields);
				$this->session->set_flashdata('msg_success', 'Loyalty discout successfully updated.');
			} else {
				$fields['user_id'] = $user['id'];
				$fields['created_date'] = time();
				$cid = $this->Users_model->insertData('product_discount_loyalty', $fields);
				$this->session->set_flashdata('msg_success', 'Loyalty discount successfully added.');
			}

			$this->Users_model->deleteData('product_discount_loyalty_categories', array('loyalty_id' => $cid));
			$this->Users_model->deleteData('product_discount_loyalty_items', array('loyalty_id' => $cid));

			if ($post['discount_product'] == 'product' && !empty($post['product_items'])) {
				$fields = array();
				foreach ($post['product_items'] as $value) {
					$fields[] = array(
						'loyalty_id' => $cid,
						'product_id' => $value,
						'created_date' => time()
					);
				}
				$this->Users_model->insertBatch('product_discount_loyalty_items', $fields);
			} else if ($post['discount_product'] == 'category' && !empty($post['by_category'])) {
				$fields = array();
				foreach ($post['by_category'] as $value) {
					$fields[] = array(
						'loyalty_id' => $cid,
						'category_id' => $value,
						'created_date' => time()
					);
				}
				$this->Users_model->insertBatch('product_discount_loyalty_categories', $fields);
			}

			redirect(base_url('business/loyalty'), 'refresh');
		}

		$voucher = $categories = $product_items = array();
		$this->commonData['title'] = 'Loyalty Discount Add';
		if (!empty($cid)) {
			$voucher = $this->Users_model->getData('product_discount_loyalty', array('id' => $cid));
			$voucher = $voucher[0];
			$categories_arr = $this->Users_model->getData('product_discount_loyalty_categories', array('loyalty_id' => $cid), 'category_id');
			$product_items_arr = $this->Users_model->getData('product_discount_loyalty_items', array('loyalty_id' => $cid), 'product_id');
			if (!empty($categories_arr)) {
				foreach ($categories_arr as $value) {
					$categories[] = $value->category_id;
				}
			}
			if (!empty($product_items_arr)) {
				foreach ($product_items_arr as $value) {
					$product_items[] = $value->product_id;
				}
			}
			$this->commonData['title'] = 'Loyalty Discount Edit';
		}

		$product_categories = $this->Users_model->getData('product_category', array('status' => 1), 'id, name');
		$products = $this->Users_model->getData('products', array('status' => 1, 'user_id' => $user['id']), 'id, name');
		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['voucher'] = $voucher;
		$this->commonData['user_categories'] = $categories;
		$this->commonData['user_products'] = $product_items;
		$this->commonData['product_categories'] = $product_categories;
		$this->commonData['products'] = $products;
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;

		$this->commonData['js'][] = 'libs/ckeditor/ckeditor.js';
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->loadScreen('frontend/business/loyalty_add');
	}

	public function endorseAccept () {
		$cid = (isset($_GET['cid'])) ? $_GET['cid'] : '';
		
		if (empty($cid)) {
			$this->session->set_flashdata('msg_error', 'Unable process');
			redirect(base_url('business/endorselist'), 'refresh');
		}

		$this->Users_model->updateData('endorse_business', array('id' => $cid), array('status' => 1));

		$this->session->set_flashdata('msg_success', 'User successfully endorse.');
		redirect(base_url('business/endorselist'), 'refresh');
	}

	public function endorseList () {
		$user = authentication();

		if ($user['type'] != B2B) {
			redirect(base_url());
		}

		$endorse = $this->Users_model->getEndorse('b2b_user', $user['id']);
		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['title'] = 'Endorse List';
		$this->commonData['user'] = $user;
		$this->commonData['endorse'] = $endorse;
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';
		$this->loadScreen('frontend/business/endorse_list');
	}

	public function brands () {
		$user = authentication();

		if ($user['type'] != SELLER) {
			redirect(base_url());
		}

		$this->load->model('Business_model');

		$content = $this->Business_model->getBusiness();

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');
		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}
		$this->commonData['title'] = 'Brands';
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['content'] = $content;
		$this->commonData['css'][] = 'libs/animate.css/animate.min.css';
		$this->loadScreen('frontend/business/brands');
	}

	public function types ($type = '') {
		$user = authentication();

		if ($user['type'] != SELLER) {
			redirect(base_url());
		}

		if (!empty($type)) {
			$this->load->model('Business_model');
			$content = $this->Business_model->getBusinessBySlug($type);
		} else {
			$content = $this->Users_model->getData('product_category', array('status' => 1), 'id, name, slug, filename');
		}

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');
		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['type'] = $type;
		$this->commonData['content'] = $content;
		$this->commonData['title'] = 'Product Types';
		$this->commonData['css'][] = 'libs/animate.css/animate.min.css';
		$this->loadScreen('frontend/business/products_category_list');
	}

	public function voucherorders () {
		$user = authentication();

		if ($user['type'] != B2B) {
			redirect(base_url());
		}

		$this->load->model('Business_model');
		$data = $this->Business_model->getVoucherOrders($user['id']);

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['content'] = $data;
		$this->commonData['title'] = 'Discount Voucher Order List';
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';

		$this->loadScreen('frontend/business/voucherorders');
	}

}