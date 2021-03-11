<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Products extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Product_model');
        $this->load->model('Login_model');
        $this->load->library('image_lib');
    }

    public function product_categories() { // product_categories
        $li_count = $this->Users_model->getData('product_category', ['status' => 1], "COUNT(id) count")[0]->count;

        $currentPage = 1;
        if (isset($_GET['pg']) && ($_GET['pg'] > 0)) {
            $currentPage = $_GET['pg'];
        }
        $order_by['order_by'] = 'name';
        $order_by['sort'] = 'ASC';
        $limit['limit'] = ITEM_PRODACT_CAT;
        $limit['offset'] = (($currentPage - 1 ) * ITEM_PRODACT_CAT);
        $categories = $this->Users_model->getData('product_category', ['status' => 1], '', [], [], $order_by, $limit);
//        $categories = $this->Product_model->getProductCategory($limit);

        $this->commonData['li_item'] = $li_count;
        $this->commonData['currentPage'] = $currentPage;

        $this->commonData['categories'] = $categories;

        $this->loadScreen('frontend/products/product_categories');
    }

    public function product_list() {
        $catId = $this->uri->segment(3);
        $catName = $this->uri->segment(4);

        $categories = $this->Users_model->getData('product_category', ['status' => 1], 'id, name', [], [], ['order_by' => 'name', 'sort' => 'ASC']);

        $li_count = $this->Product_model->getProductList_count($catId, 0)[0]->count;
        $currentPage = 1;
        if (isset($_GET['pg']) && ($_GET['pg'] > 0)) {
            $currentPage = $_GET['pg'];
        }

        $limit['limit'] = ITEM_PRODACT_LG;
        $limit['offset'] = (($currentPage - 1 ) * ITEM_PRODACT_LG);

        $orderBy['orderBy'] = 'p.is_boost';
        $orderBy['type'] = 'DESC';

        $la_productList = $this->Product_model->getProductList($catId, 0, $limit, '', '', '', $orderBy);

        $this->commonData['title'] = 'Search Product';
        $this->commonData['header_flag'] = 'search_cat_and_location';
        $this->commonData['li_item'] = $li_count;
        $this->commonData['currentPage'] = $currentPage;

        $this->commonData['catId'] = $catId;
        $this->commonData['catName'] = $catName;
        $this->commonData['location_id'] = ''; // for search form defauly value 
        $this->commonData['ls_location'] = ''; // for search form defauly value 
        $this->commonData['categories'] = $categories;
        $this->commonData['la_productList'] = $la_productList;
        $this->loadScreen('frontend/products/product_list');
    }

    public function product_search() {
        $categories = $this->Users_model->getData('product_category', ['status' => 1], 'id, name', [], [], ['order_by' => 'name', 'sort' => 'ASC']);

        $currentPage = 1;
        $catId = 0;
        $ls_location = '';
        $proName = '';
        $location_id = '';

        if (isset($_GET['pg']) && ($_GET['pg'] > 0)) {
            $currentPage = $_GET['pg'];
        }
        if (isset($_GET['category']) && ($_GET['category'] > 0)) {
            $catId = $_GET['category'];
        }
        if (isset($_GET['location']) && ($_GET['location'] != '')) {
            $ls_location = $_GET['location'];
        }
        if (isset($_GET['location_id']) && ($_GET['location_id'] != '')) {
            $location_id = $_GET['location_id'];
        }

        $li_count = $this->Product_model->getProductListgetProductList_search_count($catId, $ls_location, $proName)[0]->count;
        $limit['limit'] = ITEM_PRODACT_LG;
        $limit['offset'] = (($currentPage - 1 ) * ITEM_PRODACT_LG);

        $orderBy['orderBy'] = 'p.is_boost';
        $orderBy['type'] = 'DESC';
        $la_productList = $this->Product_model->getProductList_search($catId, $location_id, $limit, $orderBy);

//        print_r($currentPage);
//        die(current_url());
        $this->commonData['title'] = 'Search Product';
        $this->commonData['header_flag'] = 'search_cat_and_location';
        $this->commonData['li_item'] = $li_count;
        $this->commonData['currentPage'] = $currentPage;
        $this->commonData['categories'] = $categories;
        $this->commonData['search_url'] = base_url("products/search?category=$catId&location=$ls_location&location_id=$location_id");


        $this->commonData['catId'] = $catId;
        $this->commonData['catName'] = '';
        $this->commonData['ls_location'] = $ls_location;
        $this->commonData['location_id'] = $location_id;
        $this->commonData['la_productList'] = $la_productList;
//        $this->loadScreen('frontend/products/product_list_search');
        $this->loadScreen('frontend/products/product_list');
    }

    public function product_details() {
        $user = authentication(false);

        $userId = 0;
        if (isset($user['id']) && ($user['id'] != '')) {
            $userId = $user['id'];
        }
        $productId = $this->uri->segment(3);
        $productName = $this->uri->segment(4);
        $catId = ($this->uri->segment(5) > 0) ? $this->uri->segment(5) : '';
        $catName = ($this->uri->segment(6) != '') ? $this->uri->segment(6) : "";
        $product = $this->Product_model->single_product($productId);
        $product_location = $this->Product_model->single_product_location($productId);
        $my_favorites = $this->Product_model->my_favorites($productId, $userId);
        if (empty($product)) {
            redirect(base_url(), 'refresh');
        }
        if (!empty($my_favorites)) {
            $my_favorites = $my_favorites[0];
        }
        $la_proMoreImg = $this->Users_model->getData('product_images', array('product_id' => $productId));
        $la_sellerReview = $this->Product_model->get_seller_review($productId);

//        print_r($product_location);die;

        $this->commonData['title'] = "Product Details: $productName";
        $this->commonData['user'] = $user;
        $this->commonData['productId'] = $productId;
        $this->commonData['productName'] = $productName;
        $this->commonData['catId'] = $catId;
        $this->commonData['catName'] = $catName;
        $this->commonData['sellerId'] = $product[0]->user_id;
        $this->commonData['product'] = $product[0];
        $this->commonData['product_location'] = $product_location;
        $this->commonData['my_favorites'] = $my_favorites;
        $this->commonData['la_proMoreImg'] = $la_proMoreImg;
        $this->commonData['la_sellerReview'] = $la_sellerReview;
        $this->loadScreen('frontend/products/product_details');
    }

    public function purchase_request_on_product_details() { // check  user type for open  purchase_request form ========
        $user = authentication(false);
        $response = array('success' => false, 'msg' => 'Unable to process');

        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('buyer', $user['user_types']))) {
            $response['success'] = true;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a buyer');
        }

        echo json_encode($response);
    }

//    public function product_purchase() {
//        $user = authentication(false);
//
//        if (isset($user['id']) && ($user['id'] != '')) {
//            $productId = $this->uri->segment(3);
//            $productName = $this->uri->segment(4);
//            $product = $this->Product_model->single_product($productId)[0];
//
//            if (empty($product)) {
//                redirect(base_url(), 'refresh');
//            }
//
//            $this->commonData['user'] = $user;
//            $this->commonData['productId'] = $productId;
//            $this->commonData['productName'] = $productName;
//            $this->commonData['product'] = $product;
//            $this->loadScreen('frontend/products/product_purchase');
//        } else {
//            $currentURL = current_url();
//            $_SESSION['user_data_url']['login_return_url'] = $currentURL;
//            redirect(base_url("sign-in"), 'refresh');
//            exit();
//        }
//    }

    public function send_purchase_request() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('buyer', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');

            $productId = $this->uri->segment(3);
            $sellerId = $this->uri->segment(5);
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('phone', 'phone', 'required|max_length[10]|min_length[10]|greater_than[0]');
            $this->form_validation->set_rules('address', 'address', 'required');
            $this->form_validation->set_rules('message', 'message', 'required');
            $post = $this->input->post();

            $la_post['product_id'] = $productId;
            $la_post['buyer_id'] = $uid;
            $la_post['submitted_name'] = $post['name'];
            $la_post['submitted_phone'] = $post['phone'];
            $la_post['submitted_address'] = $post['address'];
            $la_post['message'] = $post['message'];
            $la_post['created_on'] = date('Y-m-d H:i:s');
            $la_post['last_update'] = date('Y-m-d H:i:s');
            $la_post['status'] = 'pending';
//            print_r($mailBody);
//            die;
            if ($this->form_validation->run() == FALSE) {
                $response['msg'] = str_replace(["<p>"], " ", validation_errors());
                $response['msg'] = str_replace(["</p>"], "<br>", $response['msg']);
            } else {

                $insertId = $this->Users_model->insertData('purchase_request', $la_post);
                if ($insertId) {

                    $la_notification = [
                        'notification_for_user' => $sellerId,
                        'notification_by_user' => $uid,
                        'notification_type' => 'purchase_request',
                        'act_id' => $insertId,
                        'notification_title' => 'Purchase request',
                        'notification_body' => $post['name'] . " send a purchase request",
                    ];
                    $this->Login_model->save_notification($la_notification);

//========================= START:: Send mail to seller =================================//
                    $sellerData = $this->Users_model->getData('users', array('id' => $sellerId), 'email, first_name');
                    $sellerEmail = $sellerData[0]->email;
                    $sellerName = $sellerData[0]->first_name;
                    $body = "Please check below purchase request details. <br><br>"
                            . "Name: " . $post['name'] . " <br>"
                            . "Phone: " . $post['phone'] . " <br>"
                            . "Address: " . $post['address'] . " <br>"
                            . "Message: " . $post['message'] . " <br>";
                    $mailDataArr = [
                        'username' => $sellerName,
                        'body' => $body,
                    ];

                    $mailBody = $this->load->view('frontend/email/common_format.php', $mailDataArr, TRUE);
                    $this->Login_model->send_mail($sellerEmail, "Submitted purchase request", $mailBody);
//========================== END:: Send mail to seller =================================//

                    $response['success'] = true;
                    $response['data'] = $la_post;
                    $response['msg'] = 'Success';
                }
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a buyer');
//            $currentURL = current_url();
//            $_SESSION['user_data_url']['login_return_url'] = $currentURL;
//            redirect(base_url("sign-in"), 'refresh');
//            exit();
        }
        echo json_encode($response);
    }

    public function add_favorite() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('buyer', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');

            $productId = $this->uri->segment(3);

            $la_post['added_by_user_id'] = $uid;
            $la_post['product_id'] = $productId;
            $la_post['added_datetime'] = date('Y-m-d H:i:s');

            $favorites = $this->Users_model->getData('my_favorites', ['added_by_user_id' => $uid, 'product_id' => $productId]);
            if (empty($favorites)) {
                $insertId = $this->Users_model->insertData('my_favorites', $la_post);
                if ($insertId) {
                    $response['success'] = true;
                    $response['text'] = "<i class='fa fa-heart'></i> Favorite";
                    $response['flag'] = "add";
                    $response['msg'] = 'Added to your favorites';
                }
            } else {
                $return = $this->Users_model->deleteData('my_favorites', ['added_by_user_id' => $uid, 'product_id' => $productId]);
                if ($return) {
                    $response['success'] = true;
                    $response['text'] = "<i class='fa fa-heart-o'></i> Favorite";
                    $response['flag'] = "remove";
                    $response['msg'] = 'Remove from your favorites';
                }
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a buyer');
        }

        echo json_encode($response);
    }

    public function product_upload() {
        $user = authentication(false);

        if (isset($user['id']) && ($user['id'] != '')) {
            if ($user['type'] != 'seller') {
                redirect(base_url(), 'refresh');
            }
            $productId = $this->uri->segment(3);
            $la_pCategory = $this->Users_model->getData('product_category', array('status' => 1));
            $la_product = [];
            $la_selectedCat = [];
            $product = $this->Users_model->getData('products', array('id' => $productId, 'user_id' => $user['id']));
            if (isset($product[0]) && (!empty($product[0]))) {
                $la_product = $product[0];
                $selectedCat = $this->Users_model->getData('product_categories', array('product_id' => $productId), 'category_id');
                foreach ($selectedCat as $cat) {
                    $la_selectedCat[] = $cat->category_id;
                }
            } elseif ($productId != '') {
                redirect(base_url(), 'refresh');
            }
//            print_r($selectedCat);
//            die;
            $this->commonData['user'] = $user;
            $this->commonData['productId'] = $productId;
            $this->commonData['la_pCategory'] = $la_pCategory;
            $this->commonData['la_product'] = $la_product;
            $this->commonData['la_selectedCat'] = $la_selectedCat;
            $this->loadScreen('frontend/products/product_upload');
        } else {
            $currentURL = current_url();
            $_SESSION['user_data_url']['login_return_url'] = $currentURL;
            redirect(base_url("sign-in"), 'refresh');
            exit();
        }
    }

    public function upload_product_form() {
        $user = authentication(false);
        if (isset($user['id']) && ($user['id'] != '')) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');


            $this->form_validation->set_rules('name', 'product name', 'required');
            $this->form_validation->set_rules('regular_price', 'regular price', 'required|min_length[1]|greater_than[0]');
            $this->form_validation->set_rules('original_manufacture_name', 'original manufacture name', 'required');
            $this->form_validation->set_rules('year_manufactured', 'year manufactured', 'required|min_length[4]|max_length[4]|greater_than[0]');
//            $this->form_validation->set_rules('warranty', 'warranty', 'required');
            $this->form_validation->set_rules('product_condition_id', 'product condition', 'required');
            $this->form_validation->set_rules('notable_defect_id', 'notable defect', 'required');
//            $this->form_validation->set_rules('short_description', 'short description', 'required');
            $this->form_validation->set_rules('long_description', 'long description', 'required');

            $post = $this->input->post();

            $productId = $post['productId'];
            $files = $_FILES;
//            print_r($post);
//            die;
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

            $path = 'products/product/';
            if (isset($files['filename']['name']) && !empty($files['filename']['name'])) { //========= Upload product image in product table===========//
                $file = $files['filename'];

                $ext_arr = explode('.', $file['name']);
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = "_pro_" . time() . "_" . rand(10000, 99999) . '.' . $ext;
            }

            $la_pro_img = [];
            $li_pro_img = 0;
            foreach ($files as $fieldName => $la_file) {//========= Upload product more image in map table===========//
//                $thisFile = $files[$fieldName];
                if ($fieldName != 'filename' && ($la_file['name'] != '')) {
                    $extP = pathinfo($la_file['name'], PATHINFO_EXTENSION);
                    $filenameP = "_pro_" . time() . "_" . rand(10000, 99999) . '.' . $extP;
                    $la_pro_img[$li_pro_img]['fieldName'] = $fieldName;
                    $la_pro_img[$li_pro_img]['orig_name'] = $la_file['name'];
                    $la_pro_img[$li_pro_img++]['filenameP'] = $filenameP;
                }
            }


            if ($this->form_validation->run() == FALSE) {
                $response['msg'] = str_replace(["<p>"], " ", validation_errors());
                $response['msg'] = str_replace(["</p>"], "<br>", $response['msg']);
            } else {
                if (!isset($post['category_id'][0]) || (isset($post['category_id'][0]) && ($post['category_id'][0] == ''))) {
                    $response = array('success' => false, 'data' => $post, 'msg' => 'Product category must be selected!');
                } else {
                    if ($productId == '') { //=========== Insert product===============
                        $la_post['sku'] = $uid . "-" . time();
                        $la_post['user_id'] = $uid;
                        $la_post['created_date'] = time();

                        if (empty($files['filename']['name'])) {
                            $response = array('success' => false, 'data' => $post, 'msg' => 'Please add product image!');
                            echo json_encode($response);
                            exit();
                        }
                        if (!isset($post['location_id'])) {
                            $response = array('success' => false, 'data' => $post, 'msg' => 'Please select product location!');
                            echo json_encode($response);
                            exit();
                        }

                        $insertId = $this->Users_model->insertData('products', $la_post);
                        if ($insertId) {
                            foreach ($post['category_id'] as $category_id) {
                                $this->Users_model->insertData('product_categories', ['product_id' => $insertId, 'category_id' => $category_id, 'created_date' => time()]);
                            }

                            if (isset($post['location_id']) && count($post['location_id']) > 0) {
                                foreach ($post['location_id'] as $city_id) {
                                    $this->Users_model->insertData('products_location_map', ['product_id' => $insertId, 'city_id' => $city_id]);
                                }
                            }

                            //========= Upload product image in product table===========//
                            if (!empty($files['filename']['name'])) {
                                $filename = $insertId . $filename;

                                if ($this->image_upload($file['name'], $path, $filename, 'filename', 180, 180)) {
                                    $return = $this->Users_model->updateData('products', ['id' => $insertId], ['filename' => $filename]);
                                }
                            }

                            //========= Upload product more image in map table===========//
                            if (count($la_pro_img) > 0) {
                                foreach ($la_pro_img as $proImg) {
                                    $filenameP = $insertId . $proImg['filenameP'];
                                    if ($this->image_upload($proImg['orig_name'], $path, $filenameP, $proImg['fieldName'], 180, 180)) {

                                        $product_images['product_id'] = $insertId;
                                        $product_images['image'] = $filenameP;
                                        $product_images['created_date'] = $product_images['modified_date'] = time();

                                        $return = $this->Users_model->insertData('product_images', $product_images);
                                    }
                                }
                            }


                            $la_post['product_id'] = $insertId;
                            $response['success'] = true;
                            $response['data'] = $la_post;
                            $response['msg'] = 'Product has been successfully uploaded';
                        }
                    } else { //=========== Update product======================
                        if (!isset($post['category_id'][0]) || (isset($post['category_id'][0]) && ($post['category_id'][0] == ''))) {
                            $response = array('success' => false, 'data' => $post, 'msg' => 'Product category must be selected!');
                            echo json_encode($response);
                            exit();
                        }
                        if (!isset($post['location_id'])) {
                            $response = array('success' => false, 'data' => $post, 'msg' => 'Please select product location!');
                            echo json_encode($response);
                            exit();
                        }
                        $return = $this->Users_model->updateData('products', ['id' => $productId], $la_post);
                        if ($return) {
                            $this->Users_model->deleteData('product_categories', ['product_id' => $productId]);
                            foreach ($post['category_id'] as $category_id) {
                                $this->Users_model->insertData('product_categories', ['product_id' => $productId, 'category_id' => $category_id, 'created_date' => time()]);
                            }


                            if (isset($post['location_id']) && count($post['location_id']) > 0) {
                                $this->Users_model->deleteData('products_location_map', ['product_id' => $productId]);
                                foreach ($post['location_id'] as $city_id) {
                                    $returnLocationData = $this->Users_model->getData('products_location_map', ['product_id' => $productId, 'city_id' => $city_id]);
                                    if (count($returnLocationData) == 0) {
                                        $this->Users_model->insertData('products_location_map', ['product_id' => $productId, 'city_id' => $city_id]);
                                    }
                                }
                            }


                            if (!empty($files['filename']['name'])) { //========= Upload product image in product table===========//
                                $filename = $productId . $filename;

                                if ($this->image_upload($file['name'], $path, $filename, 'filename', 180, 180)) {
                                    $return = $this->Users_model->updateData('products', ['id' => $productId], ['filename' => $filename]);
                                }
                            }

                            if (count($la_pro_img) > 0) { //========= Upload product more image in map table===========//
                                foreach ($la_pro_img as $proImg) {
                                    $filenameP = $productId . $proImg['filenameP'];
                                    if ($this->image_upload($proImg['orig_name'], $path, $filenameP, $proImg['fieldName'], 180, 180)) {

                                        $product_images['product_id'] = $productId;
                                        $product_images['image'] = $filenameP;
                                        $product_images['created_date'] = $product_images['modified_date'] = time();

                                        $return = $this->Users_model->insertData('product_images', $product_images);
                                    }
                                }
                            }


                            $la_post['product_id'] = $productId;
                            $response['success'] = true;
                            $response['data'] = $la_post;
                            $response['msg'] = 'Product has been successfully updated';
                        }
                    }
                }
            }
        } else {
//            redirect(base_url("sign-in"), 'refresh');
            $response = array('success' => false, 'msg' => 'Please login at first');
        }
        echo json_encode($response);
    }

    public function ajax_product_details() { // get product details for update by modal ========
        $user = authentication(false);
        $response = array('success' => false, 'msg' => 'Unable to process');

        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('seller', $user['user_types']))) {
            $proId = $_POST['proId'];
            $product = $this->Product_model->single_product($proId, $user['id']);
            if ((isset($product[0]) && ($product[0]->id != ''))) {
                $productImgMap = $this->Product_model->single_product_image_map($proId);
                $product_location = $this->Product_model->single_product_location($proId);
                $pCheckboost = $this->Product_model->check_boost_available_for_seller($user['id']);

                $ls_proLocation = "";
                if ($product_location) {
                    foreach ($product_location as $location) {
                        $ls_proLocation .= '<span class="selected_location_span" title="' . $location->COUNTRY . '">'
                                . '<input type="hidden" class="selected_location_input" name="location_id[]" value="' . $location->city_id . '" readonly="">' . $location->CITY . ''
                                . '<i class="fa fa-times remove_selected_location"></i></span>';
                    }
                }

                $noProductImg = UPLOADPATH . 'products/no_product.png';

                $ls_productImgMap = "";

                $pImage = UPLOADDIR . 'products/product/thumb/' . $product[0]->filename;
                if (!file_exists($pImage) || ($product[0]->filename == '')) {
                    $moreImage = $noProductImg;
                } else {
                    $pImage = UPLOADPATH . 'products/product/thumb/' . $product[0]->filename;
                }
                $ls_productImgMap .= '<span class="item more_image_modal_item" id="pImg_' . $proId . '_' . 0 . '"><img src="' . $pImage . '" width="50px"/></span>';

                if ($productImgMap) {
                    foreach ($productImgMap as $la_proImg) {
                        $moreImage = UPLOADDIR . 'products/product/thumb/' . $la_proImg->image;
                        if (!file_exists($moreImage) || ($la_proImg->image == '')) {
                            $moreImage = $noProductImg;
                        } else {
                            $moreImage = UPLOADPATH . 'products/product/thumb/' . $la_proImg->image;
                        }

                        $ls_productImgMap .= '<span class="item more_image_modal_item" id="pImgMap_' . $proId . '_' . $la_proImg->id . '"><img src="' . $moreImage . '" width="50px"/><i class="fa fa-times remove_pro_img_modal"></i></span>';
                    }
                }
                $response['success'] = true;
                $response['data'] = $product[0];
                $response['pCheckboost'] = $pCheckboost;
                $response['ls_productImgMap'] = $ls_productImgMap;
                $response['ls_proLocation'] = $ls_proLocation;
                $response['msg'] = 'success';
            } else {
                $response['success'] = false;
                $response['msg'] = 'Product not available';
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a buyer');
        }

        echo json_encode($response);
    }

    public function remove_pro_img() {
        $user = authentication(false);
        $response = array('success' => false, 'msg' => 'Unable to process');

        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('seller', $user['user_types']))) {
            $imgId = $_POST['imgId'];
            $imgIdArr = explode('_', $imgId);
            $proId = $imgIdArr[1];
            $mapImgId = $imgIdArr[2];

            $product = $this->Product_model->single_product($proId);
            if ((isset($product[0]) && ($product[0]->id != ''))) {
                $productImgMap = $this->Product_model->single_product_image_map($proId, $mapImgId);

                if ((isset($productImgMap[0]) && ($productImgMap[0]->id != ''))) {

                    $moreImage = UPLOADDIR . 'products/product/thumb/' . $productImgMap[0]->image;
                    if (file_exists($moreImage) || ($productImgMap[0]->image != '')) {
                        $moreImage = UPLOADDIR . 'products/product/' . $productImgMap[0]->image;
                        $moreThumbImage = UPLOADDIR . 'products/product/thumb/' . $productImgMap[0]->image;
                        @unlink($moreImage);
                        @unlink($moreThumbImage);
                        $this->Users_model->deleteData('product_images', array('id' => $mapImgId));

                        $response['success'] = true;
                        $response['msg'] = 'success';
                    }
                }
            } else {
                $response['success'] = false;
                $response['msg'] = 'Product not available';
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a buyer');
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

//    public function change_product_status() {  // Change product active or archived by ajax
//        $user = authentication(false);
//        if (isset($user['id']) && ($user['id'] != '')) {
//            $uid = $user['id'];
//            $response = array('success' => false, 'msg' => 'Unable to process');
//
//            $productId = $this->uri->segment(3);
//
//            $product = $this->Users_model->getData('products', ['user_id' => $uid, 'id' => $productId]);
//            if (isset($product[0]) && !empty($product[0])) {
//                $status = $product[0]->status;
//                $newStatus = ($status == 0) ? 1 : 0;
//                $ls_newStatus = ($status == 0) ? "active" : "archived";
//                $this->Users_model->updateData('products', ['id' => $productId], array('status' => $newStatus, 'modified_date' => time()));
//
//                $response['success'] = true;
//                $response['flag'] = $newStatus;
//                $response['msg'] = "Product $ls_newStatus successfully";
//            } else {
//                $response = array('success' => false, 'msg' => 'Something is wrong please reload!');
//            }
//        } else {
//            $response = array('success' => false, 'msg' => 'Please login at first!');
//        }
//
//        echo json_encode($response);
//    }

    public function message_to_seller() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('buyer', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');

            $productId = $this->uri->segment(3);
            $sellerId = $this->uri->segment(4);
            $this->form_validation->set_rules('subject', 'name', 'required');
            $this->form_validation->set_rules('message', 'message', 'required');
            $post = $this->input->post();

            $la_post['send_to'] = $sellerId;  // seller id
            $la_post['send_from'] = $uid; // buyer_id
            $la_post['product_id'] = $productId;
            $la_post['subject'] = $post['subject'];
            $la_post['message'] = $post['message'];
            $la_post['created_on'] = date('Y-m-d H:i:s');
            $la_post['updated_on'] = date('Y-m-d H:i:s');
            $la_post['ip'] = get_client_ip();

//            print_r($mailBody);
//            die;
            if ($this->form_validation->run() == FALSE) {
                $response['msg'] = str_replace(["<p>"], " ", validation_errors());
                $response['msg'] = str_replace(["</p>"], "<br>", $response['msg']);
            } else {

                $insertId = $this->Users_model->insertData('message_chatting', $la_post);
                if ($insertId) {

                    $la_notification = [
                        'notification_for_user' => $sellerId,
                        'notification_by_user' => $uid,
                        'notification_type' => 'message',
                        'act_id' => $insertId,
                        'notification_title' => 'Message from product page',
                        'notification_body' => $post['subject'] . " send a message",
                    ];
                    $this->Login_model->save_notification($la_notification);

                    $response['success'] = true;
                    $response['data'] = $la_post;
                    $response['msg'] = 'Submitted successfully';
                }
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a buyer');
        }
        echo json_encode($response);
    }

    public function ajax_purchase_requests_details() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('seller', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');
            $puchase_details = $_POST['puchase_details'];
            $puchase_detailsArr = explode("__", $puchase_details);
            $puchaseId = $puchase_detailsArr[1];
            $la_purchaseRequests = $this->Product_model->my_purchase_requests($uid, [], $puchaseId);

            if (count($la_purchaseRequests) > 0) {
                $response['success'] = true;
                $response['data'] = $la_purchaseRequests[0];
                $response['msg_id_for_chat'] = "viewDetailsForPurchase###" . $uid . "__" . $la_purchaseRequests[0]->buyer_id . "__" . $puchaseId . "__purchase";
                $response['msg'] = "Success";
            } else {
                $response = array('success' => false, 'msg' => 'Purchase request not found.');
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a buyer');
        }
        echo json_encode($response);
    }

    public function ajax_purchase_requests_status_update() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('seller', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');
            $puchase_details = $_POST['purchase_requests_data'];
            $new_status = $_POST['new_status'];
            $puchase_detailsArr = explode("__", $puchase_details);
            $puchaseId = $puchase_detailsArr[1];

            $la_purchaseRequests = $this->Product_model->my_purchase_requests($uid, [], $puchaseId);
		
            if (count($la_purchaseRequests) > 0) {
                $status = $la_purchaseRequests[0]->status;
                if ($status == 'pending') {
                    $return = $this->Users_model->updateData('purchase_request', ['purchase_request_id' => $puchaseId], array('status' => $new_status, 'last_update' => date('Y-m-d H:i:s')));

                    if ($return) {
						$paymentLink = base_url("product-purchase-payment/$puchaseId");
                        $la_chatField['send_to'] = $la_purchaseRequests[0]->buyer_id;
                        $la_chatField['send_from'] = $uid;
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
                } else {
                    $response['success'] = false;
                    $response['msg'] = "Purchase already $status";
                }
//
            } else {
                $response = array('success' => false, 'msg' => 'Purchase request not found.');
            }
        } else {
            $response = array('success' => false, 'msg' => 'Please login as a buyer');
        }
        echo json_encode($response);
    }

    public function ajax_buyer_dashboard_search_product_autocomplete() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('buyer', $user['user_types']))) {
            $response = array('success' => false, 'msg' => 'Unable to process');
            $proName = $_POST['proName'];

            $limit['limit'] = 10;
            $limit['offset'] = 0;
            $la_searchProduct = $this->Product_model->getProductList(0, 0, $limit, $proName, 'p.name', 'p.name');

            $ls_productName = '';
            if (count($la_searchProduct) > 0) {
                $ls_productName = "<ul>";
                foreach ($la_searchProduct as $lo_product) {
                    $ls_productName .= "<li class='auto_pro_name'>" . str_replace($proName, "<b>$proName</b>", $lo_product->name) . "</li>";
                }
                $ls_productName .= "</ul>";
                $response['data'] = $ls_productName;
            }

            $response['success'] = true;
            $response['msg'] = "Success";
        } else {
            $response = array('success' => false, 'msg' => 'Please login');
        }
        echo json_encode($response);
    }

    public function ajax_buyer_dashboard_search_product() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('buyer', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');
            $proName = $_POST['proName'];

            $currentPage = 1;
            if (isset($_GET['pg']) && ($_GET['pg'] > 0)) {
                $currentPage = $_GET['pg'];
            }
            $limit['limit'] = ITEM_PRODACT;
            $limit['offset'] = (($currentPage - 1 ) * ITEM_PRODACT);
            $li_searchProduct_count = $this->Product_model->getProductList_count(0, 0, $proName)[0]->count;
            $la_searchProduct = $this->Product_model->getProductList(0, 0, $limit, $proName);


            ob_start();
            include(APPPATH . 'views/frontend/user/include_buyer_dashboard.php');
            $output = ob_get_clean();

            $response['success'] = true;
            $response['data'] = $output;
            $response['msg'] = "Success";
        } else {
            $response = array('success' => false, 'msg' => 'Please login');
        }
        echo json_encode($response);
    }

    public function ajax_add_remove_boost_product() {
        $user = authentication(false);
        if ((isset($user['id']) && ($user['id'] != '')) && (in_array('buyer', $user['user_types']))) {
            $uid = $user['id'];
            $response = array('success' => false, 'msg' => 'Unable to process');

            if ((isset($user['id']) && ($user['id'] != '')) && (in_array('seller', $user['user_types']))) {
                $proId = $_POST['proId'];
                $product = $this->Product_model->single_product($proId, $user['id']);
                if ((isset($product[0]) && ($product[0]->id != ''))) {
                    $is_boost = $product[0]->is_boost;

                    if ($is_boost == 1) {
                        $return = $this->Users_model->updateData('products', ['id' => $proId, 'user_id' => $uid, 'status' => 1], ['is_boost' => 0]);

                        if ($return) {
                            $response['success'] = true;
                            $response['msg'] = "Product removed from boost";
                        }
                    } else {
                        $pCheckboost = $this->Product_model->check_boost_available_for_seller($user['id']);
//                    die($pCheckboost);
                        if ($pCheckboost == 'no_boost') {
                            $response = array('success' => false, 'msg' => 'No product available for boost');
                        } else {
                            $return = $this->Users_model->updateData('products', ['id' => $proId, 'user_id' => $uid, 'status' => 1], ['is_boost' => 1]);

                            if ($return) {
                                $response['success'] = true;
                                $response['msg'] = "Product added to boost";
                            }
                        }
                    }
                }
            } else {
                $response = array('success' => false, 'msg' => 'Please login');
            }
            echo json_encode($response);
        }
    }

}
