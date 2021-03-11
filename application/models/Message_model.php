<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function my_message_list_count($useId = 0) {
        $ls_sql = "SELECT COUNT(DISTINCT(mc.mc_id)) count "
                . "FROM message_chatting mc "
                . "LEFT JOIN users u_to ON u_to.id = mc.send_to "
                . "LEFT JOIN users u_from ON u_from.id = mc.send_from "
                . "LEFT JOIN products p ON p.id = mc.product_id "
                . "WHERE (mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_to = $useId AND mc1.product_id != 0 GROUP BY mc1.send_to, mc1.send_from, mc1.product_id) OR "
                . "       mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_from = $useId AND mc1.product_id != 0 GROUP BY mc1.send_from, mc1.send_to, mc1.product_id)) "
                . "  OR  (mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_to = $useId AND mc1.purchase_id != 0 GROUP BY mc1.send_to, mc1.send_from, mc1.purchase_id) OR "
                . "       mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_from = $useId AND mc1.purchase_id != 0 GROUP BY mc1.send_from, mc1.send_to, mc1.purchase_id)) "
					."   OR  (mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_to = $useId GROUP BY mc1.send_to, mc1.send_from) OR "
                . "       mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_from = $useId  GROUP BY mc1.send_from, mc1.send_to)) ";
//                . "GROUP BY mc.send_to, mc.send_from, mc.product_id ";

        $la_message = $this->db->query($ls_sql)->result();
//        print_r($la_message);die;
        return $la_message;
    }

    public function my_message_list($useId = 0, $limit = [], $userName = '') {
        $wherUserName = ($userName == '') ? "" : " AND (u_to.first_name LIKE '%$userName%' OR u_from.first_name LIKE '%$userName%')";
        $ls_sql = "SELECT mc.*,u_to.first_name to_f_name, CONCAT(u_to.first_name, ' ', u_to.last_name) to_username, u_to.filename to_filename, "
                . "u_from.first_name from_f_name, CONCAT(u_from.first_name, ' ', u_from.last_name) from_username, u_from.filename from_filename, p.name product_name "
                . "FROM message_chatting mc "
                . "LEFT JOIN users u_to ON u_to.id = mc.send_to "
                . "LEFT JOIN users u_from ON u_from.id = mc.send_from "
                . "LEFT JOIN products p ON p.id = mc.product_id "
                . "WHERE (mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_to = $useId AND mc1.product_id != 0 GROUP BY mc1.send_to, mc1.send_from, mc1.product_id) OR "
                . "       mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_from = $useId AND mc1.product_id != 0 GROUP BY mc1.send_from, mc1.send_to, mc1.product_id)) "
                . "  OR  (mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_to = $useId AND mc1.purchase_id != 0 GROUP BY mc1.send_to, mc1.send_from, mc1.purchase_id) OR "
                . "       mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_from = $useId AND mc1.purchase_id != 0 GROUP BY mc1.send_from, mc1.send_to, mc1.purchase_id)) "
				."   OR  (mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_to = $useId GROUP BY mc1.send_to, mc1.send_from) OR "
                . "       mc.mc_id IN (SELECT MAX(mc1.mc_id) FROM message_chatting mc1 WHERE mc1.send_from = $useId  GROUP BY mc1.send_from, mc1.send_to)) "
                . " $wherUserName GROUP BY mc.send_to, mc.send_from, mc.product_id "
                . "ORDER BY mc.mc_id DESC ";
        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
            $ls_sql .= " LIMIT " . $limit['offset'] . ", " . $limit['limit'] . " ";
        }

        $la_message = $this->db->query($ls_sql)->result();
//        echo $this->db->last_query() ;exit ;
//        print_r($la_message);die;
        return $la_message;
    }

    public function get_message_chat_data($send_from, $send_to, $flagId, $flag = '') {
        if ($flag == 'pro') {
            $flagCondition = " AND mc.product_id = $flagId ";
        } else {
            $flagCondition = " AND mc.purchase_id = $flagId ";
        }
        $ls_sql = "SELECT mc.*,u_to.first_name to_f_name, CONCAT(u_to.first_name, ' ', u_to.last_name) to_username,  "
                . "u_from.first_name from_f_name, CONCAT(u_from.first_name, ' ', u_from.last_name) from_username "
                . "FROM message_chatting mc "
                . "LEFT JOIN users u_to ON u_to.id = mc.send_to "
                . "LEFT JOIN users u_from ON u_from.id = mc.send_from "
                . "WHERE ((mc.send_to = $send_to AND mc.send_from = $send_from) OR (mc.send_to = $send_from AND mc.send_from = $send_to)) $flagCondition "
                . "AND mc.status = 'A'"
                . "ORDER BY mc.mc_id ASC";

        $la_message = $this->db->query($ls_sql)->result();
//        print_r($la_message);
//        die;
        return $la_message;
    }



}
