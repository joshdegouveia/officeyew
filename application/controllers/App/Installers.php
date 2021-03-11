<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Installers extends BaseController {
	public function __construct() {
		parent::__construct();
		// $this->load->library('facebook');
		$this->load->model('Users_model');
		$this->load->model('Product_model');
		$this->load->model('Login_model');
	   
	}
	
	   
	public function get_all_request(){
		$data = json_decode(file_get_contents('php://input'));
		$limit['limit'] = $data->prodLimit;
		$currentpage = $data->offset;
		$limit['offset'] = (($currentpage - 1 ) * $limit['limit']);
		$uid = $data->userId;
		$installer_order_by['order_by'] = 'installer_request_id';
        $installer_order_by['sort'] = 'DESC';

		$la_installer_request_data = $this->Users_model->getData('installer_request', array('user_id' => $uid), '', [], [], $installer_order_by, $limit);
        $li_installerRequestData_count = $this->Users_model->getCountInstallerRequest($uid)->count;

		$la_installer_request_received = $this->Users_model->installer_request_received($uid, $limit, $installer_order_by);
        $la_installerRequestReceived_count = $this->Users_model->getCountInstallerRequest_received($uid)->count;

		$response['success'] = true;
		$response['requested_data'] = $la_installer_request_data;
		$response['requested_data_count'] = $li_installerRequestData_count;
		$response['incoming_data'] = $la_installer_request_received;
		$response['incoming_data_count'] = $la_installerRequestReceived_count;
		echo json_encode($response);

	}


	public function installer_dashboard(){
		 $data = json_decode(file_get_contents('php://input'));
		 $dashboard_data = array();
		 $la_installer_request_data_2 = array();
		 $la_installer_request_received_2=array();
		 
		 $uid = $data->user_id;
		 $la_installer_request_data_2=$this->db->select('*')->from('installer_request')->where(array('user_id'=>$uid))->order_by('installer_request_id','desc')->limit(5,0)->get()->result();
		 $dashboard_data['la_installer_request_data_2']=$la_installer_request_data_2;
		 
		 $la_installer_request_received_2= $this->db->select('ir.*, u.first_name, u.last_name')->from('installer_request ir')->join('installer_request_map irm', 'irm.request_id = ir.installer_request_id', 'left')->join('users u', 'u.id = ir.user_id', 'left')->where("irm.installer_id = $uid")->order_by('ir.installer_request_id', 'DESC')->limit(5,0)->get()->result();
		 $dashboard_data['la_installer_request_received_2']=$la_installer_request_received_2;
		 
		$response['success'] = true;
		$response['requested_data'] = $dashboard_data;
		
		echo '<pre>';
		print_r($response);
		//echo json_encode($response);
		
	}


}
?>

