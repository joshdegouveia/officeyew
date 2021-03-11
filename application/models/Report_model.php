<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Report_model extends CI_model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function getAverageSale ($uid, $type) {
        if ($type == SELLER) {
            $this->db->select('u.id AS user_id, u.first_name, u.last_name, u.email AS user_email, p.name, po.*, ');
            $this->db->from('product_orders po');
            $this->db->join('users u', 'u.id = po.order_by', 'left');
            $this->db->join('products p', 'p.id = po.product_id', 'left');
            $this->db->where('po.seller_id', $uid);
            $this->db->order_by('po.modified_date', 'DESC');
            $this->db->limit(10, 0);
            $query = $this->db->get();
            return $query->result();
        } else if ($type == B2B) {
            $this->db->select('u.id AS user_id, u.first_name, u.last_name, u.email AS user_email, p.name, po.product_price, po.sale_price, COUNT(po.product_id) AS total_unit, SUM(po.sale_price) AS total_price, po.created_date');
            $this->db->from('product_orders po');
            $this->db->join('users u', 'u.id = po.seller_id', 'left');
            $this->db->join('products p', 'p.id = po.product_id', 'left');
            $this->db->where('p.user_id', $uid);
            $this->db->order_by('total_unit', 'DESC');
            $this->db->group_by(array('product_id', 'seller_id'));
            $this->db->limit(10, 0);
            $query = $this->db->get();
            return $query->result();
        }
    }

    function trendingReport ($uid) {
        $this->db->select('p.name, COUNT(po.product_id) AS total_unit, SUM(po.sale_price) AS total_price');
        $this->db->from('product_orders po');
        $this->db->join('products p', 'p.id = po.product_id', 'left');
        $this->db->where('po.seller_id', $uid);
        $this->db->order_by('total_unit', 'DESC');
        $this->db->group_by(array('seller_id', 'product_id'));
        $this->db->limit(10, 0);
        $query = $this->db->get();
        return $query->result();
    }

    function topReseller ($uid) {
        $this->db->select('u.id AS user_id, u.first_name, u.last_name, u.email AS user_email, p.name, po.product_price, po.sale_price, COUNT(po.product_id) AS total_unit, SUM(po.sale_price) AS total_price, po.created_date');
        $this->db->from('product_orders po');
        $this->db->join('users u', 'u.id = po.seller_id', 'left');
        $this->db->join('products p', 'p.id = po.product_id', 'left');
        $this->db->where('p.user_id', $uid);
        $this->db->order_by('total_unit', 'DESC');
        $this->db->group_by(array('product_id', 'seller_id'));
        $this->db->limit(10, 0);
        $query = $this->db->get();
        return $query->result();
    }

    function customReport ($uid, $type) {
        if ($type == SELLER) {
            $this->db->select('u.id AS user_id, u.first_name, u.last_name, u.email AS user_email, p.name, po.*, COUNT(po.product_id) AS total_unit, SUM(po.sale_price) AS total_price');
            $this->db->from('product_orders po');
            $this->db->join('products p', 'p.id = po.product_id', 'left');
            $this->db->join('users u', 'u.id = po.order_by', 'left');
            $this->db->where('po.seller_id', $uid);
            $this->db->order_by('total_unit', 'DESC');
            $this->db->group_by(array('seller_id', 'product_id'));
            $this->db->limit(10, 0);
            $query = $this->db->get();
            return $query->result();
        } else if ($type == B2B) {
            $this->db->select('u.id AS user_id, u.first_name, u.last_name, u.email AS user_email, p.name, po.*, COUNT(po.product_id) AS total_unit, SUM(po.sale_price) AS total_price, po.created_date');
            $this->db->from('product_orders po');
            $this->db->join('users u', 'u.id = po.seller_id', 'left');
            $this->db->join('products p', 'p.id = po.product_id', 'left');
            $this->db->where('p.user_id', $uid);
            $this->db->order_by('total_unit', 'DESC');
            $this->db->group_by(array('product_id', 'seller_id'));
            $this->db->limit(10, 0);
            $query = $this->db->get();
            return $query->result();
        }
    }

    function customGraph ($uid, $type, $graph_arr) {
        // if ($type == SELLER) {
        if ($graph_arr->field == 'total_product') {
            $this->db->select('date_format(from_unixtime(po.modified_date),"%Y-%m-%d") AS modified_date, SUM(po.quantity) AS total_unit');
        } else if ($graph_arr->field == 'total_sale') {
            $this->db->select('date_format(from_unixtime(po.modified_date),"%Y-%m-%d") AS modified_date, SUM(po.sale_price) AS total_unit');
        } else if ($graph_arr->field == 'total_customer') {
            $this->db->select('date_format(from_unixtime(po.modified_date),"%Y-%m-%d") AS modified_date, COUNT(po.order_by) AS total_unit');
        } else if ($graph_arr->field == 'total_reseller') {
            $this->db->select('date_format(from_unixtime(po.modified_date),"%Y-%m-%d") AS modified_date, COUNT(po.order_by) AS total_unit');
        }

        if ($graph_arr->type == 'by_year') {
            $cur_date_in = strtotime(date('Y') . '-01-01');
            $cur_date_end = strtotime(date('Y') . '-12-31');
            $this->db->where('po.modified_date BETWEEN ' . $cur_date_in . ' AND ' . $cur_date_end);
        } else if ($graph_arr->type == 'by_month') {
            $cur_date_in = strtotime(date('Y') . '-' . date('m') . '-01');
            $cur_date_end = strtotime(date('Y') . '-' . date('m') . '-31');
            $this->db->where('po.modified_date BETWEEN ' . $cur_date_in . ' AND ' . $cur_date_end);
        } else if ($graph_arr->type == 'by_week') {
            $ts = strtotime(date('Y-m-d'));
            $cur_date_in = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
            $cur_date_end = strtotime('next saturday', $cur_date_in);
            $this->db->where('po.modified_date BETWEEN ' . $cur_date_in . ' AND ' . $cur_date_end);
        } else if ($graph_arr->type == 'by_day') {
            $cur_date_in = strtotime(date("Y-m-d 00:00:01"));
            $cur_date_end = strtotime(date("Y-m-d 23:59:59"));
            $this->db->where('po.modified_date BETWEEN ' . $cur_date_in . ' AND ' . $cur_date_end);
        } else if ($graph_arr->type == 'custom') {
            $cur_date_in = strtotime($graph_arr->from_date);
            $cur_date_end = strtotime($graph_arr->to_date);
            $this->db->where('po.modified_date BETWEEN ' . $cur_date_in . ' AND ' . $cur_date_end);
        }

        $this->db->from('product_orders po');
        $this->db->join('products p', 'p.id = po.product_id', 'left');
        
        if ($type == SELLER) {
            $this->db->join('users u', 'u.id = po.order_by', 'left');
            $this->db->where('po.seller_id', $uid);
        } else if ($type == B2B) {
            $this->db->join('users u', 'u.id = po.seller_id', 'left');
            $this->db->where('p.user_id', $uid);
        }

        $this->db->order_by('po.modified_date', 'ASC');
        // $this->db->group_by(array('product_id', 'seller_id'));
        $this->db->group_by('modified_date');
        $this->db->limit(10, 0);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
        // }
    }

    function getVoucherOrders ($type, $uid) {
        if ($type == SELLER) {
            $this->db->select('ov.*, dv.name');
            $this->db->from('customer_order_vouchers ov');
            $this->db->join('product_discount_voucher dv', 'dv.id = ov.voucher_id');
            $this->db->where('ov.seller_id', $uid);
            $query = $this->db->get();
            return $query->result();
        }
    }

    function getProductOrders ($type, $uid) {
        if ($type == SELLER) {
            $this->db->select('po.*, p.name, u.first_name, u.last_name, u.email AS user_email');
            $this->db->from('product_orders po');
            $this->db->join('products p', 'p.id = po.product_id');
            $this->db->join('users u', 'u.id = po.order_by', 'left');
            $this->db->where('po.seller_id', $uid);
            $query = $this->db->get();
            return $query->result();
        }
    }

}
