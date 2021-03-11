<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Dashboard
 * 
 */
class Setting extends AdminController{

	public function __construct(){
		parent::__construct();
		// $this->load->model('setting_model');
		$this->load->model('Users_model');

		if ( $this->userLogged() == false ){
			// redirect them to the login page
			redirect('admin/auth/login', 'refresh');
			exit ;
		}
	}

	/**
	 * Redirect if needed, otherwise display the Setting
	 */
	public function index () {
		$this->commonData['activeMenues']['menuParent'] = 'setting';
		$this->commonData['activeMenues']['menuChild'] = 'setting';
		
		$this->commonData['title'] = "Setting";

		$settings_tem = (object)array('site_name' => '', 'site_email' => '', 'site_logo' => '', 'site_favicon' => '');
		$settings = $this->Users_model->getData('setting');
		$this->commonData['setting'] = (!empty($settings)) ? $settings[0] : $settings_tem;

		$this->loadScreen('setting') ;
	}

	/**
	 * Function update setting
	 */
	public function update () {
		$site_name = trim($this->input->post('site_name'));
		$site_email = trim($this->input->post('site_email'));
		$site_logo_old = trim($this->input->post('site_logo_old'));
		$facebook = $this->input->post('facebook');
		$instagram = $this->input->post('instagram');
		$site_logo = $site_favicon = '';

		if ($_FILES['site_logo']) {
			$file = $_FILES['site_logo'];
			if ($file['error'] == 0) {
				$image_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');

				if (!in_array($file['type'], $image_types)) {
					$this->session->set_flashdata('msg_error', 'Invalid image.');
					redirect(base_url('admin/setting', 'refresh'));
				}

				$path = 'default/logo/';
				$upload_dir = UPLOADDIR . $path;
				// $thumb_path = 'thumb/';
				if ($_SERVER['HTTP_HOST'] == 'localhost') {
					$path = 'default\\logo\\';
					$upload_dir = UPLOADDIR . $path;
					// $thumb_path = 'thumb\\';
				}

				folderCheck($upload_dir);// . $thumb_path);

				$folder_path = $upload_dir . "/";

				$ext_arr = explode('.', $file['name']);

				$config['upload_path'] = $folder_path;
				$config['allowed_types'] = '*';
				$config['max_size']	= '0';
				$config['max_width'] = '0';
				$config['max_height'] = '0';
				$config['overwrite'] = TRUE;
				$site_logo = $image = 'logo_' . time() . '.' . end($ext_arr);
				$config['file_name'] = $image;
				$config['orig_name'] = $file['name'];
				$config['image'] = $image;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload('site_logo');

				if (!empty($site_logo_old)) {
					@unlink($folder_path . $site_logo_old);
				}
			}
		}

		$fields = array(
			'site_name' => $site_name,
			'site_email' => $site_email,
			'site_favicon' => $site_favicon,
			'modified_date' => time()
		);

		if (!empty($site_logo)) {
			$fields['site_logo'] = $site_logo;
		}
		//$social_fields
		$this->Users_model->updateData('setting', array(), $fields);
		$this->session->set_flashdata('msg_success', 'Setting updated successfully.');
	
		redirect('admin/setting', 'refresh');
	}

	public function homepage () {
		if ($this->input->post()) {
			
			// pre($_FILES, 1);
			$image_arr = array();
			if (!empty($_FILES)) {
				$path = 'setting/home_page_setting/';
				$upload_dir = UPLOADDIR . $path;
				if ($_SERVER['HTTP_HOST'] == 'localhost') {
					$path = 'setting\\home_page_setting\\';
					$upload_dir = UPLOADDIR . $path;
				}
				folderCheck($upload_dir);
				$folder_path = $upload_dir . "/";

				foreach ($_FILES as $k => $value) {
					$file = $_FILES[$k];
					if (empty($file['name'])) {
						continue;
					}
					$ext_arr = explode('.', $file['name']);

					$config['upload_path'] = $folder_path;
					$config['allowed_types'] = 'png|jpeg|jpg|gif';
					$config['max_size']	= '0';
					$config['max_width'] = '0';
					$config['max_height'] = '0';
					$config['overwrite'] = TRUE;
					$image = 'hps_' . time() . '_' . rand(111, 9999) . '.' . end($ext_arr);
					$config['file_name'] = $image;
					$config['orig_name'] = $file['name'];
					$config['image'] = $image;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload($k)) {
						$image_arr[$k] = $image;
					}
				}
			}

			$post = $this->input->post();
			$fields = array();

			foreach ($post as $k => $value) {
				// $fields[] = array(
				// 	'region' => $k,
				// 	'value' => $value,
				// 	'created_date' => time(),
				// 	'modified_date' => time(),
				// );
				$fields = array(
					'value' => $value,
					'modified_date' => time()
				);
				
				$this->Users_model->updateData('home_page_setting', array('region' => $k), $fields);
			}

			if (!empty($image_arr)) {
				foreach ($image_arr as $k => $value) {
					$fields = array(
						'value' => $value,
						'modified_date' => time()
					);
			
					$this->Users_model->updateData('home_page_setting', array('region' => $k), $fields);
				}
			}

			/* update meta */
			$fields = array(
				'meta_key' => $post['meta_key'],
				'meta_description' => $post['meta_description'],
				'modified_date' => time()
			);
			$meta_data = $this->Users_model->getData('seo_data', array('page_slug' => 'home_page'));
			if (empty($meta_data)) {
				$fields['created_date'] = time();
				$fields['page_slug'] = 'home_page';
				$this->Users_model->insertData('seo_data', $fields);
			} else {
				$this->Users_model->updateData('seo_data', array('page_slug' => 'home_page'), $fields);
			}
			/* update meta */

			// $this->Users_model->insertBatch('home_page_setting', $fields);
			$this->session->set_flashdata('msg_success', 'Home page setting updated successfully.');
			redirect(base_url('admin/setting/homepage'), 'refresh');
		}

		$this->commonData['activeMenues']['menuParent'] = 'cms';
		$this->commonData['activeMenues']['menuChild'] = 'home-page-setting';
		
		$this->commonData['title'] = "Home Page Setting";
		$setting_arr = $this->Users_model->getData('home_page_setting');
		$settings = array('first_heading' => '', 'second_heading' => '', 'summary' => '', 'first_button_title' => '', 'first_button_link' => '', 'second_button_title' => '', 'second_button_link' => '', 'store_section_content' => '', 'app_section_content' => '', 'about_application_section' => '', 'customer_review_section' => '', 'footer_copy_right' => '', 'about_section_image' => '', 'register_form_heading_content' => '', 'about_section_sub_heading' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$meta_data = $this->Users_model->getData('seo_data', array('page_slug' => 'home_page'));
		$this->commonData['meta_description'] = $this->commonData['meta_key'] = '';
		if (!empty($meta_data)) {
			$this->commonData['meta_description'] = $meta_data[0]->meta_description;
			$this->commonData['meta_key'] = $meta_data[0]->meta_key;
		}

		$this->commonData['setting'] = $settings;

		$this->loadScreen('home_page_setting') ;
	}

	public function logoManage () {
		$region = array('seller_login_logo', 'seller_registration_logo', 'seller_forgot_pass_logo', 'b2b_login_logo', 'b2b_registration_logo', 'b2b_forgot_pass_logo', 'login_registration_logo');
		$logos = array('slfile' => 'seller_login_logo', 'srfile' => 'seller_registration_logo', 'blfile' => 'b2b_login_logo', 'brfile' => 'b2b_registration_logo', 'ufile' => 'login_registration_logo', 'sffile' => 'seller_forgot_pass_logo', 'bffile' => 'b2b_forgot_pass_logo');
		$data = $this->Users_model->getData('home_page_setting', array(), '', array(), array('region' => $region));

		if ($_FILES) {
			$update = false;
			$path = 'setting/page_logo/';
			$upload_dir = UPLOADDIR . $path;
			if ($_SERVER['HTTP_HOST'] == 'localhost') {
				$path = 'setting\\page_logo\\';
				$upload_dir = UPLOADDIR . $path;
			}

			folderCheck($upload_dir);

			$folder_path = $upload_dir . "/";
			$ind = 1;

			foreach ($logos as $k => $value) {
				$fields = array();
				if (!empty($_FILES[$k]['name'])) {
					$file = $_FILES[$k];
					$ext_arr = explode('.', $file['name']);

					$config['upload_path'] = $folder_path;
					$config['allowed_types'] = 'png|gif|jpg|jpeg';
					$config['max_size']	= '0';
					$config['max_width'] = '0';
					$config['max_height'] = '0';
					$config['overwrite'] = TRUE;
					$image = 'lrlogo_' . time() . '_' . rand(111, 999999) . $ind++ . '.' . end($ext_arr);
					$config['file_name'] = $image;
					$config['orig_name'] = $file['name'];
					$config['image'] = $image;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload($k)) {
						$fields = array(
							'value' => $image,
							'modified_date' => time()
						);

						$this->Users_model->updateData('home_page_setting', array('region' => $value), $fields);
						$update = true;
					}
				}
			}

			if ($update) {
				$this->session->set_flashdata('msg_success', 'Home page logo updated successfully.');
				redirect(base_url('admin/setting/logomanage'), 'refresh');
			}
		}

		$logo_images = array();

		foreach ($data as $value) {
			if (in_array($value->region, $logos)) {
				$logo_images[array_search($value->region, $logos)] = (!empty($value->value)) ? UPLOADPATH . 'setting/page_logo/' . $value->value : FILEPATH . 'img/default/no-image.png';
			}
		}

		$this->commonData['activeMenues']['menuParent'] = 'cms' ;
		$this->commonData['activeMenues']['menuChild'] = 'site-logo-manage';
		
		$this->commonData['title'] = "Logo Manage";
		$this->commonData['logos'] = $logo_images;
		$this->loadScreen('logo_manage');
	}

	public function payment_Credentials () {
		$this->commonData['activeMenues']['menuParent'] = 'setting';
		$this->commonData['activeMenues']['menuChild'] = 'payment_credentials';
		
		$user_id = $this->session->userdata('user_id');
		$settings = $this->Users_model->getData('stripe_details', array('user_id' => $user_id), 'secret_key, publish_key');

		if ($this->input->post('secret_key')) {
			$fields = array(
				'secret_key' => trim($this->input->post('secret_key')),
				'publish_key' => trim($this->input->post('publish_key')),
				'modified_date' => time()
			);

			if (!empty($settings)) {
				$this->Users_model->updateData('stripe_details', array('user_id' => $user_id), $fields);
				$this->session->set_flashdata('msg_success', 'Stripe credentials successfully updated.');
			} else  {
				$fields['user_id'] = $user_id;
				$fields['created_date'] = time();
				$this->Users_model->insertData('stripe_details', $fields);
				$this->session->set_flashdata('msg_success', 'Stripe credentials successfully added.');
			}

			redirect(base_url('admin/setting/payment_credentials'), 'refresh');
		}

		$this->commonData['title'] = "Payment Credentials";
		$settings_tem = (object)array('secret_key' => '', 'publish_key' => '');
		$this->commonData['stripe'] = (!empty($settings)) ? $settings[0] : $settings_tem;

		$this->loadScreen('payment_credentials') ;
	}

	public function homePageTrending () {
		if ($this->input->post('page')) {
			$brands = $this->input->post('brands');
			$fields_arr = array();
			if (!empty($brands)) {
				foreach ($brands as $value) {
					$fields_arr[] = array(
						'brand_id' => $value,
						'created_date' => time()
					);
				}
			}

			$this->Users_model->deleteData('trending_brands_setting', array('brand_id !=' => ''));
			if (!empty($fields_arr)) {
				$this->Users_model->insertBatch('trending_brands_setting', $fields_arr);
			}
			$this->session->set_flashdata('msg_success', 'Trending brands successfully updated.');
			redirect(base_url('admin/setting/homepagetrending'), 'refresh');
		}

		$this->commonData['activeMenues']['menuParent'] = 'cms';
		$this->commonData['activeMenues']['menuChild'] = 'home-page-setting';
		
		$data = $this->Users_model->getTrendingBrands('admin_list');
		$select_data_arr = $this->Users_model->getData('trending_brands_setting', array(), 'brand_id');
		$select_data = array();

		if (!empty($select_data_arr)) {
			foreach ($select_data_arr as $value) {
				$select_data[] = $value->brand_id;
			}
		}

		$this->commonData['title'] = "Home Page Trending Brands";
		$this->commonData['content'] = $data;
		$this->commonData['select_brands'] = $select_data;

		$this->loadScreen('home_page_trending_brands');
	}

	public function homepageficons ($cid = '') {
		$image = '';
		$upload = false;
		$icon = array();

		if (!empty($cid)) {
			$icon = $this->Users_model->getData('home_page_ficons', array('id' => $cid));
		}

		if ($_FILES) {
			$file = $_FILES['ufile'];
			if (!empty($file['name'])) {
				$path = 'setting/home_page_ficons/';
				$upload_dir = UPLOADDIR . $path;
				if ($_SERVER['HTTP_HOST'] == 'localhost') {
					$path = 'setting\\home_page_ficons\\';
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
				$image = 'ficon_' . time() . rand(111, 999) . '.' . end($ext_arr);
				$config['file_name'] = $image;
				$config['orig_name'] = $file['name'];
				$config['image'] = $image;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('ufile')) {
					$upload = true;
					if (!empty($cid)) {
						@unlink(UPLOADDIR . 'setting/home_page_ficons/' . $icon[0]->filename);
					}
				}
			}
		}

		if ($this->input->post('title')) {
			$title = trim($this->input->post('title'));
			if ($upload || !empty($cid)) {
				$fields = array(
					'title' => $title,
					'modified_date' => time()
				);
				if (!empty($image)) {
					$fields['filename'] = $image;
				}

				if (!empty($cid)) {
					$this->Users_model->updateData('home_page_ficons', array('id' => $cid), $fields);
					$this->session->set_flashdata('msg_success', 'Icon successfully updated.');
				} else {
					$fields['created_date'] = time();
					$this->Users_model->insertData('home_page_ficons', $fields);
					$this->session->set_flashdata('msg_success', 'Icon successfully added.');
				}
			} else {
				$this->session->set_flashdata('msg_error', 'Icon unable to add.');
			}
			redirect(base_url('admin/setting/homepageficons'), 'refresh');
		}

		$this->commonData['activeMenues']['menuParent'] = 'cms';
		$this->commonData['activeMenues']['menuChild'] = 'home-page-setting';
		
		$data = $this->Users_model->getData('home_page_ficons');

		$this->commonData['title'] = "Home Page Floating Icons";
		$this->commonData['content'] = $data;
		$this->commonData['icon'] = (!empty($icon)) ? $icon[0] : array();

		$this->loadScreen('home_page_floting_icons');
	}

	public function customerTestimonials ($cid = '') {
		$image = '';
		$testimonial = array();

		if (!empty($cid)) {
			$testimonial = $this->Users_model->getData('home_page_testimonials', array('id' => $cid));
		}

		if ($_FILES) {
			$file = $_FILES['ufile'];
			if (!empty($file['name'])) {
				$path = 'setting/home_page_testimonials/';
				$upload_dir = UPLOADDIR . $path;
				if ($_SERVER['HTTP_HOST'] == 'localhost') {
					$path = 'setting\\home_page_testimonials\\';
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
				$image = 'hpt_' . time() . rand(111, 999) . '.' . end($ext_arr);
				$config['file_name'] = $image;
				$config['orig_name'] = $file['name'];
				$config['image'] = $image;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('ufile')) {
					if (!empty($cid)) {
						@unlink(UPLOADDIR . 'setting/home_page_testimonials/' . $testimonial[0]->filename);
					}
				}
			}
		}

		if ($this->input->post('name')) {
			$post = $this->input->post();
			$fields = array(
				'name' => trim($post['name']),
				'tag' => trim($post['tag']),
				'description' => trim($post['description']),
				'rating' => $post['rating'],
				'modified_date' => time()
			);

			if (!empty($image)) {
				$fields['filename'] = $image;
			}

			if (!empty($cid)) {
				$this->Users_model->updateData('home_page_testimonials', array('id' => $cid), $fields);
				$this->session->set_flashdata('msg_success', 'Testimonial successfully updated.');
			} else {
				$fields['created_date'] = time();
				$this->Users_model->insertData('home_page_testimonials', $fields);
				$this->session->set_flashdata('msg_success', 'Testimonial successfully added.');
			}
			redirect(base_url('admin/setting/customertestimonials'), 'refresh');
		}

		$this->commonData['activeMenues']['menuParent'] = 'cms';
		$this->commonData['activeMenues']['menuChild'] = 'home-page-setting';
		
		$content = array();
		
		if (empty($cid)) {
			$content = $this->Users_model->getData('home_page_testimonials');
		}

		$this->commonData['title'] = "Home Page Testimonials";
		$this->commonData['content'] = $content;
		$this->commonData['testimonial'] = (!empty($testimonial)) ? $testimonial[0] : array();

		$this->loadScreen('customertestimonials');
	}

	public function delete () {
		$action = ($this->input->get('act')) ? $this->input->get('act') : '' ;
		$id = ($this->input->get('cid')) ? $this->input->get('cid') : 0;

		if (empty($action) || $id == 0) {
			redirect('admin/dashboard', 'refresh');
		}

		switch ($action) {
			case 'ficon':
				$data = $this->Users_model->getData('home_page_ficons', array('id' => $id), 'filename');
				$this->Users_model->deleteData('home_page_ficons', array('id' => $id));
				if (!empty($data)) {
					if (!empty($data[0]->filename)) {
						@unlink(UPLOADDIR . 'setting/home_page_ficons/' . $data[0]->filename);
					}
				}
				$this->session->set_flashData('msg_success', 'Icon successfully deleted.');
				redirect('admin/setting/homepageficons', 'refresh');
				break;
			case 'testimonial':
				$data = $this->Users_model->getData('home_page_testimonials', array('id' => $id), 'filename');
				$this->Users_model->deleteData('home_page_testimonials', array('id' => $id));
				if (!empty($data)) {
					if (!empty($data[0]->filename)) {
						@unlink(UPLOADDIR . 'setting/home_page_testimonials/' . $data[0]->filename);
					}
				}
				$this->session->set_flashData('msg_success', 'Testimonial successfully deleted.');
				redirect('admin/setting/customertestimonials', 'refresh');
				break;
		}

		redirect('admin/dashboard', 'refresh');
	}

	public function changeStat () {
		$action = ($this->input->get('act')) ? $this->input->get('act') : '' ;

		if (empty($action)) {
			redirect('admin/dashboard', 'refresh');
		}

		$stat = ($this->input->get('stat') &&  $this->input->get('stat') == '1') ? 0 : 1;
		$fields = array(
			'status' => $stat
		);
		$id = 0;
		$table = '';
		$return = '';

		switch ($action) {
			case 'ficon':
				$id = ($this->input->get('cid')) ? $this->input->get('cid') : 0;
				$table = 'home_page_ficons';
				$return = 'homepageficons';
				break;
			case 'testimonial':
				$id = ($this->input->get('cid')) ? $this->input->get('cid') : 0;
				$table = 'home_page_testimonials';
				$return = 'customertestimonials';
				break;
		}

		if ($id == 0) {
			redirect('admin/dashboard', 'refresh');
		}

		$this->Users_model->updateData($table, array('id' => $id), $fields);
		redirect('admin/setting/' . $return, 'refresh');
	}

	public function social_links(){
		$post = $this->input->post();
		$sociallinks = $this->Users_model->getData('sociallinks'); //insertData updateData
		//pre($sociallinks,1);
		
		if(isset($post['submit'])){
			//pre($post,1);
			if(!empty($sociallinks)){
				foreach($post as $key => $value){
					$this->Users_model->updateData ('sociallinks',array('type' => $key),array('value' => $value)); 
				}
				$this->session->set_flashData('msg_success', 'Link update sucessfully');
				redirect('admin/setting/social_links', 'refresh');
			}else{
				foreach($post as $key => $value){
					$this->Users_model->insertData ('sociallinks',array('type' => $key,'value' => $value)); 
				}
				$this->session->set_flashData('msg_success', 'Link update sucessfully');
				redirect('admin/setting/social_links', 'refresh');
			}

		}
		$this->commonData['activeMenues']['menuParent'] = 'setting';
		$this->commonData['activeMenues']['menuChild'] = 'social-link';
		$this->commonData['title'] = "Social Links";
		$this->commonData['sociallinks'] = (!empty($sociallinks)) ? $sociallinks : array();
		$this->loadScreen('social_links');
	}

}
