<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class User extends BaseController{
	const MAX_PASSWORD_SIZE_BYTES = 4096;

	public function __construct(){
		parent::__construct(); 
		$this->load->model('Users_model');
		$this->load->library('image_lib');
		$this->hash_method = $this->config->item('hash_method', 'ion_auth');
	}

	public function index () {
		$user = authentication();
		$game_id = 0;

		if ($this->input->post('games')) {
			$game_id = $this->input->post('games');
		}

		$data = array();
		$numbers = $this->getNUmbers(true, $game_id);

		if ($numbers !== false) {
			$games = $this->Users_model->getData('games', array('status' => 1), 'id, name');
			$data['games'] = $games;
		}

		$data['user'] = $user;
		$data['numbers'] = $numbers;
		$this->loadScreen('frontend/user/user_home', $data);
	}

	public function logout () {
		$this->session->set_userdata('user_data', '');
		redirect(base_url());
	}

	public function profile () {
		//exit;
		$user = authentication();
	 	$type = $user['type'];
		//print_r($user);
		//exit;
		if(empty($type)){
			exit;
		}
		if ($user['type'] != 'buyer' && $user['type'] != 'seller') {
			redirect(base_url('login/signin'));
		}

		$uid = ($this->uri->segment(3)) ? $this->uri->segment(3) : $user['id'];

		$user_detail = $this->Users_model->getData('users', array('id' => $uid));

		if (empty($user_detail)) {
			redirect(base_url('user/profile'));
		}

		$fields = array();

		if ($this->input->post('post')) {
			$fields['content'] = $this->input->post('post');
		}

		if (isset($_FILES['file'])) {
			$files = $_FILES['file'];
			$image_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');

			if (in_array($files['type'], $image_types)) {
				$path = 'post/wall_post/';
				$upload_dir = UPLOADDIR . $path;
				if ($_SERVER['HTTP_HOST'] == 'localhost') {
					$path = 'post\\wall_post\\';
					$upload_dir = UPLOADDIR . $path;
				}

				folderCheck($upload_dir);

				$folder_path = $upload_dir . "/";
				$ext_arr = explode('.', $files['name']);

				$config['upload_path'] = $folder_path;
				$config['allowed_types'] = 'jpeg|jpg|png|gif';
				$config['max_size']	= '0';
				$config['max_width'] = '0';
				$config['max_height'] = '0';
				$config['overwrite'] = TRUE;
				$image = 'wall_post_' . time() . '_' . $user['id'] . '.' . end($ext_arr);
				$config['file_name'] = $image;
				$config['orig_name'] = $files['name'];
				$config['image'] = $image;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('file')) {
					$fields['image'] = $image;
				}
			}
		}

		if (!empty($fields)) {
			$fields['user_id'] = $user['id'];
			$fields['created_date'] = time();
			$fields['modified_date'] = time();
			$this->Users_model->insertData('post', $fields);
			$this->session->set_flashdata('msg_success', 'Your post has been successfully submited.');
			redirect(base_url('user/profile'), 'refresh');
		}


		/*
		$post = $this->Users_model->getPost($uid);

		
		$follow_arr = $this->Users_model->getData('follow_business_seller', array('user_id' => $uid, 'follow_by' => $user['id']), 'id');
		$endorse_arr = $this->Users_model->getData('endorse_business', array('user_id' => $uid, 'follow_by' => $user['id']), 'id, status');
		$follow = (!empty($follow_arr)) ? true : false;
		$endorse = (!empty($endorse_arr)) ? $endorse_arr[0] : array();

		$company_detail = $this->Users_model->getData('users_business_details', array('user_id' => $uid));
		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['user_detail'] = $user_detail[0];
		$this->commonData['company_detail'] = (!empty($company_detail)) ? $company_detail[0] : array();
		$this->commonData['post'] = $post;
		$this->commonData['follow'] = $follow;
		$this->commonData['endorse'] = $endorse;
		$this->commonData['css'][] = 'libs/@fancyapps/fancybox/dist/jquery.fancybox.min.css';
		$this->commonData['js'][] = 'libs/@fancyapps/fancybox/dist/jquery.fancybox.min.js';
		$this->commonData['js'][] = 'libs/autosize/dist/autosize.min.js';
		*/
		$this->loadScreen('frontend/user/profile_'.$type);
	}
	
	public function ajaxUpdate () {
		$user = authentication();
		$response = array('success' => false, 'msg' => 'Unable to process');
		$post = $this->input->post();

		if (!isset($post['action']) || $post['action'] == '' || !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
			echo json_encode($response);
			exit;
		}

		$action = $post['action'];

		if ($action == 'post_like') {
			$pid = str_replace('post-', '', $post['pid']);
			$fields = array(
				'user_id' => $user['id'],
				'post_id' => $pid,
				'created_date' => time()
			);
			$this->Users_model->insertData('post_likes', $fields);
			$response['success'] = true;
			$response['msg'] = 'done';
		} else if ($action == 'post_ulike') {
			$pid = str_replace('post-', '', $post['pid']);
			$this->Users_model->deleteData('post_likes', array('user_id' => $user['id'], 'post_id' => $pid));
			$response['success'] = true;
			$response['msg'] = 'done';
		} else if ($action == 'get_comment') {
			$pid = str_replace('post-', '', $post['pid']);
			$comments = $this->Users_model->getComment($pid);
			$output = '';

			if (!empty($comments)) {
				foreach ($comments as $value) {
					$image = FILEPATH . 'img/default/profile-pic-blank.png';
					$image = '<img alt="Image placeholder" class="rounded-circle shadow mr-4" src="' . $image .'" style="width: 64px;">';
					if (!empty($value->filename)) {
						$image = UPLOADPATH . 'user/profile/' . $value->filename;
						$image = '<a href="' . $image . '" class="" data-fancybox>
                  <div class="profile-image-post" style="background-image: url(' . $image . ');"></div></a>';
					}
					$output .= '<div class="media media-comment post-comment-content">
                  ' . $image . '
                  <div class="media-body">
                    <div class="media-comment-bubble left-top">
                      <h6 class="mt-0">' . ucwords($value->first_name . ' ' . $value->last_name) . '</h6>
                      <p class="text-sm lh-160">' . $value->comment . '</p>
                    </div>
                  </div>
                </div>';
				}
			}

			$response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = $output;
		} else if ($action == 'post_comment') {
			$pid = str_replace('post-', '', $post['pid']);
			$comment = $post['comment'];
			$fields = array(
				'user_id' => $user['id'],
				'post_id' => $pid,
				'comment' => $comment,
				'created_date' => time(),
				'modified_date' => time(),
			);
			$this->Users_model->insertData('post_comment', $fields);

			$image = FILEPATH . 'img/default/profile-pic-blank.png';
			$image = '<img alt="Image placeholder" class="rounded-circle shadow mr-4" src="' . $image .'" style="width: 64px;">';

			if (!empty($user['filename'])) {
				$image = UPLOADPATH . 'user/profile/' . $user['filename'];
				$image = '<a href="' . $image . '" class="" data-fancybox>
                  <div class="profile-image-post" style="background-image: url(' . $image . ');"></div>
                </a>';
			}

			$output = '<div class="media media-comment post-comment-content">
	          ' . $image . '
	          <div class="media-body">
	            <div class="media-comment-bubble left-top">
	              <h6 class="mt-0">' . ucwords($user['first_name'] . ' ' . $user['last_name']) . '</h6>
	              <p class="text-sm lh-160">' . $comment . '</p>
	            </div>
	          </div>
	        </div>';

			$response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = $output;
		} else if ($action == 'bfollow') {
			$pid = str_replace('post-', '', $post['pid']);
			$fields = array(
				'follow_by' => $user['id'],
				'user_id' => $pid,
				'created_date' => time()
			);
			$this->Users_model->insertData('follow_business_seller', $fields);
            $fields = array(
				'user_id' => $pid,
				'user_by' => $user['id'],
				'name' => ucwords($user['first_name'] . ' ' . $user['last_name']),
				'type' => 'follow',
				'created_date' => time()
			);
			$this->Users_model->updateData('notification', array('user_id' => $pid, 'user_by' => $user['id'], 'type' => 'follow'), array('status' => 0));
			$this->Users_model->insertData('notification', $fields);

			$response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = '<div class="dropdown-content cnt-drp">
                      <div class="inner-detail">
                        <a href="javascript:void(0)" class="unfollow">Unfollow</a>
                      </div>
                    </div>';
		} else if ($action == 'bunfollow') {
			$pid = str_replace('post-', '', $post['pid']);
			$this->Users_model->deleteData('follow_business_seller', array('user_id' => $pid, 'follow_by' => $user['id']));
			$response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = '';
		} else if ($action == 'bendorse') {
			$pid = str_replace('post-', '', $post['pid']);
			$status = 1;
			$msg = 'You have successfully endorse.';
			$endorse_user = $this->Users_model->getData('users_business_details', array('user_id' => $pid), 'endorse');
			$endorse_request = $this->Users_model->getData('endorse_business', array('user_id' => $pid, 'follow_by' => $user['id']), 'id');

			if (empty($endorse_request)) {
				$data = '<div class="dropdown-content cnt-drp">
	                      <div class="inner-detail">
	                        <a href="javascript:void(0)" class="unendorse">Unendorse</a>
	                      </div>
	                    </div>';
	                    $request = true;
				if (!empty($endorse_user)) {
					if ($endorse_user[0]->endorse == 'manual') {
						$status = 0;
						$msg = 'Your endorse request has submited';
						$data = '';
						$request = false;
					}
				}
				$fields = array(
					'follow_by' => $user['id'],
					'user_id' => $pid,
					'status' => $status,
					'created_date' => time()
				);
				$this->Users_model->insertData('endorse_business', $fields);
				$fields = array(
					'user_id' => $pid,
					'user_by' => $user['id'],
					'name' => ucwords($user['first_name'] . ' ' . $user['last_name']),
					'type' => 'endorse',
					'created_date' => time()
				);
				$this->Users_model->updateData('notification', array('user_id' => $pid, 'user_by' => $user['id'], 'type' => 'endorse'), array('status' => 0));
				$this->Users_model->insertData('notification', $fields);
				$response['success'] = true;
				$response['msg'] = $msg;
				$response['data'] = $data;
				$response['endorse'] = $request;
            }
		} else if ($action == 'bunendorse') {
			$pid = str_replace('post-', '', $post['pid']);
			$this->Users_model->deleteData('endorse_business', array('user_id' => $pid, 'follow_by' => $user['id']));
			$response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = '';
		} else if ($action == 'get_product_cat') {
			$pid = str_replace('post-', '', $post['pid']);
			$endorse = $this->Users_model->getData('endorse_business', array('user_id' => $pid, 'follow_by' => $user['id']), 'id, status');

			if (!empty($endorse)) {
				if ($endorse[0]->status == 1) {
					$this->load->model('Product_model');
					$product_category = $this->Product_model->getProductCategories('b2b_category', $pid);
					$output = '';
					if (!empty($product_category)) {
						foreach ($product_category as $value) {
							$image = FILEPATH . 'img/default/no-image.png';
							if (!empty($value->filename) && file_exists(UPLOADDIR . 'products/product_categories/thumb/' . $value->filename)) {
								$image = UPLOADPATH . 'products/product_categories/thumb/' . $value->filename;
							}
							$output .= '<div class="col-xl-3 col-lg-4 col-sm-6">
		            <div class="card card-product">
		              <div class="card-image">
		                <a href="' . base_url('products/business_products/' . $pid . '/' . $value->slug) . '">
		                  <img alt="Image placeholder" src="' . $image . '" class="img-center img-fluid">
		                </a>
		              </div>
		              <div class="card-body text-center pt-0">
		                <h6><a href="' . base_url('products/business_products/' . $pid . '/' . $value->slug) . '">' . $value->name . '</a></h6>
		              </div>
		            </div>
		          </div>';
						}
						$output = '<div class="row">' . $output . '</div>';
					}
				} else {
					$output = '<div class="row">Endorsement is pending approval.</div>';
				}
			} else {
					$output = '<div class="row">Please endorse first.</div>';
				}
			$response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = $output;
		} else if ($action == 'get_cities') {
			$cities = $this->Users_model->getData('cities', array('state_id' => $post['val']), 'id, name');
			$response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = $cities;
		} else if ($action == 'message_post') {
			$uid = str_replace('mu-', '', $post['muid']);
			$images = array();
			$file_output = '';

			if (isset($_FILES['ufile'])) {
				$files = $_FILES['ufile'];
				$files_total = count($files['name']);

				$path = 'messages/';
				$thumb_path = 'thumb/';
				$upload_dir = UPLOADDIR . $path;

				if ($_SERVER['HTTP_HOST'] == 'localhost') {
					$path = 'messages\\';
					$thumb_path = 'thumb\\';
					$upload_dir = UPLOADDIR . $path;
				}

				folderCheck($upload_dir . $thumb_path);
				$folder_path = $upload_dir . "/";
				$fields = array();

				for ($i = 0; $i < $files_total; $i++) {
					if (isset($files['name'][$i]) && !empty($files['name'][$i]) && $files['error'][$i] == 0) {
						$_FILES['ufile']['name'] = $files['name'][$i];
			            $_FILES['ufile']['type'] = $files['type'][$i];
			            $_FILES['ufile']['tmp_name'] = $files['tmp_name'][$i];
			            $_FILES['ufile']['error'] = $files['error'][$i];
			            $_FILES['ufile']['size'] = $files['size'][$i];
			            $ext_arr = explode('.', $files['name'][$i]);

						$config['upload_path'] = $folder_path;
						$config['allowed_types'] = '*';
						$config['max_size']	= '0';
						$config['max_width'] = '0';
						$config['max_height'] = '0';
						$config['overwrite'] = TRUE;
						$image = 'msg_' . time() . '_' . $user['id'] . '_' . rand(111, 999999) . $i . '.' . end($ext_arr);
						$config['file_name'] = $image;
						$config['orig_name'] = $files['name'][$i];
						$config['image'] = $image;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload('ufile')) {
							$ftype = 'file';
							$file_path = UPLOADPATH . 'messages/thumb/';
							if (strpos($files['type'][$i], 'mage/')) {
								//generate the thumbnail photo from the main photo
								$config['image_library'] = 'gd2';
								$config['source_image'] = $folder_path . $config['image'];
								$config['new_image'] = $folder_path . $thumb_path . $config['image'];
								$config['thumb_marker'] = '';
								$config['create_thumb'] = TRUE;
								$config['maintain_ratio'] = TRUE;
								$config['width'] = 100;
								$config['height'] = 100;
								$this->load->library('upload', $config);
								$this->image_lib->initialize($config);
								$this->image_lib->resize();
								//generate the thumbnail photo from the main photo
								$ftype = 'image';
								$file_output .= '<p><img src="' . $file_path . $image . '" width="100" height="100"> <button title="Download" class="button download" type="button" data-file="file-' . $image . '" data-ofile="file-' . $files['name'][$i] . '"><i class="fa fa-download" aria-hidden="true"></i></button></p>';
							} else {
								$ftype = 'video';
								$file_output .= '<p>File: ' . $files['name'][$i] . ' <button title="Download" class="button download" type="button" data-file="file-' . $image . '" data-ofile="file-' . $files['name'][$i] . '"><i class="fa fa-download" aria-hidden="true"></i></button></p>';
							}

							$images[] = array(
								'filename' => $image,
								'ofilename' => $files['name'][$i],
								'type' => $ftype,
							);
						}
					}
				}
				$file_output = '<p>' . $file_output . '</p>';
			}

			$fields = array(
				'from_id' => $user['id'],
				'to_id' => $uid,
				'content' => $post['message'],
				'files' => (!empty($images)) ? serialize($images) : '',
				'created_date' => time(),
				'modified_date' => time()
			);

			$msg_id = $this->Users_model->insertData('messages', $fields);
			$profile_image = FILEPATH . 'img/default/profile-pic-blank.png';
			if (!empty($user['filename'])) {
				$profile_image = UPLOADPATH . 'user/profile/thumb/' . $user['filename'];
			}

			$output = '<div class="outgoing_msg msg">
                <div class="sent_msg msg-txtcmn btm-right-shape">
                  <p>' . $post['message'] . '</p>
                  ' . $file_output . '
                  <span class="rm-time"> ' . date('h:i A') . '</span>
                  <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                  <div class="action" data-pid="pid-' . $msg_id . '" style="display:none;">
                  <span class="delme">Delete for me</span>
                  <span class="delboth">Delete for both</span>
                  </div>
                </div>
                <div class="msg_img">
                  <img src="' . $profile_image . '" alt="profile image">
                </div>
              </div>';
            $response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = $output;
		} else if ($action == 'message_get') {
			$uid = str_replace('mu-', '', $post['muid']);
			$content = $this->Users_model->getMessages('message_by_user', $user['id'], $uid);
			$output = '';

			if (!empty($content)) {
				$profile_image = FILEPATH . 'img/default/profile-pic-blank.png';
				if (!empty($user['filename'])) {
					$profile_image = UPLOADPATH . 'user/profile/thumb/' . $user['filename'];
				}
				foreach ($content as $value) {
					$files = '';
					if (!empty($value->files)) {
						$file_arr = unserialize($value->files);
						$file_path = UPLOADPATH . 'messages/thumb/';
						foreach ($file_arr as $file) {
							if ($file['type'] == 'image') {
								$files .= '<p><img src="' . $file_path . $file['filename'] . '" width="100" height="100"> <button title="Download" class="button download" type="button" data-file="file-' . $file['filename'] . '" data-ofile="file-' . $file['ofilename'] . '"><i class="fa fa-download" aria-hidden="true"></i></button></p>';
							} else {
								$files .= '<p>File: ' . $file['ofilename'] . ' <button title="Download" class="button download" type="button" data-file="file-' . $file['filename'] . '" data-ofile="file-' . $file['ofilename'] . '"><i class="fa fa-download" aria-hidden="true"></i></button></p>';
							}
						}
					}
					
					if ($value->from_id == $user['id']) {
						$output .= '<div class="outgoing_msg msg">
                <div class="sent_msg msg-txtcmn btm-right-shape">
                  <p>' . $value->content . '</p>
                  ' . $files . '
                  <span class="rm-time"> ' . date('h:i A', $value->created_date) . '</span>
                  <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                  <div class="action" data-pid="pid-' . $value->id . '" style="display:none;">
                  <span class="delme">Delete for me</span>
                  <span class="delboth">Delete for both</span>
                  </div>
                </div>
                <div class="msg_img">
                  <img src="' . $profile_image . '" alt="profile image">
                </div>
              </div>';
					} else {
						$output .= '<div class="incoming_msg msg">
                <div class="msg_img">
                  <img src="{{user_image}}" alt="profile image">
                </div>
                <div class="received_msg msg-txtcmn btm-left-shape">
                  <p>' . $value->content . '</p>
                  ' . $files . '
                  <span class="rm-time"> ' . date('h:i A', $value->created_date) . '</span>
                  <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </div>
                <div class="action" data-pid="pid-' . $value->id . '" style="display:none;">
                  <span class="delme">Delete</span>
                  </div>
              </div>';
					}
				}
			}

			$response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = $output;
		} else if ($action == 'get_review') {
			$pid = str_replace('post-', '', $post['pid']);
			$reviews = $this->Users_model->getReviews('post', array('pid' => $pid));
			$output = '';
			$own_review = 0;

			if (!empty($reviews)) {
				foreach ($reviews as $value) {
					if ($value->id == $user['id']) {
						$own_review = $value->review;
					}
					$image = FILEPATH . 'img/default/no-image.png';
					if (!empty($value->filename)) {
						$images = UPLOADPATH . 'user/profile/thumb/' . $value->filename;
					}
					$reviews = '';

					for ($i = 1; $i <= 5 ; $i++) {
						if ($i <= $value->review) {
							$reviews .= '<i class="star fas fa-star voted"></i>';
						} else {
							$reviews .= '<i class="star fas fa-star"></i>';
						}
					}
					$output .= '<div class="col-lg-4">
                        <div class="card bg-secondary">
                          <div class="p-3">
                            <div class="d-flex align-items-center">
                              <div>
                                <a href="javascript:void(0)" class="avatar rounded-circle d-inline-block">
                                  <img alt="Image placeholder" src="' . $image . '" class="">
                                </a>
                              </div>
                              <div class="pl-3">
                                <a href="javascript:void(0)" class="h6 text-sm">' . ucwords($value->first_name . ' ' . $value->last_name) . '</a><span class="static-rating static-rating-sm d-block">
                                ' . $reviews . '
                                </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>';
				}
				
				$output = '<div class="row">' . $output . '</div>';
				$output = '<div class="post-reivew-list mt-2"><h6 class="mt-3">
                    <i class="fas fa-user-friends mr-2"></i>Endorsements
                    </h6>' . $output . '</div>';
			}

			$response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = $output;
			$response['review'] = $own_review;
		} else if ($action == 'set_review') {
			$pid = str_replace('post-', '', $post['pid']);
			$review = $post['review'];

			$review_exist = $this->Users_model->getData('post_review', array('post_id' => $pid, 'user_id' => $user['id']), 'id');

			if (empty($pid) || empty($review) || !empty($review_exist)) {
				echo json_encode($response);
				exit;
			}
			
			$fields = array(
				'user_id' => $user['id'],
				'post_id' => $pid,
				'review' => $review,
				'created_date' => time()
			);

			$this->Users_model->insertData('post_review', $fields);
			$response['success'] = true;
			$response['msg'] = 'Review successfully done';
		} else if ($action == 'get_head_rate') {
			$ts = strtotime(date('Y-m-d'));
	        $cur_date_in = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
	        $cur_date_end = strtotime('next saturday', $cur_date_in);
	        $last_week_sunday = strtotime('-1 week', $cur_date_in);
	        $last_week_saturday = strtotime('-1 day', $cur_date_in);

	        $prev_products = $this->Users_model->getRating('products', $user['id'], $user['type'], $last_week_sunday, $last_week_saturday);
	        $cur_products = $this->Users_model->getRating('products', $user['id'], $user['type'], $cur_date_in, $cur_date_end);
	        $prev_sales = $this->Users_model->getRating('sales', $user['id'], $user['type'], $last_week_sunday, $last_week_saturday);
	        $cur_sales = $this->Users_model->getRating('sales', $user['id'], $user['type'], $cur_date_in, $cur_date_end);
	        $prev_followers = $this->Users_model->getRating('followers', $user['id'], $user['type'], $last_week_sunday, $last_week_saturday);
	        $cur_followers = $this->Users_model->getRating('followers', $user['id'], $user['type'], $cur_date_in, $cur_date_end);

			/*$products = $this->Users_model->getData('seller_stock_product', array('seller_id' => $user['id']), 'COUNT(id) AS total');
			$sales = $this->Users_model->getData('product_orders', array('seller_id' => $user['id']), 'SUM(quantity) AS total');
			$followers = $this->Users_model->getData('follow_business_seller', array('user_id' => $user['id']), 'COUNT(id) AS total');*/
			/*$data['products'] = (!empty($products)) ? $products[0]->total : 0;
			$data['sales'] = (!empty($sales)) ? $sales[0]->total : 0;
			$data['followers'] = (!empty($followers)) ? $followers[0]->total : 0;*/
			
			$prev_product = $prev_products[0]->total;
			$cur_product = $cur_products[0]->total;
			$prev_sale = $prev_sales[0]->total;
			$cur_sale = $cur_sales[0]->total;
			$prev_follower = $prev_followers[0]->total;
			$cur_follower = $cur_followers[0]->total;

			$data['products'] = $data['sales'] = $data['followers'] = 0;

			if (!empty($cur_product) && $cur_product > 0) {
				if ($prev_product > 0) {
					$temp = 100 / ($prev_product / $cur_product);
					$data['products'] = ($temp > 100) ? 100 : round($temp);
				} else {
					$data['products'] = 100;
				}
			}
			if (!empty($cur_sale) && $cur_sale > 0) {
				if ($prev_sale > 0) {
					$temp = 100 / ($prev_sale / $cur_sale);
					$data['sales'] = ($temp > 100) ? 100 : round($temp);
				} else {
					$data['sales'] = 100;
				}
			}
			if (!empty($cur_follower) && $cur_follower > 0) {
				if ($prev_follower > 0) {
					$temp = 100 / ($prev_follower / $cur_follower);
					$data['followers'] = ($temp > 100) ? 100 : round($temp);
				} else {
					$data['followers'] = 100;
				}
			}

			$response['success'] = true;
			$response['msg'] = 'Rate get successfully done';
			$response['data'] = $data;
		} else if ($action == 'get_business_vouchers') {
			$pid = str_replace('post-', '', $post['pid']);
			$endorse = $this->Users_model->getData('endorse_business', array('user_id' => $pid, 'follow_by' => $user['id']), 'id, status');

			if (!empty($endorse)) {
				if ($endorse[0]->status == 1) {
					$vouchers = $this->Users_model->getData('product_discount_voucher', array('user_id' => $pid, 'status' => 1, 'voucher_status' => 'open'), 'id, name, percentage, flat_rate, description, filename');
					$output = '';
					if (!empty($vouchers)) {
						foreach ($vouchers as $value) {
							$discount = $value->percentage . ' %';
							if (!empty($value->flat_rate) && $value->flat_rate > 0) {
								$discount = '$' . $value->flat_rate;
							}
							$url = base_url('products/businessvoucher/' . $value->id);
							$image_name = ucwords($value->name);
							if (!empty($value->filename) && file_exists(UPLOADDIR . 'vouchers/' . $value->filename)) {
								$image_name = '<img src="' . UPLOADPATH . 'vouchers/' . $value->filename . '" title="' . ucwords($value->name) . '">';
							}
							$output .= '<div class="col-xl-6 col-lg-4 col-sm-6 mb-2">
                    <div class="voucher-list" data-couponid="85411">
                        <p>' . $discount . ' <span>OFF</span><a href="' . $url . '" class="view" title="' . ucwords($value->name) . '">' . $image_name . '</a></p>
                        <h3>' . $value->description . '</h3>
                        <a href="' . $url . '" class="view" title="' . ucwords($value->name) . '">See Offer</a>
                    </div></div>';
							/*$output .= '<div class="col-xl-3 col-lg-4 col-sm-6 text-center">
		            <div class="card card-product">
		              <div class="card-image">
		                <a href="' . base_url('products/businessvoucher/' . $value->id) . '">
		                  ' . $discount . '
		                </a>
		              </div>
		              <div class="card-body text-center pt-0">
		                <h6><a href="' . base_url('products/businessvoucher/' . $value->id) . '">' . $value->name . '</a></h6>
		              </div>
		            </div>
		          </div>';*/
						}
						$output = '<div class="row">' . $output . '</div>';
					} else {
						$output = '<div class="row">No voucher found.</div>';
					}
				} else {
					$output = '<div class="row">Endorsement is pending approval.</div>';
				}
			} else {
					$output = '<div class="row">Please endorse first.</div>';
				}
			$response['success'] = true;
			$response['msg'] = 'done';
			$response['data'] = $output;
		} else if ($action == 'get_user_notification') {
			$data = $this->Users_model->getData('notification', array('user_id' => $user['id'], 'isread' => 0, 'status' => 1), 'COUNT(id) AS total');
			if (!empty($data)) {
				$response['success'] = true;
				$response['data'] = $data[0]->total;
			}
			$response['msg'] = 'done';
		} else if ($action == 'update_user_notification') {
			$this->Users_model->updateData('notification', array('user_id' => $user['id'], 'isread' => 0), array('isread' => 1));
			$response['success'] = true;				
		} else if ($action == 'delme') {
			$pid = str_replace('pid-', '', $post['pid']);
			$fields = array(
				'user_id' => $user['id'],
				'msg_id' => $pid,
				'created_date' => time()
			);
			$this->Users_model->insertData('messages_delete', $fields);
			$response['success'] = true;
			$response['msg'] = 'Message successfully deleted.';
		} else if ($action == 'delboth') {
			$pid = str_replace('pid-', '', $post['pid']);
			$this->Users_model->deleteData('messages', array('id' => $pid));
			$response['success'] = true;
			$response['msg'] = 'Message successfully deleted.';
		} else if ($action == 'get_user_notification_list') {
			$data = $this->Users_model->getData('notification', array('user_id' => $user['id'], 'isread' => 0, 'status' => 1));
			if (!empty($data)) {
				$output_arr = $read = '';
				$link = base_url('user/notification');
				foreach ($data as $row) {
					$output = '';
					switch ($row->type) {
	                  case 'follow':
	                    $output = 'New follow by ' . ucwords($row->name);
	                    break;
	                  case 'endorse':
	                    $output = 'New endorsement from ' . ucwords($row->name);
	                    break;
	                  case 'product':
	                    $output = 'Product purchase by ' . ucwords($row->name);
	                    break;
	                  case 'voucher':
	                    $output = 'Voucher purchase by ' . ucwords($row->name);
	                    break;
	                  case 'post':
	                    $output = 'New post in profile';
	                    break;
	                }
	                if ($row->isread == 0) {
	                  $read = 'unread';
	                }
					$output_arr .= '<a href="' . $link . '" target="_blank" class="dropdown-item ' . $read . '">' . $output . '</a>';
				}

				$response['success'] = true;
				$response['data'] = $output_arr;
			}
			$response['msg'] = 'done';
		}

		echo json_encode($response);
	}

	public function account () {
		$user = authentication();
		$user_details = $this->Users_model->getData('users', array('id' => $user['id']));

		/*if (isset($_FILES['ufile'])) {
			$file = $_FILES['ufile'];
			$image_types = array('image/png', 'image/jpg', 'image/jpeg', 'image/svg' ,'image/gif');

			if (!in_array($file['type'], $image_types)) {
				$this->session->set_flashdata('msg_error', 'Invalid profile image uploaded.');
				redirect(base_url('user/account'), 'refresh');
			}

			$path = 'user/profile/';
			$upload_dir = UPLOADDIR . $path;
			$thumb_path = 'thumb/';
			if ($_SERVER['HTTP_HOST'] == 'localhost') {
				$path = 'user\\profile\\';
				$upload_dir = UPLOADDIR . $path;
				$thumb_path = 'thumb\\';
			}

			folderCheck($upload_dir . $thumb_path);

			$folder_path = $upload_dir . "/";
			$ext_arr = explode('.', $file['name']);

			$config['upload_path'] = $folder_path;
			$config['allowed_types'] = '*';
			$config['max_size']	= '0';
			$config['max_width'] = '0';
			$config['max_height'] = '0';
			$config['overwrite'] = TRUE;
			$image = 'profile_' . time() . '_' . $user['id'] . '.' . end($ext_arr);
			$config['file_name'] = $image;
			$config['orig_name'] = $file['name'];
			$config['image'] = $image;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('ufile');
			//generate the thumbnail photo from the main photo
			$config['image_library'] = 'gd2';
			$config['source_image'] = $folder_path . $config['image'];
			$config['new_image'] = $folder_path . $thumb_path . $config['image'];
			$config['thumb_marker'] = '';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 100;
			$config['height'] = 100;
			$this->load->library('upload', $config);
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			//generate the thumbnail photo from the main photo

			if (!empty($user_details[0]->filename)) {
				@unlink($upload_dir . $user_details[0]->filename);
				@unlink($upload_dir . $thumb_path . $user_details[0]->filename);
			}

			$fields = array(
				'filename' => $image,
				'modified_date' => time()
			);

			$this->Users_model->updateData('users', array('id' => $user['id']), $fields);
			$this->session->set_flashdata('msg_success', 'Profile photo successfully updated.');
			redirect(base_url('user/account'), 'refresh');
		}*/

		if ($this->input->post('cimage')) {
			$post = $this->input->post();
			$image = $post['cimage'];
			$image_info = explode(";base64,", $image);
		    $img_ext = str_replace('data:image/', '', $image_info[0]);      
		    $image = str_replace(' ', '+', $image_info[1]);
			$image = base64_decode($image);
			$path = 'user/profile/';
			$upload_dir = UPLOADDIR . $path;
			if ($_SERVER['HTTP_HOST'] == 'localhost') {
				$path = 'user\\profile\\';
				$upload_dir = UPLOADDIR . $path;
			}

			if (!is_dir($upload_dir)) {
				folderCheck($upload_dir);
			}

			$folder_path = $upload_dir . "/";
			$image_org_name = 'profile_' . time() . '_' . $user['id'] . '.' . $img_ext;
			$image_name = $folder_path . $image_org_name;
			file_put_contents($image_name, $image);
			if (!empty($user_details[0]->filename)) {
				@unlink($upload_dir . $user_details[0]->filename);
			}

			$fields = array(
				'filename' => $image_org_name,
				'modified_date' => time()
			);

			$this->Users_model->updateData('users', array('id' => $user['id']), $fields);
			$this->session->set_flashdata('msg_success', 'Profile photo successfully updated.');
			redirect(base_url('user/account'), 'refresh');
		}
		if ($this->input->post('first_name')) {
			$post = $this->input->post();
			$fields = array(
				'first_name' => $post['first_name'],
				'last_name' => $post['last_name'],
				'dob' => $post['dob'],
				'gender' => $post['gender'],
				'phone' => $post['phone'],
				'address' => $post['address'],
				'city' => $post['city'],
				'state' => $post['state'],
				'country' => $post['country'],
				'modified_date' => time()
			);
			$this->Users_model->updateData('users', array('id' => $user['id']), $fields);
			$this->session->set_flashdata('msg_success', 'Profile successfully updated.');
			redirect(base_url('user/account'), 'refresh');
		}

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['user_detail'] = $user_details[0];
		$this->load->helper('custom_helper');
		$this->commonData['countries'] = getCountries();
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		$this->commonData['js'][] = 'libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js';
		$this->commonData['js'][] = 'js/cropzee.js';
		$this->commonData['css'][] = 'libs/@fancyapps/fancybox/dist/jquery.fancybox.min.css';
		$this->commonData['js'][] = 'libs/@fancyapps/fancybox/dist/jquery.fancybox.min.js';
		$this->commonData['js'][] = 'libs/autosize/dist/autosize.min.js';

		$this->loadScreen('frontend/user/account');
	}

	public function settings () {
		$user = authentication();

		if ($this->input->post('old_password')) {
			$post = $this->input->post();
			$user_details = $this->Users_model->getData('users', array('id' => $user['id']), 'password');

			if (md5($post['old_password']) !== $user_details[0]->password) {
				$this->session->set_flashdata('msg_error', 'Old password does not match.');
				redirect(base_url('user/settings'), 'refresh');
			}

			$fields = array('password' => md5($post['password']));
			$this->Users_model->update($user['id'], $fields);
			$this->session->set_flashdata('msg_success', 'New password successfully updated.');
			redirect(base_url('user/settings'), 'refresh');
		} else if ($this->input->post('old_email')) {
			$old_email = trim($this->input->post('old_email'));
			$new_email = trim($this->input->post('new_email'));

			if ($user['email'] !== $old_email) {
				$this->session->set_flashdata('msg_error', 'Old email does not match.');
				redirect(base_url('user/settings'), 'refresh');
			}

			$user_details = $this->Users_model->getData('users', array('email' => $new_email, 'id !=' => $user['id']), 'id');

			if (!empty($user_details)) {
				$this->session->set_flashdata('msg_error', 'Entered email already exist. Please enter another and try again');
				redirect(base_url('user/settings'), 'refresh');
			}

			$fields = array('email' => $new_email);
			$this->Users_model->update($user['id'], $fields);
			$_SESSION['user_data']['email'] = $new_email;
			$this->session->set_flashdata('msg_success', 'New email successfully updated.');
			redirect(base_url('user/settings'), 'refresh');
		}

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		$this->commonData['js'][] = 'libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js';

		$this->loadScreen('frontend/user/settings');
	}

	public function dashboard () {
		$user = authentication();

		if ($user['type'] != B2B && $user['type'] != SELLER ) {
			redirect(base_url());
		}

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		$this->commonData['js'][] = 'libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js';
		$this->commonData['js'][] = 'js/jquery.canvasjs.min.js';
		$this->commonData['js'][] = 'js/report.js';

		if ($user['type'] == B2B) {
			$this->loadScreen('frontend/business/dashboard');
		} else if ($user['type'] == SELLER) {
			$categories = $this->Users_model->getData('product_category', array('status' => 1), 'id, name, slug');
			$this->commonData['categories'] = $categories;
			$this->loadScreen('frontend/user/dashboard');
		}
	}

	public function followList () {
		$user = authentication();

		if ($user['type'] != B2B && $user['type'] != SELLER) {
			redirect(base_url());
		}

		$follow = $this->Users_model->getFollowers($user['id']);
		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['title'] = 'Follower List';
		$this->commonData['user'] = $user;
		$this->commonData['follow'] = $follow;
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';
		$this->commonData['css'][] = 'libs/@fancyapps/fancybox/dist/jquery.fancybox.min.css';
		$this->commonData['js'][] = 'libs/@fancyapps/fancybox/dist/jquery.fancybox.min.js';
		$this->loadScreen('frontend/business/follower_list');
	}

	public function changeStat () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '';
		$stat = ($this->input->get('stat') &&  $this->input->get('stat') == '1') ? '0' : '1';
		$tp = ($this->input->get('tp')) ? $this->input->get('tp') : '';

		if (empty($cid)) {
			redirect('admin/faq/items', 'refresh');
		}
		
		if ($tp == 'followbu') {
			$fields = array(
				'block' => $stat
			);
			$this->Users_model->updateData('follow_business_seller', array('id' => $cid), $fields);
			redirect(base_url('user/followlist'), 'refresh');
		} else {
			// $fields = array(
			// 	'status' => $stat
			// );
			// $this->Users_model->updateData('faq_items', array('id' => $cid), $fields);
			// redirect('', 'refresh');
		}
	}

/////////////////////Koustav 09-12-2019//////////////////////////////////////////
	public function becameSeller(){
		$user = authentication();
		if($user['id'] == $_GET['uid'])
		{
			if($user['type'] == CUSTOMER)
			{
				$data = array('type' => SELLER);
				$upade_id = $this->Users_model->update($user['id'], $data);
				$_SESSION['user_data']['type'] = SELLER;
				$this->session->set_flashdata('msg_success', 'Your profile updated to Reseller.');
				redirect(base_url('user/dashboard'), 'refresh');				
			}
			else{
				$this->session->set_flashdata('msg_error', 'Your are allready a Reseller.');
				redirect(base_url('user/account'), 'refresh');
			}

		}
		else{
			$this->session->set_flashdata('msg_error', 'Please tryagain...');
			redirect(base_url('user/account'), 'refresh');
		}
	}

	public function messages () {
		$user = authentication();

		$data = $this->Users_model->getMessages('user_list', $user['id'], $user['type']);

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['title'] = 'Messages';
		$this->commonData['user'] = $user;
		$this->commonData['messages'] = $data;
		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';
		$this->loadScreen('frontend/user/messages');
	}

	public function downloadFile ($file, $ofile) {
		$ref = $_SERVER['HTTP_REFERER'];
		if (empty($file) || empty($ofile)) {
			redirect($ref);
		}

		$file = str_replace('file-', '', $file);
		$ofile = str_replace('file-', '', $ofile);
		$file = UPLOADDIR . 'messages/' . $file;

		if (!file_exists($file)) {
			redirect($ref);
		}

		$result = basename($file);
		ob_start();
		header('Content-Description: File Transfer');
		header('Content-Type: application/force-download');
		header('Content-Disposition: attachment; filename=' . $ofile);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_end_clean();
		flush();
		readfile($file);
		exit();
	}

	public function billing () {
		$user = authentication();

		$stripe_detail = $this->Users_model->getData('stripe_details', array('user_id' => $user['id']), 'secret_key, publish_key');

		if ($this->input->post('secret_key')) {
			$fields = array(
				'secret_key' => trim($this->input->post('secret_key')),
				'publish_key' => trim($this->input->post('publish_key')),
				'modified_date' => time()
			);

			if (!empty($stripe_detail)) {
				$this->Users_model->updateData('stripe_details', array('user_id' => $user['id']), $fields);
				$this->session->set_flashdata('msg_success', 'Stripe credentials successfully updated.');
			} else  {
				$fields['user_id'] = $user['id'];
				$fields['created_date'] = time();
				$this->Users_model->insertData('stripe_details', $fields);
				$this->session->set_flashdata('msg_success', 'Stripe credentials successfully added.');
			}

			redirect(base_url('user/billing'), 'refresh');
		}

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['payment'] = array();
		$this->commonData['stripe_detail'] = (!empty($stripe_detail)) ? $stripe_detail[0] : array();
		$this->commonData['css'][] = 'libs/flatpickr/dist/flatpickr.min.css';
		$this->commonData['css'][] = 'libs/select2/dist/css/select2.min.css';
		$this->commonData['js'][] = 'libs/flatpickr/dist/flatpickr.min.js';
		$this->commonData['js'][] = 'libs/select2/dist/js/select2.min.js';
		$this->commonData['js'][] = 'libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js';

		$this->loadScreen('frontend/user/billing');
	}

	public function notification () {
		$user = authentication();

		$notifications = $this->Users_model->getData('notification', array('user_id' => $user['id'], 'status' => 1));

		$setting_arr = $this->Users_model->getData('home_page_setting', array('region' => 'footer_copy_right'));
		$settings = array('footer_copy_right' => '');

		foreach ($setting_arr as $value) {
			$settings[$value->region] = $value->value;
		}

		$this->commonData['home_page_setting'] = $settings;
		$this->commonData['user'] = $user;
		$this->commonData['content'] = $notifications;
		$this->commonData['title'] = 'Notification List';
		$this->commonData['css'][] = 'libs/datatables.net-bs/css/dataTables.bootstrap.min.css';
		$this->commonData['js'][] = 'libs/datatables.net/js/jquery.dataTables.min.js';
		$this->commonData['js'][] = 'libs/datatables.net-bs/js/dataTables.bootstrap.min.js';

		$this->loadScreen('frontend/user/notification');
	}

}
