<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Login extends BaseController {

	public function __construct(){
		parent::__construct();
		// $this->load->library('facebook');
		$this->load->model('Login_model');
		$this->load->model('users_model');
		
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index () {
		//exit;
		$user = authentication(false);
		if($this->input->post() && empty($user)) {
			
			if ($this->Login_model->from_validation_resgistration()) {
				//pre($this->input->post(),1);
				if (!checkEmail(trim($this->input->post('email')))) {
					$post_data = array();
					$activation_code = md5(date("YmdHis") . rand(100,999));

					$post_data['first_name'] 		= trim($this->input->post('first_name'));
					$post_data['last_name'] 		= '  ';
					$post_data['uniqueid']			= uniqid();
					$post_data['email'] 			= trim($this->input->post('email'));
					$post_data['password'] 			= $this->input->post('password');
					$post_data['phone'] 			= trim($this->input->post('phone'));
					$post_data['type'] 				= CUSTOMER;
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
					} else {
						$this->session->set_flashdata('msg_error', 'You are not registred please try again');
					}
				} else {
						$this->session->set_flashdata('msg_email_error', 'Email address already exist. Please try with another email address.');
				}
			}
		}

		

		

		$this->commonData['user'] = $user;
		
		$this->commonData['meta_data'] = (!empty($meta_data)) ? $meta_data[0] : array();
		
		$this->loadFScreen('frontend/user/home');
	}

   	public function registration() {
		// die('The site is under processing.');
		$data = array();
		$user = authentication(false);
		if (empty($user)) {
			if(empty($this->input->post())) {
				$this->index();
			} else {
				if ($this->Login_model->from_validation_resgistration()) {
				pre($this->input->post(), 1);
					$post_data = array();
					$split_date = date("M d, Y", strtotime($this->input->post('yy').'-'.$this->input->post('mm').'-'.$this->input->post('dd')));
					$dob = ($this->input->post('date_of_birth'))? $this->input->post('date_of_birth'):$split_date;
					$activation_code = md5(date("YmdHis").rand(100,999));
					$username = $this->input->post('fname') . '-' . $this->input->post('lname');

					$post_data['first_name'] 		= $this->input->post('full_name');
					$post_data['email'] 			= $this->input->post('email');
					$post_data['password'] 			= $this->input->post('password');
					$post_data['phone'] 			= $this->input->post('mobile');
					$post_data['provinces'] 		= $this->input->post('country');
					$post_data['city'] 				= $this->input->post('city');
				    $post_data['state'] 			= $this->input->post('state');
					$post_data['type'] 				= 'customer';
					$post_data['activation_code']	= $activation_code;
					$post_data['active']			= 1;
					$post_data['created_date']		= time();
					$post_data['modified_date']		= time();
					$post_data['ip_address']		= $_SERVER['REMOTE_ADDR'];
 
					$in_id = $this->Login_model->insert('users', $post_data);
					// mail for confurmation
					// $name = $this->input->post('fname') . ' ' . $this->input->post('lname');
					// $name = ucwords($name);
					// $config = array (
				    //   	'mailtype' => 'html',
					//     'charset'  => 'utf-8',
					//     'priority' => '1'
					// );
				    // $this->email->initialize($config);
				    // $this->email->from(SITE_EMAIL, SITE_NAME);
			    	// // $this->email->to('rupam.brainium@gmail.com');
			    	// $this->email->to($this->input->post('email'));
				    // $data_arr = array(
				    // 	'username'=> $name,
				    // 	'active_link'=> base_url() . 'newuser/activation/' . $activation_code,
				    // );
				    // $this->email->subject(SITE_NAME . ' Register Activation Link');
				    // $body = $this->load->view('frontend/email/registration.php', $data_arr, TRUE);
				    // $this->email->message($body);
				    // $this->email->send();
				    // $this->session->set_flashdata('success_msg', 'A verification link has been sent to your email account..');
					// // mail
					if($in_id != '')
					{
						$this->session->set_flashdata('success_msg', 'You are sucessfully registered..');
						$user = $this->users_model->getData('users', $post_data);
						$user = $user[0];
						$this->setUserData($user);
						redirect("user",'refresh');
					}
					else{
						$this->session->set_flashdata('error_msg', 'You are not registred please try again');
						// redirect("login/registration");
						$this->index();
					}
					
					
				}
				else {
					$this->index();
					// redirect(base_url());
					// $this->loadPlainScreen('frontend/user/register', $data);
				}
			}
		} else{
			redirect('user', 'refresh');
		}
	}

	function activation () {
		$activation_code = $this->uri->segment(3);
		$user = $this->Login_model->getUser(array('activation_code' => $activation_code));

		if (empty($user)) {
			show_error('Page not found!');
		} else {
			// $password = md5($this->input->post('password'));
			if ($user[0]->type == B2B) {
				$this->Login_model->update('users', array('activation_code' => ''), array('id' => $user[0]->id));
				$this->session->set_flashdata('msg_success', 'Your account email verification has completed. You will login your account after site admin approved.');
				redirect(base_url('business'), 'refresh');
			} else {
				$this->Login_model->update('users', array('active' => 1, 'activation_code' => ''), array('id' => $user[0]->id));
				$this->setUserData($user[0]);
				$this->session->set_flashdata('msg_success', 'Your account has successfully activated.');
				redirect(base_url(), 'refresh');
			}
		}
	}

	public function forgotPass () {
		$user = authentication(false);

		if (!empty($user)) {
			redirect(base_url());
		}
		if ($this->input->post('email')) {
			$email = trim($this->input->post('email'));
			$user = $this->users_model->getData('users', array('email' => $email, 'type' => SELLER));

			if (empty($user)) {
				$this->session->set_flashdata('msg_error', 'Email does not exist.');
			} else {
				$user = $user[0];
				$activation_code = md5($email . rand(111, 999));
				$this->users_model->updateData('users', array('id' => $user->id), array('activation_code' => $activation_code, 'password' => ''));
                
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

		$region = array('seller_forgot_pass_logo', 'login_registration_logo');
		$logos = array('blfile' => 'seller_forgot_pass_logo', 'ufile' => 'login_registration_logo');
		$data = $this->users_model->getData('home_page_setting', array(), 'id, region, value', array(), array('region' => $region));

		$logo = FILEPATH . 'img/backgrounds/img-12.jpg';

		$logo_images = array('seller_forgot_pass_logo' => '', 'login_registration_logo' => '');

		foreach ($data as $value) {
			if ($value->region == 'seller_forgot_pass_logo') {
				$logo_images['seller_forgot_pass_logo'] = $value->value;
			} else if ($value->region == 'login_registration_logo') {
				$logo_images['login_registration_logo'] = $value->value;
			}
		}

		if (!empty($logo_images['seller_forgot_pass_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['seller_forgot_pass_logo'];
		} else if (!empty($logo_images['login_registration_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['login_registration_logo'];
		}
		
		$this->commonData['logo'] = $logo;
		$this->commonData['title'] = 'Forgot Password';
		$this->loadPlainScreen('frontend/user/forgotpass');
	}

	public function passwordreset () {
		$user = authentication(false);

		if (!empty($user)) {
			redirect(base_url());
		}
		unset($_SESSION['msg_success']);
		$data = array();
		$activation_code = $this->uri->segment(3);
		$user = $this->users_model->getData('users', array('activation_code' => $activation_code));

		if ($this->input->post()) {
			if (empty($user)) {
				$this->session->set_flashdata('msg_error', 'Password reset link has expired.');
			} else {
				$user = $user[0];
				$password = md5($this->input->post('password'));
				$this->users_model->updateData('users', array('id' => $user->id), array('password' => $password, 'activation_code' => ''));
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

	public function signin () {
		$user = authentication(false);

		if (!empty($user)) {
			redirect(base_url());
		}

		if ($this->input->post()) {
			if ($this->Login_model->from_validation_login()) {
				$post_data = array();

				$post_data['email'] = $this->input->post('email');
				 $post_data['password'] = $this->input->post('password');
				//echo '<br>';
				//$post_data['type !='] = B2B;

				$user = $this->users_model->getData('users', $post_data);

				if (!empty($user)) {
					$user = $user[0];

					if($user->active == 0 && !empty($user)) {
						$this->session->set_flashdata('msg_error','Please active your account and try again.');
					} else if($user->active == 1 && !empty($user)) {
						$fields = array(
							'last_activity' => time()
						);
						$this->users_model->updateData('users', array('id' => $user->id), $fields);
						$this->setUserData($user);
						redirect(base_url('user/profile'));
					}
				} else {
					$this->session->set_flashdata('msg_error','Email address does not exist.');
				}
			}
		}

		$region = array('seller_login_logo', 'login_registration_logo');
		$logos = array('blfile' => 'seller_login_logo', 'ufile' => 'login_registration_logo');
		//$data = $this->users_model->getData('home_page_setting', array(), 'id, region, value', array(), array('region' => $region));

		//$logo = FILEPATH . 'img/backgrounds/img-12.jpg';

		//$logo_images = array('seller_login_logo' => '', 'login_registration_logo' => '');

		/*foreach ($data as $value) {
			if ($value->region == 'seller_login_logo') {
				$logo_images['seller_login_logo'] = $value->value;
			} else if ($value->region == 'login_registration_logo') {
				$logo_images['login_registration_logo'] = $value->value;
			}
		}

		if (!empty($logo_images['seller_login_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['seller_login_logo'];
		} else if (!empty($logo_images['login_registration_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['login_registration_logo'];
		}
		
		$this->commonData['logo'] = $logo;
		*/
		$this->commonData['title'] = 'Login';

		$this->loadFScreen('frontend/user/login');
	}

	public function register ()	{
		$user = authentication(false);
		if($this->input->post() && empty($user)) {
			print_r($_POST);
			//exit;
			if ($this->Login_model->from_validation_resgistration()) {
				if (!checkEmail(trim($this->input->post('email')))) {
					$post_data = array();
					$activation_code = md5(date("YmdHis") . rand(100,999));
					$post_data['uniqueid'] 			= uniqid();
					$post_data['first_name'] 		= trim($this->input->post('first_name'));
					$post_data['last_name'] 		= trim($this->input->post('last_name'));
					$post_data['email'] 			= trim($this->input->post('email'));
					$post_data['password'] 			= $this->input->post('password');
					//echo '<br>'.md5(123456);
					//exit;e10adc3949ba59abbe56e057f20f883e
					//$post_data['phone'] 			= trim($this->input->post('phone'));
					$post_data['type'] 				= trim($this->input->post('type'));;
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
						redirect(base_url('login/signin'));
					} else {
						$this->session->set_flashdata('msg_error', 'You are not registred please try again');
					}
				} else {
						$this->session->set_flashdata('msg_error', 'Email address already exist. Please try with another email address.');
				}
			}else{
				echo 'error validation';
				exit;
			}
		}

		$region = array('seller_registration_logo', 'login_registration_logo');
		$logos = array('blfile' => 'seller_registration_logo', 'ufile' => 'login_registration_logo');
		//$data = $this->users_model->getData('home_page_setting', array(), 'id, region, value', array(), array('region' => $region));

		$logo = FILEPATH . 'img/backgrounds/img-12.jpg';

		$logo_images = array('seller_registration_logo' => '', 'login_registration_logo' => '');
/*
		foreach ($data as $value) {
			if ($value->region == 'seller_registration_logo') {
				$logo_images['seller_registration_logo'] = $value->value;
			} else if ($value->region == 'login_registration_logo') {
				$logo_images['login_registration_logo'] = $value->value;
			}
		}
*/
		if (!empty($logo_images['seller_registration_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['seller_registration_logo'];
		} else if (!empty($logo_images['login_registration_logo'])) {
			$logo = UPLOADPATH . 'setting/page_logo/' . $logo_images['login_registration_logo'];
		}
		
		$this->commonData['logo'] = $logo;
		$this->commonData['title'] = 'Business Regsiter';
		$this->commonData['user'] = $user;
		
		$this->loadFScreen('frontend/user/register');
	}

	public function regionChange ($region = '') {
		setcookie('bm_rg', $region, time() + (86400 * 30), '/');
		$rlink = ($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
		redirect($rlink);
	}

}