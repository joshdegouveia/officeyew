<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Class MY_Controller
 *
 */
class MY_Controller extends CI_Controller{
    public function __construct(){
        parent::__construct();
		
    }
}

/**
 * Class FrontendController
 *
 */
class FrontendController extends MY_Controller{
    public function __construct(){
        parent::__construct();
		
    }
}

/**
 * Class AdminController
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class AdminController extends MY_Controller{
    protected $commonData = [] ;

    public function __construct(){
        parent::__construct();
        $this->load->library(['ion_auth', 'session', 'form_validation']) ;
        $this->load->database() ;
        $this->load->helper(['url', 'language']) ;
        
        $setting = getSettingData();
        $this->commonData['site_setting'] = getSettingData();
        if (!empty($setting)) {
            define('SITE_NAME', $setting->site_name);
            define('SITE_EMAIL', $setting->site_email);
        }

        $this->commonData['site'] = SITE_NAME;
        $this->commonData['activeMenues'] = [];
        $this->commonData['user_type'] = '';
        $this->commonData['currency'] = '$';

        if (isset($this->session->userdata['type'])) {
            $this->commonData['user_type'] = $this->session->userdata['type'];
        }
    }

    /**
    * This function check the authentication
    *
    * @param
    *
    * @return boolean
    */
    public function userLogged(){
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()){
			// redirect them to the login page
            redirect('admin/auth/login', 'refresh');
            exit() ;
            return FALSE ;
		} else{
            return TRUE ;
        }
    }

    /**
    * This function will help to load any screen
    *
    * @param template is the screen name
    *
    * @return void no return data will be presented
    */
    protected function loadScreen($template){
        if(isset($this->session->userdata) && $this->session->userdata('user_id') != ''){
            $userId = $this->session->userdata('user_id') ;
            $this->commonData['userData'] = $this->db->get_where('users', array('id' => $userId))->row() ;
        }
         
      
        $this->load->view('admin/layout/header', $this->commonData); // just the header file
        $this->load->view('admin/layout/sidemenu');
        $this->load->view('admin/'.$template);
        $this->load->view('admin/layout/footer');
    }
	
	function loadChangePassword($template, $load_commonData)
	{
		 if(isset($this->session->userdata) && $this->session->userdata('user_id') != ''){
            $userId = $this->session->userdata('user_id') ;
            $this->commonData['userData'] = $this->db->get_where('users', array('id' => $userId))->row() ;
        }
		
		/* echo '<pre>';
		print_r($this->commonData['userData']); */
		
       $this->load->view('admin/layout/header', $this->commonData); // just the header file
        $this->load->view('admin/layout/sidemenu');
        $this->load->view('admin/auth/'.$template);
        $this->load->view('admin/layout/footer');    
	}
}



class BaseController extends MY_Controller{
    public $commonData = [] ;

    public function __construct() {
        parent::__construct();

        // redirect(base_url('admin'));
		
        $this->load->library(['ion_auth', 'session', 'form_validation']);
        $this->load->database();
        $this->load->helper(['url', 'language']);
		// $this->load->model('Users_model');

        $this->commonData['activeMenues'] = [];
        $this->commonData['breadcrumb'] = '';//getBreadCrumb();
        $this->commonData['currency'] = '$';
        $setting = $this->commonData['site_setting'] = getSettingData();
        if (!empty($setting)) {
            define('SITE_NAME', $setting->site_name);
            define('SITE_EMAIL', $setting->site_email);
        }
        // $stripe = getAdminStripe();
        // $this->commonData['secret_key'] = '';
        // $this->commonData['publish_key'] = '';
        // if (!empty($stripe)) {
        //     $this->commonData['secret_key'] = $stripe->secret_key;
        //     $this->commonData['publish_key'] = $stripe->publish_key;
        // }
        $this->commonData['meta_data'] = array();
		// $this->admin_user_data = $this->Users_model->get_user_by_id(1);
    }

    /**
    * This function check the authentication
    *
    * @param
    *
    * @return boolean
    */
    public function userLogged(){
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()){
            // redirect them to the login page
            redirect('login/register', 'refresh');
            exit() ;
            return FALSE ;
        }else{
            return TRUE ;
        }
    }

    public function setUserData ($data) {
        $user_data = array(
            'id' => $data->id,
            'uniqueid' => $data->uniqueid,
            //'ip_address' => $data->ip_address,
            'type' => $data->type,
            'email' => $data->email,
            'phone' => $data->phone,
            'address' => $data->address,
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'filename' => $data->filename,
            'user_types' => $data->user_types,
        );
        $this->session->set_userdata('user_data', $user_data);
    }

    /**
    * This function will help to load any screen
    *
    * @param template is the screen name
    *
    * @return void no return data will be presented
    */
	
	protected function loadPlainScreen($template, $data = array()){
		
        if(isset($this->session->userdata) && $this->session->userdata('user_id') != ''){
            $userId = $this->session->userdata('user_id') ;
            $this->commonData['userData'] = $this->db->get_where('users', array('id' => $userId))->row() ;
        }

        $this->load->view('frontend/layout/plain_header', $this->commonData); // just the header file
        // $this->load->view('admin/layout/sidemenu');
        if (!empty($template)) {
            $this->load->view($template, $data);
        }
        $this->load->view('frontend/layout/plain_footer');
    }
	
    protected function loadFScreen($template, $data = array()) {
        
        if(isset($this->session->userdata) && $this->session->userdata('user_id') != ''){
            $userId = $this->session->userdata('user_id') ;
            $this->commonData['userData'] = $this->db->get_where('users', array('id' => $userId))->row() ;
        }
        
        $this->load->view('frontend/layout/header', $this->commonData); // just the header file
        // $this->load->view('admin/layout/sidemenu');
        if (!empty($template)) {
            $this->load->view($template, $data);
        }
        $this->load->view('frontend/layout/footer', $this->commonData);
    }

    protected function loadScreen($template, $data = array()) {
		
        if(isset($this->session->userdata) && $this->session->userdata('user_id') != ''){
            $userId = $this->session->userdata('user_id') ;
            $this->commonData['userData'] = $this->db->get_where('users', array('id' => $userId))->row() ;
        }
		
        $this->load->view('frontend/layout/header', $this->commonData); // just the header file
        // $this->load->view('admin/layout/sidemenu');
        if (!empty($template)) {
            $this->load->view($template, $data);
        }
        $this->load->view('frontend/layout/footer', $this->commonData);
    }
}