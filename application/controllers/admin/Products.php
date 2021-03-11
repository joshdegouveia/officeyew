<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * 
 */
class Products extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->library('image_lib');

        if ($this->userLogged() == false) {
            // redirect them to the login page
            redirect('admin/auth/login', 'refresh');
            exit;
        }
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function order() {
        $user = $this->ion_auth->user()->row();
        $this->commonData['activeMenues']['menuParent'] = 'order';
        $this->commonData['activeMenues']['menuChild'] = 'order';

        $this->commonData['title'] = "Product Orders";
        $this->load->model('Users_model');
        $product_orders = $this->Product_model->getOrders($user->id, ADMIN);

        $this->commonData['products'] = $product_orders;
        $this->loadScreen('product_orders');
    }

    public function commission() {
        if ($this->input->post('type')) {
            $post = $this->input->post();

            $fields = array(
                'flat_rate' => 0,
                'percentage' => 0,
                'created_date' => time(),
                'modified_date' => time(),
            );

            if ($post['type'] == 'flat_rate') {
                $fields['flat_rate'] = $post['flat_rate'];
            } else {
                $fields['percentage'] = $post['percentage'];
            }

            $this->Product_model->updateData('commissions', array('type' => 'all'), $fields);
            $this->session->set_flashData('msg_success', 'Commission setting successfully updated.');
        }

        $this->commonData['activeMenues']['menuParent'] = 'commission';
        $this->commonData['activeMenues']['menuChild'] = 'commission-setting';

        $this->commonData['title'] = "Commission Setting";
        $this->load->model('Users_model');
        $commission = $this->Users_model->getData('commissions');
        $this->commonData['commission'] = $commission[0];

        $this->loadScreen('commission');
    }

    public function lists($type = '') {
        $sellerId = '';

        if (isset($_GET['sellerId']) && ($_GET['sellerId'] != '')) {
            $sellerId = $_GET['sellerId'];
        }

        $this->commonData['activeMenues']['menuParent'] = 'products';
        $this->commonData['activeMenues']['menuChild'] = $type . '-product-list';

        $this->commonData['title'] = ucwords($type) . " Product List";
        $products = $this->Product_model->getProducts('admin_list', '', [], $sellerId);
        $this->commonData['products'] = $products;

        $this->loadScreen('product_list');
    }

    public function categories() {
        $this->commonData['activeMenues']['menuParent'] = 'products';
        $this->commonData['activeMenues']['menuChild'] = 'product-category';

        $this->commonData['title'] = "Product Categories";
        $this->load->model('Users_model');
        // $product_categories = $this->Users_model->getData('product_category');
        $product_categories = $this->Product_model->getProductCategories('admin_list_categories');
        $this->commonData['product_categories'] = $product_categories;

        $this->loadScreen('product_categories');
    }

    public function changeStat() {
        $this->load->model('Users_model');
        $action = ($this->input->get('act')) ? $this->input->get('act') : '';

        if (empty($action)) {
            redirect('admin/dashboard', 'refresh');
        }

        $stat = ($this->input->get('stat') && $this->input->get('stat') == '1') ? 0 : 1;
        $fields = array(
            'status' => $stat
        );
        $id = 0;
        $table = '';
        $return = '';

        switch ($action) {
            case 'pcat':
                $id = ($this->input->get('cid')) ? $this->input->get('cid') : 0;
                $table = 'product_category';
                $return = 'categories';
                break;
            case 'prod':
                $id = ($this->input->get('cid')) ? $this->input->get('cid') : 0;
                $table = 'products';
                $return = 'lists/seller';
                break;
        }

        if ($id == 0) {
            redirect('admin/dashboard', 'refresh');
        }

        $this->Users_model->updateData($table, array('id' => $id), $fields);
        redirect('admin/products/' . $return, 'refresh');
    }

    public function delete() {
        $action = ($this->input->get('act')) ? $this->input->get('act') : '';

        if (empty($action)) {
            redirect('admin/dashboard', 'refresh');
        }

        switch ($action) {
            case 'pcat':
                $id = ($this->input->get('cid')) ? $this->input->get('cid') : 0;
                $table = 'product_category';
                $this->Product_model->deleteData($table, array('id' => $id));
                $this->session->set_flashData('msg_success', 'Product category successfully deleted.');
                redirect('admin/products/categories', 'refresh');
                break;
            case 'prod':
                $id = ($this->input->get('cid')) ? $this->input->get('cid') : 0;
                $table = 'products';
                $this->Product_model->deleteData($table, array('id' => $id));

                $table2 = 'product_categories';
                $this->Product_model->deleteData($table2, array('product_id' => $id));

                $this->session->set_flashData('msg_success', 'Product category successfully deleted.');
                redirect('admin/products/lists/seller', 'refresh');
                break;
            case 'pord_order':
                $id = ($this->input->get('pid')) ? $this->input->get('pid') : 0;
                $table = 'product_orders';
                $this->Product_model->deleteData($table, array('id' => $id));
                $this->session->set_flashData('msg_success', 'Product order successfully deleted.');
                redirect('admin/products/order', 'refresh');
                break;
            case 'boost':
                $id = ($this->input->get('cid')) ? $this->input->get('cid') : 0;
                $type = ($this->input->get('type')) ? $this->input->get('type') : 0;

                $table = 'boost_product_charges';
                $this->Product_model->deleteData($table, array('boost_id' => $id));
                $this->session->set_flashData('msg_success', 'Product boost successfully deleted.');
                redirect('admin/products/boost/' . $type, 'refresh');
                break;
        }

        redirect('admin/dashboard', 'refresh');
    }

    public function editProductCategory() {
        $pid = ($this->input->get('pid')) ? $this->input->get('pid') : '';

        if (empty($pid)) {
            redirect('admin/products/categories', 'refresh');
        }

        $this->addProductCategory($pid);
    }

    public function edit() {
        $pid = ($this->input->get('pid')) ? $this->input->get('pid') : '';

        if (empty($pid)) {
            redirect('admin/products/lists/seller', 'refresh');
        }
        $this->commonData['activeMenues']['menuParent'] = 'Products';
        $this->commonData['activeMenues']['menuChild'] = 'products';

        $this->commonData['title'] = "Edit Product";
        $product = $this->db->select('*')->from('products')->where(array('id' => $pid))->get()->result();
        $imagee = $product[0]->filename;
        $sellers = $this->db->select('*')->from('users')->where(array('active' => 1, 'type' => 'seller'))->get()->result();
        $categories = $this->db->select('*')->from('product_category')->where(array('status' => 1))->get()->result();


        $product_categories = $this->db->select('product_category.id')->from('product_category')->where(array('product_category.status' => 1, 'product_categories.product_id' => $pid))->join('product_categories', 'product_categories.category_id = product_category.id', 'inner')->get()->result_array();
        //echo '<pre>';
        //print_r($product_categories);
        $prod_cat = array();
        if (count($product_categories) > 0) {
            foreach ($product_categories as $prodcat) {
                $prod_cat[] = $prodcat['id'];
            }
        }
        if (count($_POST) > 0) {
            $name = $this->input->post('name');
            $pid = $this->input->post('pid');
            $short_description = $this->input->post('short_description');
            $long_description = $this->input->post('long_description');
            $price = $this->input->post('regular_price');
            $user_id = $this->input->post('user_id');
            $status = $this->input->post('status');
            $category_id = $this->input->post('category_id');
            //print_r($_FILES['ufile']);

            if (!empty($_FILES['ufile']['name'])) {
                $file = $_FILES['ufile'];
                $path = 'products/product/';
                $upload_dir = UPLOADDIR . $path;
                $thumb_path = 'thumb/';
                if ($_SERVER['HTTP_HOST'] == 'localhost') {
                    $path = 'products\\product\\';
                    $upload_dir = UPLOADDIR . $path;
                    $thumb_path = 'thumb\\';
                }

                folderCheck($upload_dir . $thumb_path);

                $folder_path = $upload_dir . "/";
                $ext_arr = explode('.', $file['name']);

                $config['upload_path'] = $folder_path;
                $config['allowed_types'] = 'png|gif|jpg|jpeg';
                $config['max_size'] = '0';
                $config['max_width'] = '0';
                $config['max_height'] = '0';
                $config['overwrite'] = TRUE;
                $image = 'product_' . time() . '.' . end($ext_arr);
                $config['file_name'] = $image;
                $config['orig_name'] = $file['name'];
                $config['image'] = $image;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('ufile')) {
                    //generate the thumbnail photo from the main photo
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $folder_path . $config['image'];
                    $config['new_image'] = $folder_path . $thumb_path . $config['image'];
                    $config['thumb_marker'] = '';
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 698;
                    $config['height'] = 399;
                    $this->load->library('upload', $config);
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    //generate the thumbnail photo from the main photo
                    if (!empty($product)) {
                        if (!empty($product[0]->filename)) {
                            @unlink($folder_path . $product[0]->filename);
                            @unlink($folder_path . $thumb_path . $product[0]->filename);
                        }
                    }
                }
            } else {
                if (!empty($pid)) {
                    $image = $product[0]->filename;
                }
            }


            if (!empty($pid)) {
                $this->db->where(array('id' => $pid));
                $this->db->update('products', array('name' => $name, 'short_description' => $short_description, 'long_description' => $long_description, 'regular_price' => $price, 'user_id' => $user_id, 'status' => $status, 'filename' => $image));
                if (count($category_id) > 0) {
                    $this->db->delete('product_categories', array('product_id', $pid));
                    foreach ($category_id as $cat_id) {
                        $this->db->insert('product_categories', array('product_id' => $pid, 'category_id' => $cat_id, 'created_date' => strtotime(date('Y-m-d'))));
                    }
                }
            }
            redirect('admin/products/edit/' . $pid, 'refresh');
            exit;
        }
        $this->commonData['product'] = $product[0];
        $this->commonData['sellers'] = $sellers;
        $this->commonData['categories'] = $categories;
        $this->commonData['product_categories'] = $product_categories;
        $this->commonData['prod_cat'] = $prod_cat;
        $this->loadScreen('add_product');
    }

    public function addProductCategory($pid = '') {
        $this->commonData['activeMenues']['menuParent'] = 'products';
        $this->commonData['activeMenues']['menuChild'] = 'product-category';
        $this->load->model('Users_model');

        $this->commonData['title'] = "Product Category";
        $product = array();
        $user = $this->ion_auth->user()->row();

        if (!empty($pid)) {
            $product = $this->Users_model->getData('product_category', array('id' => $pid));
            if (empty($product)) {
                redirect('admin/products/categories', 'refresh');
            }
            $product = $product[0];
        }

        $image = '';

        if (!empty($_FILES['ufile']['name'])) {
            $file = $_FILES['ufile'];

            $path = 'products/product_categories/';
            $upload_dir = UPLOADDIR . $path;
            $thumb_path = 'thumb/';
            if ($_SERVER['HTTP_HOST'] == 'localhost') {
                $path = 'products\\product_categories\\';
                $upload_dir = UPLOADDIR . $path;
                $thumb_path = 'thumb\\';
            }

            folderCheck($upload_dir . $thumb_path);

            $folder_path = $upload_dir . "/";
            $ext_arr = explode('.', $file['name']);

            $config['upload_path'] = $folder_path;
            $config['allowed_types'] = 'png|gif|jpg|jpeg';
            $config['max_size'] = '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['overwrite'] = TRUE;
            $image = 'prodcate_' . time() . '_' . $user->user_id . '.' . end($ext_arr);
            $config['file_name'] = $image;
            $config['orig_name'] = $file['name'];
            $config['image'] = $image;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('ufile')) {
                //generate the thumbnail photo from the main photo
                $config['image_library'] = 'gd2';
                $config['source_image'] = $folder_path . $config['image'];
                $config['new_image'] = $folder_path . $thumb_path . $config['image'];
                $config['thumb_marker'] = '';
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 698;
                $config['height'] = 399;
                $this->load->library('upload', $config);
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                //generate the thumbnail photo from the main photo
                if (!empty($product)) {
                    if (!empty($product->filename)) {
                        @unlink($folder_path . $product->filename);
                        @unlink($folder_path . $thumb_path . $product->filename);
                    }
                }
            }
        } else {
            if (!empty($product)) {
                $image = $product->filename;
            }
        }

        if ($this->input->post('name')) {

            $post = $this->input->post();
            $slug = strtolower(preg_replace('/[^a-z0-9]/i', '-', $post['name']));

            $fields = array(
                'name' => $post['name'],
                'slug' => $slug,
                'filename' => $image,
                'modified_date' => time(),
            );

            if (!empty($pid)) {
                $this->Users_model->updateData('product_category', array('id' => $pid), $fields);
                $this->session->set_flashData('msg_success', 'Product category successfully updated.');
            } else {
                $fields['created_by'] = $user->user_id;
                $fields['created_date'] = time();
                $this->Users_model->insertData('product_category', $fields);
                $this->session->set_flashData('msg_success', 'Product category successfully added.');
            }

            redirect(base_url('admin/products/categories'), 'refresh');
        }

        $this->commonData['product'] = $product;
        $this->loadScreen('add_product_category');
    }

    public function boost() {
        $cat_id = $this->uri->segment(4);
        $this->commonData['activeMenues']['menuParent'] = 'boost';
        $this->commonData['activeMenues']['menuChild'] = 'Boost';

        $this->commonData['title'] = "Product Boost";


        $this->db->select('bpc.*,boost_product_category.cat_name,boost_product_category.cat_id');
        $this->db->from('boost_product_charges bpc');
        $this->db->where(array('boost_product_category.cat_id' => $cat_id));
        $this->db->join('boost_product_category', 'bpc.boost_cat_id = boost_product_category.cat_id', 'inner');
        $this->db->order_by('bpc.boost_id', 'DESC');
        $boost_lists = $this->db->get()->result();



        $this->commonData['datas'] = $boost_lists;
        if ($cat_id == 1) {
            $this->loadScreen('product-boost-subscription');
        } elseif ($cat_id == 2) {
            $this->loadScreen('product-boost-onetime');
        }
    }

    public function add_product_boost() {
        $boost_id = $this->input->get('boost_id');
        $this->commonData['activeMenues']['menuParent'] = 'boost';
        $this->commonData['activeMenues']['menuChild'] = 'Boost';
        $this->commonData['title'] = " Add Product Boost";


        if (!empty($boost_id)) {
            $boost_product = $this->db->select('*')->from('boost_product_charges')->where(array('boost_id' => $boost_id))->get()->result();
            //print_r($boost_product);
            $this->commonData['boost_product'] = $boost_product[0];
        }

        if (count($_POST) > 0) {
            $boost_type = $this->input->post('boost_type');
            if ($boost_type == 1) {
                $month_wise_price = $this->input->post('month_wise_price');
                $no_of_product = $this->input->post('no_of_product2');
				$description = $this->input->post('description');
                $product_posting_type = $this->input->post('product_posting_type');
				if (empty($boost_id)) {
					$insert_id = $this->db->insert('boost_product_charges', array('month_wise_price' => $month_wise_price, 'no_of_product' => $no_of_product, 'product_posting_type' => $product_posting_type, 'boost_cat_id' => $boost_type, 'status' => 1,'description' => $description));
                    if ($insert_id) {
                        redirect(base_url('admin/products/boost/' . $boost_type), 'refresh');
                        $this->session->set_flashData('msg_success', 'Product boost successfully added.');
                    }
                } else {
                    $this->db->where(array('boost_id' => $boost_id));
					$insert_id = $this->db->update('boost_product_charges', array('month_wise_price' => $month_wise_price, 'no_of_product' => $no_of_product, 'product_posting_type' => $product_posting_type, 'boost_cat_id' => $boost_type, 'status' => 1,'description' => $description));
                    redirect(base_url('admin/products/boost/' . $boost_type), 'refresh');
                    $this->session->set_flashData('msg_success', 'Product boost successfully updated.');
                }
            } elseif ($boost_type == 2) {
                $week_time = $this->input->post('week_time');
                $week_wise_price = $this->input->post('week_wise_price');
                $no_of_weeks = $this->input->post('no_of_weeks');
                $no_of_product = $this->input->post('no_of_product');
				$description = $this->input->post('description');
				if (empty($boost_id)) {
					$insert_id = $this->db->insert('boost_product_charges', array('week_wise_price' => $week_wise_price, 'no_of_weeks' => $no_of_weeks, 'no_of_product' => $no_of_product, 'boost_cat_id' => $boost_type, 'status' => 1,'description' => $description));
                    if ($insert_id) {
                        redirect(base_url('admin/products/boost/' . $boost_type), 'refresh');
                        $this->session->set_flashData('msg_success', 'Product boost successfully updated.');
                    }
                } else {
                    $this->db->where(array('boost_id' => $boost_id));
					$insert_id = $this->db->update('boost_product_charges', array('week_wise_price' => $week_wise_price, 'no_of_weeks' => $no_of_weeks, 'no_of_product' => $no_of_product, 'boost_cat_id' => $boost_type, 'status' => 1,'description' => $description));
                    redirect(base_url('admin/products/boost/' . $boost_type), 'refresh');
                    $this->session->set_flashData('msg_success', 'Product boost successfully updated.');
                }
            }
        }

        $this->loadScreen('add-product-boost');
    }

    public function changeBoostStat() {
        $boost_id = ($this->input->get('boost_id')) ? $this->input->get('boost_id') : '';
        $stat = ($this->input->get('stat') && $this->input->get('stat') == '1') ? '0' : '1';
        $boost_type = ($this->input->get('boost_type')) ? $this->input->get('boost_type') : '';

        if (empty($boost_id)) {
            redirect('admin/products/boost/' . $boost_type, 'refresh');
        }
        $fields = array(
            'status' => $stat
        );
        $this->db->update('boost_product_charges', $fields, array('boost_id' => $boost_id));
        //echo $this->db->last_query();
        //exit;
        redirect('admin/products/boost/' . $boost_type, 'refresh');
    }

    public function tax_for_city() {
        $this->load->model('Cms_model');
        $la_data = $this->Cms_model->getCityData();
        $this->commonData['activeMenues']['menuParent'] = 'commission';
        $this->commonData['activeMenues']['menuChild'] = 'city_tax';

        $this->commonData['title'] = "Tax";

        $this->commonData['la_data'] = $la_data;

        $this->loadScreen('location/city_list');
    }

    public function ajax_update_tax() {
        $response = array('success' => false, 'msg' => 'Unable to process');
        $thisId = $_POST['thisId'];
        $thisVal = $_POST['thisVal'];
        $thisIdArr = explode('_', $thisId);

        if (is_numeric($thisVal)) {
            if ($thisIdArr[0] == 'taxFlat') {
                $this->db->update('location_cities', ['tax_in_flat' => $thisVal], array('ID' => $thisIdArr[1]));
            } else {
                $this->db->update('location_cities', ['tax_in_percentage' => $thisVal], array('ID' => $thisIdArr[1]));
            }
            $response['success'] = true;
//            $response['data'] = $output;
            $response['msg'] = 'success';
        } else {
            $response = array('success' => false, 'msg' => 'Please enter correct value');
        }

        echo json_encode($response);
    }

}
