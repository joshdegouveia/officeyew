<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Cms_pages extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->helper('cookie');
    }

    public function cms() {
        // pre($_COOKIE);
        $slug_req = $this->uri->segment(1);
        $slug = $title = '';
        $page = 'common_pages';
        switch ($slug_req) {

            case 'about-us':
                $slug = 'aboutus';
//                $slug = $page = 'aboutus';
                $title = 'About Us';
                break;

            case 'who-we-are':
                $slug = 'who_we_are';
//                $slug = $page = 'who_we_are';
                $title = 'Who We are';
                break;

            case 'how-we-work':
                $slug = 'how_we_work';
//                $slug = $page = 'how_we_work';
                $title = 'How we Work';
                break;

            case 'work-with-us':
                $slug = 'work_with_us';
                $title = 'Work With Us';
                break;

            case 'terms-condition':
                $slug = 'terms_condition';
                $title = 'Terms and Condition';
                break;

            case 'privacy-policy':
                $slug = 'privacy_policy';
                $title = 'Privacy Policy';
                break;
            case 'trust-safety':
                $slug = 'trust_safety';
                $title = 'Trust and Safety';
                break;

            case 'support':
                $slug = 'support';
                $title = 'support';
                break;

            case 'help':
                $slug = 'help';
                $title = 'Help';
                break;
        }

        $pagedata = $this->Users_model->getData('cms', array('type' => $slug));
//        print_r($pagedata);die;
        $short_description = '';
        if (!empty($pagedata)) {
            $this->commonData['content'] = $pagedata[0];
            $short_description = $pagedata[0]->sub_description;
        } else {
            $this->session->set_flashdata('eMessage', 'Page is not avalable right now .....');
            redirect(base_url(), 'refresh');
        }

        $meta_data = $this->Users_model->getData('seo_data', array('page_id' => $pagedata[0]->id));
        $this->commonData['meta_data'] = (!empty($meta_data)) ? $meta_data[0] : array();

        $this->load->model('Users_model');
        
//        die($page);
        $this->commonData['header_flag'] = 'text_only';
        $this->commonData['title'] = $title;
        $this->commonData['short_description'] = $short_description;
        $this->loadFScreen('frontend/pages/' . $page);
    }

    public function contact_us() {
		$this->commonData['page'] = 'ContactUs';
		$this->commonData['title'] = 'Contact Us';
        $this->loadFScreen('frontend/pages/contact_us');
    }


	public function contact_us_enquiry(){
		   if ($this->input->post()) {
            //mail for confurmation
            $error = false;
            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
			$phone = trim($this->input->post('phone'));
			$subject = trim($this->input->post('subject'));
            $message = trim($this->input->post('message'));

            if (empty($name)) {
                $this->session->set_flashdata('msg_error', 'Please enter your name');
                $error = true;
            }
            if (empty($email) && !validEmail($email)) {
                $this->session->set_flashdata('msg_error', 'Please enter a valid email');
                $error = true;
            }
			if (empty($phone)) {
                $this->session->set_flashdata('msg_error', 'Please enter your phone number');
                $error = true;
            }
			if (empty($subject)) {
                $this->session->set_flashdata('msg_error', 'Please enter your subject');
                $error = true;
            }
            if (empty($message)) {
                $this->session->set_flashdata('msg_error', 'Please enter message');
                $error = true;
            }

            if (!$error) {
                $admin_arr = getAdmin();
                $admin = $admin_arr[0];
                // mail
                $config = array(
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'priority' => '1'
                );
                $this->email->initialize($config);
                $this->email->from(SITE_EMAIL, SITE_NAME);
                // $this->email->to($admin->email);
                $this->email->to('himadrimajumder8@gmail.com');
                $data_arr = array(
                    'name' => $name,
                    'email' => $email,
					'phone' => $phone,
					'subject' => $subject,
                    'message' => $message,
                    'admin' => $admin,
                );
                $this->email->subject(SITE_NAME . ' Contact Us Request');
                $body = $this->load->view('frontend/email/contact_us.php', $data_arr, TRUE);
                $this->email->message($body);
                $this->email->send();
                // mail
                $this->session->set_flashdata('msg_success', 'Thank you for contact with us....');
            }
        }

        /*$this->load->model('Users_model');
//        $setting_arr = $this->Users_model->getData('home_page_setting');
//        $settings = array('first_heading' => '', 'second_heading' => '', 'summary' => '', 'first_button_title' => '', 'first_button_link' => '', 'second_button_title' => '', 'second_button_link' => '');

//        foreach ($setting_arr as $value) {
//            $settings[$value->region] = $value->value;
//        }

//        $this->commonData['home_page_setting'] = $settings;

//        $content = $this->Users_model->getData('cms', array('type' => 'contactus'));
//        $this->commonData['content'] = (!empty($content)) ? $content[0] : array();

        $pagedata = $this->Users_model->getData('cms', array('type' => 'contact_us'));
//        print_r($pagedata);die;
        $short_description = '';
        if (!empty($pagedata)) {
            $this->commonData['content'] = $pagedata[0];
            $short_description = $pagedata[0]->sub_description;
        } else {
            $this->session->set_flashdata('eMessage', 'Page is not avalable right now .....');
            redirect(base_url(), 'refresh');
        }

        $meta_data = $this->Users_model->getData('seo_data', array('page_id' => $pagedata[0]->id));
        $this->commonData['meta_data'] = (!empty($meta_data)) ? $meta_data[0] : array();

        $this->load->model('Users_model');*/
        
//        die($page);
		$this->commonData['page'] = 'ContactUs';
		$this->commonData['title'] = 'Contact Us';
        $this->loadFScreen('frontend/pages/contact_us');
	}

    public function faq() {
        $faq_items = $this->Users_model->getData('faq_items', array('status' => 1), '', array(), array(), array('order_by' => 'category_id', 'sort' => 'ASC'));
        $faq_categories = $this->Users_model->getData('faq_category', array('status' => 1), 'id, name', array(), array(), array('order_by' => 'id', 'sort' => 'ASC'));
        $faq_active_categories = array();

        if (!empty($faq_items) && !empty($faq_categories)) {
            foreach ($faq_items as $value) {
                if (!in_array($value->category_id, $faq_active_categories)) {
                    $faq_active_categories[$value->category_id] = $value->category_id;
                }
            }
        }

        $this->load->model('Users_model');
        $setting_arr = $this->Users_model->getData('home_page_setting');
        $settings = array('first_heading' => '', 'second_heading' => '', 'summary' => '', 'first_button_title' => '', 'first_button_link' => '', 'second_button_title' => '', 'second_button_link' => '');

        foreach ($setting_arr as $value) {
            $settings[$value->region] = $value->value;
        }

        $this->commonData['home_page_setting'] = $settings;

        $this->commonData['title'] = 'FAQ';
        $this->commonData['faq_items'] = $faq_items;
        $this->commonData['faq_categories'] = $faq_categories;
        $this->commonData['faq_active_categories'] = $faq_active_categories;

        $this->loadFScreen('frontend/pages/faq');
    }

}
