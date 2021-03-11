<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertData($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function deleteData($table, $where) {
        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }

        $this->db->delete($table);
    }

    function updateData($table, $where, $data) {
        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }

        $this->db->update($table, $data);
    }

    function insertBatch($table, $data) {
        $this->db->insert_batch($table, $data);
    }

//    function getProductCategory($limit = []) {
//        $this->db->select('pc.*');
//        $this->db->from('product_category pc');
//        $this->db->join('product_categories pcs', 'pcs.category_id = pc.id', 'left');
//        $this->db->join('products p', 'p.id = pcs.product_id', 'left');
//        $this->db->join('users u', 'u.id = p.user_id', 'left');
//        $this->db->where('pc.status', 1);
//        $this->db->where('p.status', 1);
//        $this->db->where('u.active', 1);
//
//        if (!empty($limit)) {
//            $this->db->limit($limit['limit'], $limit['offset']);
//        }
////        $this->db->order_by('p.id', 'DESC');
////        $this->db->group_by('p.id');
//        $query = $this->db->get();
//        $la_productList = $query->result();
//        print_r($la_productList);die;
//        return $la_productList;
//        
//    }
    function getProductList_count($catId = 0, $sellerId = 0, $proName = '') {
        $this->db->select('COUNT(DISTINCT(p.id)) count');
        $this->db->from('products p');
        $this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'left');
        $this->db->join('users u', 'u.id = p.user_id', 'left');
        if ($catId != 0) {
            $this->db->where('pcs.category_id', $catId);
        }
        if ($sellerId != 0) {
            $this->db->where('p.user_id', $sellerId);
        }
        if ($proName != '') {
            $this->db->where("p.name LIKE '%$proName%'");
        }
        $this->db->where('p.status', 1);
        $this->db->where('u.active', 1);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        exit;
        $la_productList = $query->result();
        return $la_productList;
    }

    function getProductList($catId = 0, $sellerId = 0, $limit = [], $proName = '', $fields = '', $group_by = '', $orderBy = []) {  // Get product list by categoty id && seller id
        if ($fields != '') {
            $this->db->select("$fields");
        } else {
            $this->db->select('p.*, pc.name category_name, pc.id category_id, u.first_name, u.last_name, sfb.subscription_for_boost_id, pm.image');
        }
        $this->db->from('products p');
        $this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'left');
        $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
        $this->db->join('users u', 'u.id = p.user_id', 'left');
        $this->db->join('subscription_for_boost sfb', "sfb.user_id = p.user_id AND sfb.status = 'A'", 'left');
		$this->db->join('product_images pm', "pm.product_id = p.id", 'left');
        if ($catId != 0) {
            $this->db->where('pcs.category_id', $catId);
        }
        if ($sellerId != 0) {
            $this->db->where('p.user_id', $sellerId);
        }
        if ($proName != '') {
            $this->db->where("p.name LIKE '%$proName%'");
        }
        $this->db->where('p.status', 1);
        $this->db->where('u.active', 1);

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        if (!empty($orderBy)) {
            $this->db->order_by($orderBy['orderBy'], $orderBy['type']);
        } else {
            $this->db->order_by('p.id', 'DESC');
        }
        if ($group_by == '') {
            $this->db->group_by('p.id');
        } else {
            $this->db->group_by($group_by);
        }
        $query = $this->db->get();
        $la_productList = $query->result();
//        print_r($la_productList);
        return $la_productList;
    }

    function getProductList_home($sellerId = 0, $limit = [], $orderBy = [], $currentCity = '') {  // Get product list by categoty id && seller id
        $this->db->select('p.*, sfb.subscription_for_boost_id');
        $this->db->from('products p');
        $this->db->join('users u', 'u.id = p.user_id', 'left');
        $this->db->join('subscription_for_boost sfb', "sfb.user_id = p.user_id AND sfb.status = 'A'", 'left');
        $this->db->join('products_location_map plm', "plm.product_id = p.id", 'left');
        $this->db->join('location_cities lc', "lc.ID = plm.city_id", 'left');

        if ($sellerId != 0) {
            $this->db->where("p.user_id != $sellerId");
        }
        if ($currentCity != '') {
            $this->db->where("lc.CITY = '$currentCity'");
        }
        $this->db->where('p.status', 1);
        $this->db->where('u.active', 1);

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        if (!empty($orderBy)) {
            $this->db->order_by($orderBy['orderBy'], $orderBy['type']);
        } else {
            $this->db->order_by('p.id', 'DESC');
        }
        $this->db->group_by('p.id');  // GROUP BY ERROR
        $query = $this->db->get();
        $la_productList = $query->result();

//        print_r(($limit['limit'] - count($la_productList)));
        if ($limit['limit'] > count($la_productList)) {
            $this->db->select('p.*, sfb.subscription_for_boost_id');
            $this->db->from('products p');
            $this->db->join('users u', 'u.id = p.user_id', 'left');
            $this->db->join('subscription_for_boost sfb', "sfb.user_id = p.user_id AND sfb.status = 'A'", 'left');
            $this->db->join('products_location_map plm', "plm.product_id = p.id", 'left');
            $this->db->join('location_cities lc', "lc.ID = plm.city_id", 'left');

            if ($sellerId != 0) {
                $this->db->where("p.user_id != $sellerId");
            }
            if ($currentCity != '') {
                $this->db->where("lc.CITY != '$currentCity'");
            }
            $this->db->where('p.status', 1);
            $this->db->where('u.active', 1);

            if (!empty($limit)) {
                $this->db->limit(($limit['limit'] - count($la_productList)), $limit['offset']);
            }
            if (!empty($orderBy)) {
                $this->db->order_by($orderBy['orderBy'], $orderBy['type']);
            } else {
                $this->db->order_by('p.id', 'DESC');
            }
            $this->db->group_by('p.id');  // GROUP BY ERROR
            $query = $this->db->get();
            $la_productList2 = $query->result();
            $la_productList = array_merge($la_productList, $la_productList2);

//            print_r($la_productList2);
        }
        return $la_productList;
    }

    function getProductListgetProductList_search_count($catId = 0, $location = 0) {
        $this->db->select('COUNT(DISTINCT(p.id)) count');
        $this->db->from('products p');
        $this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'left');
        $this->db->join('users u', 'u.id = p.user_id', 'left');
        if ($catId != 0) {
            $this->db->where('pcs.category_id', $catId);
            $this->db->where('p.status', 1);
        }
        if ($location != '') {
            $this->db->where('u.city', "%$location%");
        }
        $this->db->where('u.active', 1);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        exit;
        $la_productList = $query->result();
        return $la_productList;
    }

    function getProductList_search($catId = 0, $location_id = '', $limit = [], $orderBy = []) {  // Get product list by categoty id && location id
        $this->db->select('p.*, pc.name category_name, u.first_name, u.last_name');
        $this->db->from('products p');
        $this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'left');
        $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
        $this->db->join('users u', 'u.id = p.user_id', 'left');
        $this->db->join('products_location_map plm', 'plm.product_id = p.id', 'left');
        if ($catId != 0) {
            $this->db->where('pcs.category_id', $catId);
            $this->db->where('p.status', 1);
        }
        if ($location_id != '') {
            $this->db->where('plm.city_id', $location_id);
        }
        $this->db->where('u.active', 1);

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }

        if (!empty($orderBy)) {
            $this->db->order_by($orderBy['orderBy'], $orderBy['type']);
        } else {
            $this->db->order_by('p.name', 'ASC');
        }
        $this->db->group_by('p.id');
        $query = $this->db->get();
        $la_productList = $query->result();
        return $la_productList;
    }

    function getProducts($action = 'admin_list', $select = '', $where = array(), $sellerId = '') {
        if ($action == 'b2b_user_product_list') {
            $this->db->select('p.*, pi.image, GROUP_CONCAT(pc.name, ", ") AS category');
            $this->db->from('products p');
            $this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'left');
            $this->db->join('product_images pi', '(pi.product_id = p.id AND pi.cover = "yes")', 'left');
            $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
            $this->db->where('p.user_id', $where['user_id']);
            $this->db->group_by('p.id');
            $query = $this->db->get();
            return $query->result();
        } else if ($action == 'b2c_user_product_list') {
            /////Koustav 06-12-2019//////
            $this->db->select('p.*, pi.image, GROUP_CONCAT(pc.name, ", ") AS category, sp.id AS stock_id, sp.b2b_id AS b2bid, sp.regular_price as seller_regular_price, sp.sale_price AS seller_sale_price, sp.stock AS seller_stock, sp.status AS seller_status, sp.created_date AS seller_created_date, sp.modified_date AS seller_modified_date');
            $this->db->from('seller_stock_product sp');
            $this->db->join('products p', 'p.id = sp.product_id', 'left');
            $this->db->join('product_categories pcs', 'pcs.product_id = sp.product_id', 'left');
            $this->db->join('product_images pi', '(pi.product_id = sp.product_id AND pi.cover = "yes")', 'left');
            $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
            $this->db->join('users u', 'u.id = sp.seller_id', 'inner');
            $this->db->where('sp.seller_id', $where['user_id']);
            //pre($this->db->last_query(), 1);
            $this->db->group_by('p.id');
            $query = $this->db->get();
            return $query->result();
        } else if ($action == 'admin_list') {

            $this->db->select('u.id AS user_id, u.first_name, u.last_name, p.*');
            $this->db->select('GROUP_CONCAT(DISTINCT(pc.name)) AS category, GROUP_CONCAT(DISTINCT(pc.slug)) AS cat_slug');
            $this->db->from('products p');
            $this->db->join('users u', 'u.id = p.user_id', 'left');
            $this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'left');
            $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
            $this->db->join('users_groups ug', 'ug.user_id = u.id', 'left');
            $this->db->join('groups g', 'g.id = ug.group_id', 'left');
            if ($sellerId != '') {
                $this->db->where(array('p.user_id' => $sellerId));
            }
//            $this->db->where(array('g.name' => 'seller'));
            $this->db->group_by('p.id');
            $this->db->order_by('p.id', 'DESC');
            $result = $this->db->get()->result();
//            print_r($result);die;

            return $result;
        } else if ($action == 'common_product_list') {
            $this->db->select('p.*, pi.image, GROUP_CONCAT(pc.name, ", ") AS category, pw.id AS wish_id, sp.id AS stock_id, sp.seller_id AS sellerid, sp.b2b_id AS b2bid, sp.regular_price as seller_regular_price, sp.sale_price AS seller_sale_price, sp.stock AS seller_stock, sp.status AS seller_status, sp.created_date AS seller_created_date, sp.modified_date AS seller_modified_date');
            $this->db->from('seller_stock_product sp');
            $this->db->join('products p', 'p.id = sp.product_id', 'left');
            $this->db->join('product_categories pcs', 'pcs.product_id = sp.product_id', 'left');
            $this->db->join('product_images pi', '(pi.product_id = sp.product_id AND pi.cover = "yes")', 'left');
            $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
            $this->db->join('product_wishlist pw', 'p.id = pw.product_id', 'left');
            $this->db->join('users u', 'u.id = sp.seller_id', 'inner');
            $this->db->group_by('p.id');
            $query = $this->db->get();
            return $query->result();
        } else if ($action == 'cart_product') {
            $this->db->select('p.*, pi.image, GROUP_CONCAT(pc.name, ", ") AS category, sp.id AS stock_id, sp.seller_id AS sellerid, sp.b2b_id AS b2bid, sp.regular_price as seller_regular_price, sp.sale_price AS seller_sale_price, sp.stock AS seller_stock, sp.status AS seller_status, sp.created_date AS seller_created_date, sp.modified_date AS seller_modified_date');
            $this->db->from('products p');
            $this->db->join('seller_stock_product sp', 'p.id = sp.product_id', 'left');
            $this->db->join('product_categories pcs', 'pcs.product_id = sp.product_id', 'left');
            $this->db->join('product_images pi', '(pi.product_id = sp.product_id AND pi.cover = "yes")', 'left');
            $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
            $this->db->join('users u', 'u.id = p.user_id', 'inner');
            // $this->db->where_in('p.id', $where['pids']);
            if (!empty($where)) {
                foreach ($where as $k => $value) {
                    // $this->db->where('(' . $k . ' IN (' . implode(',', $value) . '))');
                    $this->db->where_in($k, $value);
                }
            }
            $this->db->group_by('p.id');
            $query = $this->db->get();
            return $query->result();
        } else if ($action == 'releted') {
            $this->db->select('p.*, pi.image, GROUP_CONCAT(pc.name, ", ") AS category, pw.id AS wish_id, sp.id AS stock_id, sp.seller_id AS sellerid, sp.b2b_id AS b2bid, sp.regular_price as seller_regular_price, sp.sale_price AS seller_sale_price, sp.stock AS seller_stock, sp.status AS seller_status, sp.created_date AS seller_created_date, sp.modified_date AS seller_modified_date');
            $this->db->from('seller_stock_product sp');
            $this->db->join('products p', 'p.id = sp.product_id', 'left');
            $this->db->join('product_categories pcs', 'pcs.product_id = sp.product_id', 'left');
            $this->db->join('product_images pi', '(pi.product_id = sp.product_id AND pi.cover = "yes")', 'left');
            $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
            $this->db->join('product_wishlist pw', 'p.id = pw.product_id', 'left');
            $this->db->join('users u', 'u.id = sp.seller_id', 'inner');
            if (!empty($where)) {
                foreach ($where as $key => $val) {
                    if ($key == 'pc.slug') {
                        $this->db->where_in($key, $val);
                    } elseif ($key == 'sp.id') {
                        $this->db->where($key . '!=', $val);
                    } else {
                        $this->db->where($key, $val);
                    }
                }
            }
            $this->db->group_by('p.id');
            $query = $this->db->get();
            return $query->result();
        }
    }

    function getProductCategories($action = '', $uid = 0) {
        if ($action == 'b2b_category') {
            $this->db->select('pc.*');
            $this->db->from('products p');
            $this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'left');
            $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
            $this->db->where('p.user_id', $uid);
            $this->db->group_by('pcs.category_id');
            $query = $this->db->get();
            return $query->result();
        } else if ($action == 'admin_list_categories') {
            $this->db->select('pc.*, u.first_name, u.last_name, u.id AS user_id');
            $this->db->from('product_category pc');
            $this->db->join('users u', 'u.id = pc.created_by', 'left');
            $this->db->order_by("pc.id", "desc");
            $query = $this->db->get();
            return $query->result();
        } else if ($action == 'endorse_reseller_list') {
            $this->db->select('pc.*');
            $this->db->from('product_discount_categories pdc');
            $this->db->join('product_category pc', 'pc.id = pdc.category_id', 'left');
            $this->db->where('pdc.voucher_id', $uid);
            $this->db->group_by('pdc.created_date', 'DESC');
            $query = $this->db->get();
            return $query->result();
        }
    }

    //koustav 29-11-2019///
    function getAllb2bProducts($uid = '', $catslug = '', $current_country = '') {
        if ($uid != '' && $catslug != '') {
            $this->db->select('p.*, pi.image, GROUP_CONCAT(pc.name, ", ") AS category, pw.product_id AS pw_pid, sp.product_id AS sp_pid');
            $this->db->from('products p');
            $this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'left');
            $this->db->join('product_images pi', '(pi.product_id = p.id AND pi.cover = "yes")', 'left');
            $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
            $this->db->join('product_wishlist pw', 'p.id = pw.product_id', 'left');
            $this->db->join('seller_stock_product sp', 'p.id = sp.product_id', 'left');
            $this->db->join('users u', 'u.id = p.user_id', 'left');
            $this->db->where('p.user_id', $uid);
            $this->db->where('pc.slug', $catslug);
            if (!empty($current_country)) {
                $this->db->where('u.country', $current_country);
            }
            $this->db->group_by('p.id');
            $query = $this->db->get();
            return $query->result();
        } else {
            return false;
        }
    }

    function check_user_wishlist($u_id) {
        $this->db->select('product_id');
        $this->db->from('product_wishlist');
        $this->db->where('user_id', $u_id);
        $query = $this->db->get();
        $arr = array_map(function($value) {
            return $value['product_id'];
        }, $query->result_array());
        return $arr;
    }

    function check_seller_stock($u_id) {
        $this->db->select('product_id');
        $this->db->from('seller_stock_product');
        $this->db->where('seller_id', $u_id);
        $query = $this->db->get();
        $arr = array_map(function($value) {
            return $value['product_id'];
        }, $query->result_array());
        return $arr;
    }

    function getUser_wishlistProduct($user_id) {
        $this->db->select('pw.id as pwid,p.*,pi.image');
        $this->db->from('product_wishlist pw');
        $this->db->join('products p', 'p.id = pw.product_id', 'left');
        $this->db->join('product_images pi', '(pi.product_id = pw.product_id AND pi.cover = "yes")', 'left');
        $this->db->where('pw.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    function single_product($pid = '', $sellerId = 0) {
        if ($pid != '') {
            $this->db->select('p.*, pi.image, GROUP_CONCAT(DISTINCT(pcs.category_id)) AS category_id, GROUP_CONCAT(DISTINCT(pc.name)) AS category, GROUP_CONCAT(DISTINCT(pc.slug)) AS cat_slug');
            $this->db->select('pcon.products_condition, pnd.notable_defects');
            $this->db->select('u.first_name, u.last_name, u.email'); // saller information 
            $this->db->from('products p');
            $this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'left');
            $this->db->join('product_images pi', '(pi.product_id = p.id AND pi.cover = "yes")', 'left');
            $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
            $this->db->join('products_condition pcon', 'pcon.products_condition_id = p.product_condition_id', 'left');
            $this->db->join('products_notable_defects pnd', 'pnd.products_notable_defects_id = p.notable_defect_id', 'left');
            $this->db->join('users u', 'u.id = p.user_id', 'left'); // for saller information 
            $this->db->where('p.id', $pid);
            if ($sellerId != 0) {
                $this->db->where('p.user_id', $sellerId);
            }
            $this->db->group_by('p.id');
            $query = $this->db->get();
//            print_r($query->result());die;
            if ($query->result()) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function check_boost_available_for_seller($sellerId = 0) {
        $ls_sql = "SELECT sfb.*, COUNT(DISTINCT(p.id)) boost_products_count"
                . " FROM subscription_for_boost sfb "
                . "LEFT JOIN products p ON p.user_id = sfb.user_id AND is_boost = 1 "
                . "WHERE sfb.user_id = $sellerId AND sfb.status = 'A'"
                . " ORDER BY sfb.subscription_for_boost_id DESC";

        $la_data = $this->db->query($ls_sql)->row();
//        print_r($la_data);die;
        $return = 'no_boost';

        if (empty($la_data)) {
            $return = 'no_boost';
        } else {
            if (isset($la_data->subscription_for_boost_id) && ($la_data->subscription_for_boost_id > 0)) {
                $validTime = strtotime("+$la_data->duration_in_days days", strtotime($la_data->created_at));
                $validDateTime = date('Y-m-d H:i:s', $validTime);

                if (($validTime < time())) {
                    $return = 'no_boost';
                } else {
                    if ($la_data->duration_in_days == 'Unlimited') {
                        $return = 'available';
                    } else {
                        if ($la_data->boost_products_count < $la_data->product_no) {
                            $return = 'available';
                        }
                    }
                }
//                echo $validDateTime . " <br>";
            } else {
                $return = 'no_boost';
            }
        }
        return $return;
    }

    function single_product_image_map($pid = '', $mapImgId = '') {
        if ($pid != '') {
            $this->db->select('pi.*');
            $this->db->from('product_images pi');
            $this->db->where('pi.product_id', $pid);
            if ($mapImgId != '') {
                $this->db->where('pi.id', $mapImgId);
            }
            $query = $this->db->get();
            if ($query->result()) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function single_product_location($pid = '') {
        if ($pid != '') {
            $this->db->select('plm.*, lc.CITY, lc.COUNTRY');
            $this->db->from('products_location_map plm');
            $this->db->join('location_cities lc', 'lc.ID = plm.city_id', 'left');
            $this->db->where('plm.product_id', $pid);
            $this->db->order_by('lc.CITY', 'ASC');

            $query = $this->db->get();
            if ($query->result()) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function single_product_old($pid = '', $where = array()) {
        if ($pid != '') {
            $this->db->select('p.*, ub.company_name AS b2bcompany, pi.image, GROUP_CONCAT(pc.name, ", ") AS category, GROUP_CONCAT(pc.slug, ", ") AS cat_slug, pw.id AS wish_id, sp.id AS stock_id, sp.seller_id AS sellerid, sp.b2b_id AS b2bid, sp.regular_price as seller_regular_price, sp.sale_price AS seller_sale_price, sp.stock AS seller_stock, sp.status AS seller_status, sp.created_date AS seller_created_date, sp.modified_date AS seller_modified_date');
            $this->db->from('seller_stock_product sp');
            $this->db->join('products p', 'p.id = sp.product_id', 'left');
            $this->db->join('product_categories pcs', 'pcs.product_id = sp.product_id', 'left');
            $this->db->join('product_images pi', '(pi.product_id = sp.product_id AND pi.cover = "yes")', 'left');
            $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
            $this->db->join('product_wishlist pw', 'p.id = pw.product_id', 'left');
            $this->db->join('users_business_details ub', 'ub.user_id = sp.b2b_id', 'left');
            $this->db->where('sp.id', $pid);
            $this->db->group_by('p.id');
            $query = $this->db->get();
            if ($query->result()) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getCart($where = array()) {
        $this->db->select('p.id, p.name, p.sale_price, p.stock, pi.image, pc.id AS cid, pc.cart_id, pc.quantity, pc.currency, sp.id AS stockid,sp.sale_price AS stock_price, sp.seller_id AS seller_id, sp.b2b_id AS b2b_id');
        $this->db->from('product_cart pc');
        $this->db->join('seller_stock_product sp', 'sp.id = pc.product_id', 'left');
        $this->db->join('products p', 'p.id = sp.product_id', 'inner');
        $this->db->join('product_images pi', 'pi.product_id = sp.product_id', 'left');
        $this->db->where('pc.status', 1);
        $this->db->where('pi.cover', 'yes');
        if (!empty($where)) {
            foreach ($where as $key => $val) {
                $this->db->where_in($key, $val);
            }
        }
        $query = $this->db->get();
        if ($query->result()) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getCartid($where = array()) {
        $this->db->select('pc.cart_id AS user_cartid');
        $this->db->from('product_cart pc');
        $this->db->where('pc.status', 1);
        if (!empty($where)) {
            foreach ($where as $key => $val) {
                $this->db->where_in($key, $val);
            }
        }
        $query = $this->db->get();
        if ($query->result()) {
            $arr = array_map(function($value) {
                return $value['user_cartid'];
            }, $query->result_array());
            return $arr;
            //return $query->result();    
        } else {
            return false;
        }
    }

    /* Rupam get orders by user */

    function getOrders($uid, $type) {
        $this->db->select('po.*, p.name, p.filename, u.id AS user_id, u.first_name, u.last_name, u.email AS user_email, u2.first_name AS seller_first_name, u2.last_name AS seller_last_name');
        $this->db->from('product_orders po');
        $this->db->join('products p', 'p.id = po.product_id', 'left');
        $this->db->join('users u', 'u.id = po.order_by', 'left');
        $this->db->join('users u2', 'u2.id = po.seller_id', 'left');
        $this->db->order_by('po.modified_date', 'DESC');
       
        $query = $this->db->get();
        //echo $this->db->last_query();
        //exit;
        return $query->result();
    }

    /* Rupam voucher apply */

    function getDiscountData($type, $cart_ids, $code) {
        if ($type == SELLER) {
            $this->db->select('sp.sale_price, sp.product_id, dv.*');
            $this->db->from('product_cart pc');
            $this->db->join('seller_stock_product sp', 'sp.id = pc.product_id', 'inner');
            $this->db->join('seller_discount_voucher dv', 'dv.user_id = sp.seller_id', 'inner');
            $this->db->group_by('sp.product_id');
            $this->db->where('dv.code', $code);
            $this->db->where_in('pc.cart_id', $cart_ids);
            $query = $this->db->get();
            return $query->result();
        }
    }

    /* Rupam product review comments */

    function getReviewComments($pid) {
        $this->db->select('c.*, u.id as uid, u.first_name, u.last_name');
        $this->db->from('product_review_comment c');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('c.product_id', $pid);
        $this->db->order_by('c.created_date', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    /* Business vouchers */

    function getVouchers($where = array()) {
        $this->db->select('sv.*, dv.name, dv.start_date, dv.expiry_date, dv.code, dv.percentage, dv.flat_rate, dv.status as business_status, dv.voucher_price, dv.filename');
        $this->db->from('seller_stock_voucher sv');
        $this->db->join('product_discount_voucher dv', 'dv.id = sv.voucher_id');
        $this->db->where('sv.status', 1);
        $this->db->where('sv.stock_quantity !=', 0);
        $this->db->where('sv.sale_price !=', 0);
        $this->db->order_by('sv.modified_date', 'DESC');
        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }

    function mySubmittedRequest_count($buyerId = 0) {   //=== purchase request for buyer ===========//
        $this->db->select('COUNT(DISTINCT(pr.purchase_request_id)) count');
        $this->db->from('purchase_request pr');
        $this->db->join('products p', 'p.id = pr.product_id');
        $this->db->where('pr.buyer_id', $buyerId);

        $query = $this->db->get();
        return $query->result();
    }

    function mySubmittedRequest($buyerId = 0, $limit = []) {   //=== purchase request for buyer ===========//
        $this->db->select('p.name product_name, pr.*');
        $this->db->select('u.first_name seller_f_name, u.last_name seller_l_name');
        $this->db->from('purchase_request pr');
        $this->db->join('products p', 'p.id = pr.product_id');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->where('pr.buyer_id', $buyerId);
        $this->db->order_by('pr.purchase_request_id', 'DESC');

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function my_favorites($pid = 0, $favoriteUserId = 0) {
        $this->db->select('mf.*'); // my_favorites information for product details
        $this->db->from('my_favorites mf');
        $this->db->where('mf.product_id', $pid);
        $this->db->where('mf.added_by_user_id', $favoriteUserId);

        $query = $this->db->get();
        return $query->result();
    }

    function my_favorites_list_count($userId = 0) {
        $this->db->select('COUNT(DISTINCT(mf.my_favorites_id)) count'); // my_favorites information 
        $this->db->from('my_favorites mf');
        $this->db->where('mf.added_by_user_id', $userId);
        $query = $this->db->get();
        return $query->result();
    }

    function my_favorites_list($userId = 0, $limit = []) {
        $this->db->select('mf.*, p.name product_name, p.regular_price, p.filename'); // my_favorites information 
        $this->db->from('my_favorites mf');
        $this->db->join('products p', 'mf.product_id = p.id', 'left');
        $this->db->where('mf.added_by_user_id', $userId);

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function my_purchase_requests_count($sellerId = 0) {
        $this->db->select('COUNT(DISTINCT(pr.purchase_request_id)) count');
        $this->db->from('purchase_request pr');
        $this->db->join('products p', 'p.id = pr.product_id');
        $this->db->where('p.user_id', $sellerId);
        $this->db->order_by('pr.purchase_request_id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function my_purchase_requests($sellerId = 0, $limit = [], $purchaseId = 0) {
        $this->db->select('p.name product_name, p.regular_price, pr.*');
        $this->db->from('purchase_request pr');
        $this->db->join('products p', 'p.id = pr.product_id');
        $this->db->where('p.user_id', $sellerId);
        if ($purchaseId != 0) {
            $this->db->where('pr.purchase_request_id', $purchaseId);
        }
        $this->db->order_by('pr.purchase_request_id', 'DESC');

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function my_subscription_charges_count($sellerId = 0) {
        $this->db->select('COUNT(DISTINCT(sfb.subscription_for_boost_id)) count');
        $this->db->from('subscription_for_boost sfb');
        $this->db->where('sfb.user_id', $sellerId);
        $query = $this->db->get();
        return $query->row();
    }

    function my_subscription_charges($sellerId = 0, $limit = []) {
        $this->db->select('sfb.*');
        $this->db->from('subscription_for_boost sfb');
        $this->db->where('sfb.user_id', $sellerId);
        $this->db->order_by('sfb.subscription_for_boost_id', 'DESC');

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $query = $this->db->get();
        return $query->result();
    }
	function my_subscription_charges_count_emp($empId = 0)
	{
		$this->db->select('COUNT(DISTINCT(subscription_for_boost_id)) count');
		$this->db->from('job_posting_subscription');
		$this->db->where('job_posting_subscription.user_id', $empId);
		$query = $this->db->get();
		return $query->row();
	}

	function my_subscription_charges_emp($empId = 0, $limit = [])
	{
		$this->db->select('job_posting_subscription.*');
		$this->db->from('job_posting_subscription');
		$this->db->where('job_posting_subscription.user_id', $empId);
		$this->db->order_by('job_posting_subscription.subscription_for_boost_id', 'DESC');

		if (!empty($limit)) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}
		$query = $this->db->get();
		return $query->result();
	}

    function top_subscription() {
        $this->db->select('MAX(month_wise_price) monthly, MAX(week_wise_price) weekly');
        $this->db->from('boost_product_charges bpc');
        $this->db->where('bpc.status', 1);

        $query = $this->db->get();
        return $query->row();
    }

    function single_subscription_charges($rowId = 0) {
        $this->db->select('sfb.*, bp_cat.cat_name');
        $this->db->from('subscription_for_boost sfb');
        $this->db->join('boost_product_charges bpc', 'bpc.boost_id = sfb.subscription_id');
        $this->db->join('boost_product_category bp_cat', 'bp_cat.cat_id = bpc.boost_cat_id');
        $this->db->where('sfb.subscription_for_boost_id', $rowId);
        $this->db->order_by('sfb.subscription_for_boost_id', 'DESC');

        $query = $this->db->get();
        return $query->row();
    }
	function single_subscription_charges_emp($rowId = 0)
	{
		$this->db->select('job_posting_subscription.*, job_posting_subscription.job_category,job_posting_subscription.valid_upto');
		$this->db->from('job_posting_subscription');
		$this->db->join('job_posting_charges', 'job_posting_subscription.subscription_id = job_posting_charges.job_posting_charges_id');
		$this->db->where('job_posting_charges.subscription_for_boost_id', $rowId);
		$this->db->order_by('job_posting_charges.subscription_for_boost_id', 'DESC');
		$query = $this->db->get();
		return $query->row();
	}
    function get_seller_review($pid = 0) {
        $this->db->select('rar.*, u.first_name, u.last_name, u.filename');
        $this->db->from('products p');
        $this->db->join('rating_and_review rar', 'rar.act_id = p.user_id', 'left');
        $this->db->join('users u', 'u.id = rar.user_id', 'left');
        $this->db->where('p.id', $pid);
        $this->db->where('rar.type', 'seller');
        $this->db->where('rar.status', 'A');
        $this->db->order_by('rar.rating_and_review_id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

}
