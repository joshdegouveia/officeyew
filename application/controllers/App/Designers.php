<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Designers extends BaseController {
	public function __construct() {
		parent::__construct();
		// $this->load->library('facebook');
		$this->load->model('Users_model');
		$this->load->model('Product_model');
		$this->load->model('Login_model');
	   
	}
	
	   


}
?>

