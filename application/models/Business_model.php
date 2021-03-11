<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Business_model extends CI_model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function getBusiness () {
        $this->db->select('u.id, u.first_name, u.last_name, u.filename, b.company_name, b.company_logo, b.about_company');
        $this->db->from('users u');
        $this->db->join('users_business_details b', 'b.user_id = u.id', 'left');
        $this->db->where('u.type', B2B);
        $this->db->where('u.active', 1);
        $this->db->order_by('b.modified_date', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function getBusinessBySlug ($slug) {
        $this->db->select('u.id, u.first_name, u.last_name, u.filename, b.company_name, b.company_logo, b.about_company');
        $this->db->from('users u');
        $this->db->join('users_business_details b', 'b.user_id = u.id', 'left');
        $this->db->join('products p', 'p.user_id = u.id', 'inner');
        $this->db->join('product_categories pcs', 'pcs.product_id = p.id', 'inner');
        $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'inner');
        $this->db->where('u.type', B2B);
        $this->db->where('u.active', 1);
        $this->db->where('p.status', 1);
        $this->db->where('pc.status', 1);
        $this->db->where('pc.slug', $slug);
        $this->db->order_by('p.modified_date', 'DESC');
        $this->db->group_by('u.id');
        $query = $this->db->get();
        return $query->result();
    }

    function getVoucherOrders ($user_id) {
        $this->db->select('u.id AS user_id, u.first_name, u.last_name, u.email, dv.name AS voucher_name, dv.code, dv.voucher_status, dv.start_date, dv.expiry_date, ov.*');
        $this->db->from('seller_order_voucher ov');
        $this->db->join('product_discount_voucher dv', 'dv.id = ov.voucher_id');
        $this->db->join('users u', 'u.id = ov.seller_id');
        $this->db->where('ov.b2b_id', $user_id);
        $this->db->where('u.type', SELLER);
        $this->db->where('u.active', 1);
        $this->db->order_by('ov.created_date', 'DESC');
        $this->db->group_by('dv.id');
        $query = $this->db->get();
        return $query->result();
    }
}
