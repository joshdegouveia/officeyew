<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Login extends BaseController {

    public function __construct() {
        parent::__construct();
        // $this->load->library('facebook');
        $this->load->model('Login_model');
        $this->load->model('users_model');
    }
	

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index() {
        //exit;
        $user = authentication(false);
        if ($this->input->post() && empty($user)) {

            if ($this->Login_model->from_validation_resgistration()) {
                //pre($this->input->post(),1);
                if (!checkEmail(trim($this->input->post('email')))) {
                    $post_data = array();
                    $activation_code = md5(date("YmdHis") . rand(100, 999));

                    $post_data['first_name'] = trim($this->input->post('first_name'));
                    $post_data['last_name'] = '  ';
                    $post_data['uniqueid'] = uniqid();
                    $post_data['email'] = trim($this->input->post('email'));
                    $post_data['password'] = $this->input->post('password');
                    $post_data['phone'] = trim($this->input->post('phone'));
                    $post_data['type'] = CUSTOMER;
                    $post_data['activation_code'] = $activation_code;
                    $post_data['active'] = 0;
                    $post_data['created_date'] = time();
                    $post_data['modified_date'] = time();
                    $post_data['ip_address'] = $_SERVER['REMOTE_ADDR'];

                    $uid = $this->Login_model->insert('users', $post_data);
                    // mail for confurmation
                    $name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
                    $name = ucwords($name);
                    $config = array(
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'priority' => '1'
                    );
                    $this->email->initialize($config);
                    $this->email->from(SITE_EMAIL, SITE_NAME);
                    // $this->email->to('rupam.brainium@gmail.com');
                    $this->email->to($this->input->post('email'));
                    $data_arr = array(
                        'username' => $name,
                        'email' => $this->input->post('email'),
                        'active_link' => base_url() . 'newuser/activation/' . $activation_code,
                    );
                    $this->email->subject(SITE_NAME . ' Register Activation Link');
                    $body = $this->load->view('frontend/email/registration.php', $data_arr, TRUE);
                    $this->email->message($body);
                    @$this->email->send();
                    // // mail
                    if (!empty($uid)) {
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

    function activation() {
        $activation_code = $this->uri->segment(3);
        $user = $this->Login_model->getUser(array('activation_code' => $activation_code));

        if (empty($user)) {
            $this->session->set_flashdata('msg_error', 'Activation code has been expired!');
        } else {
            $this->Login_model->update('users', array('activation_code' => '', 'active' => 1), array('id' => $user[0]->id));
            $this->session->set_flashdata('msg_success', 'Your account has successfully activated.');
        }
        redirect(base_url('login/signin'), 'refresh');
    }

    public function forgot_password() {
        $user = authentication(false);

        if (!empty($user)) {
            redirect(base_url());
        }
        if ($this->input->post('email')) {
            $email = trim($this->input->post('email'));
            $user = $this->users_model->getData('users', array('email' => $email));

            if (empty($user)) {
                $this->session->set_flashdata('msg_error', 'Email does not exist.');
            } else {
                $user = $user[0];
                $activation_code = md5($email . rand(111, 999));
                $this->users_model->updateData('users', array('id' => $user->id), array('activation_code' => $activation_code, 'password' => ''));

                unset($_SESSION['msg_error']);
                $this->session->set_flashdata('msg_success', 'Password reset link has sent to your email.');
                // mail
                $name = $user->first_name . ' ' . $user->last_name;
				/*$subject = "Password Rest Link";
				  $data_arr = array(
                    'username' => $name,
                    'active_link' => base_url() . 'login/passwordreset/' . $activation_code,
                );
				 $body = $this->load->view('frontend/email/forgot_password.php', $data_arr, TRUE);
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers = "Content-type: text/html; charset=iso-8859-1" . "\r\n";
				if(mail($email, $subject, $body, $headers, "-f info@mydevfactory.com")){echo $this->email->print_debugger();}else{echo $this->email->print_debugger();}*/
				
				/*
                $config = array(
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'priority' => '1'
                );
                $this->email->initialize($config);
                $this->email->from(SITE_EMAIL, SITE_NAME);
                $this->email->to($email);
                $data_arr = array(
                    'username' => $name,
                    'active_link' => base_url() . 'login/passwordreset/' . $activation_code,
                );
                $this->email->subject(SITE_NAME . ' Password Rest Link');
                $body = $this->load->view('frontend/email/forgot_password.php', $data_arr, TRUE);
                $this->email->message($body);
                $this->email->send();
				*/
				$this->load->config('email');
				$this->load->library('email');
				//$from = $this->config->item('smtp_user');
				$from = SITE_EMAIL;
				$to = $email;
				$subject = SITE_NAME . ' Password Rest Link';
				$data_arr = array(
                    'username' => $name,
                    'active_link' => base_url() . 'login/passwordreset/' . $activation_code,
                );
				$body = $this->load->view('frontend/email/forgot_password.php', $data_arr, TRUE);
				$message = $body;
				
				$this->email->set_newline("\r\n");
				$this->email->from($from);
				$this->email->to($to);
				$this->email->subject($subject);
				$this->email->message($message);
				
				if ($this->email->send()) {
					//echo 'Your Email has successfully been sent.';
					$this->session->set_flashdata('msg_success', 'Password reset link has sent to your email.');
				} else {
					show_error($this->email->print_debugger());
				}
                // mail
           }
        }


        $this->commonData['header_flag'] = 'text_only';
        $this->commonData['title'] = 'Forgot Password';
        $this->loadFScreen('frontend/user/forgot_password');
    }

    public function passwordreset() {
        $user = authentication(false);

        if (!empty($user)) {
            redirect(base_url());
        }
        unset($_SESSION['msg_success']);
        unset($_SESSION['msg_error']);
        $data = array();
        $activation_code = $this->uri->segment(3);
        $user = $this->users_model->getData('users', array('activation_code' => $activation_code));

        if ($this->input->post()) {
            if (empty($user)) {
                $this->session->set_flashdata('msg_error', 'Password reset link has been expired!');
            } else {
                if ($this->input->post('password') != $this->input->post('confirm_password')) {
                    $this->session->set_flashdata('msg_error', 'Password & Confirm password must be same!');
                } else {
                    $user = $user[0];
                    $password = md5($this->input->post('password'));
                    $this->users_model->updateData('users', array('id' => $user->id), array('password' => $password, 'activation_code' => ''));
//                    $this->setUserData($user);

                    $this->session->set_flashdata('msg_success', 'You have successfully set new password.');
                    redirect(base_url('login/signin'), 'refresh');
                }
            }
        }

        if (empty($user)) {
            $this->session->set_flashdata('msg_error', 'Password reset link has been expired!');
        }

        $this->commonData['header_flag'] = 'text_only';
        $this->commonData['title'] = 'Reset Password';
        $this->loadFScreen('frontend/user/activation', $data);
    }

    public function signin() {
        $user = authentication(false);

        if (!empty($user)) {
            redirect(base_url());
        }

        if ($this->input->post()) {
            if ($this->Login_model->from_validation_login()) {
                $post_data = array();

                $post_data['email'] = $this->input->post('email');
                $post_data['password'] = $this->input->post('password');

                $user = $this->users_model->getData('users', $post_data);


                if (!empty($user)) {
                    $user = $user[0];
                    $user_type = $this->users_model->getUserType(['email' => $post_data['email']]);
                    $user->type = explode(',', $user_type->user_types)[0];
                    $user->user_types = explode(',', $user_type->user_types);

//                    print_r($user);die;

                    if ($user->active == 0 && !empty($user)) {
                        $this->session->set_flashdata('msg_error', 'Please active your account and try again.');
                    } else if ($user->active == 1 && !empty($user)) {
                        $fields = array(
                            'last_activity' => time()
                        );
                        $this->users_model->updateData('users', array('id' => $user->id), $fields);
                        
                        if (isset($_GET['type']) && ($_GET['type'] == 'seller')) { // dirrect login to seller =========
                            if (in_array('seller', $user->user_types)) {
                                $user->type = 'seller';
                            }else{
                                $this->session->set_flashdata('msg_error', 'You do not have permission to sell.');
                            }
                        }
                        
                        $this->setUserData($user);
                        
                        
                        if (isset($_SESSION['user_data_url']['login_return_url']) && ($_SESSION['user_data_url']['login_return_url'] != '')) {
                            $returnUrl = $_SESSION['user_data_url']['login_return_url'];
                            $_SESSION['user_data_url']['login_return_url'] = '';
                        } else {
                            $returnUrl = base_url('user/profile');
                        }
//                        $rlink = ($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url('user/profile');
                        redirect($returnUrl);
                    }
                } else {
                    $this->session->set_flashdata('msg_error', 'Email or password does not match.');
                }
            }
        }

        $this->commonData['header_flag'] = 'text_only';
        $this->commonData['title'] = 'Login';

        $this->loadFScreen('frontend/user/login');
    }

    public function register() {
        $user = authentication(false);
        $la_groups = $this->users_model->getData('groups', ['id !=' => 1]);

        if ($this->input->post() && empty($user)) {

            $la_userType = [];
            if (isset($_POST['user_type'])) {
                $la_userType = $_POST['user_type'];
                $_POST['user_type'] = implode(",", $_POST['user_type']);
            }

            if ($this->Login_model->from_validation_resgistration()) {
                if (!checkEmail(trim($this->input->post('email')))) {
                    $post_data = array();
                    $activation_code = md5(date("YmdHis") . rand(100, 999));
                    $post_data['uniqueid'] = uniqid();
                    $post_data['first_name'] = trim($this->input->post('first_name'));
                    $post_data['last_name'] = trim($this->input->post('last_name'));
                    $post_data['email'] = trim($this->input->post('email'));
                    $post_data['password'] = $this->input->post('password');

                    $post_data['activation_code'] = $activation_code;
                    $post_data['active'] = 0;
                    $post_data['created_date'] = time();
                    $post_data['modified_date'] = time();
                    $post_data['ip_address'] = $_SERVER['REMOTE_ADDR'];

                    $uid = $this->Login_model->insert('users', $post_data);

                    if ($uid > 0) {
                        foreach ($la_userType as $li_userTypeId) {
                            $this->Login_model->insert('users_groups', ['user_id' => $uid, 'group_id' => $li_userTypeId]);
                        }
                    }

                    // mail for confurmation
                    /*$name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
                    $name = ucwords($name);
                    $config = array(
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'priority' => '1'
                    );
                    $this->email->initialize($config);
                    $this->email->from(SITE_EMAIL, SITE_NAME);
                    // $this->email->to('rupam.brainium@gmail.com');
                    $this->email->to($this->input->post('email'));
                    $data_arr = array(
                        'username' => $name,
                        'email' => $this->input->post('email'),
                        'active_link' => base_url() . 'login/activation/' . $activation_code,
                    );
                    $this->email->subject(SITE_NAME . ' Register Activation Link');
                    $body = $this->load->view('frontend/email/registration.php', $data_arr, TRUE);
                    $this->email->message($body);
                    @$this->email->send();
                    // // mail
                    if (!empty($uid)) {
                        $this->session->set_flashdata('msg_success', 'You have sucessfully registered. A verification link has been sent to your email account.');
                        redirect(base_url('login/signin'));
                    } else {
                        $this->session->set_flashdata('msg_error', 'You are not registred please try again');
                    }
					*/
					$this->load->config('email');
					$this->load->library('email');
					//$from = $this->config->item('smtp_user');
					$from = SITE_EMAIL;
					$email=trim($this->input->post('email'));
					$to = $email;
					//$to = 'rajashree.sarkar@brainiuminfotech.com';
					$subject = SITE_NAME . ' Register Activation Link';
					$name = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
                    $name = ucwords($name);
					$data_arr = array(
                        'username' => $name,
                        'email' => $this->input->post('email'),
                        'active_link' => base_url() . 'login/activation/' . $activation_code,
                    );
					$body = $this->load->view('frontend/email/registration.php', $data_arr, TRUE);
					$message = $body;
					
					$this->email->set_newline("\r\n");
					$this->email->from($from);
					$this->email->to($to);
					$this->email->subject($subject);
					$this->email->message($message);
					
					if ($this->email->send()) {
					//echo 'Your Email has successfully been sent.';
					$this->session->set_flashdata('msg_success', 'You have sucessfully registered. A verification link has been sent to your email account.');
					unset($_POST);
					} else {
					show_error($this->email->print_debugger());
					}
					
					
					
                } else {
                    $this->session->set_flashdata('msg_error', 'Email address already exist. Please try with another email address.');
                }
            } else {
//                echo 'error validation';
                $msg_error = strip_tags(validation_errors());
                $this->session->set_flashdata('msg_error', $msg_error);
            }
        }


        $this->commonData['header_flag'] = 'text_only';
        $this->commonData['title'] = 'Registration';
        $this->commonData['user'] = $user;
        $this->commonData['la_groups'] = $la_groups;

        $this->loadFScreen('frontend/user/register');
    }

    public function update_user_status() {
        $user_type = $_POST['user_type'];

        $_SESSION['user_data']['type'] = $user_type;
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function regionChange($region = '') {
        setcookie('bm_rg', $region, time() + (86400 * 30), '/');
        $rlink = ($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
        redirect($rlink);
    }

}
