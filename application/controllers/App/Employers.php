<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employers extends BaseController {
	public function __construct() {
		parent::__construct();
		// $this->load->library('facebook');
		$this->load->model('Users_model');
		$this->load->model('Product_model');
		$this->load->model('Login_model');
	   
	}
	public function user_recent_job_applicant(){
		$data = json_decode(file_get_contents('php://input'));
	  	$user_id = $data->user_id;
		if(!empty($user_id)){
			$records = $this->Users_model->get_job_applicant($user_id);
			$response['fav_data'] = $records;
			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
		}else{
		  $response = array('success' => false, 'msg' => 'user id missing');
	    }
		//print_r($response);
		echo json_encode($response);
	}
	public function user_recent_job_posted(){
		$data = json_decode(file_get_contents('php://input'));
	  	$user_id = $data->user_id;
		if(!empty($user_id)){
			$records = $this->Users_model->get_jobs_data($user_id, '');
			$response['fav_data'] = $records;
			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		//print_r($response);
		echo json_encode($response);
	}
	public function get_user_my_jobs(){
		$data = json_decode(file_get_contents('php://input'));
		$user_id = $data->user_id;
		
		  if(!empty($user_id)){
			$records = $this->Users_model->get_jobs_data($user_id,'');
			$response['fav_data'] = $records;
			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
		 }else{
				$response = array('success' => false, 'msg' => 'User Id Missing');
			}
		 echo json_encode($response);
	}

	public function get_user_job_applicants(){
	  $data = json_decode(file_get_contents('php://input'));
	  $user_id = $data->user_id;
	  if(!empty($user_id)){
	  		$records = $this->Users_model->get_job_applicant($user_id);
			$response['fav_data'] = $records;
			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
	  }else{
		   $response = array('success' => false, 'msg' => 'user id missing');
	  }
	  //print_r($response);
	  echo json_encode($response);
	}

	public function user_find_resume(){
		$data = json_decode(file_get_contents('php://input'));
	  	$user_id = $data->user_id;
		$limit = $data->limit;
		if(!empty($user_id)){
	  		$records = $this->Users_model->getusersType("'candidate'", '', $limit,'','','');
			$response['fav_data'] = $records;
			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
		 }else{
			   $response = array('success' => false, 'msg' => 'user id missing');
		 }
	  	echo json_encode($response);
	}
	public function user_add_jobs(){
			$data = json_decode(file_get_contents('php://input'));
			$user_id = $data->user_id;
	  	    $job_title = $data->job_title;
			$job_description = $data->job_description;
			$min_salary = $data->min_salary;
			$max_salary = $data->max_salary;
			$educational_level = $data->educational_level;
			$experience = $data->experience;
			$preferred_location = $data->preferred_location;
			$designation = $data->designation;
			$avl_time_frame = $data->avl_time_frame;
			$travel_required = $data->travel_required;
			$post_anonymous = $data->post_anonymous;
			//$job_id = $data->job_id;
			
			
			$la_post['job_title'] = (!isset($job_title)) ? "" : $job_title;
			$la_post['job_description'] = (!isset($job_description)) ? "" : $job_description;
			$la_post['min_salary'] = (!isset($min_salary)) ? "" : $min_salary;
			$la_post['max_salary'] = (!isset($max_salary)) ? "" : $max_salary;
			$la_post['educational_level'] = (!isset($educational_level)) ? "" : $educational_level;
			$la_post['experience'] = (!isset($experience)) ? "" : $experience;
			$la_post['preferred_location'] = (!isset($preferred_location)) ? "" : $preferred_location;
			$la_post['designation'] = (!isset($designation)) ? "" : $designation;
			$la_post['avl_time_frame'] = (!isset($avl_time_frame)) ? "" : $avl_time_frame;
			$la_post['travel_required'] = (!isset($travel_required)) ? "" : $travel_required;
			$la_post['post_anonymous'] = (!isset($post_anonymous)) ? "" : $post_anonymous;
			$la_post['job_upload_date'] = time();
			$timestamp = time();
			$la_post['job_expiry_date'] = strtotime('+7 days', $timestamp);
            $la_post['job_status'] = 1;
			if (empty($job_id)) {
				$insertid = $this->Users_model->insertData('jobs', $la_post);
				if ($insertid) {
					$la_post['Job_id'] = $insertid;
					$response['success'] = true;
					$response['data'] = $la_post;
					$response['msg'] = 'Job has been successfully uploaded';
					$response = array('success' => true, 'msg' => 'Job has been successfully uploaded');
				} else {
					$response = array('success' => false, 'msg' => 'Error in insertion');
				}
            }else{
				$unset_arr = array('job_upload_date','job_expiry_date','job_status');
				foreach ($unset_arr as $key=>$val) {
					unset($la_post[$key]);
				}
				$this->db->where(array('id'=>$job_id));
				$this->db->update('jobs',$la_post);
				$la_post['Job_id'] = $job_id;
				$response['success'] = true;
				$response['data'] = $la_post;
				$response['msg'] = 'Job updated successfully';
				$response = array('success' => true, 'msg' => 'Job has been successfully updated');
            }
			
			echo json_encode($response);
	}
	public function user_update_jobs(){
		$data = json_decode(file_get_contents('php://input'));
		$user_id = $data->user_id;
		$job_title = $data->job_title;
		$job_description = $data->job_description;
		$min_salary = $data->min_salary;
		$max_salary = $data->max_salary;
		$educational_level = $data->educational_level;
		$experience = $data->experience;
		$preferred_location = $data->preferred_location;
		$designation = $data->designation;
		$avl_time_frame = $data->avl_time_frame;
		$travel_required = $data->travel_required;
		$post_anonymous = $data->post_anonymous;
		$job_id = $data->job_id;
		
		$la_post['job_title'] = (!isset($job_title)) ? "" : $job_title;
		$la_post['job_description'] = (!isset($job_description)) ? "" : $job_description;
		$la_post['min_salary'] = (!isset($min_salary)) ? "" : $min_salary;
		$la_post['max_salary'] = (!isset($max_salary)) ? "" : $max_salary;
		$la_post['educational_level'] = (!isset($educational_level)) ? "" : $educational_level;
		$la_post['experience'] = (!isset($experience)) ? "" : $experience;
		$la_post['preferred_location'] = (!isset($preferred_location)) ? "" : $preferred_location;
		$la_post['designation'] = (!isset($designation)) ? "" : $designation;
		$la_post['avl_time_frame'] = (!isset($avl_time_frame)) ? "" : $avl_time_frame;
		$la_post['travel_required'] = (!isset($travel_required)) ? "" : $travel_required;
		$la_post['post_anonymous'] = (!isset($post_anonymous)) ? "" : $post_anonymous;
		$la_post['job_status'] = 1;
		$this->db->where(array('id'=>$job_id));
		$this->db->update('jobs',$la_post);
		$la_post['Job_id'] = $job_id;
		$response['success'] = true;
		$response['data'] = $la_post;
		$response['msg'] = 'Job updated successfully';
		$response = array('success' => true, 'msg' => 'Job has been successfully updated');
		echo json_encode($response);
	}

	public function get_user_all_applicants(){
		$data = json_decode(file_get_contents('php://input'));
	  	$user_id = $data->user_id;
		if(!empty($user_id)){
			$records = $this->Users_model->get_job_applicant($user_id);
			$response['fav_data'] = $records;
			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
		}else{
			   $response = array('success' => false, 'msg' => 'user id missing');
		 }
	  	echo json_encode($response);
	}
}
?>

