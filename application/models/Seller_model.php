<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Seller_model extends CI_model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function check_store_name($name)
    {
        $name = trim($name);   
        if($name !='')
        {
            $this->db->select('name');
            $this->db->from('store');
            $this->db->where('name',$name);
            $query = $this->db->get();
            return $query->result();
        }
        else{
            return false;
        }
    }

    function user_have_store($u_id)
    { 
        if($u_id !='')
        {
            $this->db->from('store');
            $this->db->where('useer_id',$u_id);
            $count = $this->db->count_all_results();
            return $count;
        }
        else{
            return false;
        }
    }

    function insert($data)
    {
        $this->db->insert('store', $data);
        return $this->db->insert_id();
    }

    function getVouchers ($action, $where = array()) {
        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }

        if ($action == 'reseller_voucher_list') {
            $this->db->select('sv.*, dv.name, dv.start_date, dv.expiry_date, dv.code, dv.percentage, dv.flat_rate, dv.status as business_status, dv.voucher_price, dv.filename');
            $this->db->from('seller_stock_voucher sv');
            $this->db->join('product_discount_voucher dv', 'dv.id = sv.voucher_id');
            $this->db->order_by('sv.modified_date', 'DESC');
            $query = $this->db->get();
            return $query->result();
        }
    }
    
}