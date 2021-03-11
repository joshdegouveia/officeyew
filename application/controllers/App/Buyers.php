<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Buyers extends BaseController {
	public function __construct() {
		parent::__construct();
		// $this->load->library('facebook');
		$this->load->model('Users_model');
		$this->load->model('Product_model');
		$this->load->model('Login_model');
	   
	}
	public function get_user_favourite(){
	
	  $data = json_decode(file_get_contents('php://input'));
	  $user_id = $data->userId;
	  if(!empty($user_id)){
		$la_myFavorites = $this->Product_model->my_favorites_list($user_id, ['limit' => ITEM_MY_FAVORITES, 'offset' => 0]);
		$response['fav_data'] = $la_myFavorites;
		$response['success'] = true;
		$response['msg'] = ' Message Submitted Successfully';
	  }else{
		  $response = array('success' => false, 'msg' => 'user id missing');
	  }
	  echo json_encode($response);
  }
  public function get_my_orders(){
	
	  $data = json_decode(file_get_contents('php://input'));
	  $user_id = $data->user_id;
	  if(!empty($user_id)){
		$la_productOrder = $this->Users_model->get_product_order_data($user_id);
		$response['fav_data'] = $la_productOrder;
		$response['success'] = true;
		$response['msg'] = ' Message Submitted Successfully';
	  }else{
		  $response = array('success' => false, 'msg' => 'user id missing');
	  }
	  echo json_encode($response);
  }
    public function get_user_submitted_request(){
		$data = json_decode(file_get_contents('php://input'));
		$user_id = $data->userId;
		  if(!empty($user_id)){
		  $this->db->select('p.name product_name, pr.*');
		  $this->db->select('u.first_name seller_f_name, u.last_name seller_l_name');
		  $this->db->from('purchase_request pr');
		  $this->db->join('products p', 'p.id = pr.product_id');
		  $this->db->join('users u', 'u.id = p.user_id');
		  $this->db->where('pr.buyer_id', $user_id);
		  $this->db->order_by('pr.purchase_request_id', 'DESC');
		  $query = $this->db->get();
		  $submitted_data = $query->result();
			$response['sub_data'] = $submitted_data;
			$response['success'] = true;
			$response['msg'] = ' Message Submitted Successfully';
		  
		  }else{
			  $response = array('success' => false, 'msg' => 'user id missing');
			 
		  }
		  echo json_encode($response);
	}
 
	public function user_delete_favourite(){
		$data = json_decode(file_get_contents('php://input'));
		$user_id = $data->user_id;
		$product_id = $data->product_id;
	   $fav_delete = $this->db->delete('my_favorites',array('product_id'=>$product_id,'added_by_user_id'=>$user_id));
	   //echo $this->db->last_query();
	   if($fav_delete){
	   	$response = array('success' => true, 'msg' => 'Deleted Successfully');
	   }else{
		$response = array('error' => false, 'msg' => 'Delete Failed');
	   }
	   echo json_encode($response);
	}

	public function get_search_product(){
		$productName = $this->uri->segment(2);
		$limit['limit'] = 10;
        $limit['offset'] = 0;
        $la_searchProduct = $this->Product_model->getProductList(0, 0, $limit, $productName, 'p.name,p.id,p.filename', 'p.name');
		$response['data'] = $la_searchProduct;
		$response['success'] = true;
		$response['msg'] = "Success";
		echo json_encode($response);
	}

}
?>

