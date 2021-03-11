<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sellers extends BaseController {
	public function __construct() {
		parent::__construct();
		// $this->load->library('facebook');
		$this->load->model('Users_model');
		$this->load->model('Product_model');
		$this->load->model('Login_model');
		$this->load->library('image_lib');
	   
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
	   
	public function get_user_purchase_requests(){
		$data = json_decode(file_get_contents('php://input'));
		$user_id = $data->user_id;
		$limit=$data->limit;
		if(!empty($user_id)){
			$records=$this->Product_model->my_purchase_requests($user_id, $limit);
			$response['fav_data'] = $records;
			$response['success'] = true;
			$response['msg'] = 'Message Submitted Successfully';
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		//echo '<pre>';
		//print_r($response);
		echo json_encode($response);
	}
	public function get_user_recent_purchase_requests(){
		$data = json_decode(file_get_contents('php://input'));
		$user_id = $data->userId;
		$limit['limit'] = $data->prodLimit;
		$currentpage = $data->offset;
		$limit['offset'] = (($currentpage - 1 ) * $limit['limit']);
		if(!empty($user_id)){
			$records = $this->Product_model->my_purchase_requests($user_id, $limit);
			$response['fav_data'] = $records;
			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		echo json_encode($response);
	}
	
	public function get_user_single_purchase_details(){
		if($this->input->post('user_id')) {
			$user_id =   $this->input->post('user_id');
			$purchaseId =   $this->input->post('purchaseId');
		}else{
			$data = json_decode(file_get_contents('php://input'));
			$user_id = $data->user_id;
			$purchaseId = $data->purchaseId;
		}
		if(!empty($user_id)){
			$this->db->select('p.name product_name, p.regular_price, pr.*');
			$this->db->from('purchase_request pr');
			$this->db->join('products p', 'p.id = pr.product_id');
			//$this->db->where('p.user_id', $user_id);
			$this->db->where('pr.purchase_request_id', $purchaseId);
			$query = $this->db->get();
			$response = $query->result();
		}else{
			$response = array('success' => false, 'msg' => 'Data missing');
		}
		//echo '<pre>';
		//print_r($response);
		echo json_encode($response);
	}
	public function get_user_my_product(){
		$data = json_decode(file_get_contents('php://input'));
		$user_id = $data->userId;
		$limit = $data->prodLimit;
		$offset = (($data->offset - 1 ) * $limit);
		if(!empty($user_id)){
			$la_myProduct = $this->Product_model->getProductList(0, $user_id, ['limit' => $limit, 'offset' => $offset]);
			$response = $la_myProduct;
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		echo json_encode($response);
	}

	
	public function user_add_product(){
			$post = $this->input->post();
			$files = $_FILES;
			$la_post['name'] = (!isset($post['name'])) ? "" : $post['name'];
            $la_post['regular_price'] = (!isset($post['regular_price'])) ? "" : $post['regular_price'];
            $la_post['original_manufacture_name'] = (!isset($post['original_manufacture_name'])) ? "" : $post['original_manufacture_name'];
            $la_post['year_manufactured'] = (!isset($post['year_manufactured'])) ? "" : $post['year_manufactured'];
            $la_post['warranty'] = ($post['warranty'] == '') ? "No" : $post['warranty'];
            $la_post['product_condition_id'] = (!isset($post['product_condition_id'])) ? "" : $post['product_condition_id'];
            $la_post['notable_defect_id'] = (!isset($post['notable_defect_id'])) ? "" : $post['notable_defect_id'];
//            $la_post['short_description'] = $post['short_description'];
            $la_post['long_description'] = (!isset($post['long_description'])) ? "" : $post['long_description'];
            $la_post['modified_date'] = time();
            $la_post['status'] = 1;
            $la_post['created_date'] = time();
			$la_post['modified_date'] = time();

			$path = 'products/product/';
			/*$category_id=$data->category_id;
			$city_id=$data->city_id;
			$insertId = $this->Users_model->insertData('products', $la_post);
			if ($insertId) {
				$this->Users_model->insertData('product_categories', ['product_id' => $insertId, 'category_id' => $category_id, 'created_date' => time()]);
				$this->Users_model->insertData('products_location_map', ['product_id' => $insertId, 'city_id' => $city_id]);
				$response = array('success' => true, 'msg' => 'Product inserted');
			}else{
				$response = array('success' => false, 'msg' => 'Product insertion failed');
			}
			echo json_encode($response);*/
			
			
            if (isset($files['uploadedImages']['name']) && !empty($files['uploadedImages']['name'])) { //========= Upload product image in product table===========//
                $file = $files['uploadedImages'];
                $ext_arr = explode('.', $file['name']);
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = "_pro_" . time() . "_" . rand(10000, 99999) . '.' . $ext;
				/*$insertId = 65;
				$filenameone = $insertId . $filename;
				$path = 'products/product/';
				$upload_dir = UPLOADDIR . $path;
				$uploadFile = move_uploaded_file($file['tmp_name'], $upload_dir . $filenameone);
				echo $uploadFile;
		
				if($uploadFile){
					$path_thumb = 'products/product/thumb/';
					$upload_dir_thumb = UPLOADDIR . $path_thumb;
					$uploadFile_thumb = move_uploaded_file($file['tmp_name'], $upload_dir_thumb . $filenameone);
					echo $uploadFile_thumb;
					exit;
				}*/
				//$uploadFile = $this->image_upload($file['tmp_name'], $path, $filenameone, 'filename', 180, 180);
				
            }


		  if (!isset($post['category_id'][0]) || (isset($post['category_id'][0]) && ($post['category_id'][0] == ''))) {
               $response = array('success' => false, 'data' => $post, 'msg' => 'Product category must be selected!');
          }else{
			   if($post['productId'] == '') {
				  $la_post['sku'] = $post['userId'] . "-" . time();
                  $la_post['user_id'] = $post['userId'];
                  $la_post['created_date'] = time();
				  if (empty($files['uploadedImages']['name'])) {
						$response = array('success' => false, 'data' => $post, 'msg' => 'Please add product image!');
						echo json_encode($response);
						exit();
					}
				$get_loaction = json_decode($post['locationId']);
				$locationCount = count($get_loaction);
				if ($locationCount == 0) {
					$response = array('success' => false, 'data' => $post, 'msg' => 'Please select product location!');
					echo json_encode($response);
					exit();
				}
				$insertId = $this->Users_model->insertData('products', $la_post);
				 if ($insertId) {
					 foreach ($post['category_id'] as $category_id) {
							$this->Users_model->insertData('product_categories', ['product_id' => $insertId, 'category_id' => $category_id, 'created_date' => time()]);
						}
					 
				  if ($locationCount > 0) {
						foreach ($get_loaction as $city_id) {
							$this->Users_model->insertData('products_location_map', ['product_id' => $insertId, 'city_id' => $city_id->ID]);
						}
					}
				   if (!empty($files['uploadedImages']['name'])) {
						$filenameone = $insertId . $filename;
					   if ($this->image_upload($file['name'], $path, $filenameone, 'uploadedImages', 180, 180)) {
                          $return = $this->Users_model->updateData('products', ['id' => $insertId], ['filename' => $filenameone]);
                        }
						
					}
					$response['success'] = true;
					$response['product_id'] = $insertId;
					$response['msg'] = 'Product has been successfully uploaded';
				 }
				
				//;
				//print_r($get_loaction[0]);
				//exit;
					
			   }
		  }
		  echo json_encode($response);

	}

	function image_upload($orig_name, $path, $filename, $fieldName, $width, $height) {
        $upload_dir = UPLOADDIR . $path;
        $thumb_path = 'thumb/';
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $path = str_replace('/', "\\", $path);
            $upload_dir = UPLOADDIR . $path;
            $thumb_path = 'thumb\\';
        }

        folderCheck($upload_dir . $thumb_path);

        $folder_path = $upload_dir . "/";

        $config['upload_path'] = $folder_path;
        $config['allowed_types'] = 'png|gif|jpg|jpeg';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = TRUE;
        $config['file_name'] = $filename;
        $config['orig_name'] = $orig_name;
        $config['image'] = $filename;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload($fieldName)) {
            //generate the thumbnail photo from the main photo
            $config['image_library'] = 'gd2';
            $config['source_image'] = $folder_path . $config['image'];
            $config['new_image'] = $folder_path . $thumb_path . $config['image'];
            $config['thumb_marker'] = '';
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $width;
            $config['height'] = $height;
            $this->load->library('upload', $config);
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            //generate the thumbnail photo from the main photo
//                    if (!empty($product)) {
//                        if (!empty($product[0]->filename)) {
//                            @unlink($folder_path . $product[0]->filename);
//                            @unlink($folder_path . $thumb_path . $product[0]->filename);
//                        }
//                    }

            return TRUE;
        }
        return FALSE;
    }
	public function user_edit_product(){
			$data = json_decode(file_get_contents('php://input'));
			$user_id = $data->user_id;
			$la_post['sku'] = $data->user_id . "-" . time();
			$la_post['user_id'] = (!isset($data->user_id)) ? "" : $data->user_id;
			$la_post['name'] = (!isset($data->name)) ? "" : $data->name;
			$la_post['regular_price'] = (!isset($data->regular_price)) ? "" : $data->regular_price;
            $la_post['original_manufacture_name'] = (!isset($data->original_manufacture_name)) ? "" : $data->original_manufacture_name;
            $la_post['year_manufactured'] = (!isset($data->year_manufactured)) ? "" : $data->year_manufactured;
            $la_post['warranty'] = ($data->warranty == '') ? "No" : $data->warranty;
            $la_post['product_condition_id'] = (!isset($data->product_condition_id)) ? "" : $data->product_condition_id;
            $la_post['notable_defect_id'] = (!isset($data->notable_defect_id)) ? "" : $data->notable_defect_id;
			$la_post['short_description'] = (!isset($data->short_description)) ? "" : $data->short_description;
            $la_post['long_description'] = (!isset($data->long_description)) ? "" : $data->long_description;
			$la_post['status'] = 1;
            $la_post['created_date'] = time();
			$la_post['modified_date'] = time();
			$category_id=$data->category_id;
			$city_id=$data->city_id;
			$product_id = $data->product_id;
			$this->db->where(array('id'=>$product_id));
			$update=$this->db->update('products',$la_post);
			if($update){
				$response = array('success' => true, 'msg' => 'Product updated');
			}else{
				$response = array('success' => false, 'msg' => 'Update Failed');
			}
			echo json_encode($response);
	}

	public function get_payment_data(){
		$data = json_decode(file_get_contents('php://input'));
		$user_id = $data->user_id;
		if(!empty($user_id)){
			$la_paymentData = $this->Users_model->get_payment_data($user_id, '');
			$response = $la_paymentData;
		}else{
			$response = array('success' => false, 'msg' => 'user id missing');
		}
		echo json_encode($response);
	}
	public function get_product_add_criteria(){
		$la_pCategory = $this->Users_model->getData('product_category', array('status' => 1));
		$la_productsCondition = $this->Users_model->getData('products_condition', array('status' => "A"));
        $la_notableDefects = $this->Users_model->getData('products_notable_defects', array('status' => "A"));
		$response = array('success' => true, 'cat_data' => $la_pCategory, 'con_data' =>$la_productsCondition, 'def_data' =>$la_notableDefects  );
		echo json_encode($response);
	}

	public function get_auto_location() {
		$searchval = $this->uri->segment(2);
        if ($searchval != '') {
            $limit['limit'] = 10;
            $limit['offset'] = 0;
            $la_city = $this->Users_model->get_location_autocomplete_search($searchval, $limit);
			$response['data'] = $la_city;
			$response['success'] = true;
			$response['msg'] = "Success";
			
        }else{
			$response = array('success' => false, 'data' => []);
		}
		echo json_encode($response);
	}

	public function get_some_data(){
		$proId = $this->uri->segment(2);
		$ls_proLocation = [];
		$ls_productImgMap = [];
		$productImgMap = $this->Product_model->single_product_image_map($proId);
		if($productImgMap){
			$ls_productImgMap = $productImgMap;
		}
        $product_location = $this->Product_model->single_product_location($proId);
		if($product_location){
			$ls_proLocation = $product_location;
		}
		$response['ls_productImgMap'] = $ls_productImgMap;
		$response['ls_proLocation'] = $ls_proLocation;
		$response['msg'] = 'success';
		$response['success'] = true;
		echo json_encode($response);
	}


	public function update_purchase_requests(){
		$data = json_decode(file_get_contents('php://input'));
		$puchaseId = $data->purchaseId;
        $new_status = $data->status;
		$userid = $data->userId;
		$la_purchaseRequests = $this->Product_model->my_purchase_requests($userid, [], $puchaseId);
		if (count($la_purchaseRequests) > 0) {
			$status = $la_purchaseRequests[0]->status;
			if ($status == 'pending') {
				 $return = $this->Users_model->updateData('purchase_request', ['purchase_request_id' => $puchaseId], array('status' => $new_status, 'last_update' => date('Y-m-d H:i:s')));
				   if ($return) {
					$paymentLink = base_url("product-purchase-payment/$puchaseId");
					$la_chatField['send_to'] = $la_purchaseRequests[0]->buyer_id;
					$la_chatField['send_from'] = $userid;
					$la_chatField['purchase_id'] = $la_purchaseRequests[0]->purchase_request_id;
					$la_chatField['subject'] = $la_purchaseRequests[0]->message;
					$la_chatField['message'] = "Purchase has been $new_status. Please copy this link $paymentLink and paste in your browser to purchase the Product";
					$la_chatField['created_on'] = $la_chatField['updated_on'] = date('Y-m-d H:i:s');
					$la_chatField['	ip'] = get_client_ip();

					$this->Users_model->insertData('message_chatting', $la_chatField);

					$response['success'] = true;
					$response['data'] = ucfirst($new_status);
					$response['msg'] = "Success";
				}
			}
			 else {
                    $response['success'] = false;
                    $response['msg'] = "Purchase already $status";
                }
		}


	}

	public function get_transaction_list(){
		$data = json_decode(file_get_contents('php://input'));
		$limit['limit'] = $data->prodLimit;
		$currentpage = $data->offset;
		$limit['offset'] = (($currentpage - 1 ) * $limit['limit']);
		$uid = $data->userId;
		$li_subscriptionCharges_count = $this->Product_model->my_subscription_charges_count($uid)->count;
        $la_subscriptionCharges = $this->Product_model->my_subscription_charges($uid, $limit);
		$response['success'] = true;
		$response['data'] = $la_subscriptionCharges;
		$response['data_count'] = $li_subscriptionCharges_count;
		echo json_encode($response);
	}


	

}
?>

