    <?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Products extends BaseController {
		public function __construct() {
			parent::__construct();
			// $this->load->library('facebook');
            $this->load->model('Users_model');
            $this->load->model('Product_model');
			$this->load->model('Login_model');
           
		}

            public function getallproducts(){
                $catid = $this->uri->segment(2);
                $orderBy['orderBy'] = 'p.is_boost';
                $orderBy['type'] = 'DESC';
                $currentPage = 1;
                if (isset($_GET['pg']) && ($_GET['pg'] > 0)) {
                    $currentPage = $_GET['pg'];
                }
                $limit['limit'] = ITEM_PRODACT_LG;
                $limit['offset'] = (($currentPage - 1 ) * ITEM_PRODACT_LG);
                $la_all_products = $this->Product_model->getProductList($catid, 0, $limit, '', '', '', $orderBy);
                echo json_encode($la_all_products);
        
            }

            public function product_details() {
              
                $productId = $this->uri->segment(2);
                $userId = $this->uri->segment(3);
                $product = $this->Product_model->single_product($productId);
                $product_location = $this->Product_model->single_product_location($productId);
                $my_favorites = $this->Product_model->my_favorites($productId, $userId);
                if (!empty($my_favorites)) {
                    $my_favorites = $my_favorites[0];
                }
                $la_proMoreImg = $this->Users_model->getData('product_images', array('product_id' => $productId));
				$userData =  $this->Users_model->getData('users', array('id' => $userId));
                $la_sellerReview = $this->Product_model->get_seller_review($productId);
        
        //        print_r($product_location);die;
        
              

                $response['prodData'] = $product[0];
				$response['user'] = $userData;
                $response['product_location'] = $product_location;
                $response['my_favorites'] = $my_favorites;
                $response['la_proMoreImg'] = $la_proMoreImg;
                $response['la_sellerReview'] = $la_sellerReview;
                $response['success'] = true;

                echo json_encode($response);

            }

		public function addfavorite(){
			$data = json_decode(file_get_contents('php://input'), true);
            $la_post['added_by_user_id'] = $data['userId'];
            $la_post['product_id'] = $data['productId'];
            $la_post['added_datetime'] = date('Y-m-d H:i:s');

            $favorites = $this->Users_model->getData('my_favorites', ['added_by_user_id' => $data['userId'], 'product_id' => $data['productId']]);
            if (empty($favorites)) {
                $insertId = $this->Users_model->insertData('my_favorites', $la_post);
                if ($insertId) {
                    $response['success'] = true;
                    $response['msg'] = 'Added to your favorites';
                }
            } else {
                $return = $this->Users_model->deleteData('my_favorites', ['added_by_user_id' => $data['userId'], 'product_id' => $data['productId']]);
                if ($return) {
                    $response['success'] = true;
                    $response['msg'] = 'Remove from your favorites';
                }
            }
       

        echo json_encode($response);
		}

	public function send_purchase_request(){
		$data = json_decode(file_get_contents('php://input'), true);
		$la_post['product_id'] = $data['productId'];
		$la_post['buyer_id'] = $data['buyerid'];
		$la_post['price'] = $data['regularPrice'];
		$la_post['submitted_name'] = $data['name'];
		$la_post['submitted_phone'] = $data['phone'];
		$la_post['submitted_address'] = $data['address'];
		$la_post['message'] = $data['message'];
		$la_post['created_on'] = date('Y-m-d H:i:s');
		$la_post['last_update'] = date('Y-m-d H:i:s');
		$la_post['status'] = 'pending';
//  

		$insertId = $this->Users_model->insertData('purchase_request', $la_post);
		if ($insertId) {

			$la_notification = [
				'notification_for_user' => $data['sellerId'],
				'notification_by_user' => $data['buyerid'],
				'notification_type' => 'purchase_request',
				'act_id' => $insertId,
				'notification_title' => 'Purchase request',
				'notification_body' => $data['name'] . " send a purchase request",
			];
			$this->Login_model->save_notification($la_notification);

//========================= START:: Send mail to seller =================================//
			$sellerData = $this->Users_model->getData('users', array('id' => $data['sellerId']), 'email, first_name');
			$sellerEmail = $sellerData[0]->email;
			$sellerName = $sellerData[0]->first_name;
			$body = "Please check below purchase request details. <br><br>"
					. "Name: " . $data['name'] . " <br>"
					. "Phone: " . $data['phone'] . " <br>"
					. "Address: " . $data['address'] . " <br>"
					. "Message: " . $data['message'] . " <br>";
			$mailDataArr = [
				'username' => $sellerName,
				'body' => $body,
			];

			$mailBody = $this->load->view('frontend/email/common_format.php', $mailDataArr, TRUE);
			$this->Login_model->send_mail($sellerEmail, "Submitted purchase request", $mailBody);
//========================== END:: Send mail to seller =================================//

			$response['success'] = true;
			$response['msg'] = 'Request Successfully Send';
		}
		
        
        echo json_encode($response);
 
	}


	public function message_to_seller(){

		$data = json_decode(file_get_contents('php://input'), true);
		$productId =$data['productId'];
		$sellerId = $data['sellerId'];
		$la_post['send_to'] = $sellerId;  // seller id
		$la_post['send_from'] = $data['userId']; // buyer_id
		$la_post['product_id'] = $productId;
		$la_post['subject'] = $data['subject'];
		$la_post['message'] = $data['subjectmessage'];
		$la_post['created_on'] = date('Y-m-d H:i:s');
		$la_post['updated_on'] = date('Y-m-d H:i:s');
		$la_post['ip'] = get_client_ip();

//            print_r($mailBody);
//            die;
		$insertId = $this->Users_model->insertData('message_chatting', $la_post);
		if ($insertId) {

			$la_notification = [
				'notification_for_user' => $sellerId,
				'notification_by_user' => $data['userId'],
				'notification_type' => 'message',
				'act_id' => $insertId,
				'notification_title' => 'Message from product page',
				'notification_body' => $data['subject'] . " send a message",
			];
			$this->Login_model->save_notification($la_notification);

			$response['success'] = true;
			$response['msg'] = 'Message Submitted successfully';
		}
            
        
        echo json_encode($response);
	}


	public function get_product_list(){
		$limit['limit'] = $this->uri->segment(2);
		$currentpage = $this->uri->segment(3);
		$limit['offset'] = (($currentpage - 1 ) * $limit['limit']);
		$orderBy['orderBy'] = 'p.is_boost';
        $orderBy['type'] = 'DESC';
		$catid = '';
		$la_all_products = $this->Product_model->getProductList($catid, 0, $limit, '', '', '', $orderBy);
        echo json_encode($la_all_products);
	}

	public function addinstallerrequest(){
		$data = json_decode(file_get_contents('php://input'), true);
		$this->form_validation->set_rules('loading_dock_available', 'loading_dock_available', 'required');
        $this->form_validation->set_rules('delivery_site', 'delivery_site', 'required');
        $this->form_validation->set_rules('restricted_hours', 'restricted_hours', 'required');
        $this->form_validation->set_rules('receiving_hours', 'receiving_hours', 'required');
        $this->form_validation->set_rules('customer_to_remove', 'customer_to_remove', 'required');
        $this->form_validation->set_rules('installer_to_remove', 'installer_to_remove', 'required');
        $this->form_validation->set_rules('dumpster_provided_by_customer', 'dumpster_provided_by_customer', 'required');
        $this->form_validation->set_rules('single_phase_installation', 'single_phase_installation', 'required');
        $this->form_validation->set_rules('multiple_phase_installation', 'multiple_phase_installation', 'required');
//        $this->form_validation->set_rules('multiple_phase_installation_desc', 'multiple_phase_installation_desc', 'required');
        $this->form_validation->set_rules('anchor_product', 'anchor_product', 'required');
//        $this->form_validation->set_rules('anchor_product_desc', 'anchor_product_desc', 'required');
        $this->form_validation->set_rules('insurance_cert', 'insurance_cert', 'required');
//        $this->form_validation->set_rules('insurance_cert_desc', 'insurance_cert_desc', 'required');
        $this->form_validation->set_rules('delivery_made_floor', 'delivery_made_floor', 'required');
        $this->form_validation->set_rules('delivery_made_floor_type', 'delivery_made_floor_type', 'required');
        $this->form_validation->set_rules('access_to_freight', 'access_to_freight', 'required');
        $this->form_validation->set_rules('access_to_passenger', 'access_to_passenger', 'required');
        $this->form_validation->set_rules('non_union_labor', 'non_union_labor', 'required');
        $this->form_validation->set_rules('union_labor', 'union_labor', 'required');
        $this->form_validation->set_rules('security_clearance', 'security_clearance', 'required');
//        $this->form_validation->set_rules('additional_info_desc', 'additional_info_desc', 'required');
        $this->form_validation->set_rules('wall_receptacle', 'wall_receptacle', 'required');
        $this->form_validation->set_rules('floor_receptacle', 'floor_receptacle', 'required');
        $this->form_validation->set_rules('ceiling', 'ceiling', 'required');
//        $this->form_validation->set_rules('additional_info_desc_celling', 'additional_info_desc_celling', 'required');
        $this->form_validation->set_rules('comments_message', 'comments_message', 'required');
		 if ($this->form_validation->run() == FALSE) {
            $response['msg'] = "Please fill all fields!";
            $response['msg1'] = str_replace(["<p>"], " ", validation_errors());
            $response['msg1'] = str_replace(["</p>"], "<br>", $response['msg1']);
        }
		$la_post = $data;
		$la_post['ip'] = get_client_ip();
		$la_post['status'] = 'A';
		$la_post['create_datetime'] = date('Y-m-d H:i:s');
		$insertId = $this->Users_model->insertData('installer_request', $la_post);
		if ($insertId > 0) {
			$response['success'] = true;
			$response['msg'] = 'Please complete the next step';
			$response['id'] = $insertId;
		}
		 echo json_encode($response);

	}

	public function adddesignerrequest(){
		$data = json_decode(file_get_contents('php://input'), true);
		$this->form_validation->set_rules('request_type', 'request type', 'required');
        $this->form_validation->set_rules('space_planning_needed', 'space planning needed', 'required');
        $this->form_validation->set_rules('space_size', 'space size', 'required');
        $this->form_validation->set_rules('project_scope', 'project scope', 'required');
        $this->form_validation->set_rules('acheive_space', 'acheive space', 'required');
        $this->form_validation->set_rules('style_preference', 'style preference', 'required');
        $this->form_validation->set_rules('technology_requirement', 'technology requirement', 'required');
        $this->form_validation->set_rules('construction_involved', 'construction involved', 'required');
        $this->form_validation->set_rules('time_frame', 'time frame', 'required');
//        $this->form_validation->set_rules('area_required', 'area required', 'required');
        $this->form_validation->set_rules('message', 'message', 'required');

		if (isset($data['area_required']) && count($data['area_required']) > 0) {
            
        } else {
            $response = array('success' => false, 'data' => $_POST, 'msg' => 'Please add Check off areas!');
            echo json_encode($response);
            exit();
        }

			$post_data['request_type'] = $data['request_type'];
			$post_data['user_id'] = $data['user_id'];
			$post_data['space_planning_needed'] = $data['space_planning_needed'];
			$post_data['space_size'] = $data['space_size'];
			$post_data['project_scope'] =  $data['project_scope'];
			$post_data['acheive_space'] = $data['acheive_space'];
			$post_data['style_preference'] = $data['style_preference'];
			$post_data['technology_requirement'] = $data['technology_requirement'];
			$post_data['construction_involved'] = $data['construction_involved'];
			$post_data['time_frame'] = $data['time_frame'];
			$post_data['message'] = $data['message'];
			$post_data['created_on'] = date("Y-m-d H:i:s");
			$insertId = $this->Users_model->insertData('designer_request', $post_data);
			if ($insertId > 0) {
			if (isset($data['area_required']) && count($data['area_required']) > 0) {
				foreach ($data['area_required'] as $data_id) {
					$this->Users_model->insertData('designer_request_area_map', ['designer_area_id' => $data_id, 'request_id' => $insertId]);
				}
			}
//                    if (isset($_POST['collaboration']) && count($_POST['collaboration']) > 0) {
//                        foreach ($_POST['collaboration'] as $data_id) {
//                            $this->Users_model->insertData('designer_collaboration_map', ['collaboration_id' => $data_id, 'request_id' => $insertId]);
//                        }
//                    }

			$response['success'] = true;
			$response['msg'] = 'Please complete the next step';
			$response['id'] = $insertId;
		}else{
			$response['success'] = false;
			$response['msg'] = 'Something Went Wrong, Please Check';
		}
		echo json_encode($response);
        
	}

	public function getinstallerlist(){
		$limit['limit'] = $this->uri->segment(2);
		$currentpage = $this->uri->segment(3);
		$limit['offset'] = (($currentpage - 1 ) * $limit['limit']);
		$loggdId = $this->uri->segment(4);
		$location_id = "";

		$totalinstaller_count = $this->Users_model->getUsersByUserType_count("'installer'", $loggdId);
		$la_installerData = $this->Users_model->getUsersByUserType("'installer'", $loggdId, $limit, '', '', '', $location_id);
		$response['success'] = true;
		$response['installer_count'] = $totalinstaller_count;
		$response['installer_data'] = $la_installerData;
		echo json_encode($response);
	}


	public function getdesignerlist(){
		$limit['limit'] = $this->uri->segment(2);
		$currentpage = $this->uri->segment(3);
		$limit['offset'] = (($currentpage - 1 ) * $limit['limit']);
		$loggdId = $this->uri->segment(4);
		$location_id = "";
		$la_desingerData_count = $this->Users_model->getUsersByUserType_count("'designer'", $loggdId);
		$la_designerData = $this->Users_model->getUsersByUserType("'designer'", $loggdId, $limit);
        $la_designerArea = $this->Users_model->getData('designer_area_required', ['status' => 'A']);
		$response['success'] = true;
		$response['li_designerDataCount'] = $la_desingerData_count->user_count;
		$response['desinger_data'] = $la_designerData;
		$response['la_designerArea'] = $la_designerArea;
		echo json_encode($response);

	}


	public function getjobsearchlist(){
		$limit['limit'] = $this->uri->segment(2);
		$currentpage = $this->uri->segment(3);
		$limit['offset'] = (($currentpage - 1 ) * $limit['limit']);
		$loggdId = $this->uri->segment(4);
		$location_id = "";
		$la_jobs_count = $this->Users_model->getUsersByUserType_count("'employer'", $loggdId);
		$la_jobsData = $this->Users_model->getjobbyuserType( $loggdId, $limit,'','','');

		$response['success'] = true;
		$response['li_jobsDataCount'] = $la_jobs_count;
		$response['la_jobsData'] = $la_jobsData;
		echo json_encode($response);
	}

	public function job_details() {
              
		$jobId = $this->uri->segment(2);
		$userId = $this->uri->segment(3);
		$jobDetails = $this->Users_model->get_job_details($jobId);
		$get_applied = $this->Users_model->applied_jobs($jobId,$userId);
		$get_saved = $this->Users_model->saved_jobs($jobId,$userId);

		$response['applied_jobs'] = $get_applied;
		$response['saved_jobs'] = $get_saved;
		$response['la_jobData'] = $jobDetails[0];
		$response['success'] = true;

		echo json_encode($response);

	}


	public function save_job(){
		$data = json_decode(file_get_contents('php://input'), true);
		$jobId = $data['jobId'];
		$userId = $data['userId'];

		$la_post['save_by_user_id'] = $userId;
		$la_post['saved_job_id'] = $jobId;
		$la_post['saved_date'] = date('Y-m-d H:i:s');

		$favorites = $this->Users_model->getData('save_jobs', ['save_by_user_id' => $userId, '	saved_job_id' => $jobId]);
		if (empty($favorites)) {
			$insertId = $this->Users_model->insertData('save_jobs', $la_post);
			if ($insertId) {
				$response['success'] = true;
				$response['text'] = "Remove";
				$response['flag'] = "add";
				$response['msg'] = 'Added to your Savelist';
			}
		} else {
			$return = $this->Users_model->deleteData('save_jobs', ['save_by_user_id' => $userId, 'saved_job_id' => $jobId]);
			if ($return) {
				$response['success'] = true;
				$response['text'] = "Save This Job";
				$response['flag'] = "remove";
				$response['msg'] = 'Remove from Savelist';
			}
		}
		echo json_encode($response);
	}


	public function apply_job(){
		$data = json_decode(file_get_contents('php://input'), true);
		$jobId = $data['jobId'];
		$userId = $data['userId'];

		$la_post['applied_by_user_id'] = $userId;
        $la_post['applied_in_job_id'] = $jobId;
        $la_post['applied_date'] = date('Y-m-d H:i:s');

		$favorites = $this->Users_model->getData('job_applied', ['applied_by_user_id' => $userId, 'applied_in_job_id' => $jobId]);
		 if (empty($favorites)) {
			$insertId = $this->Users_model->insertData('job_applied', $la_post);
			if ($insertId) {
				$response['success'] = true;
				$response['text'] = "Already Aplied";
				$response['flag'] = "add";
				$response['msg'] = 'Job Applied Successfully';
			}
		} else {
			$return = $this->Users_model->deleteData('job_applied', ['applied_by_user_id' => $userId, 'applied_in_job_id' => $jobId]);
			if ($return) {
				$response['success'] = true;
				$response['text'] = "Apply";
				$response['flag'] = "remove";
				$response['msg'] = 'Successfully Remove From List';
			}
		}
		echo json_encode($response);
	}

	public function getcandidatesearchlist(){
		$limit['limit'] = $this->uri->segment(2);
		$currentpage = $this->uri->segment(3);
		$limit['offset'] = (($currentpage - 1 ) * $limit['limit']);
		$loggdId = $this->uri->segment(4);
		$la_usersData_count = $this->Users_model->getUsersByUserType_count("'candidate'", $loggdId);
		$la_usersData = $this->Users_model->getusersType("'candidate'", $loggdId, $limit,'','','');
		$response['success'] = true;
		$response['li_candidateDataCount'] = $la_usersData_count;
		$response['la_candidateData'] = $la_usersData;
		echo json_encode($response);
	}

	public function candidate_details(){
		$candidateId = $this->uri->segment(2);
		$userId = $this->uri->segment(3);
		$user = $this->Users_model->single_user($candidateId);
		$get_favorite = $this->Users_model->get_favorite_list($candidateId,$userId);
		$response['fav_candidate'] = $get_favorite;
		$response['la_candidateData'] = $user[0];
		$response['success'] = true;

		echo json_encode($response);
	}

	public function message_to_candidate(){
		$data = json_decode(file_get_contents('php://input'), true);
		$candidateId = $data['candidateId'];
		$emplyrId = $data['userId'];

		$la_post['send_to'] = $candidateId;  // seller id
		$la_post['send_from'] = $emplyrId; // buyer_id
		$la_post['subject'] = $data['subject'];
		$la_post['message'] = $post['subjectmessage'];
		$la_post['created_on'] = date('Y-m-d H:i:s');
		$la_post['updated_on'] = date('Y-m-d H:i:s');
		$la_post['ip'] = get_client_ip();

		$insertId = $this->Users_model->insertData('message_chatting', $la_post);
		if ($insertId) {
			$la_notification = [
				'notification_for_user' => $candidateId,
				'notification_by_user' => $uid,
				'notification_type' => 'message',
				'act_id' => $insertId,
				'notification_title' => 'Message from candidate page',
				'notification_body' => $post['subject'] . " send a message",
			];
			$this->Login_model->save_notification($la_notification);

			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
		}
		echo json_encode($response);
	}


  }
 ?>

