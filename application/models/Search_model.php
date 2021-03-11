<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search_model extends CI_model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function productsByTerm ($term, $current_country = '') {
        // $this->db->select('p.name, p.short_description, p.regular_price AS breg_price, p.sale_price AS bsal_price, sp.product_id, sp.regular_price, sp.sale_price, pc.name AS category_name, pc.slug');
        $this->db->select('p.name, sp.id , sp.product_id, pc.name AS category_name, pc.slug');
        $this->db->from('seller_stock_product sp');
        $this->db->join('products p', 'p.id = sp.product_id', 'inner');
        $this->db->join('product_categories pcs', 'pcs.product_id = sp.product_id', 'left');
        $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
        $this->db->join('users u', 'u.id = sp.seller_id');
        if (!empty($current_country)) {
            $this->db->where('u.country', $current_country);
        }
        $this->db->where('p.stock', 'yes');
        $this->db->where('p.status', 1);
        $this->db->where('sp.stock', 'yes');
        $this->db->where('sp.status', 1);
        $this->db->where('(p.name LIKE "%' . $term . '%" OR p.tags LIKE "%' . $term . '%" OR pc.name LIKE "%' . $term . '%")');
        // $this->db->like('p.name', $term, 'both');
        // $this->db->or_like('p.tags', $term . ',', 'both');
        // $this->db->or_like('pc.name', $term, 'both');

        $query = $this->db->get();
        return $query->result();
    }

    function getSearchProducts ($k, $country, $state, $city, $current_country = '') {
        $this->db->select('p.name, p.short_description, p.regular_price AS breg_price, p.sale_price AS bsal_price, sp.id, sp.product_id, sp.regular_price, sp.sale_price, pi.image');
        $this->db->from('seller_stock_product sp');
        $this->db->join('products p', 'p.id = sp.product_id', 'inner');
        $this->db->join('product_categories pcs', 'pcs.product_id = sp.product_id', 'left');
        $this->db->join('product_category pc', 'pc.id = pcs.category_id', 'left');
        $this->db->join('product_images pi', '(pi.product_id = sp.product_id AND pi.cover = "yes")', 'left');
        $this->db->join('users u', 'u.id = sp.seller_id', 'inner');
        $this->db->where('p.stock', 'yes');
        $this->db->where('p.status', 1);
        $this->db->where('sp.stock', 'yes');
        $this->db->where('sp.status', 1);
        $this->db->where('(p.name LIKE "%' . $k . '%" OR p.tags LIKE "%' . $k . ',%" OR pc.name LIKE "%' . $k . '%")');
        // $this->db->like('p.name', $k, 'both');
        // $this->db->or_like('p.tags', $k . ',', 'both');
        // $this->db->or_like('pc.name', $k, 'both');
        if (!empty($country)) {
            $this->db->where('u.country', $country);
        }
        if (!empty($state)) {
            $this->db->where('u.state', $state);
        }
        if (!empty($city)) {
            $this->db->where('u.city', $city);
        }
        if (!empty($current_country)) {
            $this->db->where('u.country', $current_country);
        }
        $query = $this->db->get();
        // pre($this->db->last_query(), 1);
        return $query->result();
    }
    
}