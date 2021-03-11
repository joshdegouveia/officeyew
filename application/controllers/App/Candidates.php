<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Candidates extends BaseController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Product_model');
		$this->load->model('Login_model');
	}
	public function get_candiadate_dashboard_list_all_jobs(){
		$data = json_decode(file_get_contents('php://input'));
	  	$limit = $data->limit;
		$jobsData = $this->Users_model->getjobbyuserType('', $limit,'','','');
		$response['fav_data'] = $jobsData;
		$response['success'] = true;
		$response['msg'] = ' Message Submitted Successfully';
		echo json_encode($response);
	}
	public function get_candiadate_all_applied_jobs(){
		$data = json_decode(file_get_contents('php://input'));
	  	$user_id = $data->user_id;
		$this->Users_model->get_applied_data($user_id);
		if(!empty($user_id)){
			$appliedData = $this->Users_model->get_applied_data($user_id);
			$response['fav_data'] = $appliedData;
			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		echo json_encode($response);
	}
	public function get_candidate_list_all_save_jobs(){
		$data = json_decode(file_get_contents('php://input'));
	  	$user_id = $data->user_id;
		if(!empty($user_id)){
			$savedData = $this->Users_model->get_saved_data($user_id);
			$response['fav_data'] = $savedData;
			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		echo json_encode($response);
	}
	public function apply_job(){
		$data = json_decode(file_get_contents('php://input'));
		$user_id = $data->user_id;
		$job_id = $data->job_id;
		$la_post['applied_by_user_id'] = $user_id;
		$la_post['applied_in_job_id'] = $job_id;
		$la_post['applied_date'] = date('Y-m-d H:i:s');
		$favorites = $this->Users_model->getData('job_applied', ['applied_by_user_id' => $user_id, 'applied_in_job_id' => $job_id]);
		if (empty($favorites)) {
			$insertId = $this->Users_model->insertData('job_applied', $la_post);
			if ($insertId) {
				$response['success'] = true;
				$response['text'] = "Already Aplied";
				$response['flag'] = "add";
				$response['msg'] = 'Job Applied Successfully';
			}
		}else {
		
			if ($return) {
				$response['success'] = true;
				$response['text'] = "Apply";
				$response['flag'] = "remove";
				$response['msg'] = 'This job already applied by you.';
			}
		} 
		echo json_encode($response);
	}
	public function remove_apply_jobs(){
		$data = json_decode(file_get_contents('php://input'));
		$user_id = $data->user_id;
		$job_id = $data->job_id;
		$la_post['applied_by_user_id'] = $user_id;
		$la_post['applied_in_job_id'] = $job_id;
		$la_post['applied_date'] = date('Y-m-d H:i:s');
		$favorites = $this->Users_model->getData('job_applied', ['applied_by_user_id' => $user_id, 'applied_in_job_id' => $job_id]);
		if (!empty($favorites)) {
			$return = $this->Users_model->deleteData('job_applied', ['applied_by_user_id' => $user_id, 'applied_in_job_id' => $job_id]);
			if ($return) {
				$response['success'] = true;
				$response['text'] = "Apply";
				$response['flag'] = "remove";
				$response['msg'] = 'Successfully Remove From List';
			}
		}else{
				$response = array('success' => false, 'msg' => 'Data missing');
		}
		echo json_encode($response);
	}
	public function save_job()
	{
		$data = json_decode(file_get_contents('php://input'));
		$job_id = $data->job_id;
		$user_id = $data->user_id;
		$la_post['save_by_user_id'] = $user_id;
		$la_post['saved_job_id'] = $job_id;
		$la_post['saved_date'] = date('Y-m-d H:i:s');

		$favorites = $this->Users_model->getData('save_jobs', ['save_by_user_id' => $user_id, 'saved_job_id' => $job_id]);
			if (empty($favorites)) {
				$insertId = $this->Users_model->insertData('save_jobs', $la_post);
				if ($insertId) {
					$response['success'] = true;
					$response['text'] = "Remove";
					$response['flag'] = "add";
					$response['msg'] = 'Added to your Savelist';
				}
			} else {
				$response = array('success' => false, 'msg' => 'Data missing');
			} 
		echo json_encode($response);
	}
	public function remove_save_job(){
		$data = json_decode(file_get_contents('php://input'));
		$job_id = $data->job_id;
		$user_id = $data->user_id;
		$la_post['save_by_user_id'] = $user_id;
		$la_post['saved_job_id'] = $job_id;
		$la_post['saved_date'] = date('Y-m-d H:i:s');

		$favorites = $this->Users_model->getData('save_jobs', ['save_by_user_id' => $user_id, 'saved_job_id' => $job_id]);
		if (!empty($favorites)) {
			$return = $this->Users_model->deleteData('save_jobs', ['save_by_user_id' => $user_id, 'saved_job_id' => $job_id]);
			if ($return) {
				$response['success'] = true;
				$response['text'] = "Remove";
				$response['flag'] = "add";
				$response['msg'] = 'Save jobs are removed successfully';
			}
		} else {
			$response = array('success' => false, 'msg' => 'Data missing');
		}
		echo json_encode($response);
	}
	
}
?>

