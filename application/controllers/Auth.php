<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Auth extends BaseController {
		public function __construct() {
			parent::__construct();
			// $this->load->library('facebook');
			$this->load->model('Login_model');
            $this->load->model('users_model');
            $this->load->model('Product_model');
		}
		public function getuserType() {
			$la_groups = $this->users_model->getData('groups', ['id !=' => 1]);
			echo json_encode($la_groups);
        }
        
        public function getcategory(){
            $la_categoey = $this->users_model->getData('product_category', ['status' => 1], '*', [], [], ['order_by' => 'name', 'sort' => 'ASC']);
            $response['data'] = $la_categoey;
            $response['success'] = true;
            echo json_encode($response);
            
        }
		

		public function register() {
      
		$data = json_decode(file_get_contents('php://input'));
		print_r($data);
		exit;
        if ($this->input->post()) {
            $data = json_decode(file_get_contents('php://input'), true);
			print_r($data);
			print_r($this->input->post());
			exit;
            $la_userType = $data['user_type'];
            //echo json_encode($data);
            $post_data = array();
            $activation_code = mt_rand(1000,9999);
            $post_data['uniqueid'] = uniqid();
            $post_data['first_name'] = trim($data['first_name']);
            $post_data['last_name'] = trim($data['last_name']);
            $post_data['email'] = trim($data['email']);
            $post_data['password'] = trim($data['password']);

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
            $name = $data['first_name'] . ' ' . $data['last_name'];
            $name = ucwords($name);
            $config = array(
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'priority' => '1'
            );
            $this->email->initialize($config);
            $this->email->from(SITE_EMAIL, SITE_NAME);
            // $this->email->to('rupam.brainium@gmail.com');
            $this->email->to($data['email']);
            $data_arr = array(
                'username' => $name,
                'email' => $data['email'],
                'active_link' => base_url() . 'login/activation/' . $activation_code,
            );
            $this->email->subject(SITE_NAME . ' Register Activation Link');
            $body = $this->load->view('frontend/email/registration.php', $data_arr, TRUE);
            $this->email->message($body);
            @$this->email->send();
                    // // mail*/

            $response['data'] = $uid;
            $response['success'] = true;
            $response['msg'] = "You have Successfully Regsiter";

     
        }else{
            $response = array('success' => false, 'msg' => 'something went wrong!');
        }
        echo json_encode($response);


        /*$this->commonData['header_flag'] = 'text_only';
        $this->commonData['title'] = 'Registration';
        $this->commonData['user'] = $user;
        $this->commonData['la_groups'] = $la_groups;

        $this->loadFScreen('frontend/user/register');*/
    }
    public function login() {
        if ($this->input->post()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $post_data = array();
            $post_data['email'] = trim($data['email']);
            $post_data['password'] = md5($data['password']);
           
            $user = $this->users_model->getData('users', $post_data);
            if (!empty($user)) {
                $user = $user[0];
                $user_type = $this->users_model->getUserType(['email' => $post_data['email']]);
                $user->type = explode(',', $user_type->user_types)[0];
                $user->user_types = explode(',', $user_type->user_types);

//                    print_r($user);die;

                /*if ($user->active == 0 && !empty($user)) {
                    $response = array('success' => false, 'msg' => 'Please active your account and try again.');
                } else if ($user->active == 1 && !empty($user)) {
                    $fields = array(
                        'last_activity' => time()
                    );
                    $this->users_model->updateData('users', array('id' => $user->id), $fields);
                    
                    if (isset($_GET['type']) && ($_GET['type'] == 'seller')) { // dirrect login to seller =========
                        if (in_array('seller', $user->user_types)) {
                            $user->type = 'seller';
                        }else{
                            //$this->session->set_flashdata('msg_error', 'You do not have permission to sell.');
                            $response = array('success' => false, 'msg' => 'You do not have permission to sell.');
                        }
                    }
                    
                    //$this->setUserData($user);*/
                    
                $response['data'] = $user;
                $response['success'] = true;
                $response['msg'] = "You have Successfully Login";
                 
            }else{
                $response = array('success' => false, 'msg' => 'Please Check Your Username And Password!');
            }
        }else{
            $response = array('success' => false, 'msg' => 'something went wrong!');
        }
        echo json_encode($response);
    }
    public function getallproducts(){
          
        $orderBy['orderBy'] = 'p.is_boost';
        $orderBy['type'] = 'DESC';
        $la_all_products = $this->Product_model->getProductList('', 0, $limit, '', '', '', $orderBy);
        $response['data'] = $la_categoey;
        $response['success'] = true;
        echo json_encode($response);

    }
	
////////////////////////////Added By Rajashree////////////////////////////
/*public function change_password(){
}
public function get_user_details(){
}
public function update_profile(){
}
public function insert_desiger_request(){
}
public function insert_installer_request(){
}
public function cms(){
}
public function add_jobs(){
}*/
	public function get_product_details(){
	if($this->input->post('category_id')) {
		$category_id =   $this->input->post('category_id');
	}else{
		$data = json_decode(file_get_contents('php://input'));
		$category_id = $data->category_id;
	}
	$this->db->from('products p');
	$this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'left');
	$this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
	$this->db->where('pcs.category_id', $category_id);
	$query = $this->db->get();
	$response = $query->result();
	/*echo '<pre>';
	print_r($response);
	echo '</pre>';
	*/
	echo json_encode($response);
		
	}
	public function get_jobs(){
	if($this->input->post('user_id')) {
		$user_id =   $this->input->post('user_id');
	}else{
		$data = json_decode(file_get_contents('php://input'));
		if(!empty($data)){
		$user_id = $data->user_id;
		}
	}
	if(!empty($user_id)){
		$this->db->where("jobs.userid != $user_id");
	}
	$this->db->where("jobs.job_status = 1");
	$this->db->order_by('jobs.job_title', 'ASC');
	$response=$this->db->select('*')->from('jobs')->get()->result();
	/*echo '<pre>';
	print_r($response);
	echo '</pre>';
	*/
	echo json_encode($response);
		
	}
	public function get_job_details(){
		if($this->input->post('job_id')) {
			$job_id =   $this->input->post('job_id');
		}else{
			$data = json_decode(file_get_contents('php://input'));
			if(!empty($data)){
			$job_id = $data->job_id;
			}
		}
		if(!empty($job_id)){
			$result = $this->db->select('*')->from('jobs')->where(array('id'=>$job_id))->get()->result();
			if($result!=''){
				$response= $result;
			}else{
				$response = array('success' => false, 'msg' => 'no jobs found by this id');
			}
		}else{
			$response = array('success' => false, 'msg' => 'Job Id Missing');
		}
		echo json_encode($response);
	}
	public function get_user_my_jobs(){
		if($this->input->post('user_id')) {
          $user_id =   $this->input->post('user_id');
	  }else{
		  $data = json_decode(file_get_contents('php://input'));
		  //print_r($data);
		$user_id = $data->user_id;
	  }
	  if(!empty($user_id)){
		$this->db->select('*');
		$this->db->from('jobs');
		$this->db->where('userid', $user_id);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		$response = $query->result();
	 }else{
			$response = array('success' => false, 'msg' => 'User Id Missing');
		}
	 echo json_encode($response);
	}
	public function get_user_job_applicants(){
		if($this->input->post('user_id')) {
          $user_id =   $this->input->post('user_id');
	  }else{
		  $data = json_decode(file_get_contents('php://input'));
		  //print_r($data);
		$user_id = $data->user_id;
	  }
	  if(!empty($user_id)){
	  	$this->db->select('ja.*, u.*, j.*');
		$this->db->from(' job_applied ja');
		$this->db->join('users u', 'u.id = ja.applied_by_user_id', 'left');
		$this->db->join('jobs j', 'j.id = ja.applied_in_job_id', 'left');
		$this->db->where('j.userid', $user_id);
		$this->db->order_by('ja.applied_id', 'DESC');
		$query = $this->db->get();
        $response =  $query->result();
	  }else{
		   $response = array('success' => false, 'msg' => 'user id missing');
	  }
	  echo json_encode($response);
	}

	public function get_user_applied_jobs(){
		if($this->input->post('user_id')) {
          $user_id =   $this->input->post('user_id');
	  }else{
		  $data = json_decode(file_get_contents('php://input'));
		  //print_r($data);
		$user_id = $data->user_id;
	  }
	  if(!empty($user_id)){
	  $this->db->select('ja.*, u.*, j.*');
		$this->db->from(' job_applied ja');
		$this->db->join('users u', 'u.id = ja.applied_by_user_id', 'left');
		$this->db->join('jobs j', 'j.id = ja.applied_in_job_id', 'left');
		$this->db->where('ja.applied_by_user_id', $user_id);
		$this->db->order_by('ja.applied_id', 'DESC');
		$query = $this->db->get();
        $response = $query->result();
		/*echo '<pre>';
		print_r($response);
		echo '</pre>';
		*/
	  }else{
		   $response = array('success' => false, 'msg' => 'user id missing');
	  }
	  echo json_encode($response);
	}
	public function get_user_saved_jobs(){
		if($this->input->post('user_id')) {
          $user_id =   $this->input->post('user_id');
	  }else{
		  $data = json_decode(file_get_contents('php://input'));
		  //print_r($data);
		$user_id = $data->user_id;
	  }
	  if(!empty($user_id)){
		$this->db->select('sj.*, u.*, j.*');
		$this->db->from(' save_jobs sj');
		$this->db->join('users u', 'u.id = sj.save_by_user_id', 'left');
		$this->db->join('jobs j', 'j.id = sj.saved_job_id', 'left');
		$this->db->where('sj.save_by_user_id', $user_id);
		$this->db->order_by('sj.save_id', 'DESC');
		$query = $this->db->get();
		$response = $query->result();
		/*echo '<pre>';
		print_r($response);
		echo '</pre>';
		*/
		
	  }else{
		   $response = array('success' => false, 'msg' => 'user id missing');
	  }
	  echo json_encode($response);
	}
	public function get_candidate_list(){
		$this->db->from('users_candidate_details uc');
		$this->db->join('users u', "u.id = uc.userid", 'left');
        $this->db->join("users_groups ug", "ug.user_id = u.id", 'left');
        $this->db->join("groups g", "g.id = ug.group_id", 'left');
		$this->db->where("g.name LIKE ('candidate')");
		$query = $this->db->get();
		$response = $query->result();
		/*echo '<pre>';
		print_r($response);
		echo '</pre>';
		*/
		echo json_encode($response);
		
	}
	public function get_candidate_details(){
		if($this->input->post('candidate_id')) {
          $candidate_id =   $this->input->post('candidate_id');
	  }else{
		  $data = json_decode(file_get_contents('php://input'));
		  $candidate_id = $data->candidate_id;
	  }
	  if(!empty($candidate_id)){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('users_candidate_details', 'users.id= users_candidate_details.userid');
		$this->db->where('users.id', $candidate_id);
		$response = $this->db->get()->result();
		if(empty($response)){
		$response = array('success' => false, 'msg' => 'No records found');
		}
	  }else{
		  $response = array('success' => false, 'msg' => 'Candidate id missing');
	  }
	  echo json_encode($response);
	}
  public function get_user_favourite(){
	  if($this->input->post('user_id')) {
          $user_id =   $this->input->post('user_id');
	  }else{
		  $data = json_decode(file_get_contents('php://input'));
		  //print_r($data);
		$user_id = $data->user_id;
	  }
	  if(!empty($user_id)){
		$this->db->select('mf.*, p.name product_name, p.regular_price, p.filename'); // my_favorites information 
        $this->db->from('my_favorites mf');
        $this->db->join('products p', 'mf.product_id = p.id', 'left');
        $this->db->where('mf.added_by_user_id', $user_id);
		$query = $this->db->get();
        $response = $query->result();
		
	  }else{
		  $response = array('success' => false, 'msg' => 'user id missing');
	  }
	  echo json_encode($response);
  }
  public function get_user_submitted_request(){
	  if($this->input->post('user_id')) {
          $user_id =   $this->input->post('user_id');
	  }else{
		  $data = json_decode(file_get_contents('php://input'));
		  $user_id = $data->user_id;
	  }
	  if(!empty($user_id)){
	  $this->db->select('p.name product_name, pr.*');
      $this->db->select('u.first_name seller_f_name, u.last_name seller_l_name');
      $this->db->from('purchase_request pr');
      $this->db->join('products p', 'p.id = pr.product_id');
      $this->db->join('users u', 'u.id = p.user_id');
      $this->db->where('pr.buyer_id', $user_id);
      $this->db->order_by('pr.purchase_request_id', 'DESC');
	  $query = $this->db->get();
	  $response = $query->result();
	  
	  }else{
		  $response = array('success' => false, 'msg' => 'user id missing');
		 
	  }
	  echo json_encode($response);
  }
 
 public function get_user_installer_request(){
	  if($this->input->post('user_id')) {
          $user_id =   $this->input->post('user_id');
	  }else{
		  $data = json_decode(file_get_contents('php://input'));
		  $user_id = $data->user_id;
	  }
	  if(!empty($user_id)){
	  $this->db->select('ir.*, u.first_name, u.last_name')->from('installer_request ir');
      $this->db->join('installer_request_map irm', 'irm.request_id = ir.installer_request_id', 'left');
      $this->db->join('users u', 'u.id = ir.user_id', 'left');
      $this->db->where("irm.installer_id",$user_id);
      $this->db->order_by('ir.installer_request_id', 'DESC');
	  $query = $this->db->get();
	  echo $this->db->last_query();
	  $response = $query->result();
	  
	  }else{
		  $response = array('success' => false, 'msg' => 'user id missing');
	  }
	  echo json_encode($response);
  }
  	public function get_user_designer_submitted_request(){
		if($this->input->post('user_id')) {
			$user_id =   $this->input->post('user_id');
		}else{
			$data = json_decode(file_get_contents('php://input'));
			$user_id = $data->user_id;
		}
		if(!empty($user_id)){
			$response = $this->db->select('*')->from('designer_request')->where(array('user_id'=>$user_id))->get()->result();
			
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		echo json_encode($response);
	}
	public function get_user_designer_incoming_request(){
		if($this->input->post('user_id')) {
			$user_id =   $this->input->post('user_id');
		}else{
			$data = json_decode(file_get_contents('php://input'));
			$user_id = $data->user_id;
		}
		if(!empty($user_id)){
			$this->db->select('dr.*, u.first_name, u.last_name')->from('designer_request dr');
			$this->db->join('designer_request_user dru', 'dru.request_id = dr.id', 'left');
			$this->db->join('users u', 'u.id = dr.user_id', 'left');
			$this->db->where("dru.designer_id",$user_id);
			$this->db->order_by('dr.id', 'DESC');
			$query = $this->db->get();
			//echo $this->db->last_query();
			$response = $query->result();
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		echo json_encode($response);
	}
	public function get_user_message_request(){
		if($this->input->post('user_id')) {
			$useId =   $this->input->post('user_id');
		}else{
			$data = json_decode(file_get_contents('php://input'));
			$useId = $data->user_id;
		}
		if(!empty($useId)){
			//$wherUserName = ($userName == '') ? "" : " AND (u_to.first_name LIKE '%$userName%' OR u_from.first_name LIKE '%$userName%')";
			$wherUserName = "";
			$ls_sql = "SELECT mc.*,u_to.first_name to_f_name, CONCAT(u_to.first_name, ' ', u_to.last_name) to_username, u_to.filename to_filename, "
			. "u_from.first_name from_f_name, CONCAT(u_from.first_name, ' ', u_from.last_name) from_username, u_from.filename from_filename, p.name product_name "
			. "FROM message_chatting mc "
			. "LEFT JOIN users u_to ON u_to.id = mc.send_to "
			. "LEFT JOIN users u_from ON u_from.id = mc.send_from "
			. "LEFT JOIN products p ON p.id = mc.product_id "
			. "WHERE (mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_to = $useId AND mc1.product_id != 0 GROUP BY mc1.send_to, mc1.send_from, mc1.product_id) OR "
			. "       mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_from = $useId AND mc1.product_id != 0 GROUP BY mc1.send_from, mc1.send_to, mc1.product_id)) "
			. "  OR  (mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_to = $useId AND mc1.purchase_id != 0 GROUP BY mc1.send_to, mc1.send_from, mc1.purchase_id) OR "
			. "       mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_from = $useId AND mc1.purchase_id != 0 GROUP BY mc1.send_from, mc1.send_to, mc1.purchase_id)) "
			."   OR  (mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_to = $useId GROUP BY mc1.send_to, mc1.send_from) OR "
			. "       mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_from = $useId  GROUP BY mc1.send_from, mc1.send_to)) "
			. " $wherUserName GROUP BY mc.send_to, mc.send_from, mc.product_id "
			. "ORDER BY mc.mc_id DESC ";
			$response = $this->db->query($ls_sql)->result();
			/*echo '<pre>';
			print_r($response);
			echo '</pre>';
			*/
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		echo json_encode($response);
	}
	//////////////////////////////
	public function get_user_single_installer_request_details(){
		//$request_id = $this->input->post('request_id');
		if($this->input->post('request_id')) {
			$request_id =   $this->input->post('request_id');
		}else{
			$data = json_decode(file_get_contents('php://input'));
			$request_id = $data->request_id;
		}
		$this->db->select('*')->from('installer_request');
        $this->db->where(array("installer_request_id" =>$request_id));
        $la_requestData = $this->db->get()->result();
		//$val = ($key == 'status') ? (($val == 'A') ? "Active" : "Archived") : $val;
		if(count($la_requestData)>0){
			$response=$la_requestData;
			/*echo '<pre>';
			print_r($response);
			*/
			$val = ($response[0]->status == 'A') ? "Active" : "Archived" ;
			$response[0]->status=$val;
			$this->db->select('irm.*, u.first_name, u.last_name')->from('installer_request_map irm');
                $this->db->join('users u', 'u.id = irm.installer_id', 'left');
                $this->db->where("irm.request_id = $request_id");
                $la_reqUserData = $this->db->get()->result();
                $response[0]->la_reqUserData = $la_reqUserData;
				/*echo '<pre>';
				print_r($response);
				*/

		}else{
		    $response = array('success' => false, 'msg' => 'No records');
		}
		echo json_encode($response);
	}
	public function get_user_single_designer_request_details(){
		//$request_id = $this->input->post('request_id');
		if($this->input->post('request_id')) {
			$request_id =   $this->input->post('request_id');
		}else{
			$data = json_decode(file_get_contents('php://input'));
			$request_id = $data->request_id;
		}
		$this->db->select('*')->from('designer_request');
        $this->db->where(array("id" =>$request_id));
        $la_requestData = $this->db->get()->result();
		//$val = ($key == 'status') ? (($val == 'A') ? "Active" : "Archived") : $val;
		if(count($la_requestData)>0){
			$response=$la_requestData;
			/*echo '<pre>';
			print_r($response);
			*/
			$val = ($response[0]->status == 'A') ? "Active" : "Archived" ;
			$response[0]->status=$val;
			$this->db->select('irm.*, u.first_name, u.last_name')->from('installer_request_map irm');
                $this->db->join('users u', 'u.id = irm.installer_id', 'left');
                $this->db->where("irm.request_id = $request_id");
                $la_reqUserData = $this->db->get()->result();
                $response[0]->la_reqUserData = $la_reqUserData;
				
				$this->db->select('arq.*')->from('designer_area_required arq');
				$this->db->join('designer_request_area_map amp', 'amp.designer_area_id = arq.designer_area_id', 'left');
				$this->db->where("amp.request_id = $request_id");
				$this->db->where("arq.status = 'A'");
				$la_areaData = $this->db->get()->result();
				$response[0]->la_areaData = $la_areaData;
				
				$this->db->select('dra.*, u.first_name, u.last_name')->from('designer_request_user dra');
                $this->db->join('users u', 'u.id = dra.designer_id', 'left');
                $this->db->where("dra.request_id = $request_id");
                $la_reqUserData = $this->db->get()->result();
                $response[0]->la_reqUserData = $la_reqUserData;

		}else{
		    $response = array('success' => false, 'msg' => 'No records');
		}
		echo json_encode($response);
	}
	public function get_user_purchase_requests(){
		if($this->input->post('user_id')) {
			$user_id =   $this->input->post('user_id');
		}else{
			$data = json_decode(file_get_contents('php://input'));
			$user_id = $data->user_id;
		}
		if(!empty($user_id)){
		$this->db->select('p.name product_name, p.regular_price, pr.*');
        $this->db->from('purchase_request pr');
        $this->db->join('products p', 'p.id = pr.product_id');
        $this->db->where('p.user_id', $user_id);
        $query = $this->db->get();
        $response = $query->result();
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		//echo '<pre>';
		//print_r($response);
		echo json_encode($response);
	}
	public function get_user_subscription_charges(){
		if($this->input->post('user_id')) {
			$user_id =   $this->input->post('user_id');
		}else{
			$data = json_decode(file_get_contents('php://input'));
			$user_id = $data->user_id;
		}
		if(!empty($user_id)){
			$this->db->select('sfb.*');
			$this->db->from('subscription_for_boost sfb');
			$this->db->where('sfb.user_id', $user_id);
			$this->db->order_by('sfb.subscription_for_boost_id', 'DESC');
	
			if (!empty($limit)) {
				$this->db->limit($limit['limit'], $limit['offset']);
			}
			$query = $this->db->get();
			$response = $query->result();
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		//echo '<pre>';
		//print_r($response);
		echo json_encode($response);
	}
	public function get_user_single_subscription_details(){
		if($this->input->post('boost_id')) {
			$boost_id =   $this->input->post('boost_id');
		}else{
			$data = json_decode(file_get_contents('php://input'));
			$boost_id = $data->boost_id;
		}
		if(!empty($boost_id)){
		$this->db->select('sfb.*, bp_cat.cat_name');
        $this->db->from('subscription_for_boost sfb');
        $this->db->join('boost_product_charges bpc', 'bpc.boost_id = sfb.subscription_id');
        $this->db->join('boost_product_category bp_cat', 'bp_cat.cat_id = bpc.boost_cat_id');
        $this->db->where('sfb.subscription_for_boost_id', $boost_id);
        $this->db->order_by('sfb.subscription_for_boost_id', 'DESC');

        $query = $this->db->get();
        $response = $query->result();
		}else{
			$response = array('success' => false, 'msg' => 'Prameter missing');
		}
		echo json_encode($response);
	}

	public function userdetails(){
		$userType = $this->uri->segment(2);
        $installerId = $this->uri->segment(3);
		$userId = $this->uri->segment(4);
		$my_favorites = [];
        if ($userId  != '')) {
            $loggedUserId = $userId ;
            $my_favorites = $this->users_model->getData('favorites_user', ['added_by_user_id' => $loggedUserId, 'user_id' => $installerId]);
			print_r($my_favorites);
			exit;


            if (!empty($my_favorites)) {
                $my_favorites = $my_favorites[0];
            }
        }
		$lo_installerDetail = $this->users_model->getUserListById($installerId);
		$user_location = [];
        $user_business = [];
		$lo_installerDetail = $lo_installerDetail[0];
        $user_business = $this->users_model->single_designer_business($lo_installerDetail->id, 'designer');

		$response['success'] = true;
		$response['lo_installerDetail'] = $lo_installerDetail;
		$response['user_business'] = $user_business;
		$response['my_favorites'] = $my_favorites;
		echo json_encode($response);
	}

	public function add_favorite_user(){
		$data = json_decode(file_get_contents('php://input'), true);
		 $la_post['added_by_user_id'] = $data['userId'];
         $la_post['user_id'] = $data['installerId'];
         $la_post['added_datetime'] = date('Y-m-d H:i:s');

		  $favorites = $this->users_model->getData('favorites_user', ['added_by_user_id' => $data['userId'], 'user_id' => $data['installerId']]);
		         if (empty($favorites)) {
                $insertId = $this->users_model->insertData('favorites_user', $la_post);
                if ($insertId) {
                   $response['success'] = true;
                   $response['msg'] = 'Added to your favorites';
                }
            } else {
                $return = $this->users_model->deleteData('favorites_user', ['added_by_user_id' => $data['userId'], 'user_id' => $data['installerId']]);
                if ($return) {
                    $response['success'] = true;
                    $response['msg'] = 'Remove from your favorites';
                }
            }
			  echo json_encode($response);
	}


	}
?>