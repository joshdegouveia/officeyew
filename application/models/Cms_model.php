<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getNotificationListAdmin($where = []) {
        $this->db->select('n.*, u_for.first_name for_f_name, u_for.last_name for_l_name, u_by.first_name by_f_name, u_by.last_name by_l_name')
                ->from('notification n')
                ->join("users u_for", "n.notification_for_user = u_for.id", 'left')
                ->join("users u_by", "n.notification_by_user = u_by.id", 'left');
        foreach ($where as $k => $cond) {
            $this->db->where("$k", $cond);
        }
        $this->db->order_by("notification_id", "DESC");
        $la_notification = $this->db->get()->result();
        return $la_notification;
    }

    public function get_seller_review() {
        $this->db->select('rar.*, u_buyer.first_name buyer_f_name, u_buyer.last_name buyer_l_name, u_seller.first_name seller_f_name, u_seller.last_name seller_l_name')
                ->from('rating_and_review rar')
                ->join("users u_buyer", "rar.user_id = u_buyer.id", 'left')
                ->join("users u_seller", "rar.act_id = u_seller.id", 'left');

        $this->db->where("rar.type", 'seller');
        $this->db->order_by("rar.rating_and_review_id", "DESC");
        $la_notification = $this->db->get()->result();
        return $la_notification;
    }

    public function getCityData() {
        $this->db->select('lc.*')
                ->from('location_cities lc');
        $this->db->order_by("lc.CITY", "ASC");
        $la_data = $this->db->get()->result();
        return $la_data;
    }

    public function get_subscription_and_charges() {
        $this->db->select('bpc.*, pc.cat_name')
                ->from('boost_product_charges bpc')
                ->join("boost_product_category pc", "pc.cat_id = bpc.boost_cat_id", 'left');
//        $this->db->where("bpc.product_posting_type = 'individual' AND bpc.no_of_product != 0");
        $this->db->where("bpc.status", "1");
        $this->db->where("pc.status", "Y");
        $this->db->order_by("bpc.boost_cat_id", "ASC");
        $this->db->order_by("bpc.month_wise_price", "DESC");
        $la_data = $this->db->get()->result();
        return $la_data;
    }

    public function get_subscription_for_job_posting() { // frontend
        $this->db->select('jpc.*')
                ->from('job_posting_charges jpc');
        $this->db->where("jpc.status", "A");
        $la_data = $this->db->get()->result();
        $returnData = [];
        foreach ($la_data as $data){
            $returnData[$data->job_category][] = $data;
        }
//        print_r($returnData);die;
        return $returnData;
    }

    public function job_posting_charge_list() { // backend
        $this->db->select('jpc.*')->from('job_posting_charges jpc');
        $this->db->order_by("jpc.job_posting_charges_id", "DESC");
        $la_data = $this->db->get()->result();
         
        return $la_data;
    }

}
