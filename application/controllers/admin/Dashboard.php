<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Dashboard
 * 
 */
class Dashboard extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('users_model');

		if ( $this->userLogged() == false ) {
			// redirect them to the login page
			redirect('admin/auth/login', 'refresh');
			exit ;
		}
	}

	/**
	 * Redirect if needed, otherwise display the Dahboard
	 */
	public function index() {
		$this->commonData['activeMenues']['menuParent'] = 'dashboard';
		$this->commonData['activeMenues']['menuChild'] = '';
		
		$this->commonData['title'] = "Dashboard";
//		$type = $this->session->userdata('type');
//		$id = $this->session->userdata('user_id');

		$la_userCount = $this->users_model->getUserCount();

                $cms = $this->users_model->getData('cms', array(), 'COUNT(id) AS total');
		//$faq_category = $this->users_model->getData('faq_category', array(), 'COUNT(id) AS total');
		//$faq_item = $this->users_model->getData('faq_items', array(), 'COUNT(id) AS total');
		

                $this->commonData['la_userCount'] = $la_userCount;
		$this->commonData['total_cms'] = (!empty($cms)) ? $cms[0]->total : 0;
		//$this->commonData['total_faq_category'] = (!empty($faq_category)) ? $faq_category[0]->total : 0;
		//$this->commonData['total_faq_item'] = (!empty($faq_item)) ? $faq_item[0]->total : 0;

		$this->loadScreen('dashboard');
	}

}
